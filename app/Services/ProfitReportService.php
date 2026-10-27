<?php

namespace App\Services;

use App\Models\DealsBanner;
use App\Models\Expense;
use App\Models\Investment;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Purchase;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Profit & loss for Accounts & Reports. All dates are local (Asia/Dhaka)
 * Y-m-d strings; orders.placed_at is stored in UTC and converted here.
 *
 *   Sales        = order totals (after discount, incl. shipping charged)
 *   Cost         = qty × purchase price snapshotted on each order line
 *   Gross profit = Sales − Cost
 *   Net profit   = Gross profit − Expenses
 *
 * Investments are money put into the business; they don't reduce profit.
 */
class ProfitReportService
{
    /** Pending (unconfirmed online), cancelled and returned orders are not sales. */
    public const COUNTED_STATUSES = ['confirmed', 'processing', 'shipped', 'delivered'];

    public static function today(): string
    {
        return now(DealsBanner::LOCAL_TZ)->toDateString();
    }

    /** Local date range → UTC datetimes for querying placed_at. */
    public static function utcRange(string $from, string $to): array
    {
        return [
            Carbon::parse($from, DealsBanner::LOCAL_TZ)->startOfDay()->utc(),
            Carbon::parse($to, DealsBanner::LOCAL_TZ)->endOfDay()->utc(),
        ];
    }

    public function countedOrders(string $from, string $to)
    {
        return Order::query()
            ->whereIn('orders.status', self::COUNTED_STATUSES)
            ->whereBetween('orders.placed_at', self::utcRange($from, $to));
    }

    private function countedItems(string $from, string $to)
    {
        return OrderItem::query()
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereIn('orders.status', self::COUNTED_STATUSES)
            ->whereBetween('orders.placed_at', self::utcRange($from, $to));
    }

    /** Totals for a date range. */
    public function summary(string $from, string $to): array
    {
        $orders = $this->countedOrders($from, $to);
        $items  = $this->countedItems($from, $to);

        $sales    = (float) (clone $orders)->sum('total');
        $cost     = (float) (clone $items)->sum(DB::raw('order_items.quantity * coalesce(order_items.unit_cost, 0)'));
        $expenses = (float) Expense::betweenDates($from, $to)->sum('amount');

        return $this->withProfit([
            'orders'       => (int) (clone $orders)->count(),
            'sales'        => $sales,
            'cost'         => $cost,
            'expenses'     => $expenses,
            'missing_cost' => (int) (clone $items)->where(fn ($q) => $q->whereNull('order_items.unit_cost')->orWhere('order_items.unit_cost', '<=', 0))->count(),
        ]);
    }

    /** Counted orders in the range, each with its `cost` (sum of its lines). */
    public function orders(string $from, string $to): Collection
    {
        return $this->countedOrders($from, $to)
            ->select('orders.id', 'orders.order_no', 'orders.source', 'orders.shipping_name', 'orders.status', 'orders.total', 'orders.placed_at')
            ->selectSub(
                OrderItem::query()->whereColumn('order_items.order_id', 'orders.id')
                    ->selectRaw('coalesce(sum(quantity * coalesce(unit_cost, 0)), 0)'),
                'cost'
            )
            ->orderBy('orders.placed_at')
            ->get()
            ->each(fn (Order $o) => $o->setAttribute('profit', round((float) $o->total - (float) $o->cost, 2)));
    }

    /** One row per local day in [from, to], keyed by date. */
    public function daily(string $from, string $to): array
    {
        $days = [];
        foreach (CarbonPeriod::create($from, $to) as $date) {
            $days[$date->toDateString()] = ['orders' => 0, 'sales' => 0.0, 'cost' => 0.0, 'expenses' => 0.0];
        }

        foreach ($this->orders($from, $to) as $order) {
            $day = $order->placed_at->copy()->setTimezone(DealsBanner::LOCAL_TZ)->toDateString();
            if (!isset($days[$day])) continue;
            $days[$day]['orders']++;
            $days[$day]['sales'] += (float) $order->total;
            $days[$day]['cost']  += (float) $order->cost;
        }

        $expenses = Expense::betweenDates($from, $to)
            ->groupBy('expense_date')
            ->selectRaw('expense_date, sum(amount) as total')
            ->get();
        foreach ($expenses as $row) {
            $day = Carbon::parse($row->getRawOriginal('expense_date'))->toDateString();
            if (isset($days[$day])) $days[$day]['expenses'] += (float) $row->total;
        }

        return array_map(fn ($d) => $this->withProfit($d), $days);
    }

    /** Profit per product sold in the range, best earners first. */
    public function productWise(string $from, string $to): Collection
    {
        // A product's share of an order discount is taken off its revenue.
        return $this->countedItems($from, $to)
            ->groupBy('order_items.product_id')
            ->selectRaw('order_items.product_id,
                max(order_items.product_name) as product_name,
                max(order_items.product_sku) as product_sku,
                sum(order_items.quantity) as qty,
                sum(order_items.total * case when orders.subtotal > 0 then 1 - orders.discount / orders.subtotal else 1 end) as revenue,
                sum(order_items.quantity * coalesce(order_items.unit_cost, 0)) as cost,
                sum(case when coalesce(order_items.unit_cost, 0) <= 0 then 1 else 0 end) as missing_cost')
            ->get()
            ->map(function ($row) {
                $revenue = round((float) $row->revenue, 2);
                $cost    = round((float) $row->cost, 2);
                $profit  = round($revenue - $cost, 2);

                return (object) [
                    'product_id'   => $row->product_id,
                    'name'         => $row->product_name,
                    'sku'          => $row->product_sku,
                    'qty'          => (float) $row->qty,
                    'revenue'      => $revenue,
                    'cost'         => $cost,
                    'profit'       => $profit,
                    'margin'       => $revenue > 0 ? round($profit / $revenue * 100, 1) : 0,
                    'missing_cost' => (int) $row->missing_cost > 0,
                ];
            })
            ->sortByDesc('profit')
            ->values();
    }

    /**
     * Money invested: hand-entered investments plus stock bought from
     * suppliers (non-cancelled purchases). Null dates = all time.
     */
    public function investmentTotals(?string $from = null, ?string $to = null): array
    {
        $manual = Investment::query();
        $stock  = Purchase::query()->where('status', '!=', 'cancelled');
        if ($from && $to) {
            $manual->betweenDates($from, $to);
            $stock->whereBetween('purchase_date', [$from, $to]);
        }

        $manual = (float) $manual->sum('amount');
        $stock  = (float) $stock->sum('total_amount');

        return ['manual' => $manual, 'stock' => $stock, 'total' => round($manual + $stock, 2)];
    }

    private function withProfit(array $row): array
    {
        $row['sales']    = round($row['sales'], 2);
        $row['cost']     = round($row['cost'], 2);
        $row['expenses'] = round($row['expenses'], 2);
        $row['gross']    = round($row['sales'] - $row['cost'], 2);
        $row['net']      = round($row['gross'] - $row['expenses'], 2);

        return $row;
    }
}
