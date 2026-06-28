<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', \App\Models\SiteSetting::get('company_name', 'NF Shop 24') . ' - Largest E-commerce in Bangladesh')</title>
    <link rel="stylesheet" href="{{ asset('backend/assets/css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
    @stack('styles')
    @php
        $cp  = \App\Models\SiteSetting::get('color_primary',   '#2D1B69');
        $cs  = \App\Models\SiteSetting::get('color_secondary', '#5E2590');
        $ca  = \App\Models\SiteSetting::get('color_accent',    '#f59e0b');
        // auto-darken by 15 RGB units
        $darken = function(string $hex, int $amt = 20): string {
            $hex = ltrim($hex, '#');
            $r = max(0, hexdec(substr($hex, 0, 2)) - $amt);
            $g = max(0, hexdec(substr($hex, 2, 2)) - $amt);
            $b = max(0, hexdec(substr($hex, 4, 2)) - $amt);
            return sprintf('#%02x%02x%02x', $r, $g, $b);
        };
        $csDark = $darken($cs);
        $caDark = $darken($ca);
    @endphp
    <style>
        :root {
            --primary:        {{ $cp }};
            --secondary:      {{ $cs }};
            --secondary-dark: {{ $csDark }};
            --accent:         {{ $ca }};
            --accent-dark:    {{ $caDark }};
            --gold:           {{ $ca }};
        }
    </style>
    <style>
        #preloader{position:fixed;inset:0;z-index:99999;background:linear-gradient(135deg,#2D1B69,#5E2590);display:flex;flex-direction:column;align-items:center;justify-content:center;transition:opacity .5s ease,visibility .5s ease}
        #preloader.hide{opacity:0;visibility:hidden;pointer-events:none}
        #preloader .pl-logo{height:120px;margin-bottom:28px;filter:brightness(0) invert(1)}
        #preloader .pl-spinner{width:44px;height:44px;border:4px solid rgba(255,255,255,.15);border-top-color:#fbbf24;border-radius:50%;animation:pl-spin .8s linear infinite}
        @keyframes pl-spin{to{transform:rotate(360deg)}}
        #preloader .pl-text{color:rgba(255,255,255,.6);font-size:13px;margin-top:16px;letter-spacing:2px;text-transform:uppercase}
    </style>
</head>
<body>

<!-- Preloader -->
<div id="preloader">
    <img class="pl-logo" src="{{ asset('backend/assets/images/b590a397-1dfa-4237-8d00-6c2712a2b6c8-removebg-preview.png') }}" alt="NF Shop 24">
    <div class="pl-spinner"></div>
    <div class="pl-text">Loading...</div>
</div>

@include('Frontend.Layout.partials.header')

@yield('content')

@include('Frontend.Layout.partials.footer')

<!-- WhatsApp -->
<div class="whatsapp">
    <a href="https://api.whatsapp.com/send?phone=8801820834086" target="_blank"><i class="fab fa-whatsapp"></i></a>
</div>

<!-- Back to Top -->
<button class="btt" id="btt" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <i class="fas fa-arrow-up"></i>
</button>

<script>window.NF_CHECKOUT_URL = '{{ route("checkout") }}';</script>
<script src="{{ asset('backend/assets/js/script.js') }}"></script>
@stack('scripts')
</body>
</html>