{{-- Product names on a purchase / GRN row so it can be found by product, not
     only by invoice number. Shows the first 3; the rest are listed in the
     tooltip and stay in the cell text, so the table search still finds them.
     $items: items with product_name (+ product), $qtyField: quantity column. --}}
@php
    $shown = $items->take(3);
    $rest  = $items->slice(3);
    $nameOf = fn ($i) => $i->product_name ?: ($i->product->name ?? '—');
    $qtyOf  = fn ($i) => rtrim(rtrim(number_format((float) $i->{$qtyField}, 2, '.', ''), '0'), '.');
@endphp
<div class="text-[12.5px] leading-[1.45]" title="{{ $items->map(fn ($i) => $nameOf($i) . ' × ' . $qtyOf($i))->implode("\n") }}">
    @foreach ($shown as $i)
        <div class="truncate" style="max-width:280px">{{ $nameOf($i) }} <span class="text-[#787c82]">× {{ $qtyOf($i) }}</span></div>
    @endforeach
    @if ($rest->isNotEmpty())
        <div class="text-[11.5px] text-[#2271b1]">+{{ $rest->count() }} more</div>
        <span style="display:none">{{ $rest->map($nameOf)->implode(', ') }}</span>
    @endif
    @if ($items->isEmpty())
        <span class="text-[#a7aaad]">—</span>
    @endif
</div>
