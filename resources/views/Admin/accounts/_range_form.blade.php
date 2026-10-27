{{-- From/To picker with quick presets. Expects $route, $from, $to, $today; optional $keep (extra query params). --}}
@php
    $keep = array_filter($keep ?? [], fn ($v) => $v !== null && $v !== '');
    $todayC = \Illuminate\Support\Carbon::parse($today);
    $presets = [
        'Today'        => [$today, $today],
        'Last 7 days'  => [$todayC->copy()->subDays(6)->toDateString(), $today],
        'Last 30 days' => [$todayC->copy()->subDays(29)->toDateString(), $today],
        'This month'   => [$todayC->copy()->startOfMonth()->toDateString(), $today],
        'Last month'   => [$todayC->copy()->subMonthNoOverflow()->startOfMonth()->toDateString(), $todayC->copy()->subMonthNoOverflow()->endOfMonth()->toDateString()],
        'This year'    => [$todayC->copy()->startOfYear()->toDateString(), $today],
    ];
@endphp
<div class="flex flex-wrap items-end justify-between gap-3 mb-4">
    <form method="GET" action="{{ route($route) }}" class="flex flex-wrap items-end gap-2">
        @foreach ($keep as $k => $v)<input type="hidden" name="{{ $k }}" value="{{ $v }}">@endforeach
        <div>
            <label class="block text-[12px] font-semibold text-[#50575e] mb-1">From</label>
            <input type="date" name="from" value="{{ $from }}" max="{{ $today }}" class="wp-input" style="width:160px">
        </div>
        <div>
            <label class="block text-[12px] font-semibold text-[#50575e] mb-1">To</label>
            <input type="date" name="to" value="{{ $to }}" max="{{ $today }}" class="wp-input" style="width:160px">
        </div>
        <button type="submit" class="wp-btn wp-btn-primary">Show</button>
    </form>
    <div class="flex flex-wrap gap-1.5">
        @foreach ($presets as $label => [$pf, $pt])
            <a href="{{ route($route, $keep + ['from' => $pf, 'to' => $pt]) }}" class="wp-btn {{ $pf === $from && $pt === $to ? 'wp-btn-primary' : '' }}">{{ $label }}</a>
        @endforeach
    </div>
</div>
