@extends('Admin.Layout.app')

@section('title', 'Add New GRN')
@section('page_title', 'Add New GRN')

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

@if ($errors->any())
    <div class="mb-4 px-3 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">
        <ul class="list-disc list-inside">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<h1 class="wp-h1">Add New Goods Received Note</h1>

<form method="POST" action="{{ route('admin.grn.store') }}">
    @csrf

    <div class="grid grid-cols-12 gap-5 mt-3">
        <div class="col-span-12 lg:col-span-8 space-y-5">
            <div class="wp-panel">
                <div class="wp-panel-h">GRN Details</div>
                <div class="wp-panel-body">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="wp-field">
                            <label for="purchaseSelect">Purchase Order <span class="text-[#d63638]">*</span></label>
                            <select name="purchase_id" id="purchaseSelect" required class="wp-input" onchange="loadPurchaseItems()">
                                <option value="">— Select purchase order —</option>
                                @foreach ($purchases as $p)
                                    <option value="{{ $p->id }}" data-supplier="{{ $p->supplier->name }}" data-warehouse="{{ $p->warehouse->name }}">{{ $p->invoice_no }} — {{ $p->supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="wp-field">
                            <label for="received_date">Received Date</label>
                            <input type="date" name="received_date" id="received_date" value="{{ old('received_date', now()->format('Y-m-d')) }}" class="wp-input">
                        </div>
                    </div>

                    <div class="wp-field">
                        <label for="notes">Notes</label>
                        <textarea name="notes" id="notes" rows="2" class="wp-input">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="wp-panel">
                <div class="wp-panel-h">Items</div>
                <div class="wp-panel-body" style="padding: 0;">
                    <div id="noPurchaseMsg" class="wc-empty">Select a purchase order to load items.</div>
                    <div id="itemsSection" style="display:none">
                        <table class="wp-list-table" style="border: 0; box-shadow: none;">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th class="text-right" style="width: 110px;">Ordered</th>
                                    <th class="text-right" style="width: 130px;">Received</th>
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
                    <p class="text-[12.5px] text-[#50575e] mb-3">Once received, stock will be added to the warehouse.</p>
                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.grn.index') }}" class="wp-btn-link">Cancel</a>
                        <button type="submit" class="wp-btn wp-btn-primary">Create GRN</button>
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
    function loadPurchaseItems() {
        let id = $('#purchaseSelect').val();
        if (!id) {
            $('#noPurchaseMsg').show();
            $('#itemsSection').hide();
            $('#displaySupplier').text('—');
            $('#displayWarehouse').text('—');
            return;
        }

        let opt = $('#purchaseSelect option:selected');
        $('#displaySupplier').text(opt.data('supplier'));
        $('#displayWarehouse').text(opt.data('warehouse'));

        $.getJSON('/admin/grn/purchase/' + id + '/items', function (purchase) {
            let html = '';
            $.each(purchase.items, function (i, item) {
                let received = item.quantity;
                html += '<tr>'
                    + '<td>'
                    +   '<input type="hidden" name="items[' + i + '][purchase_item_id]" value="' + item.id + '">'
                    +   '<input type="hidden" name="items[' + i + '][product_name]" value="' + item.product_name + '">'
                    +   '<input type="hidden" name="items[' + i + '][ordered_qty]" value="' + item.quantity + '">'
                    +   '<input type="hidden" name="items[' + i + '][unit_cost]" value="' + item.unit_cost + '">'
                    +   '<strong>' + item.product_name + '</strong>'
                    + '</td>'
                    + '<td class="text-right text-[#50575e]">' + item.quantity + '</td>'
                    + '<td><input type="number" name="items[' + i + '][received_qty]" step="0.01" min="0" max="' + item.quantity + '" value="' + received + '" class="wp-input text-right received-qty" oninput="calcGrnRow(this)"></td>'
                    + '<td class="text-right text-[#50575e] unit-cost-cell">' + parseFloat(item.unit_cost).toFixed(2) + '</td>'
                    + '<td class="text-right"><strong class="row-total">' + (received * item.unit_cost).toFixed(2) + '</strong></td>'
                    + '</tr>';
            });
            $('#itemsContainer').html(html);
            $('#noPurchaseMsg').hide();
            $('#itemsSection').show();
        });
    }

    function calcGrnRow(el) {
        let row = $(el).closest('tr');
        let qty = parseFloat($(el).val()) || 0;
        let cost = parseFloat(row.find('.unit-cost-cell').text()) || 0;
        row.find('.row-total').text((qty * cost).toFixed(2));
    }
</script>
@endpush
