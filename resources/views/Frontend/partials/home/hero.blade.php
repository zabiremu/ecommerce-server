
<div class="wp-block-wd-slider wd-slider wd-carousel-container wd-anim-slide wd-autoplay-on wd-14565c68">
    <div class="wd-carousel-inner">
        <div class="wd-carousel wd-grid" data-effect="slide" data-wrap="yes" data-autoheight="yes"
            data-sliding_speed="700" style="--wd-col-lg:1;--wd-col-md:1;--wd-col-sm:1"
            data-autoplay="yes" data-speed="20000">
            <div class="wd-carousel-wrap">
                @foreach($sliders as $slider)
                @php
                    $slideImage = !empty($slider->image) && \Illuminate\Support\Facades\Storage::disk('public')->exists($slider->image)
                        ? \Illuminate\Support\Facades\Storage::url($slider->image)
                        : (!empty($slider->image) ? asset($slider->image) : null);
                    $slideUrl = $slider->url ?? null;
                @endphp
                <div
                    class="wp-block-wd-slider-item wd-slide wd-carousel-item {{ $loop->even ? 'color-scheme-dark' : 'color-scheme-light' }}">

                    <div class="wd-slide-bg wd-fill">
                        @if($slideImage)
                            <img decoding="async" width="1294" height="600" src="{{ $slideImage }}" alt="{{ $slider->title }}" />
                        @else
                            <div class="gms-slide-fallback-bg" aria-hidden="true"></div>
                        @endif
                    </div>
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
