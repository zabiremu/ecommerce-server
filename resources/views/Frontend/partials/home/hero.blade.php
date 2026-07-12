<div class="wp-block-wd-row wd-7ae8bcf1">
    <div class="wp-block-wd-column wd-1083b687">
        <span class="gms-section-eyebrow">{{ \App\Models\SiteSetting::get('home_hero_eyebrow', "Today's Offer") }}</span>
        <h2 class="wp-block-wd-title title wd-47de8d1e gms-heading-tier-1">{{ \App\Models\SiteSetting::get('home_hero_title', 'Level Up Your Gear!') }}</h2>

        <h2 class="wp-block-wd-title title wd-56e5e720 wd-custom-width">{{ \App\Models\SiteSetting::get('home_hero_subtitle', 'Official Merch for Every Gamer – Shop Hoodies, Collectibles, Posters, and More!') }}</h2>
    </div>
</div>

<div class="wp-block-wd-slider wd-slider wd-carousel-container wd-anim-slide wd-autoplay-on wd-14565c68">
    <div class="wd-carousel-inner">
        <div class="wd-carousel wd-grid" data-effect="slide" data-wrap="yes" data-autoheight="yes"
            data-sliding_speed="700" style="--wd-col-lg:1;--wd-col-md:1;--wd-col-sm:1"
            data-autoplay="yes" data-speed="20000">
            <div class="wd-carousel-wrap">
                @foreach($sliders as $slider)
                <div
                    class="wp-block-wd-slider-item wd-slide wd-carousel-item {{ $loop->even ? 'color-scheme-dark' : 'color-scheme-light' }}">
                    <div class="wd-slide-container">
                        <h2 class="wp-block-wd-title title wd-custom-width">{{ $slider->title }}</h2>

                        @if($slider->subtitle)
                        <p class="wp-block-wd-paragraph wd-hide-sm">{{ $slider->subtitle }}</p>
                        @endif

                        @if($slider->description)
                        <p class="wp-block-wd-paragraph wd-hide-sm">{{ $slider->description }}</p>
                        @endif

                        <a class="wp-block-wd-button btn btn-style-default btn-color-primary btn-size-large btn-shape-semi-round"
                            href="{{ route('all-products') }}"><span>Shop
                                now</span></a>
                    </div>
                    <div class="wd-slide-bg wd-fill"><img decoding="async" width="1294" height="600"
                            src="{{ Storage::url($slider->image) }}" alt="{{ $slider->title }}" /></div>
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
