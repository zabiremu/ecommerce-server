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
