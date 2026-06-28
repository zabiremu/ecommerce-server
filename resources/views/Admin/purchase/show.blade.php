@extends('Admin.Layout.app')

@section('title', 'Purchase #' . $purchase->invoice_no)
@section('page_title', 'Purchase #' . $purchase->invoice_no)

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif

<div class="flex items-center gap-3 mb-3">
    <h1 class="wp-h1">Purchase <span class="font-mono text-[#50575e] text-[18px]">{{ $purchase->invoice_no }}</span></h1>
    <a href="{{ route('admin.purchases.index') }}" class="wp-add-new">← Back</a>
</div>

<div class="grid grid-cols-12 gap-5 mt-3">
    <div class="col-span-12 lg:col-span-8 space-y-5">
        <div class="wp-panel">
            <div class="wp-panel-h">Purchase Details</div>
            <div class="wp-panel-body">
                <div class="wc-info-grid">
                    <span class="lbl">Invoice</span>
                    <span class="val font-mono">{{ $purchase->invoice_no }}</span>
                    <span class="lbl">Supplier</span>
                    <span class="val">{{ $purchase->supplier->name }}</span>
                    <span class="lbl">Warehouse</span>
                    <span class="val">{{ $purchase->warehouse->name }}</span>
                    <span class="lbl">Date</span>
                    <span class="val">{{ $purchase->purchase_date->format('d M, Y') }}</span>
                    @if ($purchase->notes)
                        <span class="lbl">Notes</span>
                        <span class="val font-normal text-[#50575e]">{{ $purchase->notes }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="wp-panel">
            <div class="wp-panel-h">Items</div>
            <div class="wp-panel-body" style="padding: 0;">
                <table class="wp-list-table" style="border: 0; box-shadow: none;">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Product</th>
                            <th class="text-right" style="width: 120px;">Quantity</th>
                            <th class="text-right" style="width: 120px;">Unit Cost</th>
                            <th class="text-right" style="width: 120px;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchase->items as $i => $item)
                            <tr>
                                <td class="text-[#787c82]">{{ $i + 1 }}</td>
                                <td><strong>{{ $item->product_name }}</strong></td>
                                <td class="text-right text-[#50575e]">{{ $item->quantity }}</td>
                                <td class="text-right text-[#50575e]">{{ number_format($item->unit_cost, 2) }}</td>
                                <td class="text-right"><strong>{{ number_format($item->total, 2) }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-right">Total</th>
                            <th class="text-right">{{ number_format($purchase->total_amount, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-4 space-y-5">
        <div class="wp-panel">
            <div class="wp-panel-h">Status</div>
            <div class="wp-panel-body space-y-3">
                <div class="text-[13px] text-[#50575e]">Current:
                    @php
                        $s = $purchase->status;
                        $style = $s === 'completed' ? 'background:#edf7ed;color:#2e7d32;' : ($s === 'cancelled' ? 'background:#fdecea;color:#b32d2e;' : 'background:#fff4e5;color:#d97706;');
                    @endphp
                    <span class="wp-status-pill" style="cursor:default;{{ $style }}">{{ ucfirst($s) }}</span>
                </div>

                @if ($purchase->status === 'pending')
                    <div class="flex items-center gap-2">
                        <form method="POST" action="{{ route('admin.purchases.status', $purchase) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="wp-btn wp-btn-primary">Mark Completed</button>
                        </form>
                        <form method="POST" action="{{ route('admin.purchases.status', $purchase) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="wp-btn" style="border-color:#d63638;color:#d63638;">Cancel</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <div class="wp-panel">
            <div class="wp-panel-h">Summary</div>
            <div class="wp-panel-body">
                <div class="wc-summary-row">
                    <span class="lbl">Items</span>
                    <span class="val">{{ $purchase->items->count() }}</span>
                </div>
                <div class="wc-summary-row">
                    <span class="lbl">Total Quantity</span>
                    <span class="val">{{ rtrim(rtrim(number_format((float) $purchase->items->sum('quantity'), 2, '.', ''), '0'), '.') }}</span>
                </div>
                <div class="wc-summary-total">
                    <span class="lbl">Total Amount</span>
                    <span class="val">{{ number_format($purchase->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="wp-panel">
            <div class="wp-panel-h">Actions</div>
            <div class="wp-panel-body">
                <form method="POST" action="{{ route('admin.purchases.destroy', $purchase) }}" onsubmit="return confirm('Delete this purchase?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="wp-btn-link text-[#b32d2e]"><i class="fas fa-trash mr-1"></i> Move to Trash</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
