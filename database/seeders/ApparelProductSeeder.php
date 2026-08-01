<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Realistic catalog for the apparel category tree (see the
 * replace_categories_with_apparel_taxonomy migration). Complements the
 * starter catalog seeded by the seed_starter_apparel_products migration
 * with a wider product spread plus size/color variants. Thumbnails/gallery
 * use the stock Unsplash photography already bundled under
 * public/frontend/products/unsplash — generic but real product-style shots
 * (garment on white/plain background) rather than the SVG placeholders,
 * rotated across products of the same type. Swap in real photography per
 * SKU as it becomes available.
 */
class ApparelProductSeeder extends Seeder
{
    public function run(): void
    {
        $base = 'frontend/products/unsplash/';

        // Only Unsplash photos that are unambiguously a top / bottom / shoe
        // product shot (watches, headphones, a backpack were excluded).
        $topImages = array_map(fn ($f) => $base . $f, [
            'unsplash-1445205170230-053b83016050.jpg', // sweaters on a shop rack
            'unsplash-1503341504253-dff4815485f1.jpg', // graphic tee, male model
            'unsplash-1512436991641-6745cdb1723f.jpg', // clothing rack, mixed tops
            'unsplash-1517841905240-472988babdf9.jpg', // denim jacket over hoodie
            'unsplash-1521572163474-6864f9cf17ab.jpg', // plain white tee, male model
            'unsplash-1523381210434-271e8be1f52b.jpg', // t-shirts on hangers
            'unsplash-1526720568277-267ff662958c.jpg', // knit sweater, female model
            'unsplash-1583744946564-b52ac1c389c8.jpg', // graphic tee, female model
            'unsplash-1602810318383-e386cc2a3ccf.jpg', // folded formal shirts
            'unsplash-1622445275463-afa2ab738c34.jpg', // white tee + cap, male model
        ]);
        $bottomImages = array_map(fn ($f) => $base . $f, [
            'unsplash-1515886657613-9f3515b0c78f.jpg', // sweatpants, male model
            'unsplash-1556905055-8f358a7a47b2.jpg', // folded jeans flat lay
        ]);
        $shoeImages = array_map(fn ($f) => $base . $f, [
            'unsplash-1491553895911-0055eca6402d.jpg', // black running shoe
            'unsplash-1542291026-7eec264c27ff.jpg', // red/maroon running shoe
            'unsplash-1560343090-f0409e92791a.jpg', // teal suede oxford
            'unsplash-1608231387042-66d1773070a5.jpg', // white sneaker
        ]);

        $topSizes    = ['S', 'M', 'L', 'XL', 'XXL'];
        $bottomSizes = ['28', '30', '32', '34', '36', '38'];
        $shoeSizes   = ['39', '40', '41', '42', '43', '44'];

        $colorHex = [
            'Black'  => '#111111',
            'White'  => '#f8fafc',
            'Navy'   => '#1e293b',
            'Grey'   => '#9ca3af',
            'Maroon' => '#7f1d1d',
            'Olive'  => '#4d7c0f',
            'Khaki'  => '#d2b48c',
            'Beige'  => '#e7d9c3',
            'Blue'   => '#2563eb',
            'Brown'  => '#5b3a29',
        ];
        $colorNames = array_keys($colorHex);

        $fashionBrands = ["Nike", "Adidas", "Puma", "Lee Cooper", "Levi's", "H&M", "Zara"];
        $shoeBrands     = ['Nike', 'Adidas', 'Puma', 'Bata', 'Apex', 'Reebok', 'Lotto'];

        // category slug => [type, sku prefix, [[name, price, short desc], ...]]
        $catalog = [
            't-shirt' => ['top', 'TSH', [
                ['V-Neck Basic T-Shirt', 480, 'Soft cotton v-neck tee for daily wear.'],
                ['Long Sleeve T-Shirt', 580, 'Full-sleeve cotton tee with ribbed cuffs.'],
                ['Striped Cotton T-Shirt', 520, 'Horizontal striped tee in breathable cotton.'],
            ]],
            'polo-t-shirt' => ['top', 'POL', [
                ['Striped Polo Shirt', 700, 'Pique polo with contrast stripe detailing.'],
                ['Half Sleeve Polo Shirt', 680, 'Classic half-sleeve polo with ribbed collar.'],
                ['Premium Cotton Polo Shirt', 820, 'Premium combed cotton polo, tailored fit.'],
            ]],
            'shirt' => ['top', 'SHR', [
                ['Denim Casual Shirt', 980, 'Lightweight denim shirt with button-down collar.'],
                ['Printed Casual Shirt', 780, 'All-over printed casual shirt, relaxed fit.'],
                ['Linen Blend Shirt', 1050, 'Breathable linen-cotton blend shirt for summer.'],
            ]],
            'boxy-shirt' => ['top', 'BXS', [
                ['Boxy Overshirt', 850, 'Structured boxy overshirt with dropped shoulder.'],
                ['Boxy Fit Printed Shirt', 750, 'Relaxed boxy shirt with placement print.'],
                ['Boxy Corduroy Shirt', 980, 'Boxy-cut corduroy shirt with patch pockets.'],
            ]],
            'jeans' => ['bottom', 'JNS', [
                ['Skinny Fit Jeans', 1500, 'Stretch skinny denim, tapered from knee to ankle.'],
                ['Regular Fit Jeans', 1400, 'Comfort stretch denim, regular through hip and thigh.'],
                ['Distressed Jeans', 1600, 'Slim fit denim with light distressing.'],
            ]],
            'baggy-jeans' => ['bottom', 'BGJ', [
                ['Oversized Baggy Jeans', 1700, 'Extra-loose baggy denim with a dropped crotch.'],
                ['Baggy Jeans with Patchwork', 1750, 'Baggy fit denim with patchwork detailing.'],
                ['Washed Baggy Jeans', 1650, 'Stonewashed baggy denim, wide leg opening.'],
            ]],
            'semi-baggy-jeans' => ['bottom', 'SBJ', [
                ['Semi Baggy Ripped Jeans', 1550, 'Semi-loose denim with knee rips.'],
                ['Semi Baggy Cargo Jeans', 1600, 'Semi baggy denim with utility side pockets.'],
                ['Semi Baggy Ankle Jeans', 1500, 'Semi-loose fit denim, cropped ankle length.'],
            ]],
            'cargo-pant' => ['bottom', 'CRG', [
                ['Six Pocket Cargo Pant', 1300, 'Cotton cargo pant with six utility pockets.'],
                ['Jogger Cargo Pant', 1250, 'Cargo pant with jogger-style elastic hem.'],
                ['Relaxed Cargo Pant', 1350, 'Relaxed-fit cargo pant in ripstop cotton.'],
            ]],
            'formal-pant' => ['bottom', 'FRP', [
                ['Pleated Formal Pant', 1150, 'Pleated-front formal trouser, classic fit.'],
                ['Slim Taper Formal Pant', 1200, 'Slim taper formal pant in wrinkle-resist fabric.'],
                ['Formal Pant with Stretch', 1100, 'Comfort-stretch formal trouser for all-day wear.'],
            ]],
            'chino-pant' => ['bottom', 'CHN', [
                ['Slim Taper Chino Pant', 1100, 'Slim taper chino in soft cotton twill.'],
                ['Relaxed Fit Chino Pant', 1000, 'Relaxed chino pant for casual comfort.'],
                ['Stretch Chino Pant', 1150, 'Stretch-cotton chino, tailored through the seat.'],
            ]],
            'shorts' => ['bottom', 'SHT', [
                ['Denim Shorts', 700, 'Classic denim shorts, mid-thigh length.'],
                ['Chino Shorts', 600, 'Tailored chino shorts for smart-casual wear.'],
                ['Sweat Shorts', 550, 'Soft fleece sweat shorts with drawstring waist.'],
            ]],
            'sneakers' => ['shoe', 'SNK', [
                ['Retro Low-Top Sneakers', 2000, 'Retro-inspired low-top sneakers, cushioned sole.'],
                ['High-Top Sneakers', 2200, 'High-top sneakers with padded ankle collar.'],
                ['Knit Upper Sneakers', 2100, 'Breathable knit-upper sneakers, lightweight sole.'],
            ]],
            'formal-shoes' => ['shoe', 'FSH', [
                ['Derby Formal Shoes', 3000, 'Classic leather Derby shoes with stitched welt.'],
                ['Monk Strap Formal Shoes', 3300, 'Single monk strap leather formal shoes.'],
                ['Brogue Formal Shoes', 3100, 'Wingtip brogue detailing in polished leather.'],
            ]],
            'boots' => ['shoe', 'BOT', [
                ['Leather Ankle Boots', 3000, 'Genuine leather ankle boots, rubber sole.'],
                ['Desert Boots', 2700, 'Suede desert boots with a crepe sole.'],
                ['Work Boots', 3200, 'Heavy-duty leather work boots, reinforced toe.'],
            ]],
            'slides' => ['shoe', 'SLD', [
                ['Slide Sandals', 500, 'Molded EVA slide sandals with a textured footbed.'],
                ['Two-Strap Slides', 480, 'Adjustable two-strap slide sandals.'],
                ['Sport Slides Pro', 600, 'Cushioned sport slides for post-training recovery.'],
            ]],
            'slippers' => ['shoe', 'SLP', [
                ['Flip Flop Slippers', 300, 'Lightweight rubber flip-flop slippers.'],
                ['Cushioned House Slippers', 400, 'Soft cushioned slippers for indoor comfort.'],
                ['Textured Sole Slippers', 380, 'Anti-slip textured sole slippers.'],
            ]],
            'running-shoes' => ['shoe', 'RUN', [
                ['Cushioned Running Shoes', 2300, 'Extra-cushioned running shoe for long distances.'],
                ['Trail Running Shoes', 2500, 'Grippy outsole trail running shoe.'],
                ['Everyday Running Shoes', 1900, 'Versatile running shoe for daily training.'],
            ]],
            'sports-shoes' => ['shoe', 'SPT', [
                ['Basketball Sports Shoes', 2400, 'High-top basketball shoe with ankle support.'],
                ['Gym Training Shoes', 2000, 'Stable flat-sole shoe for gym training.'],
                ['Outdoor Sports Shoes', 2100, 'Rugged outdoor sports shoe with grip outsole.'],
            ]],
            'loafers' => ['shoe', 'LOF', [
                ['Tassel Loafers', 2500, 'Leather loafers with tassel detailing.'],
                ['Horsebit Loafers', 2700, 'Classic horsebit-buckle leather loafers.'],
                ['Casual Suede Loafers', 2300, 'Soft suede loafers for smart-casual wear.'],
            ]],
        ];

        $brands     = Brand::pluck('id', 'name');
        $unitId     = Unit::where('name', 'Piece')->value('id') ?? Unit::value('id');
        $supplierIds = Supplier::pluck('id')->all();
        $warehouseIds = Warehouse::pluck('id')->all();

        $idx = 0;
        $created = 0;
        $skippedCategories = [];

        foreach ($catalog as $categorySlug => [$type, $skuPrefix, $items]) {
            $categoryId = Category::where('slug', $categorySlug)->value('id');
            if (! $categoryId) {
                $skippedCategories[] = $categorySlug;
                continue;
            }

            $sizes      = match ($type) {
                'top'    => $topSizes,
                'bottom' => $bottomSizes,
                default  => $shoeSizes,
            };
            $imagePool  = match ($type) {
                'top'    => $topImages,
                'bottom' => $bottomImages,
                default  => $shoeImages,
            };
            $brandPool  = $type === 'shoe' ? $shoeBrands : $fashionBrands;

            foreach ($items as [$name, $price, $shortDesc]) {
                $idx++;

                $brandId = null;
                foreach ($brandPool as $bName) {
                    if (isset($brands[$bName])) {
                        $brandId = $brands[$bName];
                        break;
                    }
                }

                $productColors = collect($colorNames)->shuffle()->take(2)->values();
                $sku  = 'RVX-' . $skuPrefix . '-' . str_pad((string) $idx, 4, '0', STR_PAD_LEFT);
                $slug = Str::slug($name) . '-' . $idx;

                // Rotate through the type's photo pool per product, pairing each
                // gallery shot with one of the product's two assigned colors.
                $thumbnail = $imagePool[$idx % count($imagePool)];
                $galleryImages = collect($imagePool)->shuffle()->take($productColors->count());
                $gallery = $productColors->values()->map(fn ($c, $i) => [
                    'path'  => $galleryImages[$i] ?? $thumbnail,
                    'color' => $colorHex[$c],
                ])->all();

                // Build variants first so product stock can mirror their total.
                $variants = [];
                $sortOrder = 0;
                foreach ($productColors as $color) {
                    foreach ($sizes as $size) {
                        $variants[] = [
                            'size'       => $size,
                            'color'      => $color,
                            'stock'      => rand(5, 25),
                            'sku'        => $sku . '-' . $size . '-' . strtoupper(substr($color, 0, 3)),
                            'sort_order' => $sortOrder++,
                        ];
                    }
                }
                $totalStock = array_sum(array_column($variants, 'stock'));

                $hasSale   = rand(1, 100) <= 25;
                $salePrice = $hasSale ? round($price * 0.85, 2) : null;

                $product = Product::updateOrCreate(
                    ['sku' => $sku],
                    [
                        'name'              => $name,
                        'slug'              => $slug,
                        'category_id'       => $categoryId,
                        'brand_id'          => $brandId,
                        'unit_id'           => $unitId,
                        'supplier_id'       => $supplierIds ? $supplierIds[($idx - 1) % count($supplierIds)] : null,
                        'type'              => 'physical',
                        'barcode'           => '8802' . str_pad((string) $idx, 9, '0', STR_PAD_LEFT),
                        'purchase_price'    => round($price * 0.6, 2),
                        'selling_price'     => $price,
                        'sale_price'        => $salePrice,
                        'stock'             => $totalStock,
                        'alert_quantity'    => 10,
                        'short_description' => $shortDesc,
                        'description'       => $shortDesc,
                        'long_description'  => '<p>' . $shortDesc . '</p><p>Available in multiple sizes and colors. Cash on Delivery available across Bangladesh.</p>',
                        'thumbnail'         => $thumbnail,
                        'gallery'           => $gallery,
                        'publish_status'    => 'published',
                        'special_sections'  => rand(1, 100) <= 20
                            ? [array_rand(Product::SPECIAL_SECTIONS)]
                            : null,
                    ]
                );

                $product->variants()->delete();
                foreach ($variants as $v) {
                    ProductVariant::create($v + ['product_id' => $product->id]);
                }

                if (count($warehouseIds) >= 2) {
                    $w1 = $warehouseIds[($idx - 1) % count($warehouseIds)];
                    $w2 = $warehouseIds[$idx % count($warehouseIds)];
                    $product->warehouses()->syncWithoutDetaching([
                        $w1 => ['stock' => intval($totalStock * 0.6)],
                        $w2 => ['stock' => intval($totalStock * 0.4)],
                    ]);
                } elseif (count($warehouseIds) === 1) {
                    $product->warehouses()->syncWithoutDetaching([
                        $warehouseIds[0] => ['stock' => $totalStock],
                    ]);
                }

                $created++;
            }
        }

        if ($skippedCategories) {
            $this->command->warn('Skipped (category not found): ' . implode(', ', $skippedCategories));
        }

        $this->command->info("Apparel products seeded: {$created} products.");
    }
}
