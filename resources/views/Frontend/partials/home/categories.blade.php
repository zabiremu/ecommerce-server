<link rel="stylesheet" id="wd-woo-categories-loop-css"
    href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-categories-loop.css') }}" type="text/css"
    media="all" />
<link rel="stylesheet" id="wd-categories-loop-css"
    href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-categories-loop-old.css') }}"
    type="text/css" media="all" />
<style>
    .wd-cats .wd-cat-thumb {
        border-radius: 50% !important;
        overflow: hidden;
        aspect-ratio: 1 / 1;
        width: 110px;
        height: 110px;
    }
    .wd-cats .wd-cat-image {
        display: block;
        width: 100%;
        height: 100%;
        border-radius: 0 !important;
    }
    .wd-cats .wd-cat-image img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 0 !important;
    }
    .wd-cats .wd-cat-image,
    .wd-cats .wd-cat-image img,
    .wd-cats .category-grid-item:hover .wd-cat-image,
    .wd-cats .category-grid-item .wd-cat-inner,
    .wd-cats .category-grid-item .wd-cat-thumb {
        transition: none !important;
        transform: none !important;
        animation: none !important;
    }
    /* Categories without an uploaded photo yet get their icon in a
       colored circle instead of an unrelated stock placeholder image.
       Cycled palette so a row of repeated icons (e.g. several shirt
       categories) doesn't read as visually broken/duplicated. */
    .gms-cat-icon-fallback {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        font-size: 34px;
    }
    .gms-cat-icon-fallback-0 { background: linear-gradient(135deg, #F3E4B8, #C9A24B); color: #5C4A1E; }
    .gms-cat-icon-fallback-1 { background: linear-gradient(135deg, #F3D9D2, #E0A99C); color: #7A3B2E; }
    .gms-cat-icon-fallback-2 { background: linear-gradient(135deg, #DCE6DA, #A9C0A4); color: #3E5A38; }
    .gms-cat-icon-fallback-3 { background: linear-gradient(135deg, #DCE1EA, #A9B7CC); color: #34435C; }
    .gms-cat-icon-fallback-4 { background: linear-gradient(135deg, #E9DCEF, #C6A8D6); color: #5A3A6B; }
</style>
<div class="wp-block-wd-container wd-dir-row wd-align-is-lg-center wd-fedb8996">
    <div>
        <span class="gms-section-eyebrow">🛍️ Explore</span>
        <h2 class="wp-block-wd-title title gms-heading-tier-2">Shop by Category</h2>
    </div>
</div>
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
                                <a class="wd-cat-image category-image gms-cat-image-link"
                                    href="{{ route('category-products') }}?cat={{ $cat->slug }}"
                                    aria-label="{{ $cat->name }}">
                                    @if($cat->image)
                                    <img {{ $loop->index > 1 ? 'loading=lazy' : '' }} decoding="async" width="150" height="150"
                                        src="{{ Storage::url($cat->image) }}"
                                        class="attachment-150x150 size-150x150"
                                        alt="{{ $cat->name }}"
                                        style="object-fit: cover; width: 150px; height: 150px;" />
                                    @else
                                    <span class="gms-cat-icon-fallback gms-cat-icon-fallback-{{ $loop->index % 5 }}" aria-hidden="true">
                                        <i class="{{ $cat->icon ?: 'fas fa-tag' }}"></i>
                                    </span>
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
