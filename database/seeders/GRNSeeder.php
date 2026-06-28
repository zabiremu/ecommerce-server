<?php

namespace Database\Seeders;

use App\Models\GoodsReceivedNote;
use App\Models\Product;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GRNSeeder extends Seeder
{
    public function run(): void
    {
        // Clear any existing GRNs (idempotent)
        DB::table('grn_items')->delete();
        GoodsReceivedNote::query()->delete();

        // Only completed purchases get a GRN
        $completed = Purchase::with('items')
            ->where('status', 'completed')
            ->orderBy('purchase_date')
            ->get();

        if ($completed->isEmpty()) {
            $this->command->warn('No completed purchases — run PurchaseSeeder first.');
            return;
        }

        $noteSamples = [
            'All items received in good condition.',
            'Inspection passed — full quantity accepted.',
            'Minor packaging damage on a few items, contents OK.',
            null, null, null,
            'Received and stored in designated warehouse rack.',
            'Quality check complete — ready for sale.',
        ];

        $grnSerial = 0;
        foreach ($completed as $purchase) {
            // ~88% of completed purchases get a GRN, rest treated as "in transit"
            if (rand(1, 100) > 88) {
                continue;
            }

            $grnSerial++;
            $receivedDate = Carbon::parse($purchase->purchase_date)->addDays(rand(1, 7))->format('Y-m-d');
            $grnNo = 'GRN-' . Carbon::parse($receivedDate)->format('Ymd') . '-' . str_pad((string) $grnSerial, 4, '0', STR_PAD_LEFT);

            $grn = GoodsReceivedNote::create([
                'grn_no'        => $grnNo,
                'purchase_id'   => $purchase->id,
                'supplier_id'   => $purchase->supplier_id,
                'warehouse_id'  => $purchase->warehouse_id,
                'received_date' => $receivedDate,
                'notes'         => $noteSamples[array_rand($noteSamples)],
                'created_at'    => $receivedDate . ' ' . sprintf('%02d:%02d:00', rand(10, 17), rand(0, 59)),
                'updated_at'    => $receivedDate . ' ' . sprintf('%02d:%02d:00', rand(10, 17), rand(0, 59)),
            ]);

            foreach ($purchase->items as $pItem) {
                // Most items fully received (90% chance), some partial (10%)
                if (rand(1, 100) <= 90) {
                    $received = (float) $pItem->quantity;
                } else {
                    $received = max(1, round((float) $pItem->quantity * (rand(70, 95) / 100), 2));
                }

                $unitCost = (float) $pItem->unit_cost;
                $lineTotal = round($received * $unitCost, 2);

                $grn->items()->create([
                    'purchase_item_id' => $pItem->id,
                    'product_id'       => $pItem->product_id,
                    'product_name'     => $pItem->product_name,
                    'ordered_qty'      => $pItem->quantity,
                    'received_qty'     => $received,
                    'unit_cost'        => $unitCost,
                    'total'            => $lineTotal,
                ]);

                // Apply stock update — matches GRNController@store logic
                if ($pItem->product_id && $received > 0) {
                    $product = Product::find($pItem->product_id);
                    if ($product) {
                        $product->increment('stock', $received);

                        $whId = $purchase->warehouse_id;
                        $existing = $product->warehouses()->where('warehouse_id', $whId)->first();
                        if ($existing) {
                            $product->warehouses()->updateExistingPivot($whId, [
                                'stock' => ((float) $existing->pivot->stock) + $received,
                            ]);
                        } else {
                            $product->warehouses()->attach($whId, ['stock' => $received]);
                        }
                    }
                }
            }
        }

        $totalGrn   = GoodsReceivedNote::count();
        $totalItems = DB::table('grn_items')->count();
        $totalQty   = (float) DB::table('grn_items')->sum('received_qty');

        $this->command->info('GRNs seeded successfully.');
        $this->command->info('  GRNs created: '   . $totalGrn);
        $this->command->info('  GRN items: '      . $totalItems);
        $this->command->info('  Total stock added: ' . rtrim(rtrim(number_format($totalQty, 2, '.', ''), '0'), '.') . ' units');
    }
}
