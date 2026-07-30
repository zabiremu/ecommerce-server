<link rel="stylesheet" id="wd-woo-categories-loop-css"
    href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-categories-loop.css') }}" type="text/css"
    media="all" />
<link rel="stylesheet" id="wd-categories-loop-css"
    href="{{ asset('frontend/merchandise/wp-content/themes/woodmart/css/parts/woo-categories-loop-old.css') }}"
    type="text/css" media="all" />
<style>
    /* .wd-cat-inner is the whole card box (border/shadow come from
       gms-custom.css); it has no padding by default since that shared
       rule is written for edge-to-edge product photos, not a smaller
       centered icon circle — without this the circle sits flush
       against the card's top edge. */
    .wd-cats .wd-cat-inner {
        padding-top: 24px;
        height: 100%;
    }
    /* Cards were different heights side-by-side because the theme's
       carousel row uses align-items:flex-start (lib-swiper.css) — each
       card just took its own content height, so a 2-line category name
       ("Semi Baggy Jeans") made that card taller than a 1-line one
       ("Jeans") right next to it. Stretch the row so every card fills
       the tallest one instead. */
    .wd-cats .wd-carousel-wrap {
        align-items: stretch;
    }
    .wd-cats .wd-carousel-item {
        height: auto;
    }
    .wd-cats .category-grid-item {
        height: 100%;
    }
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
    /* Hover: red ring on the thumbnail, card lift, image zoom, title
       color. Selectors are prefixed with .wd-cats and use transform/
       box-shadow/color only (no layout-affecting properties), so this
       can't cause a layout shift regardless of load-order relative to
       woo-categories-loop-old.css (which also targets .wd-cat-image
       on hover — these selectors are more specific so ours wins
       deterministically either way, rather than depending on which
       stylesheet happens to load last). */
    .wd-cats .wd-cat-thumb {
        transition: box-shadow .3s ease;
        box-shadow: 0 0 0 3px rgba(0, 0, 0, .05);
    }
    .wd-cats .category-grid-item:hover .wd-cat-thumb {
        box-shadow: 0 0 0 3px var(--gms-red, #E63946);
    }
    .wd-cats .category-grid-item .wd-cat-inner {
        transition: transform .3s ease;
    }
    .wd-cats .category-grid-item:hover .wd-cat-inner {
        transform: translateY(-4px);
    }
    .wd-cats .category-grid-item .wd-cat-image {
        transition: transform .3s ease;
    }
    .wd-cats .category-grid-item:hover .wd-cat-image {
        transform: scale(1.08);
    }
    .wd-cats .wd-entities-title {
        transition: color .2s ease;
    }
    .wd-cats .category-grid-item:hover .wd-entities-title {
        color: var(--gms-red, #E63946);
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

    /* Mobile: turn this into a real swipeable slider. The theme's own
       carousel needs Swiper JS to reposition .wd-carousel-wrap and
       reveal items past the first --wd-col — that init never reliably
       fires on this build, so on narrow screens the row's default
       overflow-x:clip (lib-swiper.css) just clips every category past
       the 2nd one, with no way to reach them. A plain scroll-snap row
       sidesteps that dependency entirely. Desktop is untouched — at
       --wd-col-lg:5 every card already fits in one row, no slider
       needed there. */
    @media (max-width: 768.98px) {
        .wd-cats .wd-carousel {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scroll-snap-type: x mandatory;
            touch-action: pan-x pan-y;
        }
        .wd-cats .wd-carousel-wrap {
            transform: none !important;
        }
        .wd-cats .wd-carousel-item {
            scroll-snap-align: start;
        }
        .wd-cats .wd-nav-arrows {
            display: none;
        }
    }
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
            style="--wd-col-lg:5;--wd-col-md:5;--wd-col-sm:2;--wd-gap-lg:20px;--wd-gap-sm:10px;">
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
