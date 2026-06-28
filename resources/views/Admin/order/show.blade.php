@extends('Admin.Layout.app')

@section('title', 'Order #' . $order->order_no)
@section('page_title', 'Order #' . $order->order_no)

@push('styles')
@include('Admin._partials.wp-styles')
<style>
    .order-status-pill { display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; font-size: 12px; font-weight: 600; border-radius: 12px; text-transform: capitalize; }
    .info-grid { display: grid; grid-template-columns: 110px 1fr; gap: 6px 12px; font-size: 13px; }
    .info-grid .lbl { color: #50575e; }
    .info-grid .val { color: #1d2327; font-weight: 500; }
    .product-thumb { width: 40px; height: 40px; object-fit: cover; border-radius: 4px; background: #f0f0f1; border: 1px solid #e0e0e0; }
</style>
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif

<div class="flex items-center gap-3 mb-3 flex-wrap">
    <h1 class="wp-h1">Order <span class="font-mono text-[#50575e] text-[18px]">#{{ $order->order_no }}</span></h1>
    @php
        $sMap = [
            'pending' => ['#fff4e5', '#d97706'],
            'confirmed' => ['#dbeafe', '#1d4ed8'],
            'processing' => ['#e0e7ff', '#3730a3'],
            'shipped' => ['#cffafe', '#0e7490'],
            'delivered' => ['#d1fae5', '#047857'],
            'cancelled' => ['#fee2e2', '#b91c1c'],
            'returned' => ['#e5e7eb', '#374151'],
        ];
        [$bg, $fg] = $sMap[$order->status] ?? ['#f3f4f6', '#374151'];
    @endphp
    <span class="order-status-pill" style="background: {{ $bg }}; color: {{ $fg }};">{{ $order->status }}</span>
    <a href="{{ route('admin.orders.index') }}" class="wp-add-new ml-auto">← Back to orders</a>
</div>

<p class="text-[13px] text-[#50575e] mb-4">
    Placed on <strong>{{ ($order->placed_at ?? $order->created_at)->format('d M, Y \a\t h:i A') }}</strong>
    @if ($order->customer)
        by <a href="{{ route('admin.customers.show', $order->customer) }}" class="text-[#2271b1]">{{ $order->customer->name }}</a>
    @endif
</p>

<div class="grid grid-cols-12 gap-5">
    <div class="col-span-12 lg:col-span-8 space-y-5">

        <!-- Items -->
        <div class="wp-panel">
            <div class="wp-panel-h">Items</div>
            <div class="wp-panel-body" style="padding: 0;">
                <table class="wp-list-table" style="border: 0; box-shadow: none;">
                    <thead>
                        <tr>
                            <th style="width:50px"></th>
                            <th>Product</th>
                            <th class="text-right" style="width:90px">Cost</th>
                            <th class="text-right" style="width:70px">Qty</th>
                            <th class="text-right" style="width:110px">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>
                                    @if ($item->thumbnail)
                                        <img src="{{ asset($item->thumbnail) }}" class="product-thumb">
                                    @else
                                        <div class="product-thumb"></div>
                                    @endif
                                </td>
                                <td>
                                    <strong>
                                        @if ($item->product)
                                            <a href="{{ route('admin.products.edit', $item->product) }}" class="text-[#2271b1]">{{ $item->product_name }}</a>
                                        @else
                                            {{ $item->product_name }}
                                        @endif
                                    </strong>
                                    @if ($item->product_sku)
                                        <div class="text-[12px] text-[#50575e]">SKU: <span class="font-mono">{{ $item->product_sku }}</span></div>
                                    @endif
                                    @if ($item->variant_label)
                                        <div class="text-[12px] text-[#50575e]">Option: <strong>{{ $item->variant_label }}</strong>@if($item->variant_sku) (<span class="font-mono">{{ $item->variant_sku }}</span>)@endif</div>
                                    @endif
                                </td>
                                <td class="text-right">৳ {{ number_format($item->unit_price, 2) }}</td>
                                <td class="text-right">× {{ rtrim(rtrim(number_format($item->quantity, 2, '.', ''), '0'), '.') }}</td>
                                <td class="text-right"><strong>৳ {{ number_format($item->total, 2) }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right text-[#50575e]">Subtotal</td>
                            <td class="text-right">৳ {{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right text-[#50575e]">Shipping</td>
                            <td class="text-right">৳ {{ number_format($order->shipping_charge, 2) }}</td>
                        </tr>
                        @if ($order->discount > 0)
                            <tr>
                                <td colspan="4" class="text-right text-[#50575e]">Discount</td>
                                <td class="text-right text-emerald-700">-৳ {{ number_format($order->discount, 2) }}</td>
                            </tr>
                        @endif
                        <tr style="border-top: 2px solid #c3c4c7;">
                            <td colspan="4" class="text-right"><strong>Total</strong></td>
                            <td class="text-right"><strong class="text-[15px]">৳ {{ number_format($order->total, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Billing / Shipping -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="wp-panel">
                <div class="wp-panel-h">Shipping Address</div>
                <div class="wp-panel-body">
                    <strong>{{ $order->shipping_name }}</strong><br>
                    <span class="text-[13px] text-[#50575e]">
                        {{ $order->shipping_address }}<br>
                        @if ($order->shipping_area){{ $order->shipping_area }}, @endif{{ $order->shipping_city }}<br>
                        📞 {{ $order->shipping_phone }}<br>
                        @if ($order->shipping_email)✉️ {{ $order->shipping_email }}@endif
                    </span>
                </div>
            </div>
            <div class="wp-panel">
                <div class="wp-panel-h">Payment</div>
                <div class="wp-panel-body">
                    <div class="info-grid">
                        <span class="lbl">Method</span>
                        <span class="val uppercase">{{ $order->payment_method }}</span>
                        <span class="lbl">Status</span>
                        <span class="val capitalize">{{ $order->payment_status }}</span>
                    </div>
                    <form method="POST" action="{{ route('admin.orders.payment-status', $order) }}" class="mt-3">
                        @csrf @method('PATCH')
                        <label class="text-[12px] text-[#50575e]">Change payment status:</label>
                        <div class="flex items-center gap-2 mt-1">
                            <select name="payment_status" class="wp-input flex-1">
                                @foreach ($paymentStatuses as $ps)
                                    <option value="{{ $ps }}" @selected($order->payment_status === $ps)>{{ ucfirst($ps) }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="wp-btn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if ($order->notes)
            <div class="wp-panel">
                <div class="wp-panel-h">Customer Note</div>
                <div class="wp-panel-body text-[13px] text-[#50575e]">{{ $order->notes }}</div>
            </div>
        @endif

        <!-- Admin notes -->
        <div class="wp-panel">
            <div class="wp-panel-h">Admin Notes (private)</div>
            <div class="wp-panel-body">
                <form method="POST" action="{{ route('admin.orders.notes', $order) }}">
                    @csrf @method('PATCH')
                    <textarea name="admin_notes" rows="3" class="wp-input" style="width:100%;font-family:inherit" placeholder="Internal notes for this order...">{{ $order->admin_notes }}</textarea>
                    <button type="submit" class="wp-btn wp-btn-primary mt-2">Save Note</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-4 space-y-5">

        <!-- Steadfast Courier -->
        <div class="wp-panel border-l-4" id="sfPanel" style="border-color: {{ $order->isSentToSteadfast() ? '#2e7d32' : '#2271b1' }}">
            <div class="wp-panel-h flex items-center gap-2">
                <i class="fas fa-truck-fast text-[12px] text-[#50575e]"></i>
                <span>Steadfast Courier</span>
                <span id="sfSentBadge" class="ml-auto text-[10px] font-semibold px-2 py-0.5 rounded-full {{ $order->isSentToSteadfast() ? 'bg-green-100 text-green-700' : 'hidden' }}">Sent</span>
            </div>
            <div class="wp-panel-body space-y-3">

                {{-- Error / Success message --}}
                <div id="sfMsg" class="hidden text-[12.5px] px-3 py-2 rounded"></div>

                {{-- Tracking info (shown after send or if already sent) --}}
                <div id="sfTracking" class="{{ $order->isSentToSteadfast() ? '' : 'hidden' }} px-3 py-3 bg-[#f0fdf4] border border-[#bbf7d0] rounded space-y-2 text-[13px]">
                    <div class="flex items-center justify-between">
                        <span class="text-[#50575e]">Tracking Code</span>
                        <strong class="font-mono text-[14px] text-[#15803d]" id="sfTrackingCode">{{ $order->steadfast_tracking_code ?? '—' }}</strong>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[#50575e]">Consignment ID</span>
                        <span class="font-mono text-[12px]" id="sfConsignmentId">{{ $order->steadfast_consignment_id ?? '—' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[#50575e]">Status</span>
                        <span id="sfStatusBadge" class="text-[11px] font-semibold px-2 py-0.5 rounded-full {{ $order->steadfast_status ? \App\Models\Order::steadfastStatusBadge($order->steadfast_status) : 'bg-gray-100 text-gray-600' }}">
                            {{ $order->steadfast_status ? str_replace('_', ' ', $order->steadfast_status) : '—' }}
                        </span>
                    </div>
                    @if ($order->steadfast_sent_at)
                        <div class="text-[11px] text-[#787c82] pt-1 border-t border-[#e2e4e7]" id="sfSentAt">
                            Sent {{ $order->steadfast_sent_at->diffForHumans() }}
                        </div>
                    @endif
                </div>

                {{-- Pre-send info (hidden after sent) --}}
                <div id="sfPreInfo" class="{{ $order->isSentToSteadfast() ? 'hidden' : '' }} text-[12.5px] text-[#50575e] space-y-1 bg-[#f6f7f7] rounded px-3 py-2">
                    <div class="flex justify-between"><span>Recipient</span><strong class="text-[#1d2327]">{{ $order->shipping_name }}</strong></div>
                    <div class="flex justify-between"><span>Phone</span><strong class="font-mono text-[#1d2327]">{{ $order->shipping_phone }}</strong></div>
                    <div class="flex justify-between"><span>COD Amount</span><strong class="text-[#1d2327]">৳{{ number_format($order->total, 2) }}</strong></div>
                </div>

                {{-- ONE-CLICK SEND button --}}
                <button id="sfSendBtn"
                    onclick="sfSendOrder()"
                    class="{{ $order->isSentToSteadfast() ? 'hidden' : '' }} wp-btn wp-btn-primary"
                    style="width:100%; background:#1a6b1a; border-color:#1a6b1a; font-size:13px; padding:9px 12px">
                    <i class="fas fa-paper-plane mr-1.5"></i> Send to Steadfast
                </button>

                {{-- Refresh Status button (shown after sent) --}}
                <button id="sfRefreshBtn"
                    onclick="sfRefreshStatus()"
                    class="{{ $order->isSentToSteadfast() ? '' : 'hidden' }} wp-btn"
                    style="width:100%">
                    <i class="fas fa-rotate mr-1"></i> <span id="sfRefreshLabel">Refresh Status</span>
                </button>

                {{-- Balance --}}
                <div class="flex items-center justify-between text-[12px] pt-1 border-t border-[#e2e4e7]">
                    <span class="text-[#50575e]">Account Balance</span>
                    <span id="sfBalance">
                        <button type="button" onclick="loadSfBalance()" class="text-[#2271b1]">Check balance</button>
                    </span>
                </div>

            </div>
        </div>

        <!-- Risk Analysis -->
        @php
            $riskScore = (int) ($order->risk_score ?? 0);
            $riskFlags = $order->risk_flags ?? [];
            $rb        = \App\Services\OrderRiskService::badge($riskScore);
            $pa        = $phoneAnalysis;
            $cancelRate = $pa['history']['total'] > 0
                ? round(($pa['history']['cancelled'] + $pa['history']['returned']) / $pa['history']['total'] * 100)
                : 0;
        @endphp

        <!-- ─── Fake Order Chance Card ─── -->
        <div class="wp-panel border-l-4" style="border-color:{{ $pa['fg'] }}">
            <div class="wp-panel-h flex items-center gap-2">
                <i class="fas fa-user-secret text-[12px]" style="color:{{ $pa['fg'] }}"></i>
                <span>Fake Order Analysis</span>
            </div>
            <div class="wp-panel-body">

                {{-- Big score circle + chance label --}}
                <div style="display:flex;align-items:center;gap:16px;margin-bottom:16px;">
                    <div style="position:relative;width:72px;height:72px;flex-shrink:0;">
                        <svg viewBox="0 0 36 36" style="width:72px;height:72px;transform:rotate(-90deg)">
                            <circle cx="18" cy="18" r="15.9" fill="none" stroke="#e5e7eb" stroke-width="3.2"/>
                            <circle cx="18" cy="18" r="15.9" fill="none"
                                stroke="{{ $pa['fg'] }}" stroke-width="3.2"
                                stroke-dasharray="{{ $pa['fake_score'] }} {{ 100 - $pa['fake_score'] }}"
                                stroke-linecap="round"/>
                        </svg>
                        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:{{ $pa['fg'] }}">
                            {{ $pa['fake_score'] }}%
                        </div>
                    </div>
                    <div>
                        <div style="font-size:18px;font-weight:700;color:{{ $pa['fg'] }}">{{ $pa['fake_chance'] }} Chance</div>
                        <div style="font-size:12px;color:#50575e;margin-top:2px;">of being a fake order</div>
                        <div style="display:inline-flex;align-items:center;gap:5px;margin-top:6px;padding:2px 9px;border-radius:4px;font-size:11px;font-weight:600;background:{{ $pa['bg'] }};color:{{ $pa['fg'] }}">
                            @if($pa['fake_score'] >= 70) <i class="fas fa-triangle-exclamation"></i> Very High Risk
                            @elseif($pa['fake_score'] >= 45) <i class="fas fa-circle-exclamation"></i> High Risk
                            @elseif($pa['fake_score'] >= 20) <i class="fas fa-circle-info"></i> Medium Risk
                            @else <i class="fas fa-shield-check"></i> Low Risk
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Phone info row --}}
                <div style="background:#f6f7f7;border-radius:8px;padding:10px 12px;margin-bottom:12px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                        <span style="font-size:13px;font-weight:600;color:#1d2327;font-family:monospace;">{{ $order->shipping_phone }}</span>
                        <span style="font-size:11px;font-weight:600;padding:2px 7px;border-radius:4px;background:{{ $pa['is_valid'] ? '#dcfce7' : '#fee2e2' }};color:{{ $pa['is_valid'] ? '#15803d' : '#b91c1c' }}">
                            {{ $pa['is_valid'] ? '✓ Valid BD' : '✗ Invalid' }}
                        </span>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px;">
                        <span style="font-size:11px;color:#50575e;">Operator:</span>
                        <span style="font-size:11px;font-weight:600;color:{{ $pa['operator_color'] }}">{{ $pa['operator'] }}</span>
                    </div>
                </div>

                {{-- Pattern flags --}}
                @if(count($pa['flags']) > 0)
                <div style="margin-bottom:12px;">
                    <p style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.04em;color:#50575e;margin-bottom:6px;">Detection Flags</p>
                    <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:5px;">
                        @foreach($pa['flags'] as $flag)
                        <li style="display:flex;align-items:flex-start;gap:7px;font-size:12px;color:#b91c1c;line-height:1.4;">
                            <i class="fas fa-flag" style="font-size:10px;margin-top:2px;flex-shrink:0;"></i>
                            <span>{{ $flag }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @else
                <p style="font-size:12.5px;color:#15803d;margin-bottom:12px;"><i class="fas fa-check-circle"></i> No suspicious patterns detected in phone number.</p>
                @endif

                {{-- Order history stats --}}
                <div style="background:#f6f7f7;border-radius:8px;padding:10px 12px;margin-bottom:12px;">
                    <p style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.04em;color:#50575e;margin-bottom:8px;">Phone Order History</p>
                    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:6px;text-align:center;">
                        <div>
                            <div style="font-size:18px;font-weight:700;color:#1d2327;">{{ $pa['history']['total'] }}</div>
                            <div style="font-size:10px;color:#50575e;">Total</div>
                        </div>
                        <div>
                            <div style="font-size:18px;font-weight:700;color:{{ $pa['history']['delivered'] > 0 ? '#15803d' : '#94a3b8' }}">{{ $pa['history']['delivered'] }}</div>
                            <div style="font-size:10px;color:#50575e;">Delivered</div>
                        </div>
                        <div>
                            <div style="font-size:18px;font-weight:700;color:{{ $pa['history']['cancelled'] > 0 ? '#dc2626' : '#94a3b8' }}">{{ $pa['history']['cancelled'] }}</div>
                            <div style="font-size:10px;color:#50575e;">Cancelled</div>
                        </div>
                        <div>
                            <div style="font-size:18px;font-weight:700;color:{{ $pa['history']['names'] > 2 ? '#b45309' : '#94a3b8' }}">{{ $pa['history']['names'] }}</div>
                            <div style="font-size:10px;color:#50575e;">Names</div>
                        </div>
                    </div>
                    @if($pa['history']['total'] > 0)
                    <div style="margin-top:8px;padding-top:8px;border-top:1px solid #e0e0e0;">
                        <div style="display:flex;justify-content:space-between;font-size:11.5px;">
                            <span style="color:#50575e;">Cancel / Return rate</span>
                            <strong style="color:{{ $cancelRate >= 50 ? '#dc2626' : ($cancelRate >= 25 ? '#b45309' : '#15803d') }}">{{ $cancelRate }}%</strong>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Order-level risk flags (from OrderRiskService) --}}
                @if(count($riskFlags) > 0)
                <div style="margin-bottom:12px;">
                    <p style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.04em;color:#50575e;margin-bottom:6px;">Order-Level Flags</p>
                    @foreach($riskFlags as $flag)
                    <div style="font-size:12px;color:#b45309;display:flex;gap:6px;margin-bottom:4px;">
                        <i class="fas fa-circle-exclamation" style="font-size:10px;margin-top:2px;flex-shrink:0;"></i>{{ $flag }}
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Blacklist button --}}
                <form method="POST" action="{{ route('admin.phone-blacklist.block-from-order') }}"
                    onsubmit="return confirm('Blacklist {{ $order->shipping_phone }}? Future orders from this number will be blocked.')">
                    @csrf
                    <input type="hidden" name="phone" value="{{ $order->shipping_phone }}">
                    <button type="submit" class="wp-btn" style="width:100%;color:#b91c1c;border-color:#fca5a5;background:#fff5f5;font-size:12px;">
                        <i class="fas fa-ban"></i> Blacklist this phone number
                    </button>
                </form>

            </div>
        </div>

        <!-- BD Courier Fraud Check -->
        @if (!is_null($order->bdcourier_success_ratio))
        @php
            $bdr = (float) $order->bdcourier_success_ratio;
            $bdColor = $bdr >= 75 ? '#15803d' : ($bdr >= 50 ? '#b45309' : '#b91c1c');
            $bdBg    = $bdr >= 75 ? '#f0fdf4' : ($bdr >= 50 ? '#fffbeb' : '#fef2f2');
            $bdBorder = $bdr >= 75 ? '#bbf7d0' : ($bdr >= 50 ? '#fde68a' : '#fecaca');
        @endphp
        <div class="wp-panel border-l-4" style="border-color:{{ $bdColor }}">
            <div class="wp-panel-h flex items-center gap-2">
                <i class="fas fa-shield-halved text-[12px]" style="color:{{ $bdColor }}"></i>
                <span>BD Courier Check</span>
                <span class="ml-auto text-[10px] font-semibold px-2 py-0.5 rounded-full" style="background:{{ $bdBg }};color:{{ $bdColor }}">
                    {{ $bdr >= 75 ? 'Good' : ($bdr >= 50 ? 'Caution' : 'High Risk') }}
                </span>
            </div>
            <div class="wp-panel-body">
                <div style="display:flex;align-items:center;gap:14px;margin-bottom:12px;">
                    <div style="position:relative;width:60px;height:60px;flex-shrink:0;">
                        <svg viewBox="0 0 36 36" style="width:60px;height:60px;transform:rotate(-90deg)">
                            <circle cx="18" cy="18" r="15.9" fill="none" stroke="#e5e7eb" stroke-width="3.2"/>
                            <circle cx="18" cy="18" r="15.9" fill="none"
                                stroke="{{ $bdColor }}" stroke-width="3.2"
                                stroke-dasharray="{{ $bdr }} {{ 100 - $bdr }}"
                                stroke-linecap="round"/>
                        </svg>
                        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:{{ $bdColor }}">
                            {{ $bdr }}%
                        </div>
                    </div>
                    <div>
                        <div style="font-size:13px;font-weight:600;color:#1d2327;">Success Ratio</div>
                        <div style="font-size:12px;color:#50575e;margin-top:2px;">{{ $order->bdcourier_total_parcels }} total parcels</div>
                        @if ($order->bdcourier_fraud_reports > 0)
                            <div style="margin-top:5px;display:inline-flex;align-items:center;gap:4px;padding:2px 7px;border-radius:4px;background:#fee2e2;color:#b91c1c;font-size:11px;font-weight:600;">
                                <i class="fas fa-triangle-exclamation"></i> {{ $order->bdcourier_fraud_reports }} fraud report(s)
                            </div>
                        @else
                            <div style="margin-top:5px;font-size:11px;color:#15803d;"><i class="fas fa-check-circle"></i> No fraud reports</div>
                        @endif
                    </div>
                </div>
                <div style="padding:8px 12px;border-radius:6px;background:{{ $bdBg }};border:1px solid {{ $bdBorder }};font-size:12px;color:{{ $bdColor }}">
                    @if ($bdr >= 75)
                        <i class="fas fa-circle-check mr-1"></i> Delivery success rate is good across BD couriers.
                    @elseif ($bdr >= 50)
                        <i class="fas fa-circle-exclamation mr-1"></i> Moderate cancel/return rate — review carefully.
                    @else
                        <i class="fas fa-triangle-exclamation mr-1"></i> High cancel/return rate across BD couriers.
                    @endif
                </div>
            </div>
        </div>
        @elseif (\App\Services\BdCourierFraudService::isEnabled())
        <div class="wp-panel">
            <div class="wp-panel-h flex items-center gap-2">
                <i class="fas fa-shield-halved text-[12px] text-[#9ca3af]"></i>
                <span>BD Courier Check</span>
            </div>
            <div class="wp-panel-body text-[12.5px] text-[#50575e]">
                <i class="fas fa-circle-minus mr-1"></i> No BD Courier history found for this phone number.
            </div>
        </div>
        @endif

        <!-- Change Status -->
        <div class="wp-panel">
            <div class="wp-panel-h">Order Status</div>
            <div class="wp-panel-body">
                <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                    @csrf @method('PATCH')
                    <select name="status" class="wp-input" style="width:100%">
                        @foreach ($availableStatuses as $s)
                            <option value="{{ $s }}" @selected($order->status === $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="wp-btn wp-btn-primary mt-2" style="width:100%">Update Status</button>
                </form>
                @if ($order->stock_deducted)
                    <p class="text-[11.5px] text-emerald-700 mt-2"><i class="fas fa-check-circle"></i> Stock deducted from inventory</p>
                @else
                    <p class="text-[11.5px] text-[#646970] mt-2"><i class="fas fa-info-circle"></i> Stock will be deducted when confirmed/processing</p>
                @endif
            </div>
        </div>

        <!-- Summary -->
        <div class="wp-panel">
            <div class="wp-panel-h">Summary</div>
            <div class="wp-panel-body">
                <div class="info-grid">
                    <span class="lbl">Order #</span>
                    <span class="val font-mono">{{ $order->order_no }}</span>
                    <span class="lbl">Items</span>
                    <span class="val">{{ $order->items->count() }}</span>
                    <span class="lbl">Quantity</span>
                    <span class="val">{{ rtrim(rtrim(number_format((float) $order->items->sum('quantity'), 2, '.', ''), '0'), '.') }}</span>
                    <span class="lbl">Total</span>
                    <span class="val text-[16px] font-bold">৳ {{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Customer Info -->
        @if ($order->customer)
            <div class="wp-panel">
                <div class="wp-panel-h">Customer</div>
                <div class="wp-panel-body">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-400 to-purple-600 text-white flex items-center justify-center font-bold text-[14px]">
                            {{ strtoupper(substr($order->customer->name, 0, 1)) }}
                        </div>
                        <div>
                            <strong>{{ $order->customer->name }}</strong>
                            <div class="text-[12px] text-[#50575e]">{{ $order->customer->phone }}</div>
                        </div>
                    </div>
                    <div class="info-grid">
                        <span class="lbl">Total Orders</span>
                        <span class="val">{{ $order->customer->total_orders }}</span>
                        <span class="lbl">Total Spent</span>
                        <span class="val text-emerald-700">৳ {{ number_format($order->customer->total_spent, 2) }}</span>
                    </div>
                    <a href="{{ route('admin.customers.show', $order->customer) }}" class="wp-btn mt-3 block text-center">View customer →</a>
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="wp-panel">
            <div class="wp-panel-h">Actions</div>
            <div class="wp-panel-body">
                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Delete this order? Stock will be restored if it was deducted.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="wp-btn" style="width:100%;border-color:#b32d2e;color:#b32d2e">Delete Order</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const SF_CSRF    = '{{ csrf_token() }}';
const SF_SEND    = '{{ route('admin.steadfast.send', $order) }}';
const SF_STATUS  = '{{ route('admin.steadfast.check-status', $order) }}';
const SF_BALANCE = '{{ route('admin.steadfast.balance') }}';

function sfShowMsg(msg, isError) {
    const el = document.getElementById('sfMsg');
    el.className = 'text-[12.5px] px-3 py-2 rounded ' + (isError ? 'bg-red-50 text-red-700 border border-red-200' : 'bg-green-50 text-green-700 border border-green-200');
    el.textContent = msg;
    el.classList.remove('hidden');
    setTimeout(() => el.classList.add('hidden'), 6000);
}

function sfSendOrder() {
    const btn = document.getElementById('sfSendBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-1.5"></i> Sending…';

    fetch(SF_SEND, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': SF_CSRF, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(d => {
        if (!d.ok) {
            sfShowMsg(d.message || 'Failed to send.', true);
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-paper-plane mr-1.5"></i> Send to Steadfast';
            return;
        }

        // Success — update panel
        document.getElementById('sfTrackingCode').textContent  = d.tracking_code  || '—';
        document.getElementById('sfConsignmentId').textContent = d.consignment_id || '—';
        const badge = document.getElementById('sfStatusBadge');
        badge.textContent = (d.status || 'in review').replace(/_/g,' ');
        badge.className = 'text-[11px] font-semibold px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-800';

        document.getElementById('sfTracking').classList.remove('hidden');
        document.getElementById('sfPreInfo').classList.add('hidden');
        btn.classList.add('hidden');
        document.getElementById('sfRefreshBtn').classList.remove('hidden');
        document.getElementById('sfSentBadge').classList.remove('hidden');
        document.getElementById('sfPanel').style.borderColor = '#2e7d32';
        sfShowMsg('Order sent to Steadfast! Tracking: ' + d.tracking_code, false);
    })
    .catch(() => {
        sfShowMsg('Network error. Please try again.', true);
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-paper-plane mr-1.5"></i> Send to Steadfast';
    });
}

function sfRefreshStatus() {
    const btn   = document.getElementById('sfRefreshBtn');
    const label = document.getElementById('sfRefreshLabel');
    btn.disabled = true;
    label.textContent = 'Refreshing…';

    fetch(SF_STATUS, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': SF_CSRF, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(d => {
        btn.disabled = false;
        label.textContent = 'Refresh Status';
        if (!d.ok) { sfShowMsg(d.message || 'Failed.', true); return; }

        const badge = document.getElementById('sfStatusBadge');
        badge.textContent = (d.status || '').replace(/_/g,' ');
        sfShowMsg(d.message || 'Status updated.', false);
    })
    .catch(() => {
        btn.disabled = false;
        label.textContent = 'Refresh Status';
        sfShowMsg('Network error.', true);
    });
}

function loadSfBalance() {
    const el = document.getElementById('sfBalance');
    el.innerHTML = '<span class="text-[#787c82]">Loading…</span>';
    fetch(SF_BALANCE, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
    .then(r => r.json())
    .then(d => {
        el.innerHTML = d.error
            ? '<span class="text-red-600">' + d.error + '</span>'
            : '<strong>৳ ' + parseFloat(d.current_balance || 0).toLocaleString() + '</strong>';
    })
    .catch(() => { el.innerHTML = '<span class="text-red-600">Failed</span>'; });
}
</script>
@endpush
