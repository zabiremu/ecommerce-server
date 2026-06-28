@extends('Admin.Layout.app')

@section('title', 'Goods Received Notes')
@section('page_title', 'Goods Received Notes')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@include('Admin._partials.wp-styles')
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif

<div class="flex items-center gap-3 mb-3">
    <h1 class="wp-h1">Goods Received Notes</h1>
    <a href="{{ route('admin.grn.create') }}" class="wp-add-new">Add New</a>
</div>

<table id="grnTable" class="wp-list-table">
    <thead>
        <tr>
            <th>GRN No</th>
            <th>Purchase</th>
            <th>Supplier</th>
            <th>Warehouse</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($grns as $g)
            <tr>
                <td>
                    <strong><a href="{{ route('admin.grn.show', $g) }}" class="text-[#2271b1] hover:text-[#135e96] font-mono text-[12.5px]">{{ $g->grn_no }}</a></strong>
                    <div class="wp-row-actions">
                        <span><a href="{{ route('admin.grn.show', $g) }}">View</a> |</span>
                        <span>
                            <form method="POST" action="{{ route('admin.grn.destroy', $g) }}" style="display:inline" onsubmit="return confirm('Delete this GRN?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="trash">Delete</button>
                            </form>
                        </span>
                    </div>
                </td>
                <td class="text-[#50575e] font-mono text-[12px]">{{ $g->purchase->invoice_no }}</td>
                <td class="text-[#50575e]">{{ $g->supplier->name }}</td>
                <td class="text-[#50575e]">{{ $g->warehouse->name }}</td>
                <td class="text-[#50575e]">{{ $g->received_date->format('d M, Y') }}</td>
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
        $('#grnTable').DataTable({
            pageLength: 25,
            order: [[0, 'desc']],
            language: { search: "_INPUT_", searchPlaceholder: "Search GRNs..." }
        });
    });
</script>
@endpush
