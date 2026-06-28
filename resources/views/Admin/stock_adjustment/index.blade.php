@extends('Admin.Layout.app')

@section('title', 'Stock Adjustments')
@section('page_title', 'Stock Adjustments')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@include('Admin._partials.wp-styles')
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="mb-4 px-4 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">{{ session('error') }}</div>
@endif

<div class="flex items-center gap-3 mb-3">
    <h1 class="wp-h1">Stock Adjustments</h1>
    <a href="{{ route('admin.stock-adjustments.create') }}" class="wp-add-new">Add New</a>
</div>

<table id="adjustmentTable" class="wp-list-table">
    <thead>
        <tr>
            <th>Reference No</th>
            <th>Warehouse</th>
            <th class="text-center" style="width: 130px;">Type</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($adjustments as $a)
            <tr>
                <td>
                    <strong><a href="{{ route('admin.stock-adjustments.show', $a) }}" class="text-[#2271b1] hover:text-[#135e96] font-mono text-[12.5px]">{{ $a->reference_no }}</a></strong>
                    <div class="wp-row-actions">
                        <span><a href="{{ route('admin.stock-adjustments.show', $a) }}">View</a> |</span>
                        <span>
                            <form method="POST" action="{{ route('admin.stock-adjustments.destroy', $a) }}" style="display:inline" onsubmit="return confirm('Delete this stock adjustment? Stock will be reverted.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="trash">Delete</button>
                            </form>
                        </span>
                    </div>
                </td>
                <td class="text-[#50575e]">{{ $a->warehouse->name }}</td>
                <td class="text-center">
                    @php
                        $typeStyle = match($a->type) {
                            'write_off' => 'background:#fdecea;color:#b32d2e;',
                            'damage' => 'background:#fff4e5;color:#d97706;',
                            'correction' => 'background:#e6f0fb;color:#2271b1;',
                            default => 'background:#f0f0f1;color:#50575e;',
                        };
                    @endphp
                    <span class="wp-status-pill" style="cursor:default;{{ $typeStyle }}">{{ str_replace('_', ' ', ucfirst($a->type)) }}</span>
                </td>
                <td class="text-[#50575e]">{{ $a->adjustment_date->format('d M, Y') }}</td>
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
        $('#adjustmentTable').DataTable({
            pageLength: 25,
            order: [[0, 'desc']],
            language: { search: "_INPUT_", searchPlaceholder: "Search adjustments..." },
            columnDefs: [{ orderable: false, targets: [2] }]
        });
    });
</script>
@endpush
