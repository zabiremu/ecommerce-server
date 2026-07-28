<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Swaps the abstract gradient hero banners (2026_07_28_120000) for real
 * photos already sitting in the project (public/frontend/products/
 * unsplash/), representing both men and women. These are the only
 * unused people-photos available — two others already serve as product
 * thumbnails (Classic Crew Neck T-Shirt, Graphic Print T-Shirt) and are
 * reused here rather than fabricated/downloaded from nowhere. Copy is
 * written to match what's actually shown in each photo.
 */
return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        DB::table('sliders')->delete();
        DB::table('sliders')->insert([
            [
                'title'      => 'Layer Up In Style',
                'subtitle'   => 'Jackets, hoodies, and everyday essentials for her.',
                'image'      => 'frontend/products/unsplash/unsplash-1517841905240-472988babdf9.jpg',
                'status'     => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title'      => 'Elevated Basics',
                'subtitle'   => 'Clean, comfortable everyday essentials for him.',
                'image'      => 'frontend/products/unsplash/unsplash-1521572163474-6864f9cf17ab.jpg',
                'status'     => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title'      => 'New Season Arrivals',
                'subtitle'   => 'Fresh graphic tees and everyday styles, added regularly.',
                'image'      => 'frontend/products/unsplash/unsplash-1503341504253-dff4815485f1.jpg',
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
