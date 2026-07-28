<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Tags a spread of the real starter-catalog products (seeded by
 * 2026_07_29_100000_seed_starter_apparel_products) with the 7
 * Product::SPECIAL_SECTIONS keys, so each homepage section actually has
 * products to show instead of sitting empty. Matched by slug rather than
 * id so this stays safe to re-run against a differently-ordered catalog.
 *
 * Flash Sale and Clearance also get a genuine sale_price set — tagging a
 * product "Flash Sale" with no real discount would be misleading, so the
 * price cut is real, not cosmetic.
 */
return new class extends Migration
{
    public function up(): void
    {
        $tags = [
            // slug => [special_sections...]
            'classic-crew-neck-t-shirt-1' => ['new-arrival', 'best-seller'],
            'casual-check-shirt-6'        => ['new-arrival'],
            'slim-fit-jeans-9'            => ['new-arrival'],
            'classic-canvas-sneakers-23'  => ['new-arrival'],

            'straight-fit-jeans-10'          => ['best-seller'],
            'lightweight-running-shoes-33'   => ['best-seller'],
            'all-court-sports-shoes-36'      => ['best-seller'],

            'leather-formal-shoes-25' => ['premium-collection'],
            'oxford-formal-shoes-26'  => ['premium-collection'],
            'combat-boots-28'         => ['premium-collection'],
            'suede-loafers-38'        => ['premium-collection'],

            'slim-fit-polo-shirt-4'  => ['combo-offer'],
            'formal-cotton-shirt-5'  => ['combo-offer'],
            'slim-fit-formal-pant-17' => ['combo-offer'],
            'classic-chino-pant-19'  => ['combo-offer'],

            'comfort-slides-30'                => ['restock'],
            'everyday-slippers-31'              => ['restock'],
            'memory-foam-slippers-32'           => ['restock'],
            'breathable-mesh-running-shoes-34'  => ['restock'],
        ];

        foreach ($tags as $slug => $sections) {
            DB::table('products')
                ->where('slug', $slug)
                ->update(['special_sections' => json_encode($sections)]);
        }

        // Flash Sale — real discount, not just a badge.
        $flashSale = [
            'multi-pocket-cargo-pant-15' => 950.00,
            'casual-cotton-shorts-21'    => 420.00,
            'chunky-sole-sneakers-24'    => 1899.00,
            'sport-slides-29'            => 399.00,
        ];
        foreach ($flashSale as $slug => $salePrice) {
            DB::table('products')
                ->where('slug', $slug)
                ->update([
                    'special_sections' => json_encode(['flash-sale']),
                    'sale_price'       => $salePrice,
                ]);
        }

        // Clearance — deeper discount, same reasoning.
        $clearance = [
            'oversized-boxy-shirt-7'  => 450.00,
            'boxy-fit-denim-shirt-8'  => 599.00,
            'wide-leg-baggy-jeans-12' => 999.00,
            'cargo-shorts-22'         => 420.00,
        ];
        foreach ($clearance as $slug => $salePrice) {
            DB::table('products')
                ->where('slug', $slug)
                ->update([
                    'special_sections' => json_encode(['clearance']),
                    'sale_price'       => $salePrice,
                ]);
        }
    }

    public function down(): void
    {
        // No-op: don't blindly wipe tags/prices an admin may have since edited.
    }
};
