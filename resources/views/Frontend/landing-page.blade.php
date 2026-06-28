@extends('Frontend.Layout.landing')

@section('title', $pageTitle)
@if ($landing->meta_description)
@section('meta_description', $landing->meta_description)
@endif

@push('styles')
<style>
/* ── Theme tokens ─────────────────────────────────────────── */
.lp-page { margin:0; font-family:'Hind Siliguri',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
    background:
        radial-gradient(900px 500px at 0% 0%, rgba(46,139,46,.08), transparent 60%),
        radial-gradient(900px 500px at 100% 0%, rgba(246,195,67,.10), transparent 60%),
        radial-gradient(900px 600px at 50% 100%, rgba(241,99,52,.06), transparent 60%),
        #fbfdfb; }
.lp { --c1:#2e8b2e; --c1-d:#1f6e1f; --c1-d2:#236f23; --c1-l:#3fbf3f; --c1-l2:#46d246; --c1-rgb:46,139,46;
      --c2:#f16334; --c2-d:#e2531f; --c2-l:#ff7a3d; --c2-l2:#ff8a50; --c2-dd:#d8480f; --c2-rgb:241,99,52;
      --gold:#f6c343; --gold2:#f6a623; --gold-rgb:246,195,67; --footer2:#143f14; --urgency1:#7a1f00; --page-bg:#fbfdfb;
      --green:var(--c1); --green-d:var(--c1-d); --ink:#1c1c1c;
      width:100%; max-width:100%; margin:0 auto; background:transparent; color:#1c1c1c; overflow:hidden; }
.lp * { box-sizing:border-box; }
.lp-sec { padding:26px 18px; }
.lp-sec-dark  { background:#ffffff; color:#1c1c1c; }
.lp-sec-green { background:linear-gradient(180deg,var(--c1),var(--c1-d2)); color:#fff; position:relative; }

/* Floating-card feel: lift main sections off the soft mesh background */
.lp-sec-dark, .lp-sec-form, .lp-trust {
    margin:14px 10px; border-radius:18px; box-shadow:0 8px 30px rgba(20,40,20,.06); }
@media(min-width:768px){ .lp-sec-dark, .lp-sec-form, .lp-trust { margin:18px auto; max-width:980px; } }

/* Diagonal wave divider before/after green sections */
.lp-sec-green:before, .lp-sec-green:after { content:""; position:absolute; left:0; right:0; height:26px;
    background:#fbfdfb; }
.lp-sec-green:before { top:-1px; clip-path:polygon(0 100%, 100% 0, 100% 100%); }
.lp-sec-green:after  { bottom:-1px; clip-path:polygon(0 0, 100% 100%, 0 100%); }

/* ── Marquee ─────────────────────────────────────────────── */
.lp-marquee { background:linear-gradient(90deg,var(--gold),var(--gold2),var(--c2),var(--gold2),var(--gold)); background-size:200% 100%;
    animation:lp-marquee-bg 6s linear infinite; overflow:hidden; white-space:nowrap; }
@keyframes lp-marquee-bg { 0%{ background-position:0% 0; } 100%{ background-position:200% 0; } }
.lp-marquee-track { display:inline-block; padding:10px 0; color:#1a1a1a; font-weight:700; font-size:14px;
    animation:lp-scroll 18s linear infinite; }
.lp-marquee-track span { padding:0 26px; }
.lp-marquee-track span:before { content:"🔥 "; }
@keyframes lp-scroll { from{transform:translateX(0)} to{transform:translateX(-50%)} }

/* ── YouTube video ───────────────────────────────────────── */
.lp-vid-title { text-align:center; font-size:clamp(1.05rem,3.4vw,1.5rem); font-weight:700; margin:0 0 14px; color:#1c1c1c; }
.lp-video { position:relative; width:100%; padding-top:56.25%; border-radius:10px; overflow:hidden; background:#111;
    box-shadow:0 0 0 3px rgba(var(--c1-rgb),.45); }
.lp-video iframe { position:absolute; inset:0; width:100%; height:100%; border:0; }
.lp-vid-desc { text-align:center; color:#555; font-size:.95rem; margin:14px 0 0; line-height:1.7; }

/* ── Rounded heading banner ──────────────────────────────── */
.lp-rhead { text-align:center; }
.lp-rhead h2 { margin:0; font-weight:700; line-height:1.4; font-size:clamp(1.05rem,3.6vw,1.45rem); }
.lp-rhead p  { margin:8px 0 0; font-size:.95rem; opacity:.95; }
.lp-rhead-green { background:linear-gradient(135deg,var(--c1-l),var(--c1-d)); color:#fff; border-radius:18px; padding:24px 20px 20px;
    box-shadow:0 10px 26px rgba(var(--c1-rgb),.35), inset 0 1px 0 rgba(255,255,255,.35); }
.lp-rhead-badge { display:inline-flex; align-items:center; justify-content:center; width:46px; height:46px;
    border-radius:50%; background:rgba(255,255,255,.18); font-size:1.4rem; margin-bottom:10px;
    box-shadow:inset 0 0 0 2px rgba(255,255,255,.35); }
.lp-rhead-dark { background:#fff; border-radius:18px; padding:22px 20px; box-shadow:0 8px 24px rgba(0,0,0,.06);
    border:1px solid #eef2ee; }
.lp-rhead-dark h2 { color:#1c1c1c; }
.lp-rhead-dark .lp-rhead-badge { background:linear-gradient(135deg,var(--c1),var(--c1-d)); color:#fff;
    box-shadow:0 6px 14px rgba(var(--c1-rgb),.35); }

/* ── Rich text ───────────────────────────────────────────── */
.lp-richtext { color:#333; font-size:1rem; line-height:1.85; max-width:680px; margin:0 auto; }
.lp-richtext h1,.lp-richtext h2,.lp-richtext h3 { color:#111; margin:14px 0 8px; }
.lp-richtext a { color:var(--green-d); }
.lp-richtext ul,.lp-richtext ol { padding-left:22px; }

/* ── Image ───────────────────────────────────────────────── */
.lp-figure { margin:0; text-align:center; }
.lp-figure img { max-width:100%; border-radius:10px; }
.lp-figure figcaption { color:#666; font-size:.85rem; margin-top:8px; }

/* ── Video thumbnails row ────────────────────────────────── */
.lp-thumbs-row { display:grid; grid-template-columns:repeat(3,1fr); gap:10px; }
@media(max-width:520px){ .lp-thumbs-row{ grid-template-columns:repeat(3,1fr); gap:7px; } }
.lp-thumb { display:block; text-decoration:none; color:#fff; }
.lp-thumb-img { position:relative; display:block; width:100%; padding-top:66%; border-radius:8px; overflow:hidden; background:#000; }
.lp-thumb-img img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; }
.lp-thumb-play { position:absolute; inset:0; margin:auto; width:36px; height:36px; border-radius:50%;
    background:rgba(220,30,30,.92); display:flex; align-items:center; justify-content:center; color:#fff; font-size:13px;
    top:50%; left:50%; transform:translate(-50%,-50%); }
.lp-thumb-label { display:block; text-align:center; font-size:.78rem; margin-top:6px; line-height:1.3; }

/* ── Price offer ─────────────────────────────────────────── */
.lp-sec-green:has(.lp-offer) { background:
        repeating-linear-gradient(135deg, rgba(255,255,255,.05) 0 18px, transparent 18px 36px),
        linear-gradient(180deg,var(--c1),var(--c1-d2)); }
.lp-offer { text-align:center; position:relative; }
.lp-offer-label { font-size:1.05rem; font-weight:600; margin-bottom:6px; }
.lp-offer-prices { display:flex; align-items:baseline; justify-content:center; gap:12px; flex-wrap:wrap; }
.lp-offer-old { text-decoration:line-through; color:#ffd9d9; font-size:1.05rem; opacity:.85; }
.lp-offer-new { color:var(--gold); font-size:clamp(1.6rem,6vw,2.3rem); font-weight:800; }
.lp-offer-note { font-size:.9rem; opacity:.95; margin-top:6px; }

/* ── CTA button ──────────────────────────────────────────── */
.lp-cta-wrap { text-align:center; margin-top:16px; }
.lp-order-btn { display:inline-flex; align-items:center; gap:9px; background:linear-gradient(180deg,var(--c1-l),var(--c1-d));
    color:#fff; font-weight:700; font-size:1.05rem; padding:13px 30px; border-radius:30px; text-decoration:none;
    border:none; cursor:pointer; box-shadow:0 6px 16px rgba(var(--c1-rgb),.5); transition:transform .12s; margin-top:16px; }
.lp-order-btn:hover { transform:translateY(-2px); color:#fff; }

/* ── Order form ──────────────────────────────────────────── */
.lp-sec-form { background:#ffffff; color:#1d2327; padding:0 0 26px; overflow:hidden; }
.lp-form-head { background:linear-gradient(135deg,var(--c1),var(--c1-d),var(--c2)); padding:22px 16px 30px; text-align:center; }
.lp-form-head .lp-form-title { color:#fff; margin:0; }
.lp-form-head .lp-form-title:after { background:linear-gradient(90deg,var(--gold),#fff); }
.lp-form-grid-wrap { padding:0 16px; margin-top:-16px; }
.lp-form-title { text-align:center; font-size:1.2rem; font-weight:700; color:#1d2327; margin:0 0 18px; }
.lp-form-grid { display:grid; grid-template-columns:1fr 1fr; gap:18px; max-width:100%; margin:0 auto; }
@media(max-width:640px){ .lp-form-grid{ grid-template-columns:1fr; } }
.lp-card { background:#fff; border:1px solid #e2e4e7; border-radius:10px; padding:18px; }
.lp-card h3 { font-size:1rem; font-weight:700; margin:0 0 14px; color:#1d2327; }
.lp-fld { margin-bottom:13px; }
.lp-fld label { display:block; font-size:.82rem; font-weight:600; color:#374151; margin-bottom:5px; }
.lp-fld input, .lp-fld textarea { width:100%; padding:10px 12px; font-size:.92rem; border:1px solid #cfd4da; border-radius:7px; outline:none; font-family:inherit; }
.lp-fld input:focus, .lp-fld textarea:focus { border-color:var(--c1); box-shadow:0 0 0 3px rgba(var(--c1-rgb),.15); }
.lp-zone { display:flex; flex-direction:column; gap:8px; }
.lp-zone label { display:flex; align-items:center; justify-content:space-between; gap:10px; padding:10px 12px; border:1px solid #cfd4da; border-radius:8px; cursor:pointer; font-size:.9rem; font-weight:500; }
.lp-zone label.active { border-color:var(--c1); background:rgba(var(--c1-rgb),.06); }
.lp-zone input { width:auto; accent-color:var(--c1); }
.lp-qty { display:flex; align-items:center; gap:10px; }
.lp-qty button { width:34px; height:34px; border:1px solid #cfd4da; background:#f6f7f7; border-radius:7px; cursor:pointer; font-size:1rem; }
.lp-qty input { width:56px; text-align:center; font-weight:700; padding:8px 4px; }
.lp-sum-row { display:flex; justify-content:space-between; padding:9px 0; font-size:.92rem; border-bottom:1px dashed #e2e4e7; }
.lp-sum-row .v { font-weight:600; }
.lp-sum-head { font-weight:700; color:#1d2327; border-bottom:2px solid #1d2327; }
.lp-sum-total { display:flex; justify-content:space-between; padding:12px 0 0; margin-top:6px; border-top:2px solid #1d2327; font-size:1.05rem; font-weight:800; }
.lp-pay { margin-top:14px; }
.lp-pay label { display:flex; align-items:center; gap:9px; padding:11px 12px; border:1px solid #cfd4da; border-radius:8px; cursor:pointer; font-size:.9rem; margin-bottom:8px; }
.lp-pay label.active { border-color:var(--c2); background:rgba(var(--c2-rgb),.06); }
.lp-pay input { accent-color:var(--c2); }
.lp-pay-note { font-size:.8rem; color:#6b7280; margin:-2px 0 10px 4px; }
.lp-confirm { width:100%; margin-top:8px; padding:15px; font-size:1.1rem; font-weight:800; color:#fff;
    background:var(--c2); border:none; border-radius:9px; cursor:pointer; box-shadow:0 6px 16px rgba(var(--c2-rgb),.4); }
.lp-confirm:hover { background:var(--c2-d); }
.lp-confirm:disabled { opacity:.6; cursor:not-allowed; }
.lp-msg { margin-top:12px; padding:11px 14px; border-radius:8px; font-size:.9rem; display:none; }
.lp-oos { text-align:center; background:#fee2e2; color:#991b1b; padding:14px; border-radius:9px; font-weight:700; }

/* ── Footer ──────────────────────────────────────────────── */
.lp-footer { background:linear-gradient(180deg,var(--c1-d2),var(--footer2)); color:#fff; text-align:center; padding:22px 16px; }
.lp-footer-cta { font-size:1.1rem; font-weight:800; margin-bottom:10px; }
.lp-footer-copy { font-size:.8rem; opacity:.8; }

/* ── Eye-catch enhancements ───────────────────────────────── */
.lp-marquee { box-shadow:inset 0 -2px 6px rgba(0,0,0,.12); border-bottom:2px solid rgba(0,0,0,.08); }
.lp-marquee-track { font-weight:800; letter-spacing:.3px; text-shadow:0 1px 0 rgba(255,255,255,.35); }

/* Glossy green banners with shimmer */
.lp-rhead-green { position:relative; background:linear-gradient(135deg,var(--c1-l),var(--c1-d)); border-radius:16px;
    box-shadow:0 10px 26px rgba(var(--c1-rgb),.35), inset 0 1px 0 rgba(255,255,255,.35); overflow:hidden; }
.lp-rhead-green:before { content:""; position:absolute; top:0; left:-45%; width:45%; height:100%;
    background:linear-gradient(120deg,transparent,rgba(255,255,255,.28),transparent); transform:skewX(-18deg);
    animation:lp-shine 3.6s ease-in-out infinite; }
.lp-rhead-green h2 { text-shadow:0 1px 2px rgba(0,0,0,.2); }

/* Video frame */
.lp-video { border-radius:16px; box-shadow:0 14px 36px rgba(0,0,0,.22), 0 0 0 4px rgba(46,139,46,.16); }

/* Review thumbnails */
.lp-thumb-img { box-shadow:0 6px 16px rgba(0,0,0,.25); transition:transform .2s, box-shadow .2s; }
.lp-thumb:hover .lp-thumb-img { transform:translateY(-3px) scale(1.02); box-shadow:0 12px 24px rgba(0,0,0,.35); }
.lp-thumb-play { box-shadow:0 0 0 6px rgba(220,30,30,.25); animation:lp-pulse 1.8s ease-in-out infinite; }
.lp-thumb-label { font-weight:600; }

/* Price offer — make it pop */
.lp-offer-badge { display:inline-block; margin:0 auto 12px; background:#fff200; color:#7a1f00; font-weight:800;
    font-size:.92rem; padding:6px 16px; border-radius:30px; box-shadow:0 4px 12px rgba(0,0,0,.22); transform:rotate(-2deg); }
.lp-offer-old { color:#ffe1e1; }
.lp-offer-new { display:inline-block; text-shadow:0 2px 12px rgba(0,0,0,.28); animation:lp-pop 2s ease-in-out infinite; }

/* CTA buttons — pulse + shine */
.lp-order-btn { position:relative; overflow:hidden; font-size:1.15rem; padding:15px 40px;
    background:linear-gradient(135deg,var(--c1-l2),var(--c1-d)); box-shadow:0 8px 22px rgba(var(--c1-rgb),.55);
    animation:lp-pulse 1.8s ease-in-out infinite; }
.lp-order-btn:after { content:""; position:absolute; top:0; left:-60%; width:50%; height:100%;
    background:linear-gradient(120deg,transparent,rgba(255,255,255,.5),transparent); transform:skewX(-20deg);
    animation:lp-shine 2.8s ease-in-out infinite; }
.lp-order-btn:hover { transform:translateY(-2px) scale(1.02); animation-play-state:paused; }

/* Form heading underline */
.lp-form-title { font-size:clamp(1.3rem,4.2vw,1.8rem); font-weight:800; }
.lp-form-title:after { content:""; display:block; width:74px; height:4px; margin:10px auto 0; border-radius:4px;
    background:linear-gradient(90deg,var(--c1),var(--c2)); }

/* Order form cards — accent + lift */
.lp-card { border:0; border-radius:14px; box-shadow:0 10px 28px rgba(0,0,0,.09); position:relative; overflow:hidden; }
.lp-card:before { content:""; position:absolute; top:0; left:0; right:0; height:4px;
    background:linear-gradient(90deg,var(--c1),var(--gold),var(--c2)); }
.lp-card h3 { padding-top:6px; }
.lp-fld input:focus, .lp-fld textarea:focus { border-color:var(--c2); box-shadow:0 0 0 3px rgba(var(--c2-rgb),.15); }

/* Confirm button — glowing pulse */
.lp-confirm { background:linear-gradient(135deg,var(--c2-l),var(--c2-d)); animation:lp-glow 1.8s ease-in-out infinite; letter-spacing:.3px; }
.lp-confirm:hover { animation-play-state:paused; transform:translateY(-1px); background:linear-gradient(135deg,var(--c2-l2),var(--c2-dd)); }

/* Trust badges strip */
.lp-trust { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; padding:26px 18px; background:#f6faf6; }
@media(max-width:560px){ .lp-trust{ grid-template-columns:1fr; gap:10px; } }
.lp-trust-item { text-align:center; background:#fff; border:1px solid #e7efe7; border-radius:14px; padding:20px 12px;
    box-shadow:0 6px 16px rgba(0,0,0,.05); transition:transform .15s, box-shadow .15s; }
.lp-trust-item:hover { transform:translateY(-4px); box-shadow:0 12px 24px rgba(0,0,0,.1); }
.lp-trust-item i { font-size:1.8rem; color:var(--c1); margin-bottom:9px; display:block; }
.lp-trust-item strong { display:block; font-size:1rem; color:#1c1c1c; margin-bottom:2px; }
.lp-trust-item span { font-size:.82rem; color:#6b7280; }

.lp-footer { box-shadow:inset 0 6px 18px rgba(0,0,0,.15); }

/* ── Urgency / countdown strip ───────────────────────────── */
.lp-urgency { display:flex; align-items:center; justify-content:center; gap:10px; flex-wrap:wrap;
    background:linear-gradient(90deg,var(--urgency1),var(--c2-d)); color:#fff; text-align:center; padding:10px 14px;
    font-weight:700; font-size:.92rem; }
.lp-urgency i { animation:lp-pulse 1.2s ease-in-out infinite; }
.lp-countdown { display:inline-flex; gap:6px; font-weight:800; }
.lp-countdown b { background:rgba(255,255,255,.18); border-radius:6px; padding:2px 7px; min-width:30px; display:inline-block; }

/* ── Scroll reveal ───────────────────────────────────────── */
.lp-reveal { opacity:0; transform:translateY(28px); transition:opacity .7s ease, transform .7s ease; }
.lp-reveal.lp-in { opacity:1; transform:translateY(0); }

/* ── Section divider wave ───────────────────────────────── */
.lp-wave { display:block; width:100%; height:34px; margin:-1px 0; }

/* ── Sticky mobile order bar ────────────────────────────── */
.lp-sticky-bar { display:none; position:fixed; left:0; right:0; bottom:0; z-index:999;
    background:#fff; box-shadow:0 -8px 24px rgba(0,0,0,.15); padding:10px 14px;
    align-items:center; justify-content:space-between; gap:12px; }
.lp-sticky-bar .lp-sticky-price { font-weight:800; color:#1c1c1c; font-size:1.05rem; line-height:1.2; }
.lp-sticky-bar .lp-sticky-price small { display:block; font-size:.72rem; font-weight:600; color:#6b7280; }
.lp-sticky-bar .lp-sticky-btn { flex:1; max-width:220px; text-align:center; background:linear-gradient(135deg,var(--c2-l),var(--c2-d));
    color:#fff; font-weight:800; padding:13px 18px; border-radius:30px; text-decoration:none; font-size:.95rem;
    box-shadow:0 6px 16px rgba(var(--c2-rgb),.45); animation:lp-glow 1.8s ease-in-out infinite; }
@media(max-width:768px){ .lp-sticky-bar{ display:flex; } body{ padding-bottom:0; } .lp-page{ padding-bottom:64px; } }

@keyframes lp-pulse { 0%,100%{ transform:scale(1); } 50%{ transform:scale(1.045); } }
@keyframes lp-pop   { 0%,100%{ transform:scale(1); } 50%{ transform:scale(1.06); } }
@keyframes lp-glow  { 0%,100%{ box-shadow:0 6px 16px rgba(var(--c2-rgb),.45); } 50%{ box-shadow:0 12px 30px rgba(var(--c2-rgb),.8); } }
@keyframes lp-shine { 0%{ left:-60%; } 60%,100%{ left:135%; } }
@media (prefers-reduced-motion: reduce) {
    .lp-order-btn, .lp-confirm, .lp-offer-new, .lp-thumb-play, .lp-rhead-green:before, .lp-order-btn:after, .lp-sticky-bar .lp-sticky-btn, .lp-urgency i { animation:none !important; }
    .lp-reveal { opacity:1; transform:none; transition:none; }
}

/* ── Layout theme palettes ────────────────────────────────── */
.lp-theme-one {
    --c1:#2563eb; --c1-d:#1d4ed8; --c1-d2:#1e3a8a; --c1-l:#3b82f6; --c1-l2:#60a5fa; --c1-rgb:37,99,235;
    --c2:#dc2626; --c2-d:#b91c1c; --c2-l:#f87171; --c2-l2:#fca5a5; --c2-dd:#991b1b; --c2-rgb:220,38,38;
    --gold:#fbbf24; --gold2:#f59e0b; --gold-rgb:251,191,36; --footer2:#0c1f4a; --urgency1:#7f1d1d;
}
.lp-theme-two {
    --c1:#0ea5e9; --c1-d:#0284c7; --c1-d2:#075985; --c1-l:#38bdf8; --c1-l2:#7dd3fc; --c1-rgb:14,165,233;
    --c2:#f97316; --c2-d:#ea580c; --c2-l:#fb923c; --c2-l2:#fdba74; --c2-dd:#c2410c; --c2-rgb:249,115,22;
    --gold:#a78bfa; --gold2:#8b5cf6; --gold-rgb:167,139,250; --footer2:#0c2233; --urgency1:#7c2d12;
}
.lp-theme-three {
    --c1:#9a3412; --c1-d:#7c2d12; --c1-d2:#5b2109; --c1-l:#c2410c; --c1-l2:#ea580c; --c1-rgb:154,52,18;
    --c2:#dc2626; --c2-d:#b91c1c; --c2-l:#f87171; --c2-l2:#fca5a5; --c2-dd:#991b1b; --c2-rgb:220,38,38;
    --gold:#fcd34d; --gold2:#fbbf24; --gold-rgb:252,211,77; --footer2:#3a1408; --urgency1:#450a0a;
}
.lp-theme-four {
    --c1:#7c3aed; --c1-d:#5b21b6; --c1-d2:#4c1d95; --c1-l:#a78bfa; --c1-l2:#c4b5fd; --c1-rgb:124,58,237;
    --c2:#f43f5e; --c2-d:#be123c; --c2-l:#fb7185; --c2-l2:#fda4af; --c2-dd:#9f1239; --c2-rgb:244,63,94;
    --gold:#fbbf24; --gold2:#f59e0b; --gold-rgb:251,191,36; --footer2:#2e1065; --urgency1:#4a044e;
}
.lp-theme-five {
    --c1:#0d9488; --c1-d:#0f766e; --c1-d2:#115e59; --c1-l:#2dd4bf; --c1-l2:#5eead4; --c1-rgb:13,148,136;
    --c2:#f59e0b; --c2-d:#d97706; --c2-l:#fbbf24; --c2-l2:#fcd34d; --c2-dd:#b45309; --c2-rgb:245,158,11;
    --gold:#fde68a; --gold2:#fcd34d; --gold-rgb:253,230,138; --footer2:#042f2e; --urgency1:#78350f;
}
.lp-theme-six {
    --c1:#db2777; --c1-d:#be185d; --c1-d2:#9d174d; --c1-l:#f472b6; --c1-l2:#f9a8d4; --c1-rgb:219,39,119;
    --c2:#f97316; --c2-d:#ea580c; --c2-l:#fb923c; --c2-l2:#fdba74; --c2-dd:#c2410c; --c2-rgb:249,115,22;
    --gold:#fbcfe8; --gold2:#f9a8d4; --gold-rgb:251,207,232; --footer2:#500724; --urgency1:#831843;
}
</style>
@endpush

@section('content')
@php
    $cta     = $landing->cta_text ?: 'অর্ডার করতে চাই';
    $unit    = (float) $current;
    $shipIn  = (float) $landing->shipping_inside_dhaka;
    $shipOut = (float) $landing->shipping_outside_dhaka;
    $blocks  = is_array($landing->blocks) ? $landing->blocks : [];
@endphp

<div class="lp lp-theme-{{ $landing->layout ?? 'default' }}">

    {{-- Marquee --}}
    @if ($landing->hero_subheading)
    <div class="lp-marquee">
        <div class="lp-marquee-track">
            <span>{{ $landing->hero_subheading }}</span><span>{{ $landing->hero_subheading }}</span>
            <span>{{ $landing->hero_subheading }}</span><span>{{ $landing->hero_subheading }}</span>
        </div>
    </div>
    @endif

    {{-- Urgency strip --}}
    <div class="lp-urgency">
        <i class="fas fa-fire"></i> সীমিত সময়ের অফার শেষ হবে —
        <span class="lp-countdown" id="lpCountdown"><b id="lpCdH">00</b>:<b id="lpCdM">00</b>:<b id="lpCdS">00</b></span>
    </div>

    {{-- Blocks --}}
    @foreach ($blocks as $block)
        <div class="lp-reveal">
            @includeIf('Frontend.landing.blocks.' . ($block['type'] ?? 'none'), ['block' => $block, 'cta' => $cta])
        </div>
    @endforeach

    {{-- Order form --}}
    <section class="lp-sec lp-sec-form lp-reveal" id="lp-order">
        <div class="lp-form-head">
            <h2 class="lp-form-title">অর্ডার করতে নিচে ফর্মটি পূরণ করুন</h2>
        </div>

        @if ($oos)
            <div style="max-width:480px;margin:16px auto 0;"><div class="lp-oos"><i class="fas fa-times-circle"></i> স্টক শেষ (Out of Stock)</div></div>
        @else
        <div class="lp-form-grid-wrap"><div class="lp-form-grid">

            {{-- Left: customer details --}}
            <div class="lp-card">
                <h3>আপনার তথ্য দিন</h3>
                <div class="lp-fld">
                    <label>আপনার নাম লিখুন <span style="color:#ef4444">*</span></label>
                    <input type="text" id="lpName" placeholder="আপনার নাম" required>
                </div>
                <div class="lp-fld">
                    <label>আপনার সম্পূর্ণ ঠিকানা লিখুন <span style="color:#ef4444">*</span></label>
                    <textarea id="lpAddress" rows="2" placeholder="বাসা, রোড, এলাকা, থানা, জেলা" required></textarea>
                </div>
                <div class="lp-fld">
                    <label>আপনার ফোন নাম্বার লিখুন <span style="color:#ef4444">*</span></label>
                    <input type="tel" id="lpPhone" placeholder="01XXXXXXXXX" required>
                </div>
                <div class="lp-fld">
                    <label>ডেলিভারি এরিয়া</label>
                    <div class="lp-zone" id="lpZones">
                        <label class="active"><span><input type="radio" name="lpZone" value="inside" checked> ঢাকা শহর</span> <span class="z-cost">৳ {{ number_format($shipIn) }}</span></label>
                        <label><span><input type="radio" name="lpZone" value="outside"> ঢাকার বাইরে</span> <span class="z-cost">৳ {{ number_format($shipOut) }}</span></label>
                    </div>
                </div>
                <div class="lp-fld">
                    <label>পরিমাণ</label>
                    <div class="lp-qty">
                        <button type="button" onclick="lpQty(-1)"><i class="fas fa-minus" style="font-size:.7rem"></i></button>
                        <input type="number" id="lpQtyInput" value="1" min="1" max="{{ $product->type === 'digital' ? 99 : max(1,(int)$stock) }}" readonly>
                        <button type="button" onclick="lpQty(1)"><i class="fas fa-plus" style="font-size:.7rem"></i></button>
                    </div>
                </div>
            </div>

            {{-- Right: order summary --}}
            <div class="lp-card">
                <h3>আপনার অর্ডার</h3>
                <div class="lp-sum-row lp-sum-head"><span>Product</span><span class="v">Subtotal</span></div>
                <div class="lp-sum-row"><span id="lpItemLabel">{{ $product->name }} × 1</span><span class="v">৳ <span id="lpSubtotal">{{ number_format($unit) }}</span></span></div>
                <div class="lp-sum-row"><span>Shipping</span><span class="v">৳ <span id="lpShip">{{ number_format($shipIn) }}</span></span></div>
                <div class="lp-sum-total"><span>Total</span><span>৳ <span id="lpTotal">{{ number_format($unit + $shipIn) }}</span></span></div>

                <div class="lp-pay">
                    <label class="active"><input type="radio" name="lpPay" value="cod" checked> <i class="fas fa-money-bill-wave" style="color:var(--c1)"></i> Cash on Delivery</label>
                    <p class="lp-pay-note">Pay with cash upon delivery.</p>
                    @if ($landing->enable_online_payment)
                    <label><input type="radio" name="lpPay" value="uddoktapay"> <i class="fas fa-mobile-screen" style="color:#e0780a"></i> bKash / Nagad / Card</label>
                    @endif
                </div>

                <button type="button" class="lp-confirm" id="lpConfirm" onclick="lpPlaceOrder()">
                    কনফার্ম অর্ডার — ৳ <span id="lpBtnTotal">{{ number_format($unit + $shipIn) }}</span>
                </button>
                <div class="lp-msg" id="lpMsg"></div>
            </div>

        </div></div>
        @endif
    </section>

    {{-- Trust badges --}}
    <section class="lp-trust lp-reveal">
        <div class="lp-trust-item"><i class="fas fa-truck-fast"></i><strong>হোম ডেলিভারি</strong><span>সারা বাংলাদেশে</span></div>
        <div class="lp-trust-item"><i class="fas fa-hand-holding-dollar"></i><strong>ক্যাশ অন ডেলিভারি</strong><span>পণ্য হাতে পেয়ে পেমেন্ট</span></div>
        <div class="lp-trust-item"><i class="fas fa-rotate-left"></i><strong>সহজ রিটার্ন</strong><span>৭ দিনের রিটার্ন পলিসি</span></div>
    </section>

    {{-- Sticky mobile order bar --}}
    <div class="lp-sticky-bar" id="lpStickyBar">
        <div class="lp-sticky-price"><small>সর্বমোট</small>৳ <span id="lpStickyTotal">{{ number_format($unit + $shipIn) }}</span></div>
        <a href="#lp-order" class="lp-sticky-btn"><i class="fas fa-bag-shopping"></i> {{ $cta }}</a>
    </div>

    {{-- Footer --}}
    <footer class="lp-footer">
        @if ($landing->footer_text)<div class="lp-footer-cta">{{ $landing->footer_text }}</div>@endif
        <div class="lp-footer-copy">© {{ date('Y') }} {{ $siteName }}. All rights reserved.</div>
    </footer>
</div>
@endsection

@push('scripts')
<script>
window.LP = {
    id:       {{ $product->id }},
    unit:     {{ $unit }},
    shipIn:   {{ $shipIn }},
    shipOut:  {{ $shipOut }},
    name:     @json($product->name),
    orderUrl: @json(route('landing.order', $landing->slug)),
    complete: @json(route('order-complete')),
    csrf:     @json(csrf_token()),
};

function lpFmt(n){ return Math.round(n).toLocaleString('en-US'); }

function lpState(){
    var qty  = parseInt(document.getElementById('lpQtyInput').value) || 1;
    var zone = document.querySelector('input[name="lpZone"]:checked').value;
    var ship = zone === 'inside' ? LP.shipIn : LP.shipOut;
    var sub  = LP.unit * qty;
    return { qty:qty, zone:zone, ship:ship, sub:sub, total:sub+ship };
}

function lpRecalc(){
    var s = lpState();
    document.getElementById('lpItemLabel').textContent = LP.name + ' × ' + s.qty;
    document.getElementById('lpSubtotal').textContent  = lpFmt(s.sub);
    document.getElementById('lpShip').textContent      = lpFmt(s.ship);
    document.getElementById('lpTotal').textContent     = lpFmt(s.total);
    document.getElementById('lpBtnTotal').textContent  = lpFmt(s.total);
    var sticky = document.getElementById('lpStickyTotal');
    if (sticky) sticky.textContent = lpFmt(s.total);
}

// ── Countdown timer (resets every 2 hours, persists across reloads) ──
(function(){
    var KEY = 'lpOfferEnds';
    var end = parseInt(localStorage.getItem(KEY) || '0', 10);
    if (!end || end < Date.now()) {
        end = Date.now() + 2 * 60 * 60 * 1000;
        localStorage.setItem(KEY, end);
    }
    function pad(n){ return String(n).padStart(2,'0'); }
    function tick(){
        var diff = end - Date.now();
        if (diff <= 0) { end = Date.now() + 2*60*60*1000; localStorage.setItem(KEY, end); diff = end - Date.now(); }
        var h = Math.floor(diff / 3600000);
        var m = Math.floor((diff % 3600000) / 60000);
        var s = Math.floor((diff % 60000) / 1000);
        var eh = document.getElementById('lpCdH'), em = document.getElementById('lpCdM'), es = document.getElementById('lpCdS');
        if (eh) eh.textContent = pad(h);
        if (em) em.textContent = pad(m);
        if (es) es.textContent = pad(s);
    }
    tick();
    setInterval(tick, 1000);
})();

// ── Scroll-reveal animations ──
(function(){
    var items = document.querySelectorAll('.lp-reveal');
    if (!('IntersectionObserver' in window)) { items.forEach(function(el){ el.classList.add('lp-in'); }); return; }
    var io = new IntersectionObserver(function(entries){
        entries.forEach(function(e){
            if (e.isIntersecting) { e.target.classList.add('lp-in'); io.unobserve(e.target); }
        });
    }, { threshold: 0.12 });
    items.forEach(function(el){ io.observe(el); });
})();

// ── Hide sticky bar once the order form is in view ──
(function(){
    var bar = document.getElementById('lpStickyBar');
    var form = document.getElementById('lp-order');
    if (!bar || !form || !('IntersectionObserver' in window)) return;
    var io = new IntersectionObserver(function(entries){
        entries.forEach(function(e){ bar.style.display = e.isIntersecting ? 'none' : ''; });
    }, { threshold: 0.15 });
    io.observe(form);
})();

function lpQty(d){
    var inp = document.getElementById('lpQtyInput');
    var max = parseInt(inp.max) || 99;
    inp.value = Math.max(1, Math.min(max, (parseInt(inp.value)||1) + d));
    lpRecalc();
}

// Zone / payment active styling
document.querySelectorAll('#lpZones label').forEach(function(l){
    l.addEventListener('click', function(){
        document.querySelectorAll('#lpZones label').forEach(x=>x.classList.remove('active'));
        l.classList.add('active');
        setTimeout(lpRecalc, 0);
    });
});
document.querySelectorAll('.lp-pay label').forEach(function(l){
    l.addEventListener('click', function(){
        document.querySelectorAll('.lp-pay label').forEach(x=>x.classList.remove('active'));
        l.classList.add('active');
    });
});

function lpMsg(text, ok){
    var b = document.getElementById('lpMsg');
    b.textContent = text; b.style.display='block';
    b.style.background = ok ? '#dcfce7' : '#fee2e2';
    b.style.color      = ok ? '#166534' : '#991b1b';
}

function lpPlaceOrder(){
    var name = document.getElementById('lpName').value.trim();
    var addr = document.getElementById('lpAddress').value.trim();
    var phone= document.getElementById('lpPhone').value.trim();
    if(!name || !addr || !phone){ lpMsg('অনুগ্রহ করে আপনার নাম, ঠিকানা ও মোবাইল নম্বর দিন।', false); return; }

    var s   = lpState();
    var pay = document.querySelector('input[name="lpPay"]:checked').value;
    var btn = document.getElementById('lpConfirm');
    btn.disabled = true;
    var orig = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> অর্ডার হচ্ছে...';

    fetch(LP.orderUrl, {
        method:'POST',
        headers:{ 'Content-Type':'application/json', 'X-CSRF-TOKEN':LP.csrf, 'X-Requested-With':'XMLHttpRequest' },
        body: JSON.stringify({
            shipping_name: name, shipping_phone: phone, shipping_address: addr,
            zone: s.zone, quantity: s.qty, payment_method: pay,
        }),
    })
    .then(r=>r.json())
    .then(d=>{
        if(d.success){ window.location.href = d.redirect || LP.complete; }
        else { lpMsg(d.message || 'কিছু একটা সমস্যা হয়েছে। আবার চেষ্টা করুন।', false); btn.disabled=false; btn.innerHTML=orig; }
    })
    .catch(()=>{ lpMsg('নেটওয়ার্ক সমস্যা। আবার চেষ্টা করুন।', false); btn.disabled=false; btn.innerHTML=orig; });
}

lpRecalc();
</script>
@endpush
