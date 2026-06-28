@extends('Admin.Layout.app')

@section('title', 'GRN Return #' . $grnReturn->return_no)
@section('page_title', 'GRN Return #' . $grnReturn->return_no)

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif

<div class="flex items-center gap-3 mb-3">
    <h1 class="wp-h1">Return <span class="font-mono text-[#50575e] text-[18px]">{{ $grnReturn->return_no }}</span></h1>
    <a href="{{ route('admin.grn-returns.index') }}" class="wp-add-new">← Back</a>
</div>

<div class="grid grid-cols-12 gap-5 mt-3">
    <div class="col-span-12 lg:col-span-8 space-y-5">
        <div class="wp-panel">
            <div class="wp-panel-h">Return Details</div>
            <div class="wp-panel-body">
                <div class="wc-info-grid">
                    <span class="lbl">Return No</span>
                    <span class="val font-mono">{{ $grnReturn->return_no }}</span>
                    <span class="lbl">Original GRN</span>
                    <span class="val">
                        <a href="{{ route('admin.grn.show', $grnReturn->goodsReceivedNote) }}" class="text-[#2271b1] hover:text-[#135e96] font-mono">{{ $grnReturn->goodsReceivedNote->grn_no }}</a>
                    </span>
                    <span class="lbl">Supplier</span>
                    <span class="val">{{ $grnReturn->supplier->name }}</span>
                    <span class="lbl">Warehouse</span>
                    <span class="val">{{ $grnReturn->warehouse->name }}</span>
                    <span class="lbl">Return Date</span>
                    <span class="val">{{ $grnReturn->return_date->format('d M, Y') }}</span>
                    @if ($grnReturn->reason)
                        <span class="lbl">Reason</span>
                        <span class="val text-[#50575e]">{{ $grnReturn->reason }}</span>
                    @endif
                    @if ($grnReturn->notes)
                        <span class="lbl">Notes</span>
                        <span class="val font-normal text-[#50575e]">{{ $grnReturn->notes }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="wp-panel">
            <div class="wp-panel-h">Returned Items</div>
            <div class="wp-panel-body" style="padding: 0;">
                <table class="wp-list-table" style="border: 0; box-shadow: none;">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Product</th>
                            <th class="text-right" style="width: 110px;">Received</th>
                            <th class="text-right" style="width: 110px;">Returned</th>
                            <th class="text-right" style="width: 110px;">Unit Cost</th>
                            <th class="text-right" style="width: 110px;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grnReturn->items as $i => $item)
                            <tr>
                                <td class="text-[#787c82]">{{ $i + 1 }}</td>
                                <td><strong>{{ $item->product_name }}</strong></td>
                                <td class="text-right text-[#50575e]">{{ $item->received_qty }}</td>
                                <td class="text-right"><strong class="text-[#b32d2e]">{{ $item->return_qty }}</strong></td>
                                <td class="text-right text-[#50575e]">{{ number_format($item->unit_cost, 2) }}</td>
                                <td class="text-right"><strong>{{ number_format($item->total, 2) }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-right">Total</th>
                            <th class="text-right">{{ number_format($grnReturn->items->sum('total'), 2) }}</th>
                        </tr>
                    </tfoot>
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
                    <span class="val">{{ $grnReturn->items->count() }}</span>
                </div>
                <div class="wc-summary-row">
                    <span class="lbl">Total Returned</span>
                    <span class="val">{{ rtrim(rtrim(number_format((float) $grnReturn->items->sum('return_qty'), 2, '.', ''), '0'), '.') }}</span>
                </div>
                <div class="wc-summary-total">
                    <span class="lbl">Total Amount</span>
                    <span class="val">{{ number_format($grnReturn->items->sum('total'), 2) }}</span>
                </div>
            </div>
        </div>

        <div class="wp-panel">
            <div class="wp-panel-h">Actions</div>
            <div class="wp-panel-body">
                <form method="POST" action="{{ route('admin.grn-returns.destroy', $grnReturn) }}" onsubmit="return confirm('Delete this return? Stock will be restored.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="wp-btn-link text-[#b32d2e]"><i class="fas fa-trash mr-1"></i> Delete Return</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
