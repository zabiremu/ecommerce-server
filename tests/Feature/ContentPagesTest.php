<?php

namespace Tests\Feature;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentPagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The FAQ page's seeded content once had its Track Order / Refund &
     * Return Policy / Contact Us links frozen as absolute http://localhost
     * URLs (baked in at migration-run time via url(), which resolves
     * against whatever APP_URL happened to be set on the machine that ran
     * the migration) — on production those links sent visitors to their own
     * computer instead of the live site. This locks down that the rendered
     * page never contains an absolute dev-host link.
     */
    public function test_faq_page_links_are_relative_not_hardcoded_to_a_dev_host(): void
    {
        // Checked against the stored content itself, not the whole rendered
        // page — the page's header/footer chrome legitimately contains
        // "localhost" in this test environment (APP_URL) via route()/asset(),
        // which is correct dynamic behavior, not the bug being guarded here.
        $content = Page::where('slug', 'faq')->value('content');
        $this->assertNotNull($content);
        $this->assertStringNotContainsString('http://localhost', $content);
        $this->assertStringNotContainsString('http://127.0.0.1', $content);

        $response = $this->get('/faq');
        $response->assertOk();

        $html = $response->getContent();
        $this->assertStringContainsString('href="/track-order"', $html);
        $this->assertStringContainsString('href="/refund-policy"', $html);
        $this->assertStringContainsString('href="/contact"', $html);
    }
}
