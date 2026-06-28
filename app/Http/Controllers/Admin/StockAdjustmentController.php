<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockAdjustment;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\ProductWarehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockAdjustmentController extends Controller
{
    public function index()
    {
        $adjustments = StockAdjustment::with('warehouse', 'creator')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('Admin.stock_adjustment.index', compact('adjustments'));
    }

    public function create()
    {
        $warehouses = Warehouse::where('status', true)->orderBy('name')->get();
        $products = Product::published()->where('type', 'physical')->orderBy('name')->get();
        return view('Admin.stock_adjustment.create', compact('warehouses', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'adjustment_date' => 'required|date',
            'type' => 'required|in:write_off,damage,correction',
            'notes' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric',
            'items.*.reason' => 'nullable|string|max:255',
        ]);

        $refNo = 'SA-' . strtoupper(now()->format('Ymd')) . '-' . str_pad(StockAdjustment::max('id') + 1, 4, '0', STR_PAD_LEFT);

        $adjustment = StockAdjustment::create([
            'warehouse_id' => $request->warehouse_id,
            'adjustment_date' => $request->adjustment_date,
            'reference_no' => $refNo,
            'type' => $request->type,
            'notes' => $request->notes,
            'created_by' => Auth::guard('admin')->id(),
        ]);

        try {
            DB::transaction(function () use ($adjustment, $request) {
                foreach ($request->items as $item) {
                    $pw = ProductWarehouse::firstOrCreate(
                        ['product_id' => $item['product_id'], 'warehouse_id' => $request->warehouse_id],
                        ['stock' => 0]
                    );
                    $currentStock = $pw->stock;

                    $qty = (float) $item['quantity'];
                    if (in_array($request->type, ['write_off', 'damage'])) {
                        $qty = -abs($qty);
                    }

                    $adjustedStock = max(0, $currentStock + $qty);

                    $pw->update(['stock' => $adjustedStock]);

                    $product = Product::find($item['product_id']);
                    $product->increment('stock', $qty);
                    if ($product->stock < 0) {
                        $product->update(['stock' => 0]);
                    }

                    $adjustment->items()->create([
                        'product_id' => $item['product_id'],
                        'quantity' => $qty,
                        'current_stock' => $currentStock,
                        'adjusted_stock' => $adjustedStock,
                        'reason' => $item['reason'] ?? null,
                    ]);
                }
            });

            return redirect()->route('admin.stock-adjustments.show', $adjustment)
                ->with('success', 'Stock adjustment completed successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.stock-adjustments.create')
                ->with('error', 'Adjustment failed: ' . $e->getMessage());
        }
    }

    public function show(StockAdjustment $stockAdjustment)
    {
        $stockAdjustment->load('warehouse', 'items.product', 'creator');
        return view('Admin.stock_adjustment.show', compact('stockAdjustment'));
    }

    public function destroy(StockAdjustment $stockAdjustment)
    {
        try {
            DB::transaction(function () use ($stockAdjustment) {
                foreach ($stockAdjustment->items as $item) {
                    $pw = ProductWarehouse::where('product_id', $item->product_id)
                        ->where('warehouse_id', $stockAdjustment->warehouse_id)
                        ->first();
                    if ($pw) {
                        $diff = $item->adjusted_stock - $item->current_stock;
                        $pw->decrement('stock', $diff);

                        $product = Product::find($item->product_id);
                        if ($product) {
                            $product->decrement('stock', $diff);
                            if ($product->stock < 0) {
                                $product->update(['stock' => 0]);
                            }
                        }
                    }
                }
                $stockAdjustment->delete();
            });

            return redirect()->route('admin.stock-adjustments.index')
                ->with('success', 'Stock adjustment deleted and stock reverted.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to revert: ' . $e->getMessage());
        }
    }

    public function getProductStock($productId, $warehouseId)
    {
        $pw = ProductWarehouse::where('product_id', $productId)
            ->where('warehouse_id', $warehouseId)
            ->first();
        return response()->json([
            'warehouse_stock' => $pw ? $pw->stock : 0,
            'total_stock' => Product::find($productId)?->stock ?? 0,
        ]);
    }
}
