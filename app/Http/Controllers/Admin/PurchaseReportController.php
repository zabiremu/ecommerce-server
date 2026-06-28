<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchaseReportController extends Controller
{
    public function index(Request $request)
    {
        $from      = $request->filled('from') ? Carbon::parse($request->from)->startOfDay() : Carbon::now()->startOfMonth();
        $to        = $request->filled('to')   ? Carbon::parse($request->to)->endOfDay()     : Carbon::now()->endOfDay();
        $supplierId  = $request->input('supplier_id', '');
        $warehouseId = $request->input('warehouse_id', '');
        $status      = $request->input('status', '');

        $query = Purchase::with('supplier', 'warehouse')
            ->whereBetween('purchase_date', [$from->toDateString(), $to->toDateString()]);

        if ($supplierId !== '') {
            $query->where('supplier_id', $supplierId);
        }
        if ($warehouseId !== '') {
            $query->where('warehouse_id', $warehouseId);
        }
        if ($status !== '') {
            $query->where('status', $status);
        }

        $purchases = $query->latest('purchase_date')->get();

        $suppliers  = Supplier::where('status', true)->orderBy('name')->get();
        $warehouses = Warehouse::where('status', true)->orderBy('name')->get();

        $totalPurchases  = $purchases->count();
        $totalAmount     = $purchases->sum('total_amount');
        $receivedAmount  = $purchases->where('status', 'received')->sum('total_amount');
        $pendingAmount   = $purchases->where('status', 'pending')->sum('total_amount');

        $statusCounts = $purchases->groupBy('status')->map->count();

        return view('Admin.purchase_report.index', compact(
            'purchases', 'from', 'to', 'supplierId', 'warehouseId', 'status',
            'suppliers', 'warehouses',
            'totalPurchases', 'totalAmount', 'receivedAmount', 'pendingAmount',
            'statusCounts'
        ));
    }
}
