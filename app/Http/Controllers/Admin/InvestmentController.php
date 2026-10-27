<?php

namespace App\Http\Controllers\Admin;

use App\Models\Investment;
use App\Models\Purchase;
use App\Services\ProfitReportService;

/** Money put into the business, month by month. Stock purchases are added automatically. */
class InvestmentController extends LedgerController
{
    protected function model(): string
    {
        return Investment::class;
    }

    protected function config(): array
    {
        return [
            'route'    => 'admin.investments',
            'singular' => 'Investment',
            'plural'   => 'Investments',
            'icon'     => 'fa-sack-dollar',
            'intro'    => 'Money put into the business — shop setup, equipment, capital. Not counted as an expense.',
        ];
    }

    protected function monthExtras(string $from, string $to): array
    {
        $totals = app(ProfitReportService::class)->investmentTotals($from, $to);

        return [
            'stock_total' => $totals['stock'],
            'month_total' => $totals['total'],
            'all_time'    => app(ProfitReportService::class)->investmentTotals()['total'],
            'purchases'   => Purchase::with('supplier:id,name')
                ->where('status', '!=', 'cancelled')
                ->whereBetween('purchase_date', [$from, $to])
                ->orderByDesc('purchase_date')->orderByDesc('id')
                ->get(['id', 'supplier_id', 'invoice_no', 'purchase_date', 'total_amount', 'status']),
        ];
    }
}
