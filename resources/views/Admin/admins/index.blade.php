@extends('Admin.Layout.app')

@section('title', 'Admin Users')
@section('page_title', 'Admin Users')

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')
@php($me = Auth::guard('admin')->user())

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="mb-4 px-4 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">{{ session('error') }}</div>
@endif

<div class="flex items-center justify-between mb-4">
    <h1 class="wp-h1">Admin Users <span class="text-[#50575e] text-[16px]">({{ $admins->count() }})</span></h1>
    <a href="{{ route('admin.admins.create') }}" class="wp-add-new">
        <i class="fas fa-plus text-[11px]"></i> Add New Admin
    </a>
</div>

<table class="wp-list-table">
    <thead>
        <tr>
            <th style="width:32px">#</th>
            <th>Admin</th>
            <th>Email</th>
            <th>Role</th>
            <th style="width:100px">Type</th>
            <th style="width:110px">Created</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($admins as $admin)
        <tr>
            <td class="text-[#50575e]">{{ $loop->iteration }}</td>
            <td>
                <div class="flex items-center gap-2.5">
                    <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#5E2590,#2D1B69);
                                display:flex;align-items:center;justify-content:center;
                                color:#fff;font-size:12px;font-weight:700;flex-shrink:0">
                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                    </div>
                    <div>
                        <strong class="{{ $admin->id === $me->id ? 'text-[#2271b1]' : '' }}">
                            {{ $admin->name }}
                            @if($admin->id === $me->id)
                                <span class="text-[11px] font-normal text-[#50575e]">(You)</span>
                            @endif
                        </strong>
                        <div class="wp-row-actions">
                            <span><a href="{{ route('admin.admins.edit', $admin) }}">Edit</a></span>
                            @if($admin->id !== $me->id && !$admin->isSuperAdmin())
                            <span> | <form method="POST" action="{{ route('admin.admins.destroy', $admin) }}" style="display:inline"
                                      onsubmit="return confirm('Delete admin {{ addslashes($admin->name) }}? This cannot be undone.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="trash">Delete</button>
                                </form>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </td>
            <td class="text-[#50575e] text-[13px]">{{ $admin->email }}</td>
            <td>
                @if($admin->role)
                    <span style="background:#f0f0f1;color:#2c3338;padding:2px 9px;border-radius:3px;font-size:12px;font-weight:600;">
                        {{ $admin->role->name }}
                    </span>
                @else
                    <span class="text-[12px] text-[#50575e]">No role</span>
                @endif
            </td>
            <td>
                @if($admin->isSuperAdmin())
                    <span style="background:#dbeafe;color:#1d4ed8" class="wp-status-pill">Super Admin</span>
                @else
                    <span class="wp-status-pill wp-status-on">Staff</span>
                @endif
            </td>
            <td class="text-[12px] text-[#50575e]">{{ $admin->created_at->format('d M Y') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center text-[#50575e] py-8">No admin users found.</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection
