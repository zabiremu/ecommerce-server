@extends('Admin.Layout.app')

@section('title', 'Daily Profit Report')
@section('page_title', 'Daily Profit Report')

@push('styles')
@include('Admin.accounts._styles')
@endpush

@php($money = fn ($v) => \App\Support\Money::format($v))

@section('content')

<h1 class="wp-h1">Accounts &amp; Reports</h1>
@include('Admin.accounts._tabs')

<form method="GET" action="{{ route('admin.accounts.daily') }}" class="report-filters">
    <label><i class="fas fa-calendar text-[#787c82]"></i> Date:
        <input type="date" name="date" value="{{ $date->toDateString() }}" max="{{ now()->toDateString() }}">
    </label>
    <button type="submit" class="wp-btn wp-btn-primary"><i class="fas fa-search mr-1"></i> Show</button>
    <a href="{{ route('admin.accounts.daily', ['date' => $date->copy()->subDay()->toDateString()]) }}" class="wp-btn"><i class="fas fa-chevron-left"></i> Prev day</a>
    @if($date->lt(today()))
        <a href="{{ route('admin.accounts.daily', ['date' => $date->copy()->addDay()->toDateString()]) }}" class="wp-btn">Next day <i class="fas fa-chevron-right"></i></a>
    @endif
    <a href="{{ route('admin.accounts.daily') }}" class="wp-btn">Today</a>
</form>

<p class="text-[13px] text-[#50575e] mb-3"><strong>{{ $date->format('l, d F Y') }}</strong> — {{ $day['orders'] }} order(s)</p>

<div class="stat-cards">
    <div class="stat-card"><div class="label">Sales</div><div class="value">{{ $money($day['sales']) }}</div><div class="sub">Excl. cancelled &amp; returned</div></div>
    <div class="stat-card"><div class="label">Product Cost</div><div class="value">{{ $money($day['product_cost']) }}</div><div class="sub">Purchase price of items sold</div></div>
    <div class="stat-card"><div class="label">Expenses</div><div class="value">{{ $money($day['expenses']) }}</div><div class="sub">Added for this date</div></div>
    <div class="stat-card hl"><div class="label">Net Profit</div><div class="value {{ $day['net_profit'] >= 0 ? 'pos' : 'neg' }}">{{ $money($day['net_profit']) }}</div><div class="sub">Margin {{ $day['margin'] }}%</div></div>
</div>

<div class="calc-box mb-4">
    <div class="row"><span>Sales</span><span class="num">{{ $money($day['sales']) }}</span></div>
    <div class="row"><span>− Product purchase cost</span><span class="num">{{ $money($day['product_cost']) }}</span></div>
    <div class="row"><span>= Gross profit</span><span class="num">{{ $money($day['gross_profit']) }}</span></div>
    <div class="row"><span>− Expenses</span><span class="num">{{ $money($day['expenses']) }}</span></div>
    <div class="row total"><span>= Net profit</span><span class="num {{ $day['net_profit'] >= 0 ? 'pos' : 'neg' }}">{{ $money($day['net_profit']) }}</span></div>
</div>

@if($products->isNotEmpty())
<h2 class="acc-section-h">Products sold on this day</h2>
<div class="table-scroll">
<table class="wp-list-table">
    <thead><tr><th>Product</th><th class="num">Qty</th><th class="num">Sales</th><th class="num">Cost</th><th class="num">Profit</th></tr></thead>
    <tbody>
    @foreach($products as $p)
        <tr>
            <td>{{ $p['name'] }} @if($p['sku'])<span class="text-[11px] text-[#787c82]">({{ $p['sku'] }})</span>@endif</td>
            <td class="num">{{ rtrim(rtrim(number_format($p['qty'], 2), '0'), '.') }}</td>
            <td class="num">{{ $money($p['revenue']) }}</td>
            <td class="num">{{ $money($p['cost']) }}</td>
            <td class="num {{ $p['profit'] >= 0 ? 'pos' : 'neg' }}">{{ $money($p['profit']) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
@endif

@if($dayExpenses->isNotEmpty())
<h2 class="acc-section-h">Expenses on this day</h2>
<table class="wp-list-table">
    <thead><tr><th>Title</th><th>Category</th><th class="num">Amount</th></tr></thead>
    <tbody>
    @foreach($dayExpenses as $e)
        <tr><td>{{ $e->title }}</td><td class="text-[#50575e]">{{ $e->category?->name ?? '—' }}</td><td class="num">{{ $money($e->amount) }}</td></tr>
    @endforeach
    </tbody>
</table>
@endif

<h2 class="acc-section-h">Day-by-day — {{ $date->format('F Y') }}</h2>
<div class="table-scroll">
<table class="wp-list-table">
    <thead>
        <tr><th>Date</th><th class="num">Orders</th><th class="num">Sales</th><th class="num">Product Cost</th><th class="num">Gross Profit</th><th class="num">Expenses</th><th class="num">Net Profit</th></tr>
    </thead>
    <tbody>
    @foreach($rows as $r)
        <tr @if($r['date']->isSameDay($date)) style="background:#f0f6fc" @endif>
            <td><a href="{{ route('admin.accounts.daily', ['date' => $r['date']->toDateString()]) }}" class="text-[#2271b1] hover:underline">{{ $r['date']->format('d M, D') }}</a></td>
            <td class="num">{{ $r['orders'] }}</td>
            <td class="num">{{ $money($r['sales']) }}</td>
            <td class="num">{{ $money($r['product_cost']) }}</td>
            <td class="num">{{ $money($r['gross_profit']) }}</td>
            <td class="num">{{ $money($r['expenses']) }}</td>
            <td class="num {{ $r['net_profit'] >= 0 ? 'pos' : 'neg' }}">{{ $money($r['net_profit']) }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td>Month total</td>
            <td class="num">{{ $rows->sum('orders') }}</td>
            <td class="num">{{ $money($rows->sum('sales')) }}</td>
            <td class="num">{{ $money($rows->sum('product_cost')) }}</td>
            <td class="num">{{ $money($rows->sum('gross_profit')) }}</td>
            <td class="num">{{ $money($rows->sum('expenses')) }}</td>
            <td class="num {{ $rows->sum('net_profit') >= 0 ? 'pos' : 'neg' }}">{{ $money($rows->sum('net_profit')) }}</td>
        </tr>
    </tfoot>
</table>
</div>
<p class="text-[12px] text-[#787c82] mt-2"><a class="text-[#2271b1]" href="{{ route('admin.accounts.export', ['month' => $date->format('Y-m')]) }}"><i class="fas fa-file-csv"></i> Export this month as CSV</a></p>

@endsection
