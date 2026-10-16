<?php

namespace Tests\Feature;

use App\Models\DealsBanner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\Feature\Concerns\ActsAsAdmin;
use Tests\TestCase;

class SaleCountdownTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    private function banner(array $attrs): DealsBanner
    {
        $banner = DealsBanner::current();
        $banner->update(array_merge([
            'title'           => 'Stock Clearance Sale',
            'title_highlight' => 'Up to 60% off',
            'button_text'     => 'Shop the collection',
            'status'          => true,
        ], $attrs));

        return $banner->fresh();
    }

    public function test_homepage_shows_countdown_while_sale_is_running(): void
    {
        $this->banner(['ends_at' => now()->addDays(3)]);

        $this->get('/')
            ->assertOk()
            ->assertSee('gms-sale-cd', false)
            ->assertSee('Stock Clearance Sale')
            ->assertSee('Up to 60% off')
            ->assertSee('Shop the collection');
    }

    public function test_homepage_hides_countdown_without_timer_after_end_or_when_disabled(): void
    {
        // Seeded default banner has no end time -> nothing on the homepage.
        $this->get('/')->assertOk()->assertDontSee('id="gms-sale-cd"', false);

        $this->banner(['ends_at' => now()->subMinute()]);
        $this->get('/')->assertDontSee('id="gms-sale-cd"', false);

        $this->banner(['ends_at' => now()->addDay(), 'status' => false]);
        $this->get('/')->assertDontSee('id="gms-sale-cd"', false);
    }

    public function test_scheduled_sale_appears_only_after_start_time(): void
    {
        $this->banner(['starts_at' => now()->addHour(), 'ends_at' => now()->addDays(2)]);
        $this->get('/')->assertDontSee('id="gms-sale-cd"', false);

        Carbon::setTestNow(now()->addHours(2));
        $this->get('/')->assertSee('id="gms-sale-cd"', false);
    }

    public function test_admin_times_are_saved_as_bangladesh_time(): void
    {
        $this->actingAsAdmin();

        $this->put('/admin/deals-banner', [
            'title'   => 'Eid Sale',
            'ends_at' => '2030-01-10T18:00',
            'status'  => '1',
        ])->assertRedirect(route('admin.deals-banner.edit'));

        $banner = DealsBanner::current()->fresh();
        // 18:00 in Dhaka (UTC+6) is 12:00 UTC.
        $this->assertSame('2030-01-10 12:00:00', $banner->ends_at->utc()->format('Y-m-d H:i:s'));
        $this->assertNull($banner->starts_at);
    }

    public function test_end_time_must_be_after_start_time(): void
    {
        $this->actingAsAdmin();

        $this->put('/admin/deals-banner', [
            'title'     => 'Bad Sale',
            'starts_at' => '2030-01-10T18:00',
            'ends_at'   => '2030-01-09T18:00',
        ])->assertSessionHasErrors('ends_at');
    }
}
