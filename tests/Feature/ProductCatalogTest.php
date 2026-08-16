<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\SearchLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\CreatesProducts;
use Tests\TestCase;

class ProductCatalogTest extends TestCase
{
    use RefreshDatabase;
    use CreatesProducts;

    public function test_product_details_page_shows_variant_colors_and_sizes(): void
    {
        $product = $this->makeProduct(['selling_price' => 1000]);
        $this->makeVariant($product, ['color' => 'Red', 'size' => 'M']);
        $this->makeVariant($product, ['color' => 'Blue', 'size' => 'L']);

        $response = $this->get('/product-details?slug=' . $product->slug);

        $response->assertOk();
        $response->assertViewHas('colors', function ($colors) {
            return $colors->contains('Red') && $colors->contains('Blue');
        });
        $response->assertViewHas('sizes', function ($sizes) {
            return $sizes->contains('M') && $sizes->contains('L');
        });
    }

    public function test_product_details_page_flags_out_of_stock_and_low_stock(): void
    {
        $outOfStock = $this->makeProduct(['stock' => 0]);
        $response = $this->get('/product-details?slug=' . $outOfStock->slug);
        $response->assertOk()->assertViewHas('outOfStock', true);

        $lowStock = $this->makeProduct(['stock' => 2, 'alert_quantity' => 5]);
        $response = $this->get('/product-details?slug=' . $lowStock->slug);
        $response->assertOk()->assertViewHas('lowStock', true)->assertViewHas('outOfStock', false);
    }

    public function test_product_details_returns_404_for_unpublished_product(): void
    {
        $product = $this->makeProduct(['publish_status' => 'draft']);

        $this->get('/product-details?slug=' . $product->slug)->assertNotFound();
    }

    public function test_all_products_page_only_lists_published_products(): void
    {
        $published = $this->makeProduct(['name' => 'Published Item']);
        $draft = $this->makeProduct(['name' => 'Draft Item', 'publish_status' => 'draft']);

        $response = $this->get('/all-products');

        $response->assertOk();
        $response->assertViewHas('products', function ($products) use ($published, $draft) {
            $ids = $products->pluck('id');
            return $ids->contains($published->id) && !$ids->contains($draft->id);
        });
    }

    public function test_category_products_page_lists_active_categories(): void
    {
        $active = $this->makeCategory(['name' => 'Electronics', 'status' => true]);
        $inactive = $this->makeCategory(['name' => 'Hidden', 'status' => false]);

        $response = $this->get('/category-products');

        $response->assertOk();
        $response->assertViewHas('categories', function ($categories) {
            $names = $categories->pluck('name');
            return $names->contains('Electronics') && !$names->contains('Hidden');
        });
    }

    /**
     * Both listing pages filter entirely client-side against a window.NF_PRODUCTS
     * JSON blob embedded in the response — assertViewHas() only proves the
     * server-side view-data is correct, not what the browser actually renders.
     * These tests decode that embedded JSON to catch the class of bug where the
     * page returns 200 with correct view-data but ships an empty/broken payload.
     */
    private function extractNfProducts(string $html): array
    {
        $this->assertMatchesRegularExpression('/window\.NF_PRODUCTS\s*=\s*(\[.*?\]);/s', $html);
        preg_match('/window\.NF_PRODUCTS\s*=\s*(\[.*?\]);/s', $html, $m);
        $decoded = json_decode($m[1], true);
        $this->assertIsArray($decoded, 'window.NF_PRODUCTS did not decode as valid JSON');

        return $decoded;
    }

    public function test_all_products_page_embeds_the_full_published_catalog_as_json(): void
    {
        $published = $this->makeProduct(['name' => 'Published Item']);
        $draft = $this->makeProduct(['name' => 'Draft Item', 'publish_status' => 'draft']);

        $response = $this->get('/all-products');
        $response->assertOk();

        $products = $this->extractNfProducts($response->getContent());
        $ids = array_column($products, 'id');

        $this->assertSame(\App\Models\Product::published()->count(), count($products));
        $this->assertContains($published->id, $ids);
        $this->assertNotContains($draft->id, $ids);
    }

    public function test_category_products_page_embeds_matching_products_for_both_cat_and_slug_params(): void
    {
        $categorySlug = 'catalog-test-tshirts-' . uniqid();
        $tshirts = $this->makeCategory(['name' => 'T-Shirt', 'slug' => $categorySlug]);
        $shoes = $this->makeCategory(['name' => 'Shoes']);
        $shirt1 = $this->makeProduct(['name' => 'Red Tee', 'category_id' => $tshirts->id]);
        $shirt2 = $this->makeProduct(['name' => 'Blue Tee', 'category_id' => $tshirts->id]);
        $shoe = $this->makeProduct(['name' => 'Running Shoe', 'category_id' => $shoes->id]);

        foreach (['cat', 'slug'] as $param) {
            $response = $this->get('/category-products?' . $param . '=' . $categorySlug);
            $response->assertOk();

            $products = $this->extractNfProducts($response->getContent());
            $this->assertNotEmpty($products, "NF_PRODUCTS was empty for ?{$param}={$categorySlug}");

            // Filtering itself happens client-side, so the endpoint must at
            // least ship every product needed to satisfy this filter.
            $ids = array_column($products, 'id');
            $this->assertContains($shirt1->id, $ids);
            $this->assertContains($shirt2->id, $ids);
        }
    }

    public function test_all_products_page_survives_a_product_with_unusual_characters_in_its_name(): void
    {
        $this->makeProduct(['name' => 'Emoji Tee 🔥 </script> "quoted" & <b>bold</b>']);

        $response = $this->get('/all-products');
        $response->assertOk();

        $products = $this->extractNfProducts($response->getContent());
        $this->assertNotEmpty($products);
    }

    /**
     * Header nav, mega-menu, mobile nav, homepage category tiles, and the
     * product-details breadcrumb all link to /category-products — they must
     * all use the same query param (`cat`), or a visitor arriving via one
     * link surface sees an empty listing while another works. Rendering
     * /all-products exercises the shared header/nav partial the same way
     * every other page does.
     */
    public function test_header_navigation_links_to_categories_using_the_cat_param_consistently(): void
    {
        $category = $this->makeCategory(['name' => 'Nav Test Category', 'status' => true]);
        $this->makeProduct(['category_id' => $category->id]);

        $response = $this->get('/all-products');
        $response->assertOk();

        $html = $response->getContent();
        $this->assertStringContainsString('category-products?cat=' . $category->slug, $html);
        $this->assertStringNotContainsString('category-products?slug=', $html);
    }

    public function test_product_quick_view_returns_pricing_and_stock_status(): void
    {
        $product = $this->makeProduct(['selling_price' => 1000, 'sale_price' => 800, 'stock' => 5]);

        $response = $this->getJson('/product-quick-view/' . $product->id);

        $response->assertOk()->assertJson([
            'name'  => $product->name,
            'price' => ['current' => 800.0, 'old' => 1000.0, 'hasSale' => true],
        ]);
    }

    /**
     * The quick-view modal's "View Full Details" link is wired up purely
     * client-side, by setting its href to this endpoint's `url` field once
     * the AJAX response comes back — if that field is ever missing or
     * malformed, the link silently stays at its static href="#" and clicking
     * it does nothing. This locks down that the endpoint always returns a
     * real, well-formed product-details url.
     */
    public function test_product_quick_view_returns_a_working_product_details_url(): void
    {
        $product = $this->makeProduct();

        $response = $this->getJson('/product-quick-view/' . $product->id);
        $response->assertOk();

        $url = $response->json('url');
        $this->assertIsString($url);
        $this->assertNotSame('', $url);
        $this->assertStringContainsString('product-details', $url);
        $this->assertStringContainsString('slug=' . $product->slug, $url);
    }

    /**
     * The quick-view modal's <img> is populated client-side (its `src` is
     * set once the AJAX response comes back), but the static markup itself
     * had no `src` attribute at all — a real <img> with no src, present on
     * every page since the modal lives in the shared layout. This locks
     * down that it always ships with at least a placeholder src, so the
     * element is never genuinely broken/empty before JS runs.
     */
    public function test_quick_view_image_placeholder_always_has_a_src_attribute(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        preg_match('/<img([^>]*)id="gms-quick-view-img"([^>]*)>/', $html, $m);
        $this->assertNotEmpty($m, 'Could not find the quick-view image markup');

        $tag = $m[0];
        $this->assertStringContainsString('src="', $tag, 'Quick-view <img> has no src attribute');
    }

    public function test_search_suggestions_matches_by_name_and_logs_the_term(): void
    {
        $this->makeProduct(['name' => 'Wireless Mouse']);
        $this->makeProduct(['name' => 'Mechanical Keyboard']);

        $response = $this->getJson('/search/suggestions?q=mouse');

        $response->assertOk()->assertJson(['success' => true, 'popular' => false]);
        $response->assertJsonFragment(['title' => 'Wireless Mouse']);
        $this->assertSame(1, SearchLog::where('term', 'mouse')->count());
    }

    public function test_search_suggestions_returns_popular_terms_when_query_is_empty(): void
    {
        SearchLog::create(['term' => 'phone']);
        SearchLog::create(['term' => 'phone']);
        SearchLog::create(['term' => 'laptop']);
        $this->makeProduct();

        $response = $this->getJson('/search/suggestions');

        $response->assertOk()->assertJson(['success' => true, 'popular' => true]);
        $response->assertJsonFragment(['popularTerms' => ['phone', 'laptop']]);
    }
}
