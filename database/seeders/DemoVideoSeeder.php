<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductLandingPage;
use App\Models\ProductWarehouse;
use App\Models\SiteSetting;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/**
 * Opt-in demo data used for recording the admin feature walkthrough videos.
 * Run after the catalog + inventory seeders:
 *   php artisan db:seed --class=DemoVideoSeeder
 *
 * Gives every admin screen real content: product photos, customers, online
 * orders in every status, stock transfers/adjustments, a landing page and
 * branding. It never calls third-party APIs (Steadfast, UddoktaPay, BD Courier).
 */
class DemoVideoSeeder extends Seeder
{
    /** Source photo (public/frontend/products/unsplash) per product id. */
    private const PHOTOS = [
        1 => '1521572163474-6864f9cf17ab', 2 => '1503341504253-dff4815485f1',
        3 => '1523381210434-271e8be1f52b', 4 => '1622445275463-afa2ab738c34',
        5 => '1602810318383-e386cc2a3ccf', 6 => '1445205170230-053b83016050',
        7 => '1512436991641-6745cdb1723f', 8 => '1517841905240-472988babdf9',
        9 => '1556905055-8f358a7a47b2',    10 => '1556905055-8f358a7a47b2',
        11 => '1515886657613-9f3515b0c78f', 12 => '1556905055-8f358a7a47b2',
        13 => '1515886657613-9f3515b0c78f', 14 => '1556905055-8f358a7a47b2',
        15 => '1515886657613-9f3515b0c78f', 16 => '1556905055-8f358a7a47b2',
        17 => '1515886657613-9f3515b0c78f', 18 => '1556905055-8f358a7a47b2',
        19 => '1515886657613-9f3515b0c78f', 20 => '1556905055-8f358a7a47b2',
        21 => '1583744946564-b52ac1c389c8', 22 => '1556905055-8f358a7a47b2',
        23 => '1608231387042-66d1773070a5', 24 => '1542291026-7eec264c27ff',
        25 => '1560343090-f0409e92791a',    26 => '1560343090-f0409e92791a',
        27 => '1560343090-f0409e92791a',    28 => '1491553895911-0055eca6402d',
        29 => '1491553895911-0055eca6402d', 30 => '1608231387042-66d1773070a5',
        31 => '1491553895911-0055eca6402d', 32 => '1608231387042-66d1773070a5',
        33 => '1491553895911-0055eca6402d', 34 => '1542291026-7eec264c27ff',
        35 => '1608231387042-66d1773070a5', 36 => '1542291026-7eec264c27ff',
        37 => '1560343090-f0409e92791a',    38 => '1560343090-f0409e92791a',
    ];

    public function run(): void
    {
        $this->seedProductPhotos();
        $this->topUpMainWarehouse();
        $customers = $this->seedCustomers();
        $this->seedOrders($customers);
        $this->seedStockTransfers();
        $this->seedStockAdjustments();
        $this->seedLandingPage();
        $this->seedBranding();

        $this->command->info('Demo video data seeded.');
    }

    private function seedProductPhotos(): void
    {
        $disk = Storage::disk('public');
        $disk->makeDirectory('products/thumbnails');
        $disk->makeDirectory('products/gallery');

        foreach (self::PHOTOS as $id => $photo) {
            $src = public_path("frontend/products/unsplash/unsplash-{$photo}.jpg");
            if (! File::exists($src)) {
                continue;
            }
            $img = imagecreatefromjpeg($src);

            $thumb = "products/thumbnails/demo_{$id}.webp";
            $gallery = "products/gallery/demo_{$id}.webp";
            $disk->put($thumb, $this->squareWebp($img, 300));
            $disk->put($gallery, $this->squareWebp($img, 800));
            imagedestroy($img);

            Product::whereKey($id)->update([
                'thumbnail' => $thumb,
                'gallery' => json_encode([['color' => null, 'path' => $gallery]]),
                'publish_status' => 'published',
            ]);
        }
    }

    private function squareWebp(\GdImage $img, int $size): string
    {
        $w = imagesx($img);
        $h = imagesy($img);
        $side = min($w, $h);
        $out = imagecreatetruecolor($size, $size);
        imagecopyresampled($out, $img, 0, 0, intdiv($w - $side, 2), intdiv($h - $side, 2), $size, $size, $side, $side);
        ob_start();
        imagewebp($out, null, 85);
        imagedestroy($out);

        return ob_get_clean();
    }

    /** Warehouse 1 carries every product so POS, transfers and adjustments have stock to work with. */
    private function topUpMainWarehouse(): void
    {
        foreach (Product::where('type', 'physical')->pluck('id') as $id) {
            $pw = ProductWarehouse::firstOrCreate(['product_id' => $id, 'warehouse_id' => 1], ['stock' => 0]);
            $pw->increment('stock', 60);
            Product::whereKey($id)->increment('stock', 60);
        }
    }

    private function seedCustomers(): array
    {
        $people = [
            ['Rahim Uddin',     '01711234567', 'rahim.uddin@example.com',   'House 12, Road 5, Dhanmondi',   'Dhaka',      'Dhanmondi'],
            ['Nusrat Jahan',    '01819876543', 'nusrat.jahan@example.com',  'Flat 4B, Block C, Bashundhara', 'Dhaka',      'Bashundhara'],
            ['Tanvir Hasan',    '01552345678', 'tanvir.hasan@example.com',  '45 GEC Circle',                 'Chittagong', 'GEC'],
            ['Farhana Akter',   '01923456789', 'farhana.akter@example.com', 'Zindabazar Main Road',          'Sylhet',     'Zindabazar'],
            ['Sakib Rahman',    '01634567890', 'sakib.rahman@example.com',  'Sector 7, Uttara',              'Dhaka',      'Uttara'],
            ['Mehjabin Chowdhury', '01745678901', 'mehjabin.c@example.com', 'Shaheb Bazar',                  'Rajshahi',   'Shaheb Bazar'],
            ['Arif Hossain',    '01856789012', 'arif.hossain@example.com',  'KDA Avenue',                    'Khulna',     'Sonadanga'],
            ['Sumaiya Islam',   '01967890123', 'sumaiya.islam@example.com', 'Mirpur 10, Road 3',             'Dhaka',      'Mirpur'],
        ];

        $customers = [];
        foreach ($people as $i => [$name, $phone, $email, $address, $city, $area]) {
            $customers[] = Customer::updateOrCreate(['phone' => $phone], [
                'name' => $name, 'email' => $email, 'address' => $address,
                'city' => $city, 'area' => $area, 'status' => true,
                'total_orders' => 0, 'total_spent' => 0,
                'created_at' => now()->subDays(40 - $i * 3),
            ]);
        }

        return $customers;
    }

    private function seedOrders(array $customers): void
    {
        // [customer index, days ago, status, payment method, payment status, [[product id, qty], ...]]
        $orders = [
            [0, 0,  'pending',    'cod',   'unpaid',   [[1, 2], [23, 1]]],
            [1, 0,  'pending',    'bkash', 'paid',     [[4, 1]]],
            [2, 1,  'confirmed',  'cod',   'unpaid',   [[10, 1], [6, 1]]],
            [3, 1,  'processing', 'nagad', 'paid',     [[24, 1]]],
            [4, 2,  'processing', 'cod',   'unpaid',   [[2, 3]]],
            [5, 3,  'shipped',    'cod',   'unpaid',   [[25, 1], [17, 1]]],
            [6, 4,  'shipped',    'bkash', 'paid',     [[34, 1]]],
            [7, 5,  'delivered',  'cod',   'paid',     [[8, 1], [12, 1]]],
            [0, 7,  'delivered',  'bkash', 'paid',     [[28, 1]]],
            [1, 9,  'delivered',  'cod',   'paid',     [[1, 1], [2, 1], [21, 2]]],
            [2, 12, 'delivered',  'nagad', 'paid',     [[37, 1]]],
            [3, 15, 'cancelled',  'cod',   'unpaid',   [[16, 1]]],
            [4, 18, 'returned',   'bkash', 'refunded', [[33, 1]]],
            [5, 22, 'delivered',  'cod',   'paid',     [[5, 2], [19, 1]]],
        ];

        // Insert oldest first so ids follow placement date ("Recent Orders" sorts by id).
        $seq = [];
        foreach (array_reverse($orders) as [$ci, $daysAgo, $status, $method, $payStatus, $lines]) {
            $customer = $customers[$ci];
            $placedAt = Carbon::now()->subDays($daysAgo)->subMinutes(rand(20, 300));
            $datePart = $placedAt->format('Ymd');
            $seq[$datePart] = ($seq[$datePart] ?? 0) + 1;

            $subtotal = 0;
            $items = [];
            foreach ($lines as [$pid, $qty]) {
                $p = Product::find($pid);
                $price = (float) ($p->sale_price ?: $p->selling_price);
                $subtotal += $price * $qty;
                $items[] = [
                    'product_id' => $p->id, 'product_name' => $p->name, 'product_sku' => $p->sku,
                    'thumbnail' => $p->thumbnail, 'quantity' => $qty, 'unit_price' => $price,
                    'total' => $price * $qty, 'created_at' => $placedAt, 'updated_at' => $placedAt,
                ];
            }
            $shipping = $customer->city === 'Dhaka' ? 60 : 120;
            $total = $subtotal + $shipping;

            $order = Order::create([
                'order_no' => 'NF-' . $datePart . '-' . str_pad($seq[$datePart], 4, '0', STR_PAD_LEFT),
                'source' => 'online',
                'customer_id' => $customer->id,
                'shipping_name' => $customer->name, 'shipping_phone' => $customer->phone,
                'shipping_email' => $customer->email, 'shipping_address' => $customer->address,
                'shipping_city' => $customer->city, 'shipping_area' => $customer->area,
                'subtotal' => $subtotal, 'shipping_charge' => $shipping, 'discount' => 0, 'total' => $total,
                'payment_method' => $method, 'payment_status' => $payStatus, 'status' => $status,
                'notes' => $ci === 0 ? 'Please call before delivery.' : null,
                'risk_score' => 0, 'ip_address' => '103.4.145.' . (10 + $ci),
                'placed_at' => $placedAt,
            ]);
            DB::table('orders')->where('id', $order->id)->update(['created_at' => $placedAt, 'updated_at' => $placedAt]);
            DB::table('order_items')->insert(array_map(fn ($i) => $i + ['order_id' => $order->id], $items));

            if (! in_array($status, ['cancelled', 'returned'])) {
                $customer->increment('total_orders');
                $customer->increment('total_spent', $total);
                $customer->update(['last_order_at' => $placedAt]);
            }
        }
    }

    private function seedStockTransfers(): void
    {
        $transfers = [
            [1, 2, 6, 'completed', [[1, 10], [2, 8], [23, 5]], 'Restock Mirpur hub for weekend sale'],
            [1, 4, 3, 'completed', [[9, 12], [10, 12]], 'Denim stock for Chittagong'],
            [1, 3, 1, 'pending',   [[24, 6], [34, 4]], 'Sneakers for Uttara pop-up'],
        ];

        foreach ($transfers as $n => [$from, $to, $daysAgo, $status, $lines, $notes]) {
            $date = now()->subDays($daysAgo);
            $id = DB::table('stock_transfers')->insertGetId([
                'from_warehouse_id' => $from, 'to_warehouse_id' => $to,
                'transfer_date' => $date->toDateString(),
                'reference_no' => 'ST-' . $date->format('Ymd') . '-' . str_pad($n + 1, 4, '0', STR_PAD_LEFT),
                'status' => $status, 'notes' => $notes, 'created_by' => 1,
                'created_at' => $date, 'updated_at' => $date,
            ]);
            foreach ($lines as [$pid, $qty]) {
                DB::table('stock_transfer_items')->insert([
                    'stock_transfer_id' => $id, 'product_id' => $pid, 'quantity' => $qty,
                    'created_at' => $date, 'updated_at' => $date,
                ]);
                if ($status === 'completed') {
                    ProductWarehouse::where(['product_id' => $pid, 'warehouse_id' => $from])->decrement('stock', $qty);
                    ProductWarehouse::firstOrCreate(['product_id' => $pid, 'warehouse_id' => $to], ['stock' => 0])
                        ->increment('stock', $qty);
                }
            }
        }
    }

    private function seedStockAdjustments(): void
    {
        $adjustments = [
            [1, 5, 'damage',     [[3, 2, 'Torn stitching found during QC'], [7, 1, 'Water damage']], 'Monthly QC check'],
            [1, 2, 'correction', [[11, 4, 'Physical count higher than system']], 'Cycle count correction'],
        ];

        foreach ($adjustments as $n => [$wh, $daysAgo, $type, $lines, $notes]) {
            $date = now()->subDays($daysAgo);
            $id = DB::table('stock_adjustments')->insertGetId([
                'warehouse_id' => $wh, 'adjustment_date' => $date->toDateString(),
                'reference_no' => 'SA-' . $date->format('Ymd') . '-' . str_pad($n + 1, 4, '0', STR_PAD_LEFT),
                'type' => $type, 'notes' => $notes, 'created_by' => 1,
                'created_at' => $date, 'updated_at' => $date,
            ]);
            foreach ($lines as [$pid, $qty, $reason]) {
                $pw = ProductWarehouse::where(['product_id' => $pid, 'warehouse_id' => $wh])->first();
                $current = (float) $pw->stock;
                $delta = $type === 'correction' ? $qty : -$qty;
                $pw->update(['stock' => max(0, $current + $delta)]);
                Product::whereKey($pid)->increment('stock', $delta);
                DB::table('stock_adjustment_items')->insert([
                    'stock_adjustment_id' => $id, 'product_id' => $pid, 'quantity' => $delta,
                    'current_stock' => $current, 'adjusted_stock' => max(0, $current + $delta),
                    'reason' => $reason, 'created_at' => $date, 'updated_at' => $date,
                ]);
            }
        }
    }

    private function seedLandingPage(): void
    {
        $product = Product::find(1);

        ProductLandingPage::updateOrCreate(['product_id' => $product->id], [
            'slug' => $product->slug,
            'is_active' => true,
            'hero_heading' => 'The Everyday Crew Neck You\'ll Live In',
            'hero_subheading' => '100% combed cotton, pre-shrunk, and built to keep its shape wash after wash.',
            'cta_text' => 'Order Now',
            'shipping_inside_dhaka' => 60,
            'shipping_outside_dhaka' => 120,
            'blocks' => [
                ['type' => 'rounded_heading', 'heading' => 'Why customers love it', 'subheading' => 'Soft, breathable, and made to last', 'style' => 'green'],
                ['type' => 'richtext', 'html' => '<ul><li>180 GSM combed cotton</li><li>Reinforced shoulder seams</li><li>Available in S, M, L, XL</li></ul>'],
                ['type' => 'image', 'path' => 'products/gallery/demo_1.webp', 'caption' => 'Classic fit, true to size'],
                ['type' => 'price_offer', 'label' => 'Launch Offer', 'old_price' => '550', 'new_price' => '450', 'note' => 'Free delivery inside Dhaka this week'],
            ],
            'meta_title' => $product->name . ' | Roventex',
        ]);
    }

    private function seedBranding(): void
    {
        $logo = 'site/XTbkYhdH4KNXhdhduVqLqOALzhz6QlKn3ziJ8rQh.png';
        $values = [
            'logo' => [Storage::disk('public')->exists($logo) ? $logo : null, 'branding'],
            'color_primary' => ['#E11D48', 'colors'],
            'color_secondary' => ['#111827', 'colors'],
            'color_accent' => ['#F59E0B', 'colors'],
            'announcement_text' => ['Free delivery inside Dhaka on orders over ৳1500', 'header'],
        ];
        foreach ($values as $key => [$value, $group]) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
        }
    }
}
