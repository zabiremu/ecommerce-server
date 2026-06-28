@extends('Admin.Layout.app')

@section('title', 'Add New Purchase')
@section('page_title', 'Add New Purchase')

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

@if ($errors->any())
    <div class="mb-4 px-3 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">
        <ul class="list-disc list-inside">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<h1 class="wp-h1">Add New Purchase</h1>

<form method="POST" action="{{ route('admin.purchases.store') }}">
    @csrf

    <div class="grid grid-cols-12 gap-5 mt-3">
        <div class="col-span-12 lg:col-span-8 space-y-5">
            <div class="wp-panel">
                <div class="wp-panel-h">Purchase Details</div>
                <div class="wp-panel-body">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="wp-field">
                            <label for="supplier_id">Supplier <span class="text-[#d63638]">*</span></label>
                            <select name="supplier_id" id="supplier_id" class="wp-input" required>
                                <option value="">— Select supplier —</option>
                                @foreach ($suppliers as $s)
                                    <option value="{{ $s->id }}" {{ old('supplier_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="wp-field">
                            <label for="warehouse_id">Warehouse <span class="text-[#d63638]">*</span></label>
                            <select name="warehouse_id" id="warehouse_id" class="wp-input" required>
                                <option value="">— Select warehouse —</option>
                                @foreach ($warehouses as $w)
                                    <option value="{{ $w->id }}" {{ old('warehouse_id') == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="wp-field">
                        <label for="purchase_date">Purchase Date</label>
                        <input type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date', now()->format('Y-m-d')) }}" class="wp-input" style="max-width: 240px;">
                    </div>

                    <div class="wp-field">
                        <label for="notes">Notes</label>
                        <textarea name="notes" id="notes" rows="2" class="wp-input" placeholder="Optional notes">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="wp-panel">
                <div class="wp-panel-h">
                    Purchase Items
                    <button type="button" onclick="addItem()" class="wp-btn wp-btn-primary"><i class="fas fa-plus mr-1"></i> Add Item</button>
                </div>
                <div class="wp-panel-body" style="padding: 0;">
                    <table class="wp-list-table" style="border: 0; box-shadow: none;">
                        <thead>
                            <tr>
                                <th style="width: 45%;">Product</th>
                                <th class="text-right" style="width: 15%;">Quantity</th>
                                <th class="text-right" style="width: 17%;">Unit Cost</th>
                                <th class="text-right" style="width: 17%;">Total</th>
                                <th style="width: 6%;"></th>
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
                <div class="wp-panel-h">Summary</div>
                <div class="wp-panel-body">
                    <div class="wc-summary-row">
                        <span class="lbl">Items</span>
                        <span class="val" id="summaryItems">0</span>
                    </div>
                    <div class="wc-summary-row">
                        <span class="lbl">Total Quantity</span>
                        <span class="val" id="summaryQty">0</span>
                    </div>
                    <div class="wc-summary-total">
                        <span class="lbl">Total Amount</span>
                        <span class="val" id="summaryTotal">0.00</span>
                    </div>
                </div>
            </div>

            <div class="wp-panel">
                <div class="wp-panel-h">Publish</div>
                <div class="wp-panel-body">
                    <p class="text-[12.5px] text-[#50575e] mb-3">After creation, the purchase will be marked as pending. You can complete or cancel it from its details page.</p>
                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.purchases.index') }}" class="wp-btn-link">Cancel</a>
                        <button type="submit" class="wp-btn wp-btn-primary">Create Purchase</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
@include('Admin._partials.wp-scripts')
@php
    $productOptionsData = $products->map(fn($p) => [
        'id' => $p->id,
        'name' => $p->name,
        'sku' => $p->sku,
        'purchase_price' => (float) $p->purchase_price,
        'stock' => (float) $p->stock,
    ])->values();
@endphp
<script>
    const productOptions = {!! json_encode($productOptionsData) !!};

    let itemIndex = 0;

    function productOptionsHtml(selectedId) {
        let opts = '<option value="">— Select product —</option>';
        productOptions.forEach(function (p) {
            const sel = String(p.id) === String(selectedId) ? ' selected' : '';
            opts += `<option value="${p.id}" data-cost="${p.purchase_price}" data-stock="${p.stock}">${p.name} — ${p.sku} (Stock: ${p.stock})</option>`;
        });
        return opts;
    }

    function addItem(data) {
        data = data || {};
        let html = `
            <tr class="item-row">
                <td>
                    <select name="items[${itemIndex}][product_id]" required class="wp-input product-select" onchange="onProductChange(this)">
                        ${productOptionsHtml(data.product_id)}
                    </select>
                </td>
                <td>
                    <input type="number" name="items[${itemIndex}][quantity]" step="0.01" min="0.01" value="${data.quantity || 1}" required
                           class="wp-input text-right qty-input" oninput="calcRow(this)">
                </td>
                <td>
                    <input type="number" name="items[${itemIndex}][unit_cost]" step="0.01" min="0" value="${data.unit_cost || 0}" required
                           class="wp-input text-right cost-input" oninput="calcRow(this)">
                </td>
                <td class="text-right"><strong class="row-total">0.00</strong></td>
                <td class="text-center">
                    <button type="button" onclick="removeItem(this)" class="wp-btn-link text-[#d63638]" title="Remove">
                        <i class="fas fa-xmark"></i>
                    </button>
                </td>
            </tr>`;
        $('#itemsContainer').append(html);
        $('#noItemsMsg').hide();
        itemIndex++;
        updateSummary();
    }

    function onProductChange(el) {
        const $opt = $(el).find('option:selected');
        const cost = parseFloat($opt.data('cost')) || 0;
        const $row = $(el).closest('.item-row');
        if (cost > 0) {
            $row.find('.cost-input').val(cost.toFixed(2));
        }
        calcRow($row.find('.cost-input')[0]);
    }

    function removeItem(btn) {
        $(btn).closest('.item-row').remove();
        if ($('#itemsContainer .item-row').length === 0) $('#noItemsMsg').show();
        updateSummary();
    }

    function calcRow(el) {
        let row = $(el).closest('.item-row');
        let qty = parseFloat(row.find('.qty-input').val()) || 0;
        let cost = parseFloat(row.find('.cost-input').val()) || 0;
        row.find('.row-total').text((qty * cost).toFixed(2));
        updateSummary();
    }

    function updateSummary() {
        let count = 0, totalQty = 0, totalAmt = 0;
        $('#itemsContainer .item-row').each(function () {
            count++;
            totalQty += parseFloat($(this).find('.qty-input').val()) || 0;
            totalAmt += parseFloat($(this).find('.row-total').text()) || 0;
        });
        $('#summaryItems').text(count);
        $('#summaryQty').text(totalQty.toFixed(2));
        $('#summaryTotal').text(totalAmt.toFixed(2));
    }

    $(function () { addItem(); });
</script>
@endpush
