@extends('Frontend.Layout.app')

@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb">
    <div class="container">
        <a href="{{ route('home') }}">Home</a>
        <i class="fas fa-chevron-right"></i>
        <span>All Products</span>
    </div>
</section>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1><i class="fas fa-store"></i> All Products</h1>
        <p>Browse our full collection of quality products</p>
    </div>
</section>

<!-- Filters & Products -->
<section class="ap-section">
    <div class="container">
        <div class="ap-layout">
            <!-- Sidebar Filters -->
            <aside class="ap-sidebar" id="apSidebar">
                <div class="sidebar-header">
                    <h3><i class="fas fa-filter"></i> Filters</h3>
                    <button class="sidebar-close" onclick="toggleSidebar()"><i class="fas fa-times"></i></button>
                </div>

                <div class="filter-group">
                    <h4>Category</h4>
                    <div class="filter-options" id="filterCategory">
                        <label class="filter-option active" onclick="setCategory(this, 'all')">
                            <input type="radio" name="cat" value="all" checked hidden>
                            <span class="check"></span> All Categories
                        </label>
                        @foreach ($filterCategories as $cat)
                            <label class="filter-option" onclick="setCategory(this, '{{ $cat->slug }}')">
                                <input type="radio" name="cat" value="{{ $cat->slug }}" hidden>
                                <span class="check"></span> {{ $cat->name }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="filter-group">
                    <h4>Price Range</h4>
                    <div class="filter-options">
                        <label class="filter-option" onclick="setPriceRange(this, 0, 300)">
                            <input type="radio" name="price" value="0-300" hidden>
                            <span class="check"></span> Under TK 300
                        </label>
                        <label class="filter-option" onclick="setPriceRange(this, 300, 600)">
                            <input type="radio" name="price" value="300-600" hidden>
                            <span class="check"></span> TK 300 – TK 600
                        </label>
                        <label class="filter-option" onclick="setPriceRange(this, 600, 1000)">
                            <input type="radio" name="price" value="600-1000" hidden>
                            <span class="check"></span> TK 600 – TK 1,000
                        </label>
                        <label class="filter-option" onclick="setPriceRange(this, 1000, 2000)">
                            <input type="radio" name="price" value="1000-2000" hidden>
                            <span class="check"></span> TK 1,000 – TK 2,000
                        </label>
                        <label class="filter-option" onclick="setPriceRange(this, 2000, Infinity)">
                            <input type="radio" name="price" value="2000+" hidden>
                            <span class="check"></span> TK 2,000+
                        </label>
                        <label class="filter-option" onclick="setPriceRange(this, 0, Infinity)">
                            <input type="radio" name="price" value="all" checked hidden>
                            <span class="check"></span> All Prices
                        </label>
                    </div>
                </div>

                <button class="btn-clear" onclick="clearFilters()"><i class="fas fa-redo"></i> Clear All Filters</button>
            </aside>

            <!-- Products Area -->
            <div class="ap-main">
                <!-- Toolbar -->
                <div class="ap-toolbar">
                    <button class="filter-toggle" onclick="toggleSidebar()">
                        <i class="fas fa-sliders-h"></i> Filters
                    </button>
                    <div class="ap-meta">
                        Showing <strong id="resultCount">0</strong> products
                    </div>
                    <div class="ap-sort">
                        <label for="sortSelect">Sort:</label>
                        <select id="sortSelect" onchange="sortProducts()">
                            <option value="default">Default</option>
                            <option value="price-asc">Price: Low to High</option>
                            <option value="price-desc">Price: High to Low</option>
                            <option value="name">Name: A–Z</option>
                            <option value="discount">Biggest Discount</option>
                        </select>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="product-grid" id="productGrid"></div>

                <!-- Pagination -->
                <div class="ap-pagination" id="apPagination"></div>
            </div>
        </div>
    </div>
</section>

<script>
    window.NF_PRODUCTS = @json($products);
</script>
@endsection
