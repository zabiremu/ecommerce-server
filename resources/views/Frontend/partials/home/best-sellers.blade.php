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
