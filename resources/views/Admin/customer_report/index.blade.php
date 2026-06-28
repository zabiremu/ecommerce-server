@extends('Admin.Layout.app')

@section('title', 'Customer Report')
@section('page_title', 'Customer Report')

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
    .rank-badge { display: inline-flex; align-items: center; justify-content: center; width: 22px; height: 22px; border-radius: 50%; font-size: 11px; font-weight: 700; }
    .rank-1 { background: #fef3c7; color: #92400e; }
    .rank-2 { background: #f1f5f9; color: #475569; }
    .rank-3 { background: #fde8d3; color: #9a3412; }
    .rank-n { background: #f0f0f1; color: #787c82; }
</style>
@endpush

@section('content')

<h1 class="wp-h1">Customer Report</h1>
<p class="text-[13px] text-[#50575e] mt-1 mb-4">Customer overview and spending summary for the selected period.</p>

{{-- Filters --}}
<form method="GET" action="{{ route('admin.customer-report.index') }}" class="report-filters">
    <label><i class="fas fa-calendar text-[#787c82]"></i> From:
        <input type="date" name="from" value="{{ $from->toDateString() }}">
    </label>
    <label>To:
        <input type="date" name="to" value="{{ $to->toDateString() }}">
    </label>
    <label><i class="fas fa-filter text-[#787c82]"></i> Status:
        <select name="status">
            <option value="">All Customers</option>
            <option value="active"   {{ $status === 'active'   ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </label>
    <label><i class="fas fa-sort text-[#787c82]"></i> Sort by:
        <select name="sort_by">
            <option value="total_spent"   {{ $sortBy === 'total_spent'   ? 'selected' : '' }}>Total Spent</option>
            <option value="total_orders"  {{ $sortBy === 'total_orders'  ? 'selected' : '' }}>Total Orders</option>
            <option value="last_order_at" {{ $sortBy === 'last_order_at' ? 'selected' : '' }}>Last Order</option>
            <option value="created_at"    {{ $sortBy === 'created_at'    ? 'selected' : '' }}>Joined Date</option>
        </select>
    </label>
    <button type="submit" class="wp-btn wp-btn-primary"><i class="fas fa-search mr-1"></i> Apply</button>
    <a href="{{ route('admin.customer-report.index') }}" class="wp-btn">Reset</a>
</form>

{{-- Stat Cards --}}
<div class="stat-cards">
    <div class="stat-card">
        <div class="label">Total Customers</div>
        <div class="value">{{ number_format($totalCustomers) }}</div>
        <div class="sub">Matching filters</div>
    </div>
    <div class="stat-card">
        <div class="label">Active Customers</div>
        <div class="value">{{ number_format($activeCustomers) }}</div>
        <div class="sub">Enabled accounts</div>
    </div>
    <div class="stat-card">
        <div class="label">Period Revenue</div>
        <div class="value">TK {{ number_format($totalRevenue) }}</div>
        <div class="sub">{{ $from->format('d M') }} – {{ $to->format('d M Y') }}</div>
    </div>
    <div class="stat-card">
        <div class="label">New Customers</div>
        <div class="value">{{ number_format($newCustomers) }}</div>
        <div class="sub">Joined this period</div>
    </div>
</div>

{{-- Customers table --}}
<table id="customerTable" class="wp-list-table">
    <thead>
        <tr>
            <th style="width:36px">#</th>
            <th>Customer</th>
            <th>Phone</th>
            <th>City</th>
            <th>Joined</th>
            <th class="text-center" style="width:100px">All Orders</th>
            <th class="text-right" style="width:120px">All-Time Spent</th>
            <th class="text-center" style="width:100px">Period Orders</th>
            <th class="text-right" style="width:120px">Period Spent</th>
            <th>Last Order</th>
            <th class="text-center" style="width:70px">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($customers as $i => $customer)
        <tr>
            <td>
                @if ($i < 3)
                    <span class="rank-badge rank-{{ $i + 1 }}">{{ $i + 1 }}</span>
                @else
                    <span class="rank-badge rank-n">{{ $i + 1 }}</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.customers.show', $customer) }}" class="text-[#2271b1] font-semibold hover:underline">
                    {{ $customer->name }}
                </a>
                @if ($customer->email)
                    <div class="text-[11px] text-[#787c82]">{{ $customer->email }}</div>
                @endif
            </td>
            <td class="text-[#50575e] font-mono text-[12px]">{{ $customer->phone }}</td>
            <td class="text-[#50575e]">{{ $customer->city ?: '—' }}</td>
            <td class="text-[#50575e]">{{ $customer->created_at->format('d M Y') }}</td>
            <td class="text-center font-semibold">{{ number_format($customer->total_orders) }}</td>
            <td class="text-right font-semibold">TK {{ number_format($customer->total_spent) }}</td>
            <td class="text-center {{ $customer->period_orders > 0 ? 'font-semibold text-blue-700' : 'text-[#c3c4c7]' }}">
                {{ $customer->period_orders > 0 ? number_format($customer->period_orders) : '—' }}
            </td>
            <td class="text-right {{ $customer->period_spent > 0 ? 'font-semibold text-emerald-700' : 'text-[#c3c4c7]' }}">
                {{ $customer->period_spent > 0 ? 'TK '.number_format($customer->period_spent) : '—' }}
            </td>
            <td class="text-[#50575e]">{{ $customer->last_order_at ? $customer->last_order_at->format('d M Y') : '—' }}</td>
            <td class="text-center">
                <span class="wp-status-pill {{ $customer->status ? 'wp-status-on' : 'wp-status-off' }}">
                    {{ $customer->status ? 'Active' : 'Off' }}
                </span>
            </td>
        </tr>
        @empty
        <tr><td colspan="11" class="wc-empty">No customers found.</td></tr>
        @endforelse
    </tbody>
    @if ($customers->isNotEmpty())
    <tfoot>
        <tr style="background:#f6f7f7; font-weight:600; font-size:13px;">
            <td colspan="5" class="text-right pr-2" style="padding:10px 8px; border-top:2px solid #c3c4c7;">
                Totals ({{ $totalCustomers }} customers)
            </td>
            <td class="text-center" style="padding:10px 8px; border-top:2px solid #c3c4c7;">
                {{ number_format($customers->sum('total_orders')) }}
            </td>
            <td class="text-right" style="padding:10px 8px; border-top:2px solid #c3c4c7;">
                TK {{ number_format($customers->sum('total_spent')) }}
            </td>
            <td class="text-center" style="padding:10px 8px; border-top:2px solid #c3c4c7;">
                {{ number_format($customers->sum('period_orders')) }}
            </td>
            <td class="text-right" style="padding:10px 8px; border-top:2px solid #c3c4c7;">
                TK {{ number_format($totalRevenue) }}
            </td>
            <td colspan="2" style="padding:10px 8px; border-top:2px solid #c3c4c7;"></td>
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
        $('#customerTable').DataTable({
            pageLength: 25,
            language: { search: "_INPUT_", searchPlaceholder: "Search customers..." }
        });
    });
</script>
@endpush
