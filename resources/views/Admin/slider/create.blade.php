@extends('Admin.Layout.app')

@section('title', 'Add New Slider')
@section('page_title', 'Add New Slider')

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

<div class="flex items-center gap-3 mb-3">
    <h1 class="wp-h1">Add New Slider</h1>
    <a href="{{ route('admin.sliders.index') }}" class="wp-add-new">← Back to list</a>
</div>

<form method="POST" action="{{ route('admin.sliders.store') }}" enctype="multipart/form-data">
    @csrf
    @include('Admin.slider._form')
</form>

@endsection
