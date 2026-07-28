<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * The homepage hero was showing Faker-generated placeholder text
 * ("Consequatur numquam eu non cillum...") on 4 slides with an
 * unrelated stock wallpaper image, plus SiteSetting values left over
 * from testing ("Hero Eyebrow 1/2/3") and a hero fallback still
 * referencing the old gaming-merch business ("Level Up Your Gear!").
 * Replaces both with real, honest apparel-store content — no
 * fabricated discounts/claims, just real category-forward copy.
 */
return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        DB::table('site_settings')->updateOrInsert(
            ['key' => 'home_hero_eyebrow'],
            ['value' => 'New Season', 'updated_at' => $now]
        );
        DB::table('site_settings')->updateOrInsert(
            ['key' => 'home_hero_title'],
            ['value' => 'Everyday Style, Elevated', 'updated_at' => $now]
        );
        DB::table('site_settings')->updateOrInsert(
            ['key' => 'home_hero_subtitle'],
            ['value' => 'Apparel and footwear chosen for quality and fit, at honest prices.', 'updated_at' => $now]
        );

        DB::table('sliders')->delete();
        DB::table('sliders')->insert([
            [
                'title'      => 'New Season Arrivals',
                'subtitle'   => 'Fresh styles across T-Shirts, Shirts, and more — added regularly.',
                'image'      => 'frontend/sliders/gms-hero-new-season.svg',
                'status'     => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title'      => 'Footwear For Every Day',
                'subtitle'   => 'From Sneakers to Formal Shoes — find your fit.',
                'image'      => 'frontend/sliders/gms-hero-footwear.svg',
                'status'     => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title'      => 'Everyday Essentials',
                'subtitle'   => 'Thoughtfully chosen apparel at honest prices.',
                'image'      => 'frontend/sliders/gms-hero-essentials.svg',
                'status'     => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        // No-op: don't blindly wipe hero content an admin may have since edited via the admin panel.
    }
};
