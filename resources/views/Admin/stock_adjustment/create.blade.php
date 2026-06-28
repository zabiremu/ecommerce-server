@extends('Admin.Layout.app')

@section('title', 'Add New Stock Adjustment')
@section('page_title', 'Add New Stock Adjustment')

@push('styles')
@include('Admin._partials.wp-styles')
<style>
    .wp-radio-card { display: flex; align-items: center; gap: 8px; padding: 8px 12px; border: 1px solid #c3c4c7; border-radius: 4px; background: #fff; cursor: pointer; transition: all .15s; font-size: 13px; color: #1d2327; }
    .wp-radio-card:hover { border-color: #2271b1; }
    .wp-radio-card:has(:checked) { border-color: #2271b1; background: #e6f0fb; color: #2271b1; font-weight: 600; }
</style>
@endpush

@section('content')

@if ($errors->any())
    <div class="mb-4 px-3 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">
        <ul class="list-disc list-inside">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<h1 class="wp-h1">Add New Stock Adjustment</h1>

<form method="POST" action="{{ route('admin.stock-adjustments.store') }}">
    @csrf

    <div class="grid grid-cols-12 gap-5 mt-3">
        <div class="col-span-12 lg:col-span-8 space-y-5">
            <div class="wp-panel">
                <div class="wp-panel-h">Adjustment Details</div>
                <div class="wp-panel-body">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="wp-field">
                            <label for="warehouse_id">Warehouse <span class="text-[#d63638]">*</span></label>
                            <select name="warehouse_id" id="warehouse_id" required class="wp-input">
                                <option value="">— Select warehouse —</option>
                                @foreach ($warehouses as $w)
                                    <option value="{{ $w->id }}" {{ old('warehouse_id') == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="wp-field">
                            <label for="adjustment_date">Adjustment Date <span class="text-[#d63638]">*</span></label>
                            <input type="date" name="adjustment_date" id="adjustment_date" value="{{ old('adjustment_date', now()->format('Y-m-d')) }}" required class="wp-input">
                        </div>
                    </div>

                    <div class="wp-field">
                        <label>Adjustment Type <span class="text-[#d63638]">*</span></label>
                        <div class="flex flex-wrap gap-2">
                            <label class="wp-radio-card">
                                <input type="radio" name="type" value="write_off" {{ old('type') === 'write_off' ? 'checked' : '' }} required>
                                <i class="fas fa-circle-minus text-[#d63638]"></i>
                                <span>Write Off</span>
                            </label>
                            <label class="wp-radio-card">
                                <input type="radio" name="type" value="damage" {{ old('type') === 'damage' ? 'checked' : '' }} required>
                                <i class="fas fa-triangle-exclamation text-[#d97706]"></i>
                                <span>Damage</span>
                            </label>
                            <label class="wp-radio-card">
                                <input type="radio" name="type" value="correction" {{ old('type') === 'correction' ? 'checked' : '' }} required>
                                <i class="fas fa-pen text-[#2271b1]"></i>
                                <span>Correction</span>
                            </label>
                        </div>
                    </div>

                    <div class="wp-field">
                        <label for="notes">Notes</label>
                        <textarea name="notes" id="notes" rows="2" class="wp-input">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="wp-panel">
                <div class="wp-panel-h">
                    Adjustment Items
                    <button type="button" onclick="addItem()" class="wp-btn wp-btn-primary"><i class="fas fa-plus mr-1"></i> Add Row</button>
                </div>
                <div class="wp-panel-body" style="padding: 0;">
                    <table class="wp-list-table" style="border: 0; box-shadow: none;">
                        <thead>
                            <tr>
                                <th style="width: 45%;">Product</th>
                                <th class="text-right" style="width: 15%;">Quantity</th>
                                <th style="width: 35%;">Reason</th>
                                <th style="width: 5%;"></th>
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
                    <div class="wc-summary-total">
                        <span class="lbl">Total Quantity</span>
                        <span class="val" id="summaryQty">0</span>
                    </div>
                </div>
            </div>

            <div class="wp-panel">
                <div class="wp-panel-h">Publish</div>
                <div class="wp-panel-body">
                    <p class="text-[12.5px] text-[#50575e] mb-3">Stock will be adjusted in the selected warehouse on creation.</p>
                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.stock-adjustments.index') }}" class="wp-btn-link">Cancel</a>
                        <button type="submit" class="wp-btn wp-btn-primary">Create Adjustment</button>
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
    let itemIndex = 0;
    const products = @json($products);

    function addItem(data) {
        data = data || {};
        let options = '<option value="">— Select product —</option>';
        products.forEach(function (p) {
            let sel = data.product_id == p.id ? 'selected' : '';
            options += '<option value="' + p.id + '" ' + sel + '>' + p.name + (p.sku ? ' (' + p.sku + ')' : '') + '</option>';
        });

        let html =
            '<tr class="item-row">'
            + '<td><select name="items[' + itemIndex + '][product_id]" required class="wp-input">' + options + '</select></td>'
            + '<td><input type="number" name="items[' + itemIndex + '][quantity]" step="0.01" min="0.01" value="' + (data.quantity || 1) + '" required class="wp-input text-right qty-input" oninput="updateSummary()"></td>'
            + '<td><input type="text" name="items[' + itemIndex + '][reason]" value="' + (data.reason || '') + '" class="wp-input" placeholder="Optional reason"></td>'
            + '<td class="text-center"><button type="button" onclick="removeItem(this)" class="wp-btn-link text-[#d63638]"><i class="fas fa-xmark"></i></button></td>'
            + '</tr>';
        $('#itemsContainer').append(html);
        $('#noItemsMsg').hide();
        itemIndex++;
        updateSummary();
    }

    function removeItem(btn) {
        $(btn).closest('.item-row').remove();
        if ($('#itemsContainer .item-row').length === 0) $('#noItemsMsg').show();
        updateSummary();
    }

    function updateSummary() {
        let count = 0, totalQty = 0;
        $('#itemsContainer .item-row').each(function () {
            count++;
            totalQty += parseFloat($(this).find('.qty-input').val()) || 0;
        });
        $('#summaryItems').text(count);
        $('#summaryQty').text(totalQty.toFixed(2));
    }

    $(function () { addItem(); });
</script>
@endpush
