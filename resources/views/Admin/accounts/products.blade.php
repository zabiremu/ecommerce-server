@extends('Admin.Layout.app')

@section('title', 'Product-wise Profit')
@section('page_title', 'Product-wise Profit')

@push('styles')
@include('Admin.accounts._styles')
@endpush

@php($money = fn ($v) => \App\Support\Money::format($v))

@section('content')

<h1 class="wp-h1">Accounts &amp; Reports</h1>
@include('Admin.accounts._tabs')

<form method="GET" action="{{ route('admin.accounts.products') }}" class="report-filters">
    <label><i class="fas fa-calendar text-[#787c82]"></i> From:
        <input type="date" name="from" value="{{ $from->toDateString() }}">
    </label>
    <label>To:
        <input type="date" name="to" value="{{ $to->toDateString() }}">
    </label>
    <button type="submit" class="wp-btn wp-btn-primary"><i class="fas fa-search mr-1"></i> Apply</button>
    <a href="{{ route('admin.accounts.products', ['from' => today()->toDateString(), 'to' => today()->toDateString()]) }}" class="wp-btn">Today</a>
    <a href="{{ route('admin.accounts.products') }}" class="wp-btn">This month</a>
    <input type="search" id="pSearch" class="wp-input" style="max-width:220px" placeholder="Search product">
</form>

<div class="stat-cards">
    <div class="stat-card"><div class="label">Products sold</div><div class="value">{{ $rows->count() }}</div><div class="sub">{{ rtrim(rtrim(number_format($totals['qty'], 2), '0'), '.') }} units</div></div>
    <div class="stat-card"><div class="label">Product sales</div><div class="value">{{ $money($totals['revenue']) }}</div><div class="sub">Line totals, before order discount</div></div>
    <div class="stat-card"><div class="label">Purchase cost</div><div class="value">{{ $money($totals['cost']) }}</div></div>
    <div class="stat-card hl"><div class="label">Product profit</div><div class="value {{ $totals['profit'] >= 0 ? 'pos' : 'neg' }}">{{ $money($totals['profit']) }}</div><div class="sub">Before expenses</div></div>
</div>

<div class="table-scroll">
<table class="wp-list-table" id="pTable">
    <thead>
        <tr><th>Product</th><th class="num">Qty sold</th><th class="num">Sales</th><th class="num">Cost</th><th class="num">Profit</th><th class="num">Profit / unit</th><th class="num">Margin</th></tr>
    </thead>
    <tbody>
    @forelse($rows as $p)
        <tr>
            <td>
                @if($p['product_id'])
                    <a href="{{ route('admin.products.edit', $p['product_id']) }}" class="text-[#2271b1] font-medium hover:underline">{{ $p['name'] }}</a>
                @else
                    <span class="font-medium">{{ $p['name'] }}</span> <span class="text-[11px] text-[#787c82]">(deleted)</span>
                @endif
                @if($p['sku'])<div class="text-[11px] text-[#787c82]">{{ $p['sku'] }}</div>@endif
            </td>
            <td class="num">{{ rtrim(rtrim(number_format($p['qty'], 2), '0'), '.') }}</td>
            <td class="num">{{ $money($p['revenue']) }}</td>
            <td class="num">{{ $money($p['cost']) }}</td>
            <td class="num {{ $p['profit'] >= 0 ? 'pos' : 'neg' }}"><strong>{{ $money($p['profit']) }}</strong></td>
            <td class="num">{{ $money($p['per_unit']) }}</td>
            <td class="num {{ $p['margin'] >= 0 ? '' : 'neg' }}">{{ $p['margin'] }}%</td>
        </tr>
    @empty
        <tr><td colspan="7" class="text-center text-[#787c82] py-6">No products sold in this period.</td></tr>
    @endforelse
    </tbody>
    @if($rows->isNotEmpty())
    <tfoot>
        <tr>
            <td>Total</td>
            <td class="num">{{ rtrim(rtrim(number_format($totals['qty'], 2), '0'), '.') }}</td>
            <td class="num">{{ $money($totals['revenue']) }}</td>
            <td class="num">{{ $money($totals['cost']) }}</td>
            <td class="num {{ $totals['profit'] >= 0 ? 'pos' : 'neg' }}">{{ $money($totals['profit']) }}</td>
            <td></td>
            <td class="num">{{ $totals['revenue'] > 0 ? round($totals['profit'] / $totals['revenue'] * 100, 1) : 0 }}%</td>
        </tr>
    </tfoot>
    @endif
</table>
</div>
<p class="text-[12px] text-[#787c82] mt-2">Cost uses the purchase price saved at the time of each sale. Products with a 0 purchase price show full sales as profit — set the purchase price on the product to fix it.</p>

@endsection

@push('scripts')
<script>
document.getElementById('pSearch').addEventListener('input', function () {
    var q = this.value.toLowerCase();
    document.querySelectorAll('#pTable tbody tr').forEach(function (tr) {
        tr.style.display = tr.textContent.toLowerCase().indexOf(q) > -1 ? '' : 'none';
    });
});
</script>
@endpush
