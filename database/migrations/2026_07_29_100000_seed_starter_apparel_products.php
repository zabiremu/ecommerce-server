<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Starter catalog so the new apparel category tree isn't empty. Names,
 * prices (BDT), and descriptions are realistic placeholders the owner
 * is expected to replace with real inventory/photos — thumbnails point
 * at a generic "photo coming soon" illustration, not real product shots.
 * Skipped "Special Sections" categories (New Arrival, Best Seller, etc.)
 * on purpose: those are meant to be computed dynamically (see $isNew /
 * $isBestSeller in product-card.blade.php), not manually assigned —
 * a product can only sit in one category via category_id, so it can't
 * be both e.g. "Jeans" and "Flash Sale" under the current schema.
 */
return new class extends Migration
{
    public function up(): void
    {
        $shirtImg = 'frontend/products/placeholders/shirt.svg';
        $pantsImg = 'frontend/products/placeholders/pants.svg';
        $shoeImg  = 'frontend/products/placeholders/shoe.svg';

        $catalog = [
            't-shirt' => [$shirtImg, 'TSH', [
                ['Classic Crew Neck T-Shirt', 450, 'Everyday 100% cotton crew neck tee, breathable and pre-shrunk.'],
                ['Graphic Print T-Shirt', 550, 'Cotton tee with a printed front graphic, regular fit.'],
            ]],
            'polo-t-shirt' => [$shirtImg, 'POL', [
                ['Classic Pique Polo Shirt', 650, 'Pique cotton polo with ribbed collar and two-button placket.'],
                ['Slim Fit Polo Shirt', 750, 'Slim-cut polo in soft cotton blend, tapered through the body.'],
            ]],
            'shirt' => [$shirtImg, 'SHR', [
                ['Formal Cotton Shirt', 950, 'Crisp cotton formal shirt, spread collar, tailored fit.'],
                ['Casual Check Shirt', 850, 'Brushed cotton check shirt for everyday wear.'],
            ]],
            'boxy-shirt' => [$shirtImg, 'BXS', [
                ['Oversized Boxy Shirt', 700, 'Boxy, drop-shoulder silhouette in soft cotton.'],
                ['Boxy Fit Denim Shirt', 900, 'Relaxed boxy shirt in lightweight denim.'],
            ]],
            'jeans' => [$pantsImg, 'JNS', [
                ['Slim Fit Jeans', 1450, 'Stretch denim jeans, slim through hip and thigh.'],
                ['Straight Fit Jeans', 1350, 'Classic straight-leg denim in mid-wash.'],
            ]],
            'baggy-jeans' => [$pantsImg, 'BGJ', [
                ['Relaxed Baggy Jeans', 1550, 'Loose, relaxed-fit denim with a dropped seat.'],
                ['Wide Leg Baggy Jeans', 1650, 'Wide-leg baggy denim, roomy from hip to hem.'],
            ]],
            'semi-baggy-jeans' => [$pantsImg, 'SBJ', [
                ['Semi Baggy Fit Jeans', 1500, 'Relaxed through the thigh, tapered towards the ankle.'],
                ['Tapered Semi Baggy Jeans', 1450, 'Semi-loose fit denim with a tapered leg opening.'],
            ]],
            'cargo-pant' => [$pantsImg, 'CRG', [
                ['Multi-Pocket Cargo Pant', 1250, 'Cotton cargo pant with side utility pockets.'],
                ['Slim Cargo Pant', 1150, 'Slimmer-cut cargo pant, tapered leg.'],
            ]],
            'formal-pant' => [$pantsImg, 'FRP', [
                ['Slim Fit Formal Pant', 1100, 'Tailored formal trouser in a smooth weave.'],
                ['Regular Fit Formal Pant', 1000, 'Classic regular-fit formal trouser.'],
            ]],
            'chino-pant' => [$pantsImg, 'CHN', [
                ['Classic Chino Pant', 1050, 'Everyday cotton chino, regular fit.'],
                ['Slim Fit Chino Pant', 1150, 'Slim-cut chino in stretch cotton twill.'],
            ]],
            'shorts' => [$pantsImg, 'SHT', [
                ['Casual Cotton Shorts', 550, 'Lightweight cotton shorts for warm weather.'],
                ['Cargo Shorts', 650, 'Cargo-style shorts with side pockets.'],
            ]],
            'sneakers' => [$shoeImg, 'SNK', [
                ['Classic Canvas Sneakers', 1800, 'Everyday canvas sneakers with rubber sole.'],
                ['Chunky Sole Sneakers', 2400, 'Chunky-sole sneakers with cushioned footbed.'],
            ]],
            'formal-shoes' => [$shoeImg, 'FSH', [
                ['Leather Formal Shoes', 2800, 'Genuine leather formal shoes, cushioned insole.'],
                ['Oxford Formal Shoes', 3200, 'Classic Oxford lace-up in polished leather.'],
            ]],
            'boots' => [$shoeImg, 'BOT', [
                ['Chukka Boots', 2600, 'Ankle-height suede chukka boots.'],
                ['Combat Boots', 2900, 'Durable lace-up combat boots.'],
            ]],
            'slides' => [$shoeImg, 'SLD', [
                ['Sport Slides', 550, 'Adjustable-strap sport slides with contoured footbed.'],
                ['Comfort Slides', 450, 'Soft EVA slides for everyday comfort.'],
            ]],
            'slippers' => [$shoeImg, 'SLP', [
                ['Everyday Slippers', 350, 'Lightweight indoor/outdoor slippers.'],
                ['Memory Foam Slippers', 450, 'Cushioned memory-foam slippers.'],
            ]],
            'running-shoes' => [$shoeImg, 'RUN', [
                ['Lightweight Running Shoes', 2200, 'Breathable mesh upper, cushioned midsole.'],
                ['Breathable Mesh Running Shoes', 2000, 'Knit mesh running shoe built for daily miles.'],
            ]],
            'sports-shoes' => [$shoeImg, 'SPT', [
                ['Training Sports Shoes', 2100, 'All-purpose training shoe with grippy outsole.'],
                ['All-Court Sports Shoes', 1900, 'Court shoe built for lateral support.'],
            ]],
            'loafers' => [$shoeImg, 'LOF', [
                ['Classic Leather Loafers', 2400, 'Slip-on leather loafers, stitched sole.'],
                ['Suede Loafers', 2600, 'Soft suede loafers with penny strap.'],
            ]],
        ];

        $now = now();
        $idx = 0;

        foreach ($catalog as $categorySlug => [$image, $skuPrefix, $products]) {
            $categoryId = DB::table('categories')->where('slug', $categorySlug)->value('id');
            if (! $categoryId) {
                continue;
            }

            foreach ($products as [$name, $price, $shortDesc]) {
                $idx++;
                $slug = Str::slug($name) . '-' . $idx;

                DB::table('products')->insert([
                    'name'               => $name,
                    'slug'               => $slug,
                    'category_id'        => $categoryId,
                    'type'               => 'physical',
                    'sku'                => $skuPrefix . '-' . str_pad($idx, 4, '0', STR_PAD_LEFT),
                    'purchase_price'     => round($price * 0.62, 2),
                    'selling_price'      => $price,
                    'stock'              => rand(15, 60),
                    'alert_quantity'     => 10,
                    'short_description'  => $shortDesc,
                    'description'        => $shortDesc . ' Starter catalog item — replace with real product photos and copy.',
                    'thumbnail'          => $image,
                    'gallery'            => json_encode([]),
                    'publish_status'     => 'published',
                    'created_at'         => $now,
                    'updated_at'         => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        // Intentionally left as a no-op: by the time a rollback is considered,
        // an admin may have already edited these rows, added real photos, or
        // taken orders against them, so blindly deleting here would be unsafe.
    }
};
