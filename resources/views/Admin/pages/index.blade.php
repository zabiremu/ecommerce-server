@extends('Admin.Layout.app')

@section('title', 'Pages')
@section('page_title', 'Pages')

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif

<div class="flex items-center gap-3 mb-3">
    <h1 class="wp-h1">Pages</h1>
</div>

<p class="text-[13px] text-[#50575e] mb-4">Edit the content of your static pages — Privacy Policy, Terms & Conditions, and Refund Policy.</p>

<table class="wp-list-table">
    <thead>
        <tr>
            <th>Page</th>
            <th>Slug</th>
            <th>Last Updated Label</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pages as $page)
            <tr>
                <td>
                    <strong>
                        <a href="{{ route('admin.pages.edit', $page) }}" class="text-[#2271b1] hover:text-[#135e96]">
                            @if($page->icon)<i class="{{ $page->icon }} mr-1.5 text-[#787c82]"></i>@endif
                            {{ $page->title }}
                        </a>
                    </strong>
                    <div class="wp-row-actions">
                        <span><a href="{{ route('admin.pages.edit', $page) }}">Edit</a> |</span>
                        <span>
                            <a href="{{ route($page->slug) }}" target="_blank" class="text-[#2271b1]">View</a>
                        </span>
                    </div>
                </td>
                <td class="text-[#50575e] font-mono text-[12px]">/{{ $page->slug }}</td>
                <td class="text-[#50575e]">{{ $page->last_updated_label ?? '—' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
