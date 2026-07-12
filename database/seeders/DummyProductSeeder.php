<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DummyProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::where('status', true)->get();

        if ($categories->isEmpty()) {
            $this->command->warn('No categories found. Run CategorySeeder first.');
            return;
        }

        // Woodmart demo images already present in public/frontend
        $images = [
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-2-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-3-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/alex-minecraft-figure-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/alex-minecraft-figure-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-tshirt-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-tshirt-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/back-to-the-future-enamel-pin-badge-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/back-to-the-future-enamel-pin-badge-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/back-to-the-future-poster-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/back-to-the-future-poster-2-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/back-to-the-future-poster-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/back-to-the-future-tshirt-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/back-to-the-future-tshirt-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/borderlands-bucket-hat-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/borderlands-bucket-hat-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/borderlands-stickers-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/borderlands-stickers-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/cartoon-spiderman-stickers-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/cartoon-spiderman-stickers-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/charmander-figure-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/charmander-figure-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/chicken-plush-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/chicken-plush-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/ciri-plush-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/ciri-plush-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/claptrap-plush-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/claptrap-plush-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/companion-cube-plush-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/companion-cube-plush-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/concept-series-stormtrooper-figure-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/concept-series-stormtrooper-figure-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/dogpool-plush-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/dogpool-plush-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/dune-desert-mouse-plush-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/dune-desert-mouse-plush-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/dune-sun-cap-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/dune-sun-cap-600x686.jpeg',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/frodo-baggins-figure-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/frodo-baggins-figure-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/god-of-war-logo-blue-cap-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/god-of-war-logo-blue-cap-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/grogu-plush-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/grogu-plush-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/jinx-monkey-graffiti-sweatshirt-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/jinx-monkey-graffiti-sweatshirt-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/level-up-mushroom-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/level-up-mushroom-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/liara-plush-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/liara-plush-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/marty-mcfly-figure-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/marty-mcfly-figure-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/minecraft--4-pack-pins-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/minecraft--4-pack-pins-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/minecraft-creeper-vinyl-figure-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/minecraft-creeper-vinyl-figure-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/pig-unisex-tshirt-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/pig-unisex-tshirt-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/pixel-axolotl-cap-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/pixel-axolotl-cap-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/plush-traveling-korok-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/plush-traveling-korok-600x686.jpeg',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/red-dead-redemption-2-art-poster-2-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/super-mario-figures-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/super-mario-figures-600x686.jpeg',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/vault-boy-plush-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/vault-boy-plush-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/yoshi-plush-1-600x686.jpeg.webp',
            'frontend/merchandise/wp-content/uploads/sites/31/2025/11/yoshi-plush-600x686.jpeg.webp',

            // Random Unsplash stock photos
            'frontend/products/unsplash/unsplash-1521572163474-6864f9cf17ab.jpg',
            'frontend/products/unsplash/unsplash-1523275335684-37898b6baf30.jpg',
            'frontend/products/unsplash/unsplash-1542291026-7eec264c27ff.jpg',
            'frontend/products/unsplash/unsplash-1523381210434-271e8be1f52b.jpg',
            'frontend/products/unsplash/unsplash-1505740420928-5e560c06d30e.jpg',
            'frontend/products/unsplash/unsplash-1517841905240-472988babdf9.jpg',
            'frontend/products/unsplash/unsplash-1546868871-7041f2a55e12.jpg',
            'frontend/products/unsplash/unsplash-1491553895911-0055eca6402d.jpg',
            'frontend/products/unsplash/unsplash-1560343090-f0409e92791a.jpg',
            'frontend/products/unsplash/unsplash-1556905055-8f358a7a47b2.jpg',
            'frontend/products/unsplash/unsplash-1445205170230-053b83016050.jpg',
            'frontend/products/unsplash/unsplash-1434056886845-dac89ffe9b56.jpg',
            'frontend/products/unsplash/unsplash-1503341504253-dff4815485f1.jpg',
            'frontend/products/unsplash/unsplash-1602810318383-e386cc2a3ccf.jpg',
            'frontend/products/unsplash/unsplash-1512436991641-6745cdb1723f.jpg',
            'frontend/products/unsplash/unsplash-1622560480605-d83c853bc5c3.jpg',
            'frontend/products/unsplash/unsplash-1583744946564-b52ac1c389c8.jpg',
            'frontend/products/unsplash/unsplash-1608231387042-66d1773070a5.jpg',
        ];

        // Frontend images live in public/, but the app serves product images via the
        // 'public' storage disk (Storage::url()). Copy each into storage/app/public
        // so the same paths that other seeded data (and the admin uploader) produce work here too.
        $images = array_map(function (string $publicPath) {
            $storagePath = 'products/dummy/' . basename($publicPath);

            if (! Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->put($storagePath, file_get_contents(public_path($publicPath)));
            }

            return $storagePath;
        }, $images);

        // 8 dummy products per category
        $templates = [
            ['%s T-Shirt',           350,  550,  280,  true],
            ['%s Hoodie',            750, 1100,  200,  true],
            ['%s Poster (A3)',       250,  400,  500,  false],
            ['%s Enamel Pin',        180,  280,  800,  false],
            ['%s Vinyl Figure',     1200, 1800,  120,  false],
            ['%s Sticker Pack',     150,  220,  1000,  false],
            ['%s Plush Toy',         950, 1400,  150,  true],
            ['%s Collector\'s Mug',  380,  580,  300,  false],
        ];

        $shortDescs = [
            'High quality merchandise for true fans. Limited edition.',
            'Official licensed product — premium materials and vibrant print.',
            'Perfect gift for collectors and enthusiasts.',
            'Comfortable, stylish, and fan-approved.',
            'Best-in-class quality at an unbeatable price.',
        ];

        $idx         = 0;
        $totalImages = count($images);
        $totalProducts = count($categories) * count($templates);

        foreach ($categories as $cat) {
            foreach ($templates as $tpl) {
                [$namePattern, $price, $oldPrice, $stock, $hasSale] = $tpl;
                $idx++;

                $name      = sprintf($namePattern, $cat->name);
                $slug      = Str::slug($name) . '-' . $idx;
                $base      = (int) floor(($idx - 1) * $totalImages / $totalProducts);
                $imgPath   = $images[$base % $totalImages];
                $salePrice = $hasSale ? round($price * 0.85) : null;

                $gallery = [];
                for ($g = 0; $g < 4; $g++) {
                    $gallery[] = $images[($base + $g) % $totalImages];
                }

                Product::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'name'              => $name,
                        'sku'               => 'DUM-' . strtoupper(Str::random(6)),
                        'category_id'       => $cat->id,
                        'type'              => 'physical',
                        'barcode'           => '8801' . str_pad($idx, 9, '0', STR_PAD_LEFT),
                        'purchase_price'    => round($price * 0.65, 2),
                        'selling_price'     => $price,
                        'sale_price'        => $salePrice,
                        'stock'             => $stock,
                        'alert_quantity'    => 10,
                        'short_description' => $shortDescs[$idx % count($shortDescs)],
                        'description'       => "{$name} — premium quality merchandise.",
                        'thumbnail'         => $imgPath,
                        'gallery'           => $gallery,
                        'publish_status'    => 'published',
                    ]
                );
            }
        }

        $this->command->info("Dummy products seeded: {$idx} products across {$categories->count()} categories.");
    }
}
