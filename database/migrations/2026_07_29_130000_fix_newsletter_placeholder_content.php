<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * The homepage newsletter section was showing "Hero Eyebrow 4" /
 * "Hero Eyebrow 5" — leftover placeholder values from testing the
 * hero settings, same class of bug fixed for home_hero_* in
 * 2026_07_29_120000. The 10% off incentive is a real existing feature
 * (NewsletterController's success message already promises it), not
 * a fabricated claim.
 */
return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        DB::table('site_settings')->updateOrInsert(
            ['key' => 'home_newsletter_title'],
            ['value' => 'Get 10% Off Your First Order', 'updated_at' => $now]
        );
        DB::table('site_settings')->updateOrInsert(
            ['key' => 'home_newsletter_subtitle'],
            ['value' => 'Subscribe for new arrivals, restocks, and exclusive offers.', 'updated_at' => $now]
        );
    }

    public function down(): void
    {
        // No-op: don't blindly wipe content an admin may have since edited.
    }
};
