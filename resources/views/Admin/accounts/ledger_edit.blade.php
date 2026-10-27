@extends('Admin.Layout.app')

@section('title', 'Edit ' . $cfg['singular'])
@section('page_title', 'Accounts & Reports')

@push('styles')
@include('Admin.accounts._styles')
@endpush

@section('content')

<div class="flex items-center gap-3 mb-3">
    <a href="{{ route($cfg['route'] . '.index', ['month' => $entry->entry_date->format('Y-m')]) }}" class="text-[13px] text-[#2271b1]"><i class="fas fa-arrow-left mr-1"></i> {{ $cfg['plural'] }}</a>
</div>
<h1 class="wp-h1 mb-4">Edit {{ $cfg['singular'] }}</h1>

<div class="grid grid-cols-12 gap-5">
    <div class="col-span-12 lg:col-span-6">
        <div class="wp-panel">
            <div class="wp-panel-body">
                <form method="POST" action="{{ route($cfg['route'] . '.update', $entry->id) }}">
                    @csrf @method('PUT')
                    @include('Admin.accounts._ledger_form')
                    <button type="submit" class="wp-btn wp-btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
