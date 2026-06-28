@php
    $announceText = \App\Models\SiteSetting::get('announcement_text', 'পণ্য বুঝে পেয়ে ডেলিভারি ম্যানকে পেমেন্ট করবেন');
    $headerPhone  = \App\Models\SiteSetting::get('contact_phone', '');
    $accountUrl = Auth::guard('admin')->check()
        ? route('admin.dashboard')
        : (Auth::guard('web')->check() ? route('dashboard') : route('login'));
@endphp
<!-- Top Announcement Bar -->
<div class="top-announce">
    <div class="container">
        <div>
            <i class="fas fa-shield-alt blink"></i> {{ $announceText }}
        </div>
        <div>
            @if ($headerPhone)
                <span><i class="fas fa-headset"></i> হেল্পলাইন: <a href="tel:{{ preg_replace('/\s+/', '', $headerPhone) }}">{{ $headerPhone }}</a></span>
                <span style="opacity:.3">|</span>
            @endif
            <a href="{{ route('track-order') }}"><i class="fas fa-truck"></i> ট্র্যাক অর্ডার</a>
        </div>
    </div>
</div>

<!-- Header -->
<header class="header" id="header">
    <div class="container" style="display:flex;align-items:center;justify-content:space-between">
        <!-- Mobile Hamburger -->
        <button class="mobile-toggle" id="mobileToggle" aria-label="Open menu">
            <i class="fas fa-bars"></i>
        </button>

        <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('backend/assets/images/logo.png') }}" alt="NF Shop 24">
        </a>

        <form class="search-box" action="{{ route('all-products') }}" method="GET" role="search">
            <input type="text" name="s" placeholder="Search products..." id="searchInput" value="{{ request('s') }}" autocomplete="off">
            <button type="submit" aria-label="Search"><i class="fas fa-search"></i></button>
        </form>

        <div class="header-actions">
            <a href="{{ route('wishlist') }}"><i class="far fa-heart"></i> <span>Wishlist</span>
                <span class="cart-badge" id="wishBadge" style="display:none">0</span>
            </a>
            <a href="{{ route('cart') }}" class="cart-link">
                <i class="fas fa-shopping-cart"></i> <span>Cart</span>
                <span class="cart-badge" id="cartBadge" style="display:none">0</span>
            </a>
            <a href="{{ $accountUrl }}"><i class="far fa-user"></i> <span>Account</span></a>
        </div>

        <!-- Mobile Cart Icon -->
        <a href="{{ route('cart') }}" class="mobile-cart" aria-label="Cart">
            <i class="fas fa-shopping-bag"></i>
            <span class="m-cart-badge" id="mCartBadge" style="display:none">0</span>
        </a>
    </div>
</header>

<!-- Navigation -->
<nav class="nav-bar">
    <div class="container">
        <button class="cat-btn"><i class="fas fa-bars"></i> All Categories</button>
        <ul class="nav-links">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('all-products') }}" class="{{ request()->routeIs('all-products') ? 'active' : '' }}">All Products</a></li>
            <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
        </ul>
    </div>
</nav>

<!-- Mobile Drawer Overlay -->
<div class="m-drawer-overlay" id="mDrawerOverlay"></div>

<!-- Mobile Slide-out Drawer -->
<aside class="m-drawer" id="mDrawer">
    <form class="m-drawer-search" action="{{ route('all-products') }}" method="GET" role="search">
        <input type="text" name="s" placeholder="Search for products" id="mSearchInput" value="{{ request('s') }}" autocomplete="off">
        <button type="submit" aria-label="Search"><i class="fas fa-search"></i></button>
    </form>

    <div class="m-drawer-tabs">
        <button class="m-tab active" data-tab="menu">MENU</button>
        <button class="m-tab" data-tab="categories">CATEGORIES</button>
    </div>

    <div class="m-tab-panel active" data-panel="menu">
        <a href="{{ route('home') }}" class="m-link">HOME</a>
        <a href="{{ route('all-products') }}" class="m-link">SHOP</a>
        <a href="{{ route('all-products') }}" class="m-link">ALL PRODUCTS</a>
        <a href="{{ route('about') }}" class="m-link">ABOUT</a>
        <a href="{{ route('contact') }}" class="m-link">CONTACT</a>
        <a href="{{ route('track-order') }}" class="m-link">TRACK ORDER</a>
        <a href="{{ route('wishlist') }}" class="m-link"><i class="far fa-heart"></i> WISHLIST</a>
        <a href="{{ route('cart') }}" class="m-link"><i class="fas fa-shopping-cart"></i> CART</a>
        <a href="{{ $accountUrl }}" class="m-link"><i class="far fa-user"></i> MY ACCOUNT</a>
    </div>

    <div class="m-tab-panel" data-panel="categories">
        @forelse ($headerCategories as $cat)
            <a href="{{ route('category-products') }}?cat={{ $cat->slug }}" class="m-link">{{ strtoupper($cat->name) }}</a>
        @empty
            <span class="m-link" style="opacity:.5">No categories yet</span>
        @endforelse
    </div>
</aside>

@php
    $headerCategoriesPayload = $headerCategories->map(fn ($c) => [
        'slug'  => $c->slug,
        'name'  => $c->name,
        'icon'  => $c->icon ?: 'fa-tag',
        'count' => $c->products_count,
    ])->values();
@endphp
<script>
    window.NF_HEADER_CATEGORIES = {!! $headerCategoriesPayload->toJson() !!};
    window.NF_CAT_PRODUCTS_URL = {!! json_encode(route('category-products')) !!};
</script>

<!-- Mobile Bottom Navigation -->
<nav class="m-bottom-nav">
    <a href="{{ route('all-products') }}" class="{{ request()->routeIs('all-products') ? 'active' : '' }}">
        <i class="fas fa-store"></i>
        <span>Shop</span>
    </a>
    <a href="{{ route('wishlist') }}" class="{{ request()->routeIs('wishlist') ? 'active' : '' }}">
        <span class="m-nav-ic">
            <i class="far fa-heart"></i>
            <em class="m-nav-badge" id="mNavWishBadge" style="display:none">0</em>
        </span>
        <span>Wishlist</span>
    </a>
    <a href="{{ $accountUrl }}" class="{{ request()->routeIs('login') || request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="far fa-user"></i>
        <span>My account</span>
    </a>
    <a href="#" id="mCompareBtn">
        <span class="m-nav-ic">
            <i class="fas fa-random"></i>
            <em class="m-nav-badge" id="mNavCompareBadge" style="display:none">0</em>
        </span>
        <span>Compare</span>
    </a>
</nav>
