<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('supplier', 'warehouse')->orderBy('created_at', 'desc')->get();
        return view('Admin.purchase.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::where('status', true)->orderBy('name')->get();
        $warehouses = Warehouse::where('status', true)->orderBy('name')->get();
        $products = Product::where('type', 'physical')
            ->orderBy('name')
            ->get(['id', 'name', 'sku', 'purchase_price', 'selling_price', 'stock']);
        return view('Admin.purchase.create', compact('suppliers', 'warehouses', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'purchase_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        $purchase = DB::transaction(function () use ($request) {
            $invoiceNo = 'PUR-' . strtoupper(now()->format('Ymd')) . '-' . str_pad(Purchase::max('id') + 1, 4, '0', STR_PAD_LEFT);

            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'warehouse_id' => $request->warehouse_id,
                'invoice_no' => $invoiceNo,
                'purchase_date' => $request->purchase_date,
                'notes' => $request->notes,
                'total_amount' => 0,
                'status' => 'pending',
            ]);

            $totalAmount = 0;
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                if (!$product) continue;

                $lineTotal = $item['quantity'] * $item['unit_cost'];
                $totalAmount += $lineTotal;
                $purchase->items()->create([
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'quantity'     => $item['quantity'],
                    'unit_cost'    => $item['unit_cost'],
                    'total'        => $lineTotal,
                ]);
            }

            $purchase->update(['total_amount' => $totalAmount]);

            return $purchase;
        });

        return redirect()->route('admin.purchases.show', $purchase)
            ->with('success', 'Purchase created successfully.');
    }

    public function show(Purchase $purchase)
    {
        $purchase->load('supplier', 'warehouse', 'items');
        return view('Admin.purchase.show', compact('purchase'));
    }

    public function destroy(Purchase $purchase)
    {
        $purchase->delete();

        return redirect()->route('admin.purchases.index')
            ->with('success', 'Purchase deleted successfully.');
    }

    public function updateStatus(Request $request, Purchase $purchase)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $purchase->update(['status' => $request->status]);

        return redirect()->route('admin.purchases.show', $purchase)
            ->with('success', 'Purchase status updated.');
    }
}
