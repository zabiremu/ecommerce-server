@extends('Admin.Layout.app')

@section('title', 'Purchase Report')
@section('page_title', 'Purchase Report')

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
    .badge-pending  { background: #fef3c7; color: #92400e; }
    .badge-ordered  { background: #dbeafe; color: #1e40af; }
    .badge-received { background: #d1fae5; color: #065f46; }
    .badge-cancelled{ background: #fee2e2; color: #991b1b; }
</style>
@endpush

@section('content')

<h1 class="wp-h1">Purchase Report</h1>
<p class="text-[13px] text-[#50575e] mt-1 mb-4">Purchase summary and breakdown for the selected period.</p>

{{-- Filters --}}
<form method="GET" action="{{ route('admin.purchase-report.index') }}" class="report-filters">
    <label><i class="fas fa-calendar text-[#787c82]"></i> From:
        <input type="date" name="from" value="{{ $from->toDateString() }}">
    </label>
    <label>To:
        <input type="date" name="to" value="{{ $to->toDateString() }}">
    </label>
    <label><i class="fas fa-truck text-[#787c82]"></i> Supplier:
        <select name="supplier_id">
            <option value="">All Suppliers</option>
            @foreach ($suppliers as $s)
                <option value="{{ $s->id }}" {{ $supplierId == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
            @endforeach
        </select>
    </label>
    <label><i class="fas fa-warehouse text-[#787c82]"></i> Warehouse:
        <select name="warehouse_id">
            <option value="">All Warehouses</option>
            @foreach ($warehouses as $w)
                <option value="{{ $w->id }}" {{ $warehouseId == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
            @endforeach
        </select>
    </label>
    <label><i class="fas fa-filter text-[#787c82]"></i> Status:
        <select name="status">
            <option value="">All Statuses</option>
            @foreach (['pending', 'ordered', 'received', 'cancelled'] as $s)
                <option value="{{ $s }}" {{ $status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </label>
    <button type="submit" class="wp-btn wp-btn-primary"><i class="fas fa-search mr-1"></i> Apply</button>
    <a href="{{ route('admin.purchase-report.index') }}" class="wp-btn">Reset</a>
</form>

{{-- Stat Cards --}}
<div class="stat-cards">
    <div class="stat-card">
        <div class="label">Total Purchases</div>
        <div class="value">{{ number_format($totalPurchases) }}</div>
        <div class="sub">{{ $from->format('d M') }} – {{ $to->format('d M Y') }}</div>
    </div>
    <div class="stat-card">
        <div class="label">Total Amount</div>
        <div class="value">TK {{ number_format($totalAmount) }}</div>
        <div class="sub">All statuses</div>
    </div>
    <div class="stat-card">
        <div class="label">Received Amount</div>
        <div class="value">TK {{ number_format($receivedAmount) }}</div>
        <div class="sub">Received purchases</div>
    </div>
    <div class="stat-card">
        <div class="label">Pending Amount</div>
        <div class="value">TK {{ number_format($pendingAmount) }}</div>
        <div class="sub">Pending purchases</div>
    </div>
</div>

{{-- Status breakdown --}}
@if ($statusCounts->isNotEmpty())
<div class="mb-4 flex flex-wrap gap-2">
    @foreach (['pending', 'ordered', 'received', 'cancelled'] as $s)
        @if ($statusCounts->has($s))
        @php
            $badgeMap = ['pending'=>'badge-pending','ordered'=>'badge-ordered','received'=>'badge-received','cancelled'=>'badge-cancelled'];
        @endphp
        <span class="status-badge {{ $badgeMap[$s] ?? '' }}">
            {{ ucfirst($s) }}: {{ $statusCounts->get($s, 0) }}
        </span>
        @endif
    @endforeach
</div>
@endif

{{-- Purchases table --}}
<table id="purchaseTable" class="wp-list-table">
    <thead>
        <tr>
            <th>Invoice #</th>
            <th>Date</th>
            <th>Supplier</th>
            <th>Warehouse</th>
            <th>Status</th>
            <th class="text-right" style="width:130px">Amount</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($purchases as $purchase)
        @php
            $badgeMap = ['pending'=>'badge-pending','ordered'=>'badge-ordered','received'=>'badge-received','cancelled'=>'badge-cancelled'];
        @endphp
        <tr>
            <td>
                <a href="{{ route('admin.purchases.show', $purchase) }}" class="text-[#2271b1] font-semibold hover:underline">
                    {{ $purchase->invoice_no }}
                </a>
            </td>
            <td class="text-[#50575e]">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}</td>
            <td>{{ $purchase->supplier->name ?? '—' }}</td>
            <td class="text-[#50575e]">{{ $purchase->warehouse->name ?? '—' }}</td>
            <td>
                <span class="status-badge {{ $badgeMap[$purchase->status] ?? '' }}">
                    {{ ucfirst($purchase->status) }}
                </span>
            </td>
            <td class="text-right font-semibold">TK {{ number_format($purchase->total_amount) }}</td>
        </tr>
        @empty
        <tr><td colspan="6" class="wc-empty">No purchases found for the selected period.</td></tr>
        @endforelse
    </tbody>
    @if ($purchases->isNotEmpty())
    <tfoot>
        <tr style="background:#f6f7f7; font-weight:600; font-size:13px;">
            <td colspan="5" class="text-right pr-2" style="padding:10px 8px; border-top:2px solid #c3c4c7;">
                Totals ({{ $totalPurchases }} purchases)
            </td>
            <td class="text-right" style="padding:10px 8px; border-top:2px solid #c3c4c7;">
                TK {{ number_format($totalAmount) }}
            </td>
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
        $('#purchaseTable').DataTable({
            pageLength: 25,
            order: [[1, 'desc']],
            language: { search: "_INPUT_", searchPlaceholder: "Search purchases..." }
        });
    });
</script>
@endpush
