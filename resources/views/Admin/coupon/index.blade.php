@extends('Admin.Layout.app')

@section('title', 'Coupons')
@section('page_title', 'Coupons')

@push('styles')
@include('Admin._partials.wp-styles')
<style>
    .coupon-code { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; background: #f3f4f6; padding: 3px 8px; border-radius: 4px; font-weight: 700; color: #1d2327; font-size: 12.5px; }
    .type-pill { display: inline-block; padding: 2px 8px; font-size: 11px; font-weight: 600; border-radius: 3px; text-transform: uppercase; }
    .type-percentage { background: #ecfdf5; color: #047857; }
    .type-fixed { background: #eff6ff; color: #1d4ed8; }
    .coupon-status-pill { display: inline-block; padding: 2px 10px; font-size: 11px; font-weight: 600; border-radius: 10px; text-transform: capitalize; }
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

<div class="flex items-center gap-3 mb-4 flex-wrap">
    <h1 class="wp-h1">Coupons</h1>
    <a href="{{ route('admin.coupons.create') }}" class="wp-add-new">Add New</a>
    @if ($search)
        <span class="text-[14px] text-[#50575e]">Search results for: <strong>"{{ $search }}"</strong></span>
    @endif
</div>

<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">
    <div class="summary-card">
        <div class="lbl">Total Coupons</div>
        <div class="val">{{ number_format($counts['all']) }}</div>
    </div>
    <div class="summary-card">
        <div class="lbl">Active</div>
        <div class="val text-emerald-700">{{ number_format($counts['active']) }}</div>
    </div>
    <div class="summary-card">
        <div class="lbl">Scheduled</div>
        <div class="val text-blue-700">{{ number_format($counts['scheduled']) }}</div>
    </div>
    <div class="summary-card">
        <div class="lbl">Expired</div>
        <div class="val text-red-600">{{ number_format($counts['expired']) }}</div>
    </div>
</div>

@php
    $tabs = [
        ['key' => 'all',       'label' => 'All',       'count' => $counts['all']],
        ['key' => 'active',    'label' => 'Active',    'count' => $counts['active']],
        ['key' => 'scheduled', 'label' => 'Scheduled', 'count' => $counts['scheduled']],
        ['key' => 'expired',   'label' => 'Expired',   'count' => $counts['expired']],
        ['key' => 'inactive',  'label' => 'Inactive',  'count' => $counts['inactive']],
    ];
@endphp

<ul class="flex items-center flex-wrap gap-x-1 wp-subtab mb-3" style="font-size:13px;">
    @foreach ($tabs as $i => $tab)
        <li class="flex items-center">
            @if ($i > 0) <span class="text-[#c3c4c7] mx-1.5">|</span> @endif
            <a href="{{ route('admin.coupons.index', array_filter(['filter' => $tab['key'] === 'all' ? null : $tab['key'], 's' => $search ?: null])) }}"
               style="color: {{ $filter === $tab['key'] ? '#000' : '#2271b1' }}; font-weight: {{ $filter === $tab['key'] ? 600 : 'normal' }}; text-decoration: none;">
                {{ $tab['label'] }} <span class="text-[#646970]">({{ $tab['count'] }})</span>
            </a>
        </li>
    @endforeach
</ul>

<form method="GET" action="{{ route('admin.coupons.index') }}" class="mb-2 flex items-center justify-end gap-2">
    <input type="hidden" name="filter" value="{{ $filter }}">
    <input type="search" name="s" value="{{ $search }}" placeholder="Search code or description..." class="wp-input" style="width:280px">
    <button type="submit" class="wp-btn">Search</button>
</form>

<table class="wp-list-table">
    <thead>
        <tr>
            <th>Code</th>
            <th>Description</th>
            <th class="text-center" style="width:100px">Type</th>
            <th class="text-right" style="width:110px">Amount</th>
            <th class="text-center" style="width:120px">Usage / Limit</th>
            <th class="text-center" style="width:120px">Expires</th>
            <th class="text-center" style="width:110px">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($coupons as $c)
            <tr>
                <td>
                    <span class="coupon-code">{{ $c->code }}</span>
                    <div class="wp-row-actions">
                        <span><a href="{{ route('admin.coupons.edit', $c) }}">Edit</a> |</span>
                        <span>
                            <form method="POST" action="{{ route('admin.coupons.toggle-status', $c) }}" style="display:inline">
                                @csrf @method('PATCH')
                                <button type="submit">{{ $c->status ? 'Deactivate' : 'Activate' }}</button>
                            </form> |
                        </span>
                        <span>
                            <form method="POST" action="{{ route('admin.coupons.destroy', $c) }}" style="display:inline" onsubmit="return confirm('Delete this coupon?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="trash">Delete</button>
                            </form>
                        </span>
                    </div>
                </td>
                <td class="text-[#50575e]">{{ $c->description ?: '—' }}</td>
                <td class="text-center">
                    <span class="type-pill type-{{ $c->type }}">{{ $c->type === 'percentage' ? '%' : 'Flat' }}</span>
                </td>
                <td class="text-right">
                    <strong>
                        @if ($c->type === 'percentage')
                            {{ rtrim(rtrim(number_format($c->amount, 2, '.', ''), '0'), '.') }}%
                        @else
                            ৳ {{ number_format($c->amount, 2) }}
                        @endif
                    </strong>
                    @if ($c->minimum_spend)
                        <div class="text-[11px] text-[#646970]">min ৳{{ number_format($c->minimum_spend, 0) }}</div>
                    @endif
                </td>
                <td class="text-center">
                    <strong>{{ $c->used_count }}</strong>
                    @if ($c->usage_limit)
                        / {{ $c->usage_limit }}
                    @else
                        <span class="text-[#646970]">/ ∞</span>
                    @endif
                </td>
                <td class="text-center text-[12.5px] text-[#50575e]">
                    @if ($c->expires_at)
                        {{ $c->expires_at->format('d M, Y') }}
                    @else
                        <span class="text-[#646970]">Never</span>
                    @endif
                </td>
                <td class="text-center">
                    @php
                        $status = $c->statusLabel();
                        $sMap = [
                            'active'    => ['#d1fae5', '#047857'],
                            'scheduled' => ['#dbeafe', '#1d4ed8'],
                            'expired'   => ['#fee2e2', '#b91c1c'],
                            'exhausted' => ['#fef3c7', '#92400e'],
                            'inactive'  => ['#e5e7eb', '#374151'],
                        ];
                        [$bg, $fg] = $sMap[$status] ?? ['#f3f4f6', '#374151'];
                    @endphp
                    <span class="coupon-status-pill" style="background:{{ $bg }};color:{{ $fg }}">{{ $status }}</span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-[#646970] py-8">
                    No coupons found.
                    <a href="{{ route('admin.coupons.create') }}" class="text-[#2271b1] hover:underline">Create your first coupon</a>.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-3">{{ $coupons->links() }}</div>

@endsection
