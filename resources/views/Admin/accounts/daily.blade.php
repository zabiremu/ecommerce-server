@extends('Admin.Layout.app')

@section('title', 'Daily Report')
@section('page_title', 'Accounts & Reports')

@push('styles')
@include('Admin.accounts._styles')
@endpush

@section('content')
@php
    $money = fn ($v) => \App\Support\Money::format($v);
    $day = \Illuminate\Support\Carbon::parse($date);
    $tz = \App\Models\DealsBanner::LOCAL_TZ;
@endphp

<div class="flex flex-wrap items-center justify-between gap-3 mb-4">
    <div class="flex items-center gap-3">
        <h1 class="wp-h1">Daily Report</h1>
        <span class="text-[14px] text-[#50575e]">{{ $day->format('l, d M Y') }}{{ $date === $today ? ' (today)' : '' }}</span>
    </div>
    <form method="GET" action="{{ route('admin.accounts.daily') }}" class="acc-nav">
        <a href="{{ route('admin.accounts.daily', ['date' => $prevDate]) }}" class="wp-btn" title="Previous day"><i class="fas fa-chevron-left"></i></a>
        <input type="date" name="date" value="{{ $date }}" max="{{ $today }}" class="wp-input" style="width:160px" onchange="this.form.submit()">
        @if ($nextDate)
            <a href="{{ route('admin.accounts.daily', ['date' => $nextDate]) }}" class="wp-btn" title="Next day"><i class="fas fa-chevron-right"></i></a>
        @endif
        @if ($date !== $today)
            <a href="{{ route('admin.accounts.daily') }}" class="wp-btn">Today</a>
        @endif
    </form>
</div>

@include('Admin.accounts._summary')

<div class="grid grid-cols-12 gap-5">
    <div class="col-span-12 lg:col-span-8 space-y-5">
        <div class="wp-panel">
            <div class="wp-panel-h">Sales</div>
            <div class="wp-panel-body" style="padding:0">
                <div style="overflow-x:auto">
                <table class="wp-list-table" style="border:0">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Order</th>
                            <th>Customer</th>
                            <th class="text-right">Sale</th>
                            <th class="text-right">Cost</th>
                            <th class="text-right">Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $o)
                            <tr>
                                <td class="text-[12px] text-[#50575e]">{{ $o->placed_at->copy()->setTimezone($tz)->format('h:i A') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $o->id) }}" class="text-[#2271b1]">#{{ $o->order_no }}</a>
                                    <span class="text-[11px] uppercase text-[#646970] ml-1">{{ $o->source === 'pos' ? 'POS' : 'Online' }}</span>
                                </td>
                                <td>{{ $o->shipping_name }}</td>
                                <td class="text-right">{{ $money($o->total) }}</td>
                                <td class="text-right text-[#50575e]">{{ $money($o->cost) }}</td>
                                <td class="text-right"><strong class="{{ $o->profit < 0 ? 'amt-neg' : 'amt-pos' }}">{{ $money($o->profit) }}</strong></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-[#646970] py-8">No sales on this day.</td></tr>
                        @endforelse
                    </tbody>
                    @if ($orders->isNotEmpty())
                    <tfoot>
                        <tr>
                            <td colspan="3">Total</td>
                            <td class="text-right">{{ $money($summary['sales']) }}</td>
                            <td class="text-right">{{ $money($summary['cost']) }}</td>
                            <td class="text-right">{{ $money($summary['gross']) }}</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
                </div>
            </div>
        </div>

        <div class="wp-panel">
            <div class="wp-panel-h">Product-wise Profit</div>
            <div class="wp-panel-body" style="padding:0">
                @include('Admin.accounts._product_table', ['products' => $products])
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-4 space-y-5">
        <div class="wp-panel">
            <div class="wp-panel-h">
                <span>Expenses</span>
                @if (Auth::guard('admin')->user()->hasPermission('expenses.view'))
                    <a href="{{ route('admin.expenses.index', ['month' => substr($date, 0, 7)]) }}" class="text-[12px] font-normal text-[#2271b1]">+ Add / manage</a>
                @endif
            </div>
            <div class="wp-panel-body" style="padding:0">
                <table class="wp-list-table" style="border:0">
                    <tbody>
                        @forelse ($expenses as $e)
                            <tr>
                                <td>
                                    <strong>{{ $e->title }}</strong>
                                    <div class="text-[11.5px] text-[#646970]">{{ $e->category_label }}</div>
                                </td>
                                <td class="text-right">{{ $money($e->amount) }}</td>
                            </tr>
                        @empty
                            <tr><td class="text-center text-[#646970] py-6">No expenses entered for this day.</td></tr>
                        @endforelse
                    </tbody>
                    @if ($expenses->isNotEmpty())
                    <tfoot><tr><td>Total</td><td class="text-right">{{ $money($summary['expenses']) }}</td></tr></tfoot>
                    @endif
                </table>
            </div>
        </div>

        <div class="wp-panel">
            <div class="wp-panel-h">How it's calculated</div>
            <div class="wp-panel-body acc-note space-y-1">
                <p><strong>Sales</strong> = order totals (after discount, incl. delivery charged to the customer).</p>
                <p><strong>Product cost</strong> = quantity × purchase price at the time of sale.</p>
                <p><strong>Net profit</strong> = sales − product cost − expenses.</p>
                <p>Pending, cancelled and returned orders are not counted.</p>
            </div>
        </div>
    </div>
</div>

@endsection
