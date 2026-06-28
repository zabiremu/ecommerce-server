@extends('Admin.Layout.app')

@section('title', 'My Profile')
@section('page_title', 'Profile')

@push('styles')
@include('Admin._partials.wp-styles')
<style>
    body.font-sans { background: #f0f0f1 !important; }
    main { background: #f0f0f1 !important; }

    .wp-form-table { width: 100%; border-collapse: collapse; }
    .wp-form-table th { width: 200px; padding: 15px 10px 15px 0; vertical-align: top; text-align: left; font-size: 14px; font-weight: 400; color: #1d2327; line-height: 1.4; }
    .wp-form-table td { padding: 10px 0; vertical-align: top; }
    .wp-form-table td input[type="text"],
    .wp-form-table td input[type="email"] { width: 100%; max-width: 400px; padding: 6px 10px; font-size: 13px; border: 1px solid #8c8f94; border-radius: 4px; background: #fff; outline: none; color: #2c3338; }
    @media (max-width: 640px) {
        .wp-form-table, .wp-form-table tbody, .wp-form-table tr { display: block; width: 100%; }
        .wp-form-table th { display: block; width: 100%; padding: 10px 0 2px; font-weight: 600; font-size: 13px; }
        .wp-form-table td { display: block; width: 100%; padding: 0 0 14px; }
        .wp-form-table td input[type="text"],
        .wp-form-table td input[type="email"] { max-width: 100%; }
        .wp-panel-body.px-6 { padding-left: 12px !important; padding-right: 12px !important; }
    }
    .wp-form-table td input:focus { border-color: #2271b1; box-shadow: 0 0 0 1px #2271b1; }
    .wp-form-table td input.error { border-color: #d63638; box-shadow: 0 0 0 1px #d63638; }
    .description { font-size: 12px; color: #646970; margin-top: 5px; display: block; }
    .error-msg { font-size: 12px; color: #d63638; margin-top: 4px; display: block; }

    .wp-section-heading { font-size: 14px; font-weight: 600; color: #1d2327; padding: 10px 12px; background: #fff; border-bottom: 1px solid #c3c4c7; display: flex; align-items: center; gap: 8px; }
    .wp-avatar { width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #5E2590, #2D1B69); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 28px; font-weight: 700; letter-spacing: -1px; border: 3px solid #fff; box-shadow: 0 0 0 1px #c3c4c7; }

    .submit-row { padding: 14px 0 4px; display: flex; align-items: center; gap: 10px; }
    .notice-success { background: #edf7ed; border-left: 4px solid #00a32a; color: #1d2327; padding: 10px 14px; margin-bottom: 16px; font-size: 13px; display: flex; align-items: center; gap-8px; }
    .notice-error   { background: #fcf0f1; border-left: 4px solid #d63638; color: #1d2327; padding: 10px 14px; margin-bottom: 16px; font-size: 13px; }
</style>
@endpush

@section('content')
@php($admin = Auth::guard('admin')->user())

{{-- Notices --}}
@if (session('success'))
<div class="notice-success mb-4"><i class="fas fa-check-circle text-[#00a32a] mr-2"></i> {{ session('success') }}</div>
@endif
@if ($errors->any())
<div class="notice-error mb-4"><i class="fas fa-circle-exclamation text-[#d63638] mr-2"></i> Please correct the errors below.</div>
@endif

<div class="flex flex-col lg:flex-row gap-5 items-start">

    {{-- ── Main column ─────────────────────────────────── --}}
    <div class="flex-1 min-w-0 space-y-4">

        {{-- Avatar + Name card --}}
        <div class="wp-panel">
            <div class="wp-section-heading">
                <i class="fas fa-user text-[#787c82] text-[12px]"></i>
                Personal Information
            </div>
            <div class="wp-panel-body py-5 px-6">

                {{-- Avatar row --}}
                <div class="flex flex-wrap items-center gap-4 pb-5 mb-5 border-b border-[#f0f0f1]">
                    <div class="wp-avatar">{{ strtoupper(substr($admin->name ?? 'A', 0, 2)) }}</div>
                    <div>
                        <p class="font-semibold text-[15px] text-[#1d2327]">{{ $admin->name }}</p>
                        <p class="text-[13px] text-[#50575e]">{{ $admin->email }}</p>
                        <span class="inline-block mt-1 text-[11px] font-semibold px-2 py-0.5 rounded-sm bg-[#e0e0e0] text-[#2c3338]">Administrator</span>
                    </div>
                </div>

                {{-- Form table --}}
                <form method="POST" action="{{ route('admin.profile.update') }}">
                    @csrf @method('PUT')

                    <table class="wp-form-table">
                        <tr>
                            <th><label for="name">Full Name</label></th>
                            <td>
                                <input type="text" id="name" name="name"
                                       value="{{ old('name', $admin->name) }}"
                                       class="{{ $errors->has('name') ? 'error' : '' }}">
                                @error('name')
                                    <span class="error-msg">{{ $message }}</span>
                                @else
                                    <span class="description">Your full display name shown in the admin panel.</span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th><label for="email">Email Address</label></th>
                            <td>
                                <input type="email" id="email" name="email"
                                       value="{{ old('email', $admin->email) }}"
                                       class="{{ $errors->has('email') ? 'error' : '' }}">
                                @error('email')
                                    <span class="error-msg">{{ $message }}</span>
                                @else
                                    <span class="description">Used for login and admin notifications.</span>
                                @enderror
                            </td>
                        </tr>
                    </table>

                    <div class="submit-row pt-5 mt-1 border-t border-[#f0f0f1]">
                        <button type="submit" class="wp-btn wp-btn-primary">
                            <i class="fas fa-check mr-1.5"></i> Update Profile
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="wp-btn">Cancel</a>
                    </div>
                </form>

            </div>
        </div>

        {{-- Account details --}}
        <div class="wp-panel">
            <div class="wp-section-heading">
                <i class="fas fa-circle-info text-[#787c82] text-[12px]"></i>
                Account Details
            </div>
            <div class="wp-panel-body px-6 py-4">
                <table class="wp-form-table">
                    <tr>
                        <th>Member Since</th>
                        <td class="text-[13px] text-[#2c3338]">{{ $admin->created_at->format('F j, Y') }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>
                            <span class="inline-block text-[11px] font-semibold px-2 py-0.5 rounded-sm bg-[#e0e0e0] text-[#2c3338]">Administrator</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Last Updated</th>
                        <td class="text-[13px] text-[#2c3338]">{{ $admin->updated_at->format('F j, Y \a\t h:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>

    </div>

    {{-- ── Sidebar ──────────────────────────────────────── --}}
    <div class="w-full lg:w-60 lg:shrink-0 space-y-4">

        <div class="wp-panel">
            <div class="wp-section-heading">
                <i class="fas fa-bolt text-[#787c82] text-[12px]"></i>
                Quick Actions
            </div>
            <div class="py-1">
                <a href="{{ route('admin.change-password') }}"
                   class="flex items-center gap-2.5 px-4 py-2.5 text-[13px] text-[#2271b1] hover:bg-[#f6f7f7] border-b border-[#f0f0f1] transition">
                    <i class="fas fa-key text-[11px] text-[#787c82] w-3.5"></i>
                    Change Password
                </a>
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-2.5 px-4 py-2.5 text-[13px] text-[#2271b1] hover:bg-[#f6f7f7] border-b border-[#f0f0f1] transition">
                    <i class="fas fa-gauge text-[11px] text-[#787c82] w-3.5"></i>
                    Dashboard
                </a>
                <a href="{{ route('home') }}" target="_blank"
                   class="flex items-center gap-2.5 px-4 py-2.5 text-[13px] text-[#2271b1] hover:bg-[#f6f7f7] transition">
                    <i class="fas fa-arrow-up-right-from-square text-[11px] text-[#787c82] w-3.5"></i>
                    View Site
                </a>
            </div>
        </div>

        <div class="wp-panel">
            <div class="wp-section-heading">
                <i class="fas fa-shield-halved text-[#787c82] text-[12px]"></i>
                Security
            </div>
            <div class="wp-panel-body py-3 px-4">
                <p class="text-[12px] text-[#50575e] leading-relaxed">
                    Keep your account safe by using a strong, unique password and updating it regularly.
                </p>
                <a href="{{ route('admin.change-password') }}"
                   class="wp-btn wp-btn-primary mt-3 inline-block text-center w-full text-center"
                   style="display:block;text-align:center;margin-top:10px;">
                    <i class="fas fa-lock mr-1"></i> Change Password
                </a>
            </div>
        </div>

    </div>
</div>

@endsection
