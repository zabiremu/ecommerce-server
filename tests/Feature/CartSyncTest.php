<?php

namespace Tests\Feature;

use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\CreatesProducts;
use Tests\TestCase;

class CartSyncTest extends TestCase
{
    use RefreshDatabase;
    use CreatesProducts;

    public function test_cart_sync_stores_selected_variant_size_and_color(): void
    {
        $product = $this->makeProduct(['selling_price' => 500]);
        $variant = $this->makeVariant($product, ['color' => 'Black', 'size' => 'XL', 'price' => 650]);

        $response = $this->postJson('/cart/sync', [
            'items' => [
                ['id' => $product->id, 'qty' => 3, 'variant_id' => $variant->id],
            ],
        ]);

        $response->assertOk()->assertJson(['ok' => true]);

        $cart = Cart::first();
        $this->assertNotNull($cart);
        $item = $cart->items()->first();

        $this->assertSame($variant->id, $item->variant_id);
        $this->assertSame('Black / XL', $item->variant_label);
        $this->assertSame(650.0, (float) $item->unit_price);
        $this->assertSame(1950.0, (float) $item->total);
    }

    public function test_cart_sync_replaces_previous_items_on_resync(): void
    {
        $product = $this->makeProduct();

        $this->postJson('/cart/sync', [
            'items' => [['id' => $product->id, 'qty' => 1]],
        ])->assertOk();

        $cart = Cart::first();
        $this->assertSame(1, $cart->items()->count());

        // Re-send the sync for the SAME browser session (cookie carried over
        // explicitly, since the test client doesn't persist cookies across calls).
        $this->withCredentials()
            ->withCookie(config('session.cookie'), $cart->session_id)
            ->postJson('/cart/sync', ['items' => []])
            ->assertOk();

        $this->assertSame(0, $cart->fresh()->items()->count());
    }
}
