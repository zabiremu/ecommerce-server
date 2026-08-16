<?php

namespace Tests\Feature;

use App\Models\Coupon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\CreatesProducts;
use Tests\TestCase;

class CartPageCouponsTest extends TestCase
{
    use RefreshDatabase;
    use CreatesProducts;

    protected function baseCoupon(array $overrides = []): array
    {
        return array_merge([
            'code'   => 'CODE' . uniqid(),
            'type'   => 'percentage',
            'amount' => 10,
            'status' => true,
        ], $overrides);
    }

    public function test_cart_page_only_lists_currently_valid_coupons(): void
    {
        $valid = Coupon::create($this->baseCoupon(['code' => 'VALID10']));
        $expired = Coupon::create($this->baseCoupon(['code' => 'EXPIRED10', 'expires_at' => now()->subDay()]));
        $notYetStarted = Coupon::create($this->baseCoupon(['code' => 'FUTURE10', 'starts_at' => now()->addDay()]));
        $inactive = Coupon::create($this->baseCoupon(['code' => 'OFF10', 'status' => false]));

        $response = $this->get('/cart');

        $response->assertOk();
        $response->assertViewHas('coupons', function ($coupons) use ($valid, $expired, $notYetStarted, $inactive) {
            $codes = $coupons->pluck('code');
            return $codes->contains($valid->code)
                && !$codes->contains($expired->code)
                && !$codes->contains($notYetStarted->code)
                && !$codes->contains($inactive->code);
        });
    }

    public function test_checkout_page_only_lists_currently_valid_coupons(): void
    {
        $valid = Coupon::create($this->baseCoupon(['code' => 'VALID10']));
        $expired = Coupon::create($this->baseCoupon(['code' => 'EXPIRED10', 'expires_at' => now()->subDay()]));

        $response = $this->get('/checkout');

        $response->assertOk();
        $response->assertViewHas('coupons', function ($coupons) use ($valid, $expired) {
            $codes = $coupons->pluck('code');
            return $codes->contains($valid->code) && !$codes->contains($expired->code);
        });
    }

    /**
     * The coupon-rejection message on /api/cart/quote used to build its
     * minimum-spend figure with a bare number_format() call instead of the
     * shared Money::format() helper — so it showed as "...minimum spend of
     * 1,000.00." (no currency symbol) right next to a subtotal/total that
     * both correctly show "৳1,000.00". Locks down the message always goes
     * through the same formatter as the rest of the page.
     */
    public function test_quote_coupon_minimum_spend_message_uses_the_shared_money_format(): void
    {
        $product = $this->makeProduct(['selling_price' => 100]);
        $coupon = Coupon::create($this->baseCoupon(['code' => 'BIGSPEND', 'minimum_spend' => 1000]));

        $response = $this->postJson('/api/cart/quote', [
            'items' => [['id' => $product->id, 'qty' => 1]],
            'coupon_code' => $coupon->code,
        ]);

        $response->assertOk();
        $this->assertStringContainsString('৳1,000.00', $response->json('coupon_message'));
    }
}
