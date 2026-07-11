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
