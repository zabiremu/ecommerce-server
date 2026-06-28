@extends('Frontend.Layout.app')

@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb">
    <div class="container">
        <a href="{{ route('home') }}">Home</a>
        <i class="fas fa-chevron-right"></i>
        <a href="{{ route('all-products') }}">All Products</a>
        <i class="fas fa-chevron-right"></i>
        <span id="catBreadcrumb">Category</span>
    </div>
</section>

<!-- Page Header -->
<section class="page-header" id="catPageHeader">
    <div class="container">
        <h1 id="catTitle"><i class="fas fa-th-large"></i> Category</h1>
        <p id="catDesc">Browse products in this category</p>
    </div>
</section>

<!-- Products -->
<section class="ap-section">
    <div class="container">
        <div class="ap-layout">
            <!-- Sidebar Filters (simplified — price + sort only) -->
            <aside class="ap-sidebar" id="apSidebar">
                <div class="sidebar-header">
                    <h3><i class="fas fa-filter"></i> Filters</h3>
                    <button class="sidebar-close" onclick="toggleCatSidebar()"><i class="fas fa-times"></i></button>
                </div>

                <div class="filter-group">
                    <h4>Price Range</h4>
                    <div class="filter-options">
                        <label class="filter-option" onclick="setCatPrice(this, 0, 300)">
                            <input type="radio" name="price" value="0-300" hidden>
                            <span class="check"></span> Under TK 300
                        </label>
                        <label class="filter-option" onclick="setCatPrice(this, 300, 600)">
                            <input type="radio" name="price" value="300-600" hidden>
                            <span class="check"></span> TK 300 – TK 600
                        </label>
                        <label class="filter-option" onclick="setCatPrice(this, 600, 1000)">
                            <input type="radio" name="price" value="600-1000" hidden>
                            <span class="check"></span> TK 600 – TK 1,000
                        </label>
                        <label class="filter-option" onclick="setCatPrice(this, 1000, 2000)">
                            <input type="radio" name="price" value="1000-2000" hidden>
                            <span class="check"></span> TK 1,000 – TK 2,000
                        </label>
                        <label class="filter-option" onclick="setCatPrice(this, 2000, Infinity)">
                            <input type="radio" name="price" value="2000+" hidden>
                            <span class="check"></span> TK 2,000+
                        </label>
                        <label class="filter-option active" onclick="setCatPrice(this, 0, Infinity)">
                            <input type="radio" name="price" value="all" checked hidden>
                            <span class="check"></span> All Prices
                        </label>
                    </div>
                </div>

                <button class="btn-clear" onclick="clearCatFilters()"><i class="fas fa-redo"></i> Clear Filters</button>
            </aside>

            <!-- Products Area -->
            <div class="ap-main">
                <div class="ap-toolbar">
                    <button class="filter-toggle" onclick="toggleCatSidebar()">
                        <i class="fas fa-sliders-h"></i> Filters
                    </button>
                    <div class="ap-meta">
                        Showing <strong id="resultCount">0</strong> products
                    </div>
                    <div class="ap-sort">
                        <label for="sortSelect">Sort:</label>
                        <select id="sortSelect" onchange="sortCatProducts()">
                            <option value="default">Default</option>
                            <option value="price-asc">Price: Low to High</option>
                            <option value="price-desc">Price: High to Low</option>
                            <option value="name">Name: A–Z</option>
                            <option value="discount">Biggest Discount</option>
                        </select>
                    </div>
                </div>

                <div class="product-grid" id="productGrid"></div>

                <div class="ap-pagination" id="apPagination"></div>
            </div>
        </div>
    </div>
</section>

<script>
    window.NF_PRODUCTS = @json($products);
    window.NF_CATEGORIES = @json($categories);
</script>
@endsection
