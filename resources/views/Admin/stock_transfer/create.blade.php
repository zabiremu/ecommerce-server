@extends('Admin.Layout.app')

@section('title', 'Add New Stock Transfer')
@section('page_title', 'Add New Stock Transfer')

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

@if ($errors->any())
    <div class="mb-4 px-3 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">
        <ul class="list-disc list-inside">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<h1 class="wp-h1">Add New Stock Transfer</h1>

<form method="POST" action="{{ route('admin.stock-transfers.store') }}">
    @csrf

    <div class="grid grid-cols-12 gap-5 mt-3">
        <div class="col-span-12 lg:col-span-8 space-y-5">
            <div class="wp-panel">
                <div class="wp-panel-h">Transfer Details</div>
                <div class="wp-panel-body">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="wp-field">
                            <label for="from_warehouse_id">From Warehouse <span class="text-[#d63638]">*</span></label>
                            <select name="from_warehouse_id" id="from_warehouse_id" required class="wp-input">
                                <option value="">— Select warehouse —</option>
                                @foreach ($warehouses as $w)
                                    <option value="{{ $w->id }}" {{ old('from_warehouse_id') == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="wp-field">
                            <label for="to_warehouse_id">To Warehouse <span class="text-[#d63638]">*</span></label>
                            <select name="to_warehouse_id" id="to_warehouse_id" required class="wp-input">
                                <option value="">— Select warehouse —</option>
                                @foreach ($warehouses as $w)
                                    <option value="{{ $w->id }}" {{ old('to_warehouse_id') == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="wp-field">
                        <label for="transfer_date">Transfer Date <span class="text-[#d63638]">*</span></label>
                        <input type="date" name="transfer_date" id="transfer_date" value="{{ old('transfer_date', now()->format('Y-m-d')) }}" required class="wp-input" style="max-width: 240px;">
                    </div>

                    <div class="wp-field">
                        <label for="notes">Notes</label>
                        <textarea name="notes" id="notes" rows="2" class="wp-input">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="wp-panel">
                <div class="wp-panel-h">
                    Transfer Items
                    <button type="button" onclick="addItem()" class="wp-btn wp-btn-primary"><i class="fas fa-plus mr-1"></i> Add Item</button>
                </div>
                <div class="wp-panel-body" style="padding: 0;">
                    <table class="wp-list-table" style="border: 0; box-shadow: none;">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th class="text-right" style="width: 140px;">Quantity</th>
                                <th style="width: 180px;">Available Stock</th>
                                <th style="width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody id="itemsContainer"></tbody>
                    </table>
                    <p id="noItemsMsg" class="wc-empty">No items added yet.</p>
                </div>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-4 space-y-5">
            <div class="wp-panel">
                <div class="wp-panel-h">Publish</div>
                <div class="wp-panel-body">
                    <p class="text-[12.5px] text-[#50575e] mb-3">Stock will be moved from "From" to "To" warehouse on creation.</p>
                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.stock-transfers.index') }}" class="wp-btn-link">Cancel</a>
                        <button type="submit" class="wp-btn wp-btn-primary">Create Transfer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<table class="hidden">
    <tbody id="itemTemplate">
        <tr class="item-row">
            <td>
                <select name="items[__INDEX__][product_id]" required class="wp-input product-select">
                    <option value="">— Select product —</option>
                    @foreach ($products as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" name="items[__INDEX__][quantity]" step="0.01" min="0.01" value="1" required class="wp-input text-right qty-input">
            </td>
            <td>
                <span class="stock-display text-[13px] text-[#50575e]">—</span>
            </td>
            <td class="text-center">
                <button type="button" onclick="removeItem(this)" class="wp-btn-link text-[#d63638]" title="Remove">
                    <i class="fas fa-xmark"></i>
                </button>
            </td>
        </tr>
    </tbody>
</table>

@endsection

@push('scripts')
@include('Admin._partials.wp-scripts')
<script>
    let itemIndex = 0;
    let selectedProducts = new Set();

    function addItem() {
        let html = $('#itemTemplate').html().replace(/__INDEX__/g, itemIndex);
        let $row = $(html);
        $('#itemsContainer').append($row);
        $('#noItemsMsg').hide();
        itemIndex++;
        attachProductHandler($row);
    }

    function removeItem(btn) {
        let $row = $(btn).closest('.item-row');
        let prodId = $row.find('.product-select').val();
        if (prodId) selectedProducts.delete(prodId);
        $row.remove();
        if ($('#itemsContainer .item-row').length === 0) $('#noItemsMsg').show();
    }

    function attachProductHandler($row) {
        $row.find('.product-select').on('change', function () {
            let $row = $(this).closest('.item-row');
            let prevVal = $row.data('prevProduct');
            if (prevVal) selectedProducts.delete(prevVal);
            let val = $(this).val();
            if (val) {
                if (selectedProducts.has(val)) {
                    alert('This product is already added.');
                    $(this).val('');
                    return;
                }
                selectedProducts.add(val);
            }
            $row.data('prevProduct', val);
            fetchStock($row);
        });
    }

    function fetchStock($row) {
        let productId = $row.find('.product-select').val();
        let warehouseId = $('#from_warehouse_id').val();
        let $stock = $row.find('.stock-display');
        if (!productId || !warehouseId) { $stock.text('—'); return; }
        $stock.text('Loading…');
        let url = '{{ url('admin/stock-transfers/product-stock') }}/' + productId + '/' + warehouseId;
        $.get(url, function (res) {
            $stock.text(parseFloat(res.stock).toFixed(2));
        }).fail(function () { $stock.text('Error'); });
    }

    $(function () {
        $('#from_warehouse_id').on('change', function () {
            $('#itemsContainer .item-row').each(function () { fetchStock($(this)); });
        });
        addItem();
    });
</script>
@endpush
