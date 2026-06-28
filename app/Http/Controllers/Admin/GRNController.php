<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GoodsReceivedNote;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GRNController extends Controller
{
    public function index()
    {
        $grns = GoodsReceivedNote::with('supplier', 'warehouse', 'purchase')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('Admin.grn.index', compact('grns'));
    }

    public function create()
    {
        $purchases = Purchase::with('supplier', 'items')
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('Admin.grn.create', compact('purchases'));
    }

    public function getPurchaseItems(Purchase $purchase)
    {
        $purchase->load('items.product', 'supplier', 'warehouse');
        return response()->json($purchase);
    }

    public function store(Request $request)
    {
        $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'received_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.purchase_item_id' => 'required|exists:purchase_items,id',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.ordered_qty' => 'required|numeric|min:0',
            'items.*.received_qty' => 'required|numeric|min:0',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        $grn = DB::transaction(function () use ($request) {
            $purchase = Purchase::with('supplier', 'warehouse')->findOrFail($request->purchase_id);

            $grnNo = 'GRN-' . strtoupper(now()->format('Ymd')) . '-' . str_pad(GoodsReceivedNote::max('id') + 1, 4, '0', STR_PAD_LEFT);

            $grn = GoodsReceivedNote::create([
                'grn_no' => $grnNo,
                'purchase_id' => $purchase->id,
                'supplier_id' => $purchase->supplier_id,
                'warehouse_id' => $purchase->warehouse_id,
                'received_date' => $request->received_date,
                'notes' => $request->notes,
            ]);

            foreach ($request->items as $item) {
                $received = (float) $item['received_qty'];
                $total    = $received * (float) $item['unit_cost'];

                $purchaseItem = PurchaseItem::find($item['purchase_item_id']);
                $productId = $purchaseItem?->product_id;

                $grn->items()->create([
                    'purchase_item_id' => $item['purchase_item_id'],
                    'product_id'       => $productId,
                    'product_name'     => $item['product_name'],
                    'ordered_qty'      => $item['ordered_qty'],
                    'received_qty'     => $received,
                    'unit_cost'        => $item['unit_cost'],
                    'total'            => $total,
                ]);

                // Stock calculation — only if received qty > 0 and product is linked
                if ($received > 0 && $productId) {
                    $product = Product::find($productId);
                    if ($product) {
                        // Update master product stock
                        $product->increment('stock', $received);

                        // Update warehouse-specific stock (pivot)
                        $warehouseId = $purchase->warehouse_id;
                        $existing = $product->warehouses()->where('warehouse_id', $warehouseId)->first();
                        if ($existing) {
                            $newStock = ((float) $existing->pivot->stock) + $received;
                            $product->warehouses()->updateExistingPivot($warehouseId, ['stock' => $newStock]);
                        } else {
                            $product->warehouses()->attach($warehouseId, ['stock' => $received]);
                        }
                    }
                }
            }

            return $grn;
        });

        return redirect()->route('admin.grn.show', $grn)
            ->with('success', 'Goods received note created successfully. Stock updated.');
    }

    public function show(GoodsReceivedNote $goodsReceivedNote)
    {
        $goodsReceivedNote->load('supplier', 'warehouse', 'purchase', 'items');
        return view('Admin.grn.show', compact('goodsReceivedNote'));
    }

    public function destroy(GoodsReceivedNote $goodsReceivedNote)
    {
        DB::transaction(function () use ($goodsReceivedNote) {
            $goodsReceivedNote->load('items');
            $warehouseId = $goodsReceivedNote->warehouse_id;

            // Reverse stock changes
            foreach ($goodsReceivedNote->items as $item) {
                if (!$item->product_id || (float) $item->received_qty <= 0) {
                    continue;
                }
                $product = Product::find($item->product_id);
                if (!$product) continue;

                $qty = (float) $item->received_qty;

                // Reduce master stock (clamp at zero)
                $newMaster = max(0, ((float) $product->stock) - $qty);
                $product->update(['stock' => $newMaster]);

                // Reduce warehouse pivot stock
                $existing = $product->warehouses()->where('warehouse_id', $warehouseId)->first();
                if ($existing) {
                    $newWh = max(0, ((float) $existing->pivot->stock) - $qty);
                    $product->warehouses()->updateExistingPivot($warehouseId, ['stock' => $newWh]);
                }
            }

            $goodsReceivedNote->delete();
        });

        return redirect()->route('admin.grn.index')
            ->with('success', 'GRN deleted successfully. Stock reverted.');
    }
}
