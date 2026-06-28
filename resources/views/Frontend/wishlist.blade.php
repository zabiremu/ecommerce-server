@extends('Frontend.Layout.app')

@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb">
    <div class="container">
        <a href="{{ route('home') }}">Home</a>
        <i class="fas fa-chevron-right"></i>
        <span>Wishlist</span>
    </div>
</section>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1><i class="far fa-heart"></i> My Wishlist</h1>
        <p id="wishlistHeaderDesc">Your saved items</p>
    </div>
</section>

<!-- Wishlist Content -->
<section class="wishlist-section">
    <div class="container">
        <div class="wishlist-toolbar">
            <div class="ap-meta">
                Showing <strong id="wishlistCount">0</strong> item(s)
            </div>
        </div>
        <div class="product-grid" id="wishlistGrid"></div>

        <div class="wishlist-empty" id="wishlistEmpty">
            <div class="wishlist-empty-icon"><i class="far fa-heart"></i></div>
            <h2>Your wishlist is empty</h2>
            <p>Save your favorite products by tapping the heart icon on any product.</p>
            <a href="{{ route('all-products') }}" class="btn-order-lg"><i class="fas fa-store"></i> Browse Products</a>
        </div>
    </div>
</section>

<script>
    window.NF_PRODUCTS = @json($products);
</script>
@endsection
