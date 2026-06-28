@extends('Admin.Layout.app')

@section('title', 'Sales Report')
@section('page_title', 'Sales Report')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@include('Admin._partials.wp-styles')
<style>
    .report-filters { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; flex-wrap: wrap; }
    .report-filters label { font-size: 13px; color: #1d2327; display: flex; align-items: center; gap: 6px; }
    .report-filters input[type="date"], .report-filters select {
        border: 1px solid #8c8f94; border-radius: 4px; padding: 5px 10px;
        font-size: 13px; background: #fff; outline: none; min-width: 140px;
    }
    .report-filters input[type="date"]:focus, .report-filters select:focus { border-color: #2271b1; box-shadow: 0 0 0 1px #2271b1; }
    .stat-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; margin-bottom: 18px; }
    .stat-card { background: #fff; border: 1px solid #c3c4c7; border-radius: 4px; padding: 14px 16px; box-shadow: 0 1px 1px rgba(0,0,0,.04); }
    .stat-card .label { font-size: 12px; color: #50575e; text-transform: uppercase; letter-spacing: .04em; }
    .stat-card .value { font-size: 22px; font-weight: 700; color: #1d2327; margin-top: 4px; }
    .stat-card .sub { font-size: 11px; color: #787c82; margin-top: 2px; }
    .status-badge { display: inline-block; padding: 2px 8px; font-size: 11px; font-weight: 600; border-radius: 3px; }
</style>
@endpush

@section('content')

<h1 class="wp-h1">Sales Report</h1>
<p class="text-[13px] text-[#50575e] mt-1 mb-4">Revenue and order summary for the selected period.</p>

{{-- Filters --}}
<form method="GET" action="{{ route('admin.sales-report.index') }}" class="report-filters">
    <label><i class="fas fa-calendar text-[#787c82]"></i> From:
        <input type="date" name="from" value="{{ $from->toDateString() }}">
    </label>
    <label>To:
        <input type="date" name="to" value="{{ $to->toDateString() }}">
    </label>
    <label><i class="fas fa-filter text-[#787c82]"></i> Status:
        <select name="status">
            <option value="">All Statuses</option>
            @foreach (\App\Models\Order::STATUSES as $s)
                <option value="{{ $s }}" {{ $status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </label>
    <button type="submit" class="wp-btn wp-btn-primary"><i class="fas fa-search mr-1"></i> Apply</button>
    <a href="{{ route('admin.sales-report.index') }}" class="wp-btn">Reset</a>
</form>

{{-- Stat Cards --}}
<div class="stat-cards">
    <div class="stat-card">
        <div class="label">Total Orders</div>
        <div class="value">{{ number_format($totalOrders) }}</div>
        <div class="sub">{{ $from->format('d M') }} – {{ $to->format('d M Y') }}</div>
    </div>
    <div class="stat-card">
        <div class="label">Total Revenue</div>
        <div class="value">TK {{ number_format($totalRevenue) }}</div>
        <div class="sub">Excl. cancelled &amp; returned</div>
    </div>
    <div class="stat-card">
        <div class="label">Avg Order Value</div>
        <div class="value">TK {{ number_format($avgOrder) }}</div>
        <div class="sub">Per completed order</div>
    </div>
    <div class="stat-card">
        <div class="label">Delivered Revenue</div>
        <div class="value">TK {{ number_format($deliveredRev) }}</div>
        <div class="sub">Delivered orders only</div>
    </div>
</div>

{{-- Status breakdown --}}
@if ($statusCounts->isNotEmpty())
<div class="mb-4 flex flex-wrap gap-2">
    @foreach (\App\Models\Order::STATUSES as $s)
        @if ($statusCounts->has($s))
        <span class="status-badge {{ \App\Models\Order::statusBadgeClass($s) }}">
            {{ ucfirst($s) }}: {{ $statusCounts->get($s, 0) }}
        </span>
        @endif
    @endforeach
</div>
@endif

{{-- Orders table --}}
<table id="salesTable" class="wp-list-table">
    <thead>
        <tr>
            <th>Order #</th>
            <th>Date</th>
            <th>Customer</th>
            <th>City</th>
            <th>Payment</th>
            <th>Status</th>
            <th class="text-right" style="width:110px">Subtotal</th>
            <th class="text-right" style="width:100px">Shipping</th>
            <th class="text-right" style="width:90px">Discount</th>
            <th class="text-right" style="width:110px">Total</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($orders as $order)
        <tr>
            <td>
                <a href="{{ route('admin.orders.show', $order) }}" class="text-[#2271b1] font-semibold hover:underline">
                    #{{ $order->order_no }}
                </a>
            </td>
            <td class="text-[#50575e]">{{ $order->placed_at?->format('d M Y') }}</td>
            <td>
                <div class="font-medium">{{ $order->shipping_name }}</div>
                <div class="text-[11px] text-[#787c82]">{{ $order->shipping_phone }}</div>
            </td>
            <td class="text-[#50575e]">{{ $order->shipping_city }}</td>
            <td>
                <span class="status-badge {{ \App\Models\Order::paymentBadgeClass($order->payment_status) }}">
                    {{ ucfirst($order->payment_status) }}
                </span>
                <div class="text-[11px] text-[#787c82] mt-0.5">{{ strtoupper($order->payment_method) }}</div>
            </td>
            <td>
                <span class="status-badge {{ \App\Models\Order::statusBadgeClass($order->status) }}">
                    {{ ucfirst($order->status) }}
                </span>
            </td>
            <td class="text-right">TK {{ number_format($order->subtotal) }}</td>
            <td class="text-right text-[#50575e]">TK {{ number_format($order->shipping_charge) }}</td>
            <td class="text-right text-[#50575e]">
                @if ($order->discount > 0)
                    <span class="text-emerald-600">-TK {{ number_format($order->discount) }}</span>
                @else
                    —
                @endif
            </td>
            <td class="text-right font-semibold">TK {{ number_format($order->total) }}</td>
        </tr>
        @empty
        <tr><td colspan="10" class="wc-empty">No orders found for the selected period.</td></tr>
        @endforelse
    </tbody>
    @if ($orders->isNotEmpty())
    <tfoot>
        <tr style="background:#f6f7f7; font-weight:600; font-size:13px;">
            <td colspan="6" class="text-right pr-2" style="padding:10px 8px; border-top:2px solid #c3c4c7;">Totals ({{ $totalOrders }} orders)</td>
            <td class="text-right" style="padding:10px 8px; border-top:2px solid #c3c4c7;">TK {{ number_format($orders->sum('subtotal')) }}</td>
            <td class="text-right" style="padding:10px 8px; border-top:2px solid #c3c4c7;">TK {{ number_format($orders->sum('shipping_charge')) }}</td>
            <td class="text-right text-emerald-700" style="padding:10px 8px; border-top:2px solid #c3c4c7;">-TK {{ number_format($orders->sum('discount')) }}</td>
            <td class="text-right" style="padding:10px 8px; border-top:2px solid #c3c4c7;">TK {{ number_format($orders->sum('total')) }}</td>
        </tr>
    </tfoot>
    @endif
</table>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(function () {
        $('#salesTable').DataTable({
            pageLength: 25,
            order: [[1, 'desc']],
            language: { search: "_INPUT_", searchPlaceholder: "Search orders..." }
        });
    });
</script>
@endpush
