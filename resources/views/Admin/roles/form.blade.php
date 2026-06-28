@extends('Admin.Layout.app')

@section('title', isset($role) ? 'Edit Role: '.$role->name : 'Create Role')
@section('page_title', isset($role) ? 'Edit Role' : 'Create Role')

@push('styles')
@include('Admin._partials.wp-styles')
<style>
    body.font-sans { background: #f0f0f1 !important; }
    main          { background: #f0f0f1 !important; }

    /* Permission matrix */
    .perm-table { width: 100%; border-collapse: collapse; }
    .perm-table thead th {
        padding: 8px 12px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: #50575e;
        background: #f6f7f7;
        border-bottom: 1px solid #c3c4c7;
        text-align: center;
    }
    .perm-table thead th:first-child { text-align: left; width: 200px; }
    .perm-table tbody tr:hover { background: #f6f7f7; }
    .perm-table tbody tr + tr { border-top: 1px solid #f0f0f1; }
    .perm-table td {
        padding: 9px 12px;
        font-size: 13px;
        color: #2c3338;
        text-align: center;
        vertical-align: middle;
    }
    .perm-table td:first-child { text-align: left; font-weight: 500; }
    .perm-table td.group-label {
        background: #f0f0f1;
        font-size: 11px;
        font-weight: 700;
        color: #50575e;
        text-transform: uppercase;
        letter-spacing: .06em;
        padding: 6px 12px;
        border-top: 1px solid #c3c4c7;
    }

    /* Checkbox styling */
    .perm-cb { width: 16px; height: 16px; cursor: pointer; accent-color: #2271b1; }

    /* Row-select-all checkbox */
    .row-all-cb { width: 16px; height: 16px; cursor: pointer; accent-color: #5E2590; }
</style>
@endpush

@section('content')
@php $isEdit = isset($role); @endphp

<div class="flex items-center gap-3 mb-4">
    <h1 class="wp-h1">{{ $isEdit ? 'Edit Role: '.$role->name : 'Create New Role' }}</h1>
    <a href="{{ route('admin.roles.index') }}" class="wp-add-new">← Back to Roles</a>
</div>

@if ($errors->any())
    <div class="mb-4 px-3 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">
        <ul class="list-disc list-inside space-y-1">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<form method="POST"
      action="{{ $isEdit ? route('admin.roles.update', $role) : route('admin.roles.store') }}">
    @csrf
    @if ($isEdit) @method('PUT') @endif

    <div class="flex gap-5 items-start">

        {{-- ── Main column ── --}}
        <div class="flex-1 min-w-0 space-y-4">

            {{-- Role details --}}
            <div class="wp-panel">
                <div class="wp-panel-h"><i class="fas fa-user-shield text-[12px] text-[#787c82] mr-1.5"></i> Role Details</div>
                <div class="wp-panel-body px-6 py-5">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div class="wp-field">
                            <label for="name">Role Name <span style="color:#d63638">*</span></label>
                            <input type="text" id="name" name="name"
                                   value="{{ old('name', $role->name ?? '') }}"
                                   class="wp-input {{ $errors->has('name') ? 'border-[#d63638]' : '' }}"
                                   placeholder="e.g. Store Manager, Editor, Viewer">
                            @error('name')<span class="wp-err">{{ $message }}</span>@enderror
                        </div>
                        <div class="wp-field">
                            <label for="description">Description</label>
                            <input type="text" id="description" name="description"
                                   value="{{ old('description', $role->description ?? '') }}"
                                   class="wp-input"
                                   placeholder="What can this role do?">
                        </div>
                    </div>

                    <div class="wp-field mt-1">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;font-weight:500;color:#1d2327;">
                            <input type="hidden" name="is_super_admin" value="0">
                            <input type="checkbox" name="is_super_admin" value="1" id="isSuperAdmin"
                                   {{ old('is_super_admin', $role->is_super_admin ?? false) ? 'checked' : '' }}
                                   onchange="toggleSuperAdmin(this)"
                                   style="width:16px;height:16px;accent-color:#2271b1;">
                            Grant all permissions (Super Admin)
                        </label>
                        <p class="wp-help">Super admins bypass all permission checks and have full access.</p>
                    </div>
                </div>
            </div>

            {{-- Permission matrix --}}
            <div class="wp-panel" id="permPanel">
                <div class="wp-panel-h" style="justify-content:space-between;">
                    <span><i class="fas fa-shield-halved text-[12px] text-[#787c82] mr-1.5"></i> Permissions</span>
                    <label style="display:flex;align-items:center;gap:6px;font-size:12px;font-weight:500;color:#50575e;cursor:pointer;">
                        <input type="checkbox" id="selectAllGlobal" class="perm-cb"
                               onchange="selectAll(this)">
                        Select / Deselect All
                    </label>
                </div>
                <div style="overflow-x:auto;">
                    <table class="perm-table">
                        <thead>
                            <tr>
                                <th>Module</th>
                                <th style="width:70px">View</th>
                                <th style="width:70px">Create</th>
                                <th style="width:70px">Edit</th>
                                <th style="width:70px">Delete</th>
                                <th style="width:70px">All</th>
                            </tr>
                        </thead>
                        <tbody id="permBody">
                        @php
                            $savedPerms = old('permissions', $role->permissions ?? []);
                        @endphp
                        @foreach ($permissions as $group => $modules)
                            <tr>
                                <td class="group-label" colspan="6">{{ $group }}</td>
                            </tr>
                            @foreach ($modules as $module => $actions)
                            @php $allActions = ['view','create','edit','delete']; @endphp
                            <tr data-module="{{ $module }}">
                                <td>{{ \App\Models\Role::moduleLabel($module) }}</td>

                                @foreach ($allActions as $action)
                                    <td>
                                        @if(in_array($action, $actions))
                                            @php $key = $module.'.'.$action; @endphp
                                            <input type="checkbox"
                                                   name="permissions[]"
                                                   value="{{ $key }}"
                                                   class="perm-cb module-cb"
                                                   data-module="{{ $module }}"
                                                   {{ in_array($key, $savedPerms) ? 'checked' : '' }}>
                                        @else
                                            <span style="color:#c3c4c7;font-size:11px;">—</span>
                                        @endif
                                    </td>
                                @endforeach

                                {{-- Row "all" checkbox --}}
                                <td>
                                    <input type="checkbox" class="row-all-cb"
                                           onchange="selectRow('{{ $module }}', this)"
                                           {{ collect($actions)->every(fn($a) => in_array($module.'.'.$a, $savedPerms)) ? 'checked' : '' }}>
                                </td>
                            </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- ── Sidebar ── --}}
        <div class="w-56 shrink-0 space-y-4">

            <div class="wp-panel">
                <div class="wp-panel-h">Publish</div>
                <div class="wp-panel-body px-4 py-3 space-y-2">
                    <button type="submit" class="wp-btn wp-btn-primary" style="width:100%;padding:8px 12px;">
                        <i class="fas {{ $isEdit ? 'fa-save' : 'fa-plus' }} mr-1.5"></i>
                        {{ $isEdit ? 'Update Role' : 'Create Role' }}
                    </button>
                    <a href="{{ route('admin.roles.index') }}" class="wp-btn" style="width:100%;display:block;text-align:center;">
                        Cancel
                    </a>
                    @if($isEdit)
                    <hr style="border:0;border-top:1px solid #f0f0f1;margin:4px 0">
                    <form method="POST" action="{{ route('admin.roles.destroy', $role) }}"
                          onsubmit="return confirm('Delete this role?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="wp-btn" style="width:100%;color:#b32d2e;border-color:#fca5a5;background:#fff5f5;">
                            <i class="fas fa-trash mr-1"></i> Delete Role
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            <div class="wp-panel">
                <div class="wp-panel-h">Summary</div>
                <div class="wp-panel-body px-4 py-3">
                    <p class="text-[12px] text-[#50575e] mb-2">Selected permissions:</p>
                    <p id="permCount" class="text-[22px] font-bold text-[#1d2327]">
                        {{ count(old('permissions', $role->permissions ?? [])) }}
                    </p>
                    <p class="text-[11px] text-[#787c82]">out of {{ collect($permissions)->flatten()->count() }} available</p>
                </div>
            </div>

        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
function toggleSuperAdmin(cb) {
    var panel = document.getElementById('permPanel');
    if (panel) panel.style.opacity = cb.checked ? '0.4' : '1';
}

function selectAll(masterCb) {
    var cbs = document.querySelectorAll('.perm-cb');
    cbs.forEach(function(cb) { cb.checked = masterCb.checked; });
    document.querySelectorAll('.row-all-cb').forEach(function(cb) { cb.checked = masterCb.checked; });
    updateCount();
}

function selectRow(module, rowCb) {
    var cbs = document.querySelectorAll('.module-cb[data-module="' + module + '"]');
    cbs.forEach(function(cb) { cb.checked = rowCb.checked; });
    updateCount();
}

// Keep row "all" checkbox in sync when individual checkboxes change
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('perm-cb')) {
        var module = e.target.dataset.module;
        if (!module) return;
        var rowCbs = document.querySelectorAll('.module-cb[data-module="' + module + '"]');
        var allChecked = Array.from(rowCbs).every(function(cb) { return cb.checked; });
        var rowAll = document.querySelector('tr[data-module="' + module + '"] .row-all-cb');
        if (rowAll) rowAll.checked = allChecked;

        // Global master checkbox
        var allPerms = document.querySelectorAll('.perm-cb');
        var allCheckedGlobal = Array.from(allPerms).every(function(cb) { return cb.checked; });
        var master = document.getElementById('selectAllGlobal');
        if (master) master.checked = allCheckedGlobal;

        updateCount();
    }
});

function updateCount() {
    var checked = document.querySelectorAll('.perm-cb:checked').length;
    var el = document.getElementById('permCount');
    if (el) el.textContent = checked;
}

// Init
document.addEventListener('DOMContentLoaded', function() {
    var superCb = document.getElementById('isSuperAdmin');
    if (superCb && superCb.checked) {
        var panel = document.getElementById('permPanel');
        if (panel) panel.style.opacity = '0.4';
    }
    updateCount();
});
</script>
@endpush
