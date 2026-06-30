@php
    $shop      = \App\Models\SiteSetting::get('company_name', 'ROVENTEX');
    $phone     = \App\Models\SiteSetting::get('contact_phone', '');
    $email     = \App\Models\SiteSetting::get('contact_email', '');
    $address   = \App\Models\SiteSetting::get('contact_address', '');
    $o         = $order;
    $firstName = explode(' ', trim($o->shipping_name))[0];
    $hasSale   = $o->discount > 0;

    $statusMap = [
        'pending'    => ['⏳', '#d97706', 'Pending — We\'ve received your order.'],
        'confirmed'  => ['✅', '#1d4ed8', 'Confirmed — Your order is confirmed.'],
        'processing' => ['⚙️', '#3730a3', 'Processing — Being prepared.'],
        'shipped'    => ['🚚', '#0e7490', 'Shipped — On the way!'],
        'delivered'  => ['🏠', '#047857', 'Delivered — Enjoy your purchase!'],
        'cancelled'  => ['❌', '#b91c1c', 'Cancelled.'],
    ];
    [$sIcon, $sColor, $sText] = $statusMap[$o->status] ?? ['📋', '#475569', ucfirst($o->status)];

    $payLabels = [
        'cod'        => 'Cash on Delivery',
        'bkash'      => 'bKash',
        'nagad'      => 'Nagad',
        'rocket'     => 'Rocket',
        'bank'       => 'Bank Transfer',
        'uddoktapay' => 'UddoktaPay (Online)',
    ];
    $payLabel = $payLabels[$o->payment_method] ?? ucfirst($o->payment_method);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Order Confirmation #{{ $o->order_no }}</title>
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:Arial,Helvetica,sans-serif;color:#1e293b">
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="padding:32px 16px">
<tr><td align="center">
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="620"
       style="max-width:620px;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,.07)">

    {{-- ── Header ── --}}
    <tr>
        <td style="background:linear-gradient(135deg,#2D1B69 0%,#5E2590 100%);padding:32px 40px">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <td>
                        <p style="margin:0 0 4px;font-size:13px;color:rgba(255,255,255,.7);text-transform:uppercase;letter-spacing:.06em">Order Confirmed</p>
                        <h1 style="margin:0;font-size:26px;font-weight:800;color:#ffffff;letter-spacing:-0.5px">
                            ✅ Thank you, {{ $firstName }}!
                        </h1>
                        <p style="margin:6px 0 0;font-size:13px;color:rgba(255,255,255,.75)">
                            Your order has been placed successfully.
                        </p>
                    </td>
                    <td align="right" valign="top" style="padding-left:20px;white-space:nowrap">
                        <p style="margin:0;font-size:11px;color:rgba(255,255,255,.6)">Order No.</p>
                        <p style="margin:4px 0 0;font-size:18px;font-weight:800;color:#ffffff;font-family:monospace">
                            #{{ $o->order_no }}
                        </p>
                        <p style="margin:4px 0 0;font-size:11px;color:rgba(255,255,255,.6)">
                            {{ ($o->placed_at ?? $o->created_at)->format('d M Y, h:i A') }}
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- ── Status pill ── --}}
    <tr>
        <td style="padding:0 40px">
            <div style="margin:20px 0;padding:12px 16px;background:#f8fafc;border-radius:8px;border-left:4px solid {{ $sColor }};font-size:14px;color:#1e293b">
                <strong>{{ $sIcon }} {{ $sText }}</strong>
            </div>
        </td>
    </tr>

    {{-- ── Order items ── --}}
    <tr>
        <td style="padding:0 40px 20px">
            <p style="margin:0 0 12px;font-size:13px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em">
                Items Ordered
            </p>
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                   style="border:1px solid #e2e8f0;border-radius:8px;overflow:hidden">
                {{-- Table head --}}
                <tr style="background:#f8fafc">
                    <th style="padding:10px 14px;text-align:left;font-size:12px;font-weight:700;color:#64748b;border-bottom:1px solid #e2e8f0">Product</th>
                    <th style="padding:10px 14px;text-align:center;font-size:12px;font-weight:700;color:#64748b;border-bottom:1px solid #e2e8f0;width:50px">Qty</th>
                    <th style="padding:10px 14px;text-align:right;font-size:12px;font-weight:700;color:#64748b;border-bottom:1px solid #e2e8f0;width:100px">Price</th>
                    <th style="padding:10px 14px;text-align:right;font-size:12px;font-weight:700;color:#64748b;border-bottom:1px solid #e2e8f0;width:100px">Total</th>
                </tr>
                {{-- Items --}}
                @foreach($o->items as $item)
                <tr style="{{ !$loop->last ? 'border-bottom:1px solid #f1f5f9' : '' }}">
                    <td style="padding:12px 14px;font-size:13px;color:#1e293b">
                        <strong>{{ $item->product_name }}</strong>
                        @if($item->product_sku)
                        <br><span style="font-size:11px;color:#94a3b8;font-family:monospace">SKU: {{ $item->product_sku }}</span>
                        @endif
                    </td>
                    <td style="padding:12px 14px;text-align:center;font-size:13px;color:#475569">
                        × {{ rtrim(rtrim(number_format((float)$item->quantity, 2, '.', ''), '0'), '.') }}
                    </td>
                    <td style="padding:12px 14px;text-align:right;font-size:13px;color:#475569">
                        TK {{ number_format((float)$item->unit_price) }}
                    </td>
                    <td style="padding:12px 14px;text-align:right;font-size:13px;font-weight:600;color:#1e293b">
                        TK {{ number_format((float)$item->total) }}
                    </td>
                </tr>
                @endforeach
                {{-- Totals --}}
                <tr style="background:#f8fafc;border-top:1px solid #e2e8f0">
                    <td colspan="3" style="padding:10px 14px;text-align:right;font-size:13px;color:#64748b">Subtotal</td>
                    <td style="padding:10px 14px;text-align:right;font-size:13px;color:#1e293b">TK {{ number_format((float)$o->subtotal) }}</td>
                </tr>
                <tr style="background:#f8fafc">
                    <td colspan="3" style="padding:6px 14px;text-align:right;font-size:13px;color:#64748b">Shipping</td>
                    <td style="padding:6px 14px;text-align:right;font-size:13px;color:#1e293b">
                        {{ $o->shipping_charge > 0 ? 'TK '.number_format((float)$o->shipping_charge) : 'FREE' }}
                    </td>
                </tr>
                @if($hasSale)
                <tr style="background:#f8fafc">
                    <td colspan="3" style="padding:6px 14px;text-align:right;font-size:13px;color:#64748b">Discount</td>
                    <td style="padding:6px 14px;text-align:right;font-size:13px;color:#16a34a">
                        − TK {{ number_format((float)$o->discount) }}
                    </td>
                </tr>
                @endif
                <tr style="background:#f1f5f9;border-top:2px solid #e2e8f0">
                    <td colspan="3" style="padding:12px 14px;text-align:right;font-size:15px;font-weight:700;color:#1e293b">Total</td>
                    <td style="padding:12px 14px;text-align:right;font-size:17px;font-weight:800;color:#5E2590">
                        TK {{ number_format((float)$o->total) }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- ── Shipping + Payment (2 col) ── --}}
    <tr>
        <td style="padding:0 40px 24px">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr valign="top">
                    {{-- Shipping address --}}
                    <td width="50%" style="padding-right:10px">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                               style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:16px">
                            <tr>
                                <td>
                                    <p style="margin:0 0 10px;font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em">
                                        📦 Shipping To
                                    </p>
                                    <p style="margin:0 0 4px;font-size:14px;font-weight:700;color:#1e293b">{{ $o->shipping_name }}</p>
                                    <p style="margin:0;font-size:13px;color:#475569;line-height:1.6">
                                        {{ $o->shipping_address }}<br>
                                        @if($o->shipping_area){{ $o->shipping_area }}, @endif{{ $o->shipping_city }}<br>
                                        📞 {{ $o->shipping_phone }}
                                        @if($o->shipping_email)<br>✉️ {{ $o->shipping_email }}@endif
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                    {{-- Payment info --}}
                    <td width="50%" style="padding-left:10px">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                               style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:16px">
                            <tr>
                                <td>
                                    <p style="margin:0 0 10px;font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em">
                                        💳 Payment
                                    </p>
                                    <p style="margin:0 0 6px;font-size:13px;color:#475569">
                                        <strong style="color:#1e293b">Method:</strong> {{ $payLabel }}
                                    </p>
                                    <p style="margin:0 0 6px;font-size:13px;color:#475569">
                                        <strong style="color:#1e293b">Status:</strong>
                                        <span style="padding:2px 8px;border-radius:4px;font-size:12px;font-weight:600;
                                            background:{{ $o->payment_status === 'paid' ? '#dcfce7' : '#fef9c3' }};
                                            color:{{ $o->payment_status === 'paid' ? '#15803d' : '#854d0e' }}">
                                            {{ ucfirst($o->payment_status) }}
                                        </span>
                                    </p>
                                    @if($o->notes)
                                    <p style="margin:10px 0 0;font-size:12px;color:#64748b;font-style:italic">
                                        Note: {{ $o->notes }}
                                    </p>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- ── Track order CTA ── --}}
    <tr>
        <td style="padding:0 40px 28px;text-align:center">
            <a href="{{ route('order-complete') }}?id={{ $o->order_no }}"
               style="display:inline-block;padding:13px 40px;background:linear-gradient(135deg,#5E2590,#2D1B69);color:#ffffff;text-decoration:none;border-radius:8px;font-size:15px;font-weight:700;letter-spacing:.3px">
                Track My Order →
            </a>
            <p style="margin:12px 0 0;font-size:12px;color:#94a3b8">
                Or visit <a href="{{ url('/track-order') }}" style="color:#5E2590;text-decoration:none">{{ url('/track-order') }}</a>
                and enter order <strong>#{{ $o->order_no }}</strong>
            </p>
        </td>
    </tr>

    {{-- ── Delivery info banner ── --}}
    <tr>
        <td style="padding:0 40px 28px">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                   style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);border:1px solid #bbf7d0;border-radius:8px;padding:16px">
                <tr>
                    <td align="center">
                        <p style="margin:0 0 6px;font-size:15px;font-weight:700;color:#15803d">🚚 Estimated Delivery: 2–5 Business Days</p>
                        <p style="margin:0;font-size:13px;color:#166534">
                            Cash on Delivery · Easy 7-day returns · Free shipping above TK 500
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- ── Help ── --}}
    <tr>
        <td style="padding:0 40px 28px">
            <p style="margin:0 0 6px;font-size:14px;font-weight:700;color:#1e293b">Need help with your order?</p>
            <p style="margin:0;font-size:13px;color:#64748b;line-height:1.7">
                @if($phone) 📞 <strong>{{ $phone }}</strong>@endif
                @if($email) &nbsp;·&nbsp; ✉️ <a href="mailto:{{ $email }}" style="color:#5E2590;text-decoration:none">{{ $email }}</a>@endif
                @if($address) <br>📍 {{ $address }}@endif
            </p>
        </td>
    </tr>

    {{-- ── Footer ── --}}
    <tr>
        <td style="background:#f8fafc;border-top:1px solid #e2e8f0;padding:18px 40px;text-align:center">
            <p style="margin:0 0 4px;font-size:13px;font-weight:700;color:#1e293b">{{ $shop }}</p>
            <p style="margin:0;font-size:11px;color:#cbd5e1">
                This email was sent because you placed an order on {{ $shop }}.
                Please do not reply to this email.
            </p>
        </td>
    </tr>

</table>
</td></tr>
</table>
</body>
</html>
