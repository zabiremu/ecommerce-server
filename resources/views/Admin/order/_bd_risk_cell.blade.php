@php
    $bdData    = $order->bdcourier_data ?? [];
    $couriers  = $bdData['couriers'] ?? [];
    $repList   = $bdData['reports']  ?? [];
    $cancelled = $bdData['cancelled'] ?? 0;

    if ($bdChecked && $bdTotal > 0) {
        if ($bdr < 60)      { $bdColor = '#b91c1c'; $bdBg = '#fee2e2'; $bdIcon = 'fa-triangle-exclamation'; $bdLevel = 'High Risk';   }
        elseif ($bdr < 80)  { $bdColor = '#b45309'; $bdBg = '#fef3c7'; $bdIcon = 'fa-circle-exclamation';   $bdLevel = 'Medium Risk'; }
        else                { $bdColor = '#15803d'; $bdBg = '#dcfce7'; $bdIcon = 'fa-shield-check';          $bdLevel = 'Low Risk';    }
    }
@endphp

@if ($bdChecked && $bdTotal > 0)

    {{-- ── Risk badge ── --}}
    <div style="display:inline-flex;align-items:center;gap:5px;padding:3px 9px;border-radius:4px;
                font-size:11px;font-weight:700;background:{{ $bdBg }};color:{{ $bdColor }};margin-bottom:6px;">
        <i class="fas {{ $bdIcon }}"></i>
        {{ $bdLevel }}
        <span style="font-weight:400;opacity:.8;">{{ number_format($bdr, 1) }}%</span>
    </div>

    {{-- ── Summary row ── --}}
    <div style="display:flex;gap:10px;margin-bottom:6px;">
        <div style="text-align:center;">
            <div style="font-size:14px;font-weight:700;color:#1d2327;">{{ number_format($bdTotal) }}</div>
            <div style="font-size:9.5px;color:#50575e;">Total</div>
        </div>
        <div style="text-align:center;">
            <div style="font-size:14px;font-weight:700;color:{{ $cancelled > 0 ? '#b91c1c' : '#94a3b8' }};">{{ number_format($cancelled) }}</div>
            <div style="font-size:9.5px;color:#50575e;">Cancelled</div>
        </div>
        <div style="text-align:center;">
            <div style="font-size:14px;font-weight:700;color:{{ $bdReport > 0 ? '#b91c1c' : '#94a3b8' }};">{{ $bdReport }}</div>
            <div style="font-size:9.5px;color:#50575e;">Fraud</div>
        </div>
    </div>

    {{-- ── Per-courier breakdown ── --}}
    @if(count($couriers) > 0)
    <div style="margin-bottom:6px;">
        @foreach($couriers as $c)
        @php
            $cRatio = (float) ($c['ratio'] ?? 0);
            $cColor = $cRatio < 60 ? '#b91c1c' : ($cRatio < 80 ? '#b45309' : '#15803d');
        @endphp
        <div style="display:flex;align-items:center;gap:5px;margin-bottom:3px;">
            <span style="font-size:10px;color:#50575e;width:68px;truncate;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"
                  title="{{ $c['name'] ?? '' }}">{{ $c['name'] ?? '' }}</span>
            <div style="flex:1;height:5px;background:#e5e7eb;border-radius:3px;overflow:hidden;min-width:40px;">
                <div style="width:{{ min(100,$cRatio) }}%;height:100%;background:{{ $cColor }};border-radius:3px;"></div>
            </div>
            <span style="font-size:10px;font-weight:700;color:{{ $cColor }};width:36px;text-align:right;">{{ number_format($cRatio,0) }}%</span>
        </div>
        @endforeach
    </div>
    @endif

    {{-- ── Fraud reports ── --}}
    @if($bdReport > 0)
    <div style="margin-top:4px;">
        <div style="font-size:10px;font-weight:700;color:#b91c1c;margin-bottom:3px;">
            <i class="fas fa-flag mr-0.5"></i> {{ $bdReport }} Fraud Report{{ $bdReport > 1 ? 's' : '' }}
        </div>
        @foreach(array_slice($repList, 0, 2) as $rep)
        <div style="padding:4px 6px;background:#fff5f5;border:1px solid #fecaca;border-radius:4px;margin-bottom:3px;font-size:10.5px;">
            <div style="font-weight:600;color:#b91c1c;">{{ $rep['name'] ?? 'Unknown' }}</div>
            @if(!empty($rep['remark']))
            <div style="color:#7f1d1d;margin-top:1px;">{{ Str::limit($rep['remark'], 60) }}</div>
            @endif
            @if(!empty($rep['merchant']))
            <div style="color:#9a3412;font-size:10px;margin-top:1px;">by {{ $rep['merchant'] }}</div>
            @endif
        </div>
        @endforeach
        @if(count($repList) > 2)
        <div style="font-size:10px;color:#b91c1c;">+{{ count($repList) - 2 }} more report(s)</div>
        @endif
    </div>
    @endif

    {{-- Re-check link --}}
    <div style="margin-top:5px;">
        <button type="button" onclick="bdCheckCell(this.closest('.bd-risk-cell'))"
                style="font-size:10px;color:#2271b1;background:none;border:0;cursor:pointer;padding:0;">
            <i class="fas fa-rotate-right"></i> Re-check
        </button>
    </div>

@elseif ($bdChecked && $bdTotal === 0)
    <div style="font-size:11px;color:#94a3b8;">
        <i class="fas fa-minus-circle mr-0.5"></i> No BD history
    </div>

@else
    <span class="bd-checking-spinner" style="font-size:10.5px;color:#94a3b8;">
        <i class="fas fa-circle-notch fa-spin mr-0.5"></i> Checking…
    </span>
@endif
