@extends('Admin.Layout.app')

@section('title', 'Customer Dues')
@section('page_title', 'Customer Dues')

@push('styles')
@include('Admin._partials.wp-styles')
<style>
    .avatar { width:32px; height:32px; border-radius:50%; background:linear-gradient(135deg,#f43f5e,#f97316); color:#fff; display:inline-flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; flex-shrink:0; }
    .summary-card { background: #fff; border: 1px solid #c3c4c7; padding: 14px 16px; border-radius: 4px; }
    .summary-card .lbl { font-size: 12px; color: #50575e; text-transform: uppercase; letter-spacing: .04em; font-weight: 600; }
    .summary-card .val { font-size: 22px; color: #1d2327; font-weight: 700; margin-top: 4px; }
    .due-pill { display:inline-block; padding:1px 8px; border-radius:999px; font-size:11px; font-weight:700; }
    .due-pill-over { background:#fee2e2; color:#b91c1c; }
    .due-pill-ok { background:#fef3c7; color:#92400e; }
</style>
@endpush

@section('content')

<div class="flex items-center gap-3 mb-4">
    <h1 class="wp-h1">Customer Dues</h1>
    <span class="text-[13px] text-[#50575e]">Who took goods on credit (POS “Due sale”) and how much they still owe</span>
</div>

<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">
    <div class="summary-card">
        <div class="lbl">Total Due</div>
        <div class="val text-rose-700">{{ \App\Support\Money::format($summary['total']) }}</div>
    </div>
    <div class="summary-card">
        <div class="lbl">Customers with Due</div>
        <div class="val">{{ number_format($summary['customers']) }}</div>
    </div>
    <div class="summary-card">
        <div class="lbl">Overdue</div>
        <div class="val text-red-700">{{ \App\Support\Money::format($summary['overdue']) }}</div>
    </div>
    <div class="summary-card">
        <div class="lbl">Collected This Month</div>
        <div class="val text-emerald-700">{{ \App\Support\Money::format($summary['collected']) }}</div>
    </div>
</div>

<div class="flex flex-wrap items-center justify-between gap-2 mb-2">
    <ul class="flex items-center gap-x-1 wp-subtab" style="font-size:13px;">
        <li><a href="{{ route('admin.dues.index', array_filter(['s' => $search ?: null])) }}" style="color: {{ $filter === 'all' ? '#000' : '#2271b1' }}; font-weight: {{ $filter === 'all' ? 600 : 'normal' }};">All dues</a></li>
        <li><span class="text-[#c3c4c7] mx-1.5">|</span><a href="{{ route('admin.dues.index', array_filter(['filter' => 'overdue', 's' => $search ?: null])) }}" style="color: {{ $filter === 'overdue' ? '#000' : '#2271b1' }}; font-weight: {{ $filter === 'overdue' ? 600 : 'normal' }};">Overdue only</a></li>
    </ul>
    <form method="GET" action="{{ route('admin.dues.index') }}" class="flex items-center gap-2">
        @if ($filter === 'overdue')<input type="hidden" name="filter" value="overdue">@endif
        <input type="search" name="s" value="{{ $search }}" placeholder="Search by name or phone…" class="wp-input" style="width:260px">
        <button type="submit" class="wp-btn">Search</button>
    </form>
</div>

<div style="overflow-x:auto;-webkit-overflow-scrolling:touch;">
<table class="wp-list-table">
    <thead>
        <tr>
            <th>Customer</th>
            <th>Phone</th>
            <th class="text-center" style="width:100px">Due Sales</th>
            <th style="width:140px">Last Sale</th>
            <th style="width:150px">Pay By</th>
            <th class="text-right" style="width:140px">Due</th>
            <th class="text-right" style="width:120px"></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($customers as $c)
            @php $overdue = (float) $c->overdue_total > 0; @endphp
            <tr>
                <td>
                    <div class="flex items-center gap-3">
                        <div class="avatar">{{ strtoupper(mb_substr($c->name, 0, 1)) }}</div>
                        <strong><a href="{{ route('admin.dues.show', $c) }}" class="text-[#2271b1] hover:text-[#135e96]">{{ $c->name }}</a></strong>
                    </div>
                </td>
                <td>{{ $c->phone }}</td>
                <td class="text-center"><strong>{{ $c->due_sales }}</strong></td>
                <td class="text-[12px] text-[#50575e]">{{ $c->last_sale_at ? \Illuminate\Support\Carbon::parse($c->last_sale_at)->setTimezone(\App\Models\DealsBanner::LOCAL_TZ)->format('d M, Y') : '—' }}</td>
                <td class="text-[12px]">
                    {{ $c->oldest_due_date ? \Illuminate\Support\Carbon::parse($c->oldest_due_date)->format('d M, Y') : '—' }}
                    @if ($overdue)
                        <span class="due-pill due-pill-over ml-1">Overdue</span>
                    @endif
                </td>
                <td class="text-right"><strong class="text-rose-700 text-[14px]">{{ \App\Support\Money::format($c->due_total) }}</strong></td>
                <td class="text-right">
                    <a href="{{ route('admin.dues.show', $c) }}" class="wp-btn">Collect</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-[#646970] py-10">
                    <i class="fas fa-circle-check text-emerald-500 text-xl mb-2"></i><br>
                    No dues — nobody owes anything right now.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>

<div class="mt-3">{{ $customers->links() }}</div>

@endsection
