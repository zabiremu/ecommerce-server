<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\Feature\Concerns\CreatesOrders;
use Tests\Feature\Concerns\CreatesProducts;
use Tests\TestCase;

class UddoktaPayTest extends TestCase
{
    use RefreshDatabase;
    use CreatesProducts;
    use CreatesOrders;

    protected function setUp(): void
    {
        parent::setUp();
        SiteSetting::updateOrCreate(['key' => 'uddoktapay_api_key'], ['value' => 'test-api-key']);
        // SiteSetting caches values in a static array for the process lifetime;
        // flush it so settings written here don't leak stale values across tests.
        SiteSetting::flushCache();
    }

    public function test_callback_without_invoice_id_redirects_home_with_error(): void
    {
        $this->get('/uddoktapay/callback')->assertRedirect(route('home'));
    }

    public function test_callback_marks_order_paid_when_payment_completed(): void
    {
        $product = $this->makeProduct();
        $order = $this->makeOrderFor($product, ['payment_status' => 'unpaid', 'payment_method' => 'uddoktapay']);

        Http::fake([
            '*/verify-payment' => Http::response([
                'status'   => 'COMPLETED',
                'metadata' => ['order_no' => $order->order_no],
            ]),
        ]);

        $response = $this->get('/uddoktapay/callback?invoice_id=INV123');

        $response->assertRedirect(route('order-complete') . '?id=' . $order->order_no);
        $order->refresh();
        $this->assertSame('paid', $order->payment_status);
        $this->assertSame('INV123', $order->uddoktapay_invoice_id);
    }

    public function test_callback_leaves_order_unpaid_when_payment_not_completed(): void
    {
        $product = $this->makeProduct();
        $order = $this->makeOrderFor($product, ['payment_status' => 'unpaid', 'payment_method' => 'uddoktapay']);

        Http::fake([
            '*/verify-payment' => Http::response([
                'status'   => 'PENDING',
                'metadata' => ['order_no' => $order->order_no],
            ]),
        ]);

        $this->get('/uddoktapay/callback?invoice_id=INV123')
            ->assertRedirect(route('order-complete') . '?id=' . $order->order_no);

        $this->assertSame('unpaid', $order->fresh()->payment_status);
    }

    public function test_cancel_redirects_to_order_complete_with_warning(): void
    {
        $product = $this->makeProduct();
        $order = $this->makeOrderFor($product);

        $this->get('/uddoktapay/cancel?order=' . $order->order_no)
            ->assertRedirect(route('order-complete') . '?id=' . $order->order_no)
            ->assertSessionHas('warning');
    }

    // ── Webhook ──────────────────────────────────────────────────────────

    public function test_webhook_rejects_invalid_api_key(): void
    {
        $response = $this->postJson('/uddoktapay/webhook', ['status' => 'COMPLETED'], [
            'RT-UDDOKTAPAY-API-KEY' => 'wrong-key',
        ]);

        $response->assertStatus(401);
    }

    public function test_webhook_marks_order_paid_for_completed_payment(): void
    {
        $product = $this->makeProduct();
        $order = $this->makeOrderFor($product, ['payment_status' => 'unpaid', 'payment_method' => 'uddoktapay']);

        $response = $this->postJson('/uddoktapay/webhook', [
            'status'     => 'COMPLETED',
            'invoice_id' => 'INV999',
            'metadata'   => ['order_no' => $order->order_no],
        ], [
            'RT-UDDOKTAPAY-API-KEY' => 'test-api-key',
        ]);

        $response->assertOk();
        $order->refresh();
        $this->assertSame('paid', $order->payment_status);
        $this->assertSame('INV999', $order->uddoktapay_invoice_id);
    }

    public function test_webhook_ignores_non_completed_status(): void
    {
        $product = $this->makeProduct();
        $order = $this->makeOrderFor($product, ['payment_status' => 'unpaid']);

        $this->postJson('/uddoktapay/webhook', [
            'status'     => 'PENDING',
            'metadata'   => ['order_no' => $order->order_no],
        ], ['RT-UDDOKTAPAY-API-KEY' => 'test-api-key'])->assertOk();

        $this->assertSame('unpaid', $order->fresh()->payment_status);
    }

    public function test_webhook_returns_404_when_order_not_found(): void
    {
        $response = $this->postJson('/uddoktapay/webhook', [
            'status'   => 'COMPLETED',
            'metadata' => ['order_no' => 'NF-DOES-NOT-EXIST'],
        ], ['RT-UDDOKTAPAY-API-KEY' => 'test-api-key']);

        $response->assertStatus(404);
    }
}
