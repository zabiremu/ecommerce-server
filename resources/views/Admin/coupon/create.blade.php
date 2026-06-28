@extends('Admin.Layout.app')

@section('title', 'Add New Coupon')
@section('page_title', 'Add New Coupon')

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

<div class="flex items-center gap-3 mb-3">
    <h1 class="wp-h1">Add New Coupon</h1>
    <a href="{{ route('admin.coupons.index') }}" class="wp-add-new">← Back to list</a>
</div>

<form method="POST" action="{{ route('admin.coupons.store') }}">
    @csrf
    @include('Admin.coupon._form')
</form>

@endsection
