@extends('Admin.Layout.app')

@section('title', 'Edit Slider')
@section('page_title', 'Edit Slider · ' . $slider->title)

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

<div class="flex items-center gap-3 mb-3">
    <h1 class="wp-h1">Edit Slider</h1>
    <a href="{{ route('admin.sliders.index') }}" class="wp-add-new">← Back to list</a>
</div>

<form method="POST" action="{{ route('admin.sliders.update', $slider) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('Admin.slider._form')
</form>

@endsection
