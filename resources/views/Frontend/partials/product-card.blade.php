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
@endphp
<div class="wd-carousel-item">
    <div class="wd-product wd-hover-quick product-grid-item product type-product{{ $outOfStock ? ' outofstock' : ' instock' }} has-post-thumbnail{{ $hasSale ? ' sale' : '' }}"
        data-id="{{ $product->id }}">

        <div class="wd-product-wrapper product-wrapper">
            <div class="wd-product-thumb product-element-top wd-quick-shop">
                <a href="{{ $detailsUrl }}" class="wd-product-img-link product-image-link" tabindex="-1"
                    aria-label="{{ $product->name }}">
                    <img loading="lazy" decoding="async" width="263" height="300" src="{{ $thumbUrl }}"
                        class="attachment-263x300 size-263x300" alt="{{ $product->name }}" />
                </a>

                <div class="product-labels labels-rounded-sm">
                    @if($hasSale)
                        <span class="onsale product-label wd-shape-round-sm">Sale</span>
                    @endif
                    @if($isNew)
                        <span class="product-label wd-shape-round-sm new">New</span>
                    @endif
                    @if($isBestSeller)
                        <span class="product-label wd-shape-round-sm bestseller">Bestseller</span>
                    @endif
                    @if($lowStock)
                        <span class="product-label wd-shape-round-sm limited">Limited</span>
                    @endif
                </div>

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
                            <span class="wd-action-icon"></span>
                            <span class="wd-action-text">Quick view</span>
                        </a>
                    </div>
                    <div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
                        <a class="" href="{{ route('wishlist') }}" data-product-id="{{ $product->id }}" rel="nofollow">
                            <span class="wd-action-icon"><span class="wd-check-icon"></span></span>
                            <span class="wd-action-text">Add to wishlist</span>
                        </a>
                    </div>
                </div>

                <div class="wd-add-btn wd-add-btn-replace">
                    @if($outOfStock)
                        <span class="button add-to-cart-loop wd-disabled" aria-disabled="true"><span
                                class="wd-action-text">Out of stock</span></span>
                    @else
                        <a href="{{ $detailsUrl }}" class="button add_to_cart_button add-to-cart-loop"
                            data-product_id="{{ $product->id }}" aria-label="View {{ $product->name }}" rel="nofollow">
                            <span class="wd-action-icon"><span class="wd-check-icon"></span></span>
                            <span class="wd-action-text">{{ $product->type === 'variable' ? 'Select options' : 'Add to cart' }}</span>
                        </a>
                    @endif
                </div>
            </div>
            <div class="product-element-bottom">
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
            </div>
        </div>
    </div>
</div>
