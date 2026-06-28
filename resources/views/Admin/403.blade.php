@extends('Admin.Layout.app')

@section('title', '403 — Access Denied')
@section('page_title', 'Access Denied')

@section('content')
<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:60vh;text-align:center;padding:40px 20px;">

    <div style="width:80px;height:80px;border-radius:50%;background:#fef2f2;border:2px solid #fecaca;
                display:flex;align-items:center;justify-content:center;margin-bottom:24px;">
        <i class="fas fa-lock" style="font-size:32px;color:#dc2626;"></i>
    </div>

    <h1 style="font-size:22px;font-weight:700;color:#1d2327;margin:0 0 8px;">Access Denied</h1>
    <p style="font-size:14px;color:#50575e;margin:0 0 6px;max-width:420px;line-height:1.6;">
        You don't have permission to access this page.
    </p>

    @if(!empty($permission))
    <p style="font-size:12px;color:#94a3b8;margin:0 0 28px;">
        Required permission: <code style="background:#f1f5f9;padding:2px 8px;border-radius:4px;font-family:monospace;color:#5E2590;">{{ $permission }}</code>
    </p>
    @endif

    <div style="display:flex;gap:10px;flex-wrap:wrap;justify-content:center;">
        <a href="{{ route('admin.dashboard') }}"
           style="padding:9px 22px;background:#2271b1;color:#fff;border-radius:4px;font-size:13px;font-weight:600;text-decoration:none;">
            <i class="fas fa-gauge-high mr-1.5"></i> Go to Dashboard
        </a>
        <a href="javascript:history.back()"
           style="padding:9px 22px;background:#f6f7f7;color:#2c3338;border:1px solid #c3c4c7;border-radius:4px;font-size:13px;font-weight:500;text-decoration:none;">
            <i class="fas fa-arrow-left mr-1.5"></i> Go Back
        </a>
    </div>

    <p style="margin-top:28px;font-size:12px;color:#c3c4c7;">
        If you believe this is a mistake, contact your Super Admin to update your role permissions.
    </p>
</div>
@endsection
