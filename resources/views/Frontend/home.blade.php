@extends('Frontend.Layout.app')

@section('content')
    <main id="main-content" class="wd-content-layout content-layout-wrapper container" role="main">

        <div class="wd-content-area site-content">
            <article id="post-591" class="entry-content post-591 page type-page status-publish has-post-thumbnail hentry">

                <div class="wp-block-wd-row wd-7ae8bcf1">
                    <div class="wp-block-wd-column wd-1083b687">
                        <h2 class="wp-block-wd-title title wd-47de8d1e">{{ \App\Models\SiteSetting::get('home_hero_title', 'Level Up Your Gear!') }}</h2>

                        <h2 class="wp-block-wd-title title wd-56e5e720 wd-custom-width">{{ \App\Models\SiteSetting::get('home_hero_subtitle', 'Official Merch for Every Gamer – Shop Hoodies, Collectibles, Posters, and More!') }}</h2>
                    </div>

                    <div class="wp-block-wd-column wd-03826530">
                        <link rel="stylesheet" id="wd-woo-categories-loop-css"
                            href="merchandise/wp-content/themes/woodmart/css/parts/woo-categories-loop.css" type="text/css"
                            media="all" />
                        <link rel="stylesheet" id="wd-categories-loop-css"
                            href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-categories-loop-old.css') }}"
                            type="text/css" media="all" />
                        <div class="products wd-carousel-container wd-cats-element  wd-37bdf58d wd-img-width wd-cats">
                            <div class="wd-carousel-inner">
                                <div class="wd-carousel wd-grid scroll-init" data-scroll_per_page="yes"
                                    style="--wd-col-lg:5;--wd-col-md:5;--wd-col-sm:3;--wd-gap-lg:20px;--wd-gap-sm:10px;">
                                    <div class="wd-carousel-wrap">
                                        @foreach($homeCategories as $cat)
                                        <div class="wd-carousel-item">
                                            <div class="category-grid-item wd-cat cat-design-alt without-product-count wd-with-subcat product-category product {{ $loop->first ? 'first' : '' }} {{ $loop->last ? 'last' : '' }}"
                                                data-loop="{{ $loop->iteration }}">
                                                <div class="wd-cat-inner wrapp-category">
                                                    <div class="wd-cat-thumb category-image-wrapp">
                                                        <a class="wd-cat-image category-image"
                                                            href="{{ route('category-products') }}?cat={{ $cat->slug }}"
                                                            aria-label="{{ $cat->name }}">
                                                            @if($cat->image)
                                                            <img {{ $loop->index > 1 ? 'loading=lazy' : '' }} decoding="async" width="150" height="150"
                                                                src="{{ Storage::url($cat->image) }}"
                                                                class="attachment-150x150 size-150x150"
                                                                alt="{{ $cat->name }}"
                                                                style="object-fit: cover; width: 150px; height: 150px;" />
                                                            @else
                                                            <img {{ $loop->index > 1 ? 'loading=lazy' : '' }} decoding="async" width="150" height="150"
                                                                src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-category-figures-150x150.jpg.webp') }}"
                                                                class="attachment-150x150 size-150x150"
                                                                alt="{{ $cat->name }}" />
                                                            @endif
                                                        </a>
                                                    </div>
                                                    <div class="wd-cat-content hover-mask">
                                                        <h3 class="wd-entities-title">{{ $cat->name }}</h3>
                                                        @if(($cat->products_count ?? 0) > 0)
                                                            <span class="wd-cat-count" style="font-size:11px;opacity:.75">{{ $cat->products_count }} products</span>
                                                        @endif
                                                    </div>
                                                    <a class="wd-fill category-link"
                                                        href="{{ route('category-products') }}?cat={{ $cat->slug }}"
                                                        aria-label="Product category {{ strtolower($cat->name) }}"></a>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="wd-nav-arrows wd-pos-sep wd-hover-1 wd-icon-1">
                                    <div class="wd-btn-arrow wd-prev wd-disabled">
                                        <div class="wd-arrow-inner"></div>
                                    </div>
                                    <div class="wd-btn-arrow wd-next">
                                        <div class="wd-arrow-inner"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                @if($trustItems->isNotEmpty())
                <div class="wp-block-wd-carousel wd-carousel-container wd-trust-strip wd-090647c4">
                    <div class="wd-carousel-inner">
                        <div class="wd-carousel wd-grid scroll-init"
                            style="--wd-col-lg:4;--wd-col-md:3;--wd-col-sm:1;--wd-gap-lg:20px;--wd-gap-sm:10px"
                            data-scroll_per_page="yes">
                            <div class="wd-carousel-wrap">
                                @foreach($trustItems as $item)
                                <div class="wp-block-wd-carousel-item wd-carousel-item">
                                    <div class="wp-block-wd-infobox wd-hover-parent wd-align wd-icon-top">
                                        @if($item->icon)
                                            @php $trustIconClass = str_contains($item->icon, ' ') ? $item->icon : 'fas ' . $item->icon; @endphp
                                            <div class="wp-block-wd-icon"><i class="{{ $trustIconClass }}" style="font-size:28px"></i></div>
                                        @endif
                                        <div class="wp-block-wd-container wd-dir-col">
                                            <h2 class="wp-block-wd-title title">{{ $item->title }}</h2>
                                            @if($item->description)
                                                <p class="wp-block-wd-paragraph">{{ $item->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="wd-nav-arrows wd-pos-sep wd-hover-1 wd-icon-1">
                            <div class="wd-btn-arrow wd-prev">
                                <div class="wd-arrow-inner"></div>
                            </div>
                            <div class="wd-btn-arrow wd-next">
                                <div class="wd-arrow-inner"></div>
                            </div>
                        </div>
                    </div>
                    <div class="wd-nav-scroll wd-hide-lg"></div>
                </div>
                @endif

                <div class="wp-block-wd-slider wd-slider wd-carousel-container wd-anim-slide wd-autoplay-on wd-14565c68">
                    <div class="wd-carousel-inner">
                        <div class="wd-carousel wd-grid" data-effect="slide" data-wrap="yes" data-autoheight="yes"
                            data-sliding_speed="700" style="--wd-col-lg:1;--wd-col-md:1;--wd-col-sm:1"
                            data-autoplay="yes" data-speed="20000">
                            <div class="wd-carousel-wrap">
                                @foreach($sliders as $slider)
                                <div
                                    class="wp-block-wd-slider-item wd-slide wd-carousel-item {{ $loop->even ? 'color-scheme-dark' : 'color-scheme-light' }}">
                                    <div class="wd-slide-container">
                                        <h2 class="wp-block-wd-title title wd-custom-width">{{ $slider->title }}</h2>

                                        @if($slider->subtitle)
                                        <p class="wp-block-wd-paragraph wd-hide-sm">{{ $slider->subtitle }}</p>
                                        @endif

                                        @if($slider->description)
                                        <p class="wp-block-wd-paragraph wd-hide-sm">{{ $slider->description }}</p>
                                        @endif

                                        <a class="wp-block-wd-button btn btn-style-default btn-color-primary btn-size-large btn-shape-semi-round"
                                            href="{{ route('all-products') }}"><span>Shop
                                                now</span></a>
                                    </div>
                                    <div class="wd-slide-bg wd-fill"><img decoding="async" width="1294" height="600"
                                            src="{{ Storage::url($slider->image) }}" alt="{{ $slider->title }}" /></div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div
                        class="wd-nav-pagin-wrap wd-slider-pagin wd-custom-style wd-style-shape-3 wd-align color-scheme-dark">
                        <ul class="wd-nav-pagin"></ul>
                    </div>
                </div>

                <div class="wp-block-wd-gallery wd-carousel-container wd-caption-mask wd-5c0b6672">
                    <div class="wd-carousel-inner">
                        <div class="wd-carousel wd-grid scroll-init"
                            style="--wd-col-lg:8;--wd-col-md:5;--wd-col-sm:3;--wd-gap-lg:20px;--wd-gap-sm:10px"
                            data-scroll_per_page="yes">
                            <div class="wd-carousel-wrap">
                                @foreach($brands as $brand)
                                <div class="wp-block-wd-gallery-item wd-carousel-item">
                                    <div class="wd-block-image"><a href="{{ route('all-products') }}" class="wd-block-image-link"><img
                                                loading="lazy" decoding="async" width="408" height="230"
                                                src="{{ Storage::url($brand->icon) }}"
                                                alt="{{ $brand->name }}" /></a></div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="wd-nav-arrows wd-pos-sep wd-hover-1 wd-icon-1">
                            <div class="wd-btn-arrow wd-prev">
                                <div class="wd-arrow-inner"></div>
                            </div>
                            <div class="wd-btn-arrow wd-next">
                                <div class="wd-arrow-inner"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wp-block-wd-container wd-dir-row wd-align-is-lg-center wd-fedb8996">
                    <h2 class="wp-block-wd-title title wd-8155d366">Best Sellers</h2>

                    <a class="wp-block-wd-button btn btn-style-default btn-size-default btn-shape-semi-round btn-icon-pos-right wd-12db7e54"
                        href="{{ route('all-products') }}"><span>View more</span>
                        <div class="wp-block-wd-icon wd-56c1d5ff"><img loading="lazy" decoding="async" width="16"
                                height="17" class="wp-image-1013"
                                src="merchandise/wp-content/uploads/sites/31/2025/11/wd-merchandise-long-arrow-black-1.svg"
                                alt="" /></div>
                    </a>
                </div>

                <link rel="stylesheet" id="wd-product-loop-css"
                    href="merchandise/wp-content/themes/woodmart/css/parts/woo-product-loop.css" type="text/css"
                    media="all" />
                <link rel="stylesheet" id="wd-woo-loop-prod-el-base-css"
                    href="merchandise/wp-content/themes/woodmart/css/parts/woo-loop-prod-el-base.css" type="text/css"
                    media="all" />
                <link rel="stylesheet" id="wd-woo-loop-prod-predefined-css"
                    href="merchandise/wp-content/themes/woodmart/css/parts/woo-loop-prod-predefined.css" type="text/css"
                    media="all" />
                <link rel="stylesheet" id="wd-product-loop-quick-css"
                    href="merchandise/wp-content/themes/woodmart/css/parts/woo-product-loop-quick.css" type="text/css"
                    media="all" />
                <link rel="stylesheet" id="wd-woo-mod-loop-prod-add-btn-replace-css"
                    href="merchandise/wp-content/themes/woodmart/css/parts/woo-mod-loop-prod-add-btn-replace.css"
                    type="text/css" media="all" />
                <link rel="stylesheet" id="wd-woo-opt-stretch-cont-css"
                    href="merchandise/wp-content/themes/woodmart/css/parts/woo-opt-stretch-cont.css" type="text/css"
                    media="all" />
                <link rel="stylesheet" id="wd-woo-opt-stretch-cont-predefined-css"
                    href="merchandise/wp-content/themes/woodmart/css/parts/woo-opt-stretch-cont-predefined.css"
                    type="text/css" media="all" />
                <link rel="stylesheet" id="wd-bordered-product-css"
                    href="merchandise/wp-content/themes/woodmart/css/parts/woo-opt-bordered-product.css" type="text/css"
                    media="all" />
                <link rel="stylesheet" id="wd-bordered-product-predefined-css"
                    href="merchandise/wp-content/themes/woodmart/css/parts/woo-opt-bordered-product-predefined.css"
                    type="text/css" media="all" />
                <link rel="stylesheet" id="wd-woo-opt-title-limit-predefined-css"
                    href="merchandise/wp-content/themes/woodmart/css/parts/woo-opt-title-limit-predefined.css"
                    type="text/css" media="all" />
                <div id="carousel-879"
                    class="wd-carousel-container  wd-e77fab64 wd-products-element wd-products products wd-loop-builder-off wd-stretch-cont-lg wd-stretch-cont-md wd-stretch-cont-sm products-bordered-grid-ins title-line-one">

                    <div class="wd-carousel-inner">
                        <div class=" wd-carousel wd-grid scroll-init" data-scroll_per_page="yes"
                            style="--wd-col-lg:4;--wd-col-md:4;--wd-col-sm:2;--wd-gap-lg:20px;--wd-gap-sm:10px;">
                            <div class="wd-carousel-wrap">
                                @foreach($bestSellers as $product)
                                    @include('Frontend.partials.product-card', ['product' => $product, 'bestSellerIds' => $bestSellerIds])
                                @endforeach
                        </div>

                        <div class="wd-nav-arrows wd-pos-sep wd-hover-1 wd-icon-1">
                            <div class="wd-btn-arrow wd-prev wd-disabled">
                                <div class="wd-arrow-inner"></div>
                            </div>
                            <div class="wd-btn-arrow wd-next">
                                <div class="wd-arrow-inner"></div>
                            </div>
                        </div>
                    </div>

                    <div class="wd-nav-scroll"></div>
                </div>

                @if($dealsBanner && $dealsBanner->title)
                <div class="wp-block-wd-container wd-dir-row wd-align-is-lg-center wd-deals-banner"
                    style="background:#111;color:#fff;border-radius:12px;padding:24px 28px;margin:24px 0;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
                    <div>
                        @if($dealsBanner->emoji)
                            <span style="font-size:22px;margin-right:8px">{{ $dealsBanner->emoji }}</span>
                        @endif
                        <strong style="font-size:20px">{{ $dealsBanner->title }}</strong>
                        @if($dealsBanner->title_highlight)
                            <span style="color:#ffb020;font-weight:700"> {{ $dealsBanner->title_highlight }}</span>
                        @endif
                        @if($dealsBanner->description)
                            <p style="margin:6px 0 0;opacity:.85">{{ $dealsBanner->description }}</p>
                        @endif
                    </div>
                    @if($dealsBanner->button_text)
                        <a class="btn btn-style-default btn-color-primary btn-size-default btn-shape-semi-round"
                            href="{{ $dealsBanner->button_link ?: route('all-products') }}"><span>{{ $dealsBanner->button_text }}</span></a>
                    @endif
                </div>
                @endif

                @if($latestProducts->isNotEmpty())
                <div class="wp-block-wd-container wd-dir-row wd-align-is-lg-center wd-fedb8996">
                    <h2 class="wp-block-wd-title title">New Arrivals</h2>

                    <a class="wp-block-wd-button btn btn-style-default btn-size-default btn-shape-semi-round btn-icon-pos-right"
                        href="{{ route('all-products') }}"><span>View more</span>
                        <div class="wp-block-wd-icon"><img loading="lazy" decoding="async" width="16"
                                height="17"
                                src="merchandise/wp-content/uploads/sites/31/2025/11/wd-merchandise-long-arrow-black-1.svg"
                                alt="" /></div>
                    </a>
                </div>

                <div id="carousel-new-arrivals"
                    class="wd-carousel-container wd-products-element wd-products products wd-loop-builder-off wd-stretch-cont-lg wd-stretch-cont-md wd-stretch-cont-sm products-bordered-grid-ins title-line-one">
                    <div class="wd-carousel-inner">
                        <div class="wd-carousel wd-grid scroll-init" data-scroll_per_page="yes"
                            style="--wd-col-lg:4;--wd-col-md:4;--wd-col-sm:2;--wd-gap-lg:20px;--wd-gap-sm:10px;">
                            <div class="wd-carousel-wrap">
                                @foreach($latestProducts as $product)
                                    @include('Frontend.partials.product-card', ['product' => $product, 'bestSellerIds' => $bestSellerIds])
                                @endforeach
                            </div>
                        </div>
                        <div class="wd-nav-arrows wd-pos-sep wd-hover-1 wd-icon-1">
                            <div class="wd-btn-arrow wd-prev wd-disabled">
                                <div class="wd-arrow-inner"></div>
                            </div>
                            <div class="wd-btn-arrow wd-next">
                                <div class="wd-arrow-inner"></div>
                            </div>
                        </div>
                    </div>
                    <div class="wd-nav-scroll"></div>
                </div>
                @endif

                @if($homeReviews->isNotEmpty())
                <div class="wp-block-wd-container wd-dir-row wd-align-is-lg-center wd-fedb8996">
                    <h2 class="wp-block-wd-title title">What Our Customers Say</h2>
                </div>
                <div class="wd-carousel-container wd-home-reviews"
                    style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:20px;margin-bottom:24px;">
                    @foreach($homeReviews as $review)
                        <div class="wd-review-card"
                            style="border:1px solid #e5e5e5;border-radius:10px;padding:18px;">
                            <div class="star-rating" role="img" aria-label="Rated {{ $review->rating }} out of 5">
                                <span style="width:{{ $review->rating / 5 * 100 }}%">
                                    Rated <strong class="rating">{{ $review->rating }}</strong> out of 5
                                </span>
                            </div>
                            <p style="margin:10px 0">{{ \Illuminate\Support\Str::limit($review->comment, 160) }}</p>
                            @if(!empty($review->photos))
                                <div class="wd-review-photos" style="display:flex;gap:6px;margin-bottom:10px;">
                                    @foreach(array_slice($review->photos, 0, 4) as $photo)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($photo) }}" alt="Customer photo"
                                            loading="lazy" width="56" height="56"
                                            style="width:56px;height:56px;object-fit:cover;border-radius:6px;" />
                                    @endforeach
                                </div>
                            @endif
                            <strong>{{ $review->name }}</strong>
                            @if($review->product)
                                <div style="font-size:12px;opacity:.7">on
                                    <a href="{{ route('product-details') }}?slug={{ $review->product->slug }}">{{ $review->product->name }}</a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @endif

                @if($allProducts->isNotEmpty())
                <div class="wp-block-wd-container wd-dir-row wd-align-is-lg-center wd-fedb8996">
                    <h2 class="wp-block-wd-title title">Featured Products</h2>

                    <a class="wp-block-wd-button btn btn-style-default btn-size-default btn-shape-semi-round btn-icon-pos-right"
                        href="{{ route('all-products') }}"><span>View more</span>
                        <div class="wp-block-wd-icon"><img loading="lazy" decoding="async" width="16"
                                height="17"
                                src="merchandise/wp-content/uploads/sites/31/2025/11/wd-merchandise-long-arrow-black-1.svg"
                                alt="" /></div>
                    </a>
                </div>

                <div id="carousel-featured"
                    class="wd-carousel-container wd-products-element wd-products products wd-loop-builder-off wd-stretch-cont-lg wd-stretch-cont-md wd-stretch-cont-sm products-bordered-grid-ins title-line-one">
                    <div class="wd-carousel-inner">
                        <div class="wd-carousel wd-grid scroll-init" data-scroll_per_page="yes"
                            style="--wd-col-lg:4;--wd-col-md:4;--wd-col-sm:2;--wd-gap-lg:20px;--wd-gap-sm:10px;">
                            <div class="wd-carousel-wrap">
                                @foreach($allProducts as $product)
                                    @include('Frontend.partials.product-card', ['product' => $product, 'bestSellerIds' => $bestSellerIds])
                                @endforeach
                            </div>
                        </div>
                        <div class="wd-nav-arrows wd-pos-sep wd-hover-1 wd-icon-1">
                            <div class="wd-btn-arrow wd-prev wd-disabled">
                                <div class="wd-arrow-inner"></div>
                            </div>
                            <div class="wd-btn-arrow wd-next">
                                <div class="wd-arrow-inner"></div>
                            </div>
                        </div>
                    </div>
                    <div class="wd-nav-scroll"></div>
                </div>
                @endif

                <div class="wp-block-wd-container wd-dir-col wd-align wd-066a5243 wd-newsletter-section">
                    <div class="wp-block-wd-image wd-block-image wd-9e91bcf0"><img loading="lazy" decoding="async"
                            width="48" height="48" class="wp-image-1021"
                            src="merchandise/wp-content/uploads/sites/31/2025/11/gms-mail-1.svg" alt="" /></div>

                    <h2 class="wp-block-wd-title title wd-29c12066">Subscribe and get 10% off your first
                        purchase</h2>

                    <p class="wp-block-wd-paragraph wd-a5b20c44">Will be used in accordance with our&nbsp;<a
                            href="{{ route('privacy-policy') }}"><span class="wd-highlight">Privacy Policy</span></a></p>

                    <form id="newsletter-form" class="wd-custom-width" method="post" action="{{ route('newsletter.subscribe') }}">
                        @csrf
                        <div class="wd-grid-f-stretch" style="--wd-gap: 10px">
                            <div class="wd-col"><input type="email" name="email" id="newsletter-email"
                                    placeholder="Your email address" required /></div>
                            <div class="wd-col-auto"><input type="submit" value="Sign up" /></div>
                        </div>
                        <div class="newsletter-message" style="margin-top:8px;font-size:14px;"></div>
                    </form>
                </div>

                <div class="wp-block-wd-container wd-dir-col wd-align wd-cdd11e25 wd-hide-mobile-insta">
                    <h2 class="wp-block-wd-title title wd-ac487a7f">Connect to our Instagram</h2>

                    <p class="wp-block-wd-paragraph wd-1bfa0982">Follow us on Instagram, keep up to date with
                        new products and share your impressions</p>

                    <a class="wp-block-wd-button btn btn-style-bordered btn-size-default btn-shape-round wd-172b7370"
                        href="https://www.instagram.com/xtemos.studio/"><span>@xtemos.studio</span></a>

                    <link rel="stylesheet" id="wd-instagram-css"
                        href="merchandise/wp-content/themes/woodmart/css/parts/el-instagram.css" type="text/css"
                        media="all" />
                    <div class="wd-insta  wd-0c7ef44c data-source-images">

                        <div class=" wd-grid-g"
                            style="--wd-col-lg:6;--wd-col-md:3;--wd-col-sm:3;--wd-gap-lg:20px;--wd-gap-sm:10px;">

                            <div class="wd-insta-item wd-col">
                                <a href="https://www.instagram.com/xtemos.studio/" target="_self"
                                    aria-label="Instagram picture"></a>

                                <img loading="lazy" decoding="async" width="256" height="256"
                                    src="merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-1.jpg.webp"
                                    class="attachment-medium size-medium" alt=""
                                    srcset="merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-1.jpg.webp 256w, merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-1-150x150.jpg.webp 150w, merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-1-100x100.jpg.webp 100w"
                                    sizes="auto, (max-width: 256px) 100vw, 256px" />
                                <div class="wd-insta-meta wd-grid-g">
                                    <span class="wd-insta-likes instagram-likes"><span>7337</span></span>
                                    <span class="wd-insta-comm instagram-comments"><span>287</span></span>
                                </div>
                            </div>

                            <div class="wd-insta-item wd-col">
                                <a href="https://www.instagram.com/xtemos.studio/" target="_self"
                                    aria-label="Instagram picture"></a>

                                <img loading="lazy" decoding="async" width="256" height="256"
                                    src="merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-2.jpg.webp"
                                    class="attachment-medium size-medium" alt=""
                                    srcset="merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-2.jpg.webp 256w, merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-2-150x150.jpg.webp 150w, merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-2-100x100.jpg.webp 100w"
                                    sizes="auto, (max-width: 256px) 100vw, 256px" />
                                <div class="wd-insta-meta wd-grid-g">
                                    <span class="wd-insta-likes instagram-likes"><span>6926</span></span>
                                    <span class="wd-insta-comm instagram-comments"><span>388</span></span>
                                </div>
                            </div>

                            <div class="wd-insta-item wd-col">
                                <a href="https://www.instagram.com/xtemos.studio/" target="_self"
                                    aria-label="Instagram picture"></a>

                                <img loading="lazy" decoding="async" width="256" height="256"
                                    src="merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-3.jpg.webp"
                                    class="attachment-medium size-medium" alt=""
                                    srcset="merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-3.jpg.webp 256w, merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-3-150x150.jpg.webp 150w, merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-3-100x100.jpg.webp 100w"
                                    sizes="auto, (max-width: 256px) 100vw, 256px" />
                                <div class="wd-insta-meta wd-grid-g">
                                    <span class="wd-insta-likes instagram-likes"><span>9605</span></span>
                                    <span class="wd-insta-comm instagram-comments"><span>992</span></span>
                                </div>
                            </div>

                            <div class="wd-insta-item wd-col">
                                <a href="https://www.instagram.com/xtemos.studio/" target="_self"
                                    aria-label="Instagram picture"></a>

                                <img loading="lazy" decoding="async" width="256" height="256"
                                    src="merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-4.jpg.webp"
                                    class="attachment-medium size-medium" alt=""
                                    srcset="merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-4.jpg.webp 256w, merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-4-150x150.jpg.webp 150w, merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-4-100x100.jpg.webp 100w"
                                    sizes="auto, (max-width: 256px) 100vw, 256px" />
                                <div class="wd-insta-meta wd-grid-g">
                                    <span class="wd-insta-likes instagram-likes"><span>5380</span></span>
                                    <span class="wd-insta-comm instagram-comments"><span>118</span></span>
                                </div>
                            </div>

                            <div class="wd-insta-item wd-col">
                                <a href="https://www.instagram.com/xtemos.studio/" target="_self"
                                    aria-label="Instagram picture"></a>

                                <img loading="lazy" decoding="async" width="256" height="256"
                                    src="merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-5.jpg.webp"
                                    class="attachment-medium size-medium" alt=""
                                    srcset="merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-5.jpg.webp 256w, merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-5-150x150.jpg.webp 150w, merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-5-100x100.jpg.webp 100w"
                                    sizes="auto, (max-width: 256px) 100vw, 256px" />
                                <div class="wd-insta-meta wd-grid-g">
                                    <span class="wd-insta-likes instagram-likes"><span>7061</span></span>
                                    <span class="wd-insta-comm instagram-comments"><span>218</span></span>
                                </div>
                            </div>

                            <div class="wd-insta-item wd-col">
                                <a href="https://www.instagram.com/xtemos.studio/" target="_self"
                                    aria-label="Instagram picture"></a>

                                <img loading="lazy" decoding="async" width="256" height="256"
                                    src="merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-6.jpg.webp"
                                    class="attachment-medium size-medium" alt=""
                                    srcset="merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-6.jpg.webp 256w, merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-6-150x150.jpg.webp 150w, merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-6-100x100.jpg.webp 100w"
                                    sizes="auto, (max-width: 256px) 100vw, 256px" />
                                <div class="wd-insta-meta wd-grid-g">
                                    <span class="wd-insta-likes instagram-likes"><span>5848</span></span>
                                    <span class="wd-insta-comm instagram-comments"><span>401</span></span>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </article>

        </div>

    </main>
@endsection
