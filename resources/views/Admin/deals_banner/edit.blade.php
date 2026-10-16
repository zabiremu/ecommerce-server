@extends('Admin.Layout.app')

@section('title', 'Deals Banner & Sale Countdown')
@section('page_title', 'Deals Banner & Sale Countdown')

@push('styles')
@include('Admin._partials.wp-styles')
<style>
    .deal-preview { background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%); color: #fff; padding: 36px 28px; border-radius: 6px; text-align: center; }
    .deal-preview h2 { font-size: 26px; font-weight: 700; margin: 0 0 8px; }
    .deal-preview h2 span { background: rgba(255,255,255,.2); padding: 2px 10px; border-radius: 4px; }
    .deal-preview p { font-size: 14px; opacity: .95; margin: 0 0 14px; }
    .deal-preview a { display: inline-block; background: #fff; color: #ee5a52; padding: 8px 20px; border-radius: 4px; font-weight: 600; font-size: 13px; text-decoration: none; }

    /* Live preview — mirrors the homepage hero countdown */
    .cd-preview { position: relative; border-radius: 8px; overflow: hidden; padding: 34px 16px; text-align: center;
        background: radial-gradient(ellipse at center, #3a3f47 0%, #15171b 75%); }
    .cd-preview-card { display: inline-block; color: #fff; padding: 22px 30px 24px; border-radius: 14px; background: rgba(10,10,12,.55); min-width: 320px; }
    .cd-preview-eyebrow { color: #ff8a3d; font-size: 12px; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; margin: 0 0 4px; }
    .cd-preview-headline { font-size: 30px; font-weight: 800; text-transform: uppercase; line-height: 1.05; margin: 0 0 4px; }
    .cd-preview-desc { font-size: 12.5px; opacity: .85; margin: 0; }
    .cd-preview-timer { display: flex; justify-content: center; gap: 8px; margin: 14px 0 16px; }
    .cd-preview-timer div { display: flex; flex-direction: column; align-items: center; min-width: 46px; }
    .cd-preview-timer b { font-size: 24px; font-variant-numeric: tabular-nums; line-height: 1; }
    .cd-preview-timer small { font-size: 11px; opacity: .75; margin-top: 4px; }
    .cd-preview-btn { display: inline-block; border: 2px solid #fff; border-radius: 7px; padding: 7px 18px; font-size: 12.5px; font-weight: 700; }
    .cd-state { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; padding: 3px 10px; border-radius: 999px; }
    .cd-state::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: currentColor; }
    .cd-state-live { background: #e7f6ec; color: #13803b; }
    .cd-state-scheduled { background: #eef4ff; color: #2459c7; }
    .cd-state-ended, .cd-state-disabled, .cd-state-no-timer { background: #f1f1f1; color: #646970; }
    .cd-preset { font-size: 12px; padding: 4px 10px; border: 1px solid #c3c4c7; border-radius: 4px; background: #fff; cursor: pointer; }
    .cd-preset:hover { border-color: #2271b1; color: #2271b1; }
</style>
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif

<div class="flex items-center gap-3 mb-3">
    <h1 class="wp-h1">Deals Banner &amp; Sale Countdown</h1>
</div>

<form method="POST" action="{{ route('admin.deals-banner.update') }}">
    @csrf @method('PUT')

    @if ($errors->any())
        <div class="mb-4 px-3 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">
            <ul class="list-disc list-inside">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="grid grid-cols-12 gap-5 mt-3">
        <div class="col-span-12 lg:col-span-8 space-y-5">

            <div class="wp-panel">
                <div class="wp-panel-h">Banner Content</div>
                <div class="wp-panel-body">
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                        <div class="wp-field sm:col-span-1">
                            <label>Emoji</label>
                            <input type="text" name="emoji" value="{{ old('emoji', $banner->emoji) }}" maxlength="10" class="wp-input" placeholder="🔥">
                            <p class="wp-help">Shown before the title.</p>
                        </div>
                        <div class="wp-field sm:col-span-3">
                            <label>Title <span class="text-[#d63638]">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $banner->title) }}" required maxlength="255" class="wp-input" placeholder="e.g. Limited Time">
                        </div>
                    </div>

                    <div class="wp-field">
                        <label>Highlighted Word(s)</label>
                        <input type="text" name="title_highlight" value="{{ old('title_highlight', $banner->title_highlight) }}" maxlength="255" class="wp-input" placeholder="e.g. Mega Deals">
                        <p class="wp-help">Shown next to the title with a colored highlight.</p>
                    </div>

                    <div class="wp-field">
                        <label>Description</label>
                        <textarea name="description" rows="3" maxlength="1000" class="wp-input">{{ old('description', $banner->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="wp-field">
                            <label>Button Text</label>
                            <input type="text" name="button_text" value="{{ old('button_text', $banner->button_text) }}" maxlength="100" class="wp-input" placeholder="e.g. Grab Your Deal">
                        </div>
                        <div class="wp-field">
                            <label>Button Link</label>
                            <input type="text" name="button_link" value="{{ old('button_link', $banner->button_link) }}" maxlength="500" class="wp-input" placeholder="e.g. /offers/clearance">
                            <p class="wp-help">Empty = the All Offers page.</p>
                        </div>
                    </div>
                </div>
            </div>

            @php
                $tz = \App\Models\DealsBanner::LOCAL_TZ;
                $startsLocal = $banner->starts_at?->copy()->setTimezone($tz)->format('Y-m-d\\TH:i');
                $endsLocal   = $banner->ends_at?->copy()->setTimezone($tz)->format('Y-m-d\\TH:i');
                $state = $banner->countdownState();
                $stateLabel = [
                    'live'      => 'Live on homepage',
                    'scheduled' => 'Scheduled — starts ' . $banner->starts_at?->copy()->setTimezone($tz)->format('d M, h:i A'),
                    'ended'     => 'Sale ended — hidden',
                    'disabled'  => 'Turned off — hidden',
                    'no-timer'  => 'No end time — hidden',
                ][$state];
            @endphp
            <div class="wp-panel" id="sale-countdown-panel">
                <div class="wp-panel-h flex items-center justify-between">
                    <span><i class="fas fa-stopwatch mr-1"></i> Sale Countdown Timer</span>
                    <span class="cd-state cd-state-{{ $state }}">{{ $stateLabel }}</span>
                </div>
                <div class="wp-panel-body">
                    <p class="wp-help" style="margin-top:0">
                        Set an end time to show this banner with a live countdown on top of the homepage hero
                        (e.g. a Stock Clearance or Eid sale). It disappears automatically when the timer reaches zero.
                        Times are Bangladesh time.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-2">
                        <div class="wp-field">
                            <label>Sale Starts <span class="text-[#646970] font-normal">(optional)</span></label>
                            <input type="datetime-local" name="starts_at" id="cd-starts" value="{{ old('starts_at', $startsLocal) }}" class="wp-input">
                            <p class="wp-help">Leave empty to start right away.</p>
                        </div>
                        <div class="wp-field">
                            <label>Sale Ends</label>
                            <input type="datetime-local" name="ends_at" id="cd-ends" value="{{ old('ends_at', $endsLocal) }}" class="wp-input">
                            <p class="wp-help">The countdown runs to this time.</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-2 mt-1">
                        <span class="text-[12px] text-[#646970]">Quick set end:</span>
                        <button type="button" class="cd-preset" data-hours="24">+1 day</button>
                        <button type="button" class="cd-preset" data-hours="72">+3 days</button>
                        <button type="button" class="cd-preset" data-hours="168">+7 days</button>
                        <button type="button" class="cd-preset" data-hours="240">+10 days</button>
                        <button type="button" class="cd-preset" data-clear="1">Clear timer</button>
                    </div>
                </div>
            </div>

            <div class="wp-panel">
                <div class="wp-panel-h">Live Preview</div>
                <div class="wp-panel-body">
                    <div class="cd-preview">
                        <div class="cd-preview-card">
                            <p class="cd-preview-eyebrow"><span data-pv="emoji">{{ $banner->emoji }}</span> <span data-pv="title">{{ $banner->title }}</span></p>
                            <p class="cd-preview-headline" data-pv="title_highlight">{{ $banner->title_highlight }}</p>
                            <p class="cd-preview-desc" data-pv="description">{{ $banner->description }}</p>
                            <div class="cd-preview-timer">
                                <div><b data-cd="d">00</b><small>Days</small></div>
                                <div><b data-cd="h">00</b><small>Hrs</small></div>
                                <div><b data-cd="m">00</b><small>Min</small></div>
                                <div><b data-cd="s">00</b><small>Sec</small></div>
                            </div>
                            <span class="cd-preview-btn" data-pv="button_text">{{ $banner->button_text }}</span>
                        </div>
                    </div>
                    <p class="wp-help mt-2">Updates as you type. This is how it looks on top of the homepage hero.</p>
                </div>
            </div>

        </div>

        <div class="col-span-12 lg:col-span-4 space-y-5">

            <div class="wp-panel">
                <div class="wp-panel-h">Visibility</div>
                <div class="wp-panel-body">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="status" value="0">
                        <input type="checkbox" name="status" value="1" {{ old('status', $banner->status) ? 'checked' : '' }}>
                        <span class="text-[13px]"><strong>Show on Homepage</strong></span>
                    </label>
                    <p class="wp-help mt-2">Shown over the homepage hero only while the countdown is running.</p>
                </div>
            </div>

            <div class="wp-panel">
                <div class="wp-panel-h">Save</div>
                <div class="wp-panel-body">
                    <button type="submit" class="wp-btn wp-btn-primary w-full">Update Banner</button>
                </div>
            </div>

        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
(function () {
    // Bangladesh time (UTC+6) for the datetime-local inputs, regardless of the admin's PC clock.
    var TZ_OFFSET_MIN = 6 * 60;
    function toLocalInput(date) {
        var d = new Date(date.getTime() + TZ_OFFSET_MIN * 60000);
        return d.toISOString().slice(0, 16);
    }
    function fromLocalInput(v) {
        if (!v) return null;
        return new Date(Date.parse(v + ':00Z') - TZ_OFFSET_MIN * 60000);
    }
    var starts = document.getElementById('cd-starts');
    var ends = document.getElementById('cd-ends');

    document.querySelectorAll('.cd-preset').forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (btn.dataset.clear) { starts.value = ''; ends.value = ''; tick(); return; }
            var base = fromLocalInput(starts.value) || new Date();
            if (base < new Date()) base = new Date();
            ends.value = toLocalInput(new Date(base.getTime() + parseInt(btn.dataset.hours, 10) * 3600000));
            tick();
        });
    });

    // Text fields -> preview
    ['emoji', 'title', 'title_highlight', 'description', 'button_text'].forEach(function (name) {
        var input = document.querySelector('[name="' + name + '"]');
        var target = document.querySelector('[data-pv="' + name + '"]');
        if (!input || !target) return;
        input.addEventListener('input', function () { target.textContent = input.value; });
    });

    function pad(n) { return (n < 10 ? '0' : '') + n; }
    function tick() {
        var end = fromLocalInput(ends.value);
        var left = end ? Math.max(0, Math.floor((end - new Date()) / 1000)) : 0;
        document.querySelector('[data-cd="d"]').textContent = pad(Math.floor(left / 86400));
        document.querySelector('[data-cd="h"]').textContent = pad(Math.floor(left % 86400 / 3600));
        document.querySelector('[data-cd="m"]').textContent = pad(Math.floor(left % 3600 / 60));
        document.querySelector('[data-cd="s"]').textContent = pad(left % 60);
    }
    ends.addEventListener('input', tick);
    setInterval(tick, 1000);
    tick();
})();
</script>
@endpush
