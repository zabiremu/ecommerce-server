@extends('Admin.Layout.app')

@section('title', 'Product Performance')
@section('page_title', 'Accounts & Reports')

@push('styles')
@include('Admin.accounts._styles')
@endpush

@section('content')
@php
    $money = fn ($v) => \App\Support\Money::format($v);
    $qty = fn ($v) => rtrim(rtrim(number_format((float) $v, 2), '0'), '.');
    $maxCatProfit = max(1, $byCategory->max(fn ($c) => abs($c->profit)) ?? 1);
    $keep = ['category' => $categoryId, 'days' => $slowDays];
@endphp

<div class="flex flex-wrap items-center gap-3 mb-4">
    <h1 class="wp-h1">Best &amp; Low Performing Products</h1>
    <span class="text-[13px] text-[#50575e]">Which products earn the most, which earn little, and which have been sitting unsold</span>
</div>

@include('Admin.accounts._range_form', ['route' => 'admin.accounts.performance', 'keep' => $keep])

<div class="flex flex-wrap items-center gap-x-1 gap-y-1 mb-4 wp-subtab" style="font-size:13px;">
    <span class="text-[#50575e] mr-1">Category:</span>
    <a href="{{ route('admin.accounts.performance', ['from' => $from, 'to' => $to, 'days' => $slowDays]) }}" style="color: {{ !$categoryId ? '#000' : '#2271b1' }}; font-weight: {{ !$categoryId ? 600 : 'normal' }};">All</a>
    @foreach ($topCategories as $c)
        <span class="text-[#c3c4c7] mx-1">|</span>
        <a href="{{ route('admin.accounts.performance', ['from' => $from, 'to' => $to, 'days' => $slowDays, 'category' => $c->id]) }}" style="color: {{ $categoryId === $c->id ? '#000' : '#2271b1' }}; font-weight: {{ $categoryId === $c->id ? 600 : 'normal' }};">{{ $c->name }}</a>
    @endforeach
</div>

<div class="wp-panel mb-5">
    <div class="wp-panel-h">Profit by Category</div>
    <div class="wp-panel-body" style="padding:0">
        <div style="overflow-x:auto">
        <table class="wp-list-table" style="border:0">
            <thead><tr><th>Category</th><th class="text-right">Qty Sold</th><th class="text-right">Sales</th><th class="text-right">Profit</th><th class="text-right">Margin</th><th style="width:160px"></th></tr></thead>
            <tbody>
                @forelse ($byCategory as $c)
                    <tr class="{{ $categoryId && $categoryId === $c->id ? 'bg-[#f0f6fc]' : '' }}">
                        <td><strong>{{ $c->name }}</strong></td>
                        <td class="text-right">{{ $qty($c->qty) }}</td>
                        <td class="text-right">{{ $money($c->revenue) }}</td>
                        <td class="text-right"><strong class="{{ $c->profit < 0 ? 'amt-neg' : 'amt-pos' }}">{{ $money($c->profit) }}</strong></td>
                        <td class="text-right text-[12px]">{{ $c->margin }}%</td>
                        <td><div class="bar-track"><div class="bar-fill" style="width:{{ (int) round(abs($c->profit) / $maxCatProfit * 100) }}%;{{ $c->profit < 0 ? 'background:#d63638' : '' }}"></div></div></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-[#646970] py-6">No sales in this period.</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>

<div class="grid grid-cols-12 gap-5 mb-5">
    @foreach ([['Best Performing — most profit', $best, 'fa-arrow-trend-up text-emerald-600'], ['Low Performing — least profit', $low, 'fa-arrow-trend-down text-rose-600']] as [$title, $list, $icon])
    <div class="col-span-12 lg:col-span-6">
        <div class="wp-panel">
            <div class="wp-panel-h"><span><i class="fas {{ $icon }} mr-1"></i> {{ $title }}</span></div>
            <div class="wp-panel-body" style="padding:0">
                <div style="overflow-x:auto">
                <table class="wp-list-table" style="border:0">
                    <thead><tr><th>Product</th><th class="text-right">Sold</th><th class="text-right">Profit</th><th class="text-right">Margin</th></tr></thead>
                    <tbody>
                        @forelse ($list as $p)
                            <tr>
                                <td>
                                    @if ($p->product_id)<a href="{{ route('admin.products.edit', $p->product_id) }}" class="text-[#2271b1]">{{ $p->name }}</a>@else{{ $p->name }}@endif
                                    <div class="text-[11px] text-[#646970]">{{ $p->category }}@if ($p->missing_cost) · <span class="text-amber-700">no purchase price</span>@endif</div>
                                </td>
                                <td class="text-right">{{ $qty($p->qty) }}</td>
                                <td class="text-right"><strong class="{{ $p->profit < 0 ? 'amt-neg' : 'amt-pos' }}">{{ $money($p->profit) }}</strong></td>
                                <td class="text-right text-[12px]">{{ $p->margin }}%</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-[#646970] py-6">No sales in this period.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="wp-panel">
    <div class="wp-panel-h flex-wrap gap-2">
        <span><i class="fas fa-hourglass-half mr-1 text-amber-600"></i> Not Selling — in stock, no sale in the last {{ $slowDays }} days</span>
        <span class="flex items-center gap-1 text-[12px] font-normal">
            @foreach ([15, 30, 60, 90, 180] as $d)
                <a href="{{ route('admin.accounts.performance', ['from' => $from, 'to' => $to, 'category' => $categoryId, 'days' => $d]) }}" class="wp-btn {{ $slowDays === $d ? 'wp-btn-primary' : '' }}" style="padding:2px 8px">{{ $d }}d</a>
            @endforeach
        </span>
    </div>
    <div class="wp-panel-body" style="padding:0">
        <div class="px-3 py-2 text-[13px] bg-[#fffbeb] border-b border-[#f0f0f1]">
            <strong>{{ $slowSummary['count'] }}</strong> {{ \Illuminate\Support\Str::plural('product', $slowSummary['count']) }} ·
            <strong>{{ $money($slowSummary['value']) }}</strong> of money stuck in this stock (at purchase price)
        </div>
        <div style="overflow-x:auto">
        <table class="wp-list-table" style="border:0">
            <thead><tr><th>Product</th><th class="text-right">In Stock</th><th class="text-right">Stock Value</th><th>Last Sold</th><th class="text-right">Days Unsold</th><th class="text-right">Sold Ever</th></tr></thead>
            <tbody>
                @forelse ($slow as $p)
                    @php
                        $since = $p->last_sold ? \Illuminate\Support\Carbon::parse($p->last_sold) : $p->created_at;
                        $daysIdle = (int) $since->diffInDays(now());
                    @endphp
                    <tr>
                        <td><a href="{{ route('admin.products.edit', $p->id) }}" class="text-[#2271b1]">{{ $p->name }}</a>@if ($p->sku)<div class="text-[11px] text-[#646970]">{{ $p->sku }}</div>@endif</td>
                        <td class="text-right">{{ $qty($p->stock) }}</td>
                        <td class="text-right">{{ $money($p->stock_value) }}</td>
                        <td class="text-[12px]">{{ $p->last_sold ? $since->copy()->setTimezone(\App\Models\DealsBanner::LOCAL_TZ)->format('d M, Y') : 'Never sold' }}</td>
                        <td class="text-right"><strong class="{{ $daysIdle >= 90 ? 'amt-neg' : '' }}">{{ $daysIdle }}</strong></td>
                        <td class="text-right">{{ $qty($p->total_sold) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-[#646970] py-8"><i class="fas fa-circle-check text-emerald-500"></i> Every in-stock product sold in the last {{ $slowDays }} days.</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>
        @if ($slowSummary['count'] > $slow->count())
            <p class="acc-note px-3 py-2">Showing the {{ $slow->count() }} slowest of {{ $slowSummary['count'] }}.</p>
        @endif
    </div>
</div>

<p class="acc-note mt-3">Profit = product sales (after discount) − purchase price. "Days unsold" counts from the last sale, or from when the product was added if it never sold. Products added in the last {{ $slowDays }} days are not listed as not selling.</p>

@endsection
