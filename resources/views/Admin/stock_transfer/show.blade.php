@extends('Admin.Layout.app')

@section('title', 'Transfer #' . $stockTransfer->reference_no)
@section('page_title', 'Transfer #' . $stockTransfer->reference_no)

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="mb-4 px-4 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">{{ session('error') }}</div>
@endif

<div class="flex items-center gap-3 mb-3">
    <h1 class="wp-h1">Stock Transfer <span class="font-mono text-[#50575e] text-[18px]">{{ $stockTransfer->reference_no }}</span></h1>
    <a href="{{ route('admin.stock-transfers.index') }}" class="wp-add-new">← Back</a>
</div>

<div class="grid grid-cols-12 gap-5 mt-3">
    <div class="col-span-12 lg:col-span-8 space-y-5">
        <div class="wp-panel">
            <div class="wp-panel-h">Transfer Details</div>
            <div class="wp-panel-body">
                <div class="wc-info-grid">
                    <span class="lbl">Reference</span>
                    <span class="val font-mono">{{ $stockTransfer->reference_no }}</span>
                    <span class="lbl">From Warehouse</span>
                    <span class="val">{{ $stockTransfer->fromWarehouse->name }}</span>
                    <span class="lbl">To Warehouse</span>
                    <span class="val">{{ $stockTransfer->toWarehouse->name }}</span>
                    <span class="lbl">Date</span>
                    <span class="val">{{ $stockTransfer->transfer_date->format('d M, Y') }}</span>
                    <span class="lbl">Created By</span>
                    <span class="val">{{ $stockTransfer->creator->name ?? '—' }}</span>
                    @if ($stockTransfer->notes)
                        <span class="lbl">Notes</span>
                        <span class="val font-normal text-[#50575e]">{{ $stockTransfer->notes }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="wp-panel">
            <div class="wp-panel-h">Transfer Items</div>
            <div class="wp-panel-body" style="padding: 0;">
                <table class="wp-list-table" style="border: 0; box-shadow: none;">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Product</th>
                            <th class="text-right" style="width: 140px;">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stockTransfer->items as $i => $item)
                            <tr>
                                <td class="text-[#787c82]">{{ $i + 1 }}</td>
                                <td><strong>{{ $item->product->name }}</strong></td>
                                <td class="text-right"><strong>{{ rtrim(rtrim(number_format((float) $item->quantity, 2, '.', ''), '0'), '.') }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" class="text-right">Total</th>
                            <th class="text-right">{{ rtrim(rtrim(number_format((float) $stockTransfer->items->sum('quantity'), 2, '.', ''), '0'), '.') }}</th>
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
                @php
                    $s = $stockTransfer->status;
                    $style = $s === 'completed' ? 'background:#edf7ed;color:#2e7d32;' : ($s === 'cancelled' ? 'background:#f0f0f1;color:#50575e;' : 'background:#fff4e5;color:#d97706;');
                @endphp
                <div class="text-[13px] text-[#50575e]">Current:
                    <span class="wp-status-pill" style="cursor:default;{{ $style }}">{{ ucfirst($s) }}</span>
                </div>

                @if ($s === 'pending')
                    <div class="flex items-center gap-2">
                        <form method="POST" action="{{ route('admin.stock-transfers.status', $stockTransfer) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="wp-btn wp-btn-primary">Complete</button>
                        </form>
                        <form method="POST" action="{{ route('admin.stock-transfers.status', $stockTransfer) }}">
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
                    <span class="val">{{ $stockTransfer->items->count() }}</span>
                </div>
                <div class="wc-summary-total">
                    <span class="lbl">Total Quantity</span>
                    <span class="val">{{ rtrim(rtrim(number_format((float) $stockTransfer->items->sum('quantity'), 2, '.', ''), '0'), '.') }}</span>
                </div>
            </div>
        </div>

        @if ($stockTransfer->status === 'pending')
            <div class="wp-panel">
                <div class="wp-panel-h">Actions</div>
                <div class="wp-panel-body">
                    <form method="POST" action="{{ route('admin.stock-transfers.destroy', $stockTransfer) }}" onsubmit="return confirm('Delete this transfer?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="wp-btn-link text-[#b32d2e]"><i class="fas fa-trash mr-1"></i> Delete Transfer</button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
