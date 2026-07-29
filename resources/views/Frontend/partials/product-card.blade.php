@php
    $hasSale = $product->sale_price && $product->sale_price < $product->selling_price;
    $displayPrice = $hasSale ? $product->sale_price : $product->selling_price;
    $avgRating = round($product->avg_rating ?? 0, 1);
    $reviewsCount = (int) ($product->reviews_count ?? 0);
    $detailsUrl = route('product-details') . '?slug=' . $product->slug;
    $resolveImage = function ($path) {
        if (!$path) return null;
        return \Illuminate\Support\Facades\Storage::disk('public')->exists($path)
            ? \Illuminate\Support\Facades\Storage::url($path)
            : asset($path);
    };
    $thumbUrl = $resolveImage($product->thumbnail);
    $galleryFirst = $product->gallery[0] ?? null;
    $hoverPath = is_array($galleryFirst) ? ($galleryFirst['path'] ?? null) : $galleryFirst;
    $hoverUrl = $hoverPath ? $resolveImage($hoverPath) : null;

    $isNew = $product->created_at && $product->created_at->gt(now()->subDays(14));
    $isBestSeller = in_array($product->id, $bestSellerIds ?? [], true);
    $stock = (float) ($product->stock ?? 0);
    $alertQty = (float) ($product->alert_quantity ?? 0);
    $outOfStock = $stock <= 0;
    $lowStock = !$outOfStock && $alertQty > 0 && $stock <= $alertQty;

    $ribbonLabels = [];
    if ($outOfStock) {
        $ribbonLabels[] = 'Sold Out';
    } else {
        if ($hasSale) $ribbonLabels[] = 'Sale';
        if ($isNew) $ribbonLabels[] = 'New Arrival';
        if ($isBestSeller) $ribbonLabels[] = 'Bestseller';
        if ($lowStock) $ribbonLabels[] = 'Limited';
    }
@endphp
<div class="wd-carousel-item">
    <div class="wd-product product-grid-item product type-product{{ $outOfStock ? ' outofstock' : ' instock' }} has-post-thumbnail{{ $hasSale ? ' sale' : '' }}"
        data-id="{{ $product->id }}">

        <div class="wd-product-wrapper product-wrapper p-0">
            <div class="wd-product-thumb product-element-top wd-quick-shop">
                <a href="{{ $detailsUrl }}" class="wd-product-img-link product-image-link" tabindex="-1"
                    aria-label="{{ $product->name }}">
                    <img loading="lazy" decoding="async" width="263" height="300" src="{{ $thumbUrl }}"
                        class="attachment-263x300 size-263x300" alt="{{ $product->name }}" />
                </a>

                @if(count($ribbonLabels))
                    <div class="gms-ribbon{{ $outOfStock ? ' gms-ribbon-soldout' : '' }}">
                        <div class="gms-ribbon-inner">
                            @foreach($ribbonLabels as $label)
                                <span>{{ $label }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($hoverUrl)
                    <div class="wd-product-img-hover hover-img">
                        <img loading="lazy" decoding="async" width="263" height="300" src="{{ $hoverUrl }}"
                            class="attachment-263x300 size-263x300" alt="{{ $product->name }}" />
                    </div>
                @endif
                <div class="wd-buttons wd-pos-r-t">
                    <div class="wd-quick-view-btn wd-quick-view-icon wd-action-btn wd-style-icon">
                        <a href="{{ $detailsUrl }}" class="open-quick-view" rel="nofollow" data-id="{{ $product->id }}"
                            data-quick-view-url="{{ route('product.quick-view', $product) }}">
                            <span class="wd-action-icon">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7S1.5 12 1.5 12Z" />
                                    <circle cx="12" cy="12" r="3.25" />
                                </svg>
                            </span>
                            <span class="wd-action-text wd-visually-hidden">Quick view</span>
                        </a>
                    </div>
                    <div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
                        <a class="" href="{{ route('wishlist') }}" data-product-id="{{ $product->id }}" rel="nofollow"
                            onclick="nfWishlistClick(event, {{ $product->id }})">
                            <span class="wd-action-icon">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M12 20.5s-7.5-4.6-10-9.3C.4 8 1.7 4.7 4.8 3.7c2.1-.7 4.3.1 5.6 1.9l1.6 2.1 1.6-2.1c1.3-1.8 3.5-2.6 5.6-1.9 3.1 1 4.4 4.3 2.8 7.5-2.5 4.7-10 9.3-10 9.3Z" />
                                </svg>
                                <span class="wd-check-icon"></span>
                            </span>
                            <span class="wd-action-text wd-visually-hidden">Add to wishlist</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="product-element-bottom text-left">
                <h3 class="wd-entities-title"><a href="{{ $detailsUrl }}">{{ $product->name }}</a></h3>

                @if($avgRating > 0)
                    <div class="star-rating" role="img" aria-label="Rated {{ $avgRating }} out of 5">
                        <span style="width:{{ $avgRating / 5 * 100 }}%">
                            Rated <strong class="rating">{{ $avgRating }}</strong> out of 5
                        </span>
                    </div>
                    @if($reviewsCount > 0)
                        <span class="wd-review-count" style="font-size:12px;color:#888">({{ $reviewsCount }})</span>
                    @endif
                @endif

                <span class="price">
                    @if($hasSale)
                        <del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi>{{ \App\Support\Money::format($product->selling_price) }}</bdi></span></del>
                        <ins aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi>{{ \App\Support\Money::format($displayPrice) }}</bdi></span></ins>
                    @else
                        <span class="woocommerce-Price-amount amount"><bdi>{{ \App\Support\Money::format($displayPrice) }}</bdi></span>
                    @endif
                </span>

                @if($outOfStock)
                    <span class="wd-stock-status out-of-stock">Out of stock</span>
                @elseif($lowStock)
                    <span class="wd-stock-status low-stock">Only {{ rtrim(rtrim(number_format($stock, 2), '0'), '.') }} left</span>
                @else
                    <span class="wd-stock-status in-stock">In stock</span>
                @endif

                <div class="wd-add-btn wd-add-btn-replace">
                    @if($outOfStock)
                        <span class="button add-to-cart-loop wd-disabled" aria-disabled="true"><span
                                class="wd-action-text">Out of stock</span></span>
                    @elseif($product->type === 'variable')
                        <a href="{{ $detailsUrl }}" class="button add_to_cart_button add-to-cart-loop"
                            data-product_id="{{ $product->id }}" aria-label="View {{ $product->name }}" rel="nofollow">
                            <span class="wd-action-icon">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="9" cy="21" r="1" /><circle cx="19" cy="21" r="1" />
                                    <path d="M1 1h3l2.7 13.4a2 2 0 0 0 2 1.6h9.6a2 2 0 0 0 2-1.6L23 6H6" />
                                </svg>
                            </span>
                            <span class="wd-action-text">Select options</span>
                        </a>
                    @else
                        <a href="#" class="button add_to_cart_button add-to-cart-loop" rel="nofollow"
                            aria-label="Add {{ $product->name }} to cart"
                            data-cart-add="{{ $product->id }}"
                            data-title="{{ $product->name }}"
                            data-price="{{ $displayPrice }}"
                            data-img="{{ $thumbUrl }}"
                            data-url="{{ $detailsUrl }}">
                            <span class="wd-action-icon">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="9" cy="21" r="1" /><circle cx="19" cy="21" r="1" />
                                    <path d="M1 1h3l2.7 13.4a2 2 0 0 0 2 1.6h9.6a2 2 0 0 0 2-1.6L23 6H6" />
                                </svg>
                            </span>
                            <span class="wd-action-text">Add to cart</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
