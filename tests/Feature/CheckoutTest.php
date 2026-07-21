<?php

namespace Tests\Feature;

use App\Mail\AccountCreatedMail;
use App\Mail\OrderConfirmationMail;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\Feature\Concerns\CreatesProducts;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;
    use CreatesProducts;

    protected function validPayload(array $overrides = []): array
    {
        return array_merge([
            'shipping_name'    => 'Jane Doe',
            'shipping_phone'   => '01700000000',
            'shipping_email'   => 'jane@example.com',
            'shipping_address' => '123 Main Street',
            'shipping_city'    => 'Dhaka',
            'payment_method'   => 'cod',
        ], $overrides);
    }

    public function test_guest_can_place_an_order_for_a_simple_product(): void
    {
        Mail::fake();
        $product = $this->makeProduct(['selling_price' => 500, 'stock' => 10]);

        $response = $this->postJson('/orders', $this->validPayload([
            'items' => [['id' => $product->id, 'qty' => 2]],
        ]));

        $response->assertOk()->assertJson(['success' => true]);

        $order = Order::first();
        $this->assertNotNull($order);
        $this->assertSame(1000.0, (float) $order->subtotal);
        $this->assertSame('Jane Doe', $order->shipping_name);
        $this->assertCount(1, $order->items);
        $this->assertSame($product->id, $order->items->first()->product_id);
        $this->assertNull($order->items->first()->variant_id);

        Mail::assertSent(OrderConfirmationMail::class);
    }

    public function test_order_records_the_chosen_variant_size_and_color(): void
    {
        Mail::fake();
        $product = $this->makeProduct(['selling_price' => 500]);
        $variant = $this->makeVariant($product, [
            'color' => 'Blue',
            'size'  => 'L',
            'price' => 750,
            'stock' => 5,
        ]);

        $response = $this->postJson('/orders', $this->validPayload([
            'items' => [['id' => $product->id, 'qty' => 1, 'variant_id' => $variant->id]],
        ]));

        $response->assertOk()->assertJson(['success' => true]);

        $order = Order::with('items')->first();
        $item = $order->items->first();

        // Variant price overrides the base product price.
        $this->assertSame(750.0, (float) $item->unit_price);
        $this->assertSame($variant->id, $item->variant_id);
        $this->assertSame('Blue / L', $item->variant_label);
        $this->assertSame($variant->sku, $item->variant_sku);
    }

    public function test_order_is_rejected_when_variant_stock_is_insufficient(): void
    {
        $product = $this->makeProduct();
        $variant = $this->makeVariant($product, ['stock' => 1]);

        $response = $this->postJson('/orders', $this->validPayload([
            'items' => [['id' => $product->id, 'qty' => 5, 'variant_id' => $variant->id]],
        ]));

        $response->assertStatus(422)->assertJson(['success' => false]);
        $this->assertSame(0, Order::count());
    }

    public function test_order_is_rejected_when_product_stock_is_insufficient(): void
    {
        $product = $this->makeProduct(['stock' => 1]);

        $response = $this->postJson('/orders', $this->validPayload([
            'items' => [['id' => $product->id, 'qty' => 3]],
        ]));

        $response->assertStatus(422)->assertJson(['success' => false]);
        $this->assertSame(0, Order::count());
    }

    public function test_valid_coupon_reduces_order_total(): void
    {
        Mail::fake();
        $product = $this->makeProduct(['selling_price' => 1000]);
        Coupon::create([
            'code'   => 'SAVE10',
            'type'   => 'percentage',
            'amount' => 10,
            'status' => true,
        ]);

        $response = $this->postJson('/orders', $this->validPayload([
            'items'       => [['id' => $product->id, 'qty' => 1]],
            'coupon_code' => 'save10',
        ]));

        $response->assertOk();
        $order = Order::first();
        $this->assertSame(100.0, (float) $order->discount);
        $this->assertSame(900.0, (float) $order->total);
    }

    public function test_expired_coupon_is_ignored(): void
    {
        Mail::fake();
        $product = $this->makeProduct(['selling_price' => 1000]);
        Coupon::create([
            'code'       => 'OLD10',
            'type'       => 'percentage',
            'amount'     => 10,
            'status'     => true,
            'expires_at' => now()->subDay(),
        ]);

        $response = $this->postJson('/orders', $this->validPayload([
            'items'       => [['id' => $product->id, 'qty' => 1]],
            'coupon_code' => 'OLD10',
        ]));

        $response->assertOk();
        $order = Order::first();
        $this->assertSame(0.0, (float) $order->discount);
    }

    public function test_order_placement_auto_creates_a_user_account_and_emails_credentials(): void
    {
        Mail::fake();
        $product = $this->makeProduct();

        $this->assertSame(0, User::where('email', 'jane@example.com')->count());

        $this->postJson('/orders', $this->validPayload([
            'items' => [['id' => $product->id, 'qty' => 1]],
        ]))->assertOk();

        $user = User::where('email', 'jane@example.com')->first();
        $this->assertNotNull($user);
        $this->assertSame('Jane Doe', $user->name);
        $this->assertSame('01700000000', $user->phone);

        Mail::assertSent(AccountCreatedMail::class, function (AccountCreatedMail $mail) use ($user) {
            return $mail->user->is($user) && $mail->plainPassword !== '';
        });
    }

    public function test_second_order_with_same_email_does_not_create_duplicate_account_or_credentials_email(): void
    {
        Mail::fake();
        $product = $this->makeProduct();

        $this->postJson('/orders', $this->validPayload([
            'items' => [['id' => $product->id, 'qty' => 1]],
        ]))->assertOk();

        $this->postJson('/orders', $this->validPayload([
            'shipping_phone' => '01711111111',
            'items'          => [['id' => $product->id, 'qty' => 1]],
        ]))->assertOk();

        $this->assertSame(1, User::where('email', 'jane@example.com')->count());
        Mail::assertSent(AccountCreatedMail::class, 1);
    }

    public function test_order_is_rejected_for_blacklisted_phone(): void
    {
        \App\Models\PhoneBlacklist::create(['phone' => '01700000000']);
        $product = $this->makeProduct();

        $response = $this->postJson('/orders', $this->validPayload([
            'items' => [['id' => $product->id, 'qty' => 1]],
        ]));

        $response->assertStatus(422)->assertJson(['success' => false]);
        $this->assertSame(0, Order::count());
    }
}
