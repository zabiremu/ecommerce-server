@extends('Admin.Layout.app')

@section('title', $cfg['plural'])
@section('page_title', 'Accounts & Reports')

@push('styles')
@include('Admin.accounts._styles')
@endpush

@section('content')
@php
    $money = fn ($v) => \App\Support\Money::format($v);
    $admin = Auth::guard('admin')->user();
    $perm = str_replace('admin.', '', $cfg['route']);
    $isInvestment = $cfg['singular'] === 'Investment';
    $currentMonth = substr($today, 0, 7);
@endphp

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif

<div class="flex flex-wrap items-center justify-between gap-3 mb-4">
    <div>
        <h1 class="wp-h1">{{ $cfg['plural'] }} — {{ $start->format('F Y') }}</h1>
        <p class="text-[13px] text-[#50575e] mt-1">{{ $cfg['intro'] }}</p>
    </div>
    <form method="GET" action="{{ route($cfg['route'] . '.index') }}" class="acc-nav">
        <a href="{{ route($cfg['route'] . '.index', ['month' => $prevMonth]) }}" class="wp-btn" title="Previous month"><i class="fas fa-chevron-left"></i></a>
        <input type="month" name="month" value="{{ $month }}" class="wp-input" style="width:170px" onchange="this.form.submit()">
        <a href="{{ route($cfg['route'] . '.index', ['month' => $nextMonth]) }}" class="wp-btn" title="Next month"><i class="fas fa-chevron-right"></i></a>
    </form>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
    @if ($isInvestment)
        <div class="summary-card"><div class="lbl">Total Invested ({{ $start->format('M') }})</div><div class="val">{{ $money($extras['month_total']) }}</div><div class="sub">Stock + other investment</div></div>
        <div class="summary-card"><div class="lbl">Stock Bought</div><div class="val">{{ $money($extras['stock_total']) }}</div><div class="sub">From Purchases, automatic</div></div>
        <div class="summary-card"><div class="lbl">Other Investment</div><div class="val">{{ $money($monthTotal) }}</div><div class="sub">{{ $entries->total() }} {{ \Illuminate\Support\Str::plural('entry', $entries->total()) }}</div></div>
        <div class="summary-card"><div class="lbl">Total Investment (all time)</div><div class="val">{{ $money($extras['all_time']) }}</div></div>
    @else
        <div class="summary-card"><div class="lbl">Total ({{ $start->format('M Y') }})</div><div class="val">{{ $money($monthTotal) }}</div></div>
        <div class="summary-card"><div class="lbl">Entries</div><div class="val">{{ number_format($byCategory->sum('entries')) }}</div></div>
        <div class="summary-card"><div class="lbl">Biggest Category</div><div class="val" style="font-size:16px">{{ $byCategory->first() ? ($categories[$byCategory->first()->category] ?? $byCategory->first()->category) : '—' }}</div><div class="sub">{{ $byCategory->first() ? $money($byCategory->first()->total) : '' }}</div></div>
        <div class="summary-card"><div class="lbl">All-time Expenses</div><div class="val">{{ $money($allTimeTotal) }}</div></div>
    @endif
</div>

<div class="grid grid-cols-12 gap-5">
    <div class="col-span-12 lg:col-span-8 space-y-5">
        @if ($byCategory->isNotEmpty())
        <ul class="flex flex-wrap items-center gap-x-1 gap-y-1 wp-subtab" style="font-size:13px;">
            <li><a href="{{ route($cfg['route'] . '.index', ['month' => $month]) }}" style="color: {{ $category === '' ? '#000' : '#2271b1' }}; font-weight: {{ $category === '' ? 600 : 'normal' }};">All <span class="text-[#646970]">({{ $byCategory->sum('entries') }})</span></a></li>
            @foreach ($byCategory as $row)
                <li><span class="text-[#c3c4c7] mx-1.5">|</span><a href="{{ route($cfg['route'] . '.index', ['month' => $month, 'category' => $row->category]) }}" style="color: {{ $category === $row->category ? '#000' : '#2271b1' }}; font-weight: {{ $category === $row->category ? 600 : 'normal' }};">{{ $categories[$row->category] ?? $row->category }} <span class="text-[#646970]">({{ $money($row->total) }})</span></a></li>
            @endforeach
        </ul>
        @endif

        <div class="wp-panel">
            <div class="wp-panel-h">{{ $isInvestment ? 'Investment List' : 'Expense List' }}</div>
            <div class="wp-panel-body" style="padding:0">
                <div style="overflow-x:auto">
                <table class="wp-list-table" style="border:0">
                    <thead>
                        <tr>
                            <th style="width:110px">Date</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Paid by</th>
                            <th class="text-right">Amount</th>
                            <th class="text-right" style="width:110px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($entries as $e)
                            <tr>
                                <td class="text-[12px] text-[#50575e]">{{ $e->entry_date->format('d M, Y') }}</td>
                                <td>
                                    <strong>{{ $e->title }}</strong>
                                    @if ($e->note)<div class="text-[11.5px] text-[#646970]">{{ $e->note }}</div>@endif
                                    @if ($e->createdBy)<div class="text-[11px] text-[#a7aaad]">by {{ $e->createdBy->name }}</div>@endif
                                </td>
                                <td class="text-[12px]">{{ $e->category_label }}</td>
                                <td class="uppercase text-[12px]">{{ $e->payment_method ?: '—' }}</td>
                                <td class="text-right"><strong>{{ $money($e->amount) }}</strong></td>
                                <td class="text-right whitespace-nowrap">
                                    @if ($admin->hasPermission($perm . '.edit'))
                                        <a href="{{ route($cfg['route'] . '.edit', $e->id) }}" class="wp-btn" title="Edit"><i class="fas fa-pen"></i></a>
                                    @endif
                                    @if ($admin->hasPermission($perm . '.delete'))
                                        <form method="POST" action="{{ route($cfg['route'] . '.destroy', $e->id) }}" class="inline" onsubmit="return confirm('Delete this {{ strtolower($cfg['singular']) }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="wp-btn" title="Delete" style="color:#b32d2e"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-[#646970] py-10">
                                <i class="fas {{ $cfg['icon'] }} text-xl mb-2 text-[#a7aaad]"></i><br>
                                Nothing entered for {{ $start->format('F Y') }}{{ $category !== '' ? ' in this category' : '' }}.
                            </td></tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <div>{{ $entries->links() }}</div>

        @if ($isInvestment)
        <div class="wp-panel">
            <div class="wp-panel-h">
                <span>Stock Bought from Suppliers</span>
                <span class="text-[12px] font-normal text-[#646970]">Added automatically from Purchases</span>
            </div>
            <div class="wp-panel-body" style="padding:0">
                <div style="overflow-x:auto">
                <table class="wp-list-table" style="border:0">
                    <thead>
                        <tr><th style="width:110px">Date</th><th>Invoice</th><th>Supplier</th><th>Status</th><th class="text-right">Amount</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($extras['purchases'] as $p)
                            <tr>
                                <td class="text-[12px] text-[#50575e]">{{ $p->purchase_date?->format('d M, Y') }}</td>
                                <td>
                                    @if ($admin->hasPermission('purchases.view'))
                                        <a href="{{ route('admin.purchases.show', $p->id) }}" class="text-[#2271b1]">{{ $p->invoice_no }}</a>
                                    @else
                                        {{ $p->invoice_no }}
                                    @endif
                                </td>
                                <td>{{ $p->supplier->name ?? '—' }}</td>
                                <td class="text-[12px]">{{ ucfirst($p->status) }}</td>
                                <td class="text-right"><strong>{{ $money($p->total_amount) }}</strong></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-[#646970] py-6">No stock purchases this month.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-span-12 lg:col-span-4">
        @if ($admin->hasPermission($perm . '.create'))
        <div class="wp-panel">
            <div class="wp-panel-h"><span><i class="fas fa-plus mr-1"></i> Add {{ $cfg['singular'] }}</span></div>
            <div class="wp-panel-body">
                <form method="POST" action="{{ route($cfg['route'] . '.store') }}">
                    @csrf
                    @include('Admin.accounts._ledger_form', ['defaultDate' => $month === $currentMonth ? $today : $start->toDateString()])
                    <button type="submit" class="wp-btn wp-btn-primary w-full">Add {{ $cfg['singular'] }}</button>
                </form>
                @if ($isInvestment)
                    <p class="wp-help mt-2">Don't enter stock bought from suppliers here — record it in Purchases and it is added automatically.</p>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

@endsection
