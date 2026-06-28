@extends('Admin.Layout.app')

@section('title', 'Customers')
@section('page_title', 'Customers')

@push('styles')
@include('Admin._partials.wp-styles')
<style>
    .avatar { width:32px; height:32px; border-radius:50%; background:linear-gradient(135deg,#6366f1,#a855f7); color:#fff; display:inline-flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; }
    .summary-card { background: #fff; border: 1px solid #c3c4c7; padding: 14px 16px; border-radius: 4px; }
    .summary-card .lbl { font-size: 12px; color: #50575e; text-transform: uppercase; letter-spacing: .04em; font-weight: 600; }
    .summary-card .val { font-size: 22px; color: #1d2327; font-weight: 700; margin-top: 4px; }
</style>
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="mb-4 px-4 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">{{ session('error') }}</div>
@endif

<div class="flex items-center gap-3 mb-4">
    <h1 class="wp-h1">Customers</h1>
    @if ($search)
        <span class="text-[14px] text-[#50575e]">Search results for: <strong>"{{ $search }}"</strong></span>
    @endif
</div>

<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">
    <div class="summary-card">
        <div class="lbl">Total Customers</div>
        <div class="val">{{ number_format($counts['all']) }}</div>
    </div>
    <div class="summary-card">
        <div class="lbl">Active</div>
        <div class="val text-emerald-700">{{ number_format($counts['active']) }}</div>
    </div>
    <div class="summary-card">
        <div class="lbl">With Orders</div>
        <div class="val text-blue-700">{{ number_format($counts['with-orders']) }}</div>
    </div>
    <div class="summary-card">
        <div class="lbl">No Orders</div>
        <div class="val text-gray-500">{{ number_format($counts['no-orders']) }}</div>
    </div>
</div>

@php
    $filterTabs = [
        ['key' => 'all',          'label' => 'All',          'count' => $counts['all']],
        ['key' => 'active',       'label' => 'Active',       'count' => $counts['active']],
        ['key' => 'inactive',     'label' => 'Inactive',     'count' => $counts['inactive']],
        ['key' => 'with-orders',  'label' => 'With Orders',  'count' => $counts['with-orders']],
        ['key' => 'no-orders',    'label' => 'No Orders',    'count' => $counts['no-orders']],
    ];
@endphp

<ul class="flex items-center flex-wrap gap-x-1 wp-subtab mb-3" style="font-size:13px;">
    @foreach ($filterTabs as $i => $tab)
        <li class="flex items-center">
            @if ($i > 0) <span class="text-[#c3c4c7] mx-1.5">|</span> @endif
            <a href="{{ route('admin.customers.index', array_filter(['filter' => $tab['key'] === 'all' ? null : $tab['key'], 's' => $search ?: null])) }}"
               class="{{ $filter === $tab['key'] ? 'current' : '' }}" style="color: {{ $filter === $tab['key'] ? '#000' : '#2271b1' }}; font-weight: {{ $filter === $tab['key'] ? 600 : 'normal' }};">
                {{ $tab['label'] }} <span class="text-[#646970]">({{ $tab['count'] }})</span>
            </a>
        </li>
    @endforeach
</ul>

<form method="GET" action="{{ route('admin.customers.index') }}" class="mb-2 flex items-center justify-end gap-2">
    <input type="hidden" name="filter" value="{{ $filter }}">
    <input type="search" name="s" value="{{ $search }}" placeholder="Search by name, phone, email..." class="wp-input" style="width:280px">
    <button type="submit" class="wp-btn">Search</button>
</form>

<div style="overflow-x:auto;-webkit-overflow-scrolling:touch;">
<table class="wp-list-table">
    <thead>
        <tr>
            <th>Customer</th>
            <th>Contact</th>
            <th>Location</th>
            <th class="text-center" style="width:90px">Orders</th>
            <th class="text-right" style="width:130px">Total Spent</th>
            <th style="width:130px">Last Order</th>
            <th class="text-center" style="width:90px">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($customers as $c)
            <tr>
                <td>
                    <div class="flex items-center gap-3">
                        <div class="avatar">{{ strtoupper(substr($c->name, 0, 1)) }}</div>
                        <div>
                            <strong>
                                <a href="{{ route('admin.customers.show', $c) }}" class="text-[#2271b1] hover:text-[#135e96]">{{ $c->name }}</a>
                            </strong>
                            <div class="wp-row-actions">
                                <span><a href="{{ route('admin.customers.show', $c) }}">View</a> |</span>
                                <span>
                                    <form method="POST" action="{{ route('admin.customers.toggle-status', $c) }}" style="display:inline">
                                        @csrf @method('PATCH')
                                        <button type="submit">{{ $c->status ? 'Disable' : 'Enable' }}</button>
                                    </form>
                                </span>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div>{{ $c->phone }}</div>
                    @if ($c->email)
                        <div class="text-[12px] text-[#50575e]">{{ $c->email }}</div>
                    @endif
                </td>
                <td class="text-[#50575e]">
                    {{ $c->city ?: '—' }}@if ($c->area), <span class="text-[12px]">{{ $c->area }}</span>@endif
                </td>
                <td class="text-center"><strong>{{ $c->total_orders }}</strong></td>
                <td class="text-right"><strong class="text-emerald-700">৳ {{ number_format($c->total_spent, 2) }}</strong></td>
                <td class="text-[#50575e] text-[12px]">{{ $c->last_order_at?->format('d M, Y') ?? '—' }}</td>
                <td class="text-center">
                    <span class="wp-status-pill {{ $c->status ? 'wp-status-on' : 'wp-status-off' }}">{{ $c->status ? 'Active' : 'Inactive' }}</span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-[#646970] py-8">No customers found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>

<div class="mt-3">{{ $customers->links() }}</div>

@endsection
