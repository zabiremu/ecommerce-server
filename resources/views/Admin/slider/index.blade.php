@extends('Admin.Layout.app')

@section('title', 'Hero Sliders')
@section('page_title', 'Hero Sliders')

@push('styles')
@include('Admin._partials.wp-styles')
<style>
    .slider-thumb { width: 120px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid #dcdcde; background: #f6f7f7; }
</style>
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="mb-4 px-4 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">{{ session('error') }}</div>
@endif

<div class="flex items-center gap-3 mb-4 flex-wrap">
    <h1 class="wp-h1">Hero Sliders</h1>
    <a href="{{ route('admin.sliders.create') }}" class="wp-add-new">Add New</a>
</div>

<table class="wp-list-table">
    <thead>
        <tr>
            <th style="width: 140px;">Image</th>
            <th>Title</th>
            <th>Badge</th>
            <th>Button</th>
            <th class="text-center" style="width: 90px;">Order</th>
            <th class="text-center" style="width: 100px;">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($sliders as $s)
            <tr>
                <td>
                    @if ($s->image)
                        <img src="{{ Storage::url($s->image) }}" alt="" class="slider-thumb">
                    @endif
                </td>
                <td>
                    <strong><a href="{{ route('admin.sliders.edit', $s) }}" class="text-[#2271b1] hover:text-[#135e96]">{{ $s->title }}</a></strong>
                    @if ($s->subtitle)
                        <div class="text-[12.5px] text-[#50575e]">{{ $s->subtitle }}</div>
                    @endif
                    <div class="wp-row-actions">
                        <span><a href="{{ route('admin.sliders.edit', $s) }}">Edit</a> |</span>
                        <span>
                            <form method="POST" action="{{ route('admin.sliders.destroy', $s) }}" style="display:inline" onsubmit="return confirm('Delete this slider?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="trash">Delete</button>
                            </form>
                        </span>
                    </div>
                </td>
                <td class="text-[#50575e]">
                    @if ($s->badge)
                        @if ($s->badge_icon)
                            @php $bi = str_contains($s->badge_icon, ' ') ? $s->badge_icon : 'fas ' . $s->badge_icon; @endphp
                            <i class="{{ $bi }} mr-1"></i>
                        @endif
                        {{ $s->badge }}
                    @else
                        —
                    @endif
                </td>
                <td class="text-[#50575e]">
                    @if ($s->button_text)
                        <div>{{ $s->button_text }}</div>
                        <div class="text-[11.5px] text-[#787c82] truncate" style="max-width:220px">{{ $s->button_link }}</div>
                    @else
                        —
                    @endif
                </td>
                <td class="text-center">{{ $s->sort_order }}</td>
                <td class="text-center">
                    <form method="POST" action="{{ route('admin.sliders.toggle-status', $s) }}" style="display:inline">
                        @csrf @method('PATCH')
                        <button type="submit" class="wp-status-pill {{ $s->status ? 'wp-status-on' : 'wp-status-off' }}" style="border:0;cursor:pointer">
                            {{ $s->status ? 'Active' : 'Inactive' }}
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-[#646970] py-8">
                    No sliders yet.
                    <a href="{{ route('admin.sliders.create') }}" class="text-[#2271b1] hover:underline">Create your first slider</a>.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="text-[13px] text-[#50575e] mt-2">{{ count($sliders) }} item{{ count($sliders) === 1 ? '' : 's' }}</div>

@endsection
