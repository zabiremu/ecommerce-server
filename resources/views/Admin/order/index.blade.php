@extends('Admin.Layout.app')

@section('title', 'Orders')
@section('page_title', 'Orders')

@push('styles')
<style>
    body.font-sans { background: #f0f0f1 !important; }
    main { background: #f0f0f1 !important; }

    /* ── Table base ── */
    .ord-table { width: 100%; border-collapse: collapse; background: #fff; }
    .ord-table thead th {
        padding: 10px 10px; font-size: 12px; font-weight: 700;
        color: #50575e; background: #f6f7f7;
        border-bottom: 1px solid #c3c4c7; text-align: left;
        white-space: nowrap;
    }
    .ord-table tbody td {
        padding: 10px 10px; font-size: 13px; color: #2c3338;
        border-bottom: 1px solid #f0f0f1; vertical-align: top;
    }
    .ord-table tbody tr:hover { background: #fafafa; }

    /* ── Status pills ── */
    .s-pill {
        display: inline-block; padding: 3px 10px; border-radius: 12px;
        font-size: 11px; font-weight: 700; text-transform: uppercase; white-space: nowrap;
    }
    .s-pending    { background:#fef3c7; color:#92400e; }
    .s-confirmed  { background:#dbeafe; color:#1d4ed8; }
    .s-processing { background:#e0e7ff; color:#3730a3; }
    .s-shipped    { background:#cffafe; color:#0e7490; }
    .s-delivered  { background:#d1fae5; color:#047857; }
    .s-cancelled  { background:#fee2e2; color:#b91c1c; }
    .s-returned   { background:#e5e7eb; color:#374151; }

    /* ── Status filter tabs ── */
    .status-tabs { display:flex; flex-wrap:wrap; gap:5px; margin-bottom:0; }
    .status-tab {
        padding: 4px 12px; border-radius: 14px; font-size: 12px; font-weight: 600;
        border: 1px solid transparent; cursor: pointer; text-decoration: none;
        transition: all .15s; color: #50575e; background: #f0f0f1;
    }
    .status-tab:hover  { background: #e0e0e0; color: #1d2327; }
    .status-tab.active { background: #1d2327; color: #fff; border-color: #1d2327; }
    .status-tab.t-pending    { background:#fef3c7; color:#92400e; border-color:#fde68a; }
    .status-tab.t-pending.active    { background:#92400e; color:#fff; }
    .status-tab.t-confirmed  { background:#dbeafe; color:#1d4ed8; border-color:#bfdbfe; }
    .status-tab.t-confirmed.active  { background:#1d4ed8; color:#fff; }
    .status-tab.t-processing { background:#e0e7ff; color:#3730a3; border-color:#c7d2fe; }
    .status-tab.t-processing.active { background:#3730a3; color:#fff; }
    .status-tab.t-shipped    { background:#cffafe; color:#0e7490; border-color:#a5f3fc; }
    .status-tab.t-shipped.active    { background:#0e7490; color:#fff; }
    .status-tab.t-delivered  { background:#d1fae5; color:#047857; border-color:#a7f3d0; }
    .status-tab.t-delivered.active  { background:#047857; color:#fff; }
    .status-tab.t-cancelled  { background:#fee2e2; color:#b91c1c; border-color:#fecaca; }
    .status-tab.t-cancelled.active  { background:#b91c1c; color:#fff; }
    .status-tab.t-returned   { background:#e5e7eb; color:#374151; border-color:#d1d5db; }
    .status-tab.t-returned.active   { background:#374151; color:#fff; }

    /* ── Inline status select ── */
    .inline-status-select {
        padding: 4px 6px; font-size: 12px; border-radius: 6px; border: 1px solid #c3c4c7;
        background: #fff; cursor: pointer; outline: none; max-width: 130px; width: 100%;
        font-weight: 600;
    }
    .inline-status-select:focus { border-color: #2271b1; box-shadow: 0 0 0 1px #2271b1; }

    /* ── Product thumb ── */
    .prod-thumb { width:44px; height:44px; object-fit:cover; border-radius:6px; border:1px solid #e0e0e0; flex-shrink:0; background:#f6f7f7; }

    /* ── Misc ── */
    .wp-input { padding:6px 10px; font-size:13px; border:1px solid #8c8f94; border-radius:4px; background:#fff; outline:none; }
    .wp-input:focus { border-color:#2271b1; box-shadow:0 0 0 1px #2271b1; }
    .wp-btn { padding:5px 12px; font-size:13px; font-weight:500; border-radius:4px; cursor:pointer; border:1px solid #c3c4c7; background:#f6f7f7; color:#2c3338; line-height:1.5; }
    .wp-btn:hover { background:#e0e0e0; }
    .wp-btn-primary { background:#5E2590; color:#fff; border-color:#5E2590; }
    .wp-btn-primary:hover { background:#4a1d73; border-color:#4a1d73; }
    .risk-pill { display:inline-flex; align-items:center; gap:3px; padding:2px 7px; font-size:10px; font-weight:700; border-radius:3px; }

    .sf-badge { font-size:10.5px; font-family:monospace; padding:2px 6px; border-radius:3px; background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
</style>
@endpush

@section('content')

@if (session('success'))
    <div class="mb-3 px-4 py-2.5 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="mb-3 px-4 py-2.5 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">{{ session('error') }}</div>
@endif

{{-- ── Header ── --}}
<div class="flex items-center justify-between mb-4 flex-wrap gap-2">
    <h1 class="text-[22px] font-semibold text-[#1d2327] m-0">All Orders</h1>
    <!-- <div class="flex items-center gap-2">
        <a href="{{ route('admin.orders.index') }}" class="wp-btn wp-btn-primary">
            <i class="fas fa-plus mr-1.5 text-[11px]"></i> New Order
        </a>
    </div> -->
</div>

{{-- ── Filter / Search bar ── --}}
<form method="GET" action="{{ route('admin.orders.index') }}" id="filterForm">
<div class="bg-white border border-[#c3c4c7] rounded-md px-4 py-3 mb-3 flex flex-wrap items-center justify-between gap-3">

    {{-- Per page --}}
    <div class="flex items-center gap-2 text-[13px] text-[#50575e]">
        <span>Show</span>
        <select name="per_page" class="wp-input py-1" onchange="this.form.submit()" style="width:70px">
            @foreach([25,50,100] as $pp)
                <option value="{{ $pp }}" @selected($perPage === $pp)>{{ $pp }}</option>
            @endforeach
        </select>
        <span>entries</span>
    </div>

    {{-- Status tabs ── --}}
    <div class="status-tabs">
        @php
            $tabs = [
                ['key'=>'pending',    'label'=>'PENDING'],
                ['key'=>'confirmed',  'label'=>'CONFIRMED'],
                ['key'=>'processing', 'label'=>'PROCESSING'],
                ['key'=>'shipped',    'label'=>'SHIPPED'],
                ['key'=>'delivered',  'label'=>'DELIVERED'],
                ['key'=>'cancelled',  'label'=>'CANCELLED'],
                ['key'=>'returned',   'label'=>'RETURNED'],
                ['key'=>'all',        'label'=>'All'],
            ];
        @endphp
        @foreach($tabs as $tab)
        <a href="{{ route('admin.orders.index', array_filter(['status' => $tab['key'] === 'all' ? null : $tab['key'], 's' => $search ?: null, 'per_page' => $perPage !== 25 ? $perPage : null])) }}"
           class="status-tab {{ $status === $tab['key'] ? 'active' : '' }} {{ $tab['key'] !== 'all' ? 't-'.$tab['key'] : '' }}">
            {{ $tab['label'] }}
            <span class="ml-1 text-[10px] font-normal opacity-75">({{ $counts[$tab['key']] ?? $counts['all'] }})</span>
        </a>
        @endforeach
    </div>

    {{-- Search --}}
    <div class="flex items-center gap-2">
        <input type="hidden" name="status" value="{{ $status !== 'all' ? $status : '' }}">
        <input type="search" name="s" value="{{ $search }}"
               placeholder="Search…"
               class="wp-input" style="width:200px">
        <button type="submit" class="wp-btn"><i class="fas fa-search text-[11px]"></i></button>
    </div>
</div>
</form>

{{-- ── Bulk + extras bar ── --}}
<div class="flex items-center gap-2 mb-2 flex-wrap">
    <select id="bulkAction" class="wp-input">
        <option value="">Bulk actions</option>
        <option value="confirmed">Mark Confirmed</option>
        <option value="processing">Mark Processing</option>
        <option value="shipped">Mark Shipped</option>
        <option value="delivered">Mark Delivered</option>
        <option value="cancelled">Mark Cancelled</option>
        <option value="delete">Delete Permanently</option>
    </select>
    <button type="button" id="applyBulk" class="wp-btn">Apply</button>

    <form method="GET" action="{{ route('admin.orders.index') }}" class="flex items-center gap-2" style="margin-left:auto">
        <input type="hidden" name="status" value="{{ $status !== 'all' ? $status : '' }}">
        <input type="hidden" name="s" value="{{ $search }}">
        <select name="payment_status" class="wp-input" onchange="this.form.submit()">
            <option value="">All payments</option>
            <option value="unpaid"   @selected($payment === 'unpaid')>Unpaid</option>
            <option value="paid"     @selected($payment === 'paid')>Paid</option>
            <option value="refunded" @selected($payment === 'refunded')>Refunded</option>
        </select>
    </form>
</div>

{{-- ── Table ── --}}
<div style="overflow-x:auto;-webkit-overflow-scrolling:touch;background:#fff;border:1px solid #c3c4c7;border-radius:4px;">
<table class="ord-table">
    <thead>
        <tr>
            <th style="width:32px"><input type="checkbox" id="selectAll"></th>
            <th style="width:75px">ID</th>
            <th>Customer</th>
            <th>Products</th>
            <th style="width:90px">Amount</th>
            <th style="width:130px">Status</th>
            <th style="width:150px">
                <span style="display:flex;align-items:center;gap:5px;">
                    <i class="fas fa-shield-halved text-[11px]" style="color:#b91c1c"></i> Fraud Check
                    @if(\App\Services\BdCourierFraudService::isEnabled())
                        <span style="font-size:9px;font-weight:700;padding:1px 5px;border-radius:3px;background:#dcfce7;color:#15803d;border:1px solid #bbf7d0;">ON</span>
                    @else
                        <span style="font-size:9px;font-weight:700;padding:1px 5px;border-radius:3px;background:#fee2e2;color:#b91c1c;border:1px solid #fecaca;">OFF</span>
                    @endif
                </span>
            </th>
            <th style="width:130px">Courier</th>
            <th style="width:90px">Date</th>
        </tr>
    </thead>
    <tbody>
    @forelse ($orders as $o)
    @php
        $bdChecked = !is_null($o->bdcourier_total_parcels);
        $bdReport  = (int) ($o->bdcourier_fraud_reports ?? 0);
        $bdr       = $o->bdcourier_success_ratio;
    @endphp
    <tr id="order-row-{{ $o->id }}">

        {{-- Checkbox --}}
        <td><input type="checkbox" class="orderCheckbox" value="{{ $o->id }}"></td>

        {{-- ID + actions --}}
        <td>
            <div class="flex items-center gap-1.5">
                <a href="{{ route('admin.orders.show', $o) }}"
                   style="font-size:11px;color:#50575e;line-height:1;padding:3px 5px;border:1px solid #c3c4c7;border-radius:4px;background:#f6f7f7;"
                   title="View order">
                    <i class="fas fa-eye text-[10px]"></i>
                </a>
                <span class="font-mono text-[12px] text-[#1d2327] font-semibold">{{ $o->id }}</span>
            </div>
            <div class="text-[11px] text-[#50575e] mt-1 font-mono">#{{ $o->order_no }}</div>
        </td>

        {{-- Customer --}}
        <td>
            <div class="font-semibold text-[13px] text-[#1d2327]">{{ $o->shipping_name }}</div>
            <div class="text-[12px] text-[#2271b1] mt-0.5">{{ $o->shipping_phone }}</div>
            @if($o->shipping_city)
            <div class="text-[11.5px] text-[#646970] mt-0.5">
                {{ $o->shipping_city }}{{ $o->shipping_area ? ', '.$o->shipping_area : '' }}
            </div>
            @endif
        </td>

        {{-- Products --}}
        <td>
            @foreach($o->items->take(2) as $item)
            <div class="flex items-start gap-2 {{ !$loop->first ? 'mt-2' : '' }}">
                @if($item->thumbnail)
                    <img src="{{ Storage::url($item->thumbnail) }}" alt="" class="prod-thumb">
                @else
                    <div class="prod-thumb flex items-center justify-center">
                        <i class="fas fa-box text-[#c3c4c7] text-[14px]"></i>
                    </div>
                @endif
                <div class="min-w-0">
                    <div class="text-[12px] font-medium text-[#1d2327] leading-tight" style="max-width:140px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $item->product_name }}</div>
                    <div class="text-[11px] text-[#50575e]">{{ rtrim(rtrim(number_format((float)$item->quantity,2,'.',''  ),'0'),'.') }} × ৳{{ number_format((float)$item->unit_price) }}</div>
                </div>
            </div>
            @endforeach
            @if($o->items->count() > 2)
                <div class="text-[11px] text-[#50575e] mt-1">+{{ $o->items->count()-2 }} more item(s)</div>
            @endif
        </td>

        {{-- Amount --}}
        <td>
            <div class="font-bold text-[14px] text-[#1d2327]">৳{{ number_format((float)$o->total) }}</div>
            <div class="text-[11px] mt-0.5">
                @php
                    $pmColors = ['cod'=>['#fffbeb','#92400e'],'bkash'=>['#fdf2f8','#9d174d'],'nagad'=>['#fff7ed','#9a3412'],'rocket'=>['#f5f3ff','#5b21b6'],'uddoktapay'=>['#eff6ff','#1e40af'],'bank'=>['#f0fdf4','#14532d']];
                    [$pmBg,$pmFg] = $pmColors[$o->payment_method] ?? ['#f3f4f6','#374151'];
                @endphp
                <span style="padding:1px 6px;border-radius:3px;font-size:10.5px;font-weight:700;background:{{ $pmBg }};color:{{ $pmFg }};text-transform:uppercase">{{ $o->payment_method }}</span>
            </div>
            <div class="mt-0.5">
                @php $psColor = $o->payment_status === 'paid' ? ['#dcfce7','#15803d'] : ($o->payment_status === 'refunded' ? ['#f3e8ff','#7e22ce'] : ['#fff7ed','#9a3412']); @endphp
                <span style="padding:1px 6px;border-radius:3px;font-size:10.5px;font-weight:700;background:{{ $psColor[0] }};color:{{ $psColor[1] }}">{{ strtoupper($o->payment_status) }}</span>
            </div>
        </td>

        {{-- Status inline dropdown --}}
        <td>
            <select class="inline-status-select"
                    data-order-id="{{ $o->id }}"
                    data-url="{{ route('admin.orders.status', $o) }}"
                    onchange="inlineStatusUpdate(this)">
                @foreach(App\Models\Order::STATUSES as $s)
                    <option value="{{ $s }}" @selected($o->status === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <div id="status-msg-{{ $o->id }}" style="font-size:10.5px;margin-top:3px;display:none;"></div>
        </td>

        {{-- Fraud Check column --}}
        <td class="bd-risk-cell"
            data-order-id="{{ $o->id }}"
            data-check-url="{{ route('admin.orders.bdcourier-check', $o) }}"
            data-bd-checked="{{ $bdChecked ? '1' : '0' }}">
            @include('Admin.order._bd_risk_cell', [
                'bdr'       => $bdr,
                'bdChecked' => $bdChecked,
                'bdTotal'   => (int) ($o->bdcourier_total_parcels ?? 0),
                'bdReport'  => $bdReport,
                'order'     => $o,
            ])
        </td>

        {{-- Courier --}}
        <td>
            @if($o->isSentToSteadfast())
                <div class="sf-badge mb-1">{{ $o->steadfast_tracking_code }}</div>
                @if($o->steadfast_status)
                    <div style="font-size:11px;font-weight:600;" class="{{ App\Models\Order::steadfastStatusBadge($o->steadfast_status) }} px-1.5 py-0.5 rounded-sm inline-block">
                        {{ str_replace('_',' ',$o->steadfast_status) }}
                    </div>
                @endif
            @else
                <button type="button"
                    class="sf-quick-send wp-btn text-[11px] px-2 py-1"
                    style="color:#1a6b1a;border-color:#bbf7d0;background:#f0fdf4"
                    data-url="{{ route('admin.steadfast.send', $o) }}"
                    data-row="{{ $o->id }}">
                    <i class="fas fa-truck-fast text-[10px]"></i> Steadfast
                </button>
            @endif
        </td>

        {{-- Date --}}
        <td>
            <div class="text-[12.5px] font-medium text-[#1d2327]">{{ ($o->placed_at ?? $o->created_at)->format('d M Y') }}</div>
            <div class="text-[11px] text-[#50575e]">{{ ($o->placed_at ?? $o->created_at)->format('h:i A') }}</div>
            {{-- Delete --}}
            <div class="mt-2">
                <form method="POST" action="{{ route('admin.orders.destroy', $o) }}" style="display:inline"
                      onsubmit="return confirm('Delete order #{{ $o->order_no }}?')">
                    @csrf @method('DELETE')
                    <button type="submit" style="font-size:10.5px;color:#b32d2e;background:none;border:0;cursor:pointer;padding:0">
                        <i class="fas fa-trash-alt text-[10px]"></i> Delete
                    </button>
                </form>
            </div>
        </td>

    </tr>
    @empty
    <tr>
        <td colspan="9" class="text-center text-[#646970] py-10">
            <i class="fas fa-inbox text-3xl text-[#c3c4c7] block mb-2"></i>
            No orders found.
        </td>
    </tr>
    @endforelse
    </tbody>
</table>
</div>

{{-- ── Pagination + info ── --}}
<div class="flex items-center justify-between mt-3 flex-wrap gap-2">
    <div class="text-[13px] text-[#50575e]">
        Showing {{ $orders->firstItem() ?? 0 }}–{{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} entries
    </div>
    <div>{{ $orders->links() }}</div>
</div>

{{-- Hidden bulk form --}}
<form method="POST" action="{{ route('admin.orders.bulk-action') }}" id="bulkForm" style="display:none">
    @csrf
    <input type="hidden" name="action" id="bulkActionInput">
    <div id="bulkIdsContainer"></div>
</form>

@endsection

@push('scripts')
<script>
// ── Select all checkboxes ──────────────────────────────────────────
document.getElementById('selectAll').addEventListener('change', function () {
    document.querySelectorAll('.orderCheckbox').forEach(cb => cb.checked = this.checked);
});

document.getElementById('applyBulk').addEventListener('click', function () {
    const action = document.getElementById('bulkAction').value;
    if (!action) { alert('Select an action.'); return; }
    const ids = Array.from(document.querySelectorAll('.orderCheckbox:checked')).map(cb => cb.value);
    if (!ids.length) { alert('Select at least one order.'); return; }
    if (action === 'delete' && !confirm('Delete ' + ids.length + ' order(s)? Stock will be restored.')) return;

    const form = document.getElementById('bulkForm');
    document.getElementById('bulkActionInput').value = action;
    const c = document.getElementById('bulkIdsContainer');
    c.innerHTML = '';
    ids.forEach(id => {
        const inp = document.createElement('input');
        inp.type = 'hidden'; inp.name = 'ids[]'; inp.value = id;
        c.appendChild(inp);
    });
    form.submit();
});

// ── Inline status update ──────────────────────────────────────────
const statusColors = {
    pending:    '#d97706', confirmed: '#1d4ed8', processing: '#3730a3',
    shipped:    '#0e7490', delivered: '#047857', cancelled:  '#b91c1c',
    returned:   '#374151'
};

async function inlineStatusUpdate(sel) {
    const orderId = sel.dataset.orderId;
    const url     = sel.dataset.url;
    const status  = sel.value;
    const msgEl   = document.getElementById('status-msg-' + orderId);

    sel.disabled = true;
    msgEl.style.display = 'none';

    try {
        const res = await fetch(url, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ status }),
        });

        if (res.ok) {
            msgEl.textContent = '✓ Saved';
            msgEl.style.display = 'block';
            msgEl.style.color = '#15803d';
            sel.style.borderColor = statusColors[status] || '#c3c4c7';
            setTimeout(() => { msgEl.style.display = 'none'; }, 2500);
        } else {
            const data = await res.json().catch(() => ({}));
            msgEl.textContent = '✗ ' + (data.message || 'Error');
            msgEl.style.display = 'block';
            msgEl.style.color = '#b91c1c';
        }
    } catch (e) {
        msgEl.textContent = '✗ Network error';
        msgEl.style.display = 'block';
        msgEl.style.color = '#b91c1c';
    }

    sel.disabled = false;
}

// ── BD Courier risk renderer ──────────────────────────────────────
function bdRenderCell(cell, d) {
    if (!d.ok) {
        cell.innerHTML = '<span style="font-size:10.5px;color:#94a3b8;"><i class="fas fa-circle-xmark mr-0.5"></i> Check failed</span>';
        return;
    }
    if (!d.found) {
        cell.innerHTML = '<span style="font-size:10.5px;color:#94a3b8;"><i class="fas fa-minus-circle mr-0.5"></i> No BD history</span>';
        return;
    }

    const data     = d.data;
    const ratio    = parseFloat(data.success_ratio);
    const total    = parseInt(data.total_parcels);
    const cancelled= parseInt(data.cancelled || 0);
    const reports  = parseInt(data.fraud_reports);
    const couriers = data.couriers || [];
    const repList  = data.reports  || [];

    let color, bg, icon, level;
    if (ratio < 60)      { color='#b91c1c'; bg='#fee2e2'; icon='fa-triangle-exclamation'; level='High Risk'; }
    else if (ratio < 80) { color='#b45309'; bg='#fef3c7'; icon='fa-circle-exclamation';   level='Medium Risk'; }
    else                 { color='#15803d'; bg='#dcfce7'; icon='fa-shield-check';          level='Low Risk'; }

    // Badge
    let html = `<div style="display:inline-flex;align-items:center;gap:5px;padding:3px 9px;border-radius:4px;font-size:11px;font-weight:700;background:${bg};color:${color};margin-bottom:6px;">
        <i class="fas ${icon}"></i> ${level} <span style="font-weight:400;opacity:.8">${ratio.toFixed(1)}%</span>
    </div>`;

    // Summary
    html += `<div style="display:flex;gap:10px;margin-bottom:6px;">
        <div style="text-align:center"><div style="font-size:14px;font-weight:700;color:#1d2327">${total}</div><div style="font-size:9.5px;color:#50575e">Total</div></div>
        <div style="text-align:center"><div style="font-size:14px;font-weight:700;color:${cancelled>0?'#b91c1c':'#94a3b8'}">${cancelled}</div><div style="font-size:9.5px;color:#50575e">Cancelled</div></div>
        <div style="text-align:center"><div style="font-size:14px;font-weight:700;color:${reports>0?'#b91c1c':'#94a3b8'}">${reports}</div><div style="font-size:9.5px;color:#50575e">Fraud</div></div>
    </div>`;

    // Per-courier bars
    if (couriers.length > 0) {
        html += '<div style="margin-bottom:6px;">';
        couriers.forEach(c => {
            const cRatio = parseFloat(c.ratio || 0);
            const cColor = cRatio < 60 ? '#b91c1c' : (cRatio < 80 ? '#b45309' : '#15803d');
            html += `<div style="display:flex;align-items:center;gap:5px;margin-bottom:3px;">
                <span style="font-size:10px;color:#50575e;width:68px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="${c.name}">${c.name}</span>
                <div style="flex:1;height:5px;background:#e5e7eb;border-radius:3px;overflow:hidden;min-width:40px;">
                    <div style="width:${Math.min(100,cRatio)}%;height:100%;background:${cColor};border-radius:3px;"></div>
                </div>
                <span style="font-size:10px;font-weight:700;color:${cColor};width:36px;text-align:right;">${Math.round(cRatio)}%</span>
            </div>`;
        });
        html += '</div>';
    }

    // Fraud reports
    if (reports > 0 && repList.length > 0) {
        html += `<div style="font-size:10px;font-weight:700;color:#b91c1c;margin-bottom:3px;"><i class="fas fa-flag mr-0.5"></i> ${reports} Fraud Report${reports>1?'s':''}</div>`;
        repList.slice(0,2).forEach(r => {
            html += `<div style="padding:4px 6px;background:#fff5f5;border:1px solid #fecaca;border-radius:4px;margin-bottom:3px;font-size:10.5px;">
                <div style="font-weight:600;color:#b91c1c;">${r.name||'Unknown'}</div>
                ${r.remark ? `<div style="color:#7f1d1d;margin-top:1px;">${r.remark.substring(0,60)}${r.remark.length>60?'…':''}</div>` : ''}
                ${r.merchant ? `<div style="color:#9a3412;font-size:10px;margin-top:1px;">by ${r.merchant}</div>` : ''}
            </div>`;
        });
        if (repList.length > 2) html += `<div style="font-size:10px;color:#b91c1c;">+${repList.length-2} more</div>`;
    }

    // Re-check button
    html += `<div style="margin-top:5px;"><button type="button" onclick="bdCheckCell(this.closest('.bd-risk-cell'))"
        style="font-size:10px;color:#2271b1;background:none;border:0;cursor:pointer;padding:0;">
        <i class="fas fa-rotate-right"></i> Re-check</button></div>`;

    cell.innerHTML = html;
}

function bdCheckCell(cell) {
    return fetch(cell.dataset.checkUrl, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    }).then(r => r.json()).then(d => bdRenderCell(cell, d))
      .catch(() => { cell.innerHTML = ''; });
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.bd-risk-cell[data-bd-checked="0"]').forEach(cell => bdCheckCell(cell));
});

// ── Steadfast quick-send ──────────────────────────────────────────
document.querySelectorAll('.sf-quick-send').forEach(btn => {
    btn.addEventListener('click', function () {
        const url = this.dataset.url;
        const orig = this.innerHTML;
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i>';
        const self = this;

        fetch(url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(d => {
            if (d.ok) {
                self.outerHTML = `<div><span class="sf-badge">${d.tracking_code || 'Sent'}</span></div>`;
            } else {
                alert(d.message || 'Failed.');
                self.disabled = false;
                self.innerHTML = orig;
            }
        })
        .catch(() => { alert('Network error.'); self.disabled = false; self.innerHTML = orig; });
    });
});
</script>
@endpush
