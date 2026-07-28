<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Replaces the 2026_07_29_140000 hero photos with a fresh set sourced the
 * same way (Unsplash License, verified branding-free) at
 * public/frontend/products/unsplash/. Copy is written to match what's
 * actually shown in each photo.
 */
return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        DB::table('sliders')->delete();
        DB::table('sliders')->insert([
            [
                'title'      => 'Gear Up, Move Free',
                'subtitle'   => 'Bold athleisure and everyday activewear built for motion.',
                'image'      => 'frontend/products/unsplash/unsplash-1515886657613-9f3515b0c78f.jpg',
                'status'     => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title'      => 'Effortless Everyday Basics',
                'subtitle'   => 'Clean tees and easy staples for him, made for daily wear.',
                'image'      => 'frontend/products/unsplash/unsplash-1622445275463-afa2ab738c34.jpg',
                'status'     => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title'      => 'Knits Worth Noticing',
                'subtitle'   => 'Statement sweaters and cozy layers for her, in bold colour.',
                'image'      => 'frontend/products/unsplash/unsplash-1526720568277-267ff662958c.jpg',
                'status'     => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        // No-op: don't blindly wipe hero content an admin may have since edited.
    }
};
