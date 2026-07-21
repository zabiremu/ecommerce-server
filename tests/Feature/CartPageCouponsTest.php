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
}
