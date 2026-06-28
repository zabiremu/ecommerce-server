@extends('Admin.Layout.app')

@section('title', 'Adjustment #' . $stockAdjustment->reference_no)
@section('page_title', 'Adjustment #' . $stockAdjustment->reference_no)

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif

<div class="flex items-center gap-3 mb-3">
    <h1 class="wp-h1">Stock Adjustment <span class="font-mono text-[#50575e] text-[18px]">{{ $stockAdjustment->reference_no }}</span></h1>
    <a href="{{ route('admin.stock-adjustments.index') }}" class="wp-add-new">← Back</a>
</div>

<div class="grid grid-cols-12 gap-5 mt-3">
    <div class="col-span-12 lg:col-span-8 space-y-5">
        <div class="wp-panel">
            <div class="wp-panel-h">Adjustment Details</div>
            <div class="wp-panel-body">
                <div class="wc-info-grid">
                    <span class="lbl">Reference</span>
                    <span class="val font-mono">{{ $stockAdjustment->reference_no }}</span>
                    <span class="lbl">Warehouse</span>
                    <span class="val">{{ $stockAdjustment->warehouse->name }}</span>
                    <span class="lbl">Date</span>
                    <span class="val">{{ $stockAdjustment->adjustment_date->format('d M, Y') }}</span>
                    <span class="lbl">Type</span>
                    <span class="val">
                        @php
                            $typeStyle = match($stockAdjustment->type) {
                                'write_off' => 'background:#fdecea;color:#b32d2e;',
                                'damage' => 'background:#fff4e5;color:#d97706;',
                                'correction' => 'background:#e6f0fb;color:#2271b1;',
                                default => 'background:#f0f0f1;color:#50575e;',
                            };
                        @endphp
                        <span class="wp-status-pill" style="cursor:default;{{ $typeStyle }}">{{ str_replace('_', ' ', ucfirst($stockAdjustment->type)) }}</span>
                    </span>
                    <span class="lbl">Created By</span>
                    <span class="val">{{ $stockAdjustment->creator?->name ?? 'System' }}</span>
                    @if ($stockAdjustment->notes)
                        <span class="lbl">Notes</span>
                        <span class="val font-normal text-[#50575e]">{{ $stockAdjustment->notes }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="wp-panel">
            <div class="wp-panel-h">Adjustment Items</div>
            <div class="wp-panel-body" style="padding: 0;">
                <table class="wp-list-table" style="border: 0; box-shadow: none;">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Product</th>
                            <th class="text-right" style="width: 120px;">Current</th>
                            <th class="text-right" style="width: 130px;">Change</th>
                            <th class="text-right" style="width: 130px;">Adjusted</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stockAdjustment->items as $i => $item)
                            <tr>
                                <td class="text-[#787c82]">{{ $i + 1 }}</td>
                                <td><strong>{{ $item->product->name }}</strong></td>
                                <td class="text-right text-[#50575e]">{{ rtrim(rtrim(number_format((float) $item->current_stock, 2, '.', ''), '0'), '.') }}</td>
                                <td class="text-right">
                                    <strong class="{{ $item->quantity < 0 ? 'text-[#d63638]' : 'text-[#2e7d32]' }}">
                                        {{ $item->quantity < 0 ? '−' : '+' }}{{ rtrim(rtrim(number_format(abs((float) $item->quantity), 2, '.', ''), '0'), '.') }}
                                    </strong>
                                </td>
                                <td class="text-right"><strong>{{ rtrim(rtrim(number_format((float) $item->adjusted_stock, 2, '.', ''), '0'), '.') }}</strong></td>
                                <td class="text-[#50575e]">{{ $item->reason ?: '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-4 space-y-5">
        <div class="wp-panel">
            <div class="wp-panel-h">Summary</div>
            <div class="wp-panel-body">
                <div class="wc-summary-row">
                    <span class="lbl">Items</span>
                    <span class="val">{{ $stockAdjustment->items->count() }}</span>
                </div>
                <div class="wc-summary-total">
                    <span class="lbl">Total Quantity</span>
                    <span class="val">{{ rtrim(rtrim(number_format((float) $stockAdjustment->items->sum('quantity'), 2, '.', ''), '0'), '.') }}</span>
                </div>
            </div>
        </div>

        <div class="wp-panel">
            <div class="wp-panel-h">Actions</div>
            <div class="wp-panel-body">
                <form method="POST" action="{{ route('admin.stock-adjustments.destroy', $stockAdjustment) }}" onsubmit="return confirm('Delete this adjustment? Stock will be reverted.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="wp-btn-link text-[#b32d2e]"><i class="fas fa-trash mr-1"></i> Delete Adjustment</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
