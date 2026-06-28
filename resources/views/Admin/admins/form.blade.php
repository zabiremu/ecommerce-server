@extends('Admin.Layout.app')

@section('title', isset($admin) ? 'Edit Admin: '.$admin->name : 'Create Admin User')
@section('page_title', isset($admin) ? 'Edit Admin User' : 'Create Admin User')

@push('styles')
@include('Admin._partials.wp-styles')
<style>
    body.font-sans { background: #f0f0f1 !important; }
    main          { background: #f0f0f1 !important; }

    .wp-form-table { width:100%; border-collapse:collapse; }
    .wp-form-table th {
        width: 180px; padding: 14px 10px 14px 0;
        vertical-align: top; text-align: left;
        font-size: 14px; font-weight: 400; color: #1d2327; line-height: 1.4;
    }
    .wp-form-table td { padding: 10px 0; vertical-align: top; }
    @media (max-width: 640px) {
        .wp-form-table,
        .wp-form-table tbody,
        .wp-form-table tr { display: block; width: 100%; }
        .wp-form-table th {
            display: block; width: 100%;
            padding: 10px 0 2px; font-weight: 600; font-size: 13px;
        }
        .wp-form-table td {
            display: block; width: 100%; padding: 0 0 14px;
        }
        .wp-form-table td input,
        .wp-form-table td select,
        .pw-wrap { max-width: 100% !important; }
    }
    .wp-form-table td input,
    .wp-form-table td select {
        max-width: 400px; width: 100%;
        padding: 6px 10px; font-size: 13px;
        border: 1px solid #8c8f94; border-radius: 4px;
        background: #fff; outline: none; color: #2c3338;
    }
    .wp-form-table td input:focus,
    .wp-form-table td select:focus { border-color: #2271b1; box-shadow: 0 0 0 1px #2271b1; }
    .wp-form-table td input.error { border-color: #d63638; box-shadow: 0 0 0 1px #d63638; }
    .pw-wrap { position: relative; max-width: 400px; }
    .pw-wrap input { width: 100%; padding-right: 36px !important; }
    .pw-toggle { position: absolute; right: 8px; top: 50%; transform: translateY(-50%);
                 background: none; border: 0; cursor: pointer; color: #787c82; font-size: 13px; }
    .pw-toggle:hover { color: #2271b1; }
    .description { font-size: 12px; color: #646970; margin-top: 5px; display: block; line-height: 1.5; }
    .error-msg   { font-size: 12px; color: #d63638; margin-top: 4px; display: block; }
    .wp-section-heading { font-size: 14px; font-weight: 600; color: #1d2327; padding: 10px 12px;
                          background: #fff; border-bottom: 1px solid #c3c4c7;
                          display: flex; align-items: center; gap: 8px; }
</style>
@endpush

@section('content')
@php $isEdit = isset($admin); @endphp

<div class="flex items-center gap-3 mb-4">
    <h1 class="wp-h1">{{ $isEdit ? 'Edit: '.$admin->name : 'Create Admin User' }}</h1>
    <a href="{{ route('admin.admins.index') }}" class="wp-add-new">← Back</a>
</div>

@if ($errors->any())
    <div class="mb-4 px-3 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">
        <ul class="list-disc list-inside space-y-1">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<form method="POST"
      action="{{ $isEdit ? route('admin.admins.update', $admin) : route('admin.admins.store') }}">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="flex flex-col lg:flex-row gap-5 items-start">

        {{-- ── Main column ── --}}
        <div class="flex-1 min-w-0 space-y-4">

            {{-- Account info --}}
            <div class="wp-panel">
                <div class="wp-section-heading">
                    <i class="fas fa-user text-[12px] text-[#787c82]"></i>
                    Account Information
                </div>
                <div class="wp-panel-body px-6 py-5">
                    <table class="wp-form-table">
                        <tr>
                            <th><label for="name">Full Name <span style="color:#d63638">*</span></label></th>
                            <td>
                                <input type="text" id="name" name="name"
                                       value="{{ old('name', $admin->name ?? '') }}"
                                       class="{{ $errors->has('name') ? 'error' : '' }}"
                                       placeholder="Admin full name">
                                @error('name')<span class="error-msg">{{ $message }}</span>@enderror
                            </td>
                        </tr>
                        <tr>
                            <th><label for="email">Email Address <span style="color:#d63638">*</span></label></th>
                            <td>
                                <input type="email" id="email" name="email"
                                       value="{{ old('email', $admin->email ?? '') }}"
                                       class="{{ $errors->has('email') ? 'error' : '' }}"
                                       placeholder="admin@example.com">
                                @error('email')<span class="error-msg">{{ $message }}</span>@else
                                    <span class="description">Used for login and email notifications.</span>
                                @enderror
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Password --}}
            <div class="wp-panel">
                <div class="wp-section-heading">
                    <i class="fas fa-lock text-[12px] text-[#787c82]"></i>
                    {{ $isEdit ? 'Change Password' : 'Set Password' }}
                </div>
                <div class="wp-panel-body px-6 py-5">
                    <table class="wp-form-table">
                        <tr>
                            <th><label for="password">{{ $isEdit ? 'New Password' : 'Password' }} @if(!$isEdit)<span style="color:#d63638">*</span>@endif</label></th>
                            <td>
                                <div class="pw-wrap">
                                    <input type="password" id="password" name="password"
                                           autocomplete="new-password"
                                           placeholder="{{ $isEdit ? 'Leave blank to keep current' : 'Min. 8 characters' }}"
                                           class="{{ $errors->has('password') ? 'error' : '' }}">
                                    <button type="button" class="pw-toggle" onclick="togglePw('password',this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')<span class="error-msg">{{ $message }}</span>@enderror
                            </td>
                        </tr>
                        <tr>
                            <th><label for="password_confirmation">Confirm Password @if(!$isEdit)<span style="color:#d63638">*</span>@endif</label></th>
                            <td>
                                <div class="pw-wrap">
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                           autocomplete="new-password"
                                           placeholder="Re-enter password">
                                    <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation',this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>

        {{-- ── Sidebar ── --}}
        <div class="w-full lg:w-60 lg:shrink-0 space-y-4">

            {{-- Publish --}}
            <div class="wp-panel">
                <div class="wp-section-heading">Publish</div>
                <div class="wp-panel-body px-4 py-3 space-y-2">
                    <button type="submit" class="wp-btn wp-btn-primary" style="width:100%;padding:8px 12px;">
                        <i class="fas {{ $isEdit ? 'fa-save' : 'fa-user-plus' }} mr-1.5"></i>
                        {{ $isEdit ? 'Update Admin' : 'Create Admin' }}
                    </button>
                    <a href="{{ route('admin.admins.index') }}" class="wp-btn"
                       style="width:100%;display:block;text-align:center;">Cancel</a>

                    @if($isEdit && Auth::guard('admin')->id() !== $admin->id)
                    <hr style="border:0;border-top:1px solid #f0f0f1;margin:4px 0">
                    <form method="POST" action="{{ route('admin.admins.destroy', $admin) }}"
                          onsubmit="return confirm('Delete this admin? This cannot be undone.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="wp-btn"
                                style="width:100%;color:#b32d2e;border-color:#fca5a5;background:#fff5f5;">
                            <i class="fas fa-trash mr-1"></i> Delete Admin
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            {{-- Role assignment --}}
            <div class="wp-panel">
                <div class="wp-section-heading">
                    <i class="fas fa-user-shield text-[12px] text-[#787c82]"></i>
                    Role
                </div>
                <div class="wp-panel-body px-4 py-3">
                    <select name="role_id" class="wp-input" style="width:100%">
                        <option value="">— Super Admin (no role) —</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}"
                                {{ old('role_id', $admin->role_id ?? '') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                                @if($role->is_super_admin) ★@endif
                            </option>
                        @endforeach
                    </select>
                    <p style="font-size:12px;color:#646970;margin-top:6px;line-height:1.5;">
                        Admins without a role are <strong>Super Admins</strong> with full access.
                        <a href="{{ route('admin.roles.index') }}" class="text-[#2271b1]">Manage roles →</a>
                    </p>

                    @if($isEdit && $admin->role)
                    <div style="margin-top:10px;padding:8px 10px;background:#f6f7f7;border-radius:6px;">
                        <p style="font-size:11px;font-weight:600;color:#50575e;margin:0 0 4px;">Current role permissions:</p>
                        @if($admin->role->is_super_admin)
                            <p style="font-size:12px;color:#1d4ed8;margin:0;">All permissions (Super Admin)</p>
                        @else
                            <p style="font-size:12px;color:#1d2327;margin:0;">
                                {{ count($admin->role->permissions ?? []) }} permissions assigned
                            </p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            {{-- Info box (edit mode) --}}
            @if($isEdit)
            <div class="wp-panel">
                <div class="wp-section-heading">Account Info</div>
                <div class="wp-panel-body px-4 py-3" style="font-size:12px;color:#50575e;line-height:1.8;">
                    <div><strong style="color:#1d2327;">Created:</strong> {{ $admin->created_at->format('d M Y') }}</div>
                    <div><strong style="color:#1d2327;">Updated:</strong> {{ $admin->updated_at->format('d M Y') }}</div>
                    @if(Auth::guard('admin')->id() === $admin->id)
                    <div style="margin-top:8px;padding:6px 8px;background:#fff8e1;border-radius:4px;color:#92400e;font-size:11px;">
                        <i class="fas fa-circle-info mr-1"></i> This is your account.
                    </div>
                    @endif
                </div>
            </div>
            @endif

        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
function togglePw(id, btn) {
    var inp = document.getElementById(id);
    var ico = btn.querySelector('i');
    if (inp.type === 'password') {
        inp.type = 'text';
        ico.className = 'fas fa-eye-slash';
    } else {
        inp.type = 'password';
        ico.className = 'fas fa-eye';
    }
}
</script>
@endpush
