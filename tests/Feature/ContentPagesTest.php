<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentPagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * About/Terms/Privacy/Refund page content once said "NF Shop 24" /
     * info@nfshop24.com (hardcoded into a seed migration before the brand
     * name was settled), while site_settings.company_name/contact_email —
     * the single source of truth the Contact page and footer read from —
     * said "ROVENTEX"/"info@ROVENTEX.com" (right brand, wrong casing, from
     * a manual admin edit). Two different-looking brand identities were
     * visible on the same site. This locks both down to one canonical,
     * correctly-cased "Roventex" / info@roventex.com everywhere.
     */
    public function test_legal_and_about_pages_use_the_canonical_brand_name_and_email(): void
    {
        $this->assertSame('Roventex', SiteSetting::get('company_name'));
        $this->assertSame('info@roventex.com', SiteSetting::get('contact_email'));

        foreach (['about', 'terms-conditions', 'privacy-policy', 'refund-policy'] as $slug) {
            $content = Page::where('slug', $slug)->value('content');
            $this->assertNotNull($content, "Missing page content for slug '{$slug}'");
            $this->assertStringNotContainsString('NF Shop 24', $content, "'{$slug}' still mentions the old brand name");
            $this->assertStringNotContainsString('nfshop24', $content, "'{$slug}' still mentions the old email domain");
        }

        foreach (['/about', '/contact'] as $path) {
            $html = $this->get($path)->assertOk()->getContent();
            $this->assertStringContainsString('Roventex', $html);
            $this->assertStringNotContainsString('NF Shop 24', $html);
            $this->assertStringNotContainsString('ROVENTEX', $html);
        }
    }

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
