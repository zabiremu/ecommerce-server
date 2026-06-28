@extends('Admin.Layout.app')

@section('title', 'Roles')
@section('page_title', 'Roles & Permissions')

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="mb-4 px-4 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">{{ session('error') }}</div>
@endif

<div class="flex items-center justify-between mb-4">
    <h1 class="wp-h1">Roles <span class="text-[#50575e] text-[16px]">({{ $roles->count() }})</span></h1>
    <a href="{{ route('admin.roles.create') }}" class="wp-add-new">
        <i class="fas fa-plus text-[11px]"></i> Add New Role
    </a>
</div>

@if ($roles->isEmpty())
    <div class="wp-panel">
        <div class="wp-panel-body text-center py-10 text-[#50575e] text-[13px]">
            <i class="fas fa-user-shield text-4xl text-[#c3c4c7] block mb-3"></i>
            No roles created yet. <a href="{{ route('admin.roles.create') }}" class="text-[#2271b1]">Create your first role</a>.
        </div>
    </div>
@else
<table class="wp-list-table">
    <thead>
        <tr>
            <th style="width:30px">#</th>
            <th>Role Name</th>
            <th>Description</th>
            <th class="text-center" style="width:100px">Type</th>
            <th class="text-center" style="width:90px">Admins</th>
            <th class="text-center" style="width:120px">Permissions</th>
            <th style="width:100px">Created</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($roles as $role)
        <tr>
            <td class="text-[#50575e]">{{ $loop->iteration }}</td>
            <td>
                <strong>
                    <a href="{{ route('admin.roles.edit', $role) }}" class="text-[#2271b1] hover:text-[#135e96]">
                        {{ $role->name }}
                    </a>
                </strong>
                <div class="wp-row-actions">
                    <span><a href="{{ route('admin.roles.edit', $role) }}">Edit</a> |</span>
                    <span>
                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" style="display:inline"
                              onsubmit="return confirm('Delete role {{ addslashes($role->name) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="trash">Delete</button>
                        </form>
                    </span>
                </div>
            </td>
            <td class="text-[#50575e] text-[12px]">{{ $role->description ?: '—' }}</td>
            <td class="text-center">
                @if($role->is_super_admin)
                    <span style="background:#dbeafe;color:#1d4ed8" class="wp-status-pill">Super Admin</span>
                @else
                    <span class="wp-status-pill wp-status-on">Custom</span>
                @endif
            </td>
            <td class="text-center">
                <span class="font-semibold text-[13px] text-[#1d2327]">{{ $role->admins_count }}</span>
            </td>
            <td class="text-center">
                @if($role->is_super_admin)
                    <span class="text-[12px] text-[#50575e]">All</span>
                @else
                    @php $cnt = count($role->permissions ?? []); @endphp
                    <span class="text-[12px] font-semibold {{ $cnt > 0 ? 'text-[#1d2327]' : 'text-[#b32d2e]' }}">
                        {{ $cnt }} selected
                    </span>
                @endif
            </td>
            <td class="text-[12px] text-[#50575e]">{{ $role->created_at->format('d M Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

@endsection
