<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\Investment;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Single source of truth for every profit number in the admin.
 *
 *   Sales        = Σ order.total  (after discount, incl. shipping charged to customer)
 *   Product Cost = Σ item.quantity × item.cost_price  (purchase price snapshot)
 *   Gross Profit = Sales − Product Cost
 *   Expenses     = Σ expenses in the period (rent, salary, courier, ...)
 *   Net Profit   = Gross Profit − Expenses
 *
 * Everything is computed live from orders/expenses, so reports update
 * automatically the moment an order, expense or status changes.
 */
class ProfitService
{
    /** Orders in these statuses are not counted as sales. */
    public const EXCLUDED_STATUSES = ['cancelled', 'returned'];

    // ── Period summary ───────────────────────────────────────────────────

    public function summary(Carbon $from, Carbon $to): array
    {
        $orders = $this->salesOrders($from, $to);

        $sales     = (float) (clone $orders)->sum('total');
        $subtotal  = (float) (clone $orders)->sum('subtotal');
        $discount  = (float) (clone $orders)->sum('discount');
        $shipping  = (float) (clone $orders)->sum('shipping_charge');
        $count     = (int) (clone $orders)->count();

        $cogs     = $this->productCost($from, $to);
        $expenses = (float) Expense::whereBetween('expense_date', [$from->toDateString(), $to->toDateString()])->sum('amount');
        $invest   = (float) Investment::whereBetween('investment_date', [$from->toDateString(), $to->toDateString()])->sum('amount');

        $gross = $sales - $cogs;
        $net   = $gross - $expenses;

        return [
            'orders'       => $count,
            'sales'        => $sales,
            'subtotal'     => $subtotal,
            'discount'     => $discount,
            'shipping'     => $shipping,
            'product_cost' => $cogs,
            'gross_profit' => $gross,
            'expenses'     => $expenses,
            'net_profit'   => $net,
            'investments'  => $invest,
            'margin'       => $sales > 0 ? round(($net / $sales) * 100, 1) : 0.0,
        ];
    }

    // ── Day-by-day rows for one month ────────────────────────────────────

    public function dailyBreakdown(Carbon $month): Collection
    {
        $from = $month->copy()->startOfMonth();
        $to   = $month->copy()->endOfMonth();

        $sales = $this->salesOrders($from, $to)
            ->selectRaw('DATE(placed_at) as d, SUM(total) as sales, COUNT(*) as orders')
            ->groupBy('d')->get()->keyBy('d');

        $cost = $this->costQuery($from, $to)
            ->selectRaw('DATE(orders.placed_at) as d, SUM(' . $this->costExpr() . ') as cost')
            ->groupBy('d')->pluck('cost', 'd');

        $exp = Expense::whereBetween('expense_date', [$from->toDateString(), $to->toDateString()])
            ->selectRaw('expense_date as d, SUM(amount) as amt')
            ->groupBy('expense_date')->get()
            ->mapWithKeys(fn ($r) => [Carbon::parse($r->d)->toDateString() => (float) $r->amt]);

        $rows = collect();
        $last = $to->isFuture() ? Carbon::today() : $to;
        for ($d = $from->copy(); $d->lte($last); $d->addDay()) {
            $key = $d->toDateString();
            $s = (float) ($sales[$key]->sales ?? 0);
            $c = (float) ($cost[$key] ?? 0);
            $e = (float) ($exp[$key] ?? 0);
            $rows->push([
                'date'         => $d->copy(),
                'orders'       => (int) ($sales[$key]->orders ?? 0),
                'sales'        => $s,
                'product_cost' => $c,
                'gross_profit' => $s - $c,
                'expenses'     => $e,
                'net_profit'   => $s - $c - $e,
            ]);
        }

        return $rows->reverse()->values();
    }

    // ── Month-by-month rows for one year ─────────────────────────────────

    public function monthlyBreakdown(int $year): Collection
    {
        $rows = collect();
        for ($m = 1; $m <= 12; $m++) {
            $start = Carbon::create($year, $m, 1)->startOfMonth();
            if ($start->isFuture()) break;
            $rows->push(['month' => $start] + $this->summary($start, $start->copy()->endOfMonth()));
        }

        return $rows->reverse()->values();
    }

    // ── Profit per product ───────────────────────────────────────────────

    public function productWise(Carbon $from, Carbon $to): Collection
    {
        return $this->costQuery($from, $to)
            ->selectRaw('order_items.product_id, MAX(order_items.product_name) as product_name, MAX(order_items.product_sku) as sku,
                SUM(order_items.quantity) as qty,
                SUM(order_items.total) as revenue,
                SUM(' . $this->costExpr() . ') as cost')
            ->groupBy('order_items.product_id')
            ->get()
            ->map(function ($r) {
                $revenue = (float) $r->revenue;
                $cost    = (float) $r->cost;
                $profit  = $revenue - $cost;
                return [
                    'product_id' => $r->product_id,
                    'name'       => $r->product_name,
                    'sku'        => $r->sku,
                    'qty'        => (float) $r->qty,
                    'revenue'    => $revenue,
                    'cost'       => $cost,
                    'profit'     => $profit,
                    'per_unit'   => $r->qty > 0 ? $profit / $r->qty : 0,
                    'margin'     => $revenue > 0 ? round(($profit / $revenue) * 100, 1) : 0.0,
                ];
            })
            ->sortByDesc('profit')
            ->values();
    }

    // ── All-time totals (dashboard) ──────────────────────────────────────

    public function totalInvestment(): float
    {
        return (float) Investment::sum('amount');
    }

    public function totalExpenses(): float
    {
        return (float) Expense::sum('amount');
    }

    // ── Internals ────────────────────────────────────────────────────────

    private function salesOrders(Carbon $from, Carbon $to)
    {
        return Order::query()
            ->whereBetween('placed_at', [$from->copy()->startOfDay(), $to->copy()->endOfDay()])
            ->whereNotIn('status', self::EXCLUDED_STATUSES);
    }

    private function productCost(Carbon $from, Carbon $to): float
    {
        return (float) $this->costQuery($from, $to)->sum(DB::raw($this->costExpr()));
    }

    private function costQuery(Carbon $from, Carbon $to)
    {
        return DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
            ->whereBetween('orders.placed_at', [$from->copy()->startOfDay(), $to->copy()->endOfDay()])
            ->whereNotIn('orders.status', self::EXCLUDED_STATUSES);
    }

    private function costExpr(): string
    {
        return 'order_items.quantity * COALESCE(order_items.cost_price, products.purchase_price, 0)';
    }
}
