@extends('Admin.Layout.app')

@section('title', 'Create GRN Return')
@section('page_title', 'Create GRN Return')

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

@if ($errors->any())
    <div class="mb-4 px-3 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">
        <ul class="list-disc list-inside">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<h1 class="wp-h1">Create GRN Return</h1>

<form method="POST" action="{{ route('admin.grn-returns.store') }}">
    @csrf

    <div class="grid grid-cols-12 gap-5 mt-3">
        <div class="col-span-12 lg:col-span-8 space-y-5">
            <div class="wp-panel">
                <div class="wp-panel-h">Return Details</div>
                <div class="wp-panel-body">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="wp-field">
                            <label for="grnSelect">Goods Received Note <span class="text-[#d63638]">*</span></label>
                            <select name="goods_received_note_id" id="grnSelect" required class="wp-input" onchange="loadGrnItems()">
                                <option value="">— Select GRN —</option>
                                @foreach ($grns as $g)
                                    <option value="{{ $g->id }}"
                                        data-supplier="{{ $g->supplier->name }}"
                                        data-warehouse="{{ $g->warehouse->name }}">
                                        {{ $g->grn_no }} — {{ $g->supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="wp-field">
                            <label for="return_date">Return Date <span class="text-[#d63638]">*</span></label>
                            <input type="date" name="return_date" id="return_date" value="{{ old('return_date', now()->format('Y-m-d')) }}" class="wp-input" required>
                        </div>
                    </div>

                    <div class="wp-field">
                        <label for="reason">Reason</label>
                        <input type="text" name="reason" id="reason" value="{{ old('reason') }}" placeholder="e.g. Damaged, Wrong item, Over-delivery" class="wp-input">
                    </div>

                    <div class="wp-field">
                        <label for="notes">Notes</label>
                        <textarea name="notes" id="notes" rows="2" class="wp-input">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="wp-panel">
                <div class="wp-panel-h">Items to Return</div>
                <div class="wp-panel-body" style="padding: 0;">
                    <div id="noGrnMsg" class="wc-empty">Select a GRN to load received items.</div>
                    <div id="itemsSection" style="display:none">
                        <table class="wp-list-table" style="border: 0; box-shadow: none;">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th class="text-right" style="width: 110px;">Received</th>
                                    <th class="text-right" style="width: 130px;">Return Qty</th>
                                    <th class="text-right" style="width: 110px;">Unit Cost</th>
                                    <th class="text-right" style="width: 110px;">Total</th>
                                </tr>
                            </thead>
                            <tbody id="itemsContainer"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-4 space-y-5">
            <div class="wp-panel">
                <div class="wp-panel-h">Source</div>
                <div class="wp-panel-body">
                    <div class="wc-info-grid">
                        <span class="lbl">Supplier</span>
                        <span class="val" id="displaySupplier">—</span>
                        <span class="lbl">Warehouse</span>
                        <span class="val" id="displayWarehouse">—</span>
                    </div>
                </div>
            </div>

            <div class="wp-panel">
                <div class="wp-panel-h">Publish</div>
                <div class="wp-panel-body">
                    <p class="text-[12.5px] text-[#50575e] mb-3">Stock will be deducted for all returned quantities.</p>
                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.grn-returns.index') }}" class="wp-btn-link">Cancel</a>
                        <button type="submit" class="wp-btn wp-btn-primary">Create Return</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
@include('Admin._partials.wp-scripts')
<script>
    function loadGrnItems() {
        let id = $('#grnSelect').val();
        if (!id) {
            $('#noGrnMsg').show();
            $('#itemsSection').hide();
            $('#displaySupplier').text('—');
            $('#displayWarehouse').text('—');
            return;
        }

        let opt = $('#grnSelect option:selected');
        $('#displaySupplier').text(opt.data('supplier'));
        $('#displayWarehouse').text(opt.data('warehouse'));

        $.getJSON('/admin/grn-returns/grn/' + id + '/items', function (grn) {
            let html = '';
            $.each(grn.items, function (i, item) {
                html += '<tr>'
                    + '<td>'
                    +   '<input type="hidden" name="items[' + i + '][grn_item_id]" value="' + item.id + '">'
                    +   '<strong>' + item.product_name + '</strong>'
                    + '</td>'
                    + '<td class="text-right text-[#50575e]">' + parseFloat(item.received_qty).toFixed(2) + '</td>'
                    + '<td><input type="number" name="items[' + i + '][return_qty]" step="0.01" min="0" max="' + item.received_qty + '" value="0" class="wp-input text-right return-qty" oninput="calcReturnRow(this, ' + item.unit_cost + ')"></td>'
                    + '<td class="text-right text-[#50575e]">' + parseFloat(item.unit_cost).toFixed(2) + '</td>'
                    + '<td class="text-right"><strong class="row-total">0.00</strong></td>'
                    + '</tr>';
            });
            $('#itemsContainer').html(html);
            $('#noGrnMsg').hide();
            $('#itemsSection').show();
        });
    }

    function calcReturnRow(el, unitCost) {
        let row = $(el).closest('tr');
        let qty = parseFloat($(el).val()) || 0;
        row.find('.row-total').text((qty * unitCost).toFixed(2));
    }
</script>
@endpush
