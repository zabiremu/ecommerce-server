@extends('Admin.Layout.app')

@section('title', 'Phone Blacklist')
@section('page_title', 'Phone Blacklist')

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="mb-4 px-4 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">{{ session('error') }}</div>
@endif

<div class="flex items-center justify-between mb-4">
    <div>
        <h1 class="wp-h1">Phone Blacklist</h1>
        <p class="text-[13px] text-[#50575e] mt-1">Blocked phone numbers cannot place any new orders.</p>
    </div>
</div>

{{-- Add form --}}
<div class="wp-panel mb-5" style="max-width:520px">
    <div class="wp-panel-h"><i class="fas fa-ban mr-1.5 text-red-500"></i> Block a Phone Number</div>
    <div class="wp-panel-body">
        <form method="POST" action="{{ route('admin.phone-blacklist.store') }}">
            @csrf
            <div class="wp-field">
                <label>Phone Number <span class="text-red-500">*</span></label>
                <input type="text" name="phone" class="wp-input" placeholder="01XXXXXXXXX" required>
                @error('phone')<p class="wp-err">{{ $message }}</p>@enderror
            </div>
            <div class="wp-field">
                <label>Reason (optional)</label>
                <input type="text" name="reason" class="wp-input" placeholder="e.g. Fake COD orders, fraud">
            </div>
            <button type="submit" class="wp-btn wp-btn-primary"><i class="fas fa-ban mr-1"></i> Block Number</button>
        </form>
    </div>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('admin.phone-blacklist.index') }}" class="mb-3 flex gap-2">
    <input type="search" name="s" value="{{ $search }}" placeholder="Search phone or reason…" class="wp-input" style="width:260px">
    <button type="submit" class="wp-btn">Search</button>
    @if($search)<a href="{{ route('admin.phone-blacklist.index') }}" class="wp-btn">Clear</a>@endif
</form>

<table class="wp-list-table">
    <thead>
        <tr>
            <th>Phone Number</th>
            <th>Reason</th>
            <th class="text-center" style="width:80px">Orders</th>
            <th class="text-center" style="width:80px">Cancelled</th>
            <th class="text-center" style="width:80px">Returned</th>
            <th>Blocked On</th>
            <th style="width:80px"></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($entries as $entry)
        @php $s = $stats->get($entry->phone); @endphp
        <tr>
            <td>
                <strong class="font-mono">{{ $entry->phone }}</strong>
            </td>
            <td class="text-[#50575e]">{{ $entry->reason ?: '—' }}</td>
            <td class="text-center">{{ $s?->total ?? 0 }}</td>
            <td class="text-center {{ ($s?->cancelled ?? 0) > 0 ? 'text-red-600 font-semibold' : '' }}">{{ $s?->cancelled ?? 0 }}</td>
            <td class="text-center {{ ($s?->returned ?? 0) > 0 ? 'text-orange-600 font-semibold' : '' }}">{{ $s?->returned ?? 0 }}</td>
            <td class="text-[#50575e]">{{ $entry->created_at->format('d M Y, h:i A') }}</td>
            <td>
                <form method="POST" action="{{ route('admin.phone-blacklist.destroy', $entry) }}" onsubmit="return confirm('Remove this number from blacklist?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="wp-btn-link trash text-red-500 hover:text-red-700 text-[12px]">
                        <i class="fas fa-trash-can mr-1"></i>Unblock
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-[#646970] py-8">No blocked phone numbers yet.</td></tr>
        @endforelse
    </tbody>
</table>

<div class="mt-3">{{ $entries->links() }}</div>

@endsection
