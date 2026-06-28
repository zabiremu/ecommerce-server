<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - NF Shop 24 Admin</title>

    <link rel="stylesheet" href="{{ asset('backend/assets/css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/fontawesome-all.min.css') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50:  '#f5f0ff',
                            100: '#eadbff',
                            200: '#d4b7ff',
                            300: '#b48aff',
                            400: '#8a52e8',
                            500: '#5E2590',
                            600: '#4a1d73',
                            700: '#36155a',
                            800: '#2D1B69',
                            900: '#1c0e44',
                        },
                        accent: {
                            400: '#fbbf24',
                            500: '#f59e0b',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                    boxShadow: {
                        card: '0 1px 2px 0 rgba(15, 23, 42, 0.04), 0 1px 3px 0 rgba(15, 23, 42, 0.06)',
                        glow: '0 0 30px -5px rgba(94, 37, 144, 0.4)',
                    }
                }
            }
        }
    </script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak]{display:none!important}
        ::-webkit-scrollbar{width:8px;height:8px}
        ::-webkit-scrollbar-track{background:transparent}
        ::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:8px}
        ::-webkit-scrollbar-thumb:hover{background:#94a3b8}
        .sidebar-scroll::-webkit-scrollbar-thumb{background:rgba(255,255,255,.15)}
        .sidebar-scroll::-webkit-scrollbar-thumb:hover{background:rgba(255,255,255,.3)}
    </style>

    @stack('styles')

<style>
/* ══ Admin — Global Mobile Responsive ══════════════════════ */

/* Tables: horizontal scroll on all screens < 1024px */
@media (max-width: 1023px) {
    .wp-list-table {
        display: block;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        white-space: nowrap;
    }
    .wp-list-table thead th,
    .wp-list-table tbody td { white-space: normal; }
    .wp-list-table thead th:first-child,
    .wp-list-table tbody td:first-child { white-space: nowrap; }
}

/* Row actions: always visible on touch devices */
@media (hover: none), (max-width: 768px) {
    .wp-row-actions { visibility: visible !important; }
}

/* ── 768px and below ───────────────────────────────────── */
@media (max-width: 768px) {

    /* Reduce main content padding */
    main > div { padding: 12px !important; }

    /* Page title */
    .wp-h1 { font-size: 18px !important; }

    /* Status tabs: horizontal scroll, no wrap */
    .wp-subtab {
        display: flex;
        flex-wrap: nowrap !important;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        padding-bottom: 2px;
        gap: 0 !important;
    }
    .wp-subtab::-webkit-scrollbar { display: none; }

    /* Filter/action bars: wrap */
    .wp-search-box { flex-wrap: wrap !important; }

    /* Fixed-width inputs → full width */
    .wp-input[style*="width:240"],
    .wp-input[style*="width: 240"] { width: 100% !important; min-width: 0 !important; }

    /* Panel body: tighter padding */
    .wp-panel-body { padding: 10px !important; }

    /* WC field: stack label above input */
    .wc-field {
        display: block !important;
        grid-template-columns: none !important;
    }
    .wc-field > * { max-width: 100% !important; }

    /* WC info grids: shrink label col */
    .wc-info-grid { grid-template-columns: max-content 1fr !important; font-size: 12px !important; }
    .info-grid    { grid-template-columns: max-content 1fr !important; font-size: 12px !important; }

    /* Submit bar: stack buttons vertically */
    .wc-submit-bar {
        flex-direction: column !important;
        align-items: stretch !important;
        gap: 8px !important;
    }
    .wc-submit-bar button,
    .wc-submit-bar a { width: 100% !important; justify-content: center !important; text-align: center !important; }

    /* Summary cards value: smaller font */
    .summary-card .val { font-size: 18px !important; }
    .summary-card .lbl { font-size: 11px !important; }

    /* Color picker row: wrap */
    .color-picker-row { flex-wrap: wrap !important; }

    /* Inline 2-column grids → 1 column */
    [style*="grid-template-columns:1fr 1fr"],
    [style*="grid-template-columns: 1fr 1fr"],
    [style*="grid-template-columns:1fr 140px"],
    [style*="grid-template-columns: 1fr 140px"],
    [style*="grid-template-columns:180px 1fr"],
    [style*="grid-template-columns: 180px 1fr"] {
        grid-template-columns: 1fr !important;
    }

    /* Inline 3-column grids → 2 columns */
    [style*="grid-template-columns:repeat(3,1fr)"],
    [style*="grid-template-columns: repeat(3, 1fr)"] {
        grid-template-columns: repeat(2, 1fr) !important;
    }

    /* Gallery grid */
    .gallery-grid { grid-template-columns: repeat(2, 1fr) !important; }

    /* Product data tabs: horizontal on mobile */
    .wc-tab-btn {
        border-left: none !important;
        border-bottom: 3px solid transparent !important;
        padding: 8px 12px !important;
        white-space: nowrap !important;
        font-size: 12px !important;
    }
    .wc-tab-btn.active {
        border-left-color: transparent !important;
        border-bottom-color: #2271b1 !important;
    }

    /* Product tabs container: horizontal scrollable */
    .col-span-12.sm\:col-span-3 {
        border-right: none !important;
        border-bottom: 1px solid #c3c4c7 !important;
        display: flex !important;
        flex-direction: row !important;
        overflow-x: auto !important;
        background: #f6f7f7 !important;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }
    .col-span-12.sm\:col-span-3::-webkit-scrollbar { display: none; }

    /* Order index action bar: stack */
    #filterForm .flex { flex-direction: column !important; align-items: stretch !important; }
    #filterForm .flex .flex { flex-direction: row !important; flex-wrap: wrap !important; }
}

/* ── 480px and below ───────────────────────────────────── */
@media (max-width: 480px) {
    .summary-card .val { font-size: 15px !important; }
    .wc-info-grid,
    .info-grid { grid-template-columns: 1fr !important; }

    /* Inline 3-col → 1 col on very small screens */
    [style*="grid-template-columns:repeat(3,1fr)"],
    [style*="grid-template-columns: repeat(3, 1fr)"] {
        grid-template-columns: 1fr !important;
    }

    /* Order status pills: compact */
    .order-status-pill { font-size: 10px !important; padding: 2px 7px !important; }
    .pay-method-pill,
    .pay-status-pill   { font-size: 10px !important; padding: 2px 6px !important; }

    /* Hide less important columns on tiny screens via utility */
    .mob-hide { display: none !important; }
}
</style>
</head>
<body class="font-sans bg-slate-50 text-slate-800 antialiased text-[14px]"
      x-data="{ sidebarOpen: false }">

<div class="flex h-screen overflow-hidden">

    <!-- Mobile backdrop -->
    <div x-show="sidebarOpen"
         x-transition.opacity
         @click="sidebarOpen = false"
         x-cloak
         class="fixed inset-0 z-30 bg-slate-900/50 backdrop-blur-sm lg:hidden"></div>

    @include('Admin.Layout.partials.sidebar')

    <div class="flex-1 flex flex-col overflow-hidden">
        @include('Admin.Layout.partials.topnav')

        <main class="flex-1 overflow-y-auto bg-slate-50">
            <div class="p-5 lg:p-6">
                @yield('content')
            </div>
        </main>
    </div>

</div>

@stack('scripts')
</body>
</html>
