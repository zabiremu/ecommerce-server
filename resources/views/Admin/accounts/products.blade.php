@extends('Admin.Layout.app')

@section('title', 'Product-wise Profit')
@section('page_title', 'Accounts & Reports')

@push('styles')
@include('Admin.accounts._styles')
@endpush

@section('content')
@php
    $money = fn ($v) => \App\Support\Money::format($v);
    $todayC = \Illuminate\Support\Carbon::parse($today);
    $presets = [
        'Today'      => [$today, $today],
        'Last 7 days' => [$todayC->copy()->subDays(6)->toDateString(), $today],
        'This month' => [$todayC->copy()->startOfMonth()->toDateString(), $today],
        'Last month' => [$todayC->copy()->subMonthNoOverflow()->startOfMonth()->toDateString(), $todayC->copy()->subMonthNoOverflow()->endOfMonth()->toDateString()],
        'This year'  => [$todayC->copy()->startOfYear()->toDateString(), $today],
    ];
@endphp

<div class="flex flex-wrap items-center gap-3 mb-4">
    <h1 class="wp-h1">Product-wise Profit</h1>
    <span class="text-[13px] text-[#50575e]">How much each product earned — {{ \Illuminate\Support\Carbon::parse($from)->format('d M Y') }} to {{ \Illuminate\Support\Carbon::parse($to)->format('d M Y') }}</span>
</div>

<div class="flex flex-wrap items-end justify-between gap-3 mb-4">
    <form method="GET" action="{{ route('admin.accounts.products') }}" class="flex flex-wrap items-end gap-2">
        <div>
            <label class="block text-[12px] font-semibold text-[#50575e] mb-1">From</label>
            <input type="date" name="from" value="{{ $from }}" max="{{ $today }}" class="wp-input" style="width:160px">
        </div>
        <div>
            <label class="block text-[12px] font-semibold text-[#50575e] mb-1">To</label>
            <input type="date" name="to" value="{{ $to }}" max="{{ $today }}" class="wp-input" style="width:160px">
        </div>
        <button type="submit" class="wp-btn wp-btn-primary">Show</button>
    </form>
    <div class="flex flex-wrap gap-1.5">
        @foreach ($presets as $label => [$pf, $pt])
            <a href="{{ route('admin.accounts.products', ['from' => $pf, 'to' => $pt]) }}" class="wp-btn {{ $pf === $from && $pt === $to ? 'wp-btn-primary' : '' }}">{{ $label }}</a>
        @endforeach
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
    <div class="summary-card"><div class="lbl">Products Sold</div><div class="val">{{ $products->count() }}</div><div class="sub">{{ rtrim(rtrim(number_format($totals['qty'], 2), '0'), '.') }} units</div></div>
    <div class="summary-card"><div class="lbl">Product Sales</div><div class="val">{{ $money($totals['revenue']) }}</div><div class="sub">After discount, without delivery</div></div>
    <div class="summary-card"><div class="lbl">Product Cost</div><div class="val">{{ $money($totals['cost']) }}</div></div>
    <div class="summary-card {{ $totals['profit'] < 0 ? 'net-neg' : 'net-pos' }}"><div class="lbl">Product Profit</div><div class="val {{ $totals['profit'] < 0 ? 'amt-neg' : 'amt-pos' }}">{{ $money($totals['profit']) }}</div><div class="sub">Before expenses</div></div>
</div>

@if ($missingCost > 0)
    <div class="acc-warn mb-4">
        <i class="fas fa-triangle-exclamation mr-1"></i>
        {{ $missingCost }} {{ \Illuminate\Support\Str::plural('product', $missingCost) }} sold without a purchase price — their cost counts as ৳0. Edit the product and set its purchase price.
    </div>
@endif

<div class="wp-panel">
    <div class="wp-panel-body" style="padding:0">
        @include('Admin.accounts._product_table', ['products' => $products])
    </div>
</div>

<p class="acc-note mt-3">An order's discount is shared across its products by value. Delivery charges are not part of product profit. Pending, cancelled and returned orders are not counted.</p>

@endsection
