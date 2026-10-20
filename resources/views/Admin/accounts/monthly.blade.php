@extends('Admin.Layout.app')

@section('title', 'Monthly Profit Report')
@section('page_title', 'Monthly Profit Report')

@push('styles')
@include('Admin.accounts._styles')
@endpush

@php($money = fn ($v) => \App\Support\Money::format($v))

@section('content')

<h1 class="wp-h1">Accounts &amp; Reports</h1>
@include('Admin.accounts._tabs')

<form method="GET" action="{{ route('admin.accounts.monthly') }}" class="report-filters">
    <label><i class="fas fa-calendar text-[#787c82]"></i> Month:
        <input type="month" name="month" value="{{ $month->format('Y-m') }}" max="{{ now()->format('Y-m') }}">
    </label>
    <button type="submit" class="wp-btn wp-btn-primary"><i class="fas fa-search mr-1"></i> Show</button>
    <a href="{{ route('admin.accounts.monthly', ['month' => $month->copy()->subMonth()->format('Y-m')]) }}" class="wp-btn"><i class="fas fa-chevron-left"></i> Prev</a>
    @if($month->lt(now()->startOfMonth()))
        <a href="{{ route('admin.accounts.monthly', ['month' => $month->copy()->addMonth()->format('Y-m')]) }}" class="wp-btn">Next <i class="fas fa-chevron-right"></i></a>
    @endif
    <a href="{{ route('admin.accounts.export', ['month' => $month->format('Y-m')]) }}" class="wp-btn"><i class="fas fa-file-csv mr-1"></i> Export CSV</a>
    <button type="button" onclick="window.print()" class="wp-btn"><i class="fas fa-print mr-1"></i> Print</button>
</form>

<p class="text-[13px] text-[#50575e] mb-3"><strong>{{ $month->format('F Y') }}</strong> — {{ number_format($summary['orders']) }} order(s)</p>

<div class="stat-cards">
    <div class="stat-card"><div class="label">Total Sales</div><div class="value">{{ $money($summary['sales']) }}</div><div class="sub">Excl. cancelled &amp; returned</div></div>
    <div class="stat-card"><div class="label">Product Cost</div><div class="value">{{ $money($summary['product_cost']) }}</div><div class="sub">Purchase price of items sold</div></div>
    <div class="stat-card"><div class="label">Total Expenses</div><div class="value">{{ $money($summary['expenses']) }}</div><div class="sub">{{ $expenses->count() }} entries</div></div>
    <div class="stat-card hl"><div class="label">Net Profit</div><div class="value {{ $summary['net_profit'] >= 0 ? 'pos' : 'neg' }}">{{ $money($summary['net_profit']) }}</div><div class="sub">Margin {{ $summary['margin'] }}%</div></div>
    <div class="stat-card"><div class="label">Investment</div><div class="value">{{ $money($summary['investments']) }}</div><div class="sub">{{ $investments->count() }} entries this month</div></div>
</div>

<div class="calc-box mb-2">
    <div class="row"><span>Products sold (subtotal)</span><span class="num">{{ $money($summary['subtotal']) }}</span></div>
    <div class="row"><span>+ Shipping charged to customers</span><span class="num">{{ $money($summary['shipping']) }}</span></div>
    <div class="row"><span>− Discounts given</span><span class="num">{{ $money($summary['discount']) }}</span></div>
    <div class="row" style="font-weight:600"><span>= Total sales</span><span class="num">{{ $money($summary['sales']) }}</span></div>
    <div class="row"><span>− Product purchase cost</span><span class="num">{{ $money($summary['product_cost']) }}</span></div>
    <div class="row"><span>= Gross profit</span><span class="num">{{ $money($summary['gross_profit']) }}</span></div>
    <div class="row"><span>− Expenses</span><span class="num">{{ $money($summary['expenses']) }}</span></div>
    <div class="row total"><span>= Net profit</span><span class="num {{ $summary['net_profit'] >= 0 ? 'pos' : 'neg' }}">{{ $money($summary['net_profit']) }}</span></div>
</div>

{{-- ── Monthly investment list ── --}}
<h2 class="acc-section-h">Investment — {{ $month->format('F Y') }}</h2>

<div class="grid grid-cols-12 gap-5">
    <div class="col-span-12 lg:col-span-4">
        <div class="wp-panel">
            <div class="wp-panel-h">By category <span class="float-right">{{ $money($investments->sum('amount')) }}</span></div>
            <div class="wp-panel-body">
                @forelse($investmentByCat as $name => $amt)
                    <div class="flex justify-between text-[13px] py-1 border-b border-[#f0f0f1]"><span>{{ $name }}</span><span class="num">{{ $money($amt) }}</span></div>
                @empty
                    <p class="text-[13px] text-[#787c82]">No investment this month.</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-span-12 lg:col-span-8 table-scroll">
        <table class="wp-list-table">
            <thead><tr><th style="width:110px">Date</th><th>Title</th><th>Category</th><th>Paid via</th><th class="num">Amount</th></tr></thead>
            <tbody>
            @forelse($investments as $i)
                <tr>
                    <td class="text-[#50575e]">{{ $i->investment_date->format('d M Y') }}</td>
                    <td>{{ $i->title }} @if($i->note)<div class="text-[11px] text-[#787c82]">{{ $i->note }}</div>@endif</td>
                    <td class="text-[#50575e]">{{ $i->category?->name ?? '—' }}</td>
                    <td class="text-[#50575e]">{{ ucfirst($i->payment_method) }}</td>
                    <td class="num">{{ $money($i->amount) }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-[#787c82] py-6">No investment recorded for this month.</td></tr>
            @endforelse
            </tbody>
            @if($investments->isNotEmpty())
            <tfoot><tr><td colspan="4">Total</td><td class="num">{{ $money($investments->sum('amount')) }}</td></tr></tfoot>
            @endif
        </table>
    </div>
</div>

@if($purchases->isNotEmpty())
<h2 class="acc-section-h">Stock purchases this month <span class="text-[12px] font-normal text-[#787c82]">(reference — product cost is counted in profit when the item is sold)</span></h2>
<table class="wp-list-table">
    <thead><tr><th>Date</th><th>Invoice</th><th>Supplier</th><th>Status</th><th class="num">Amount</th></tr></thead>
    <tbody>
    @foreach($purchases as $p)
        <tr>
            <td class="text-[#50575e]">{{ $p->purchase_date?->format('d M Y') }}</td>
            <td>{{ $p->invoice_no }}</td>
            <td>{{ $p->supplier?->name ?? '—' }}</td>
            <td class="text-[#50575e]">{{ ucfirst($p->status) }}</td>
            <td class="num">{{ $money($p->total_amount) }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot><tr><td colspan="4">Total</td><td class="num">{{ $money($purchases->sum('total_amount')) }}</td></tr></tfoot>
</table>
@endif

{{-- ── Expense list for the month ── --}}
<h2 class="acc-section-h">Expenses — {{ $month->format('F Y') }}</h2>

<div class="grid grid-cols-12 gap-5">
    <div class="col-span-12 lg:col-span-4">
        <div class="wp-panel">
            <div class="wp-panel-h">By category <span class="float-right">{{ $money($expenses->sum('amount')) }}</span></div>
            <div class="wp-panel-body">
                @forelse($expenseByCat as $name => $amt)
                    <div class="flex justify-between text-[13px] py-1 border-b border-[#f0f0f1]"><span>{{ $name }}</span><span class="num">{{ $money($amt) }}</span></div>
                @empty
                    <p class="text-[13px] text-[#787c82]">No expense this month.</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-span-12 lg:col-span-8 table-scroll">
        <table class="wp-list-table">
            <thead><tr><th style="width:110px">Date</th><th>Title</th><th>Category</th><th>Paid via</th><th class="num">Amount</th></tr></thead>
            <tbody>
            @forelse($expenses as $e)
                <tr>
                    <td class="text-[#50575e]">{{ $e->expense_date->format('d M Y') }}</td>
                    <td>{{ $e->title }} @if($e->note)<div class="text-[11px] text-[#787c82]">{{ $e->note }}</div>@endif</td>
                    <td class="text-[#50575e]">{{ $e->category?->name ?? '—' }}</td>
                    <td class="text-[#50575e]">{{ ucfirst($e->payment_method) }}</td>
                    <td class="num">{{ $money($e->amount) }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-[#787c82] py-6">No expense recorded for this month.</td></tr>
            @endforelse
            </tbody>
            @if($expenses->isNotEmpty())
            <tfoot><tr><td colspan="4">Total</td><td class="num">{{ $money($expenses->sum('amount')) }}</td></tr></tfoot>
            @endif
        </table>
    </div>
</div>

{{-- ── Year at a glance ── --}}
<h2 class="acc-section-h">{{ $month->year }} — month by month</h2>
<div class="table-scroll">
<table class="wp-list-table">
    <thead><tr><th>Month</th><th class="num">Orders</th><th class="num">Sales</th><th class="num">Product Cost</th><th class="num">Expenses</th><th class="num">Net Profit</th><th class="num">Investment</th></tr></thead>
    <tbody>
    @foreach($year as $r)
        <tr @if($r['month']->isSameMonth($month)) style="background:#f0f6fc" @endif>
            <td><a class="text-[#2271b1] hover:underline" href="{{ route('admin.accounts.monthly', ['month' => $r['month']->format('Y-m')]) }}">{{ $r['month']->format('F') }}</a></td>
            <td class="num">{{ $r['orders'] }}</td>
            <td class="num">{{ $money($r['sales']) }}</td>
            <td class="num">{{ $money($r['product_cost']) }}</td>
            <td class="num">{{ $money($r['expenses']) }}</td>
            <td class="num {{ $r['net_profit'] >= 0 ? 'pos' : 'neg' }}">{{ $money($r['net_profit']) }}</td>
            <td class="num">{{ $money($r['investments']) }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td>Year total</td>
            <td class="num">{{ $year->sum('orders') }}</td>
            <td class="num">{{ $money($year->sum('sales')) }}</td>
            <td class="num">{{ $money($year->sum('product_cost')) }}</td>
            <td class="num">{{ $money($year->sum('expenses')) }}</td>
            <td class="num {{ $year->sum('net_profit') >= 0 ? 'pos' : 'neg' }}">{{ $money($year->sum('net_profit')) }}</td>
            <td class="num">{{ $money($year->sum('investments')) }}</td>
        </tr>
    </tfoot>
</table>
</div>

@endsection
