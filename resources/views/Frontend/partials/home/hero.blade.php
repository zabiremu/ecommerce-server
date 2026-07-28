<div class="wp-block-wd-row wd-7ae8bcf1 gms-hero-intro">
    <div class="wp-block-wd-column wd-1083b687">
        <span class="gms-section-eyebrow">{{ \App\Models\SiteSetting::get('home_hero_eyebrow', 'New Season') }}</span>
        <h2 class="wp-block-wd-title title wd-47de8d1e gms-heading-tier-1">{{ \App\Models\SiteSetting::get('home_hero_title', 'Everyday Style, Elevated') }}</h2>

        <h2 class="wp-block-wd-title title wd-56e5e720 wd-custom-width">{{ \App\Models\SiteSetting::get('home_hero_subtitle', 'Apparel and footwear chosen for quality and fit, at honest prices.') }}</h2>

        <div class="gms-hero-cta-row">
            <a href="{{ route('all-products') }}" class="gms-hero-cta">
                <span>Shop Collection</span>
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
            <div class="gms-hero-trust">
                <span><i class="gms-hero-dot"></i>Cash on Delivery</span>
                <span><i class="gms-hero-dot"></i>Nationwide Shipping</span>
                <span><i class="gms-hero-dot"></i>Easy Returns</span>
            </div>
        </div>
    </div>
</div>

<div class="wp-block-wd-slider wd-slider wd-carousel-container wd-anim-slide wd-autoplay-on wd-14565c68">
    <div class="wd-carousel-inner">
        <div class="wd-carousel wd-grid" data-effect="slide" data-wrap="yes" data-autoheight="yes"
            data-sliding_speed="700" style="--wd-col-lg:1;--wd-col-md:1;--wd-col-sm:1"
            data-autoplay="yes" data-speed="20000">
            <div class="wd-carousel-wrap">
                @foreach($sliders as $slider)
                @php
                    $slideImage = \Illuminate\Support\Facades\Storage::disk('public')->exists($slider->image)
                        ? \Illuminate\Support\Facades\Storage::url($slider->image)
                        : asset($slider->image);
                @endphp
                <div
                    class="wp-block-wd-slider-item wd-slide wd-carousel-item {{ $loop->even ? 'color-scheme-dark' : 'color-scheme-light' }}">
                    <div class="wd-slide-container">
                        <h2 class="wp-block-wd-title title wd-custom-width text-center">{{ $slider->title }}</h2>

                        @if($slider->subtitle)
                        <p class="wp-block-wd-paragraph wd-hide-sm">{{ $slider->subtitle }}</p>
                        @endif

                        @if($slider->description)
                        <p class="wp-block-wd-paragraph wd-hide-sm">{{ $slider->description }}</p>
                        @endif


                    </div>
                    <div class="wd-slide-bg wd-fill"><img decoding="async" width="1294" height="600"
                            src="{{ $slideImage }}" alt="{{ $slider->title }}" /></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div
        class="wd-nav-pagin-wrap wd-slider-pagin wd-custom-style wd-style-shape-3 wd-align color-scheme-dark">
        <ul class="wd-nav-pagin"></ul>
    </div>
</div>
