@extends('Admin.Layout.app')

@section('title', 'Stock Transfers')
@section('page_title', 'Stock Transfers')

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
    <h1 class="wp-h1">Stock Transfers</h1>
    <a href="{{ route('admin.stock-transfers.create') }}" class="wp-add-new">Add New</a>
</div>

<table id="transferTable" class="wp-list-table">
    <thead>
        <tr>
            <th>Reference No</th>
            <th>From Warehouse</th>
            <th>To Warehouse</th>
            <th>Date</th>
            <th class="text-center" style="width: 110px;">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transfers as $t)
            <tr>
                <td>
                    <strong><a href="{{ route('admin.stock-transfers.show', $t) }}" class="text-[#2271b1] hover:text-[#135e96] font-mono text-[12.5px]">{{ $t->reference_no }}</a></strong>
                    <div class="wp-row-actions">
                        <span><a href="{{ route('admin.stock-transfers.show', $t) }}">View</a></span>
                        @if ($t->status === 'pending')
                            <span> | <form method="POST" action="{{ route('admin.stock-transfers.destroy', $t) }}" style="display:inline" onsubmit="return confirm('Delete this transfer?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="trash">Delete</button>
                            </form></span>
                        @endif
                    </div>
                </td>
                <td class="text-[#50575e]">{{ $t->fromWarehouse->name }}</td>
                <td class="text-[#50575e]">{{ $t->toWarehouse->name }}</td>
                <td class="text-[#50575e]">{{ $t->transfer_date->format('d M, Y') }}</td>
                <td class="text-center">
                    @php
                        $cls = $t->status === 'completed' ? 'wp-status-on' : ($t->status === 'cancelled' ? '' : '');
                    @endphp
                    <span class="wp-status-pill {{ $cls }}" style="cursor: default; {{ $t->status === 'pending' ? 'background:#fff4e5;color:#d97706;' : ($t->status === 'cancelled' ? 'background:#f0f0f1;color:#50575e;' : '') }}">{{ ucfirst($t->status) }}</span>
                </td>
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
        $('#transferTable').DataTable({
            pageLength: 25,
            order: [[0, 'desc']],
            language: { search: "_INPUT_", searchPlaceholder: "Search transfers..." },
            columnDefs: [{ orderable: false, targets: [4] }]
        });
    });
</script>
@endpush
