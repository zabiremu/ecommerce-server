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
