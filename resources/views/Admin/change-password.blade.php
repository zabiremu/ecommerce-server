@extends('Admin.Layout.app')

@section('title', 'Change Password')
@section('page_title', 'Change Password')

@push('styles')
@include('Admin._partials.wp-styles')
<style>
    body.font-sans { background: #f0f0f1 !important; }
    main { background: #f0f0f1 !important; }

    .wp-form-table { width: 100%; border-collapse: collapse; }
    .wp-form-table th { width: 200px; padding: 15px 10px 15px 0; vertical-align: top; text-align: left; font-size: 14px; font-weight: 400; color: #1d2327; line-height: 1.4; }
    .wp-form-table td { padding: 10px 0; vertical-align: top; }
    @media (max-width: 640px) {
        .wp-form-table, .wp-form-table tbody, .wp-form-table tr { display: block; width: 100%; }
        .wp-form-table th { display: block; width: 100%; padding: 10px 0 2px; font-weight: 600; font-size: 13px; }
        .wp-form-table td { display: block; width: 100%; padding: 0 0 14px; }
        .pw-wrap, .strength-bar { max-width: 100% !important; }
        .wp-panel-body.px-6 { padding-left: 12px !important; padding-right: 12px !important; }
    }

    .pw-wrap { position: relative; max-width: 400px; }
    .pw-wrap input { width: 100%; padding: 6px 36px 6px 10px; font-size: 13px; border: 1px solid #8c8f94; border-radius: 4px; background: #fff; outline: none; color: #2c3338; font-family: monospace; letter-spacing: 1px; }
    .pw-wrap input:focus { border-color: #2271b1; box-shadow: 0 0 0 1px #2271b1; }
    .pw-wrap input.error { border-color: #d63638; box-shadow: 0 0 0 1px #d63638; }
    .pw-toggle { position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: none; border: 0; cursor: pointer; color: #787c82; font-size: 13px; padding: 2px; }
    .pw-toggle:hover { color: #2271b1; }

    .strength-bar { height: 4px; border-radius: 2px; margin-top: 6px; max-width: 400px; background: #e0e0e0; overflow: hidden; }
    .strength-fill { height: 100%; border-radius: 2px; width: 0%; transition: width .3s, background .3s; }
    .strength-label { font-size: 11px; margin-top: 4px; font-weight: 600; }

    .description { font-size: 12px; color: #646970; margin-top: 5px; display: block; line-height: 1.5; }
    .error-msg { font-size: 12px; color: #d63638; margin-top: 4px; display: block; }
    .wp-section-heading { font-size: 14px; font-weight: 600; color: #1d2327; padding: 10px 12px; background: #fff; border-bottom: 1px solid #c3c4c7; display: flex; align-items: center; gap: 8px; }
    .notice-success { background: #edf7ed; border-left: 4px solid #00a32a; color: #1d2327; padding: 10px 14px; margin-bottom: 16px; font-size: 13px; }
    .notice-error   { background: #fcf0f1; border-left: 4px solid #d63638; color: #1d2327; padding: 10px 14px; margin-bottom: 16px; font-size: 13px; }

    .req-list { list-style: none; padding: 0; margin: 8px 0 0; display: flex; flex-direction: column; gap: 3px; }
    .req-list li { font-size: 12px; color: #787c82; display: flex; align-items: center; gap: 5px; }
    .req-list li.met { color: #00a32a; }
    .req-list li i { font-size: 10px; width: 12px; }
</style>
@endpush

@section('content')
@php($admin = Auth::guard('admin')->user())

{{-- Notices --}}
@if (session('success'))
<div class="notice-success"><i class="fas fa-check-circle text-[#00a32a] mr-2"></i> {{ session('success') }}</div>
@endif
@if ($errors->any())
<div class="notice-error"><i class="fas fa-circle-exclamation text-[#d63638] mr-2"></i> Please correct the errors below.</div>
@endif

<div class="flex flex-col lg:flex-row gap-5 items-start">

    {{-- ── Main column ─────────────────────────────────── --}}
    <div class="flex-1 min-w-0 space-y-4">

        <div class="wp-panel">
            <div class="wp-section-heading">
                <i class="fas fa-lock text-[#787c82] text-[12px]"></i>
                Change Your Password
            </div>
            <div class="wp-panel-body py-5 px-6">

                <form method="POST" action="{{ route('admin.password.update') }}" id="pwForm">
                    @csrf @method('PUT')

                    <table class="wp-form-table">

                        {{-- Current password --}}
                        <tr>
                            <th><label for="current_password">Current Password</label></th>
                            <td>
                                <div class="pw-wrap">
                                    <input type="password" id="current_password" name="current_password"
                                           autocomplete="current-password"
                                           class="{{ $errors->has('current_password') ? 'error' : '' }}">
                                    <button type="button" class="pw-toggle" onclick="togglePw('current_password', this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <span class="error-msg">{{ $message }}</span>
                                @else
                                    <span class="description">Enter your current password to confirm your identity.</span>
                                @enderror
                            </td>
                        </tr>

                        {{-- New password --}}
                        <tr>
                            <th><label for="password">New Password</label></th>
                            <td>
                                <div class="pw-wrap">
                                    <input type="password" id="password" name="password"
                                           autocomplete="new-password"
                                           oninput="checkStrength(this.value)"
                                           class="{{ $errors->has('password') ? 'error' : '' }}">
                                    <button type="button" class="pw-toggle" onclick="togglePw('password', this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>

                                {{-- Strength bar --}}
                                <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                                <div class="strength-label" id="strengthLabel" style="color:#787c82">Enter a new password</div>

                                @error('password')
                                    <span class="error-msg">{{ $message }}</span>
                                @enderror

                                {{-- Requirements checklist --}}
                                <ul class="req-list" id="reqList">
                                    <li id="req-len"><i class="fas fa-circle"></i> At least 8 characters</li>
                                    <li id="req-upper"><i class="fas fa-circle"></i> Uppercase letter (A–Z)</li>
                                    <li id="req-lower"><i class="fas fa-circle"></i> Lowercase letter (a–z)</li>
                                    <li id="req-num"><i class="fas fa-circle"></i> Number (0–9)</li>
                                    <li id="req-sym"><i class="fas fa-circle"></i> Special character (!@#$…)</li>
                                </ul>
                            </td>
                        </tr>

                        {{-- Confirm password --}}
                        <tr>
                            <th><label for="password_confirmation">Confirm New Password</label></th>
                            <td>
                                <div class="pw-wrap">
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                           autocomplete="new-password"
                                           oninput="checkMatch()">
                                    <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation', this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <span class="description" id="matchMsg">Re-enter the new password to confirm.</span>
                            </td>
                        </tr>

                    </table>

                    <div class="flex items-center gap-3 pt-5 mt-1 border-t border-[#f0f0f1]">
                        <button type="submit" class="wp-btn wp-btn-primary">
                            <i class="fas fa-lock mr-1.5"></i> Update Password
                        </button>
                        <a href="{{ route('admin.profile') }}" class="wp-btn">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

    </div>

    {{-- ── Sidebar ──────────────────────────────────────── --}}
    <div class="w-full lg:w-60 lg:shrink-0 space-y-4">

        <div class="wp-panel">
            <div class="wp-section-heading">
                <i class="fas fa-user text-[#787c82] text-[12px]"></i>
                Your Account
            </div>
            <div class="wp-panel-body px-4 py-3">
                <div class="flex items-center gap-3 mb-3">
                    <div style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#5E2590,#2D1B69);display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;font-weight:700;flex-shrink:0;">
                        {{ strtoupper(substr($admin->name ?? 'A', 0, 2)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-[13px] text-[#1d2327] truncate">{{ $admin->name }}</p>
                        <p class="text-[11px] text-[#50575e] truncate">{{ $admin->email }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.profile') }}"
                   class="wp-btn" style="width:100%;display:block;text-align:center;">
                    <i class="fas fa-user-pen mr-1"></i> Edit Profile
                </a>
            </div>
        </div>

        <div class="wp-panel">
            <div class="wp-section-heading">
                <i class="fas fa-shield-halved text-[#787c82] text-[12px]"></i>
                Password Tips
            </div>
            <div class="wp-panel-body px-4 py-3">
                <ul style="list-style:disc;padding-left:16px;margin:0;font-size:12px;color:#50575e;line-height:2;">
                    <li>Use at least 8 characters</li>
                    <li>Mix letters, numbers & symbols</li>
                    <li>Avoid common words or names</li>
                    <li>Don't reuse old passwords</li>
                </ul>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
function togglePw(id, btn) {
    const inp = document.getElementById(id);
    const ico = btn.querySelector('i');
    if (inp.type === 'password') {
        inp.type = 'text';
        ico.className = 'fas fa-eye-slash';
    } else {
        inp.type = 'password';
        ico.className = 'fas fa-eye';
    }
}

function checkStrength(val) {
    const fill  = document.getElementById('strengthFill');
    const label = document.getElementById('strengthLabel');

    const reqs = {
        len:   val.length >= 8,
        upper: /[A-Z]/.test(val),
        lower: /[a-z]/.test(val),
        num:   /[0-9]/.test(val),
        sym:   /[^A-Za-z0-9]/.test(val),
    };

    Object.entries(reqs).forEach(([k, met]) => {
        const li = document.getElementById('req-' + k);
        if (!li) return;
        li.classList.toggle('met', met);
        li.querySelector('i').className = met ? 'fas fa-check-circle' : 'fas fa-circle';
    });

    const score = Object.values(reqs).filter(Boolean).length;
    const levels = [
        { pct: 0,   color: '#e0e0e0', text: 'Enter a new password',  c: '#787c82' },
        { pct: 20,  color: '#d63638', text: 'Very Weak',              c: '#d63638' },
        { pct: 40,  color: '#dba617', text: 'Weak',                   c: '#dba617' },
        { pct: 60,  color: '#f0b849', text: 'Fair',                   c: '#b45309' },
        { pct: 80,  color: '#00a32a', text: 'Strong',                 c: '#00a32a' },
        { pct: 100, color: '#007017', text: 'Very Strong',            c: '#007017' },
    ];
    const lvl = val.length === 0 ? levels[0] : levels[score];
    fill.style.width      = lvl.pct + '%';
    fill.style.background = lvl.color;
    label.textContent     = lvl.text;
    label.style.color     = lvl.c;

    checkMatch();
}

function checkMatch() {
    const pw   = document.getElementById('password').value;
    const conf = document.getElementById('password_confirmation').value;
    const msg  = document.getElementById('matchMsg');
    if (!conf) { msg.style.color = '#646970'; msg.textContent = 'Re-enter the new password to confirm.'; return; }
    if (pw === conf) {
        msg.style.color = '#00a32a';
        msg.textContent = '✓ Passwords match.';
    } else {
        msg.style.color = '#d63638';
        msg.textContent = '✗ Passwords do not match.';
    }
}
</script>
@endpush
