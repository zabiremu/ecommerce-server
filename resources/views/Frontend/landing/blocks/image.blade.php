@php $imageUrl = \App\Support\PublicImage::url($block['path'] ?? null); @endphp
@if ($imageUrl)
<section class="lp-sec lp-sec-dark">
    <figure class="lp-figure">
        <img src="{{ $imageUrl }}" alt="{{ $block['caption'] ?? '' }}" loading="lazy">
        @if (!empty($block['caption']))<figcaption>{{ $block['caption'] }}</figcaption>@endif
    </figure>
    <div class="lp-cta-wrap"><a href="#lp-order" class="lp-order-btn"><i class="fas fa-bag-shopping"></i> {{ $cta }}</a></div>
</section>
@endif
