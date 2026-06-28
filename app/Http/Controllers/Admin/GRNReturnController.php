<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GoodsReceivedNote;
use App\Models\GRNReturn;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GRNReturnController extends Controller
{
    public function index()
    {
        $returns = GRNReturn::with('supplier', 'warehouse', 'goodsReceivedNote')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('Admin.grn_return.index', compact('returns'));
    }

    public function create()
    {
        $grns = GoodsReceivedNote::with('supplier', 'warehouse', 'items.product')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('Admin.grn_return.create', compact('grns'));
    }

    public function getGrnItems(GoodsReceivedNote $goodsReceivedNote)
    {
        $goodsReceivedNote->load('items.product', 'supplier', 'warehouse');
        return response()->json($goodsReceivedNote);
    }

    public function store(Request $request)
    {
        $request->validate([
            'goods_received_note_id' => 'required|exists:goods_received_notes,id',
            'return_date'            => 'required|date',
            'reason'                 => 'nullable|string|max:255',
            'notes'                  => 'nullable|string|max:500',
            'items'                  => 'required|array|min:1',
            'items.*.grn_item_id'    => 'required|exists:grn_items,id',
            'items.*.return_qty'     => 'required|numeric|min:0.01',
        ]);

        $return = DB::transaction(function () use ($request) {
            $grn = GoodsReceivedNote::with('items')->findOrFail($request->goods_received_note_id);

            $returnNo = 'GRNR-' . strtoupper(now()->format('Ymd')) . '-' . str_pad(GRNReturn::max('id') + 1, 4, '0', STR_PAD_LEFT);

            $grnReturn = GRNReturn::create([
                'return_no'               => $returnNo,
                'goods_received_note_id'  => $grn->id,
                'supplier_id'             => $grn->supplier_id,
                'warehouse_id'            => $grn->warehouse_id,
                'return_date'             => $request->return_date,
                'reason'                  => $request->reason,
                'notes'                   => $request->notes,
            ]);

            $grnItemsMap = $grn->items->keyBy('id');

            foreach ($request->items as $item) {
                $grnItem = $grnItemsMap->get($item['grn_item_id']);
                if (!$grnItem) continue;

                $returnQty = (float) $item['return_qty'];
                if ($returnQty <= 0) continue;

                $total = $returnQty * (float) $grnItem->unit_cost;

                $grnReturn->items()->create([
                    'grn_item_id'  => $grnItem->id,
                    'product_id'   => $grnItem->product_id,
                    'product_name' => $grnItem->product_name,
                    'received_qty' => $grnItem->received_qty,
                    'return_qty'   => $returnQty,
                    'unit_cost'    => $grnItem->unit_cost,
                    'total'        => $total,
                ]);

                // Deduct stock for the returned quantity
                if ($grnItem->product_id) {
                    $product = Product::find($grnItem->product_id);
                    if ($product) {
                        $newMaster = max(0, ((float) $product->stock) - $returnQty);
                        $product->update(['stock' => $newMaster]);

                        $warehouseId = $grn->warehouse_id;
                        $existing = $product->warehouses()->where('warehouse_id', $warehouseId)->first();
                        if ($existing) {
                            $newWh = max(0, ((float) $existing->pivot->stock) - $returnQty);
                            $product->warehouses()->updateExistingPivot($warehouseId, ['stock' => $newWh]);
                        }
                    }
                }
            }

            return $grnReturn;
        });

        return redirect()->route('admin.grn-returns.show', $return)
            ->with('success', 'GRN return created successfully. Stock adjusted.');
    }

    public function show(GRNReturn $grnReturn)
    {
        $grnReturn->load('supplier', 'warehouse', 'goodsReceivedNote', 'items.product');
        return view('Admin.grn_return.show', compact('grnReturn'));
    }

    public function destroy(GRNReturn $grnReturn)
    {
        DB::transaction(function () use ($grnReturn) {
            $grnReturn->load('items');
            $warehouseId = $grnReturn->warehouse_id;

            // Restore stock that was deducted when return was created
            foreach ($grnReturn->items as $item) {
                if (!$item->product_id || (float) $item->return_qty <= 0) continue;

                $product = Product::find($item->product_id);
                if (!$product) continue;

                $qty = (float) $item->return_qty;

                $product->increment('stock', $qty);

                $existing = $product->warehouses()->where('warehouse_id', $warehouseId)->first();
                if ($existing) {
                    $newWh = ((float) $existing->pivot->stock) + $qty;
                    $product->warehouses()->updateExistingPivot($warehouseId, ['stock' => $newWh]);
                } else {
                    $product->warehouses()->attach($warehouseId, ['stock' => $qty]);
                }
            }

            $grnReturn->delete();
        });

        return redirect()->route('admin.grn-returns.index')
            ->with('success', 'GRN return deleted. Stock restored.');
    }
}
