<?php

namespace Tests\Feature;

use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Concerns\ActsAsAdmin;
use Tests\Feature\Concerns\CreatesProducts;
use Tests\TestCase;

class AdminProductTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;
    use CreatesProducts;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();
        Storage::fake('public');
    }

    protected function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name'           => 'New Gadget',
            'category_id'    => $this->makeCategory()->id,
            'type'           => 'physical',
            'sku'            => 'SKU-NEW-' . uniqid(),
            'purchase_price' => 500,
            'selling_price'  => 1000,
        ], $overrides);
    }

    public function test_admin_can_create_a_physical_product_with_thumbnail_and_variants(): void
    {
        $response = $this->post('/admin/products', $this->validPayload([
            'thumbnail' => UploadedFile::fake()->image('thumb.jpg', 400, 400),
            'variants'  => [
                ['color' => 'Red', 'size' => 'M', 'price' => 1000, 'stock' => 5],
            ],
        ]));

        $response->assertRedirect(route('admin.products.index'));

        $product = \App\Models\Product::where('name', 'New Gadget')->first();
        $this->assertNotNull($product);
        // New physical products always start at 0 stock (GRN-controlled).
        $this->assertSame(0.0, (float) $product->stock);
        $this->assertNotNull($product->thumbnail);
        Storage::disk('public')->assertExists($product->thumbnail);

        $variant = $product->variants()->first();
        $this->assertSame('Red', $variant->color);
        $this->assertSame('M', $variant->size);
    }

    public function test_product_defaults_to_draft_when_no_publish_status_given(): void
    {
        $this->post('/admin/products', $this->validPayload())->assertRedirect();

        $product = \App\Models\Product::where('name', 'New Gadget')->first();
        $this->assertSame('draft', $product->publish_status);
    }

    public function test_sku_must_be_unique(): void
    {
        $existing = $this->makeProduct(['sku' => 'DUP-SKU']);

        $response = $this->from('/admin/products/create')->post('/admin/products', $this->validPayload(['sku' => 'DUP-SKU']));

        $response->assertSessionHasErrors('sku');
    }

    public function test_admin_can_update_a_product(): void
    {
        $product = $this->makeProduct(['name' => 'Old Name', 'stock' => 10]);

        $response = $this->put('/admin/products/' . $product->id, $this->validPayload([
            'name'        => 'Updated Name',
            'category_id' => $product->category_id,
            'sku'         => $product->sku,
        ]));

        $response->assertRedirect(route('admin.products.index'));
        $this->assertSame('Updated Name', $product->fresh()->name);
    }

    public function test_update_rejects_variant_stock_exceeding_available_product_stock(): void
    {
        $product = $this->makeProduct(['stock' => 5]);

        $response = $this->from('/admin/products/' . $product->id . '/edit')->put('/admin/products/' . $product->id, $this->validPayload([
            'category_id' => $product->category_id,
            'sku'         => $product->sku,
            'variants'    => [
                ['color' => 'Red', 'size' => 'M', 'stock' => 10],
            ],
        ]));

        $response->assertSessionHasErrors('variants');
    }

    public function test_admin_can_delete_a_product_and_its_variants(): void
    {
        $product = $this->makeProduct();
        $variant = $this->makeVariant($product);

        $this->delete('/admin/products/' . $product->id)->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
        $this->assertDatabaseMissing('product_variants', ['id' => $variant->id]);
    }

    public function test_admin_can_set_product_status(): void
    {
        $product = $this->makeProduct(['publish_status' => 'draft']);

        $this->post('/admin/products/' . $product->id . '/set-status', ['publish_status' => 'published'])
            ->assertRedirect();

        $this->assertSame('published', $product->fresh()->publish_status);
    }

    public function test_admin_can_bulk_update_product_status(): void
    {
        $a = $this->makeProduct(['publish_status' => 'draft']);
        $b = $this->makeProduct(['publish_status' => 'draft']);

        $this->post('/admin/products/bulk-action', [
            'action' => 'published',
            'ids'    => [$a->id, $b->id],
        ])->assertRedirect();

        $this->assertSame('published', $a->fresh()->publish_status);
        $this->assertSame('published', $b->fresh()->publish_status);
    }

    public function test_admin_can_bulk_delete_products(): void
    {
        $a = $this->makeProduct();
        $b = $this->makeProduct();

        $this->post('/admin/products/bulk-action', [
            'action' => 'delete',
            'ids'    => [$a->id, $b->id],
        ])->assertRedirect();

        $this->assertDatabaseMissing('products', ['id' => $a->id]);
        $this->assertDatabaseMissing('products', ['id' => $b->id]);
    }
}
