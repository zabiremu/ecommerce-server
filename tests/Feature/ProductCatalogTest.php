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

    public function test_product_quick_view_returns_pricing_and_stock_status(): void
    {
        $product = $this->makeProduct(['selling_price' => 1000, 'sale_price' => 800, 'stock' => 5]);

        $response = $this->getJson('/product-quick-view/' . $product->id);

        $response->assertOk()->assertJson([
            'name'  => $product->name,
            'price' => ['current' => 800.0, 'old' => 1000.0, 'hasSale' => true],
        ]);
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
