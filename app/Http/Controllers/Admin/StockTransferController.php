<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockTransfer;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\ProductWarehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockTransferController extends Controller
{
    public function index()
    {
        $transfers = StockTransfer::with('fromWarehouse', 'toWarehouse', 'creator')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('Admin.stock_transfer.index', compact('transfers'));
    }

    public function create()
    {
        $warehouses = Warehouse::where('status', true)->orderBy('name')->get();
        $products = Product::published()->where('type', 'physical')->orderBy('name')->get();
        return view('Admin.stock_transfer.create', compact('warehouses', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'from_warehouse_id' => 'required|exists:warehouses,id|different:to_warehouse_id',
            'to_warehouse_id' => 'required|exists:warehouses,id',
            'transfer_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
        ]);

        $refNo = 'ST-' . strtoupper(now()->format('Ymd')) . '-' . str_pad(StockTransfer::max('id') + 1, 4, '0', STR_PAD_LEFT);

        $transfer = StockTransfer::create([
            'from_warehouse_id' => $request->from_warehouse_id,
            'to_warehouse_id' => $request->to_warehouse_id,
            'transfer_date' => $request->transfer_date,
            'reference_no' => $refNo,
            'notes' => $request->notes,
            'status' => 'pending',
            'created_by' => Auth::guard('admin')->id(),
        ]);

        foreach ($request->items as $item) {
            $transfer->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
            ]);
        }

        return redirect()->route('admin.stock-transfers.show', $transfer)
            ->with('success', 'Stock transfer created successfully.');
    }

    public function show(StockTransfer $stockTransfer)
    {
        $stockTransfer->load('fromWarehouse', 'toWarehouse', 'items.product', 'creator');
        return view('Admin.stock_transfer.show', compact('stockTransfer'));
    }

    public function destroy(StockTransfer $stockTransfer)
    {
        if ($stockTransfer->status === 'completed') {
            return redirect()->route('admin.stock-transfers.index')
                ->with('error', 'Cannot delete a completed transfer.');
        }
        $stockTransfer->delete();
        return redirect()->route('admin.stock-transfers.index')
            ->with('success', 'Stock transfer deleted.');
    }

    public function updateStatus(Request $request, StockTransfer $stockTransfer)
    {
        $request->validate(['status' => 'required|in:completed,cancelled']);

        if ($stockTransfer->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending transfers can be updated.');
        }

        try {
            DB::transaction(function () use ($stockTransfer, $request) {
                $stockTransfer->load('items.product');

                if ($request->status === 'completed') {
                    foreach ($stockTransfer->items as $item) {
                        $fromPw = ProductWarehouse::where('product_id', $item->product_id)
                            ->where('warehouse_id', $stockTransfer->from_warehouse_id)
                            ->first();

                        $available = $fromPw ? $fromPw->stock : 0;
                        if ($available < $item->quantity) {
                            throw new \Exception("Insufficient stock for {$item->product->name}. Available: {$available}, Requested: {$item->quantity}");
                        }

                        $fromPw->decrement('stock', $item->quantity);

                        ProductWarehouse::firstOrCreate(
                            ['product_id' => $item->product_id, 'warehouse_id' => $stockTransfer->to_warehouse_id],
                            ['stock' => 0]
                        )->increment('stock', $item->quantity);
                    }
                }

                $stockTransfer->update(['status' => $request->status]);
            });

            return redirect()->route('admin.stock-transfers.show', $stockTransfer)
                ->with('success', 'Transfer ' . $request->status . ' successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getProductStock(StockTransfer $stockTransfer, $productId, $warehouseId)
    {
        $pw = ProductWarehouse::where('product_id', $productId)
            ->where('warehouse_id', $warehouseId)
            ->first();
        return response()->json(['stock' => $pw ? $pw->stock : 0]);
    }
}
