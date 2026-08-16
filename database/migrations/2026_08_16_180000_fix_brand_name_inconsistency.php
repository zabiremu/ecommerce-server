<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * The site's canonical brand is Roventex (info@roventex.com). Two independent
 * drifts had left the site showing two different brand names:
 *
 *  - site_settings.company_name/contact_email/company_tagline were correct
 *    ("Roventex") but wrongly cased ("ROVENTEX" / "info@ROVENTEX.com"),
 *    apparently from a manual edit through the admin Site Settings panel.
 *  - The About/Terms/Privacy/Refund pages' content (pages table) was never
 *    wired to site_settings at all — it was pasted into the WYSIWYG content
 *    once, before the brand name was settled, and still says "NF Shop 24" /
 *    info@nfshop24.com.
 *
 * This corrects any already-migrated copy of both, on any environment.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('site_settings')->where('key', 'company_name')->update(['value' => 'Roventex']);
        DB::table('site_settings')->where('key', 'contact_email')->update(['value' => 'info@roventex.com']);

        $tagline = DB::table('site_settings')->where('key', 'company_tagline')->value('value');
        if ($tagline !== null) {
            $fixed = strtr($tagline, ['ROVENTEX' => 'Roventex']);
            if ($fixed !== $tagline) {
                DB::table('site_settings')->where('key', 'company_tagline')->update(['value' => $fixed]);
            }
        }

        $replacements = [
            'NF Shop 24'          => 'Roventex',
            'info@nfshop24.com'   => 'info@roventex.com',
        ];

        foreach (DB::table('pages')->whereNotNull('content')->get(['id', 'content']) as $page) {
            $fixed = strtr($page->content, $replacements);
            if ($fixed !== $page->content) {
                DB::table('pages')->where('id', $page->id)->update(['content' => $fixed]);
            }
        }
    }

    public function down(): void
    {
        // Intentionally irreversible — this only corrects a stale/incorrect
        // brand name in stored content, there's nothing meaningful to revert to.
    }
};
