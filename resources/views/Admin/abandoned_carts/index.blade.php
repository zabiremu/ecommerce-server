@extends('Admin.Layout.app')

@section('title', 'Abandoned Carts')
@section('page_title', 'Abandoned Carts')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@include('Admin._partials.wp-styles')
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif

<div class="flex items-center gap-3 mb-3">
    <h1 class="wp-h1">Abandoned Carts</h1>
    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-orange-100 text-orange-700">{{ $carts->count() }} active</span>
</div>

<p class="text-[13px] text-[#50575e] mb-4">Visitors who added items to their cart but did not complete a purchase.</p>

<table id="cartTable" class="wp-list-table">
    <thead>
        <tr>
            <th>Visitor / Contact</th>
            <th>IP Address</th>
            <th>Items</th>
            <th>Est. Total</th>
            <th>Last Activity</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($carts as $cart)
            <tr>
                <td>
                    @if ($cart->contact_name || $cart->contact_email || $cart->contact_phone)
                        <strong>
                            <a href="{{ route('admin.abandoned-carts.show', $cart) }}" class="text-[#2271b1] hover:text-[#135e96]">
                                {{ $cart->contact_name ?? $cart->contact_email ?? 'Unknown' }}
                            </a>
                        </strong>
                        @if ($cart->contact_phone)
                            <div class="text-[12px] text-[#50575e] font-mono">{{ $cart->contact_phone }}</div>
                        @elseif ($cart->contact_email)
                            <div class="text-[12px] text-[#50575e]">{{ $cart->contact_email }}</div>
                        @endif
                    @else
                        <a href="{{ route('admin.abandoned-carts.show', $cart) }}" class="text-[#2271b1] hover:text-[#135e96] text-[12px] font-mono">
                            Anonymous
                        </a>
                        <div class="text-[11px] text-[#787c82]">Session: {{ substr($cart->session_id, 0, 12) }}…</div>
                    @endif
                    <div class="wp-row-actions">
                        <span><a href="{{ route('admin.abandoned-carts.show', $cart) }}">View</a> |</span>
                        <span>
                            <form method="POST" action="{{ route('admin.abandoned-carts.destroy', $cart) }}" style="display:inline" onsubmit="return confirm('Delete this cart record?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="trash">Delete</button>
                            </form>
                        </span>
                    </div>
                </td>
                <td class="text-[#50575e] font-mono text-[12px]">{{ $cart->ip_address ?? '—' }}</td>
                <td class="text-[#50575e]">{{ $cart->items->count() }} item{{ $cart->items->count() !== 1 ? 's' : '' }}</td>
                <td><strong>৳{{ number_format($cart->estimated_total, 2) }}</strong></td>
                <td class="text-[#50575e]">
                    @if ($cart->last_activity)
                        <span title="{{ $cart->last_activity->format('d M Y, H:i') }}">
                            {{ $cart->last_activity->diffForHumans() }}
                        </span>
                    @else
                        —
                    @endif
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
        $('#cartTable').DataTable({
            pageLength: 25,
            order: [[4, 'desc']],
            language: { search: "_INPUT_", searchPlaceholder: "Search by name, phone, IP..." }
        });
    });
</script>
@endpush
