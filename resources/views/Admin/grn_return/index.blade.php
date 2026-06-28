@extends('Admin.Layout.app')

@section('title', 'GRN Returns')
@section('page_title', 'GRN Returns')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@include('Admin._partials.wp-styles')
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif

<div class="flex items-center gap-3 mb-3">
    <h1 class="wp-h1">GRN Returns</h1>
    <a href="{{ route('admin.grn-returns.create') }}" class="wp-add-new">Add New</a>
</div>

<table id="grnReturnTable" class="wp-list-table">
    <thead>
        <tr>
            <th>Return No</th>
            <th>GRN</th>
            <th>Supplier</th>
            <th>Warehouse</th>
            <th>Return Date</th>
            <th>Total Items</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($returns as $r)
            <tr>
                <td>
                    <strong><a href="{{ route('admin.grn-returns.show', $r) }}" class="text-[#2271b1] hover:text-[#135e96] font-mono text-[12.5px]">{{ $r->return_no }}</a></strong>
                    <div class="wp-row-actions">
                        <span><a href="{{ route('admin.grn-returns.show', $r) }}">View</a> |</span>
                        <span>
                            <form method="POST" action="{{ route('admin.grn-returns.destroy', $r) }}" style="display:inline" onsubmit="return confirm('Delete this GRN return? Stock will be restored.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="trash">Delete</button>
                            </form>
                        </span>
                    </div>
                </td>
                <td class="text-[#50575e] font-mono text-[12px]">{{ $r->goodsReceivedNote->grn_no }}</td>
                <td class="text-[#50575e]">{{ $r->supplier->name }}</td>
                <td class="text-[#50575e]">{{ $r->warehouse->name }}</td>
                <td class="text-[#50575e]">{{ $r->return_date->format('d M, Y') }}</td>
                <td class="text-[#50575e]">{{ $r->items_count ?? $r->items()->count() }}</td>
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
        $('#grnReturnTable').DataTable({
            pageLength: 25,
            order: [[0, 'desc']],
            language: { search: "_INPUT_", searchPlaceholder: "Search returns..." }
        });
    });
</script>
@endpush
