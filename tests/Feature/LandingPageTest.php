<?php

namespace Tests\Feature;

use App\Models\ProductLandingPage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\CreatesProducts;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    use RefreshDatabase;
    use CreatesProducts;

    protected function makeLanding(array $overrides = []): ProductLandingPage
    {
        $product = $overrides['product'] ?? $this->makeProduct(['selling_price' => 1000, 'stock' => 10]);
        unset($overrides['product']);

        return ProductLandingPage::create(array_merge([
            'product_id'              => $product->id,
            'slug'                    => 'landing-' . uniqid(),
            'is_active'               => true,
            'shipping_inside_dhaka'   => 60,
            'shipping_outside_dhaka'  => 120,
            'enable_online_payment'   => false,
        ], $overrides));
    }

    public function test_active_landing_page_renders_for_a_published_product(): void
    {
        $landing = $this->makeLanding();

        $this->get('/lp/' . $landing->slug)->assertOk();
    }

    public function test_inactive_landing_page_returns_404(): void
    {
        $landing = $this->makeLanding(['is_active' => false]);

        $this->get('/lp/' . $landing->slug)->assertNotFound();
    }

    public function test_landing_page_404s_when_product_is_not_published(): void
    {
        $product = $this->makeProduct(['publish_status' => 'draft']);
        $landing = $this->makeLanding(['product' => $product]);

        $this->get('/lp/' . $landing->slug)->assertNotFound();
    }

    public function test_landing_page_order_uses_zone_based_shipping_and_places_order(): void
    {
        $product = $this->makeProduct(['selling_price' => 1000, 'stock' => 10]);
        $landing = $this->makeLanding(['product' => $product, 'shipping_inside_dhaka' => 60, 'shipping_outside_dhaka' => 120]);

        $response = $this->postJson('/lp/' . $landing->slug . '/order', [
            'shipping_name'    => 'Jane Doe',
            'shipping_phone'   => '01700000000',
            'shipping_address' => '123 Main St',
            'zone'             => 'outside',
            'quantity'         => 2,
            'payment_method'   => 'cod',
        ]);

        $response->assertOk()->assertJson(['success' => true]);

        $order = \App\Models\Order::first();
        $this->assertNotNull($order);
        $this->assertSame(2000.0, (float) $order->subtotal);
        $this->assertSame(120.0, (float) $order->shipping_charge);
        $this->assertSame('Outside Dhaka', $order->shipping_city);
    }

    public function test_landing_page_order_rejects_online_payment_when_disabled(): void
    {
        $landing = $this->makeLanding(['enable_online_payment' => false]);

        $response = $this->postJson('/lp/' . $landing->slug . '/order', [
            'shipping_name'    => 'Jane Doe',
            'shipping_phone'   => '01700000000',
            'shipping_address' => '123 Main St',
            'zone'             => 'inside',
            'quantity'         => 1,
            'payment_method'   => 'uddoktapay',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['payment_method']);
    }

    public function test_landing_page_order_is_rejected_when_stock_is_insufficient(): void
    {
        $product = $this->makeProduct(['stock' => 1]);
        $landing = $this->makeLanding(['product' => $product]);

        $response = $this->postJson('/lp/' . $landing->slug . '/order', [
            'shipping_name'    => 'Jane Doe',
            'shipping_phone'   => '01700000000',
            'shipping_address' => '123 Main St',
            'zone'             => 'inside',
            'quantity'         => 5,
            'payment_method'   => 'cod',
        ]);

        $response->assertStatus(422)->assertJson(['success' => false]);
        $this->assertSame(0, \App\Models\Order::count());
    }
}
