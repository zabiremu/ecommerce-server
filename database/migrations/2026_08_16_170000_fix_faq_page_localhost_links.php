<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * The original FAQ seed migration built its links with url('/track-order')
 * etc. at migration-run time, which froze whatever APP_URL was set on the
 * machine that ran it (http://localhost in dev) as static text inside the
 * stored HTML — so on production the links silently pointed at the visitor's
 * own computer instead of the live site. This corrects any already-migrated
 * copy of that row, on any environment, to use relative paths instead.
 */
return new class extends Migration
{
    public function up(): void
    {
        $replacements = [
            'href="http://localhost/track-order"'   => 'href="/track-order"',
            'href="http://localhost/refund-policy"' => 'href="/refund-policy"',
            'href="http://localhost/contact"'       => 'href="/contact"',
        ];

        $page = DB::table('pages')->where('slug', 'faq')->first();
        if (!$page || !$page->content) {
            return;
        }

        $fixed = strtr($page->content, $replacements);
        if ($fixed !== $page->content) {
            DB::table('pages')->where('slug', 'faq')->update(['content' => $fixed]);
        }
    }

    public function down(): void
    {
        // Intentionally irreversible — this only strips a stale dev hostname
        // from stored content, there's nothing meaningful to revert to.
    }
};
