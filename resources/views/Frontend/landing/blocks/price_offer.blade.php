@php
    $oldNum = (float) preg_replace('/[^0-9.]/', '', (string) ($block['old_price'] ?? ''));
    $newNum = (float) preg_replace('/[^0-9.]/', '', (string) ($block['new_price'] ?? ''));
    $savePct = ($oldNum > 0 && $newNum > 0 && $newNum < $oldNum) ? (int) round((($oldNum - $newNum) / $oldNum) * 100) : null;
@endphp
<section class="lp-sec lp-sec-green">
    <div class="lp-offer">
        @if ($savePct)<div class="lp-offer-badge"><i class="fas fa-bolt"></i> {{ $savePct }}% ছাড় — সাশ্রয় {{ \App\Support\Money::format($oldNum - $newNum) }}</div>@endif
        @if (!empty($block['label']))<div class="lp-offer-label">{{ $block['label'] }}</div>@endif
        <div class="lp-offer-prices">
            @if (!empty($block['old_price']))<span class="lp-offer-old">{{ \App\Support\Money::format($oldNum) }}</span>@endif
            @if (!empty($block['new_price']))<span class="lp-offer-new">{{ \App\Support\Money::format($newNum) }}</span>@endif
        </div>
        @if (!empty($block['note']))<div class="lp-offer-note">{{ $block['note'] }}</div>@endif
        <a href="#lp-order" class="lp-order-btn"><i class="fas fa-bag-shopping"></i> {{ $cta }}</a>
    </div>
</section>
