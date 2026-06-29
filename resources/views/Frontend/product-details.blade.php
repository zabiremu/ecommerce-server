@extends('Frontend.Layout.app')

@php
    $hasSale = $product->sale_price && $product->sale_price < $product->selling_price;
    $current = $hasSale ? (float) $product->sale_price : (float) $product->selling_price;
    $old = $hasSale ? (float) $product->selling_price : null;
    $discount =
        $hasSale && $product->selling_price > 0
            ? (int) round((($product->selling_price - $product->sale_price) / $product->selling_price) * 100)
            : 0;
    $save = $old ? $old - $current : 0;
    $stock = (int) ($product->stock ?? 0);
    $oos = $product->type !== 'digital' && $stock <= 0;
    $gallery = collect($product->gallery ?? [])
        ->pluck('path')
        ->filter()
        ->values();
    $images = collect([$product->thumbnail])
        ->merge($gallery)
        ->filter()
        ->unique()
        ->values();
    $pageTitle = $product->name . ' — ' . \App\Models\SiteSetting::get('company_name', 'NF Shop 24');
@endphp

@section('title', $pageTitle)

@section('content')

    <main id="main-content" class="wd-content-layout content-layout-wrapper container wd-builder-on" role="main">
        <div class="wd-content-area site-content">
            <link rel="stylesheet" id="wd-woo-single-prod-builder-css"
                href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-single-prod-builder.css') }}"
                type="text/css" media="all" />
            <div id="product-201"
                class="single-product-page entry-content product type-product post-201 status-publish first instock product_cat-hats has-post-thumbnail shipping-taxable purchasable product-type-simple">
                <link rel="stylesheet" id="wd-block-fw-section-css"
                    href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/block-fw-section.css') }}"
                    type="text/css" media="all" />
                <link rel="stylesheet" id="wd-block-opt-sticky-css"
                    href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/block-opt-sticky.css') }}"
                    type="text/css" media="all" />
                <link rel="stylesheet" id="wd-block-title-css"
                    href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/block-title.css') }}"
                    type="text/css" media="all" />
                <link rel="stylesheet" id="wd-block-image-css"
                    href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/block-image.css') }}"
                    type="text/css" media="all" />
                <link rel="stylesheet" id="wd-block-paragraph-css"
                    href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/block-paragraph.css') }}"
                    type="text/css" media="all" />
                <link rel="stylesheet" id="wd-mc4wp-css"
                    href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/int-mc4wp.css') }}"
                    type="text/css" media="all" />
                <link rel="stylesheet" id="wd-button-css"
                    href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/el-button.css') }}"
                    type="text/css" media="all" />
                <link rel="stylesheet" id="wd-block-button-css"
                    href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/block-button.css') }}"
                    type="text/css" media="all" />
                <style id="wd-style-blocks-883-inline-css" data-type="wd-style-blocks-883">
                    .wd.wd .wd-b6a382a3 {
                        justify-content: space-between;
                        align-items: center;
                        align-content: center;
                        flex-wrap: wrap;
                        --wd-row-gap: 10px;
                    }

                    .wd.wd .wd-6c35a475 {
                        padding-top: 10px;
                        padding-bottom: 10px;
                        margin-top: -40px;
                        background-color: var(--wd-primary-color);
                    }

                    .wd.wd .wd-f798e673 .shop_attributes {
                        --wd-term-img-width: 110px;
                    }

                    .wd.wd .wd-f798e673 {
                        box-shadow: 0px 0px 2px 0px rgba(0, 0, 0, 0.12);
                        flex: 0 0 auto;
                    }

                    .wd.wd .wd-ef4cd637 {
                        justify-content: space-between;
                        align-items: center;
                        align-content: center;
                    }

                    .wd.wd .wd-94b00ced .wd-timer {
                        --wd-timer-shadow: 0px 0px 2px 0px rgba(0, 0, 0, 0.12);
                    }

                    .wd.wd .wd-39bfbee2 .meta-label {
                        line-height: 1.2em;
                    }

                    .wd.wd .wd-58f3a64c {
                        align-items: center;
                        align-content: center;
                        flex-wrap: wrap;
                    }

                    .wd.wd .wd-8e733563 :is(.price, del) {
                        color: var(--wd-alternative-color);
                    }

                    .wd.wd .wd-8e733563 .price del {
                        color: #bbbbbb;
                    }

                    .wd.wd .wd-8e733563 .price {
                        font-size: 32px;
                    }

                    .wd.wd .wd-d6cacb3f {
                        align-items: center;
                        align-content: center;
                        flex-wrap: wrap;
                        margin-top: 10px;
                    }

                    .wd.wd .wd-ca100415 {
                        margin-top: 40px;
                    }

                    .wd.wd .wd-45069eb1 {
                        padding-top: 15px;
                        border-style: solid;
                        border-color: rgba(0, 0, 0, 0.11);
                        border-width: 1px 0px 0px 0px;
                    }

                    .wd.wd .wd-15ca6b8c {
                        align-self: start;
                    }

                    .wd.wd .wd-3c5dd53c {
                        margin-bottom: 80px;
                    }

                    .wd.wd .wd-0a56a3eb {
                        font-size: 40px;
                        line-height: 1.2em;
                    }

                    .wd.wd .wd-e3807c2b {
                        padding-top: 40px;
                        margin-top: 40px;
                        border-style: solid;
                        border-color: rgba(0, 0, 0, 0.11);
                        border-width: 1px 0px 0px 0px;
                    }

                    .wd.wd .wd-ba40f768 {
                        font-size: 40px;
                        line-height: 1.2em;
                    }

                    .wd.wd .wd-2dcc2a15 {
                        padding-top: 40px;
                        margin-top: 40px;
                        margin-bottom: 90px;
                        border-style: solid;
                        border-color: rgba(0, 0, 0, 0.11);
                        border-width: 1px 0px 0px 0px;
                    }

                    .wd.wd .wd-b6e11ff7 img {
                        border-radius: 0px;
                    }

                    .wd.wd .wd-6e5b80bc {
                        font-size: 32px;
                        line-height: 1.2em;
                    }

                    .wd.wd .wd-329fde28 .wd-highlight {
                        text-decoration: underline;
                    }

                    .wd.wd .wd-569ca4cc {
                        --wd-form-bg: #fefefe;
                        --wd-width: 520px;
                    }

                    .wd.wd .wd-90066ecc {
                        --wd-align: var(--wd-center);
                        padding: 50px 30px 50px 30px;
                        margin-bottom: 90px;
                        background-color: #f5f5f5;
                        border-radius: 16px;
                    }

                    .wd.wd .wd-ac487a7f {
                        font-size: 40px;
                        line-height: 1.2em;
                    }

                    .wd.wd .wd-0c7ef44c {
                        --wd-aspect-ratio: 1/1;
                        margin-top: 10px;
                    }

                    .wd.wd .wd-cdd11e25 {
                        --wd-align: var(--wd-center);
                        margin-bottom: 20px;
                    }

                    @media (min-width: 769px) {
                        .wd.wd .wd-beead794 {
                            flex: 0 1 calc(60% - var(--wd-col-gap) * 1 / 2);
                        }

                        .wd.wd .wd-15ca6b8c {
                            flex: 0 1 calc(40% - var(--wd-col-gap) * 1 / 2);
                        }
                    }

                    @media (max-width: 1024px) {
                        .wd.wd .wd-beead794 {
                            align-self: start;
                        }

                        .wd.wd .wd-ef4cd637 {
                            flex-wrap: wrap;
                        }

                        .wd.wd .wd-8e733563 .price {
                            font-size: 26px;
                        }

                        .wd.wd .wd-3c5dd53c {
                            margin-bottom: 60px;
                        }

                        .wd.wd .wd-0a56a3eb {
                            font-size: 32px;
                        }

                        .wd.wd .wd-ba40f768 {
                            font-size: 32px;
                        }

                        .wd.wd .wd-2dcc2a15 {
                            margin-bottom: 70px;
                        }

                        .wd.wd .wd-6e5b80bc {
                            font-size: 28px;
                        }

                        .wd.wd .wd-90066ecc {
                            margin-bottom: 70px;
                        }

                        .wd.wd .wd-ac487a7f {
                            font-size: 32px;
                        }
                    }

                    @media (min-width: 769px) and (max-width: 1024px) {
                        .wd.wd .wd-beead794 {
                            flex: 0 1 calc(50% - var(--wd-col-gap) * 1 / 2);
                        }

                        .wd.wd .wd-15ca6b8c {
                            flex: 0 1 calc(50% - var(--wd-col-gap) * 1 / 2);
                        }
                    }

                    @media (max-width: 768.98px) {
                        .wd.wd .wd-8e733563 .price {
                            font-size: 22px;
                        }

                        .wd.wd .wd-d6cacb3f {
                            align-items: start;
                            align-content: start;
                        }

                        .wd.wd .wd-0a56a3eb {
                            font-size: 28px;
                        }

                        .wd.wd .wd-e3807c2b {
                            border-width: 0px;
                        }

                        .wd.wd .wd-ba40f768 {
                            font-size: 28px;
                        }

                        .wd.wd .wd-2dcc2a15 {
                            margin-bottom: 50px;
                            border-width: 0px;
                        }

                        .wd.wd .wd-6e5b80bc {
                            font-size: 22px;
                        }

                        .wd.wd .wd-90066ecc {
                            padding-top: 30px;
                            padding-bottom: 30px;
                            margin-bottom: 50px;
                        }

                        .wd.wd .wd-ac487a7f {
                            font-size: 28px;
                        }

                        .wd.wd .wd-cdd11e25 {
                            margin-bottom: 0px;
                        }
                    }
                </style>

                <div class="wp-block-wd-section wd-6c35a475">
                    <div class="wp-block-wd-container wd-dir-row wd-align-is-lg-center wd-b6a382a3">
                        <link rel="stylesheet" id="wd-mod-breadcrumbs-no-wrap-css"
                            href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/mod-breadcrumbs-no-wrap.css') }}"
                            type="text/css" media="all" />
                        <div class="wd-el-breadcrumbs wd-8a950701 wd-nowrap-md">
                            <nav class="wd-breadcrumbs woocommerce-breadcrumb" aria-label="Breadcrumb"> <a
                                    href="index.htmlmerchandise">
                                    Home </a>
                                <span class="wd-delimiter">/</span> <a href="products.html">
                                    Apparel </a>
                                <span class="wd-delimiter">/</span> <a href="products.html" class="wd-last-link">
                                    Hats </a>
                                <span class="wd-delimiter">/</span> <span class="wd-last">
                                    8 Bit Hearts Cap </span>
                            </nav>
                        </div>


                        <div class="wd-single-nav wd-339a2961">
                            <link rel="stylesheet" id="wd-woo-single-prod-el-navigation-css"
                                href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-single-prod-el-navigation.css') }}"
                                type="text/css" media="all" />
                            <div class="wd-products-nav">
                                <div class="wd-event-hover">
                                    <a class="wd-product-nav-btn wd-btn-prev" href="product_details.html"
                                        aria-label="Previous product"></a>

                                    <div class="wd-dropdown">
                                        <a href="product_details.html" class="wd-product-nav-thumb">
                                            <img loading="lazy" width="150" height="150"
                                                src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/video-games-rot-your-brains-cap-150x150.jpeg.webp') }}"
                                                class="attachment-thumbnail size-thumbnail"
                                                alt="Video Games Rot Your Brains Cap" decoding="async"
                                                srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/video-games-rot-your-brains-cap-150x150.jpeg.webp') }} 150w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/video-games-rot-your-brains-cap-300x300.jpeg.webp') }} 300w"
                                                sizes="auto, (max-width: 150px) 100vw, 150px" /> </a>

                                        <div class="wd-product-nav-desc">
                                            <a href="product_details.html" class="wd-entities-title">
                                                Video Games Rot Your Brains Cap </a>

                                            <span class="price">
                                                <del aria-hidden="true"><span
                                                        class="woocommerce-Price-amount amount"><bdi><span
                                                                class="woocommerce-Price-currencySymbol">&#36;</span>19,99</bdi></span></del>
                                                <span class="screen-reader-text">Original price was:
                                                    &#036;19,99.</span><ins aria-hidden="true"><span
                                                        class="woocommerce-Price-amount amount"><bdi><span
                                                                class="woocommerce-Price-currencySymbol">&#36;</span>15,45</bdi></span></ins><span
                                                    class="screen-reader-text">Current price is:
                                                    &#036;15,45.</span> </span>
                                        </div>
                                    </div>
                                </div>

                                <a href="products.html" class="wd-product-nav-btn wd-btn-back wd-tooltip">
                                    <span>
                                        Back to products </span>
                                </a>

                                <div class="wd-event-hover">
                                    <a class="wd-product-nav-btn wd-btn-next" href="product_details.html"
                                        aria-label="Next product"></a>

                                    <div class="wd-dropdown">
                                        <a href="product_details.html" class="wd-product-nav-thumb">
                                            <img loading="lazy" width="150" height="150"
                                                src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/stardew-valley-dog-sleeping-zzz-bucket-hat-150x150.jpeg.webp') }}"
                                                class="attachment-thumbnail size-thumbnail"
                                                alt="Stardew Valley Dog sleeping zzz Bucket Hat" decoding="async"
                                                srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/stardew-valley-dog-sleeping-zzz-bucket-hat-150x150.jpeg.webp') }} 150w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/stardew-valley-dog-sleeping-zzz-bucket-hat-300x300.jpeg.webp') }} 300w"
                                                sizes="auto, (max-width: 150px) 100vw, 150px" /> </a>

                                        <div class="wd-product-nav-desc">
                                            <a href="product_details.html" class="wd-entities-title">
                                                Stardew Valley Dog sleeping zzz Bucket Hat </a>

                                            <span class="price">
                                                <span class="woocommerce-Price-amount amount"><bdi><span
                                                            class="woocommerce-Price-currencySymbol">&#36;</span>20,48</bdi></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wp-block-wd-row wd-3c5dd53c">
                    <div class="wp-block-wd-column wd-sticky-on-md-sm wd-beead794 wd-align-s-start-md">
                        <div class="wd-single-gallery wd-d2ea596d">
                            <link rel="stylesheet" id="wd-woo-single-prod-el-gallery-css"
                                href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-single-prod-el-gallery.css') }}"
                                type="text/css" media="all" />
                            <link rel="stylesheet" id="wd-swiper-css"
                                href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/lib-swiper.css') }}"
                                type="text/css" media="all" />
                            <div
                                class="woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images wd-has-thumb thumbs-position-bottom images image-action-zoom">
                                <div class="wd-carousel-container wd-gallery-images">
                                    <div class="wd-carousel-inner">


                                        <figure class="woocommerce-product-gallery__wrapper wd-carousel wd-grid"
                                            style="--wd-col-lg:1;--wd-col-md:1;--wd-col-sm:1;">
                                            <div class="wd-carousel-wrap">

                                                <div class="wd-carousel-item">
                                                    <figure
                                                        data-thumb="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-150x171.jpeg') }}"
                                                        data-thumb-alt="8 Bit Hearts Cap - Image 1"
                                                        class="woocommerce-product-gallery__image"><a
                                                            data-elementor-open-lightbox="no"
                                                            href="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap.jpeg') }}"><img
                                                                width="700" height="800"
                                                                src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap.jpeg.webp') }}"
                                                                class="wp-post-image wp-post-image"
                                                                alt="8 Bit Hearts Cap - Image 1"
                                                                title="8-bit-hearts-cap.jpeg" data-caption=""
                                                                data-src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap.jpeg') }}"
                                                                data-large_image="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap.jpeg') }}"
                                                                data-large_image_width="700" data-large_image_height="800"
                                                                decoding="async" fetchpriority="high"
                                                                srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap.jpeg.webp') }} 700w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-263x300.jpeg.webp') }} 263w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-290x330.jpeg.webp') }} 290w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-88x100.jpeg.webp') }} 88w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-600x686.jpeg.webp') }} 600w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-150x171.jpeg.webp') }} 150w"
                                                                sizes="(max-width: 700px) 100vw, 700px" /></a>
                                                    </figure>
                                                </div>
                                                <div class="wd-carousel-item">
                                                    <figure
                                                        data-thumb="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1-150x171.jpeg') }}"
                                                        data-thumb-alt="8 Bit Hearts Cap - Image 2"
                                                        class="woocommerce-product-gallery__image">
                                                        <a data-elementor-open-lightbox="no"
                                                            href="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1.jpeg') }}">
                                                            <img width="700" height="800"
                                                                src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1.jpeg.webp') }}"
                                                                class="" alt="8 Bit Hearts Cap - Image 2"
                                                                title="8-bit-hearts-cap-1.jpeg" data-caption=""
                                                                data-src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1.jpeg') }}"
                                                                data-large_image="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1.jpeg') }}"
                                                                data-large_image_width="700" data-large_image_height="800"
                                                                decoding="async" loading="lazy"
                                                                srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1.jpeg.webp') }} 700w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1-263x300.jpeg.webp') }} 263w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1-290x330.jpeg.webp') }} 290w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1-88x100.jpeg.webp') }} 88w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1-600x686.jpeg.webp') }} 600w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1-150x171.jpeg.webp') }} 150w"
                                                                sizes="auto, (max-width: 700px) 100vw, 700px" />
                                                        </a>
                                                    </figure>
                                                </div>
                                                <div class="wd-carousel-item">
                                                    <figure
                                                        data-thumb="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-2-150x171.jpeg') }}"
                                                        data-thumb-alt="8 Bit Hearts Cap - Image 3"
                                                        class="woocommerce-product-gallery__image">
                                                        <a data-elementor-open-lightbox="no"
                                                            href="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-2.jpeg') }}">
                                                            <img width="700" height="800"
                                                                src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-2.jpeg.webp') }}"
                                                                class="" alt="8 Bit Hearts Cap - Image 3"
                                                                title="8-bit-hearts-cap-2.jpeg" data-caption=""
                                                                data-src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-2.jpeg') }}"
                                                                data-large_image="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-2.jpeg') }}"
                                                                data-large_image_width="700" data-large_image_height="800"
                                                                decoding="async" loading="lazy"
                                                                srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-2.jpeg.webp') }} 700w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-2-263x300.jpeg.webp') }} 263w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-2-290x330.jpeg.webp') }} 290w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-2-88x100.jpeg.webp') }} 88w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-2-600x686.jpeg.webp') }} 600w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-2-150x171.jpeg.webp') }} 150w"
                                                                sizes="auto, (max-width: 700px) 100vw, 700px" />
                                                        </a>
                                                    </figure>
                                                </div>
                                                <div class="wd-carousel-item">
                                                    <figure
                                                        data-thumb="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-3-150x171.jpeg') }}"
                                                        data-thumb-alt="8 Bit Hearts Cap - Image 4"
                                                        class="woocommerce-product-gallery__image">
                                                        <a data-elementor-open-lightbox="no"
                                                            href="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-3.jpeg') }}">
                                                            <img width="700" height="800"
                                                                src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-3.jpeg.webp') }}"
                                                                class="" alt="8 Bit Hearts Cap - Image 4"
                                                                title="8-bit-hearts-cap-3.jpeg" data-caption=""
                                                                data-src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-3.jpeg') }}"
                                                                data-large_image="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-3.jpeg') }}"
                                                                data-large_image_width="700" data-large_image_height="800"
                                                                decoding="async" loading="lazy"
                                                                srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-3.jpeg.webp') }} 700w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-3-263x300.jpeg.webp') }} 263w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-3-290x330.jpeg.webp') }} 290w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-3-88x100.jpeg.webp') }} 88w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-3-600x686.jpeg.webp') }} 600w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-3-150x171.jpeg') }} 150w"
                                                                sizes="auto, (max-width: 700px) 100vw, 700px" />
                                                        </a>
                                                    </figure>
                                                </div>
                                            </div>
                                        </figure>

                                        <link rel="stylesheet" id="wd-swiper-arrows-critical-css"
                                            href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/lib-swiper-arrows-critical.css') }}"
                                            type="text/css" media="all" />
                                        <div class="wd-nav-arrows wd-pos-sep wd-hover-1 wd-custom-style wd-icon-1">
                                            <div class="wd-btn-arrow wd-prev wd-disabled">
                                                <div class="wd-arrow-inner"></div>
                                            </div>
                                            <div class="wd-btn-arrow wd-next">
                                                <div class="wd-arrow-inner"></div>
                                            </div>
                                        </div>

                                        <div class="product-additional-galleries">
                                            <div
                                                class="wd-show-product-gallery-wrap wd-action-btn wd-style-icon-bg-text wd-gallery-btn">
                                                <a href="#" rel="nofollow" class="woodmart-show-product-gallery">
                                                    <span class="wd-action-icon"></span>
                                                    <span class="wd-action-text">
                                                        Click to enlarge </span>
                                                </a>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="wd-carousel-container wd-gallery-thumb">
                                    <div class="wd-carousel-inner">
                                        <div class="wd-carousel wd-grid"
                                            style="--wd-col-lg:4;--wd-col-md:4;--wd-col-sm:3;">
                                            <div class="wd-carousel-wrap">
                                                <div class="wd-carousel-item ">
                                                    <img width="150" height="171"
                                                        src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-150x171.jpeg.webp') }}"
                                                        class="attachment-150x0 size-150x0" alt="8 Bit Hearts Cap"
                                                        decoding="async" loading="lazy"
                                                        srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-150x171.jpeg.webp') }} 150w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-263x300.jpeg.webp') }} 263w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-290x330.jpeg.webp') }} 290w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-88x100.jpeg.webp') }} 88w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-600x686.jpeg.webp') }} 600w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap.jpeg.webp') }} 700w"
                                                        sizes="auto, (max-width: 150px) 100vw, 150px" />
                                                </div>
                                                <div class="wd-carousel-item ">
                                                    <img width="150" height="171"
                                                        src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1-150x171.jpeg.webp') }}"
                                                        class="attachment-150x0 size-150x0"
                                                        alt="8 Bit Hearts Cap - Image 2" decoding="async" loading="lazy"
                                                        srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1-150x171.jpeg.webp') }} 150w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1-263x300.jpeg.webp') }} 263w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1-290x330.jpeg.webp') }} 290w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1-88x100.jpeg.webp') }} 88w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1-600x686.jpeg.webp') }} 600w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1.jpeg.webp') }} 700w"
                                                        sizes="auto, (max-width: 150px) 100vw, 150px" />
                                                </div>
                                                <div class="wd-carousel-item ">
                                                    <img width="150" height="171"
                                                        src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-2-150x171.jpeg.webp') }}"
                                                        class="attachment-150x0 size-150x0"
                                                        alt="8 Bit Hearts Cap - Image 3" decoding="async" loading="lazy"
                                                        srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-2-150x171.jpeg.webp') }} 150w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-2-263x300.jpeg.webp') }} 263w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-2-290x330.jpeg.webp') }} 290w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-2-88x100.jpeg.webp') }} 88w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-2-600x686.jpeg.webp') }} 600w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-2.jpeg.webp') }} 700w"
                                                        sizes="auto, (max-width: 150px) 100vw, 150px" />
                                                </div>
                                                <div class="wd-carousel-item ">
                                                    <img width="150" height="171"
                                                        src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-3-150x171.jpeg') }}"
                                                        class="attachment-150x0 size-150x0"
                                                        alt="8 Bit Hearts Cap - Image 4" decoding="async" loading="lazy"
                                                        srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-3-150x171.jpeg') }} 150w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-3-263x300.jpeg.webp') }} 263w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-3-290x330.jpeg.webp') }} 290w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-3-88x100.jpeg.webp') }} 88w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-3-600x686.jpeg.webp') }} 600w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-3.jpeg.webp') }} 700w"
                                                        sizes="auto, (max-width: 150px) 100vw, 150px" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="wd-nav-arrows wd-thumb-nav wd-custom-style wd-pos-sep wd-icon-1">
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
                    </div>

                    <div class="wp-block-wd-column wd-sticky-on-lg wd_sticky_offset_120 wd-15ca6b8c wd-align-s-start">
                        <link rel="stylesheet" id="wd-woo-el-notices-builder-css"
                            href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-el-notices-builder.css') }}"
                            type="text/css" media="all" />
                        <div class="wd-wc-notices wd-4bec9978">
                            <div class="woocommerce-notices-wrapper"></div>
                        </div>


                        <div
                            class="wp-block-wd-container wd-dir-row wd-dir-row-md wd-dir-row-sm wd-align-is-lg-center wd-ef4cd637">
                            <div class="wd-single-title wd-91cbb9f4">

                                <h1 class="product_title entry-title wd-entities-title">

                                    8 Bit Hearts Cap
                                </h1>
                            </div>


                            <div class="wd-single-attrs wd-f798e673 wd-layout-grid wd-style-bordered">

                                <link rel="stylesheet" id="wd-woo-mod-shop-attributes-builder-css"
                                    href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-mod-shop-attributes-builder.css') }}"
                                    type="text/css" media="all" />
                                <table class="woocommerce-product-attributes shop_attributes"
                                    aria-label="Product Details">
                                    <tr
                                        class="woocommerce-product-attributes-item woocommerce-product-attributes-item--attribute_pa_franchise">
                                        <td class="woocommerce-product-attributes-item__value"><a class="wd-term"
                                                href="products.html" rel="tag"><img decoding="async"
                                                    src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-franchise-logo-retro-consoles.jpg') }}"
                                                    class="wd-term-img" alt="Retro Consoles"></a></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="wd-single-rating wd-d7d53994">
                            <div class="woocommerce-product-rating">
                                <div class="star-rating" role="img" aria-label="Rated 4.00 out of 5"><span
                                        style="width:80%">Rated <strong class="rating">4.00</strong> out of 5
                                        based on <span class="rating">1</span> customer rating</span></div>
                                <a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<span
                                        class="count">1</span> customer review)</a>
                            </div>
                        </div>


                        <div class="wp-block-wd-container wd-dir-row wd-align-is-lg-center wd-58f3a64c">
                            <div class="wd-single-stock-status wd-8fed514f">
                                <p class="stock in-stock wd-style-default">399 in stock</p>
                            </div>


                            <div class="wd-single-meta wd-39bfbee2">

                                <div class="product_meta wd-layout-default">


                                    <span class="sku_wrapper">
                                        <span class="meta-label">
                                            SKU: </span>
                                        <span class="sku">
                                            GM-H-11 </span>
                                    </span>




                                </div>
                            </div>
                        </div>

                        <div class="wd-single-short-desc wd-b3d227b8">
                            <div class="woocommerce-product-details__short-description">
                                <p>Show your love for retro gaming with this adorable cap featuring 8-bit heart
                                    icons! Perfect for gamers who grew up on pixelated adventures, this
                                    adjustable cap combines nostalgia and style for everyday wear.</p>
                            </div>
                        </div>


                        <div class="wd-single-price wd-8e733563">
                            <p class="price"><span class="woocommerce-Price-amount amount"><bdi><span
                                            class="woocommerce-Price-currencySymbol">&#36;</span>22,60</bdi></span>
                            </p>
                        </div>


                        <div
                            class="wd-single-add-cart wd-ec82c100 wd-btn-design-full wd-design-default wd-swatch-layout-default wd-stock-status-off">
                            <p class="stock in-stock wd-style-default">399 in stock</p>


                            <form class="cart" action="product_details.html" method="post"
                                enctype='multipart/form-data'>


                                <div class="quantity">

                                    <input type="button" value="-" class="minus btn"
                                        aria-label="Decrease quantity" />

                                    <label class="screen-reader-text" for="quantity_6a3565def4008">8 Bit Hearts
                                        Cap quantity</label>
                                    <input type="number" id="quantity_6a3565def4008" class="input-text qty text"
                                        value="1" aria-label="Product quantity" min="1" max="399"
                                        name="quantity" step="1" placeholder="" inputmode="numeric"
                                        autocomplete="off">

                                    <input type="button" value="+" class="plus btn"
                                        aria-label="Increase quantity" />

                                </div>

                                <button type="submit" name="add-to-cart" value="201"
                                    class="single_add_to_cart_button button alt">Add to cart</button>

                                <button id="wd-add-to-cart" type="submit" name="wd-add-to-cart" value="201"
                                    class="wd-buy-now-btn btn button alt btn-accent">
                                    Buy now </button>
                            </form>



                        </div>


                        <div
                            class="wp-block-wd-container wd-dir-row wd-dir-row-sm wd-align-is-lg-center wd-align-is-sm-start wd-d6cacb3f">
                            <div class="wd-single-action-btn wd-single-wishlist-btn wd-d8042f3f">
                                <div class="wd-wishlist-btn wd-action-btn wd-wishlist-icon wd-style-text">
                                    <a class="" href="wishtlist.html" data-key="d5b554e37e" data-product-id="201"
                                        rel="nofollow">
                                        <span class="wd-action-icon">
                                            <span class="wd-check-icon"></span>
                                        </span>
                                        <span class="wd-action-text">Add to wishlist</span>
                                    </a>
                                </div>
                            </div>


                            <div class="wd-single-action-btn wd-single-size-guide-btn wd-7fb02323">
                                <link rel="stylesheet" id="wd-mod-animations-transform-css"
                                    href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/mod-animations-transform.css') }}"
                                    type="text/css" media="all" />
                                <div id="wd_sizeguide" data-wrap-class="wd-sizeguide-wrap"
                                    class="mfp-hide wd-popup wd-popup-element wd-deferred wd-sizeguide wd-scroll-content">
                                    <h4 class="wd-sizeguide-title">
                                        Size guide </h4>
                                    <div class="wd-sizeguide-content">
                                    </div>
                                    <div class="responsive-table">
                                        <table class="wd-sizeguide-table">
                                            <tr>
                                                <td>
                                                    Size </td>
                                                <td>
                                                    UK </td>
                                                <td>
                                                    US </td>
                                                <td>
                                                    EU </td>
                                                <td>
                                                    Japan </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    XS </td>
                                                <td>
                                                    6 - 8 </td>
                                                <td>
                                                    4 </td>
                                                <td>
                                                    34 </td>
                                                <td>
                                                    7 </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    S </td>
                                                <td>
                                                    8 -10 </td>
                                                <td>
                                                    6 </td>
                                                <td>
                                                    36 </td>
                                                <td>
                                                    9 </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    M </td>
                                                <td>
                                                    10 - 12 </td>
                                                <td>
                                                    8 </td>
                                                <td>
                                                    38 </td>
                                                <td>
                                                    11 </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    L </td>
                                                <td>
                                                    12 - 14 </td>
                                                <td>
                                                    10 </td>
                                                <td>
                                                    40 </td>
                                                <td>
                                                    13 </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    XL </td>
                                                <td>
                                                    14 - 16 </td>
                                                <td>
                                                    12 </td>
                                                <td>
                                                    42 </td>
                                                <td>
                                                    15 </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    XXL </td>
                                                <td>
                                                    16 - 28 </td>
                                                <td>
                                                    14 </td>
                                                <td>
                                                    44 </td>
                                                <td>
                                                    17 </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="wd-sizeguide-btn wd-action-btn wd-sizeguide-icon wd-style-text">
                                    <a class="wd-open-popup" rel="nofollow" href="#wd_sizeguide">
                                        <span class="wd-action-icon"></span>
                                        <span class="wd-action-text">
                                            Size guide </span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="wd-single-attrs wd-ca100415 wd-layout-list wd-style-bordered">

                            <table class="woocommerce-product-attributes shop_attributes" aria-label="Product Details">
                                <tr
                                    class="woocommerce-product-attributes-item woocommerce-product-attributes-item--attribute_pa_color">
                                    <th class="woocommerce-product-attributes-item__label" scope="row"><span
                                            class="wd-attr-label"><span class="wd-attr-name">Color</span></span>
                                    </th>
                                    <td class="woocommerce-product-attributes-item__value"><span class="wd-term"><span
                                                class="wd-term-name">Gray</span></span></td>
                                </tr>
                                <tr
                                    class="woocommerce-product-attributes-item woocommerce-product-attributes-item--attribute_pa_product-type">
                                    <th class="woocommerce-product-attributes-item__label" scope="row"><span
                                            class="wd-attr-label"><span class="wd-attr-name">Type</span></span>
                                    </th>
                                    <td class="woocommerce-product-attributes-item__value"><a class="wd-term"
                                            href="products.html" rel="tag"><span
                                                class="wd-term-name">Gaming</span></a></td>
                                </tr>
                            </table>
                        </div>


                        <div class="wd-single-meta wd-45069eb1">

                            <div class="product_meta wd-layout-justify">




                                <span class="posted_in"><span class="meta-label">Brand: </span><a href="products.html"
                                        rel="tag">8-Bit Legends</a></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wp-block-wd-section wd-e3807c2b">
                    <div class="wp-block-wd-container wd-dir-col wd-621f1f11">
                        <h2 class="wp-block-wd-title title wd-0a56a3eb">Customer Reviews</h2>

                        <link rel="stylesheet" id="wd-woo-single-prod-el-reviews-css"
                            href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-single-prod-el-reviews.css') }}"
                            type="text/css" media="all" />
                        <link rel="stylesheet" id="wd-woo-single-prod-el-reviews-style-1-css"
                            href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-single-prod-el-reviews-style-1.css') }}"
                            type="text/css" media="all" />
                        <link rel="stylesheet" id="wd-post-types-mod-comments-css"
                            href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/post-types-mod-comments.css') }}"
                            type="text/css" media="all" />
                        <div class="wd-single-reviews wd-9c0e153f wd-layout-two-column wd-form-pos-after">
                            <div id="reviews" class="woocommerce-Reviews" data-product-id="201">

                                <div id="comments">
                                    <div class="wd-reviews-heading">
                                        <div class="wd-reviews-tools">
                                            <h2 class="woocommerce-Reviews-title">
                                                1 review for <span>8 Bit Hearts Cap</span> </h2>

                                        </div>

                                    </div>

                                    <div class="wd-reviews-content">
                                        <ol class="commentlist wd-grid-g wd-active wd-in wd-review-style-1"
                                            style="--wd-col-lg: 1;--wd-col-md: 1;--wd-col-sm: 1;"
                                            data-reviews-columns="{&quot;reviews_columns&quot;:1,&quot;reviews_columns_tablet&quot;:1,&quot;reviews_columns_mobile&quot;:1}">
                                            <li class="review even thread-even depth-1 wd-col" id="li-comment-8">

                                                <div id="comment-8" class="comment_container">

                                                    <img alt=''
                                                        src='https://secure.gravatar.com/avatar/c3d98c4ddad266735ddd6f3202c36988e348194fac17d2d6f8bdffbe46db6f49?s=60&#038;d=mm&#038;r=g'
                                                        srcset='https://secure.gravatar.com/avatar/c3d98c4ddad266735ddd6f3202c36988e348194fac17d2d6f8bdffbe46db6f49?s=120&#038;d=mm&#038;r=g 2x'
                                                        class='avatar avatar-60 photo' height='60' width='60'
                                                        loading='lazy' decoding='async' />
                                                    <div class="comment-text">


                                                        <p class="meta">
                                                            <strong class="woocommerce-review__author">Ema
                                                                Norton </strong>
                                                            <span class="woocommerce-review__dash">&ndash;</span>
                                                            <time class="woocommerce-review__published-date"
                                                                datetime="2025-11-11T12:06:01+00:00">November
                                                                11, 2025</time>
                                                        </p>

                                                        <div class="star-rating" role="img"
                                                            aria-label="Rated 4 out of 5"><span style="width:80%">Rated
                                                                <strong class="rating">4</strong> out of 5</span>
                                                        </div>
                                                        <div class="description">
                                                            <p>I recently purchased an Astro Bot T-shirt and am
                                                                very happy with it! As a big fan of the Astro
                                                                Bot series and a proud owner of a PS5, this
                                                                T-shirt was a must-have addition to my wardrobe
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <ul class="children">
                                                    <li class="comment byuser comment-author-zakhar odd alt depth-2 wd-col"
                                                        id="li-comment-29">

                                                        <div id="comment-29" class="comment_container">

                                                            <img alt=''
                                                                src='https://secure.gravatar.com/avatar/2772a622478b29286f1cacd8ff038c7fefa5d12038bca3c619a9f4fd571267a2?s=60&#038;d=mm&#038;r=g'
                                                                srcset='https://secure.gravatar.com/avatar/2772a622478b29286f1cacd8ff038c7fefa5d12038bca3c619a9f4fd571267a2?s=120&#038;d=mm&#038;r=g 2x'
                                                                class='avatar avatar-60 photo' height='60'
                                                                width='60' loading='lazy' decoding='async' />
                                                            <div class="comment-text">


                                                                <p class="meta">
                                                                    <strong class="woocommerce-review__author">Mr.
                                                                        Mackay </strong>
                                                                    <span class="woocommerce-review__dash">&ndash;</span>
                                                                    <time class="woocommerce-review__published-date"
                                                                        datetime="2025-11-11T12:16:00+00:00">November
                                                                        11, 2025</time>
                                                                </p>

                                                                <div class="description">
                                                                    <p>That’s awesome! You made a great
                                                                        choice—it really is a must-have for any
                                                                        PS5 owner. Thanks for the feedback!</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li><!-- #comment-## -->
                                                </ul><!-- .children -->
                                            </li><!-- #comment-## -->
                                        </ol>

                                    </div>

                                    <div class="wd-loader-overlay wd-fill"></div>
                                </div>

                                <div id="review_form_wrapper">
                                    <div id="review_form">
                                        <div id="respond" class="comment-respond">
                                            <span id="reply-title" class="comment-reply-title title" role="heading"
                                                aria-level="3">Add a review <small><a rel="nofollow"
                                                        id="cancel-comment-reply-link"
                                                        href="/merchandise/product/8-bit-hearts-cap/#respond"
                                                        style="display:none;">Cancel reply</a></small></span>
                                            <form action="#" method="post" id="commentform" class="comment-form">
                                                <div class="comment-form-rating"><label for="rating"
                                                        id="comment-form-rating-label">Your rating&nbsp;<span
                                                            class="required">*</span></label><select name="rating"
                                                        id="rating" required>
                                                        <option value="">Rate&hellip;</option>
                                                        <option value="5">Perfect</option>
                                                        <option value="4">Good</option>
                                                        <option value="3">Average</option>
                                                        <option value="2">Not that bad</option>
                                                        <option value="1">Very poor</option>
                                                    </select></div>
                                                <p class="comment-form-comment"><label for="comment">Your
                                                        review&nbsp;<span class="required">*</span></label>
                                                    <textarea id="comment" name="comment" cols="45" rows="8" required></textarea>
                                                </p>
                                                <p class="form-submit"><input name="submit" type="submit"
                                                        id="submit" class="submit" value="Submit" /> <input
                                                        type='hidden' name='comment_post_ID' value='201'
                                                        id='comment_post_ID' />
                                                    <input type='hidden' name='comment_parent' id='comment_parent'
                                                        value='0' />
                                                </p>
                                            </form>
                                        </div><!-- #respond -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wp-block-wd-section wd-2dcc2a15">
                    <div class="wp-block-wd-container wd-dir-col wd-05dad393">
                        <link rel="stylesheet" id="wd-product-loop-css"
                            href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-product-loop.css') }}" type="text/css"
                            media="all" />
                        <link rel="stylesheet" id="wd-woo-loop-prod-el-base-css"
                            href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-loop-prod-el-base.css') }}"
                            type="text/css" media="all" />
                        <link rel="stylesheet" id="wd-woo-loop-prod-predefined-css"
                            href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-loop-prod-predefined.css') }}"
                            type="text/css" media="all" />
                        <link rel="stylesheet" id="wd-product-loop-quick-css"
                            href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-product-loop-quick.css') }}"
                            type="text/css" media="all" />
                        <link rel="stylesheet" id="wd-woo-mod-loop-prod-add-btn-replace-css"
                            href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-mod-loop-prod-add-btn-replace.css') }}"
                            type="text/css" media="all" />
                        <link rel="stylesheet" id="wd-woo-opt-stretch-cont-css"
                            href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-opt-stretch-cont.css') }}"
                            type="text/css" media="all" />
                        <link rel="stylesheet" id="wd-woo-opt-stretch-cont-predefined-css"
                            href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-opt-stretch-cont-predefined.css') }}"
                            type="text/css" media="all" />
                        <link rel="stylesheet" id="wd-bordered-product-css"
                            href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-opt-bordered-product.css') }}"
                            type="text/css" media="all" />
                        <link rel="stylesheet" id="wd-bordered-product-predefined-css"
                            href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-opt-bordered-product-predefined.css') }}"
                            type="text/css" media="all" />
                        <link rel="stylesheet" id="wd-woo-opt-title-limit-predefined-css"
                            href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-opt-title-limit-predefined.css') }}"
                            type="text/css" media="all" />
                        <div id="carousel-165"
                            class="wd-carousel-container  wd-fd8e9148 wd-products-element wd-products products wd-loop-builder-off wd-stretch-cont-lg wd-stretch-cont-md wd-stretch-cont-sm products-bordered-grid-ins title-line-one">


                            <h2 class="wp-block-wd-title title wd-ba40f768">You may also like…</h2>



                            <div class="wd-carousel-inner">
                                <div class=" wd-carousel wd-grid" data-scroll_per_page="yes"
                                    style="--wd-col-lg:4;--wd-col-md:4;--wd-col-sm:2;--wd-gap-lg:20px;--wd-gap-sm:10px;">
                                    <div class="wd-carousel-wrap">
                                        <div class="wd-carousel-item">
                                            <div class="wd-product wd-hover-quick product-grid-item product type-product post-201 status-publish instock product_cat-hats has-post-thumbnail shipping-taxable purchasable product-type-simple"
                                                data-loop="1" data-id="201">

                                                <div class="wd-product-wrapper product-wrapper">
                                                    <div class="wd-product-thumb product-element-top wd-quick-shop">
                                                        <a href="product_details.html"
                                                            class="wd-product-img-link product-image-link" tabindex="-1"
                                                            aria-label="8 Bit Hearts Cap">
                                                            <img width="430" height="492"
                                                                src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-600x686.jpeg.webp') }}"
                                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                alt="" decoding="async" loading="lazy"
                                                                srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-600x686.jpeg.webp') }} 600w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-263x300.jpeg.webp') }} 263w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-88x100.jpeg.webp') }} 88w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-150x171.jpeg.webp') }} 150w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap.jpeg.webp') }} 700w"
                                                                sizes="auto, (max-width: 430px) 100vw, 430px" />
                                                        </a>

                                                        <div class="wd-product-img-hover hover-img">
                                                            <img width="430" height="492"
                                                                src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1-600x686.jpeg.webp') }}"
                                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                alt="" decoding="async" loading="lazy"
                                                                srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1-600x686.jpeg.webp') }} 600w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1-263x300.jpeg.webp') }} 263w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1-88x100.jpeg.webp') }} 88w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1-150x171.jpeg.webp') }} 150w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/8-bit-hearts-cap-1.jpeg.webp') }} 700w"
                                                                sizes="auto, (max-width: 430px) 100vw, 430px" />
                                                        </div>
                                                        <div class="wd-buttons wd-pos-r-t">
                                                            <div
                                                                class="wd-quick-view-btn wd-quick-view-icon wd-action-btn wd-style-icon">
                                                                <a href="product_details.html" class="open-quick-view"
                                                                    rel="nofollow" data-id="201">
                                                                    <span class="wd-action-icon"></span>
                                                                    <span class="wd-action-text">
                                                                        Quick view </span>
                                                                </a>
                                                            </div>
                                                            <div
                                                                class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
                                                                <a class="" href="wishtlist.html"
                                                                    data-key="d5b554e37e" data-product-id="201"
                                                                    rel="nofollow">
                                                                    <span class="wd-action-icon">
                                                                        <span class="wd-check-icon"></span>
                                                                    </span>
                                                                    <span class="wd-action-text">Add to
                                                                        wishlist</span>
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="wd-add-btn wd-add-btn-replace">

                                                            <a href="/merchandise/product/8-bit-hearts-cap/?add-to-cart=201"
                                                                data-quantity="1"
                                                                class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop"
                                                                data-product_id="201" data-product_sku="GM-H-11"
                                                                aria-label="Add to cart: &ldquo;8 Bit Hearts Cap&rdquo;"
                                                                rel="nofollow"
                                                                data-success_message="&ldquo;8 Bit Hearts Cap&rdquo; has been added to your cart"
                                                                role="button"><span class="wd-action-icon"><span
                                                                        class="wd-check-icon"></span></span><span
                                                                    class="wd-action-text">Add to
                                                                    cart</span></a>
                                                        </div>
                                                    </div>
                                                    <div class="product-element-bottom">
                                                        <h3 class="wd-entities-title"><a href="product_details.html">8 Bit
                                                                Hearts Cap</a>
                                                        </h3>

                                                        <div class="star-rating" role="img"
                                                            aria-label="Rated 4.00 out of 5">
                                                            <span style="width:80%">
                                                                Rated <strong class="rating">4.00</strong> out
                                                                of 5 </span>
                                                        </div>



                                                        <span class="price"><span
                                                                class="woocommerce-Price-amount amount"><bdi><span
                                                                        class="woocommerce-Price-currencySymbol">&#36;</span>22,60</bdi></span></span>



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wd-carousel-item">
                                            <div class="wd-product wd-hover-quick product-grid-item product type-product post-382 status-publish instock product_cat-figures has-post-thumbnail sale shipping-taxable purchasable product-type-simple"
                                                data-loop="2" data-id="382">

                                                <div class="wd-product-wrapper product-wrapper">
                                                    <div class="wd-product-thumb product-element-top wd-quick-shop">
                                                        <a href="product_details.html"
                                                            class="wd-product-img-link product-image-link" tabindex="-1"
                                                            aria-label="Alex Minecraft Figure">
                                                            <img width="430" height="492"
                                                                src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/alex-minecraft-figure-600x686.jpeg.webp') }}"
                                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                alt="" decoding="async" loading="lazy"
                                                                srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/alex-minecraft-figure-600x686.jpeg.webp') }} 600w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/alex-minecraft-figure-263x300.jpeg.webp') }} 263w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/alex-minecraft-figure-88x100.jpeg.webp') }} 88w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/alex-minecraft-figure-150x171.jpeg.webp') }} 150w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/alex-minecraft-figure.jpeg.webp') }} 700w"
                                                                sizes="auto, (max-width: 430px) 100vw, 430px" />
                                                        </a>

                                                        <link rel="stylesheet" id="wd-woo-mod-product-labels-default-css"
                                                            href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-mod-product-labels-default.css') }}"
                                                            type="text/css" media="all" />
                                                        <link rel="stylesheet" id="wd-woo-mod-product-labels-css"
                                                            href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-mod-product-labels.css') }}"
                                                            type="text/css" media="all" />
                                                        <div class="product-labels labels-rounded-sm">
                                                            <span
                                                                class="onsale product-label wd-shape-round-sm">-23%</span>
                                                        </div>
                                                        <div class="wd-product-img-hover hover-img">
                                                            <img width="430" height="492"
                                                                src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/alex-minecraft-figure-1-600x686.jpeg.webp') }}"
                                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                alt="" decoding="async" loading="lazy"
                                                                srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/alex-minecraft-figure-1-600x686.jpeg.webp') }} 600w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/alex-minecraft-figure-1-263x300.jpeg.webp') }} 263w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/alex-minecraft-figure-1-88x100.jpeg.webp') }} 88w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/alex-minecraft-figure-1-150x171.jpeg.webp') }} 150w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/alex-minecraft-figure-1.jpeg.webp') }} 700w"
                                                                sizes="auto, (max-width: 430px) 100vw, 430px" />
                                                        </div>
                                                        <div class="wd-buttons wd-pos-r-t">
                                                            <div
                                                                class="wd-quick-view-btn wd-quick-view-icon wd-action-btn wd-style-icon">
                                                                <a href="product_details.html" class="open-quick-view"
                                                                    rel="nofollow" data-id="382">
                                                                    <span class="wd-action-icon"></span>
                                                                    <span class="wd-action-text">
                                                                        Quick view </span>
                                                                </a>
                                                            </div>
                                                            <div
                                                                class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
                                                                <a class="" href="wishtlist.html"
                                                                    data-key="d5b554e37e" data-product-id="382"
                                                                    rel="nofollow">
                                                                    <span class="wd-action-icon">
                                                                        <span class="wd-check-icon"></span>
                                                                    </span>
                                                                    <span class="wd-action-text">Add to
                                                                        wishlist</span>
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="wd-add-btn wd-add-btn-replace">

                                                            <a href="/merchandise/product/8-bit-hearts-cap/?add-to-cart=382"
                                                                data-quantity="1"
                                                                class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop"
                                                                data-product_id="382" data-product_sku="GM-FG-4"
                                                                aria-label="Add to cart: &ldquo;Alex Minecraft Figure&rdquo;"
                                                                rel="nofollow"
                                                                data-success_message="&ldquo;Alex Minecraft Figure&rdquo; has been added to your cart"
                                                                role="button"><span class="wd-action-icon"><span
                                                                        class="wd-check-icon"></span></span><span
                                                                    class="wd-action-text">Add to
                                                                    cart</span></a>
                                                        </div>
                                                    </div>
                                                    <div class="product-element-bottom">
                                                        <h3 class="wd-entities-title"><a href="product_details.html">Alex
                                                                Minecraft
                                                                Figure</a></h3>

                                                        <div class="star-rating" role="img"
                                                            aria-label="Rated 5.00 out of 5">
                                                            <span style="width:100%">
                                                                Rated <strong class="rating">5.00</strong> out
                                                                of 5 </span>
                                                        </div>



                                                        <span class="price"><del aria-hidden="true"><span
                                                                    class="woocommerce-Price-amount amount"><bdi><span
                                                                            class="woocommerce-Price-currencySymbol">&#36;</span>49,99</bdi></span></del>
                                                            <span class="screen-reader-text">Original price was:
                                                                &#036;49,99.</span><ins aria-hidden="true"><span
                                                                    class="woocommerce-Price-amount amount"><bdi><span
                                                                            class="woocommerce-Price-currencySymbol">&#36;</span>38,25</bdi></span></ins><span
                                                                class="screen-reader-text">Current price is:
                                                                &#036;38,25.</span></span>



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wd-carousel-item">
                                            <div class="wd-product wd-hover-quick product-grid-item product type-product post-423 status-publish last instock product_cat-plushes has-post-thumbnail shipping-taxable purchasable product-type-simple"
                                                data-loop="3" data-id="423">

                                                <div class="wd-product-wrapper product-wrapper">
                                                    <div class="wd-product-thumb product-element-top wd-quick-shop">
                                                        <a href="product_details.html"
                                                            class="wd-product-img-link product-image-link" tabindex="-1"
                                                            aria-label="Astro Bot Plush">
                                                            <img width="430" height="492"
                                                                src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-600x686.jpeg.webp') }}"
                                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                alt="" decoding="async" loading="lazy"
                                                                srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-600x686.jpeg.webp') }} 600w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-263x300.jpeg.webp') }} 263w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-88x100.jpeg.webp') }} 88w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-150x171.jpeg.webp') }} 150w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush.jpeg.webp') }} 700w"
                                                                sizes="auto, (max-width: 430px) 100vw, 430px" />
                                                        </a>

                                                        <div class="wd-product-img-hover hover-img">
                                                            <img width="430" height="492"
                                                                src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-1-600x686.jpeg.webp') }}"
                                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                alt="" decoding="async" loading="lazy"
                                                                srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-1-600x686.jpeg.webp') }} 600w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-1-263x300.jpeg.webp') }} 263w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-1-88x100.jpeg.webp') }} 88w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-1-150x171.jpeg') }} 150w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-plush-1.jpeg.webp') }} 700w"
                                                                sizes="auto, (max-width: 430px) 100vw, 430px" />
                                                        </div>
                                                        <div class="wd-buttons wd-pos-r-t">
                                                            <div
                                                                class="wd-quick-view-btn wd-quick-view-icon wd-action-btn wd-style-icon">
                                                                <a href="product_details.html" class="open-quick-view"
                                                                    rel="nofollow" data-id="423">
                                                                    <span class="wd-action-icon"></span>
                                                                    <span class="wd-action-text">
                                                                        Quick view </span>
                                                                </a>
                                                            </div>
                                                            <div
                                                                class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
                                                                <a class="" href="wishtlist.html"
                                                                    data-key="d5b554e37e" data-product-id="423"
                                                                    rel="nofollow">
                                                                    <span class="wd-action-icon">
                                                                        <span class="wd-check-icon"></span>
                                                                    </span>
                                                                    <span class="wd-action-text">Add to
                                                                        wishlist</span>
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="wd-add-btn wd-add-btn-replace">

                                                            <a href="/merchandise/product/8-bit-hearts-cap/?add-to-cart=423"
                                                                data-quantity="1"
                                                                class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop"
                                                                data-product_id="423" data-product_sku="GM-PL-1"
                                                                aria-label="Add to cart: &ldquo;Astro Bot Plush&rdquo;"
                                                                rel="nofollow"
                                                                data-success_message="&ldquo;Astro Bot Plush&rdquo; has been added to your cart"
                                                                role="button"><span class="wd-action-icon"><span
                                                                        class="wd-check-icon"></span></span><span
                                                                    class="wd-action-text">Add to
                                                                    cart</span></a>
                                                        </div>
                                                    </div>
                                                    <div class="product-element-bottom">
                                                        <h3 class="wd-entities-title"><a href="product_details.html">Astro
                                                                Bot Plush</a>
                                                        </h3>

                                                        <div class="star-rating" role="img"
                                                            aria-label="Rated 4.00 out of 5">
                                                            <span style="width:80%">
                                                                Rated <strong class="rating">4.00</strong> out
                                                                of 5 </span>
                                                        </div>

                                                        <span class="price"><span
                                                                class="woocommerce-Price-amount amount"><bdi><span
                                                                        class="woocommerce-Price-currencySymbol">&#36;</span>12,99</bdi></span></span>



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wd-carousel-item">
                                            <div class="wd-product wd-hover-quick product-grid-item product type-product post-83 status-publish first instock product_cat-t-shirts has-post-thumbnail featured shipping-taxable purchasable product-type-variable"
                                                data-loop="4" data-id="83">

                                                <div class="wd-product-wrapper product-wrapper">
                                                    <div class="wd-product-thumb product-element-top wd-quick-shop">
                                                        <a href="product_details.html"
                                                            class="wd-product-img-link product-image-link" tabindex="-1"
                                                            aria-label="Astro Bot T-Shirt">
                                                            <img width="430" height="492"
                                                                src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-tshirt-600x686.jpeg.webp') }}"
                                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                alt="" decoding="async" loading="lazy"
                                                                srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-tshirt-600x686.jpeg.webp') }} 600w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-tshirt-263x300.jpeg.webp') }} 263w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-tshirt-88x100.jpeg.webp') }} 88w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-tshirt-150x171.jpeg.webp') }} 150w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-tshirt.jpeg.webp') }} 700w"
                                                                sizes="auto, (max-width: 430px) 100vw, 430px" />
                                                        </a>

                                                        <div class="product-labels labels-rounded-sm">
                                                            <span
                                                                class="featured product-label wd-shape-round-sm">Hot</span>
                                                        </div>
                                                        <div class="wd-product-img-hover hover-img">
                                                            <img width="430" height="492"
                                                                src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-tshirt-1-600x686.jpeg.webp') }}"
                                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                alt="" decoding="async" loading="lazy"
                                                                srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-tshirt-1-600x686.jpeg.webp') }} 600w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-tshirt-1-263x300.jpeg.webp') }} 263w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-tshirt-1-88x100.jpeg.webp') }} 88w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-tshirt-1-150x171.jpeg.webp') }} 150w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/astro-bot-tshirt-1.jpeg.webp') }} 700w"
                                                                sizes="auto, (max-width: 430px) 100vw, 430px" />
                                                        </div>
                                                        <div class="wd-buttons wd-pos-r-t">
                                                            <div
                                                                class="wd-quick-view-btn wd-quick-view-icon wd-action-btn wd-style-icon">
                                                                <a href="product_details.html" class="open-quick-view"
                                                                    rel="nofollow" data-id="83">
                                                                    <span class="wd-action-icon"></span>
                                                                    <span class="wd-action-text">
                                                                        Quick view </span>
                                                                </a>
                                                            </div>
                                                            <div
                                                                class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
                                                                <a class="" href="wishtlist.html"
                                                                    data-key="d5b554e37e" data-product-id="83"
                                                                    rel="nofollow">
                                                                    <span class="wd-action-icon">
                                                                        <span class="wd-check-icon"></span>
                                                                    </span>
                                                                    <span class="wd-action-text">Add to
                                                                        wishlist</span>
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="wd-add-btn wd-add-btn-replace">

                                                            <a href="product_details.html"
                                                                aria-describedby="woocommerce_loop_add_to_cart_link_describedby_83"
                                                                data-quantity="1"
                                                                class="button product_type_variable add_to_cart_button add-to-cart-loop"
                                                                data-product_id="83" data-product_sku="GM-T-08M"
                                                                aria-label="Select options for &ldquo;Astro Bot T-Shirt&rdquo;"
                                                                rel="nofollow"><span class="wd-action-icon"><span
                                                                        class="wd-check-icon"></span></span><span
                                                                    class="wd-action-text">Select
                                                                    options</span></a> <span
                                                                id="woocommerce_loop_add_to_cart_link_describedby_83"
                                                                class="screen-reader-text">
                                                                This product has multiple variants. The options
                                                                may be chosen on the product page </span>
                                                        </div>
                                                    </div>
                                                    <div class="product-element-bottom">
                                                        <h3 class="wd-entities-title"><a href="product_details.html">Astro
                                                                Bot
                                                                T-Shirt</a></h3>

                                                        <div class="star-rating" role="img"
                                                            aria-label="Rated 5.00 out of 5">
                                                            <span style="width:100%">
                                                                Rated <strong class="rating">5.00</strong> out
                                                                of 5 </span>
                                                        </div>



                                                        <span class="price"><span
                                                                class="woocommerce-Price-amount amount"><bdi><span
                                                                        class="woocommerce-Price-currencySymbol">&#36;</span>28,65</bdi></span></span>



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wd-carousel-item">
                                            <div class="wd-product wd-hover-quick product-grid-item product type-product post-208 status-publish instock product_cat-pins has-post-thumbnail shipping-taxable purchasable product-type-simple"
                                                data-loop="5" data-id="208">

                                                <div class="wd-product-wrapper product-wrapper">
                                                    <div class="wd-product-thumb product-element-top wd-quick-shop">
                                                        <a href="product_details.html"
                                                            class="wd-product-img-link product-image-link" tabindex="-1"
                                                            aria-label="Back to the Future Enamel Pin Badge">
                                                            <img width="430" height="492"
                                                                src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/back-to-the-future-enamel-pin-badge-600x686.jpeg.webp') }}"
                                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                alt="" decoding="async" loading="lazy"
                                                                srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/back-to-the-future-enamel-pin-badge-600x686.jpeg.webp') }} 600w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/back-to-the-future-enamel-pin-badge-263x300.jpeg.webp') }} 263w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/back-to-the-future-enamel-pin-badge-88x100.jpeg.webp') }} 88w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/back-to-the-future-enamel-pin-badge-150x171.jpeg.webp') }} 150w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/back-to-the-future-enamel-pin-badge.jpeg.webp') }} 700w"
                                                                sizes="auto, (max-width: 430px) 100vw, 430px" />
                                                        </a>

                                                        <div class="wd-product-img-hover hover-img">
                                                            <img width="430" height="492"
                                                                src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/back-to-the-future-enamel-pin-badge-1-600x686.jpeg.webp') }}"
                                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                alt="" decoding="async" loading="lazy"
                                                                srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/back-to-the-future-enamel-pin-badge-1-600x686.jpeg.webp') }} 600w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/back-to-the-future-enamel-pin-badge-1-263x300.jpeg.webp') }} 263w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/back-to-the-future-enamel-pin-badge-1-88x100.jpeg.webp') }} 88w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/back-to-the-future-enamel-pin-badge-1-150x171.jpeg.webp') }} 150w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/back-to-the-future-enamel-pin-badge-1.jpeg.webp') }} 700w"
                                                                sizes="auto, (max-width: 430px) 100vw, 430px" />
                                                        </div>
                                                        <div class="wd-buttons wd-pos-r-t">
                                                            <div
                                                                class="wd-quick-view-btn wd-quick-view-icon wd-action-btn wd-style-icon">
                                                                <a href="product_details.html" class="open-quick-view"
                                                                    rel="nofollow" data-id="208">
                                                                    <span class="wd-action-icon"></span>
                                                                    <span class="wd-action-text">
                                                                        Quick view </span>
                                                                </a>
                                                            </div>
                                                            <div
                                                                class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
                                                                <a class="" href="wishtlist.html"
                                                                    data-key="d5b554e37e" data-product-id="208"
                                                                    rel="nofollow">
                                                                    <span class="wd-action-icon">
                                                                        <span class="wd-check-icon"></span>
                                                                    </span>
                                                                    <span class="wd-action-text">Add to
                                                                        wishlist</span>
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="wd-add-btn wd-add-btn-replace">

                                                            <a href="/merchandise/product/8-bit-hearts-cap/?add-to-cart=208"
                                                                data-quantity="1"
                                                                class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop"
                                                                data-product_id="208" data-product_sku="GM-P-6"
                                                                aria-label="Add to cart: &ldquo;Back to the Future Enamel Pin Badge&rdquo;"
                                                                rel="nofollow"
                                                                data-success_message="&ldquo;Back to the Future Enamel Pin Badge&rdquo; has been added to your cart"
                                                                role="button"><span class="wd-action-icon"><span
                                                                        class="wd-check-icon"></span></span><span
                                                                    class="wd-action-text">Add to
                                                                    cart</span></a>
                                                        </div>
                                                    </div>
                                                    <div class="product-element-bottom">
                                                        <h3 class="wd-entities-title"><a href="product_details.html">Back
                                                                to the Future
                                                                Enamel Pin Badge</a></h3>

                                                        <div class="star-rating" role="img"
                                                            aria-label="Rated 5.00 out of 5">
                                                            <span style="width:100%">
                                                                Rated <strong class="rating">5.00</strong> out
                                                                of 5 </span>
                                                        </div>



                                                        <span class="price"><span
                                                                class="woocommerce-Price-amount amount"><bdi><span
                                                                        class="woocommerce-Price-currencySymbol">&#36;</span>7,99</bdi></span></span>



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

                <div class="wp-block-wd-container wd-dir-col wd-align wd-90066ecc">
                    <div class="wp-block-wd-image wd-block-image wd-b6e11ff7"><img loading="lazy" decoding="async"
                            width="48" height="48" class="wp-image-1021"
                            src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-mail-1.svg') }}" alt="" /></div>

                    <h2 class="wp-block-wd-title title wd-6e5b80bc">Subscribe and get 10% off your first
                        purchase</h2>

                    <p class="wp-block-wd-paragraph wd-329fde28">Will be used in accordance with our&nbsp;<a
                            href="#"><span class="wd-highlight">Privacy Policy</span></a></p>

                    <script>
                        (function() {
                            window.mc4wp = window.mc4wp || {
                                listeners: [],
                                forms: {
                                    on: function(evt, cb) {
                                        window.mc4wp.listeners.push({
                                            event: evt,
                                            callback: cb
                                        });
                                    }
                                }
                            }
                        })();
                    </script>
                    <!-- Mailchimp for WordPress v4.12.5 - https://wordpress.org/plugins/mailchimp-for-wp/ -->
                    <form id="mc4wp-form-1" class="mc4wp-form mc4wp-form-763  wd-569ca4cc wd-custom-width"
                        method="post" data-id="763" data-name="Newsletter form">
                        <div class="mc4wp-form-fields">
                            <div class="wd-grid-f-stretch" style="--wd-gap: 10px">
                                <div class="wd-col"><input type="email" name="EMAIL"
                                        placeholder="Your email address" required /></div>
                                <div class="wd-col-auto"><input type="submit" value="Sign up" /></div>
                            </div>
                        </div><label style="display: none !important;">Leave this field empty if you're human:
                            <input type="text" name="_mc4wp_honeypot" value="" tabindex="-1"
                                autocomplete="off" /></label><input type="hidden" name="_mc4wp_timestamp"
                            value="1781884383" /><input type="hidden" name="_mc4wp_form_id" value="763" /><input
                            type="hidden" name="_mc4wp_form_element_id" value="mc4wp-form-1" />
                        <div class="mc4wp-response"></div>
                    </form><!-- / Mailchimp for WordPress Plugin -->
                </div>

                <div class="wp-block-wd-container wd-dir-col wd-align wd-cdd11e25">
                    <h2 class="wp-block-wd-title title wd-ac487a7f">Connect to our Instagram</h2>

                    <p class="wp-block-wd-paragraph wd-1bfa0982">Follow us on Instagram, keep up to date with
                        new products and share your impressions</p>

                    <a class="wp-block-wd-button btn btn-style-bordered btn-size-default btn-shape-round wd-172b7370"
                        href="https://www.instagram.com/xtemos.studio/"><span>@xtemos.studio</span></a>

                    <link rel="stylesheet" id="wd-instagram-css"
                        href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/el-instagram.css') }}" type="text/css"
                        media="all" />
                    <div class="wd-insta  wd-0c7ef44c data-source-images">

                        <div class=" wd-grid-g"
                            style="--wd-col-lg:6;--wd-col-md:3;--wd-col-sm:3;--wd-gap-lg:20px;--wd-gap-sm:10px;">


                            <div class="wd-insta-item wd-col">
                                <a href="https://www.instagram.com/xtemos.studio/" target="_self"
                                    aria-label="Instagram picture"></a>

                                <img width="256" height="256"
                                    src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-1.jpg.webp') }}"
                                    class="attachment-medium size-medium" alt="" decoding="async"
                                    loading="lazy"
                                    srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-1.jpg.webp') }} 256w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-1-150x150.jpg.webp') }} 150w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-1-100x100.jpg.webp') }} 100w"
                                    sizes="auto, (max-width: 256px) 100vw, 256px" />
                                <div class="wd-insta-meta wd-grid-g">
                                    <span class="wd-insta-likes instagram-likes"><span>2785</span></span>
                                    <span class="wd-insta-comm instagram-comments"><span>463</span></span>
                                </div>
                            </div>


                            <div class="wd-insta-item wd-col">
                                <a href="https://www.instagram.com/xtemos.studio/" target="_self"
                                    aria-label="Instagram picture"></a>

                                <img width="256" height="256"
                                    src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-2.jpg.webp') }}"
                                    class="attachment-medium size-medium" alt="" decoding="async"
                                    loading="lazy"
                                    srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-2.jpg.webp') }} 256w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-2-150x150.jpg.webp') }} 150w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-2-100x100.jpg.webp') }} 100w"
                                    sizes="auto, (max-width: 256px) 100vw, 256px" />
                                <div class="wd-insta-meta wd-grid-g">
                                    <span class="wd-insta-likes instagram-likes"><span>6236</span></span>
                                    <span class="wd-insta-comm instagram-comments"><span>669</span></span>
                                </div>
                            </div>


                            <div class="wd-insta-item wd-col">
                                <a href="https://www.instagram.com/xtemos.studio/" target="_self"
                                    aria-label="Instagram picture"></a>

                                <img width="256" height="256"
                                    src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-3.jpg.webp') }}"
                                    class="attachment-medium size-medium" alt="" decoding="async"
                                    loading="lazy"
                                    srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-3.jpg.webp') }} 256w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-3-150x150.jpg.webp') }} 150w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-3-100x100.jpg.webp') }} 100w"
                                    sizes="auto, (max-width: 256px) 100vw, 256px" />
                                <div class="wd-insta-meta wd-grid-g">
                                    <span class="wd-insta-likes instagram-likes"><span>5180</span></span>
                                    <span class="wd-insta-comm instagram-comments"><span>446</span></span>
                                </div>
                            </div>


                            <div class="wd-insta-item wd-col">
                                <a href="https://www.instagram.com/xtemos.studio/" target="_self"
                                    aria-label="Instagram picture"></a>

                                <img width="256" height="256"
                                    src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-4.jpg.webp') }}"
                                    class="attachment-medium size-medium" alt="" decoding="async"
                                    loading="lazy"
                                    srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-4.jpg.webp') }} 256w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-4-150x150.jpg.webp') }} 150w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-4-100x100.jpg.webp') }} 100w"
                                    sizes="auto, (max-width: 256px) 100vw, 256px" />
                                <div class="wd-insta-meta wd-grid-g">
                                    <span class="wd-insta-likes instagram-likes"><span>6944</span></span>
                                    <span class="wd-insta-comm instagram-comments"><span>899</span></span>
                                </div>
                            </div>


                            <div class="wd-insta-item wd-col">
                                <a href="https://www.instagram.com/xtemos.studio/" target="_self"
                                    aria-label="Instagram picture"></a>

                                <img width="256" height="256"
                                    src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-5.jpg.webp') }}"
                                    class="attachment-medium size-medium" alt="" decoding="async"
                                    loading="lazy"
                                    srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-5.jpg.webp') }} 256w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-5-150x150.jpg.webp') }} 150w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-5-100x100.jpg.webp') }} 100w"
                                    sizes="auto, (max-width: 256px) 100vw, 256px" />
                                <div class="wd-insta-meta wd-grid-g">
                                    <span class="wd-insta-likes instagram-likes"><span>5694</span></span>
                                    <span class="wd-insta-comm instagram-comments"><span>536</span></span>
                                </div>
                            </div>


                            <div class="wd-insta-item wd-col">
                                <a href="https://www.instagram.com/xtemos.studio/" target="_self"
                                    aria-label="Instagram picture"></a>

                                <img width="256" height="256"
                                    src="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-6.jpg.webp') }}"
                                    class="attachment-medium size-medium" alt="" decoding="async"
                                    loading="lazy"
                                    srcset="{{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-6.jpg.webp') }} 256w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-6-150x150.jpg.webp') }} 150w, {{ asset('frontend/merchandise/wp-content/uploads/sites/31/2025/11/gms-inst-6-100x100.jpg.webp') }} 100w"
                                    sizes="auto, (max-width: 256px) 100vw, 256px" />
                                <div class="wd-insta-meta wd-grid-g">
                                    <span class="wd-insta-likes instagram-likes"><span>6485</span></span>
                                    <span class="wd-insta-comm instagram-comments"><span>790</span></span>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
