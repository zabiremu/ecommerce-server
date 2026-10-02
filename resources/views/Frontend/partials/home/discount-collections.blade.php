{{-- "Shop by Discount": one tile per active discount collection (20% OFF,
     30% OFF, Clearance Sale...). Fully dynamic — see App\Support\DiscountCollections.
     Renders nothing when no product is currently discounted. --}}
@if(!empty($discountCollections))
<div class="gms-section-priority-2 gms-discount-collections">
    <div class="wp-block-wd-container wd-dir-row wd-align-is-lg-center">
        <div>
            <span class="gms-section-eyebrow">Sale</span>
            <h2 class="wp-block-wd-title title gms-heading-tier-2">🔥 Shop by Discount</h2>
        </div>
        <a class="wp-block-wd-button btn btn-style-default btn-size-default btn-shape-semi-round" href="{{ route('offers') }}"><span>All offers</span></a>
    </div>
    <div class="gms-discount-tiles">
        @foreach($discountCollections as $dc)
            <a href="{{ $dc['url'] }}" class="gms-discount-tile">
                <span class="gms-discount-tile-label">{{ $dc['emoji'] }} {{ $dc['label'] }}</span>
                <span class="gms-discount-tile-count">{{ $dc['count'] }} {{ \Illuminate\Support\Str::plural('product', $dc['count']) }}</span>
            </a>
        @endforeach
    </div>
</div>
<style>
.gms-discount-tiles { display:flex; flex-wrap:wrap; gap:14px; margin-top:16px; }
.gms-discount-tile {
    display:flex; flex-direction:column; gap:4px; min-width:150px; padding:18px 22px; border-radius:14px;
    background:linear-gradient(135deg,#e63946,#b71c2b); color:#fff; text-decoration:none;
    box-shadow:0 4px 14px rgba(230,57,70,.25); transition:transform .15s, box-shadow .15s;
}
.gms-discount-tile:hover { transform:translateY(-2px); box-shadow:0 8px 20px rgba(230,57,70,.35); color:#fff; }
.gms-discount-tile-label { font-size:20px; font-weight:800; line-height:1.1; }
.gms-discount-tile-count { font-size:12px; opacity:.85; }
@media (max-width:768px) {
    .gms-discount-tiles { flex-wrap:nowrap; overflow-x:auto; padding-bottom:6px; }
    .gms-discount-tile { flex-shrink:0; min-width:140px; }
}
</style>
@endif
