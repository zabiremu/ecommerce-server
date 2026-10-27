@extends('Admin.Layout.app')

@section('title', 'Returns & Discounts')
@section('page_title', 'Accounts & Reports')

@push('styles')
@include('Admin.accounts._styles')
@endpush

@section('content')
@php
    $money = fn ($v) => \App\Support\Money::format($v);
    $tz = \App\Models\DealsBanner::LOCAL_TZ;
    $r = $report;
    $lostTotal = $r['cancelled']['amount'] + $r['returned']['amount'] + $r['discount'];
    $qty = fn ($v) => rtrim(rtrim(number_format((float) $v, 2), '0'), '.');
@endphp

<div class="flex flex-wrap items-center gap-3 mb-4">
    <h1 class="wp-h1">Returns &amp; Discounts</h1>
    <span class="text-[13px] text-[#50575e]">How much income was lost to returns, cancelled orders and discounts — {{ \Illuminate\Support\Carbon::parse($from)->format('d M Y') }} to {{ \Illuminate\Support\Carbon::parse($to)->format('d M Y') }}</span>
</div>

@include('Admin.accounts._range_form', ['route' => 'admin.accounts.returns'])

<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
    <div class="summary-card">
        <div class="lbl">Returned Orders</div>
        <div class="val amt-neg">{{ $money($r['returned']['amount']) }}</div>
        <div class="sub">{{ $r['returned']['orders'] }} {{ \Illuminate\Support\Str::plural('order', $r['returned']['orders']) }}@if ($r['refunded'] > 0) · {{ $money($r['refunded']) }} refunded @endif</div>
    </div>
    <div class="summary-card">
        <div class="lbl">Cancelled Orders</div>
        <div class="val amt-neg">{{ $money($r['cancelled']['amount']) }}</div>
        <div class="sub">{{ $r['cancelled']['orders'] }} {{ \Illuminate\Support\Str::plural('order', $r['cancelled']['orders']) }}</div>
    </div>
    <div class="summary-card">
        <div class="lbl">Discounts Given</div>
        <div class="val amt-neg">{{ $money($r['discount']) }}</div>
        <div class="sub">On {{ $r['discount_orders'] }} {{ \Illuminate\Support\Str::plural('sale', $r['discount_orders']) }}</div>
    </div>
    <div class="summary-card net-neg">
        <div class="lbl">Total Reduced</div>
        <div class="val amt-neg">{{ $money($lostTotal) }}</div>
        <div class="sub">Returns + cancels + discounts</div>
    </div>
</div>

<div class="grid grid-cols-12 gap-5">
    <div class="col-span-12 lg:col-span-8 space-y-5">
        <div class="wp-panel">
            <div class="wp-panel-h">Returned &amp; Cancelled Orders</div>
            <div class="wp-panel-body" style="padding:0">
                <div style="overflow-x:auto">
                <table class="wp-list-table" style="border:0">
                    <thead><tr><th>Date</th><th>Order</th><th>Customer</th><th>Status</th><th>Payment</th><th class="text-right">Amount</th></tr></thead>
                    <tbody>
                        @forelse ($r['lost_orders'] as $o)
                            <tr>
                                <td class="text-[12px] text-[#50575e]">{{ $o->placed_at?->copy()->setTimezone($tz)->format('d M, Y') }}</td>
                                <td><a href="{{ route('admin.orders.show', $o->id) }}" class="text-[#2271b1]">#{{ $o->order_no }}</a> <span class="text-[11px] uppercase text-[#646970]">{{ $o->source === 'pos' ? 'POS' : 'Online' }}</span></td>
                                <td>{{ $o->shipping_name }}</td>
                                <td><span class="inline-block px-2 py-0.5 rounded text-[11px] font-semibold {{ \App\Models\Order::statusBadgeClass($o->status) }}">{{ ucfirst($o->status) }}</span></td>
                                <td class="text-[12px]">{{ ucfirst($o->payment_status) }}</td>
                                <td class="text-right">{{ $money($o->total) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-[#646970] py-8"><i class="fas fa-circle-check text-emerald-500"></i> No returned or cancelled orders in this period.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>

        <div class="wp-panel">
            <div class="wp-panel-h">Sales with a Discount</div>
            <div class="wp-panel-body" style="padding:0">
                <div style="overflow-x:auto">
                <table class="wp-list-table" style="border:0">
                    <thead><tr><th>Date</th><th>Order</th><th>Customer</th><th class="text-right">Before Discount</th><th class="text-right">Discount</th><th class="text-right">Paid</th></tr></thead>
                    <tbody>
                        @forelse ($r['discounted'] as $o)
                            <tr>
                                <td class="text-[12px] text-[#50575e]">{{ $o->placed_at?->copy()->setTimezone($tz)->format('d M, Y') }}</td>
                                <td><a href="{{ route('admin.orders.show', $o->id) }}" class="text-[#2271b1]">#{{ $o->order_no }}</a></td>
                                <td>{{ $o->shipping_name }}</td>
                                <td class="text-right text-[#50575e]">{{ $money($o->subtotal) }}</td>
                                <td class="text-right amt-neg">−{{ $money($o->discount) }}</td>
                                <td class="text-right">{{ $money($o->total) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-[#646970] py-8">No discounts given in this period.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-4 space-y-5">
        <div class="wp-panel">
            <div class="wp-panel-h">Sales After Reductions</div>
            <div class="wp-panel-body" style="padding:0">
                <table class="wp-list-table" style="border:0">
                    <tbody>
                        <tr><td>Sales before discount</td><td class="text-right">{{ $money($r['gross']) }}</td></tr>
                        <tr><td>− Discounts</td><td class="text-right amt-neg">{{ $money($r['discount']) }}</td></tr>
                    </tbody>
                    <tfoot><tr><td>Net sales</td><td class="text-right">{{ $money($r['net']) }}</td></tr></tfoot>
                </table>
                <p class="acc-note px-3 py-2">Returned and cancelled orders are already left out of sales — the cards above show what they would have brought in.</p>
            </div>
        </div>

        <div class="wp-panel">
            <div class="wp-panel-h">Most Returned / Cancelled Products</div>
            <div class="wp-panel-body" style="padding:0">
                <table class="wp-list-table" style="border:0">
                    <thead><tr><th>Product</th><th class="text-right">Ret.</th><th class="text-right">Canc.</th><th class="text-right">Value</th></tr></thead>
                    <tbody>
                        @forelse ($r['products'] as $p)
                            <tr>
                                <td class="text-[12.5px]">{{ $p->name }}</td>
                                <td class="text-right">{{ $qty($p->returned_qty) }}</td>
                                <td class="text-right">{{ $qty($p->cancelled_qty) }}</td>
                                <td class="text-right text-[12px]">{{ $money($p->amount) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-[#646970] py-6">None.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="wp-panel">
            <div class="wp-panel-h">Returned to Suppliers</div>
            <div class="wp-panel-body">
                <div class="text-[20px] font-bold">{{ $money($r['supplier_returns']) }}</div>
                <p class="wp-help mt-1">Stock sent back to suppliers (GRN returns) in this period. This lowers what you owe them — see Supplier Dues.</p>
            </div>
        </div>

        <p class="acc-note">Returned and cancelled orders are dated by the day they were placed.</p>
    </div>
</div>

@endsection
