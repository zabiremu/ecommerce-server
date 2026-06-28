@php $vid = \App\Models\ProductLandingPage::youtubeId($block['url'] ?? ''); @endphp
@if ($vid)
<section class="lp-sec lp-sec-dark">
    @if (!empty($block['title']))
        <h2 class="lp-vid-title">{{ $block['title'] }}</h2>
    @endif
    <div class="lp-video">
        <iframe src="https://www.youtube.com/embed/{{ $vid }}" title="{{ $block['title'] ?? 'video' }}"
                frameborder="0" loading="lazy"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
    </div>
    @if (!empty($block['description']))
        <p class="lp-vid-desc">{{ $block['description'] }}</p>
    @endif
</section>
@endif
