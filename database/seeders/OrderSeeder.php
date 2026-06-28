<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('order_items')->delete();
        Order::query()->delete();

        $customers = Customer::all();
        $products  = Product::where('type', 'physical')
            ->where('publish_status', 'published')
            ->get();

        if ($customers->isEmpty() || $products->isEmpty()) {
            $this->command->warn('Need customers + products before seeding orders.');
            return;
        }

        // Status mix (weighted toward delivered)
        $statusBag = array_merge(
            array_fill(0, 20, 'delivered'),
            array_fill(0, 6, 'shipped'),
            array_fill(0, 5, 'processing'),
            array_fill(0, 3, 'confirmed'),
            array_fill(0, 6, 'pending'),
            array_fill(0, 4, 'cancelled'),
            array_fill(0, 1, 'returned'),
        );

        $payMethods    = ['cod', 'cod', 'cod', 'cod', 'bkash', 'bkash', 'nagad', 'rocket', 'bank'];
        $citiesShipping = ['Dhaka' => 60, 'Chittagong' => 130, 'Sylhet' => 150, 'Khulna' => 130, 'Rajshahi' => 130];

        $orderNotes = [
            'Please deliver between 6–9 PM.', null, null,
            'Call before arriving — no doorbell.',
            'Gift wrap please.',
            'Need urgently for Friday.', null, null,
            'Apartment 4B — second floor.',
        ];

        $totalOrders = 60;
        $serial      = 0;

        for ($i = 1; $i <= $totalOrders; $i++) {
            $serial++;
            $daysAgo = rand(0, 80);
            $placedAt = Carbon::now()->subDays($daysAgo)->setTime(rand(9, 22), rand(0, 59), 0);

            $customer = $customers->random();
            $status   = $statusBag[array_rand($statusBag)];
            $payment  = $payMethods[array_rand($payMethods)];

            $orderNo = 'ORD-' . $placedAt->format('Ymd') . '-' . str_pad((string) $serial, 4, '0', STR_PAD_LEFT);

            // 1–5 items per order
            $itemCount = rand(1, 5);
            $picked    = $products->random(min($itemCount, $products->count()));

            $shippingCharge = $citiesShipping[$customer->city] ?? 100;
            $discount       = (rand(1, 100) <= 25) ? rand(50, 200) : 0;

            $order = Order::create([
                'order_no'        => $orderNo,
                'customer_id'     => $customer->id,
                'shipping_name'   => $customer->name,
                'shipping_phone'  => $customer->phone,
                'shipping_email'  => $customer->email,
                'shipping_address'=> $customer->address ?? 'Default address',
                'shipping_city'   => $customer->city,
                'shipping_area'   => $customer->area,
                'subtotal'        => 0,
                'shipping_charge' => $shippingCharge,
                'discount'        => $discount,
                'total'           => 0,
                'payment_method'  => $payment,
                'payment_status'  => $status === 'delivered' ? 'paid' : ($status === 'cancelled' || $status === 'returned' ? 'unpaid' : 'unpaid'),
                'status'          => $status,
                'notes'           => $orderNotes[array_rand($orderNotes)],
                'stock_deducted'  => in_array($status, ['confirmed', 'processing', 'shipped', 'delivered']),
                'placed_at'       => $placedAt,
                'created_at'      => $placedAt,
                'updated_at'      => $placedAt,
            ]);

            $subtotal = 0;
            foreach ($picked as $p) {
                $qty   = rand(1, 4);
                $price = (float) $p->selling_price;
                $line  = round($qty * $price, 2);
                $subtotal += $line;

                $order->items()->create([
                    'product_id'   => $p->id,
                    'product_name' => $p->name,
                    'product_sku'  => $p->sku,
                    'thumbnail'    => $p->thumbnail,
                    'quantity'     => $qty,
                    'unit_price'   => $price,
                    'total'        => $line,
                ]);
            }

            $total = $subtotal + $shippingCharge - $discount;
            $order->update([
                'subtotal' => $subtotal,
                'total'    => $total,
            ]);
        }

        // Recompute customer stats from orders
        foreach (Customer::all() as $c) {
            $c->recalculateStats();
        }

        $counts = Order::selectRaw('status, count(*) as c')->groupBy('status')->pluck('c', 'status');
        $this->command->info('Orders seeded successfully.');
        foreach (Order::STATUSES as $s) {
            $this->command->info('  ' . str_pad(ucfirst($s) . ':', 14) . ($counts[$s] ?? 0));
        }
        $this->command->info('  Total: ' . Order::count());
        $this->command->info('  Customers with orders: ' . Customer::where('total_orders', '>', 0)->count());
    }
}
