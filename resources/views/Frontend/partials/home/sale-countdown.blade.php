{{-- Sale countdown — "STOCK CLEARANCE SALE / UP TO 60% OFF / 10 Days 11 Hrs…".
     Managed in Admin → Home Page → Deals Banner. Renders only while the timer
     is running (see DealsBanner::live()); hides itself the moment it hits zero.
     Desktop: centered over the hero image. Mobile: a full-width strip under it. --}}
@if(!empty($saleCountdown))
@php
    $cd = $saleCountdown;
    // Remaining seconds measured on the server, so a wrong clock on the
    // shopper's phone can't show the wrong time left.
    $cdRemaining = max(0, now()->diffInSeconds($cd->ends_at, false));
    $cdLink = $cd->button_link ?: route('offers');
@endphp
<div class="gms-sale-cd" id="gms-sale-cd" data-remaining="{{ (int) $cdRemaining }}" role="region" aria-label="Sale countdown">
    <div class="gms-sale-cd-card">
        <p class="gms-sale-cd-eyebrow">@if($cd->emoji){{ $cd->emoji }} @endif{{ $cd->title }}</p>
        @if($cd->title_highlight)
            <h2 class="gms-sale-cd-headline">{{ $cd->title_highlight }}</h2>
        @endif
        @if($cd->description)
            <p class="gms-sale-cd-desc">{{ $cd->description }}</p>
        @endif

        <div class="gms-sale-cd-timer" aria-live="off">
            <div class="gms-sale-cd-unit"><span class="gms-sale-cd-num" data-cd="d">00</span><span class="gms-sale-cd-lbl">Days</span></div>
            <span class="gms-sale-cd-sep">:</span>
            <div class="gms-sale-cd-unit"><span class="gms-sale-cd-num" data-cd="h">00</span><span class="gms-sale-cd-lbl">Hrs</span></div>
            <span class="gms-sale-cd-sep">:</span>
            <div class="gms-sale-cd-unit"><span class="gms-sale-cd-num" data-cd="m">00</span><span class="gms-sale-cd-lbl">Min</span></div>
            <span class="gms-sale-cd-sep">:</span>
            <div class="gms-sale-cd-unit"><span class="gms-sale-cd-num" data-cd="s">00</span><span class="gms-sale-cd-lbl">Sec</span></div>
        </div>

        @if($cd->button_text)
            <a href="{{ $cdLink }}" class="gms-sale-cd-btn">{{ $cd->button_text }}</a>
        @endif
    </div>
</div>

<style>
.gms-hero-wrap { position: relative; }
/* Until the hero image has loaded the slider is 0px tall — keep room for the
   card so it never floats over the sections below. */
.gms-hero-wrap.has-sale-countdown { min-height: 440px; background: #111; }
.gms-sale-cd {
    /* Centered over the hero, but never lower than the first screen —
       tall hero images would otherwise push the timer below the fold. */
    position: absolute; top: 0; left: 0; right: 0; z-index: 5;
    height: min(100%, calc(100vh - 70px));
    display: flex; align-items: center; justify-content: center;
    padding: 24px; pointer-events: none;
}
.gms-sale-cd-card {
    pointer-events: auto; text-align: center; color: #fff;
    padding: 28px 40px 30px; border-radius: 18px;
    background: rgba(10, 10, 12, .55);
    -webkit-backdrop-filter: blur(6px); backdrop-filter: blur(6px);
    box-shadow: 0 18px 50px rgba(0,0,0,.35);
    max-width: 560px; width: 100%;
}
.gms-sale-cd-eyebrow {
    margin: 0 0 6px; color: #ff8a3d; font-size: 14px; font-weight: 700;
    letter-spacing: .14em; text-transform: uppercase;
}
.gms-sale-cd-headline {
    margin: 0 0 6px; color: #fff; font-size: clamp(30px, 4.2vw, 48px);
    font-weight: 800; line-height: 1.05; text-transform: uppercase; letter-spacing: .01em;
}
.gms-sale-cd-desc { margin: 4px 0 0; font-size: 14px; color: rgba(255,255,255,.85); }
.gms-sale-cd-timer {
    display: flex; justify-content: center; align-items: flex-start; gap: 10px;
    margin: 18px 0 20px;
}
.gms-sale-cd-unit { display: flex; flex-direction: column; align-items: center; min-width: 58px; }
.gms-sale-cd-num {
    font-size: clamp(26px, 3vw, 36px); font-weight: 800; line-height: 1;
    font-variant-numeric: tabular-nums; color: #fff;
}
.gms-sale-cd-lbl { margin-top: 6px; font-size: 12px; color: rgba(255,255,255,.75); letter-spacing: .04em; }
.gms-sale-cd-sep { font-size: 26px; font-weight: 700; line-height: 1; color: rgba(255,255,255,.45); padding-top: 2px; }
.gms-sale-cd-btn {
    display: inline-block; padding: 11px 26px; border: 2px solid #fff; border-radius: 8px;
    color: #fff !important; font-weight: 700; font-size: 14px; text-decoration: none;
    transition: background .15s, color .15s;
}
.gms-sale-cd-btn:hover { background: #fff; color: #111 !important; }

/* Phones: the hero image is short, so put the countdown in its own strip below it. */
@media (max-width: 768.98px) {
    .gms-hero-wrap.has-sale-countdown { min-height: 0; background: none; }
    .gms-sale-cd { position: static; height: auto; padding: 0; }
    .gms-sale-cd-card {
        max-width: none; border-radius: 0; padding: 20px 16px 22px;
        background: #111;
        -webkit-backdrop-filter: none; backdrop-filter: none;
        /* paint the dark strip edge-to-edge like the hero, without changing layout width */
        box-shadow: 0 0 0 100vmax #111; clip-path: inset(0 -100vmax);
    }
    .gms-sale-cd-eyebrow { font-size: 12px; }
    .gms-sale-cd-timer { gap: 6px; margin: 14px 0 16px; }
    .gms-sale-cd-unit { min-width: 48px; }
    .gms-sale-cd-sep { font-size: 22px; }
}
</style>

<script>
(function () {
    var root = document.getElementById('gms-sale-cd');
    if (!root) return;
    var endAt = Date.now() + (parseInt(root.getAttribute('data-remaining'), 10) || 0) * 1000;
    var els = {};
    ['d', 'h', 'm', 's'].forEach(function (k) { els[k] = root.querySelector('[data-cd="' + k + '"]'); });
    function pad(n) { return (n < 10 ? '0' : '') + n; }
    function tick() {
        var left = Math.max(0, Math.floor((endAt - Date.now()) / 1000));
        els.d.textContent = pad(Math.floor(left / 86400));
        els.h.textContent = pad(Math.floor(left % 86400 / 3600));
        els.m.textContent = pad(Math.floor(left % 3600 / 60));
        els.s.textContent = pad(left % 60);
        if (left <= 0) {
            // Sale over — remove the overlay without a reload.
            clearInterval(timer);
            root.remove();
            var wrap = document.querySelector('.gms-hero-wrap');
            if (wrap) wrap.classList.remove('has-sale-countdown');
        }
    }
    var timer = setInterval(tick, 1000);
    tick();
})();
</script>
@endif
