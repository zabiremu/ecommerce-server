@extends('Admin.Layout.app')

@section('title', 'Monthly Report')
@section('page_title', 'Accounts & Reports')

@push('styles')
@include('Admin.accounts._styles')
@endpush

@section('content')
@php
    $money = fn ($v) => \App\Support\Money::format($v);
    $expenseCategories = \App\Models\Expense::categories();
    $maxNet = max(1, collect($days)->max(fn ($d) => abs($d['net'])));
@endphp

<div class="flex flex-wrap items-center justify-between gap-3 mb-4">
    <div class="flex items-center gap-3">
        <h1 class="wp-h1">Monthly Report</h1>
        <span class="text-[14px] text-[#50575e]">{{ $start->format('F Y') }}</span>
    </div>
    <form method="GET" action="{{ route('admin.accounts.monthly') }}" class="acc-nav">
        <a href="{{ route('admin.accounts.monthly', ['month' => $prevMonth]) }}" class="wp-btn" title="Previous month"><i class="fas fa-chevron-left"></i></a>
        <input type="month" name="month" value="{{ $month }}" max="{{ now(\App\Models\DealsBanner::LOCAL_TZ)->format('Y-m') }}" class="wp-input" style="width:170px" onchange="this.form.submit()">
        @if ($nextMonth)
            <a href="{{ route('admin.accounts.monthly', ['month' => $nextMonth]) }}" class="wp-btn" title="Next month"><i class="fas fa-chevron-right"></i></a>
        @endif
        <a href="{{ route('admin.accounts.products', ['from' => $from, 'to' => $to]) }}" class="wp-btn"><i class="fas fa-tags mr-1"></i> Product profit</a>
    </form>
</div>

@include('Admin.accounts._summary')

<div class="grid grid-cols-12 gap-5">
    <div class="col-span-12 lg:col-span-8">
        <div class="wp-panel">
            <div class="wp-panel-h">Day by Day</div>
            <div class="wp-panel-body" style="padding:0">
                <div style="overflow-x:auto">
                <table class="wp-list-table" style="border:0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th class="text-center">Orders</th>
                            <th class="text-right">Sales</th>
                            <th class="text-right">Cost</th>
                            <th class="text-right">Expenses</th>
                            <th class="text-right">Net Profit</th>
                            <th style="width:90px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($days as $date => $d)
                            @php $empty = $d['orders'] === 0 && $d['expenses'] == 0; @endphp
                            <tr class="{{ $empty ? 'text-[#a7aaad]' : '' }}">
                                <td><a href="{{ route('admin.accounts.daily', ['date' => $date]) }}" class="text-[#2271b1]">{{ \Illuminate\Support\Carbon::parse($date)->format('d M, D') }}</a></td>
                                <td class="text-center">{{ $d['orders'] }}</td>
                                <td class="text-right">{{ $money($d['sales']) }}</td>
                                <td class="text-right">{{ $money($d['cost']) }}</td>
                                <td class="text-right">{{ $money($d['expenses']) }}</td>
                                <td class="text-right"><strong class="{{ $empty ? '' : ($d['net'] < 0 ? 'amt-neg' : 'amt-pos') }}">{{ $money($d['net']) }}</strong></td>
                                <td>
                                    <div class="bar-track"><div class="bar-fill" style="width:{{ (int) round(abs($d['net']) / $maxNet * 100) }}%;{{ $d['net'] < 0 ? 'background:#d63638' : '' }}"></div></div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Month total</td>
                            <td class="text-center">{{ $summary['orders'] }}</td>
                            <td class="text-right">{{ $money($summary['sales']) }}</td>
                            <td class="text-right">{{ $money($summary['cost']) }}</td>
                            <td class="text-right">{{ $money($summary['expenses']) }}</td>
                            <td class="text-right">{{ $money($summary['net']) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-4 space-y-5">
        <div class="wp-panel">
            <div class="wp-panel-h">
                <span>Expenses by Category</span>
                @if (Auth::guard('admin')->user()->hasPermission('expenses.view'))
                    <a href="{{ route('admin.expenses.index', ['month' => $month]) }}" class="text-[12px] font-normal text-[#2271b1]">View all</a>
                @endif
            </div>
            <div class="wp-panel-body" style="padding:0">
                <table class="wp-list-table" style="border:0">
                    <tbody>
                        @forelse ($expenseByCategory as $row)
                            <tr>
                                <td>{{ $expenseCategories[$row->category] ?? $row->category }} <span class="text-[11px] text-[#646970]">({{ $row->entries }})</span></td>
                                <td class="text-right">{{ $money($row->total) }}</td>
                            </tr>
                        @empty
                            <tr><td class="text-center text-[#646970] py-6">No expenses this month.</td></tr>
                        @endforelse
                    </tbody>
                    @if ($expenseByCategory->isNotEmpty())
                    <tfoot><tr><td>Total</td><td class="text-right">{{ $money($summary['expenses']) }}</td></tr></tfoot>
                    @endif
                </table>
            </div>
        </div>

        <div class="wp-panel">
            <div class="wp-panel-h">
                <span>Investment this Month</span>
                @if (Auth::guard('admin')->user()->hasPermission('investments.view'))
                    <a href="{{ route('admin.investments.index', ['month' => $month]) }}" class="text-[12px] font-normal text-[#2271b1]">View list</a>
                @endif
            </div>
            <div class="wp-panel-body" style="padding:0">
                <table class="wp-list-table" style="border:0">
                    <tbody>
                        <tr><td>Stock bought (Purchases)</td><td class="text-right">{{ $money($investment['stock']) }}</td></tr>
                        <tr><td>Other investment</td><td class="text-right">{{ $money($investment['manual']) }}</td></tr>
                    </tbody>
                    <tfoot><tr><td>Total</td><td class="text-right">{{ $money($investment['total']) }}</td></tr></tfoot>
                </table>
            </div>
        </div>

        <p class="acc-note">Investment is money put into the business — it is not subtracted from profit. Pending, cancelled and returned orders are not counted as sales.</p>
    </div>
</div>

@endsection
