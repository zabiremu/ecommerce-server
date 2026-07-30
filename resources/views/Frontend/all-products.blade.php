@extends('Frontend.Layout.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-product-loop.css') }}" type="text/css" media="all"/>
<link rel="stylesheet" href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-loop-prod-el-base.css') }}" type="text/css" media="all"/>
<link rel="stylesheet" href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-loop-prod-predefined.css') }}" type="text/css" media="all"/>
<link rel="stylesheet" href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-product-loop-quick.css') }}" type="text/css" media="all"/>
<link rel="stylesheet" href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-mod-loop-prod-add-btn-replace.css') }}" type="text/css" media="all"/>
<link rel="stylesheet" href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-opt-bordered-product.css') }}" type="text/css" media="all"/>
<link rel="stylesheet" href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-opt-bordered-product-predefined.css') }}" type="text/css" media="all"/>
<link rel="stylesheet" href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-shop-predefined.css') }}" type="text/css" media="all"/>
<style>
/* ── page title bar ── */
.gms-cat-title-bar {
    background: var(--wd-primary-color, #e63946);
    padding: 28px 0 22px;
    margin-bottom: 0;
}
.gms-cat-title-bar .container {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.gms-cat-breadcrumb {
    font-size: 13px;
    color: rgba(255,255,255,.75);
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}
.gms-cat-breadcrumb a { color: rgba(255,255,255,.85); text-decoration: none; }
.gms-cat-breadcrumb a:hover { color: #fff; }
.gms-cat-breadcrumb .sep { opacity: .5; font-size: 10px; }
.gms-cat-breadcrumb .current { color: #fff; font-weight: 600; }
.gms-cat-title-bar h1 {
    font-size: 28px;
    font-weight: 700;
    color: #fff;
    margin: 0;
    line-height: 1.2;
}
/* ── layout ── */
.gms-cat-section {
    padding: 36px 0 32px;
    background: var(--gms-bg-soft, #f7f7f7);
}
.gms-cat-inner {
    display: flex;
    gap: 28px;
    align-items: flex-start;
}
/* ── sidebar ── */
.gms-cat-sidebar {
    width: 240px;
    flex-shrink: 0;
    background: #fff;
    border-radius: 12px;
    padding: 22px 18px;
    box-shadow: 0 2px 10px rgba(0,0,0,.06);
    position: sticky;
    top: 90px;
}
.gms-sidebar-title {
    font-size: 14px;
    font-weight: 700;
    color: var(--gms-title, #242424);
    text-transform: uppercase;
    letter-spacing: .6px;
    margin: 0 0 14px;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--gms-line, #ececec);
    display: flex;
    align-items: center;
    gap: 8px;
}
.gms-filter-section { margin-bottom: 22px; }
.gms-filter-section h4 {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 13px;
    font-weight: 600;
    color: var(--gms-title, #242424);
    margin: 0 0 10px;
    cursor: pointer;
    user-select: none;
}
.gms-filter-chevron {
    font-size: 10px;
    color: var(--gms-text, #555);
    transition: transform .2s;
}
.gms-filter-section.gms-filter-collapsed .gms-filter-chevron { transform: rotate(-90deg); }
.gms-filter-section.gms-filter-collapsed .gms-filter-option { display: none; }
.gms-filter-option {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 6px 8px;
    border-radius: 7px;
    cursor: pointer;
    font-size: 13px;
    color: var(--gms-text, #555);
    transition: background .15s;
    user-select: none;
}
.gms-filter-option:hover { background: var(--gms-bg-soft, #f7f7f7); }
.gms-filter-option.active { background: rgba(230,57,70,.08); color: var(--gms-red, #e63946); font-weight: 600; }
.gms-filter-option .check {
    width: 15px; height: 15px;
    border: 2px solid #ccc;
    border-radius: 50%;
    flex-shrink: 0;
    transition: border-color .15s, background .15s;
}
.gms-filter-option.active .check {
    border-color: var(--gms-red, #e63946);
    background: var(--gms-red, #e63946);
}
.gms-clear-btn {
    width: 100%;
    padding: 9px;
    background: var(--gms-bg-soft, #f7f7f7);
    border: 1px solid var(--gms-line, #ececec);
    border-radius: 7px;
    font-size: 12px;
    font-weight: 600;
    color: var(--gms-text, #555);
    cursor: pointer;
    transition: background .15s, color .15s;
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-top: 4px;
}
.gms-clear-btn:hover { background: var(--gms-red, #e63946); color: #fff; border-color: var(--gms-red); }
/* ── main content ── */
.gms-cat-main { flex: 1; min-width: 0; }
/* ── toolbar ── */
.gms-cat-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 22px;
    background: #fff;
    border-radius: 10px;
    padding: 12px 18px;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
}
.gms-toolbar-left { display: flex; align-items: center; gap: 12px; min-width: 0; }
.gms-filter-toggle {
    display: none;
    align-items: center;
    gap: 6px;
    padding: 7px 14px;
    background: var(--gms-bg-soft);
    border: 1px solid var(--gms-line);
    border-radius: 7px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background .15s;
}
.gms-filter-toggle:hover { background: var(--gms-line); }
.gms-result-count { font-size: 13px; color: var(--gms-text, #555); min-width: 0; overflow-wrap: anywhere; }
.gms-result-count strong { color: var(--gms-title, #242424); }
.gms-sort-wrap { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--gms-text); }
.gms-sort-select {
    border: 1px solid var(--gms-line, #ececec);
    border-radius: 7px;
    padding: 6px 10px;
    font-size: 13px;
    background: #fff;
    color: var(--gms-title);
    cursor: pointer;
    outline: none;
}
/* ── empty state ── */
.gms-empty {
    text-align: center;
    padding: 60px 20px;
    color: var(--gms-text);
}
.gms-empty i { font-size: 48px; color: var(--gms-line); margin-bottom: 16px; display: block; }
.gms-empty h3 { font-size: 20px; color: var(--gms-title); margin-bottom: 8px; }
/* ── pagination ── */
.gms-pagination {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-top: 36px;
    flex-wrap: wrap;
}
.gms-page-btn {
    min-width: 36px;
    height: 36px;
    padding: 0 10px;
    border: 1px solid var(--gms-line);
    border-radius: 7px;
    background: #fff;
    font-size: 13px;
    font-weight: 600;
    color: var(--gms-title);
    cursor: pointer;
    transition: all .15s;
    display: flex;
    align-items: center;
    justify-content: center;
}
.gms-page-btn:hover { background: var(--gms-bg-soft); border-color: #bbb; }
.gms-page-btn.active { background: var(--gms-red, #e63946); color: #fff; border-color: var(--gms-red); }
.gms-page-btn:disabled { opacity: .4; pointer-events: none; }
/* ── mobile sidebar overlay ── */
.gms-sidebar-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.4);
    z-index: 1000;
}
.gms-sidebar-overlay.open { display: block; }
@media (max-width: 1024px) {
    .gms-cat-sidebar {
        position: fixed;
        top: 0; left: -280px; bottom: 0;
        width: 260px;
        z-index: 1001;
        border-radius: 0;
        overflow-y: auto;
        transition: left .3s ease;
        padding-top: 60px;
    }
    .gms-cat-sidebar.open { left: 0; }
    .gms-filter-toggle { display: flex; }
    .gms-sidebar-close {
        position: absolute;
        top: 16px; right: 16px;
        background: none; border: none;
        font-size: 20px; cursor: pointer; color: var(--gms-text);
    }
}
@media (max-width: 768px) {
    .gms-cat-inner { flex-direction: column; }
    .gms-cat-title-bar h1 { font-size: 22px; }
    .gms-cat-toolbar {
        flex-direction: column;
        align-items: stretch;
        padding: 14px 16px;
        border-radius: 14px;
        gap: 0;
    }
    .gms-toolbar-left {
        justify-content: space-between;
        padding-bottom: 12px;
        margin-bottom: 12px;
        border-bottom: 1px solid var(--gms-line, #ececec);
    }
    .gms-filter-toggle {
        padding: 8px 14px;
        border-radius: 20px;
    }
    .gms-result-count {
        text-align: right;
        flex-shrink: 1;
        min-width: 0;
    }
    .gms-sort-wrap {
        justify-content: space-between;
        font-weight: 600;
        color: var(--gms-title, #242424);
    }
    .gms-sort-select {
        flex: 1;
        max-width: 190px;
        padding: 10px 30px 10px 14px;
        font-weight: 600;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' fill='none' stroke='%23242424' stroke-width='1.6' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
    }
}
</style>
@endpush

@section('content')

{{-- Page Title Bar --}}
<div class="gms-cat-title-bar">
    <div class="container">
        <nav class="gms-cat-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="sep">›</span>
            <span class="current">All Products</span>
        </nav>
        <h1>All Products</h1>
    </div>
</div>

{{-- Mobile overlay --}}
<div class="gms-sidebar-overlay" id="sidebarOverlay" onclick="closeApSidebar()"></div>

<section class="gms-cat-section">
    <div class="container">
        <div class="gms-cat-inner">

            {{-- Sidebar --}}
            <aside class="gms-cat-sidebar" id="apSidebar">


                <div class="gms-sidebar-title"><i class="fas fa-filter"></i> Filters</div>

                <div class="gms-filter-section">
                    <h4 onclick="toggleGmsFilterSection(this)">Category <i class="fas fa-chevron-down gms-filter-chevron"></i></h4>
                    <label class="gms-filter-option active" data-cat="" onclick="setApCategory(this, '')">
                        <span class="check"></span> All Categories
                    </label>
                    @foreach($filterCategories as $cat)
                        <label class="gms-filter-option" data-cat="{{ $cat->slug }}" onclick="setApCategory(this, '{{ $cat->slug }}')">
                            <span class="check"></span> {{ $cat->name }}
                        </label>
                    @endforeach
                </div>

                @if($filterBrands->isNotEmpty())
                    <div class="gms-filter-section gms-filter-collapsed">
                        <h4 onclick="toggleGmsFilterSection(this)">Brand <i class="fas fa-chevron-down gms-filter-chevron"></i></h4>
                        <label class="gms-filter-option active" data-brand="" onclick="setApBrand(this, '')">
                            <span class="check"></span> All Brands
                        </label>
                        @foreach($filterBrands as $brand)
                            <label class="gms-filter-option" data-brand="{{ $brand->slug }}" onclick="setApBrand(this, '{{ $brand->slug }}')">
                                <span class="check"></span> {{ $brand->name }}
                            </label>
                        @endforeach
                    </div>
                @endif

                <div class="gms-filter-section gms-filter-collapsed">
                    <h4 onclick="toggleGmsFilterSection(this)">Price Range <i class="fas fa-chevron-down gms-filter-chevron"></i></h4>
                    <label class="gms-filter-option active" data-price onclick="setApPrice(this, 0, Infinity)">
                        <span class="check"></span> All Prices
                    </label>
                    <label class="gms-filter-option" data-price onclick="setApPrice(this, 0, 300)">
                        <span class="check"></span> Under ৳300
                    </label>
                    <label class="gms-filter-option" data-price onclick="setApPrice(this, 300, 600)">
                        <span class="check"></span> ৳300 – ৳600
                    </label>
                    <label class="gms-filter-option" data-price onclick="setApPrice(this, 600, 1000)">
                        <span class="check"></span> ৳600 – ৳1,000
                    </label>
                    <label class="gms-filter-option" data-price onclick="setApPrice(this, 1000, 2000)">
                        <span class="check"></span> ৳1,000 – ৳2,000
                    </label>
                    <label class="gms-filter-option" data-price onclick="setApPrice(this, 2000, Infinity)">
                        <span class="check"></span> ৳2,000+
                    </label>
                </div>

                <button class="gms-clear-btn" onclick="clearApFilters()">
                    <i class="fas fa-redo"></i> Clear Filters
                </button>
            </aside>

            {{-- Main --}}
            <div class="gms-cat-main">

                {{-- Toolbar --}}
                <div class="gms-cat-toolbar">
                    <div class="gms-toolbar-left">
                        <button class="gms-filter-toggle" onclick="openApSidebar()">
                            <i class="fas fa-sliders-h"></i> Filters
                        </button>
                        <div class="gms-result-count">
                            Showing <strong id="resultCount">0</strong> products
                            @if(request()->filled('q'))
                                for "<strong>{{ request()->query('q') }}</strong>"
                                <a href="{{ route('all-products') }}" style="margin-left:8px;color:var(--gms-red,#e63946);text-decoration:underline;">Clear search</a>
                            @endif
                        </div>
                    </div>
                    <div class="gms-sort-wrap">
                        <label for="apSortSelect">Sort:</label>
                        <select id="apSortSelect" class="gms-sort-select" onchange="renderApPage()">
                            <option value="default">Default</option>
                            <option value="price-asc">Price: Low to High</option>
                            <option value="price-desc">Price: High to Low</option>
                            <option value="name">Name: A–Z</option>
                        </select>
                    </div>
                </div>

                {{-- Product Grid --}}
                <div class="products wd-products wd-grid-g grid-columns-4 elements-grid wd-loop-builder-off title-line-one wd-stretch-cont-lg wd-stretch-cont-md wd-stretch-cont-sm products-bordered-grid-ins"
                     style="--wd-col-lg:4;--wd-col-md:3;--wd-col-sm:2;--wd-gap-lg:20px;--wd-gap-sm:10px;"
                     id="productGrid"></div>

                {{-- Pagination --}}
                <div class="gms-pagination" id="apPagination"></div>
            </div>

        </div>
    </div>
</section>

<script>
window.NF_PRODUCTS = @json($products);

(function () {
    const PER_PAGE = 12;
    const params   = new URLSearchParams(location.search);
    let catSlug    = params.get('cat')   || '';
    let brandSlug  = params.get('brand') || '';
    let searchTerm = (params.get('q')    || '').trim().toLowerCase();
    let priceMin   = 0;
    let priceMax   = Infinity;
    let currentPage = 1;

    // ── filter & sort ───────────────────────────────────────────────
    function getFiltered() {
        let list = (window.NF_PRODUCTS || []).filter(p => {
            if (catSlug && p.cat !== catSlug) return false;
            if (brandSlug && p.brand !== brandSlug) return false;
            if (searchTerm && !p.title.toLowerCase().includes(searchTerm)) return false;
            if (p.cur < priceMin || p.cur > priceMax) return false;
            return true;
        });
        const sort = document.getElementById('apSortSelect')?.value || 'default';
        if (sort === 'price-asc')  list = list.slice().sort((a,b) => a.cur - b.cur);
        if (sort === 'price-desc') list = list.slice().sort((a,b) => b.cur - a.cur);
        if (sort === 'name')       list = list.slice().sort((a,b) => a.title.localeCompare(b.title));
        return list;
    }

    // ── build one product card — shared renderer, see gms-custom.js
    // (window.gmsBuildProductCard) so this stays in sync with the
    // server-rendered product-card.blade.php partial instead of drifting. ──
    function buildCard(p) {
        return window.gmsBuildProductCard(p);
    }

    // ── render page ─────────────────────────────────────────────────
    window.renderApPage = function () {
        const all    = getFiltered();
        const total  = all.length;
        const pages  = Math.max(1, Math.ceil(total / PER_PAGE));
        currentPage  = Math.min(currentPage, pages);
        const slice  = all.slice((currentPage - 1) * PER_PAGE, currentPage * PER_PAGE);

        document.getElementById('resultCount').textContent = total;

        const grid = document.getElementById('productGrid');
        if (slice.length === 0) {
            grid.innerHTML = `<div class="gms-empty" style="grid-column:1/-1">
                <i class="fas fa-box-open"></i>
                <h3>No products found</h3>
                <p>Try adjusting your filters.</p>
            </div>`;
        } else {
            grid.innerHTML = slice.map(buildCard).join('');
        }

        window.dispatchEvent(new Event('gms:wishlist-updated'));
        renderPagination(pages);
    };

    function renderPagination(pages) {
        const el = document.getElementById('apPagination');
        if (pages <= 1) { el.innerHTML = ''; return; }
        let html = '';
        html += `<button class="gms-page-btn" onclick="goApPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>&larr;</button>`;
        for (let i = 1; i <= pages; i++) {
            if (pages > 7 && Math.abs(i - currentPage) > 2 && i !== 1 && i !== pages) {
                if (i === 2 || i === pages - 1) html += `<span style="padding:0 4px;color:#aaa">…</span>`;
                continue;
            }
            html += `<button class="gms-page-btn${i === currentPage ? ' active' : ''}" onclick="goApPage(${i})">${i}</button>`;
        }
        html += `<button class="gms-page-btn" onclick="goApPage(${currentPage + 1})" ${currentPage === pages ? 'disabled' : ''}>&rarr;</button>`;
        el.innerHTML = html;
    }

    window.goApPage = function (n) {
        currentPage = n;
        renderApPage();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    // ── filter section accordion (Category / Brand / Price Range) ────
    window.toggleGmsFilterSection = function (headerEl) {
        var section = headerEl.closest('.gms-filter-section');
        var sidebar = headerEl.closest('.gms-cat-sidebar') || document;
        var wasCollapsed = section.classList.contains('gms-filter-collapsed');
        sidebar.querySelectorAll('.gms-filter-section').forEach(function (s) {
            s.classList.add('gms-filter-collapsed');
        });
        if (wasCollapsed) {
            section.classList.remove('gms-filter-collapsed');
        }
    };

    // ── category / brand / price filters ─────────────────────────────
    window.setApCategory = function (el, slug) {
        catSlug = slug;
        currentPage = 1;
        el.parentElement.querySelectorAll('.gms-filter-option').forEach(o => o.classList.remove('active'));
        el.classList.add('active');
        renderApPage();
    };

    window.setApBrand = function (el, slug) {
        brandSlug = slug;
        currentPage = 1;
        el.parentElement.querySelectorAll('.gms-filter-option').forEach(o => o.classList.remove('active'));
        el.classList.add('active');
        renderApPage();
    };

    window.setApPrice = function (el, min, max) {
        priceMin = min;
        priceMax = max;
        currentPage = 1;
        el.parentElement.querySelectorAll('.gms-filter-option').forEach(o => o.classList.remove('active'));
        el.classList.add('active');
        renderApPage();
    };

    window.clearApFilters = function () {
        catSlug = ''; brandSlug = ''; priceMin = 0; priceMax = Infinity; currentPage = 1;
        document.querySelectorAll('.gms-filter-section').forEach(section => {
            section.querySelectorAll('.gms-filter-option').forEach((o, i) => o.classList.toggle('active', i === 0));
        });
        document.getElementById('apSortSelect').value = 'default';
        renderApPage();
    };

    // ── sidebar toggle ───────────────────────────────────────────────
    window.openApSidebar  = function () {
        document.getElementById('apSidebar').classList.add('open');
        document.getElementById('sidebarOverlay').classList.add('open');
    };
    window.closeApSidebar = function () {
        document.getElementById('apSidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').classList.remove('open');
    };

    // ── cart / wishlist (delegates to gms-custom.js if present) ─────
    window.addToCart = function (e, id) {
        e.preventDefault();
        if (typeof window.nfAddToCart === 'function') window.nfAddToCart(id);
        else {
            const p = (window.NF_PRODUCTS || []).find(x => x.id === id);
            if (p) {
                let cart = JSON.parse(localStorage.getItem('gms_cart') || '[]');
                const ex = cart.find(c => c.id === id);
                ex ? ex.qty++ : cart.push({ id, title: p.title, img: p.img, price: p.cur, qty: 1, url: p.url });
                localStorage.setItem('gms_cart', JSON.stringify(cart));
                window.dispatchEvent(new Event('gms:cart-updated'));
            }
        }
    };

    // ── init: reflect incoming ?cat=/?brand= query params in the sidebar ──
    function init() {
        if (catSlug) {
            const opt = document.querySelector(`#apSidebar [data-cat="${catSlug}"]`);
            if (opt) { document.querySelectorAll('[data-cat]').forEach(o => o.classList.remove('active')); opt.classList.add('active'); }
        }
        if (brandSlug) {
            const opt = document.querySelector(`#apSidebar [data-brand="${brandSlug}"]`);
            if (opt) { document.querySelectorAll('[data-brand]').forEach(o => o.classList.remove('active')); opt.classList.add('active'); }
        }
        renderApPage();
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();
})();
</script>
@endsection
