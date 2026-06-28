@extends('Admin.Layout.app')

@section('title', 'Edit Coupon')
@section('page_title', 'Edit Coupon · ' . $coupon->code)

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

<div class="flex items-center gap-3 mb-3">
    <h1 class="wp-h1">Edit Coupon <span class="font-mono text-[#50575e] text-[18px]">{{ $coupon->code }}</span></h1>
    <a href="{{ route('admin.coupons.index') }}" class="wp-add-new">← Back to list</a>
</div>

<form method="POST" action="{{ route('admin.coupons.update', $coupon) }}">
    @csrf @method('PUT')
    @include('Admin.coupon._form')
</form>

@endsection
