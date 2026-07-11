@extends('Admin.Layout.app')

@section('title', 'Instagram Feed')
@section('page_title', 'Instagram Feed')

@push('styles')
@include('Admin._partials.wp-styles')
<style>
    .insta-thumb { width: 90px; height: 90px; object-fit: cover; border-radius: 4px; border: 1px solid #dcdcde; background: #f6f7f7; }
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
    <h1 class="wp-h1">Instagram Feed</h1>
    <a href="{{ route('admin.instagram-posts.create') }}" class="wp-add-new">Add New</a>
</div>

<table class="wp-list-table">
    <thead>
        <tr>
            <th style="width: 110px;">Image</th>
            <th>Link</th>
            <th class="text-center" style="width: 100px;">Likes</th>
            <th class="text-center" style="width: 100px;">Comments</th>
            <th class="text-center" style="width: 90px;">Sort</th>
            <th class="text-center" style="width: 100px;">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($instagramPosts as $p)
            <tr>
                <td>
                    @if ($p->image)
                        <img src="{{ Storage::url($p->image) }}" alt="" class="insta-thumb">
                    @endif
                </td>
                <td>
                    <strong><a href="{{ route('admin.instagram-posts.edit', $p) }}" class="text-[#2271b1] hover:text-[#135e96]">{{ $p->link ?: '—' }}</a></strong>
                    <div class="wp-row-actions">
                        <span><a href="{{ route('admin.instagram-posts.edit', $p) }}">Edit</a> |</span>
                        <span>
                            <form method="POST" action="{{ route('admin.instagram-posts.destroy', $p) }}" style="display:inline" onsubmit="return confirm('Delete this post?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="trash">Delete</button>
                            </form>
                        </span>
                    </div>
                </td>
                <td class="text-center">{{ $p->likes_count }}</td>
                <td class="text-center">{{ $p->comments_count }}</td>
                <td class="text-center">{{ $p->sort_order }}</td>
                <td class="text-center">
                    <form method="POST" action="{{ route('admin.instagram-posts.toggle-status', $p) }}" style="display:inline">
                        @csrf @method('PATCH')
                        <button type="submit" class="wp-status-pill {{ $p->status ? 'wp-status-on' : 'wp-status-off' }}" style="border:0;cursor:pointer">
                            {{ $p->status ? 'Active' : 'Inactive' }}
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-[#646970] py-8">
                    No Instagram posts yet.
                    <a href="{{ route('admin.instagram-posts.create') }}" class="text-[#2271b1] hover:underline">Add your first post</a>.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="text-[13px] text-[#50575e] mt-2">{{ count($instagramPosts) }} item{{ count($instagramPosts) === 1 ? '' : 's' }}</div>

@endsection
