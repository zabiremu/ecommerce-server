@extends('Admin.Layout.app')

@section('title', 'Add Instagram Post')
@section('page_title', 'Add Instagram Post')

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

<div class="flex items-center gap-3 mb-3">
    <h1 class="wp-h1">Add Instagram Post</h1>
    <a href="{{ route('admin.instagram-posts.index') }}" class="wp-add-new">← Back to list</a>
</div>

<form method="POST" action="{{ route('admin.instagram-posts.store') }}" enctype="multipart/form-data">
    @csrf
    @include('Admin.instagram-post._form')
</form>

@endsection
