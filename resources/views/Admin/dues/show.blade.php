@extends('Admin.Layout.app')

@section('title', 'Due — ' . $customer->name)
@section('page_title', 'Customer Dues')

@push('styles')
@include('Admin._partials.wp-styles')
<style>
    .due-total { font-size: 30px; font-weight: 800; color: #be123c; line-height: 1.1; }
    .due-pill { display:inline-block; padding:1px 8px; border-radius:999px; font-size:11px; font-weight:700; }
    .due-pill-over { background:#fee2e2; color:#b91c1c; }
</style>
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif

<div class="flex items-center gap-3 mb-3">
    <a href="{{ route('admin.dues.index') }}" class="text-[13px] text-[#2271b1]"><i class="fas fa-arrow-left mr-1"></i> All dues</a>
</div>
<div class="flex flex-wrap items-center gap-3 mb-4">
    <h1 class="wp-h1">{{ $customer->name }}</h1>
    <span class="text-[14px] text-[#50575e]"><i class="fas fa-phone mr-1"></i>{{ $customer->phone }}</span>
</div>

<div class="grid grid-cols-12 gap-5">
    <div class="col-span-12 lg:col-span-8 space-y-5">

        <div class="wp-panel">
            <div class="wp-panel-h">Unpaid Sales</div>
            <div class="wp-panel-body" style="padding:0">
                <div style="overflow-x:auto">
                <table class="wp-list-table" style="border:0">
                    <thead>
                        <tr>
                            <th>Sale</th>
                            <th>Date</th>
                            <th class="text-right">Total</th>
                            <th class="text-right">Paid</th>
                            <th class="text-right">Due</th>
                            <th>Pay By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dueOrders as $o)
                            <tr>
                                <td><a href="{{ route('admin.orders.show', $o) }}" class="text-[#2271b1] font-semibold">#{{ $o->order_no }}</a></td>
                                <td class="text-[12px] text-[#50575e]">{{ ($o->placed_at ?? $o->created_at)->copy()->setTimezone(\App\Models\DealsBanner::LOCAL_TZ)->format('d M, Y h:i A') }}</td>
                                <td class="text-right">{{ \App\Support\Money::format($o->total) }}</td>
                                <td class="text-right text-emerald-700">{{ \App\Support\Money::format($o->paid_amount ?? 0) }}</td>
                                <td class="text-right"><strong class="text-rose-700">{{ \App\Support\Money::format($o->due_amount) }}</strong></td>
                                <td class="text-[12px]">
                                    {{ $o->due_date?->format('d M, Y') ?? '—' }}
                                    @if ($o->isOverdue())<span class="due-pill due-pill-over ml-1">Overdue</span>@endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-[#646970] py-8">No unpaid sales — all settled. <i class="fas fa-circle-check text-emerald-500"></i></td></tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>

        <div class="wp-panel">
            <div class="wp-panel-h">Payment History</div>
            <div class="wp-panel-body" style="padding:0">
                <div style="overflow-x:auto">
                <table class="wp-list-table" style="border:0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Sale</th>
                            <th>Method</th>
                            <th>Received By</th>
                            <th>Note</th>
                            <th class="text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $p)
                            <tr>
                                <td class="text-[12px] text-[#50575e]">{{ $p->paid_at->copy()->setTimezone(\App\Models\DealsBanner::LOCAL_TZ)->format('d M, Y h:i A') }}</td>
                                <td>{{ $p->order ? '#' . $p->order->order_no : '—' }}</td>
                                <td class="uppercase text-[12px]">{{ $p->payment_method }}</td>
                                <td class="text-[12px]">{{ $p->receivedBy->name ?? '—' }}</td>
                                <td class="text-[12px] text-[#50575e]">{{ $p->note ?: '—' }}</td>
                                <td class="text-right"><strong class="text-emerald-700">{{ \App\Support\Money::format($p->amount) }}</strong></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-[#646970] py-6">No payments collected yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-4 space-y-5">
        <div class="wp-panel">
            <div class="wp-panel-h">Total Due</div>
            <div class="wp-panel-body">
                <div class="due-total">{{ \App\Support\Money::format($outstanding) }}</div>
                <p class="wp-help mt-1">{{ $dueOrders->count() }} unpaid {{ \Illuminate\Support\Str::plural('sale', $dueOrders->count()) }}</p>
            </div>
        </div>

        @if ($outstanding > 0)
        <div class="wp-panel" id="collect-panel">
            <div class="wp-panel-h"><span><i class="fas fa-hand-holding-dollar mr-1"></i> Collect Payment</span></div>
            <div class="wp-panel-body">
                @if ($errors->any())
                    <div class="mb-3 px-3 py-2 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">{{ $errors->first() }}</div>
                @endif
                <form method="POST" action="{{ route('admin.dues.collect', $customer) }}">
                    @csrf
                    <div class="wp-field">
                        <label>Amount</label>
                        <input type="number" name="amount" step="0.01" min="0.01" max="{{ $outstanding }}" value="{{ old('amount', $outstanding) }}" class="wp-input" required>
                        <p class="wp-help">Full or part payment. Applied to the oldest sale first.</p>
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
                        <label>Note <span class="font-normal text-[#646970]">(optional)</span></label>
                        <input type="text" name="note" value="{{ old('note') }}" maxlength="500" class="wp-input" placeholder="e.g. bKash TrxID">
                    </div>
                    <button type="submit" class="wp-btn wp-btn-primary w-full">Collect Payment</button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection
