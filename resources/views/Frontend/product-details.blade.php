@extends('Frontend.Layout.app')

@php
    $hasSale  = $product->sale_price && $product->sale_price < $product->selling_price;
    $current  = $hasSale ? (float) $product->sale_price : (float) $product->selling_price;
    $old      = $hasSale ? (float) $product->selling_price : null;
    $discount = $hasSale && $product->selling_price > 0
        ? (int) round((($product->selling_price - $product->sale_price) / $product->selling_price) * 100)
        : 0;
    $save     = $old ? ($old - $current) : 0;
    $stock    = (int) ($product->stock ?? 0);
    $oos      = $product->type !== 'digital' && $stock <= 0;
    $gallery  = collect($product->gallery ?? [])->pluck('path')->filter()->values();
    $images   = collect([$product->thumbnail])->merge($gallery)->filter()->unique()->values();
    $pageTitle = $product->name . ' — ' . (\App\Models\SiteSetting::get('company_name', 'NF Shop 24'));
@endphp

@section('title', $pageTitle)

@section('content')

{{-- Pass product data to JS --}}
<script>
window.NF_PRODUCT_SERVER_RENDERED = true;
window.NF_PD_ID = {{ $product->id }};
window.NF_PD_PRODUCT = {
    id:    {{ $product->id }},
    title: @json($product->name),
    cur:   {{ $current }},
    old:   {{ $old ?? $current }},
    stock: {{ $oos ? 0 : ($product->type === 'digital' ? 999 : $stock) }},
    img:   @json($images->isNotEmpty() ? Storage::url($images->first()) : ''),
};
window.NF_PD_VARIANTS = [
    @foreach ($product->variants as $v)
    {
        id:    {{ $v->id }},
        label: @json(trim(implode(' / ', array_filter([$v->color, $v->size])) ?: $v->name)),
        price: {{ (float) $v->price }},
        stock: {{ (int) $v->stock }},
        sku:   @json($v->sku ?? ''),
    },
    @endforeach
];
document.title = @json($pageTitle);
</script>

<!-- Breadcrumb -->
<section class="breadcrumb">
    <div class="container">
        <a href="{{ route('home') }}">Home</a>
        <i class="fas fa-chevron-right"></i>
        @if ($product->category)
            <a href="{{ route('category-products') }}?cat={{ $product->category->slug }}">{{ $product->category->name }}</a>
            <i class="fas fa-chevron-right"></i>
        @endif
        <span>{{ $product->name }}</span>
    </div>
</section>

<!-- Product Details -->
<section class="pd-section">
    <div class="container">
        <div class="pd-layout">
            <!-- Left: Gallery -->
            <div class="pd-gallery">
                <div class="pd-main-img">
                    @if ($discount > 0)
                        <span class="pd-badge">-{{ $discount }}%</span>
                    @endif
                    <button class="pd-wish" id="pdWishBtn"
                            onclick="toggleWish({{ $product->id }}, this)">
                        <i class="far fa-heart"></i>
                    </button>
                    @if ($images->isNotEmpty())
                        <img src="{{ Storage::url($images->first()) }}" alt="{{ $product->name }}" id="mainImg">
                    @endif
                </div>
                @if ($images->count() > 1)
                    <div class="pd-thumbs" id="pdThumbs">
                        @foreach ($images as $i => $img)
                            <img src="{{ Storage::url($img) }}" alt="Thumb {{ $i + 1 }}"
                                 class="{{ $i === 0 ? 'active' : '' }}" onclick="changeImg(this)">
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Right: Info -->
            <div class="pd-info">
                @if ($product->brand)
                    <div class="pd-brand">{{ strtoupper($product->brand->name) }}</div>
                @endif
                <h1 class="pd-title">{{ $product->name }}</h1>

                <!-- SKU -->
                @if ($product->sku)
                    <div class="text-[13px] text-[#94a3b8] mb-1">SKU: <span class="font-mono">{{ $product->sku }}</span></div>
                @endif

                <div class="pd-price-wrap" id="pdPriceWrap">
                    <div class="pd-price">
                        <span class="cur" id="pdCur">TK {{ number_format($current) }}</span>
                        @if ($old)
                            <span class="old">TK {{ number_format($old) }}</span>
                            <span class="off">-{{ $discount }}%</span>
                        @endif
                    </div>
                    @if ($save > 0)
                        <div class="pd-save">You save <strong>TK {{ number_format($save) }}</strong></div>
                    @endif
                </div>

                <!-- Stock -->
                <div class="pd-stock" id="pdStock" @if($oos) style="color:#dc2626;font-weight:600" @endif>
                    <i class="fas {{ $oos ? 'fa-times-circle' : 'fa-check-circle' }}"></i>
                    <span id="pdStockText">
                    @if ($oos) Out of Stock
                    @elseif ($product->type === 'digital') Digital Product
                    @elseif ($stock > 0) {{ $stock }} In Stock
                    @else In Stock
                    @endif
                    </span>
                </div>

                @if ($product->short_description)
                    <div class="pd-desc">{{ $product->short_description }}</div>
                @elseif ($product->description)
                    <div class="pd-desc">{{ \Illuminate\Support\Str::limit(strip_tags($product->description), 280) }}</div>
                @endif

                @if ($product->variants->isNotEmpty())
                <!-- Variant Selector -->
                <div class="pd-variant" style="margin-bottom:14px">
                    <label for="pdVariant" style="display:block;font-weight:600;margin-bottom:6px">Options</label>
                    <select id="pdVariant" onchange="pdVariantChange()" style="width:100%;padding:10px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:14px">
                        <option value="">-- Select an option (optional) --</option>
                        @foreach ($product->variants as $v)
                            <option value="{{ $v->id }}"
                                data-price="{{ (float) $v->price }}"
                                data-stock="{{ (int) $v->stock }}"
                                data-sku="{{ $v->sku }}">
                                {{ trim(implode(' / ', array_filter([$v->color, $v->size])) ?: $v->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <!-- Quantity & Actions -->
                <div class="pd-actions">
                    @if (!$oos)
                    <div class="pd-qty">
                        <button type="button" onclick="qtyChange(-1)"><i class="fas fa-minus"></i></button>
                        <input type="number" value="1" min="1" max="{{ $product->type === 'digital' ? 99 : $stock }}"
                               id="qtyInput" readonly>
                        <button type="button" onclick="qtyChange(1)"><i class="fas fa-plus"></i></button>
                    </div>
                    @endif

                    @if ($oos)
                        <button class="btn-order-lg" disabled
                            style="opacity:.5;cursor:not-allowed;background:#9ca3af;border-color:#9ca3af;flex:1">
                            <i class="fas fa-times-circle"></i> Out of Stock
                        </button>
                    @else
                        <button class="btn-order-lg"
                                onclick="pdOrderNow({{ $product->id }})">
                            <i class="fas fa-shopping-cart"></i> Order Now
                        </button>
                        <button class="btn-cart"
                                onclick="pdAddToCart({{ $product->id }})">
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </button>
                    @endif
                </div>

                <!-- Extra Info -->
                <div class="pd-extra">
                    <div class="pd-extra-item">
                        <i class="fas fa-shield-alt"></i>
                        <span><strong>Safe Payment</strong> — Cash on Delivery</span>
                    </div>
                    <div class="pd-extra-item">
                        <i class="fas fa-undo-alt"></i>
                        <span><strong>Easy Returns</strong> — 7 days return policy</span>
                    </div>
                    <div class="pd-extra-item">
                        <i class="fas fa-truck"></i>
                        <span><strong>Free Delivery</strong> — Orders above TK 500</span>
                    </div>
                </div>

                <!-- Share -->
                <div class="pd-share">
                    <span>Share:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current() . '?id=' . $product->id) }}" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($product->name . ' — TK ' . number_format($current) . ' — ' . url()->current() . '?id=' . $product->id) }}" target="_blank" rel="noopener"><i class="fab fa-whatsapp"></i></a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current() . '?id=' . $product->id) }}&text={{ urlencode($product->name) }}" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
                    <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(url()->current() . '?id=' . $product->id) }}&description={{ urlencode($product->name) }}" target="_blank" rel="noopener"><i class="fab fa-pinterest-p"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Product Tabs -->
<section class="pd-tabs-section">
    <div class="container">
        <div class="pd-tabs">
            <button class="pd-tab active" onclick="switchTab(this, 'desc')">Description</button>
            <button class="pd-tab" onclick="switchTab(this, 'reviews')">Reviews ({{ $totalReviews }})</button>
            <button class="pd-tab" onclick="switchTab(this, 'shipping')">Shipping Info</button>
        </div>
        <div class="pd-tab-content active" id="tabDesc">
            <div class="pd-tab-inner">
                @if ($product->long_description)
                    {!! $product->long_description !!}
                @elseif ($product->description)
                    <h3>Product Description</h3>
                    <p>{{ $product->description }}</p>
                @else
                    <p style="color:#94a3b8">No description available for this product.</p>
                @endif
            </div>
        </div>
        <!-- Reviews Tab -->
        <div class="pd-tab-content" id="tabReviews">
            <div class="pd-tab-inner">

                {{-- Average rating summary --}}
                @if ($totalReviews > 0)
                <div class="review-summary" style="display:flex;align-items:center;gap:20px;margin-bottom:28px;padding:20px;background:#f8fafc;border-radius:12px;">
                    <div style="text-align:center;min-width:80px;">
                        <div style="font-size:48px;font-weight:700;line-height:1;color:#1e293b;">{{ $avgRating }}</div>
                        <div style="color:#f59e0b;font-size:18px;margin:4px 0;">
                            @for ($s = 1; $s <= 5; $s++)
                                <i class="{{ $s <= round($avgRating) ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </div>
                        <div style="font-size:12px;color:#64748b;">{{ $totalReviews }} {{ Str::plural('review', $totalReviews) }}</div>
                    </div>
                    <div style="flex:1;">
                        @foreach ([5,4,3,2,1] as $star)
                            @php $cnt = $reviews->where('rating', $star)->count(); $pct = $totalReviews > 0 ? ($cnt / $totalReviews * 100) : 0; @endphp
                            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;font-size:13px;">
                                <span style="width:14px;text-align:right;color:#64748b;">{{ $star }}</span>
                                <i class="fas fa-star" style="color:#f59e0b;font-size:11px;"></i>
                                <div style="flex:1;height:8px;background:#e2e8f0;border-radius:4px;overflow:hidden;">
                                    <div style="width:{{ $pct }}%;height:100%;background:#f59e0b;border-radius:4px;"></div>
                                </div>
                                <span style="width:24px;color:#64748b;">{{ $cnt }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Review list --}}
                <div id="reviewList">
                    @forelse ($reviews as $review)
                    <div class="review-item" style="border-bottom:1px solid #e2e8f0;padding:18px 0;">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:6px;">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:38px;height:38px;background:#3b82f6;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:15px;">
                                    {{ strtoupper(substr($review->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:600;font-size:15px;color:#1e293b;">{{ $review->name }}</div>
                                    <div style="color:#f59e0b;font-size:13px;">
                                        @for ($s = 1; $s <= 5; $s++)
                                            <i class="{{ $s <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <span style="font-size:12px;color:#94a3b8;">{{ $review->created_at->format('d M Y') }}</span>
                        </div>
                        <p style="margin:0;color:#475569;font-size:14px;line-height:1.6;">{{ $review->comment }}</p>
                    </div>
                    @empty
                    <p id="noReviewMsg" style="color:#94a3b8;text-align:center;padding:20px 0;">No reviews yet. Be the first to review this product!</p>
                    @endforelse
                </div>

                {{-- Submit review form --}}
                <div style="margin-top:32px;">
                    <h3 style="font-size:18px;font-weight:700;margin-bottom:16px;color:#1e293b;">Write a Review</h3>

                    {{-- Login prompt (shown when not logged in) --}}
                    <div id="reviewLoginPrompt" style="display:none;text-align:center;padding:28px 20px;background:#f8fafc;border:1px dashed #cbd5e1;border-radius:12px;">
                        <i class="fas fa-lock" style="font-size:32px;color:#94a3b8;margin-bottom:12px;display:block;"></i>
                        <p style="color:#475569;margin:0 0 16px;font-size:15px;">You must be logged in to write a review.</p>
                        <a href="{{ route('login') }}" style="display:inline-block;background:#3b82f6;color:#fff;padding:10px 28px;border-radius:8px;font-size:14px;font-weight:600;text-decoration:none;">
                            <i class="fas fa-sign-in-alt"></i> Login to Review
                        </a>
                    </div>

                    {{-- Review form (shown when logged in) --}}
                    <form id="reviewForm" onsubmit="submitReview(event)" style="display:none;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        {{-- Logged-in user info badge --}}
                        <div id="reviewUserBadge" style="display:flex;align-items:center;gap:12px;margin-bottom:20px;padding:12px 16px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;">
                            <div id="reviewUserAvatar" style="width:40px;height:40px;background:#3b82f6;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:17px;flex-shrink:0;"></div>
                            <div>
                                <div id="reviewUserName" style="font-weight:600;font-size:15px;color:#1e293b;"></div>
                                <div id="reviewUserEmail" style="font-size:12px;color:#64748b;"></div>
                            </div>
                            <i class="fas fa-check-circle" style="margin-left:auto;color:#22c55e;font-size:18px;" title="Logged in"></i>
                        </div>

                        <input type="hidden" name="name"  id="reviewNameHidden">
                        <input type="hidden" name="email" id="reviewEmailHidden">

                        {{-- Star rating picker --}}
                        <div style="margin-bottom:16px;">
                            <label style="display:block;font-size:13px;font-weight:600;margin-bottom:8px;color:#374151;">Your Rating <span style="color:#ef4444;">*</span></label>
                            <div class="star-picker" id="starPicker" style="display:flex;gap:6px;font-size:28px;cursor:pointer;">
                                @for ($s = 1; $s <= 5; $s++)
                                    <i class="far fa-star" style="color:#f59e0b;" data-val="{{ $s }}" onclick="pickStar({{ $s }})"></i>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="ratingInput" value="">
                        </div>

                        <div style="margin-bottom:16px;">
                            <label style="display:block;font-size:13px;font-weight:600;margin-bottom:6px;color:#374151;">Review <span style="color:#ef4444;">*</span></label>
                            <textarea name="comment" rows="4" placeholder="Share your experience with this product..." required
                                style="width:100%;padding:10px 14px;border:1px solid #e2e8f0;border-radius:8px;font-size:14px;outline:none;resize:vertical;"></textarea>
                        </div>

                        <div id="reviewMsg" style="display:none;margin-bottom:12px;padding:10px 16px;border-radius:8px;font-size:14px;"></div>

                        <button type="submit" id="reviewSubmitBtn"
                            style="background:#3b82f6;color:#fff;border:none;padding:11px 28px;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;">
                            <i class="fas fa-paper-plane"></i> Submit Review
                        </button>
                    </form>
                </div>

            </div>
        </div>

        <div class="pd-tab-content" id="tabShipping">
            <div class="pd-tab-inner">
                <h3>Shipping & Delivery</h3>
                <ul>
                    <li><strong>Delivery Time:</strong> 2-5 business days anywhere in Bangladesh.</li>
                    <li><strong>Cash on Delivery:</strong> Pay when you receive the product.</li>
                    <li><strong>Free Shipping:</strong> On orders above TK 500.</li>
                    <li><strong>Tracking:</strong> Order tracking available via our website.</li>
                </ul>
                <h3>Return Policy</h3>
                <ul>
                    <li>7 days easy return from the date of delivery.</li>
                    <li>Product must be unused and in original packaging.</li>
                    <li>Full refund or exchange available.</li>
                </ul>
                <h3>Payment Methods</h3>
                <ul>
                    <li>Cash on Delivery (COD)</li>
                    <li>bKash / Nagad / Rocket</li>
                    <li>Bank Transfer</li>
                    <li>UddoktaPay (online payment)</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
@if ($related->isNotEmpty())
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2><i class="fas fa-tags"></i> Related Products</h2>
            <a href="{{ route('all-products') }}">View All <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="product-grid">
            @foreach ($related as $r)
                @php
                    $rHasSale = $r->sale_price && $r->sale_price < $r->selling_price;
                    $rCur     = (float) ($rHasSale ? $r->sale_price : $r->selling_price);
                    $rOld     = $rHasSale ? (float) $r->selling_price : null;
                    $rDisc    = $rHasSale && $r->selling_price > 0
                        ? (int) round((($r->selling_price - $r->sale_price) / $r->selling_price) * 100) : 0;
                    $rStock   = (int) ($r->stock ?? 0);
                    $rOos     = $r->type !== 'digital' && $rStock <= 0;
                @endphp
                <div class="product-card fade-up" data-id="{{ $r->id }}">
                    @if ($rOos)
                        <span class="badge" style="background:#dc2626">Out of Stock</span>
                    @elseif ($rDisc > 0)
                        <span class="badge">-{{ $rDisc }}%</span>
                    @endif
                    <button class="wish"><i class="far fa-heart"></i></button>
                    <a href="{{ route('product-details') }}?slug={{ $r->slug }}" class="img-wrap"
                       style="{{ $rOos ? 'opacity:.65' : '' }}">
                        @if ($r->thumbnail)
                            <img src="{{ Storage::url($r->thumbnail) }}" alt="{{ $r->name }}">
                        @endif
                    </a>
                    <div class="info">
                        <a href="{{ route('product-details') }}?slug={{ $r->slug }}" class="title">{{ $r->name }}</a>
                        <div class="stock" @if($rOos) style="color:#dc2626" @endif>
                            <i class="fas {{ $rOos ? 'fa-times-circle' : 'fa-check-circle' }}"></i>
                            @if ($rOos) Out of Stock
                            @elseif ($rStock > 0) {{ $rStock }} In Stock
                            @else In Stock
                            @endif
                        </div>
                        <div class="price">
                            <span class="cur">TK {{ number_format($rCur) }}</span>
                            @if ($rOld)
                                <span class="old">TK {{ number_format($rOld) }}</span>
                            @endif
                        </div>
                        @if ($rOos)
                            <button class="btn-order" disabled
                                style="opacity:.5;cursor:not-allowed;background:#9ca3af;border-color:#9ca3af">
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    var user = null;
    try { user = JSON.parse(localStorage.getItem('nfshop_logged')); } catch(e) {}

    if (user && user.name) {
        // Show form, hide login prompt
        document.getElementById('reviewForm').style.display = 'block';
        document.getElementById('reviewLoginPrompt').style.display = 'none';

        // Fill hidden inputs
        document.getElementById('reviewNameHidden').value  = user.name;
        document.getElementById('reviewEmailHidden').value = user.email || '';

        // Fill user badge
        document.getElementById('reviewUserAvatar').textContent = user.name.charAt(0).toUpperCase();
        document.getElementById('reviewUserName').textContent   = user.name;
        document.getElementById('reviewUserEmail').textContent  = user.email || '';
    } else {
        // Show login prompt, hide form
        document.getElementById('reviewLoginPrompt').style.display = 'block';
        document.getElementById('reviewForm').style.display = 'none';
    }
});

function pickStar(val) {
    document.getElementById('ratingInput').value = val;
    document.querySelectorAll('#starPicker i').forEach(function(el, i) {
        el.className = (i < val) ? 'fas fa-star' : 'far fa-star';
        el.style.color = '#f59e0b';
    });
}

function submitReview(e) {
    e.preventDefault();
    var form   = document.getElementById('reviewForm');
    var btn    = document.getElementById('reviewSubmitBtn');
    var msgBox = document.getElementById('reviewMsg');
    var rating = document.getElementById('ratingInput').value;

    if (!rating) {
        showReviewMsg('Please select a star rating.', 'error');
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';

    var data = new FormData(form);

    fetch('{{ route('product-reviews.store') }}', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: data,
    })
    .then(function(res) { return res.json(); })
    .then(function(json) {
        if (json.success) {
            showReviewMsg('Thank you! Your review has been submitted.', 'success');
            form.reset();
            pickStar(0);
            document.getElementById('ratingInput').value = '';
            prependReview(json.review);
            var noMsg = document.getElementById('noReviewMsg');
            if (noMsg) noMsg.remove();
        } else {
            showReviewMsg('Something went wrong. Please try again.', 'error');
        }
    })
    .catch(function() {
        showReviewMsg('Something went wrong. Please try again.', 'error');
    })
    .finally(function() {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-paper-plane"></i> Submit Review';
    });
}

function showReviewMsg(text, type) {
    var box = document.getElementById('reviewMsg');
    box.textContent = text;
    box.style.display = 'block';
    box.style.background = type === 'success' ? '#dcfce7' : '#fee2e2';
    box.style.color       = type === 'success' ? '#166534' : '#991b1b';
    setTimeout(function() { box.style.display = 'none'; }, 5000);
}

function prependReview(r) {
    var stars = '';
    for (var i = 1; i <= 5; i++) {
        stars += '<i class="' + (i <= r.rating ? 'fas' : 'far') + ' fa-star"></i>';
    }
    var html = '<div class="review-item" style="border-bottom:1px solid #e2e8f0;padding:18px 0;">' +
        '<div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:6px;">' +
            '<div style="display:flex;align-items:center;gap:10px;">' +
                '<div style="width:38px;height:38px;background:#3b82f6;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:15px;">' +
                    r.name.charAt(0).toUpperCase() +
                '</div>' +
                '<div>' +
                    '<div style="font-weight:600;font-size:15px;color:#1e293b;">' + r.name + '</div>' +
                    '<div style="color:#f59e0b;font-size:13px;">' + stars + '</div>' +
                '</div>' +
            '</div>' +
            '<span style="font-size:12px;color:#94a3b8;">' + r.created_at + '</span>' +
        '</div>' +
        '<p style="margin:0;color:#475569;font-size:14px;line-height:1.6;">' + r.comment + '</p>' +
    '</div>';

    document.getElementById('reviewList').insertAdjacentHTML('afterbegin', html);

    // update tab label count
    document.querySelectorAll('.pd-tab').forEach(function(btn) {
        if (btn.getAttribute('onclick') && btn.getAttribute('onclick').includes('reviews')) {
            var match = btn.textContent.match(/\d+/);
            var cnt = match ? parseInt(match[0]) + 1 : 1;
            btn.textContent = 'Reviews (' + cnt + ')';
        }
    });
}
</script>
@endsection
