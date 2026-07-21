<?php

namespace Tests\Feature;

use App\Mail\AccountCreatedMail;
use App\Mail\NewContactMessage;
use App\Mail\OrderConfirmationMail;
use App\Mail\WelcomeMail;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SiteSetting;
use App\Models\User;
use App\Services\MailConfigService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\Feature\Concerns\CreatesProducts;
use Tests\TestCase;

class MailTest extends TestCase
{
    use RefreshDatabase;
    use CreatesProducts;

    protected function setUp(): void
    {
        parent::setUp();
        // SiteSetting caches values in a static array for the process lifetime;
        // flush it so settings written by one test don't leak into the next.
        SiteSetting::flushCache();
    }

    protected function makeOrder(array $overrides = []): Order
    {
        $product = $this->makeProduct(['selling_price' => 500]);

        $order = Order::create(array_merge([
            'order_no'         => 'NF-TEST-' . uniqid(),
            'shipping_name'    => 'Jane Doe',
            'shipping_phone'   => '01700000000',
            'shipping_email'   => 'jane@example.com',
            'shipping_address' => '123 Main St',
            'shipping_city'    => 'Dhaka',
            'subtotal'         => 500,
            'shipping_charge'  => 60,
            'discount'         => 0,
            'total'            => 560,
            'payment_method'   => 'cod',
            'payment_status'   => 'unpaid',
            'status'           => 'pending',
            'placed_at'        => now(),
        ], $overrides));

        OrderItem::create([
            'order_id'     => $order->id,
            'product_id'   => $product->id,
            'product_name' => $product->name,
            'product_sku'  => $product->sku,
            'quantity'     => 1,
            'unit_price'   => 500,
            'total'        => 500,
        ]);

        return $order->fresh('items');
    }

    // ── OrderConfirmationMail ─────────────────────────────────────────

    public function test_order_confirmation_mail_has_correct_subject_and_recipient(): void
    {
        SiteSetting::updateOrCreate(['key' => 'company_name'], ['value' => 'ACME Store']);
        $order = $this->makeOrder(['order_no' => 'NF-20260721-001']);

        $mail = (new OrderConfirmationMail($order))->to('jane@example.com');

        $mail->assertHasSubject('✅ Order Confirmed #NF-20260721-001 — ACME Store');
        $mail->assertTo('jane@example.com')->assertSeeInHtml('NF-20260721-001');
        $mail->assertSeeInHtml('Test Product');
    }

    public function test_order_confirmation_mail_is_sent_on_order_placement(): void
    {
        Mail::fake();
        $product = $this->makeProduct(['selling_price' => 500]);

        $this->postJson('/orders', [
            'shipping_name'    => 'Jane Doe',
            'shipping_phone'   => '01700000000',
            'shipping_email'   => 'jane@example.com',
            'shipping_address' => '123 Main St',
            'shipping_city'    => 'Dhaka',
            'payment_method'   => 'cod',
            'items'            => [['id' => $product->id, 'qty' => 1]],
        ])->assertOk();

        Mail::assertSent(OrderConfirmationMail::class, function (OrderConfirmationMail $mail) {
            return $mail->hasTo('jane@example.com');
        });
    }

    // ── WelcomeMail ────────────────────────────────────────────────────

    public function test_welcome_mail_has_correct_subject_and_content(): void
    {
        SiteSetting::updateOrCreate(['key' => 'company_name'], ['value' => 'ACME Store']);

        $mail = (new WelcomeMail('Jane Doe', 'jane@example.com', 'NF-20260721-001'))->to('jane@example.com');

        $mail->assertHasSubject('Welcome to ACME Store! 🎉');
        $mail->assertTo('jane@example.com');
        $mail->assertSeeInHtml('Jane');
        $mail->assertSeeInHtml('NF-20260721-001');
    }

    public function test_welcome_mail_is_sent_only_for_a_customers_first_order(): void
    {
        Mail::fake();
        $product = $this->makeProduct(['selling_price' => 500]);

        $payload = [
            'shipping_name'    => 'Jane Doe',
            'shipping_phone'   => '01700000000',
            'shipping_email'   => 'jane@example.com',
            'shipping_address' => '123 Main St',
            'shipping_city'    => 'Dhaka',
            'payment_method'   => 'cod',
            'items'            => [['id' => $product->id, 'qty' => 1]],
        ];

        $this->postJson('/orders', $payload)->assertOk();
        Mail::assertSent(WelcomeMail::class, 1);

        $this->postJson('/orders', $payload)->assertOk();
        // Still exactly one WelcomeMail across both orders (second order isn't "first").
        Mail::assertSent(WelcomeMail::class, 1);
    }

    // ── AccountCreatedMail ───────────────────────────────────────────

    public function test_account_created_mail_contains_login_credentials(): void
    {
        $user = User::create([
            'name' => 'Jane Doe', 'email' => 'jane@example.com', 'password' => 'irrelevant-hash',
        ]);

        $mail = (new AccountCreatedMail($user, 'Tmp$ecret123', 'NF-20260721-001'))->to('jane@example.com');

        $mail->assertTo('jane@example.com');
        $mail->assertSeeInHtml('jane@example.com');
        $mail->assertSeeInHtml('Tmp$ecret123');
        $mail->assertSeeInHtml('NF-20260721-001');
    }

    // ── NewContactMessage ──────────────────────────────────────────────

    public function test_contact_message_mail_uses_custom_subject_and_reply_to(): void
    {
        $msg = ContactMessage::create([
            'name' => 'John Smith', 'email' => 'john@example.com',
            'subject' => 'Where is my order?', 'message' => 'Please help.', 'status' => 'new',
        ]);

        $mail = new NewContactMessage($msg);

        $mail->assertHasSubject('[Contact] Where is my order?');
        $mail->assertHasReplyTo('john@example.com', 'John Smith');
        $mail->assertSeeInHtml('Please help.');
    }

    public function test_contact_message_mail_falls_back_to_default_subject(): void
    {
        $msg = ContactMessage::create([
            'name' => 'John Smith', 'email' => 'john@example.com',
            'message' => 'Please help.', 'status' => 'new',
        ]);

        (new NewContactMessage($msg))->assertHasSubject('[Contact] New message from John Smith');
    }

    public function test_contact_form_emails_the_configured_notify_address(): void
    {
        Mail::fake();
        SiteSetting::create(['key' => 'admin_notify_email', 'value' => 'admin@example.com']);

        $this->postJson('/contact', [
            'name'    => 'John Smith',
            'email'   => 'john@example.com',
            'message' => 'Please help.',
        ])->assertOk();

        Mail::assertSent(NewContactMessage::class, function (NewContactMessage $mail) {
            return $mail->hasTo('admin@example.com');
        });
    }

    public function test_contact_form_sends_no_mail_when_no_notify_address_configured(): void
    {
        Mail::fake();
        // The site_settings migration seeds a default contact_email, which is the
        // controller's fallback notify address — blank it to simulate "unconfigured".
        SiteSetting::updateOrCreate(['key' => 'admin_notify_email'], ['value' => '']);
        SiteSetting::updateOrCreate(['key' => 'contact_email'], ['value' => '']);

        $this->postJson('/contact', [
            'name'    => 'John Smith',
            'email'   => 'john@example.com',
            'message' => 'Please help.',
        ])->assertOk();

        Mail::assertNothingSent();
    }

    // ── MailConfigService ────────────────────────────────────────────

    public function test_mail_config_service_applies_site_settings_to_runtime_config(): void
    {
        SiteSetting::insert([
            ['key' => 'mail_mailer', 'value' => 'smtp'],
            ['key' => 'mail_host', 'value' => 'smtp.example.com'],
            ['key' => 'mail_port', 'value' => '2525'],
            ['key' => 'mail_username', 'value' => 'noreply@example.com'],
            ['key' => 'mail_password', 'value' => 'secret'],
            ['key' => 'mail_encryption', 'value' => 'ssl'],
            ['key' => 'mail_from_address', 'value' => 'noreply@example.com'],
            ['key' => 'mail_from_name', 'value' => 'ACME Store'],
        ]);

        MailConfigService::apply();

        $this->assertSame('smtp', config('mail.default'));
        $this->assertSame('smtp.example.com', config('mail.mailers.smtp.host'));
        $this->assertSame(2525, config('mail.mailers.smtp.port'));
        $this->assertSame('noreply@example.com', config('mail.mailers.smtp.username'));
        $this->assertSame('ssl', config('mail.mailers.smtp.encryption'));
        $this->assertSame('noreply@example.com', config('mail.from.address'));
        $this->assertSame('ACME Store', config('mail.from.name'));
    }

    public function test_mail_config_service_is_configured_reflects_site_settings(): void
    {
        $this->assertFalse(MailConfigService::isConfigured());

        SiteSetting::insert([
            ['key' => 'mail_host', 'value' => 'smtp.example.com'],
            ['key' => 'mail_username', 'value' => 'noreply@example.com'],
        ]);
        SiteSetting::flushCache();

        $this->assertTrue(MailConfigService::isConfigured());
    }
}
