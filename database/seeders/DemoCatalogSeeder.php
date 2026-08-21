<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Opt-in demo catalog (categories + starter products) for local testing.
 * Only runs via `php artisan db:seed` — `migrate:fresh` alone never
 * touches this data, so a fresh install starts with an empty catalog.
 */
class DemoCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedCategories();
        $this->seedStarterProducts();
        $this->addLongDescriptions();
        $this->tagSpecialSections();

        $this->command->info('Demo catalog (categories + starter products) seeded.');
    }

    private function seedCategories(): void
    {
        $apparel = [
            ['T-Shirt',           'fas fa-shirt'],
            ['Polo T-Shirt',      'fas fa-shirt'],
            ['Shirt',             'fas fa-shirt'],
            ['Boxy Shirt',        'fas fa-shirt'],
            ['Jeans',             'fas fa-vest'],
            ['Baggy Jeans',       'fas fa-vest'],
            ['Semi Baggy Jeans',  'fas fa-vest'],
            ['Cargo Pant',        'fas fa-vest'],
            ['Formal Pant',       'fas fa-vest'],
            ['Chino Pant',        'fas fa-vest'],
            ['Shorts',            'fas fa-vest'],
        ];

        $footwearChildren = [
            ['Sneakers',      'fas fa-shoe-prints'],
            ['Formal Shoes',  'fas fa-shoe-prints'],
            ['Boots',         'fas fa-shoe-prints'],
            ['Slides',        'fas fa-shoe-prints'],
            ['Slippers',      'fas fa-shoe-prints'],
            ['Running Shoes', 'fas fa-person-running'],
            ['Sports Shoes',  'fas fa-dumbbell'],
            ['Loafers',       'fas fa-shoe-prints'],
        ];

        $specialChildren = [
            ['New Arrival',        'fas fa-fire-flame-curved'],
            ['Best Seller',        'fas fa-star'],
            ['Premium Collection', 'fas fa-gem'],
            ['Flash Sale',         'fas fa-bolt'],
            ['Combo Offer',        'fas fa-gift'],
            ['Restock',            'fas fa-rotate-left'],
            ['Clearance',          'fas fa-tags'],
        ];

        $order = 0;
        $upsertTopLevel = function (string $name, string $icon, bool $homeVisible) use (&$order) {
            $slug = Str::slug($name);
            DB::table('categories')->updateOrInsert(
                ['slug' => $slug],
                [
                    'name'         => $name,
                    'icon'         => $icon,
                    'parent_id'    => null,
                    'status'       => true,
                    'home_visible' => $homeVisible,
                    'home_order'   => $order++,
                    'updated_at'   => now(),
                    'created_at'   => now(),
                ]
            );
            return DB::table('categories')->where('slug', $slug)->value('id');
        };

        foreach ($apparel as [$name, $icon]) {
            $upsertTopLevel($name, $icon, true);
        }

        $footwearId = $upsertTopLevel('Footwear', 'fas fa-shoe-prints', true);
        foreach ($footwearChildren as [$name, $icon]) {
            DB::table('categories')->updateOrInsert(
                ['slug' => Str::slug($name)],
                [
                    'name'         => $name,
                    'icon'         => $icon,
                    'parent_id'    => $footwearId,
                    'status'       => true,
                    'home_visible' => false,
                    'home_order'   => 0,
                    'updated_at'   => now(),
                    'created_at'   => now(),
                ]
            );
        }

        $specialId = $upsertTopLevel('Special Sections', 'fas fa-star', true);
        foreach ($specialChildren as [$name, $icon]) {
            DB::table('categories')->updateOrInsert(
                ['slug' => Str::slug($name)],
                [
                    'name'         => $name,
                    'icon'         => $icon,
                    'parent_id'    => $specialId,
                    'status'       => true,
                    'home_visible' => false,
                    'home_order'   => 0,
                    'updated_at'   => now(),
                    'created_at'   => now(),
                ]
            );
        }
    }

    private function seedStarterProducts(): void
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

        $idx = 0;

        foreach ($catalog as $categorySlug => [$image, $skuPrefix, $products]) {
            $categoryId = DB::table('categories')->where('slug', $categorySlug)->value('id');
            if (! $categoryId) {
                continue;
            }

            foreach ($products as [$name, $price, $shortDesc]) {
                $idx++;
                $slug = Str::slug($name) . '-' . $idx;

                DB::table('products')->updateOrInsert(
                    ['slug' => $slug],
                    [
                        'name'               => $name,
                        'category_id'        => $categoryId,
                        'type'               => 'physical',
                        'sku'                => $skuPrefix . '-' . str_pad((string) $idx, 4, '0', STR_PAD_LEFT),
                        'purchase_price'     => round($price * 0.62, 2),
                        'selling_price'      => $price,
                        'stock'              => rand(15, 60),
                        'alert_quantity'     => 10,
                        'short_description'  => $shortDesc,
                        'description'        => $shortDesc . ' Starter catalog item — replace with real product photos and copy.',
                        'thumbnail'          => $image,
                        'gallery'            => json_encode([]),
                        'publish_status'     => 'published',
                        'updated_at'         => now(),
                        'created_at'         => now(),
                    ]
                );
            }
        }
    }

    private function addLongDescriptions(): void
    {
        $byCategory = [
            't-shirt' => "Made from soft, breathable cotton jersey for everyday comfort. Regular fit, crew neckline, true to size.\n\nCare: machine wash cold, tumble dry low, do not bleach.",
            'polo-t-shirt' => "Pique cotton knit with a ribbed collar and two-button placket for a smart-casual look. True to size.\n\nCare: machine wash cold, iron on low if needed.",
            'shirt' => "Woven cotton shirt with a clean, tailored finish — dresses up easily or wears open over a tee. True to size.\n\nCare: machine wash cold, iron on medium heat.",
            'boxy-shirt' => "Relaxed, drop-shoulder boxy fit in soft cotton. Runs slightly oversized — size down for a closer fit.\n\nCare: machine wash cold, tumble dry low.",
            'jeans' => "Stretch cotton denim with a comfortable, everyday fit through the hip and thigh. True to size.\n\nCare: machine wash cold inside-out, avoid tumble drying to preserve color.",
            'baggy-jeans' => "Loose, relaxed-through-the-seat denim with a dropped fit. Consider sizing down if you prefer less volume.\n\nCare: machine wash cold inside-out, line dry recommended.",
            'semi-baggy-jeans' => "Roomy through the thigh with a tapered leg opening — a middle ground between slim and baggy. True to size.\n\nCare: machine wash cold inside-out, line dry recommended.",
            'cargo-pant' => "Durable cotton cargo pant with side utility pockets. Regular fit through the leg. True to size.\n\nCare: machine wash cold, tumble dry low.",
            'formal-pant' => "Smooth-weave formal trouser with a tailored finish, suitable for office or formal wear. True to size.\n\nCare: dry clean recommended, or machine wash cold and iron on low.",
            'chino-pant' => "Classic cotton twill chino for everyday wear, smart enough for the office, casual enough for the weekend. True to size.\n\nCare: machine wash cold, tumble dry low.",
            'shorts' => "Lightweight cotton shorts built for warm-weather comfort. Regular fit. True to size.\n\nCare: machine wash cold, tumble dry low.",
            'sneakers' => "Everyday sneaker with a cushioned footbed and durable rubber outsole. True to size — order half a size up if between sizes.\n\nCare: spot clean with a damp cloth, air dry away from direct heat.",
            'formal-shoes' => "Leather formal shoe with a cushioned insole for all-day wear. True to size.\n\nCare: wipe clean and condition leather regularly, use a shoe tree to hold shape.",
            'boots' => "Sturdy lace-up boot built for durability and everyday wear. True to size — consider half a size up if you'll wear thick socks.\n\nCare: wipe clean, treat leather/suede with an appropriate protector.",
            'slides' => "Lightweight slide with an adjustable strap and contoured footbed for everyday comfort. True to size.\n\nCare: rinse with water, air dry.",
            'slippers' => "Soft, cushioned slipper for everyday indoor and outdoor comfort. True to size.\n\nCare: spot clean with a damp cloth.",
            'running-shoes' => "Breathable mesh upper with a cushioned midsole built for daily runs. True to size — order half a size up if between sizes.\n\nCare: spot clean, air dry away from direct heat.",
            'sports-shoes' => "All-purpose training shoe with a grippy outsole for lateral support. True to size.\n\nCare: spot clean, air dry away from direct heat.",
            'loafers' => "Slip-on loafer with a stitched sole, easy to dress up or down. True to size.\n\nCare: wipe clean and condition leather/suede regularly.",
        ];

        foreach ($byCategory as $slug => $longDescription) {
            $categoryId = DB::table('categories')->where('slug', $slug)->value('id');
            if (! $categoryId) {
                continue;
            }

            DB::table('products')
                ->where('category_id', $categoryId)
                ->whereNull('long_description')
                ->update(['long_description' => $longDescription, 'updated_at' => now()]);
        }
    }

    private function tagSpecialSections(): void
    {
        $tags = [
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
}
