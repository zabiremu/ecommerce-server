<?php

namespace Tests\Feature\Concerns;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;

trait CreatesProducts
{
    protected function makeCategory(array $overrides = []): Category
    {
        return Category::create(array_merge([
            'name' => 'Test Category',
            'slug' => 'test-category-' . uniqid(),
            'status' => true,
        ], $overrides));
    }

    protected function makeProduct(array $overrides = []): Product
    {
        return Product::create(array_merge([
            'name'           => 'Test Product',
            'slug'           => 'test-product-' . uniqid(),
            'category_id'    => $this->makeCategory()->id,
            'type'           => 'physical',
            'sku'            => 'SKU-' . uniqid(),
            'purchase_price' => 500,
            'selling_price'  => 1000,
            'stock'          => 20,
            'publish_status' => 'published',
        ], $overrides));
    }

    protected function makeVariant(Product $product, array $overrides = []): ProductVariant
    {
        return ProductVariant::create(array_merge([
            'product_id' => $product->id,
            'color'      => 'Red',
            'size'       => 'M',
            'price'      => 1000,
            'stock'      => 10,
            'sku'        => 'SKU-VAR-' . uniqid(),
        ], $overrides));
    }
}
