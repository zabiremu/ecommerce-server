<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerReportController extends Controller
{
    public function index(Request $request)
    {
        $from   = $request->filled('from') ? Carbon::parse($request->from)->startOfDay() : Carbon::now()->startOfMonth();
        $to     = $request->filled('to')   ? Carbon::parse($request->to)->endOfDay()     : Carbon::now()->endOfDay();
        $status = $request->input('status', '');
        $sortBy = $request->input('sort_by', 'total_spent');

        $query = Customer::withCount(['orders as period_orders' => function ($q) use ($from, $to) {
            $q->whereBetween('placed_at', [$from, $to])
              ->whereNotIn('status', ['cancelled', 'returned']);
        }])
        ->withSum(['orders as period_spent' => function ($q) use ($from, $to) {
            $q->whereBetween('placed_at', [$from, $to])
              ->whereNotIn('status', ['cancelled', 'returned']);
        }], 'total');

        if ($status !== '') {
            $query->where('status', $status === 'active' ? 1 : 0);
        }

        $allowedSorts = ['total_spent', 'total_orders', 'last_order_at', 'created_at'];
        $sortColumn = in_array($sortBy, $allowedSorts) ? $sortBy : 'total_spent';

        $customers = $query->orderByDesc($sortColumn)->get();

        $totalCustomers  = $customers->count();
        $activeCustomers = $customers->where('status', true)->count();
        $totalRevenue    = $customers->sum('period_spent');
        $newCustomers    = Customer::whereBetween('created_at', [$from, $to])->count();

        return view('Admin.customer_report.index', compact(
            'customers', 'from', 'to', 'status', 'sortBy',
            'totalCustomers', 'activeCustomers', 'totalRevenue', 'newCustomers'
        ));
    }
}
