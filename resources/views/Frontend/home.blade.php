@extends('Frontend.Layout.app')

@section('content')

<!-- Hero Slider -->
@if ($sliders->isNotEmpty())
<section class="hero">
    <div class="hero-slides" id="heroSlides">
        @foreach ($sliders as $slide)
            <div class="hero-slide">
                <img class="bg-img" src="{{ Storage::url($slide->image) }}" alt="{{ $slide->title }}">
                <div class="overlay"></div>
                <div class="container">
                    <div class="content">
                        @if ($slide->badge)
                            <div class="badge">
                                @if ($slide->badge_icon)<i class="{{ $slide->badge_icon }}"></i> @endif
                                {{ $slide->badge }}
                            </div>
                        @endif
                        <h1>{!! e($slide->title) !!}@if ($slide->subtitle)<br><span>{{ $slide->subtitle }}</span>@endif</h1>
                        @if ($slide->description)
                            <p>{{ $slide->description }}</p>
                        @endif
                        @if ($slide->button_text)
                            <a href="{{ $slide->button_link ?: '#' }}" class="btn-primary"><i class="fas fa-shopping-bag"></i> {{ $slide->button_text }}</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if ($sliders->count() > 1)
        <div class="hero-arrows">
            <button onclick="slideHero(-1)"><i class="fas fa-chevron-left"></i></button>
            <button onclick="slideHero(1)"><i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="hero-dots" id="heroDots">
            @foreach ($sliders as $i => $slide)
                <button class="dot {{ $i === 0 ? 'active' : '' }}" onclick="goToSlide({{ $i }})"></button>
            @endforeach
        </div>
    @endif
</section>
@endif

<!-- Trust Bar -->
@if ($trustItems->isNotEmpty())
<section class="trust-bar">
    <div class="container">
        @foreach ($trustItems as $item)
            <div class="trust-item">
                <div class="icon"><i class="{{ $item->icon ?: 'fas fa-circle-check' }}"></i></div>
                <div><h4>{{ $item->title }}</h4>@if ($item->description)<p>{{ $item->description }}</p>@endif</div>
            </div>
        @endforeach
    </div>
</section>
@endif

<!-- Categories -->
@if ($homeCategories->isNotEmpty())
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2><i class="fas fa-th-large"></i> Shop by Category</h2>
            <a href="{{ route('all-products') }}">View All <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="cat-grid">
            @foreach ($homeCategories as $cat)
                <a href="{{ route('category-products') }}?cat={{ $cat->slug }}" class="cat-card">
                    <div class="img-wrap">
                        @if ($cat->image)
                            <img src="{{ Storage::url($cat->image) }}" alt="{{ $cat->name }}">
                        @elseif ($cat->icon)
                            <i class="fas {{ $cat->icon }} text-4xl text-[#787c82]"></i>
                        @endif
                    </div>
                    <h4>{{ $cat->name }}</h4>
                    <span>{{ $cat->products_count }} item{{ $cat->products_count === 1 ? '' : 's' }}</span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Latest Products -->
@if ($latestProducts->isNotEmpty())
<section class="section" style="background:#fff">
    <div class="container">
        <div class="section-header">
            <h2><i class="fas fa-clock"></i> Latest Products</h2>
            <a href="{{ route('all-products') }}">View All <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="product-grid">
            @foreach ($latestProducts as $product)
                @php
                    $hasSale = $product->sale_price && $product->sale_price < $product->selling_price;
                    $current = $hasSale ? $product->sale_price : $product->selling_price;
                    $old = $hasSale ? $product->selling_price : null;
                    $discount = $hasSale && $product->selling_price > 0
                        ? (int) round((($product->selling_price - $product->sale_price) / $product->selling_price) * 100)
                        : 0;
                    $stock = (int) ($product->stock ?? 0);
                    $oos = $product->type !== 'digital' && $stock <= 0;
                @endphp
                <div class="product-card fade-up" data-id="{{ $product->id }}">
                    @if ($oos)
                        <span class="badge" style="background:#dc2626">Out of Stock</span>
                    @elseif ($discount > 0)
                        <span class="badge">-{{ $discount }}%</span>
                    @endif
                    <button class="wish"><i class="far fa-heart"></i></button>
                    <a href="{{ route('product-details') }}?slug={{ $product->slug }}" class="img-wrap"
                       style="{{ $oos ? 'opacity:.65' : '' }}">
                        @if ($product->thumbnail)
                            <img src="{{ Storage::url($product->thumbnail) }}" alt="{{ $product->name }}">
                        @endif
                    </a>
                    <div class="info">
                        <a href="{{ route('product-details') }}?slug={{ $product->slug }}" class="title">{{ $product->name }}</a>
                        <div class="stock" @if($oos) style="color:#dc2626" @endif>
                            <i class="fas {{ $oos ? 'fa-times-circle' : 'fa-check-circle' }}"></i>
                            @if ($oos) Out of Stock
                            @elseif ($stock > 0) {{ $stock }} In Stock
                            @else In Stock
                            @endif
                        </div>
                        <div class="price">
                            <span class="cur">TK {{ number_format($current) }}</span>
                            @if ($old)
                                <span class="old">TK {{ number_format($old) }}</span>
                            @endif
                        </div>
                        @if ($oos)
                            <button class="btn-order" disabled style="opacity:.5;cursor:not-allowed;background:#9ca3af;border-color:#9ca3af">
                                <i class="fas fa-times-circle"></i> Out of Stock
                            </button>
                        @else
                            <button class="btn-order"><i class="fas fa-shopping-cart"></i> Order Now</button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Deals Banner -->
@if ($dealsBanner)
<section class="deals-banner">
    <div class="container">
        <h2>{{ $dealsBanner->emoji }} {{ $dealsBanner->title }} @if ($dealsBanner->title_highlight)<span>{{ $dealsBanner->title_highlight }}</span>@endif</h2>
        @if ($dealsBanner->description)
            <p>{{ $dealsBanner->description }}</p>
        @endif
        @if ($dealsBanner->button_text)
            <a href="{{ $dealsBanner->button_link ?: '#' }}" class="btn-deal"><i class="fas fa-bolt"></i> {{ $dealsBanner->button_text }}</a>
        @endif
    </div>
</section>
@endif

<!-- All Products -->
@if ($allProducts->isNotEmpty())
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2><i class="fas fa-store"></i> All Products</h2>
            <a href="{{ route('all-products') }}">View All <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="product-grid">
            @foreach ($allProducts as $product)
                @php
                    $hasSale = $product->sale_price && $product->sale_price < $product->selling_price;
                    $current = $hasSale ? $product->sale_price : $product->selling_price;
                    $old = $hasSale ? $product->selling_price : null;
                    $discount = $hasSale && $product->selling_price > 0
                        ? (int) round((($product->selling_price - $product->sale_price) / $product->selling_price) * 100)
                        : 0;
                    $stock = (int) ($product->stock ?? 0);
                    $oos = $product->type !== 'digital' && $stock <= 0;
                @endphp
                <div class="product-card fade-up" data-id="{{ $product->id }}">
                    @if ($oos)
                        <span class="badge" style="background:#dc2626">Out of Stock</span>
                    @elseif ($discount > 0)
                        <span class="badge">-{{ $discount }}%</span>
                    @endif
                    <button class="wish"><i class="far fa-heart"></i></button>
                    <a href="{{ route('product-details') }}?slug={{ $product->slug }}" class="img-wrap"
                       style="{{ $oos ? 'opacity:.65' : '' }}">
                        @if ($product->thumbnail)
                            <img src="{{ Storage::url($product->thumbnail) }}" alt="{{ $product->name }}">
                        @endif
                    </a>
                    <div class="info">
                        <a href="{{ route('product-details') }}?slug={{ $product->slug }}" class="title">{{ $product->name }}</a>
                        <div class="stock" @if($oos) style="color:#dc2626" @endif>
                            <i class="fas {{ $oos ? 'fa-times-circle' : 'fa-check-circle' }}"></i>
                            @if ($oos) Out of Stock
                            @elseif ($stock > 0) {{ $stock }} In Stock
                            @else In Stock
                            @endif
                        </div>
                        <div class="price">
                            <span class="cur">TK {{ number_format($current) }}</span>
                            @if ($old)
                                <span class="old">TK {{ number_format($old) }}</span>
                            @endif
                        </div>
                        @if ($oos)
                            <button class="btn-order" disabled style="opacity:.5;cursor:not-allowed;background:#9ca3af;border-color:#9ca3af">
                                <i class="fas fa-times-circle"></i> Out of Stock
                            </button>
                        @else
                            <button class="btn-order"><i class="fas fa-shopping-cart"></i> Order Now</button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
