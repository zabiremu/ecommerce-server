<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PurchaseSeeder extends Seeder
{
    public function run(): void
    {
        // Idempotent reset — wipe existing purchases + product stock to start clean.
        // (GRNs will rebuild stock realistically.)
        DB::table('grn_items')->delete();
        DB::table('goods_received_notes')->delete();
        DB::table('purchase_items')->delete();
        Purchase::query()->delete();
        DB::table('product_warehouse')->delete();
        Product::where('type', 'physical')->update(['stock' => 0]);

        $suppliers  = Supplier::pluck('id')->all();
        $warehouses = Warehouse::pluck('id')->all();
        $products   = Product::where('type', 'physical')
            ->where('publish_status', 'published')
            ->get();

        if (empty($suppliers) || empty($warehouses) || $products->isEmpty()) {
            $this->command->warn('Need at least 1 supplier, warehouse and product to seed purchases.');
            return;
        }

        // Status weighting: mostly completed, some pending, few cancelled
        $statusBag = array_merge(
            array_fill(0, 14, 'completed'),
            array_fill(0, 4, 'pending'),
            array_fill(0, 2, 'cancelled')
        );

        $noteSamples = [
            'Bulk order for monthly stock replenishment.',
            'Urgent restock — fast-moving items.',
            'Pre-Eid demand restock.',
            'Quarterly inventory top-up.',
            'New supplier trial order.',
            null, null, null,
            'Special discounted batch.',
            'Replacement for damaged previous shipment.',
        ];

        $totalPurchases = 25;
        for ($i = 1; $i <= $totalPurchases; $i++) {
            $supplierId  = $suppliers[array_rand($suppliers)];
            $warehouseId = $warehouses[array_rand($warehouses)];
            $status      = $statusBag[array_rand($statusBag)];
            $daysAgo     = rand(2, 90);
            $purchaseDate = Carbon::now()->subDays($daysAgo)->format('Y-m-d');
            $invoiceNo   = 'PUR-' . Carbon::now()->subDays($daysAgo)->format('Ymd') . '-' . str_pad((string) $i, 4, '0', STR_PAD_LEFT);

            $purchase = Purchase::create([
                'supplier_id'   => $supplierId,
                'warehouse_id'  => $warehouseId,
                'invoice_no'    => $invoiceNo,
                'purchase_date' => $purchaseDate,
                'status'        => $status,
                'total_amount'  => 0,
                'notes'         => $noteSamples[array_rand($noteSamples)],
                'created_at'    => $purchaseDate . ' ' . sprintf('%02d:%02d:00', rand(9, 18), rand(0, 59)),
                'updated_at'    => $purchaseDate . ' ' . sprintf('%02d:%02d:00', rand(9, 18), rand(0, 59)),
            ]);

            // Random 3–7 distinct products per purchase
            $itemCount = rand(3, 7);
            $selected  = $products->random(min($itemCount, $products->count()));

            $totalAmount = 0;
            foreach ($selected as $product) {
                $qty       = rand(10, 100);
                $unitCost  = (float) ($product->purchase_price > 0 ? $product->purchase_price : $product->selling_price * 0.72);
                // Small random variance ±5%
                $unitCost  = round($unitCost * (1 + (rand(-5, 5) / 100)), 2);
                $lineTotal = round($qty * $unitCost, 2);
                $totalAmount += $lineTotal;

                $purchase->items()->create([
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'quantity'     => $qty,
                    'unit_cost'    => $unitCost,
                    'total'        => $lineTotal,
                ]);
            }

            $purchase->update(['total_amount' => $totalAmount]);
        }

        $counts = Purchase::selectRaw('status, count(*) as c')->groupBy('status')->pluck('c', 'status');
        $this->command->info('Purchases seeded successfully.');
        $this->command->info('  Completed: ' . ($counts['completed'] ?? 0));
        $this->command->info('  Pending: '   . ($counts['pending']   ?? 0));
        $this->command->info('  Cancelled: ' . ($counts['cancelled'] ?? 0));
        $this->command->info('  Total: '     . Purchase::count());
    }
}
