@extends('Admin.Layout.app')

@section('title', 'Supplier Dues')
@section('page_title', 'Supplier Dues')

@push('styles')
@include('Admin.accounts._styles')
@endpush

@section('content')
@php $money = fn ($v) => \App\Support\Money::format($v); @endphp

<div class="flex flex-wrap items-center gap-3 mb-4">
    <h1 class="wp-h1">Supplier Dues</h1>
    <span class="text-[13px] text-[#50575e]">How much was bought from each supplier and how much is still unpaid</span>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
    <div class="summary-card"><div class="lbl">Total Purchased</div><div class="val">{{ $money($summary['purchased']) }}</div><div class="sub">Cancelled purchases not counted</div></div>
    <div class="summary-card"><div class="lbl">Returned to Suppliers</div><div class="val">{{ $money($summary['returned']) }}</div><div class="sub">From GRN returns</div></div>
    <div class="summary-card"><div class="lbl">Paid</div><div class="val amt-pos">{{ $money($summary['paid']) }}</div></div>
    <div class="summary-card net-neg"><div class="lbl">Total Due</div><div class="val amt-neg">{{ $money($summary['due']) }}</div><div class="sub">{{ $summary['suppliers'] }} {{ \Illuminate\Support\Str::plural('supplier', $summary['suppliers']) }} to pay</div></div>
</div>

<div class="flex flex-wrap items-center justify-between gap-2 mb-2">
    <ul class="flex items-center gap-x-1 wp-subtab" style="font-size:13px;">
        <li><a href="{{ route('admin.supplier-dues.index', array_filter(['s' => $search ?: null])) }}" style="color: {{ $filter === 'all' ? '#000' : '#2271b1' }}; font-weight: {{ $filter === 'all' ? 600 : 'normal' }};">All suppliers</a></li>
        <li><span class="text-[#c3c4c7] mx-1.5">|</span><a href="{{ route('admin.supplier-dues.index', array_filter(['filter' => 'due', 's' => $search ?: null])) }}" style="color: {{ $filter === 'due' ? '#000' : '#2271b1' }}; font-weight: {{ $filter === 'due' ? 600 : 'normal' }};">With due only</a></li>
    </ul>
    <form method="GET" action="{{ route('admin.supplier-dues.index') }}" class="flex items-center gap-2">
        @if ($filter === 'due')<input type="hidden" name="filter" value="due">@endif
        <input type="search" name="s" value="{{ $search }}" placeholder="Search supplier…" class="wp-input" style="width:240px">
        <button type="submit" class="wp-btn">Search</button>
    </form>
</div>

<div style="overflow-x:auto;-webkit-overflow-scrolling:touch;">
<table class="wp-list-table">
    <thead>
        <tr>
            <th>Supplier</th>
            <th class="text-center">Purchases</th>
            <th style="width:120px">Last Purchase</th>
            <th class="text-right">Purchased</th>
            <th class="text-right">Returned</th>
            <th class="text-right">Paid</th>
            <th class="text-right">Due</th>
            <th class="text-right" style="width:90px"></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($suppliers as $s)
            @php $due = (float) $s->due; @endphp
            <tr>
                <td>
                    <strong><a href="{{ route('admin.supplier-dues.show', $s) }}" class="text-[#2271b1]">{{ $s->name }}</a></strong>
                    @if ($s->company || $s->phone)<div class="text-[11.5px] text-[#646970]">{{ collect([$s->company, $s->phone])->filter()->implode(' · ') }}</div>@endif
                </td>
                <td class="text-center">{{ $s->purchase_count }}</td>
                <td class="text-[12px] text-[#50575e]">{{ $s->last_purchase ? \Illuminate\Support\Carbon::parse($s->last_purchase)->format('d M, Y') : '—' }}</td>
                <td class="text-right">{{ $money($s->purchased) }}</td>
                <td class="text-right text-[#50575e]">{{ $money($s->returned) }}</td>
                <td class="text-right amt-pos">{{ $money($s->paid) }}</td>
                <td class="text-right">
                    @if ($due > 0.009)
                        <strong class="amt-neg text-[14px]">{{ $money($due) }}</strong>
                    @elseif ($due < -0.009)
                        <span class="text-[12px] text-[#2271b1]">Advance {{ $money(-$due) }}</span>
                    @else
                        <span class="text-[12px] text-emerald-700"><i class="fas fa-circle-check"></i> Settled</span>
                    @endif
                </td>
                <td class="text-right"><a href="{{ route('admin.supplier-dues.show', $s) }}" class="wp-btn">{{ $due > 0.009 ? 'Pay' : 'View' }}</a></td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center text-[#646970] py-10">No purchases recorded yet.</td></tr>
        @endforelse
    </tbody>
</table>
</div>

<div class="mt-3">{{ $suppliers->links() }}</div>

@endsection
