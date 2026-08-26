<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {
        [$from, $to, $status] = $this->parseFilters($request);

        $orders = $this->filteredOrders($from, $to, $status);

        // Summary stats
        $totalOrders   = $orders->count();
        $totalRevenue  = $orders->whereNotIn('status', ['cancelled', 'returned'])->sum('total');
        $avgOrder      = $totalOrders > 0 ? ($orders->whereNotIn('status', ['cancelled', 'returned'])->sum('total') / max($orders->whereNotIn('status', ['cancelled', 'returned'])->count(), 1)) : 0;
        $deliveredRev  = $orders->where('status', 'delivered')->sum('total');

        $statusCounts = $orders->groupBy('status')->map->count();

        // Daily revenue chart data
        $dailySales = $orders
            ->whereNotIn('status', ['cancelled', 'returned'])
            ->groupBy(fn ($o) => Carbon::parse($o->placed_at)->toDateString())
            ->map(fn ($g) => $g->sum('total'))
            ->sortKeys();

        return view('Admin.sales_report.index', compact(
            'orders', 'from', 'to', 'status',
            'totalOrders', 'totalRevenue', 'avgOrder', 'deliveredRev',
            'statusCounts', 'dailySales'
        ));
    }

    public function export(Request $request): StreamedResponse
    {
        [$from, $to, $status] = $this->parseFilters($request);

        $orders = $this->filteredOrders($from, $to, $status);

        $filename = 'sales-report_' . $from->toDateString() . '_to_' . $to->toDateString() . '.csv';

        return response()->streamDownload(function () use ($orders) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Order #', 'Date', 'Customer', 'Phone', 'City',
                'Payment Method', 'Payment Status', 'Order Status',
                'Subtotal', 'Shipping', 'Discount', 'Total',
            ]);

            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->order_no,
                    optional($order->placed_at)->format('Y-m-d H:i'),
                    $order->shipping_name,
                    $order->shipping_phone,
                    $order->shipping_city,
                    strtoupper($order->payment_method),
                    $order->payment_status,
                    $order->status,
                    $order->subtotal,
                    $order->shipping_charge,
                    $order->discount,
                    $order->total,
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    private function parseFilters(Request $request): array
    {
        $from   = $request->filled('from') ? Carbon::parse($request->from)->startOfDay() : Carbon::now()->startOfMonth();
        $to     = $request->filled('to')   ? Carbon::parse($request->to)->endOfDay()     : Carbon::now()->endOfDay();
        $status = (string) $request->input('status', '');

        return [$from, $to, $status];
    }

    private function filteredOrders(Carbon $from, Carbon $to, string $status)
    {
        $query = Order::with('customer')
            ->whereBetween('placed_at', [$from, $to]);

        if ($status !== '') {
            $query->where('status', $status);
        }

        return $query->latest('placed_at')->get();
    }
}
