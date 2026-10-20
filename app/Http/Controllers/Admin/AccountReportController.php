<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Investment;
use App\Models\Purchase;
use App\Services\ProfitService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AccountReportController extends Controller
{
    public function __construct(private ProfitService $profit) {}

    /** Daily Profit Report — one date's numbers + day-by-day list of the month. */
    public function daily(Request $request)
    {
        $date  = $this->parseDate($request->input('date'));
        $day   = $this->profit->summary($date->copy()->startOfDay(), $date->copy()->endOfDay());
        $rows  = $this->profit->dailyBreakdown($date);
        $products = $this->profit->productWise($date->copy()->startOfDay(), $date->copy()->endOfDay());
        $dayExpenses = Expense::with('category')->whereDate('expense_date', $date)->latest('id')->get();

        return view('Admin.accounts.daily', compact('date', 'day', 'rows', 'products', 'dayExpenses'));
    }

    /** Monthly Profit Report + that month's investment & expense lists. */
    public function monthly(Request $request)
    {
        $month = $this->parseMonth($request->input('month'));
        $from  = $month->copy()->startOfMonth();
        $to    = $month->copy()->endOfMonth();

        $summary = $this->profit->summary($from, $to);
        $year    = $this->profit->monthlyBreakdown((int) $month->year);

        $expenses     = Expense::with('category')->whereBetween('expense_date', [$from->toDateString(), $to->toDateString()])->orderBy('expense_date')->get();
        $expenseByCat = $expenses->groupBy(fn ($e) => $e->category?->name ?? 'Uncategorized')->map->sum('amount')->sortDesc();

        $investments     = Investment::with('category')->whereBetween('investment_date', [$from->toDateString(), $to->toDateString()])->orderBy('investment_date')->get();
        $investmentByCat = $investments->groupBy(fn ($i) => $i->category?->name ?? 'Uncategorized')->map->sum('amount')->sortDesc();
        $purchases       = Purchase::with('supplier')->where('status', '!=', 'cancelled')
            ->whereBetween('purchase_date', [$from->toDateString(), $to->toDateString()])->orderBy('purchase_date')->get();

        return view('Admin.accounts.monthly', compact(
            'month', 'summary', 'year', 'expenses', 'expenseByCat', 'investments', 'investmentByCat', 'purchases'
        ));
    }

    /** Product-wise Profit for any date range. */
    public function products(Request $request)
    {
        [$from, $to] = $this->parseRange($request);
        $rows = $this->profit->productWise($from, $to);

        $totals = [
            'qty'     => $rows->sum('qty'),
            'revenue' => $rows->sum('revenue'),
            'cost'    => $rows->sum('cost'),
            'profit'  => $rows->sum('profit'),
        ];

        return view('Admin.accounts.products', compact('from', 'to', 'rows', 'totals'));
    }

    /** CSV of the month (day-wise rows). */
    public function export(Request $request): StreamedResponse
    {
        $month = $this->parseMonth($request->input('month'));
        $rows  = $this->profit->dailyBreakdown($month)->reverse();

        return response()->streamDownload(function () use ($rows) {
            $h = fopen('php://output', 'w');
            fputcsv($h, ['Date', 'Orders', 'Sales', 'Product Cost', 'Gross Profit', 'Expenses', 'Net Profit']);
            foreach ($rows as $r) {
                fputcsv($h, [$r['date']->toDateString(), $r['orders'], $r['sales'], $r['product_cost'], $r['gross_profit'], $r['expenses'], $r['net_profit']]);
            }
            fclose($h);
        }, 'profit-report_' . $month->format('Y-m') . '.csv', ['Content-Type' => 'text/csv']);
    }

    // ── Helpers ──────────────────────────────────────────────────────────

    private function parseDate(?string $v): Carbon
    {
        try { $d = $v ? Carbon::parse($v) : Carbon::today(); } catch (\Throwable) { $d = Carbon::today(); }
        return $d->isFuture() ? Carbon::today() : $d->startOfDay();
    }

    private function parseMonth(?string $v): Carbon
    {
        try { $m = $v ? Carbon::createFromFormat('Y-m', $v)->startOfMonth() : Carbon::now()->startOfMonth(); }
        catch (\Throwable) { $m = Carbon::now()->startOfMonth(); }
        return $m;
    }

    private function parseRange(Request $request): array
    {
        try {
            $from = $request->filled('from') ? Carbon::parse($request->from)->startOfDay() : Carbon::now()->startOfMonth();
            $to   = $request->filled('to') ? Carbon::parse($request->to)->endOfDay() : Carbon::now()->endOfDay();
        } catch (\Throwable) {
            $from = Carbon::now()->startOfMonth();
            $to   = Carbon::now()->endOfDay();
        }
        return $from->gt($to) ? [$to->copy()->startOfDay(), $from->copy()->endOfDay()] : [$from, $to];
    }
}
