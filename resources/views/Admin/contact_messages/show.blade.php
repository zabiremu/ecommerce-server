@extends('Admin.Layout.app')

@section('title', 'Message')
@section('page_title', 'Contact Message')

@push('styles')
@include('Admin._partials.wp-styles')
<style>
    .msg-meta { font-size: 12.5px; color: #50575e; }
    .msg-body { white-space: pre-wrap; font-size: 14px; line-height: 1.7; color: #1d2327; background: #f8fafc; padding: 18px 22px; border-radius: 6px; border: 1px solid #e2e8f0; }
    .msg-pill { display: inline-flex; align-items: center; gap: 4px; padding: 3px 12px; font-size: 11px; font-weight: 700; border-radius: 100px; text-transform: uppercase; letter-spacing: .5px; }
    .pill-new { background: #fef3c7; color: #b45309; }
    .pill-read { background: #e0e7ff; color: #4338ca; }
    .pill-replied { background: #dcfce7; color: #15803d; }
    .pill-archived { background: #f1f5f9; color: #475569; }
</style>
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif

<div class="flex items-center justify-between gap-3 mb-3">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.contact-messages.index') }}" class="text-[#2271b1] hover:text-[#135e96] text-[13px]">
            <i class="fas fa-arrow-left mr-1"></i> Back to all messages
        </a>
    </div>
    <span class="msg-pill pill-{{ $msg->status }}">{{ $msg->status }}</span>
</div>

<div class="grid grid-cols-12 gap-5">
    <div class="col-span-12 lg:col-span-8 space-y-5">

        <div class="wp-panel">
            <div class="wp-panel-h">
                {{ $msg->subject ?: 'Message from ' . $msg->name }}
            </div>
            <div class="wp-panel-body">
                <div class="msg-meta mb-4">
                    <strong class="text-[#1d2327]">{{ $msg->name }}</strong>
                    &lt;<a href="mailto:{{ $msg->email }}" class="text-[#2271b1]">{{ $msg->email }}</a>&gt;
                    @if ($msg->phone)
                        &middot; <a href="tel:{{ $msg->phone }}">{{ $msg->phone }}</a>
                    @endif
                    <br>
                    {{ $msg->created_at->format('M j, Y \a\t g:i A') }}
                </div>

                <div class="msg-body">{{ $msg->message }}</div>

                <div class="mt-5 flex flex-wrap gap-2">
                    <a href="mailto:{{ $msg->email }}?subject={{ urlencode('RE: ' . ($msg->subject ?: 'Your inquiry')) }}"
                       class="wp-btn wp-btn-primary">
                        <i class="fas fa-reply mr-1"></i> Reply via Email
                    </a>
                    @if ($msg->phone)
                        <a href="tel:{{ $msg->phone }}" class="wp-btn">
                            <i class="fas fa-phone mr-1"></i> Call
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="wp-panel">
            <div class="wp-panel-h">Metadata</div>
            <div class="wp-panel-body text-[13px] text-[#50575e] space-y-1">
                <div><strong>IP:</strong> {{ $msg->ip ?? '—' }}</div>
                <div><strong>User Agent:</strong> <span class="break-all">{{ $msg->user_agent ?? '—' }}</span></div>
                @if ($msg->read_at)
                    <div><strong>Read at:</strong> {{ $msg->read_at->format('M j, Y g:i A') }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-4 space-y-5">
        <div class="wp-panel">
            <div class="wp-panel-h">Status</div>
            <div class="wp-panel-body">
                <form method="POST" action="{{ route('admin.contact-messages.status', $msg) }}" class="space-y-3">
                    @csrf @method('PATCH')
                    <select name="status" class="wp-input w-full">
                        @foreach (App\Models\ContactMessage::STATUSES as $s)
                            <option value="{{ $s }}" @selected($msg->status === $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="wp-btn-primary w-full justify-center">Update Status</button>
                </form>
            </div>
        </div>

        <div class="wp-panel">
            <div class="wp-panel-h">Danger Zone</div>
            <div class="wp-panel-body">
                <form method="POST" action="{{ route('admin.contact-messages.destroy', $msg) }}"
                      onsubmit="return confirm('Delete this message permanently? This cannot be undone.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="wp-btn w-full justify-center" style="border-color:#b32d2e;color:#b32d2e;background:#fff">
                        <i class="fas fa-trash mr-1"></i> Delete Permanently
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
