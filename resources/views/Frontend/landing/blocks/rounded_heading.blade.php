@php $style = ($block['style'] ?? 'green') === 'dark' ? 'dark' : 'green'; @endphp
<section class="lp-sec {{ $style === 'green' ? 'lp-sec-green' : 'lp-sec-dark' }}">
    <div class="lp-rhead lp-rhead-{{ $style }}">
        <span class="lp-rhead-badge"><i class="fas fa-star"></i></span>
        @if (!empty($block['heading']))<h2>{{ $block['heading'] }}</h2>@endif
        @if (!empty($block['subheading']))<p>{{ $block['subheading'] }}</p>@endif
    </div>
</section>
