@extends('Admin.Layout.app')

@section('title', 'Messages')
@section('page_title', 'Contact Messages')

@push('styles')
<style>
    body.font-sans { background: #f0f0f1 !important; }
    main { background: #f0f0f1 !important; }
    .wp-list-table { border: 1px solid #c3c4c7; background: #fff; box-shadow: 0 1px 1px rgba(0,0,0,.04); width: 100%; border-collapse: collapse; }
    .wp-list-table thead th { background: #fff; color: #2c3338; font-weight: 600; font-size: 13px; padding: 10px 8px; border-bottom: 1px solid #c3c4c7; text-align: left; }
    .wp-list-table tbody td { font-size: 13px; padding: 12px 8px; vertical-align: top; color: #2c3338; border-bottom: 1px solid #f0f0f1; }
    .wp-list-table tbody tr:hover { background: #f6f7f7; }
    .wp-list-table tbody tr.unread td { background: #fffbeb; font-weight: 500; }
    .wp-list-table tbody tr.unread:hover td { background: #fef3c7; }
    .wp-subtab { font-size: 13px; }
    .wp-subtab a { color: #2271b1; }
    .wp-subtab a.current { color: #000; font-weight: 600; }
    .wp-input { padding: 6px 10px; font-size: 13px; border: 1px solid #8c8f94; border-radius: 4px; background: #fff; outline: none; line-height: 1.4; }
    .wp-input:focus { border-color: #2271b1; box-shadow: 0 0 0 1px #2271b1; }
    .wp-btn { padding: 5px 11px; font-size: 13px; font-weight: 500; border-radius: 3px; cursor: pointer; border: 1px solid #2271b1; background: #f6f7f7; color: #2271b1; line-height: 1.4; }
    .wp-btn:hover { background: #f0f0f1; }
    .msg-pill { display: inline-flex; align-items: center; gap: 4px; padding: 2px 10px; font-size: 11px; font-weight: 600; border-radius: 12px; text-transform: capitalize; }
    .pill-new { background: #fef3c7; color: #b45309; }
    .pill-read { background: #e0e7ff; color: #4338ca; }
    .pill-replied { background: #dcfce7; color: #15803d; }
    .pill-archived { background: #f1f5f9; color: #475569; }
    .msg-preview { color: #50575e; font-size: 12.5px; max-width: 380px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .summary-card { background: #fff; border: 1px solid #c3c4c7; padding: 14px 16px; border-radius: 4px; }
    .summary-card .lbl { font-size: 12px; color: #50575e; text-transform: uppercase; letter-spacing: .04em; font-weight: 600; }
    .summary-card .val { font-size: 22px; color: #1d2327; font-weight: 700; margin-top: 4px; }
</style>
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif

<div class="flex items-center gap-3 mb-4">
    <h1 class="text-[23px] font-normal text-[#1d2327] m-0">Messages</h1>
    @if ($search)
        <span class="text-[14px] text-[#50575e]">Search results for: <strong>"{{ $search }}"</strong></span>
    @endif
</div>

<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">
    <div class="summary-card">
        <div class="lbl">Total</div>
        <div class="val">{{ number_format($counts['all']) }}</div>
    </div>
    <div class="summary-card">
        <div class="lbl">New (Unread)</div>
        <div class="val text-amber-700">{{ number_format($counts['new']) }}</div>
    </div>
    <div class="summary-card">
        <div class="lbl">Replied</div>
        <div class="val text-emerald-700">{{ number_format($counts['replied']) }}</div>
    </div>
    <div class="summary-card">
        <div class="lbl">Archived</div>
        <div class="val text-slate-500">{{ number_format($counts['archived']) }}</div>
    </div>
</div>

@php
    $tabs = [
        ['key' => 'all',      'label' => 'All',      'count' => $counts['all']],
        ['key' => 'new',      'label' => 'New',      'count' => $counts['new']],
        ['key' => 'read',     'label' => 'Read',     'count' => $counts['read']],
        ['key' => 'replied',  'label' => 'Replied',  'count' => $counts['replied']],
        ['key' => 'archived', 'label' => 'Archived', 'count' => $counts['archived']],
    ];
@endphp

<ul class="flex items-center flex-wrap gap-x-1 wp-subtab mb-3">
    @foreach ($tabs as $i => $tab)
        <li class="flex items-center">
            @if ($i > 0) <span class="text-[#c3c4c7] mx-1.5">|</span> @endif
            <a href="{{ route('admin.contact-messages.index', array_filter(['status' => $tab['key'] === 'all' ? null : $tab['key'], 's' => $search ?: null])) }}"
               class="{{ $status === $tab['key'] ? 'current' : '' }}">
                {{ $tab['label'] }} <span class="text-[#646970]">({{ $tab['count'] }})</span>
            </a>
        </li>
    @endforeach
</ul>

<form method="POST" action="{{ route('admin.contact-messages.bulk-action') }}" id="bulkForm">
    @csrf
    <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
        <div class="flex items-center gap-2">
            <select name="action" class="wp-input">
                <option value="">Bulk actions</option>
                <option value="read">Mark as Read</option>
                <option value="replied">Mark as Replied</option>
                <option value="archived">Archive</option>
                <option value="delete">Delete Permanently</option>
            </select>
            <button type="submit" class="wp-btn" onclick="return confirmBulk(this.form)">Apply</button>
        </div>
        <form method="GET" action="{{ route('admin.contact-messages.index') }}" class="flex items-center gap-2">
            <input type="hidden" name="status" value="{{ $status }}">
            <input type="search" name="s" value="{{ $search }}" placeholder="Search name, email, message..." class="wp-input" style="width:260px">
            <button type="submit" class="wp-btn">Search</button>
        </form>
    </div>

    <table class="wp-list-table">
        <thead>
            <tr>
                <th style="width:30px"><input type="checkbox" id="selectAll"></th>
                <th>From</th>
                <th>Subject / Message</th>
                <th style="width:110px">Status</th>
                <th style="width:140px">Received</th>
                <th style="width:80px"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($messages as $m)
                <tr class="{{ $m->status === 'new' ? 'unread' : '' }}">
                    <td><input type="checkbox" name="ids[]" value="{{ $m->id }}"></td>
                    <td>
                        <a href="{{ route('admin.contact-messages.show', $m) }}" class="font-semibold text-[#2271b1] hover:text-[#135e96]">
                            {{ $m->name }}
                        </a>
                        <div class="text-[12px] text-[#50575e]">{{ $m->email }}</div>
                        @if ($m->phone)
                            <div class="text-[12px] text-[#50575e]">{{ $m->phone }}</div>
                        @endif
                    </td>
                    <td>
                        @if ($m->subject)
                            <div class="font-medium">{{ $m->subject }}</div>
                        @endif
                        <div class="msg-preview">{{ \Illuminate\Support\Str::limit($m->message, 90) }}</div>
                    </td>
                    <td>
                        <span class="msg-pill pill-{{ $m->status }}">{{ $m->status }}</span>
                    </td>
                    <td class="text-[12px] text-[#50575e]">
                        {{ $m->created_at->format('M j, Y') }}<br>
                        {{ $m->created_at->format('g:i A') }}
                    </td>
                    <td>
                        <a href="{{ route('admin.contact-messages.show', $m) }}" class="wp-btn wp-btn-primary" style="background:#2271b1;color:#fff;display:inline-block">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-12">
                        <i class="fas fa-inbox text-4xl text-slate-300 block mb-3"></i>
                        <p class="text-[14px] text-[#50575e]">No messages found.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</form>

<div class="mt-3">{{ $messages->links() }}</div>

<script>
    document.getElementById('selectAll')?.addEventListener('change', function() {
        document.querySelectorAll('input[name="ids[]"]').forEach(cb => cb.checked = this.checked);
    });
    function confirmBulk(form) {
        const action = form.querySelector('[name="action"]').value;
        if (!action) { alert('Choose a bulk action.'); return false; }
        const checked = form.querySelectorAll('input[name="ids[]"]:checked');
        if (checked.length === 0) { alert('Select at least one message.'); return false; }
        if (action === 'delete') return confirm('Delete ' + checked.length + ' message(s) permanently?');
        return true;
    }
</script>

@endsection
