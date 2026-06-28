@extends('Admin.Layout.app')

@section('title', 'Purchases')
@section('page_title', 'Purchases')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@include('Admin._partials.wp-styles')
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif

<div class="flex items-center gap-3 mb-3">
    <h1 class="wp-h1">Purchases</h1>
    <a href="{{ route('admin.purchases.create') }}" class="wp-add-new">Add New</a>
</div>

<table id="purchaseTable" class="wp-list-table">
    <thead>
        <tr>
            <th>Invoice</th>
            <th>Supplier</th>
            <th>Warehouse</th>
            <th>Date</th>
            <th class="text-right" style="width: 110px;">Total</th>
            <th class="text-center" style="width: 110px;">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($purchases as $p)
            <tr>
                <td>
                    <strong><a href="{{ route('admin.purchases.show', $p) }}" class="text-[#2271b1] hover:text-[#135e96] font-mono text-[12.5px]">{{ $p->invoice_no }}</a></strong>
                    <div class="wp-row-actions">
                        <span><a href="{{ route('admin.purchases.show', $p) }}">View</a> |</span>
                        <span>
                            <form method="POST" action="{{ route('admin.purchases.destroy', $p) }}" style="display:inline" onsubmit="return confirm('Delete this purchase?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="trash">Delete</button>
                            </form>
                        </span>
                    </div>
                </td>
                <td class="text-[#50575e]">{{ $p->supplier->name }}</td>
                <td class="text-[#50575e]">{{ $p->warehouse->name }}</td>
                <td class="text-[#50575e]">{{ $p->purchase_date->format('d M, Y') }}</td>
                <td class="text-right"><strong>{{ number_format($p->total_amount, 2) }}</strong></td>
                <td class="text-center">
                    @php
                        $s = $p->status;
                        $cls = $s === 'completed' ? 'wp-status-on' : ($s === 'cancelled' ? 'wp-status-off' : 'wp-status-pending');
                    @endphp
                    <span class="wp-status-pill {{ $cls }}" style="cursor: default; {{ $s === 'pending' ? 'background:#fff4e5;color:#d97706;' : '' }}">{{ ucfirst($s) }}</span>
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
        $('#purchaseTable').DataTable({
            pageLength: 25,
            order: [[0, 'desc']],
            language: { search: "_INPUT_", searchPlaceholder: "Search purchases..." },
            columnDefs: [{ orderable: false, targets: [5] }]
        });
    });
</script>
@endpush
