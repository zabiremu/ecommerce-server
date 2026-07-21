<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\Feature\Concerns\ActsAsAdmin;
use Tests\Feature\Concerns\CreatesOrders;
use Tests\Feature\Concerns\CreatesProducts;
use Tests\TestCase;

class AdminSiteSettingsAndSteadfastTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;
    use CreatesProducts;
    use CreatesOrders;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();
        // SiteSetting caches values in a static array for the process lifetime;
        // RefreshDatabase rolls back the DB between tests but does not clear this
        // cache, so a setting written (and cached) in one test can leak into the
        // next unless we flush it here.
        SiteSetting::flushCache();
    }

    // ── Site settings ────────────────────────────────────────────────────

    public function test_admin_can_update_site_settings(): void
    {
        $response = $this->put('/admin/site-settings', [
            'company_name'  => 'My Test Shop',
            'contact_email' => 'hello@example.com',
            'mail_mailer'   => 'smtp',
            'mail_port'     => '587',
        ]);

        $response->assertRedirect(route('admin.site-settings.edit'));
        $this->assertSame('My Test Shop', SiteSetting::get('company_name'));
        $this->assertSame('hello@example.com', SiteSetting::get('contact_email'));
        $this->assertSame('587', SiteSetting::get('mail_port'));
    }

    public function test_site_settings_reject_invalid_color_format(): void
    {
        $response = $this->from('/admin/site-settings')->put('/admin/site-settings', [
            'color_primary' => 'not-a-hex-color',
        ]);

        $response->assertSessionHasErrors('color_primary');
    }

    public function test_send_test_email_rejects_invalid_address(): void
    {
        $response = $this->postJson('/admin/site-settings/test-email', ['to' => 'not-an-email']);

        $response->assertStatus(422)->assertJson(['success' => false]);
    }

    // ── Steadfast ────────────────────────────────────────────────────────

    protected function configureSteadfast(): void
    {
        SiteSetting::updateOrCreate(['key' => 'steadfast_api_key'], ['value' => 'test-key']);
        SiteSetting::updateOrCreate(['key' => 'steadfast_secret_key'], ['value' => 'test-secret']);
        SiteSetting::flushCache();
    }

    public function test_sending_an_order_without_steadfast_configured_fails_gracefully(): void
    {
        $product = $this->makeProduct();
        $order = $this->makeOrderFor($product);

        $response = $this->postJson('/admin/steadfast/' . $order->id . '/send');

        $response->assertStatus(422)->assertJson(['ok' => false]);
    }

    public function test_sending_an_order_to_steadfast_records_the_tracking_code(): void
    {
        $this->configureSteadfast();
        $product = $this->makeProduct();
        $order = $this->makeOrderFor($product);

        Http::fake([
            '*/create_order' => Http::response([
                'status'      => 'success',
                'consignment' => ['consignment_id' => 555, 'tracking_code' => 'TRK555', 'status' => 'in_review'],
            ]),
        ]);

        $response = $this->postJson('/admin/steadfast/' . $order->id . '/send');

        $response->assertOk()->assertJson(['ok' => true, 'tracking_code' => 'TRK555']);
        $order->refresh();
        $this->assertSame('TRK555', $order->steadfast_tracking_code);
        $this->assertSame('shipped', $order->status);
    }

    public function test_cannot_send_the_same_order_to_steadfast_twice(): void
    {
        $this->configureSteadfast();
        $product = $this->makeProduct();
        $order = $this->makeOrderFor($product, ['steadfast_consignment_id' => '123', 'steadfast_tracking_code' => 'TRK123']);

        $response = $this->postJson('/admin/steadfast/' . $order->id . '/send');

        $response->assertStatus(422)->assertJson(['ok' => false]);
    }

    public function test_webhook_marks_order_delivered_and_paid_for_cod(): void
    {
        $product = $this->makeProduct();
        $order = $this->makeOrderFor($product, [
            'payment_method' => 'cod', 'payment_status' => 'unpaid', 'status' => 'shipped',
            'steadfast_consignment_id' => '555',
        ]);

        $response = $this->postJson('/api/steadfast/webhook', [
            'invoice' => $order->order_no,
            'status'  => 'delivered',
        ]);

        $response->assertOk();
        $order->refresh();
        $this->assertSame('delivered', $order->status);
        $this->assertSame('paid', $order->payment_status);
    }

    public function test_webhook_rejects_wrong_bearer_token_when_configured(): void
    {
        SiteSetting::updateOrCreate(['key' => 'steadfast_webhook_token'], ['value' => 'secret-token']);
        SiteSetting::flushCache();

        $response = $this->postJson('/api/steadfast/webhook', ['invoice' => 'NF-1', 'status' => 'delivered'], [
            'Authorization' => 'Bearer wrong-token',
        ]);

        $response->assertStatus(401);
    }

    public function test_webhook_returns_404_for_unknown_order(): void
    {
        $response = $this->postJson('/api/steadfast/webhook', [
            'invoice' => 'NF-DOES-NOT-EXIST',
            'status'  => 'delivered',
        ]);

        $response->assertStatus(404);
    }
}
