<?php

namespace Tests\Feature;

use App\Models\Coupon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\ActsAsAdmin;
use Tests\TestCase;

class AdminCouponTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();
    }

    protected function validPayload(array $overrides = []): array
    {
        return array_merge([
            'code'   => 'save10',
            'type'   => 'percentage',
            'amount' => 10,
        ], $overrides);
    }

    public function test_admin_can_create_a_coupon_and_code_is_uppercased(): void
    {
        $response = $this->post('/admin/coupons', $this->validPayload());

        $response->assertRedirect(route('admin.coupons.index'));
        $this->assertDatabaseHas('coupons', ['code' => 'SAVE10', 'type' => 'percentage']);
    }

    public function test_coupon_code_must_be_unique(): void
    {
        Coupon::create(['code' => 'SAVE10', 'type' => 'percentage', 'amount' => 10]);

        $response = $this->from('/admin/coupons/create')->post('/admin/coupons', $this->validPayload());

        $response->assertSessionHasErrors('code');
        $this->assertSame(1, Coupon::where('code', 'SAVE10')->count());
    }

    public function test_admin_can_update_a_coupon(): void
    {
        $coupon = Coupon::create(['code' => 'OLD10', 'type' => 'percentage', 'amount' => 10]);

        $response = $this->put('/admin/coupons/' . $coupon->id, $this->validPayload(['code' => 'NEW20', 'amount' => 20]));

        $response->assertRedirect(route('admin.coupons.index'));
        $coupon->refresh();
        $this->assertSame('NEW20', $coupon->code);
        $this->assertSame(20.0, (float) $coupon->amount);
    }

    public function test_admin_can_delete_a_coupon(): void
    {
        $coupon = Coupon::create(['code' => 'DEL10', 'type' => 'percentage', 'amount' => 10]);

        $this->delete('/admin/coupons/' . $coupon->id)->assertRedirect(route('admin.coupons.index'));

        $this->assertDatabaseMissing('coupons', ['id' => $coupon->id]);
    }

    public function test_admin_can_toggle_coupon_status(): void
    {
        $coupon = Coupon::create(['code' => 'TOG10', 'type' => 'percentage', 'amount' => 10, 'status' => true]);

        $this->patch('/admin/coupons/' . $coupon->id . '/toggle-status')->assertRedirect();

        $this->assertFalse((bool) $coupon->fresh()->status);
    }

    public function test_generate_code_returns_a_unique_unused_code(): void
    {
        $response = $this->getJson('/admin/coupons/generate-code');

        $response->assertOk();
        $code = $response->json('code');
        $this->assertNotEmpty($code);
        $this->assertSame(0, Coupon::where('code', $code)->count());
    }
}
