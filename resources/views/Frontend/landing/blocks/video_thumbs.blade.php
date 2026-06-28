@php $items = $block['items'] ?? []; @endphp
@if (count($items))
<section class="lp-sec lp-sec-green">
    <div class="lp-thumbs-row">
        @foreach ($items as $it)
            @php $vid = \App\Models\ProductLandingPage::youtubeId($it['url'] ?? ''); @endphp
            @if ($vid)
            <a class="lp-thumb" href="https://www.youtube.com/watch?v={{ $vid }}" target="_blank" rel="noopener">
                <span class="lp-thumb-img">
                    <img src="https://img.youtube.com/vi/{{ $vid }}/hqdefault.jpg" alt="{{ $it['label'] ?? 'review' }}" loading="lazy">
                    <span class="lp-thumb-play"><i class="fas fa-play"></i></span>
                </span>
                @if (!empty($it['label']))<span class="lp-thumb-label">{{ $it['label'] }}</span>@endif
            </a>
            @endif
        @endforeach
    </div>
</section>
@endif
