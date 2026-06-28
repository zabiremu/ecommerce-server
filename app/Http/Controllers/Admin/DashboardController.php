<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $now       = Carbon::now();
        $thisMonth = $now->copy()->startOfMonth();
        $lastMonth = $now->copy()->subMonth()->startOfMonth();
        $lastMonthEnd = $now->copy()->subMonth()->endOfMonth();

        // ── Stat cards ────────────────────────────────────────────────
        $revenueThisMonth = (float) Order::whereIn('status', ['delivered'])
            ->where('placed_at', '>=', $thisMonth)
            ->sum('total');

        $revenueLastMonth = (float) Order::whereIn('status', ['delivered'])
            ->whereBetween('placed_at', [$lastMonth, $lastMonthEnd])
            ->sum('total');

        $revenuePct = $revenueLastMonth > 0
            ? round((($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100, 1)
            : null;

        $totalOrders   = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();

        $ordersThisMonth = Order::where('placed_at', '>=', $thisMonth)->count();
        $ordersLastMonth = Order::whereBetween('placed_at', [$lastMonth, $lastMonthEnd])->count();
        $ordersPct = $ordersLastMonth > 0
            ? round((($ordersThisMonth - $ordersLastMonth) / $ordersLastMonth) * 100, 1)
            : null;

        $totalCustomers  = Customer::count();
        $newCustomers    = Customer::where('created_at', '>=', $now->copy()->subDays(7))->count();
        $customersLastWk = Customer::whereBetween('created_at', [
            $now->copy()->subDays(14), $now->copy()->subDays(7)
        ])->count();
        $customersPct = $customersLastWk > 0
            ? round((($newCustomers - $customersLastWk) / $customersLastWk) * 100, 1)
            : null;

        $totalProducts    = Product::published()->count();
        $outOfStockCount  = Product::published()->where('type', 'physical')->where('stock', '<=', 0)->count();

        // ── Sales chart — last 7 days ──────────────────────────────────
        $salesData = Order::whereNotIn('status', ['cancelled', 'returned'])
            ->where('placed_at', '>=', $now->copy()->subDays(6)->startOfDay())
            ->select(DB::raw('DATE(placed_at) as sale_date'), DB::raw('SUM(total) as day_total'))
            ->groupBy('sale_date')
            ->pluck('day_total', 'sale_date')
            ->map(fn ($v) => (float) $v);

        $bars = [];
        $maxVal = max($salesData->max() ?: 1, 1);
        for ($i = 6; $i >= 0; $i--) {
            $date   = $now->copy()->subDays($i)->toDateString();
            $dayVal = $salesData->get($date, 0);
            $bars[] = [
                'day' => $now->copy()->subDays($i)->format('D'),
                'h'   => max(4, (int) round(($dayVal / $maxVal) * 100)),
                'val' => $dayVal >= 1000
                    ? 'TK ' . number_format($dayVal / 1000, 1) . 'k'
                    : 'TK ' . number_format($dayVal),
            ];
        }

        // ── Recent orders ───────────────────────────────────────────────
        $recentOrders = Order::with('customer')
            ->latest('id')
            ->limit(6)
            ->get()
            ->map(fn (Order $o) => [
                'name'   => $o->shipping_name,
                'order'  => '#' . $o->order_no,
                'amt'    => 'TK ' . number_format($o->total),
                'status' => $o->status,
                'url'    => route('admin.orders.show', $o),
            ]);

        // ── Top selling products ────────────────────────────────────────
        $topProducts = OrderItem::query()
            ->select('product_id', 'product_name',
                DB::raw('SUM(quantity) as sold'),
                DB::raw('SUM(total) as revenue'))
            ->whereHas('order', fn ($q) => $q->whereNotIn('status', ['cancelled', 'returned']))
            ->groupBy('product_id', 'product_name')
            ->orderByDesc('sold')
            ->limit(5)
            ->get()
            ->map(fn ($item) => [
                'name'    => $item->product_name,
                'cat'     => optional(Product::find($item->product_id))->category?->name ?? '—',
                'sold'    => (int) $item->sold,
                'rev'     => 'TK ' . number_format($item->revenue),
                'product_id' => $item->product_id,
            ]);

        // ── Recent activity feed ────────────────────────────────────────
        $activity = collect();

        // Recent orders
        Order::latest('id')->limit(3)->get()->each(function (Order $o) use (&$activity) {
            $activity->push([
                'type'    => 'order',
                'icon'    => 'fas fa-shopping-bag',
                'color'   => 'bg-blue-50 text-blue-600',
                'message' => 'New order <strong>#' . $o->order_no . '</strong> placed by ' . $o->shipping_name,
                'time'    => optional($o->placed_at ?? $o->created_at)->diffForHumans(),
                'ts'      => optional($o->placed_at ?? $o->created_at)->timestamp ?? 0,
            ]);
        });

        // Delivered orders recently
        Order::where('status', 'delivered')->latest('updated_at')->limit(2)->get()->each(function (Order $o) use (&$activity) {
            $activity->push([
                'type'    => 'delivered',
                'icon'    => 'fas fa-check',
                'color'   => 'bg-emerald-50 text-emerald-600',
                'message' => 'Order <strong>#' . $o->order_no . '</strong> delivered',
                'time'    => optional($o->updated_at)->diffForHumans(),
                'ts'      => optional($o->updated_at)->timestamp ?? 0,
            ]);
        });

        // New customers
        Customer::latest('id')->limit(2)->get()->each(function (Customer $c) use (&$activity) {
            $activity->push([
                'type'    => 'customer',
                'icon'    => 'fas fa-user-plus',
                'color'   => 'bg-purple-50 text-purple-600',
                'message' => '<strong>' . $c->name . '</strong> is a new customer',
                'time'    => optional($c->created_at)->diffForHumans(),
                'ts'      => optional($c->created_at)->timestamp ?? 0,
            ]);
        });

        // Low stock alerts
        Product::published()
            ->where('type', 'physical')
            ->where('stock', '>', 0)
            ->where('stock', '<=', 5)
            ->latest('updated_at')
            ->limit(3)
            ->get()
            ->each(function (Product $p) use (&$activity) {
                $activity->push([
                    'type'    => 'alert',
                    'icon'    => 'fas fa-triangle-exclamation',
                    'color'   => 'bg-amber-50 text-amber-600',
                    'message' => 'Low stock: <strong>' . $p->name . '</strong> (' . (int)$p->stock . ' left)',
                    'time'    => optional($p->updated_at)->diffForHumans(),
                    'ts'      => optional($p->updated_at)->timestamp ?? 0,
                ]);
            });

        // Out of stock
        Product::published()
            ->where('type', 'physical')
            ->where('stock', '<=', 0)
            ->latest('updated_at')
            ->limit(2)
            ->get()
            ->each(function (Product $p) use (&$activity) {
                $activity->push([
                    'type'    => 'oos',
                    'icon'    => 'fas fa-times-circle',
                    'color'   => 'bg-rose-50 text-rose-600',
                    'message' => '<strong>' . $p->name . '</strong> is out of stock',
                    'time'    => optional($p->updated_at)->diffForHumans(),
                    'ts'      => optional($p->updated_at)->timestamp ?? 0,
                ]);
            });

        $activity = $activity->sortByDesc('ts')->values()->take(7);

        return view('Admin.dashboard', compact(
            'revenueThisMonth', 'revenueLastMonth', 'revenuePct',
            'totalOrders', 'pendingOrders', 'ordersThisMonth', 'ordersLastMonth', 'ordersPct',
            'totalCustomers', 'newCustomers', 'customersPct',
            'totalProducts', 'outOfStockCount',
            'bars', 'recentOrders', 'topProducts', 'activity'
        ));
    }

    public function liveVisitors()
    {
        $count = DB::table('visitor_sessions')
            ->where('last_seen_at', '>=', now()->subMinutes(5))
            ->count();

        return response()->json(['count' => $count]);
    }

    public function visitorStats(Request $request)
    {
        $today = now()->toDateString();

        $todayCount = DB::table('visitor_logs')
            ->where('visited_date', $today)
            ->count();

        $from = $request->input('from');
        $to   = $request->filled('to') ? $request->input('to') : $from;

        $queried = null;
        if ($from) {
            // Per-day breakdown within the range
            $rows = DB::table('visitor_logs')
                ->selectRaw('visited_date, COUNT(*) as cnt')
                ->whereBetween('visited_date', [$from, $to])
                ->groupBy('visited_date')
                ->orderBy('visited_date')
                ->get();

            $queried = [
                'total' => $rows->sum('cnt'),
                'from'  => $from,
                'to'    => $to,
                'days'  => $rows->map(fn ($r) => [
                    'date'  => $r->visited_date,
                    'count' => (int) $r->cnt,
                ])->values(),
            ];
        }

        return response()->json([
            'today'   => $todayCount,
            'queried' => $queried,
        ]);
    }
}
