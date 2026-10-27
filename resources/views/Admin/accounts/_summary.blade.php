{{-- Profit summary cards. Expects $summary from ProfitReportService::summary(). --}}
@php $money = fn ($v) => \App\Support\Money::format($v); @endphp
<div class="grid grid-cols-2 lg:grid-cols-5 gap-3 mb-4">
    <div class="summary-card">
        <div class="lbl">Total Sales</div>
        <div class="val">{{ $money($summary['sales']) }}</div>
        <div class="sub">{{ number_format($summary['orders']) }} {{ \Illuminate\Support\Str::plural('order', $summary['orders']) }}</div>
    </div>
    <div class="summary-card">
        <div class="lbl">Product Cost</div>
        <div class="val">{{ $money($summary['cost']) }}</div>
        <div class="sub">Purchase price of goods sold</div>
    </div>
    <div class="summary-card">
        <div class="lbl">Gross Profit</div>
        <div class="val {{ $summary['gross'] < 0 ? 'amt-neg' : '' }}">{{ $money($summary['gross']) }}</div>
        <div class="sub">Sales − product cost</div>
    </div>
    <div class="summary-card">
        <div class="lbl">Expenses</div>
        <div class="val">{{ $money($summary['expenses']) }}</div>
        <div class="sub">Rent, salary, delivery…</div>
    </div>
    <div class="summary-card {{ $summary['net'] < 0 ? 'net-neg' : 'net-pos' }} col-span-2 lg:col-span-1">
        <div class="lbl">{{ $summary['net'] < 0 ? 'Net Loss' : 'Net Profit' }}</div>
        <div class="val {{ $summary['net'] < 0 ? 'amt-neg' : 'amt-pos' }}">{{ $money($summary['net']) }}</div>
        <div class="sub">Gross profit − expenses</div>
    </div>
</div>

@if ($summary['missing_cost'] > 0)
    <div class="acc-warn mb-4">
        <i class="fas fa-triangle-exclamation mr-1"></i>
        {{ $summary['missing_cost'] }} sold {{ \Illuminate\Support\Str::plural('line', $summary['missing_cost']) }} had no purchase price, so their cost counts as ৳0 and profit looks higher than it is.
        Set the purchase price on those products.
    </div>
@endif
