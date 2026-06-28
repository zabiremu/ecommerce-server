<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Map frontend "cat" slug → seeded Category name
        $catMap = [
            'electronics' => 'Gadget & Electronics',
            'fashion'     => 'Fashion & Lifestyle',
            'beauty'      => 'Health & Beauty',
            'toys'        => 'Toys, Kids & Baby',
            'kitchen'     => 'Kitchen',
            'accessories' => 'Accessories',
            'fragrance'   => 'Attar & Fragrance',
            'cleaning'    => 'Cleaning Supplies',
            'sports'      => 'Sports & Fitness',
            'living'      => 'Home & Living',
        ];

        // Preload reference data
        $categories = Category::whereNull('parent_id')->pluck('id', 'name');
        $brands     = Brand::pluck('id', 'name')->all();
        $units      = Unit::pluck('id', 'name')->all();
        $suppliers  = Supplier::pluck('id')->all();
        $warehouses = Warehouse::pluck('id')->all();

        $pieceUnitId = $units['Piece'] ?? $units['Pcs'] ?? array_values($units)[0] ?? null;
        $setUnitId   = $units['Set'] ?? $pieceUnitId;
        $packUnitId  = $units['Pack'] ?? $pieceUnitId;
        $bottleUnitId = $units['Bottle'] ?? $pieceUnitId;

        // Brand pool by category for realistic assignment
        $brandPool = [
            'electronics' => ['Samsung', 'Xiaomi', 'Sony', 'JBL', 'Boat', 'Anker', 'Baseus', 'Havit', 'Remax'],
            'fashion'     => ['Nike', 'Adidas', 'Puma', 'Bata', 'Apex', "Levi's", 'H&M', 'Zara', 'Lee Cooper'],
            'beauty'      => ['Lakme', 'Maybelline', 'Loreal', 'Nivea', 'Olay', 'Garnier', 'Himalaya', 'Dove'],
            'toys'        => ['Lego', 'Funskool'],
            'kitchen'     => ['Tupperware', 'Prestige', 'Hawkins', 'Miyako', 'Vision', 'Walton'],
            'accessories' => ['Casio', 'Titan', 'Fossil', 'Ray-Ban'],
            'fragrance'   => ['Al Rehab', 'Ajmal', 'Lattafa', 'Surrati', 'Oudh Al Anfar'],
            'cleaning'    => [],
            'sports'      => ['Nike', 'Adidas', 'Puma', 'Reebok'],
            'living'      => ['IKEA', 'Walton', 'Vision'],
        ];

        $products = [
            [1,  '1762585385-WhatsApp-Image-2025-11-08-at-10.45.04_f0a7e1f0.jpg', 'Special Rose Ring Box', 550, 750, 482, 'accessories'],
            [2,  '1732256120-1722923632-9f23fb8d29c275908b09ae24abc420a8-(1).jpg', 'Salon Fashion Professional Round Hair Brush', 250, 450, 105, 'beauty'],
            [3,  '1752757286-1746524366-image.jpg', 'Adjustable Cabinet Storage Divider (6pcs)', 370, 800, 112, 'kitchen'],
            [4,  '1752845657-WhatsApp-Image-2025-07-18-at-19.28.56_de7b599b.jpg', 'Kemei Rechargeable Hair Trimmer KM-9050', 950, 1600, 103, 'electronics'],
            [5,  '1748236445-2025052312372083.jpg', '5in1 Qurbani Combo Set', 1500, 2100, 50, 'kitchen'],
            [6,  '1745127905-1745054742-WhatsApp-Image-2025-04-19-at-15.06.25_3141d73b.jpg', '6 Pcs Washable Refrigerator Mats', 420, 550, 103, 'kitchen'],
            [7,  '1767901143-1732250673-1716888039-Electric-hot-water-bag.jpg', 'Electric Hot Water Bag', 350, 550, 1247, 'beauty'],
            [8,  '1699887075-400410133_372083255474887_3250464805984629507_n.jpg', 'Vacuum Flask Set Drinking Water Bottle', 650, 1500, 106, 'kitchen'],
            [9,  '1752769883-WhatsApp-Image-2025-07-17-at-22.24.58_9939d163.jpg', 'SX21 Wireless Microphone', 1450, 2200, 103, 'electronics'],
            [10, '1752836546-WhatsApp-Image-2025-07-18-at-16.56.42_6e92568e.jpg', 'Q8SX22 Wireless Microphone', 1550, 2200, 103, 'electronics'],
            [11, '1752843619-WhatsApp-Image-2025-07-18-at-18.57.06_5f5aaa82.jpg', 'HTC AT-522 Beard Trimmer For Men', 830, 1200, 103, 'electronics'],
            [12, '1752763923-WhatsApp-Image-2025-07-17-at-20.42.51_e8735581.jpg', 'Zepter International 6pc Knife Set', 800, 1100, 106, 'kitchen'],
            [13, '1664913810-rsz_278049395_5265767843484332_2946839237932754640_n.jpg', 'Premium Leather Wallet', 450, 650, 200, 'fashion'],
            [14, '1723821353-1722686921-G63-Atmosphere-Bluetooth-Speaker-With-Wireless-Charging7896-(1).webp', 'G63 Atmosphere Bluetooth Speaker', 1800, 2800, 75, 'electronics'],
            [15, '1723986261-InShot_20221027_001338667.jpg', 'Kids Educational Learning Toy Set', 550, 800, 90, 'toys'],
            [16, '1724396249-1723972820-3eef9b79e21969e88b5aa77ba798d5db.jpg', 'Stainless Steel Kitchen Trolley', 2200, 3200, 45, 'kitchen'],
            [17, '1724397059-1723961756-179835208cb4a45701ed8a7fcf2f9c03.jpg', 'Multipurpose Storage Organizer', 380, 550, 160, 'kitchen'],
            [18, '1724410802-1723382164-7363010b8355354ab0f3d4115157a9e81.jpg', 'Smart Watch Fitness Tracker', 1200, 1800, 85, 'electronics'],
            [19, '1724488475-1722952599-aa7e3c8f5db344d5e66810bb3255a30c.jpg', 'USB Rechargeable LED Desk Lamp', 450, 700, 120, 'electronics'],
            [20, '1728914107-s-l1200.jpg', 'Wireless Earbuds TWS Bluetooth 5.3', 650, 1200, 200, 'electronics'],
            [21, '1729080562-9689659e68a235dbdb144b92949a951f.jpg_960x960q80.jpg_.webp', 'Men Casual Canvas Shoes', 850, 1300, 95, 'fashion'],
            [22, '1729084186-O1CN01F5I5hN2BfE1NYw3wI_2209546488365-0-cib-300x400.jpg', 'Women Handbag PU Leather', 650, 1100, 78, 'fashion'],
            [23, '1732013791-sellmart-72.jpg', 'Mosquito Killer Lamp USB', 320, 500, 150, 'electronics'],
            [24, '1732246930-1722924199-d4ab1c2b2d4443933edcc22b8515fa941.png', 'Kitchen Vegetable Chopper', 280, 450, 210, 'kitchen'],
            [25, '1732247909-1722753714-21488ddbaf07b2d0a5e70b770488ae45.jpg_750x750.jpg_.webp', 'Stainless Steel Water Bottle 500ml', 350, 550, 180, 'accessories'],
            [26, '1732248149-1722670806-sellmart_52.jpg', 'Multifunctional Car Phone Holder', 220, 350, 300, 'accessories'],
            [27, '1732258441-1716903735-T9-Trimmer-New0.jpg', 'T9 Professional Hair Trimmer', 750, 1200, 88, 'electronics'],
            [28, '1745394534-448fa603db362657e5c612eb6cdf768f.jpg_720x720q80.jpg', 'Men Cotton T-Shirt Round Neck', 320, 500, 250, 'fashion'],
            [29, '1747546216-1745316323-double-cooler-fan.jpg', 'Double Cooler Fan USB Rechargeable', 580, 900, 135, 'electronics'],
            [30, '1750488232-IMG_20250618_165217.jpg', 'Home Decor Wall Sticker Set', 180, 300, 400, 'accessories'],
            [31, '1750516002-IMG_20250621_202114.jpg', 'Scented Candle Gift Box Set', 320, 480, 110, 'fragrance'],
            [32, '1752759205-WhatsApp-Image-2025-07-17-at-19.24.34_411b18c8.jpg', 'Stainless Steel Spice Rack', 480, 780, 95, 'kitchen'],
            [33, '1752761888-WhatsApp-Image-2025-07-17-at-20.17.09_7b198abc.jpg', 'Adjustable Laptop Stand', 750, 1200, 145, 'electronics'],
            [34, '1752765296-WhatsApp-Image-2025-07-17-at-21.06.16_4affa092.jpg', 'Foldable Laundry Basket', 380, 550, 175, 'kitchen'],
            [35, '1752768244-WhatsApp-Image-2025-07-17-at-21.52.38_0e2155c5.jpg', 'Magnetic Phone Charger Stand', 520, 800, 130, 'electronics'],
            [36, '1752837422-WhatsApp-Image-2025-07-18-at-17.12.17_7a5317c2.jpg', 'Premium Stainless Steel Pan Set', 1800, 2700, 60, 'kitchen'],
            [37, '1752838450-WhatsApp-Image-2025-07-18-at-17.28.15_769c490e.jpg', 'Premium Designer Sunglasses', 850, 1300, 95, 'accessories'],
            [38, '1752841140-WhatsApp-Image-2025-07-18-at-18.12.50_7e09e0a3.jpg', 'Travel Toiletry Organizer Bag', 420, 650, 140, 'accessories'],
            [39, '1752850217-WhatsApp-Image-2025-07-18-at-19.51.06_38d36d65.jpg', 'Premium Body Spray for Men', 380, 600, 220, 'fragrance'],
            [40, '1752851303-WhatsApp-Image-2025-07-18-at-21.02.43_550712b1.jpg', 'Microfiber Cleaning Cloth (Pack of 10)', 250, 400, 350, 'cleaning'],
            [41, '1752852865-WhatsApp-Image-2025-07-18-at-21.26.13_0e0413de.jpg', 'Heavy Duty Floor Mop Set', 680, 1000, 85, 'cleaning'],
        ];

        $shortDesc = [
            'High quality, durable, and stylish — perfect for everyday use.',
            'Premium build with modern design, ideal gift for loved ones.',
            'Best-in-class performance at an unbeatable price point.',
            'Lightweight, ergonomic and built to last for years.',
            'Easy to use, smart features, customer favorite.',
        ];

        $longDesc = <<<HTML
<p>Experience top quality with this product, crafted to deliver outstanding performance and reliable everyday use. It features a modern design, premium materials, and is backed by a satisfaction guarantee.</p>
<ul>
    <li>Premium build quality</li>
    <li>Stylish and modern design</li>
    <li>Long-lasting durability</li>
    <li>Easy to use and maintain</li>
    <li>Cash on Delivery available across Bangladesh</li>
</ul>
<p>Order now and get fast delivery anywhere in Bangladesh. Pay only after you receive and inspect the product.</p>
HTML;

        // Build a pool of all product images for rotating gallery
        $imageDir = public_path('backend/assets/images/products');
        $allImages = [];
        if (is_dir($imageDir)) {
            foreach (scandir($imageDir) as $f) {
                if ($f === '.' || $f === '..') continue;
                $allImages[] = 'backend/assets/images/products/' . $f;
            }
        }

        $colorOptions = ['#000000', '#ffffff', '#ef4444', '#3b82f6', '#22c55e', '#facc15', '#a855f7', '#f97316', '#0ea5e9', '#ec4899'];

        $i = 0;
        foreach ($products as $p) {
            [$id, $img, $name, $cur, $old, $stock, $catKey] = $p;
            $i++;

            $categoryName = $catMap[$catKey] ?? 'Accessories';
            $categoryId = $categories[$categoryName] ?? $categories->first();

            // Pick random brand from category's pool
            $pool = $brandPool[$catKey] ?? [];
            $brandId = null;
            foreach ($pool as $bName) {
                if (isset($brands[$bName])) { $brandId = $brands[$bName]; break; }
            }
            if (!$brandId && !empty($pool)) {
                $brandId = $brands[$pool[array_rand($pool)]] ?? null;
            }

            // Pick unit based on product type
            $unitId = $pieceUnitId;
            if (Str::contains($name, ['Set', 'Combo', 'Pack'])) {
                $unitId = $setUnitId;
            } elseif (Str::contains($name, ['Bottle', 'Spray'])) {
                $unitId = $bottleUnitId;
            }

            $supplierId = $suppliers[($i - 1) % max(count($suppliers), 1)] ?? null;
            $sku = 'NFS-' . str_pad((string) $id, 5, '0', STR_PAD_LEFT);
            $barcode = '8801' . str_pad((string) $id, 9, '0', STR_PAD_LEFT);
            $thumbnail = 'backend/assets/images/products/' . $img;

            // Build gallery: thumbnail + 3 rotating images from the pool (skipping the thumb itself)
            $gallery = [['path' => $thumbnail, 'color' => $colorOptions[0]]];
            $poolSize = count($allImages);
            if ($poolSize > 1) {
                $extras = 0;
                $offset = ($i - 1) * 3;
                for ($k = 0; $k < $poolSize && $extras < 3; $k++) {
                    $candidate = $allImages[($offset + $k) % $poolSize];
                    if ($candidate === $thumbnail) continue;
                    $gallery[] = [
                        'path'  => $candidate,
                        'color' => $colorOptions[($extras + 1) % count($colorOptions)],
                    ];
                    $extras++;
                }
            }

            $product = Product::updateOrCreate(
                ['sku' => $sku],
                [
                    'name'              => $name,
                    'slug'              => Str::slug($name) . '-' . $id,
                    'category_id'       => $categoryId,
                    'brand_id'          => $brandId,
                    'unit_id'           => $unitId,
                    'supplier_id'       => $supplierId,
                    'type'              => 'physical',
                    'barcode'           => $barcode,
                    'purchase_price'    => round($cur * 0.72, 2),
                    'selling_price'     => $cur,
                    'stock'             => $stock,
                    'alert_quantity'    => 10,
                    'description'       => $name . ' — best quality at the best price in Bangladesh.',
                    'short_description' => $shortDesc[array_rand($shortDesc)],
                    'long_description'  => $longDesc,
                    'thumbnail'         => $thumbnail,
                    'gallery'           => $gallery,
                    'publish_status'    => 'published',
                ]
            );

            // Distribute stock across 2 warehouses
            if (count($warehouses) >= 2) {
                $w1 = $warehouses[($i - 1) % count($warehouses)];
                $w2 = $warehouses[$i % count($warehouses)];
                $product->warehouses()->syncWithoutDetaching([
                    $w1 => ['stock' => intval($stock * 0.6)],
                    $w2 => ['stock' => intval($stock * 0.4)],
                ]);
            }
        }

        $total = Product::count();
        $this->command->info("Products seeded successfully. Total: {$total}");
    }
}
