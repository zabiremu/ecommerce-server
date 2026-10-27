@extends('Admin.Layout.app')

@section('title', 'Supplier Due — ' . $supplier->name)
@section('page_title', 'Supplier Dues')

@push('styles')
@include('Admin.accounts._styles')
@endpush

@section('content')
@php
    $money = fn ($v) => \App\Support\Money::format($v);
    $due = (float) $totals->due;
    $canPay = Auth::guard('admin')->user()->hasPermission('supplier_dues.edit');
@endphp

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif

<div class="flex items-center gap-3 mb-3">
    <a href="{{ route('admin.supplier-dues.index') }}" class="text-[13px] text-[#2271b1]"><i class="fas fa-arrow-left mr-1"></i> All suppliers</a>
</div>
<div class="flex flex-wrap items-center gap-3 mb-4">
    <h1 class="wp-h1">{{ $supplier->name }}</h1>
    <span class="text-[13px] text-[#50575e]">{{ collect([$supplier->company, $supplier->phone])->filter()->implode(' · ') }}</span>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
    <div class="summary-card"><div class="lbl">Purchased</div><div class="val">{{ $money($totals->purchased) }}</div><div class="sub">{{ $totals->purchase_count }} {{ \Illuminate\Support\Str::plural('purchase', $totals->purchase_count) }}</div></div>
    <div class="summary-card"><div class="lbl">Returned</div><div class="val">{{ $money($totals->returned) }}</div></div>
    <div class="summary-card"><div class="lbl">Paid</div><div class="val amt-pos">{{ $money($totals->paid) }}</div></div>
    <div class="summary-card {{ $due > 0.009 ? 'net-neg' : 'net-pos' }}">
        <div class="lbl">{{ $due < -0.009 ? 'Advance Paid' : 'Due' }}</div>
        <div class="val {{ $due > 0.009 ? 'amt-neg' : 'amt-pos' }}">{{ $money(abs($due)) }}</div>
    </div>
</div>

<div class="grid grid-cols-12 gap-5">
    <div class="col-span-12 lg:col-span-8 space-y-5">
        <div class="wp-panel">
            <div class="wp-panel-h">Purchases</div>
            <div class="wp-panel-body" style="padding:0">
                <div style="overflow-x:auto">
                <table class="wp-list-table" style="border:0">
                    <thead><tr><th>Date</th><th>Invoice</th><th>Status</th><th class="text-right">Amount</th><th class="text-right">Paid against it</th></tr></thead>
                    <tbody>
                        @forelse ($purchases as $p)
                            <tr class="{{ $p->status === 'cancelled' ? 'text-[#a7aaad]' : '' }}">
                                <td class="text-[12px]">{{ $p->purchase_date?->format('d M, Y') }}</td>
                                <td><a href="{{ route('admin.purchases.show', $p) }}" class="text-[#2271b1] font-mono">{{ $p->invoice_no }}</a></td>
                                <td class="text-[12px]">{{ ucfirst($p->status) }}{{ $p->status === 'cancelled' ? ' (not counted)' : '' }}</td>
                                <td class="text-right">{{ $money($p->total_amount) }}</td>
                                <td class="text-right text-[#50575e]">{{ $money($p->paid_total ?? 0) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-[#646970] py-6">No purchases.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>

        @if ($returns->isNotEmpty())
        <div class="wp-panel">
            <div class="wp-panel-h">Returned to Supplier</div>
            <div class="wp-panel-body" style="padding:0">
                <table class="wp-list-table" style="border:0">
                    <thead><tr><th>Date</th><th>Return #</th><th>Reason</th><th class="text-right">Amount</th></tr></thead>
                    <tbody>
                        @foreach ($returns as $r)
                            <tr>
                                <td class="text-[12px]">{{ $r->return_date?->format('d M, Y') }}</td>
                                <td class="font-mono">{{ $r->return_no }}</td>
                                <td class="text-[12px] text-[#50575e]">{{ $r->reason ?: '—' }}</td>
                                <td class="text-right">{{ $money($r->return_total ?? 0) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <div class="wp-panel">
            <div class="wp-panel-h">Payment History</div>
            <div class="wp-panel-body" style="padding:0">
                <div style="overflow-x:auto">
                <table class="wp-list-table" style="border:0">
                    <thead><tr><th>Date</th><th>Purchase</th><th>Method</th><th>By</th><th>Note</th><th class="text-right">Amount</th>@if ($canPay)<th></th>@endif</tr></thead>
                    <tbody>
                        @forelse ($payments as $pay)
                            <tr>
                                <td class="text-[12px]">{{ $pay->paid_on->format('d M, Y') }}</td>
                                <td class="font-mono text-[12px]">{{ $pay->purchase->invoice_no ?? '—' }}</td>
                                <td class="uppercase text-[12px]">{{ $pay->payment_method }}</td>
                                <td class="text-[12px]">{{ $pay->paidBy->name ?? '—' }}</td>
                                <td class="text-[12px] text-[#50575e]">{{ $pay->note ?: '—' }}</td>
                                <td class="text-right"><strong class="amt-pos">{{ $money($pay->amount) }}</strong></td>
                                @if ($canPay)
                                <td class="text-right">
                                    <form method="POST" action="{{ route('admin.supplier-dues.payments.destroy', [$supplier, $pay]) }}" onsubmit="return confirm('Remove this payment?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="wp-btn" title="Remove" style="color:#b32d2e"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-[#646970] py-6">No payments made yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-4">
        @if ($canPay)
        <div class="wp-panel">
            <div class="wp-panel-h"><span><i class="fas fa-hand-holding-dollar mr-1"></i> Pay Supplier</span></div>
            <div class="wp-panel-body">
                @if ($errors->any())
                    <div class="mb-3 px-3 py-2 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">{{ $errors->first() }}</div>
                @endif
                <form method="POST" action="{{ route('admin.supplier-dues.pay', $supplier) }}">
                    @csrf
                    <div class="wp-field">
                        <label>Amount</label>
                        <input type="number" name="amount" step="0.01" min="0.01" value="{{ old('amount', $due > 0 ? round($due, 2) : '') }}" class="wp-input" required>
                    </div>
                    <div class="wp-field">
                        <label>Date</label>
                        <input type="date" name="paid_on" value="{{ old('paid_on', $today) }}" class="wp-input" required>
                    </div>
                    <div class="wp-field">
                        <label>Method</label>
                        <select name="payment_method" class="wp-input">
                            @foreach ($methods as $m)
                                <option value="{{ $m }}" @selected(old('payment_method', 'cash') === $m)>{{ ucfirst($m) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="wp-field">
                        <label>For purchase <span class="font-normal text-[#646970]">(optional)</span></label>
                        <select name="purchase_id" class="wp-input">
                            <option value="">— General payment —</option>
                            @foreach ($purchases->where('status', '!=', 'cancelled') as $p)
                                <option value="{{ $p->id }}" @selected(old('purchase_id') == $p->id)>{{ $p->invoice_no }} — {{ $money($p->total_amount) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="wp-field">
                        <label>Note <span class="font-normal text-[#646970]">(optional)</span></label>
                        <input type="text" name="note" value="{{ old('note') }}" maxlength="500" class="wp-input" placeholder="e.g. bKash TrxID">
                    </div>
                    <button type="submit" class="wp-btn wp-btn-primary w-full">Save Payment</button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection
