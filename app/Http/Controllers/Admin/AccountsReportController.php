<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Services\ProfitReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/** Accounts & Reports — daily, monthly and product-wise profit. */
class AccountsReportController extends Controller
{
    public function __construct(private ProfitReportService $profit)
    {
    }

    public function daily(Request $request)
    {
        $today = ProfitReportService::today();
        $date  = self::parseDate($request->query('date')) ?? $today;
        if ($date > $today) $date = $today;

        $summary  = $this->profit->summary($date, $date);
        $orders   = $this->profit->orders($date, $date);
        $products = $this->profit->productWise($date, $date);
        $expenses = Expense::betweenDates($date, $date)->latest('id')->get();

        $prevDate = Carbon::parse($date)->subDay()->toDateString();
        $nextDate = $date < $today ? Carbon::parse($date)->addDay()->toDateString() : null;

        return view('Admin.accounts.daily', compact('date', 'today', 'summary', 'orders', 'products', 'expenses', 'prevDate', 'nextDate'));
    }

    public function monthly(Request $request)
    {
        $today = ProfitReportService::today();
        $month = self::parseMonth($request->query('month')) ?? substr($today, 0, 7);
        if ($month > substr($today, 0, 7)) $month = substr($today, 0, 7);

        $start = Carbon::parse($month . '-01');
        $from  = $start->toDateString();
        $to    = $start->copy()->endOfMonth()->toDateString();
        // Current month: only the days so far.
        $lastDay = min($to, $today);

        $summary = $this->profit->summary($from, $to);
        $days    = array_reverse($this->profit->daily($from, $lastDay), true);
        $investment = $this->profit->investmentTotals($from, $to);

        $expenseByCategory = Expense::betweenDates($from, $to)
            ->groupBy('category')
            ->selectRaw('category, sum(amount) as total, count(*) as entries')
            ->orderByDesc('total')
            ->get();

        $prevMonth = $start->copy()->subMonth()->format('Y-m');
        $nextMonth = $month < substr($today, 0, 7) ? $start->copy()->addMonth()->format('Y-m') : null;

        return view('Admin.accounts.monthly', compact(
            'month', 'start', 'from', 'to', 'summary', 'days', 'investment', 'expenseByCategory', 'prevMonth', 'nextMonth'
        ));
    }

    public function products(Request $request)
    {
        $today = ProfitReportService::today();
        $from  = self::parseDate($request->query('from')) ?? substr($today, 0, 8) . '01';
        $to    = self::parseDate($request->query('to')) ?? $today;
        if ($from > $to) [$from, $to] = [$to, $from];

        $products = $this->profit->productWise($from, $to);
        $totals = [
            'qty'     => $products->sum('qty'),
            'revenue' => round($products->sum('revenue'), 2),
            'cost'    => round($products->sum('cost'), 2),
            'profit'  => round($products->sum('profit'), 2),
        ];
        $missingCost = $products->where('missing_cost', true)->count();

        return view('Admin.accounts.products', compact('from', 'to', 'today', 'products', 'totals', 'missingCost'));
    }

    public static function parseDate($value): ?string
    {
        if (!is_string($value) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) return null;
        try {
            return Carbon::createFromFormat('!Y-m-d', $value)->toDateString();
        } catch (\Throwable) {
            return null;
        }
    }

    public static function parseMonth($value): ?string
    {
        if (!is_string($value) || !preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $value)) return null;

        return $value;
    }
}
