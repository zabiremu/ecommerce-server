<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PurchaseReportController extends Controller
{
    public function index(Request $request)
    {
        [$from, $to, $supplierId, $warehouseId, $status] = $this->parseFilters($request);

        $purchases = $this->filteredPurchases($from, $to, $supplierId, $warehouseId, $status);

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

    public function export(Request $request): StreamedResponse
    {
        [$from, $to, $supplierId, $warehouseId, $status] = $this->parseFilters($request);

        $purchases = $this->filteredPurchases($from, $to, $supplierId, $warehouseId, $status);

        $filename = 'purchase-report_' . $from->toDateString() . '_to_' . $to->toDateString() . '.csv';

        return response()->streamDownload(function () use ($purchases) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Invoice #', 'Date', 'Supplier', 'Warehouse', 'Status', 'Amount',
            ]);

            foreach ($purchases as $purchase) {
                fputcsv($handle, [
                    $purchase->invoice_no,
                    Carbon::parse($purchase->purchase_date)->format('Y-m-d'),
                    $purchase->supplier->name ?? '',
                    $purchase->warehouse->name ?? '',
                    $purchase->status,
                    $purchase->total_amount,
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    private function parseFilters(Request $request): array
    {
        $from        = $request->filled('from') ? Carbon::parse($request->from)->startOfDay() : Carbon::now()->startOfMonth();
        $to          = $request->filled('to')   ? Carbon::parse($request->to)->endOfDay()     : Carbon::now()->endOfDay();
        $supplierId  = (string) $request->input('supplier_id', '');
        $warehouseId = (string) $request->input('warehouse_id', '');
        $status      = (string) $request->input('status', '');

        return [$from, $to, $supplierId, $warehouseId, $status];
    }

    private function filteredPurchases(Carbon $from, Carbon $to, string $supplierId, string $warehouseId, string $status)
    {
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

        return $query->latest('purchase_date')->get();
    }
}
