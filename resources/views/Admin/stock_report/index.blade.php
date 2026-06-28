@extends('Admin.Layout.app')

@section('title', 'Stock Report')
@section('page_title', 'Stock Report')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@include('Admin._partials.wp-styles')
<style>
    .stock-filters { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; flex-wrap: wrap; }
    .stock-filters label { font-size: 13px; color: #1d2327; display: flex; align-items: center; gap: 6px; }
    .stock-filters select { border: 1px solid #8c8f94; border-radius: 4px; padding: 5px 28px 5px 10px; font-size: 13px; background: #fff; outline: none; min-width: 160px; appearance: none; background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2350575e' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e"); background-position: right 8px center; background-repeat: no-repeat; background-size: 16px; }
    .stock-filters select:focus { border-color: #2271b1; box-shadow: 0 0 0 1px #2271b1; }
    table.wp-list-table td.wh-col { text-align: center; font-weight: 600; }
    table.wp-list-table td.wh-col.wh-zero { color: #c3c4c7; font-weight: 400; }
    table.wp-list-table td.wh-col.wh-low { color: #d97706; }
</style>
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif

<h1 class="wp-h1">Stock Report</h1>
<p class="text-[13px] text-[#50575e] mt-1 mb-3">Current stock levels for all physical products, per warehouse.</p>

<div class="stock-filters">
    <label><i class="fas fa-tags text-[#787c82]"></i> Category:
        <select id="filterCategory">
            <option value="">All categories</option>
            @foreach (\App\Models\Category::where('status', 1)->orderBy('name')->get() as $cat)
                <option value="{{ $cat->name }}">{{ $cat->name }}</option>
            @endforeach
        </select>
    </label>
    <label><i class="fas fa-warehouse text-[#787c82]"></i> Warehouse:
        <select id="filterWarehouse">
            <option value="">All warehouses</option>
            @foreach ($warehouses as $w)
                <option value="{{ $w->id }}">{{ $w->name }}</option>
            @endforeach
        </select>
    </label>
</div>

<table id="stockTable" class="wp-list-table">
    <thead>
        <tr>
            <th>Product</th>
            <th style="width: 120px;">SKU</th>
            <th style="width: 140px;">Category</th>
            <th class="text-right" style="width: 110px;">Total Stock</th>
            @foreach ($warehouses as $w)
                <th class="text-center" data-wh="{{ $w->id }}">{{ $w->name }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $p)
            @php
                $total = (float) $p->stock;
                $alert = (float) ($p->alert_quantity ?? 0);
            @endphp
            <tr>
                <td><strong>{{ $p->name }}</strong></td>
                <td class="text-[#50575e] font-mono text-[12px]">{{ $p->sku }}</td>
                <td class="text-[#50575e] cat-col">{{ $p->category->name ?? '—' }}</td>
                <td class="text-right">
                    @if ($total <= 0)
                        <strong class="text-[#d63638]">{{ rtrim(rtrim(number_format($total, 2, '.', ''), '0'), '.') }}</strong>
                    @elseif ($alert > 0 && $total <= $alert)
                        <strong class="text-[#d97706]">{{ rtrim(rtrim(number_format($total, 2, '.', ''), '0'), '.') }}</strong>
                    @else
                        <strong>{{ rtrim(rtrim(number_format($total, 2, '.', ''), '0'), '.') }}</strong>
                    @endif
                </td>
                @foreach ($warehouses as $w)
                    @php
                        $whStock = (float) ($p->warehouses->where('id', $w->id)->first()?->pivot->stock ?? 0);
                        $whCls = $whStock == 0 ? 'wh-zero' : '';
                    @endphp
                    <td class="wh-col {{ $whCls }}" data-wh="{{ $w->id }}">{{ rtrim(rtrim(number_format($whStock, 2, '.', ''), '0'), '.') }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(function () {
        var table = $('#stockTable').DataTable({
            pageLength: 25,
            language: { search: "_INPUT_", searchPlaceholder: "Search products..." }
        });

        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            var catFilter = $('#filterCategory').val();
            var whFilter = $('#filterWarehouse').val();
            var row = table.row(dataIndex).node();

            if (catFilter && $(row).find('.cat-col').text().trim() !== catFilter) return false;
            if (whFilter) {
                var whVal = parseFloat($(row).find('td[data-wh="' + whFilter + '"]').text().trim());
                if (!whVal || whVal === 0) return false;
            }
            return true;
        });

        $('#filterCategory, #filterWarehouse').on('change', function () { table.draw(); });
    });
</script>
@endpush
