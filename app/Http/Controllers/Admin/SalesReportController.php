<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {
        $from   = $request->filled('from') ? Carbon::parse($request->from)->startOfDay() : Carbon::now()->startOfMonth();
        $to     = $request->filled('to')   ? Carbon::parse($request->to)->endOfDay()     : Carbon::now()->endOfDay();
        $status = $request->input('status', '');

        $query = Order::with('customer')
            ->whereBetween('placed_at', [$from, $to]);

        if ($status !== '') {
            $query->where('status', $status);
        }

        $orders = $query->latest('placed_at')->get();

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
}
