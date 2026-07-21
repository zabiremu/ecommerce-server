<?php

namespace Tests\Feature;

use App\Models\DealsBanner;
use App\Models\InstagramPost;
use App\Models\Page;
use App\Models\Slider;
use App\Models\TrustItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Concerns\ActsAsAdmin;
use Tests\TestCase;

class AdminContentManagementTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();
        Storage::fake('public');
    }

    // ── Sliders ────────────────────────────────────────────────────────

    public function test_admin_can_create_update_and_delete_a_slider(): void
    {
        $response = $this->post('/admin/sliders', [
            'title'  => 'Summer Sale',
            'image'  => UploadedFile::fake()->image('slider.jpg'),
            'status' => '1',
        ]);
        $response->assertRedirect(route('admin.sliders.index'));

        $slider = Slider::where('title', 'Summer Sale')->firstOrFail();
        Storage::disk('public')->assertExists($slider->image);
        $this->assertTrue((bool) $slider->status);

        $this->put('/admin/sliders/' . $slider->id, ['title' => 'Winter Sale', 'status' => '1'])
            ->assertRedirect(route('admin.sliders.index'));
        $this->assertSame('Winter Sale', $slider->fresh()->title);

        $this->patch('/admin/sliders/' . $slider->id . '/toggle-status')->assertRedirect();
        $this->assertFalse((bool) $slider->fresh()->status);

        $this->delete('/admin/sliders/' . $slider->id)->assertRedirect(route('admin.sliders.index'));
        $this->assertDatabaseMissing('sliders', ['id' => $slider->id]);
    }

    // ── Trust items ──────────────────────────────────────────────────────

    public function test_admin_can_create_update_toggle_and_delete_a_trust_item(): void
    {
        $this->postJson('/admin/trust-items', ['title' => 'Secure Payment'])
            ->assertOk()->assertJson(['success' => true]);
        $item = TrustItem::where('title', 'Secure Payment')->firstOrFail();

        $this->putJson('/admin/trust-items/' . $item->id, ['title' => 'Fast Delivery'])
            ->assertOk()->assertJson(['success' => true]);
        $this->assertSame('Fast Delivery', $item->fresh()->title);

        $this->patchJson('/admin/trust-items/' . $item->id . '/toggle-status')->assertOk();
        $this->assertFalse((bool) $item->fresh()->status);

        $this->deleteJson('/admin/trust-items/' . $item->id)->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseMissing('trust_items', ['id' => $item->id]);
    }

    // ── Deals banner (singleton) ─────────────────────────────────────────

    public function test_deals_banner_edit_view_loads_the_seeded_singleton_row(): void
    {
        // The deals_banner migration seeds row id=1 by default.
        $this->assertSame(1, DealsBanner::count());

        $this->get('/admin/deals-banner')->assertOk();

        $this->assertSame(1, DealsBanner::count());
    }

    public function test_admin_can_update_the_deals_banner(): void
    {
        $this->put('/admin/deals-banner', ['title' => 'Flash Sale', 'emoji' => '🔥'])
            ->assertRedirect(route('admin.deals-banner.edit'));

        $banner = DealsBanner::current();
        $this->assertSame('Flash Sale', $banner->title);
        $this->assertSame('🔥', $banner->emoji);
    }

    // ── Instagram posts ──────────────────────────────────────────────────

    public function test_admin_can_create_update_toggle_and_delete_an_instagram_post(): void
    {
        $response = $this->post('/admin/instagram-posts', [
            'image'  => UploadedFile::fake()->image('post.jpg'),
            'link'   => 'https://instagram.com/p/abc123',
            'status' => '1',
        ]);
        $response->assertRedirect(route('admin.instagram-posts.index'));

        $post = InstagramPost::first();
        Storage::disk('public')->assertExists($post->image);
        $this->assertTrue((bool) $post->status);

        $this->put('/admin/instagram-posts/' . $post->id, ['likes_count' => 42, 'status' => '1'])
            ->assertRedirect(route('admin.instagram-posts.index'));
        $this->assertSame(42, $post->fresh()->likes_count);

        $this->patch('/admin/instagram-posts/' . $post->id . '/toggle-status')->assertRedirect();
        $this->assertFalse((bool) $post->fresh()->status);

        $this->delete('/admin/instagram-posts/' . $post->id)->assertRedirect(route('admin.instagram-posts.index'));
        $this->assertDatabaseMissing('instagram_posts', ['id' => $post->id]);
    }

    // ── Pages (about page uses the same generic controller) ─────────────

    public function test_about_page_edit_view_loads_the_seeded_about_page(): void
    {
        // The pages migrations seed "about", "privacy-policy", "terms-conditions",
        // and "refund-policy" by default.
        $this->assertDatabaseHas('pages', ['slug' => 'about']);

        $this->get('/admin/about-page')->assertOk();
    }

    public function test_admin_can_update_a_page(): void
    {
        $page = Page::where('slug', 'privacy-policy')->firstOrFail();

        $this->put('/admin/pages/' . $page->id, [
            'title'   => 'Our Privacy Policy',
            'content' => '<p>Updated content</p>',
        ])->assertRedirect(route('admin.pages.edit', $page));

        $page->refresh();
        $this->assertSame('Our Privacy Policy', $page->title);
        $this->assertSame('<p>Updated content</p>', $page->content);
    }
}
