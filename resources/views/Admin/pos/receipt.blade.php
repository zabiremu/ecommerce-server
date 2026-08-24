@php
    $shop    = \App\Models\SiteSetting::get('company_name', 'Roventex');
    $phone   = \App\Models\SiteSetting::get('contact_phone', '');
    $address = \App\Models\SiteSetting::get('contact_address', '');
    $colorPrimary = \App\Models\SiteSetting::get('color_primary', '#2D1B69');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $order->order_no }}</title>
    <link rel="stylesheet" href="{{ asset('backend/assets/css/fontawesome-all.min.css') }}">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 0; font-family: 'Courier New', Courier, monospace; color: #1e293b; background: #f1f5f9; }

        .toolbar { max-width: 340px; margin: 0 auto; padding: 16px 0 0; display: flex; gap: 8px; justify-content: center; }
        .toolbar button, .toolbar a {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 9px 16px; border-radius: 6px; font-size: 13px; font-weight: 600;
            text-decoration: none; cursor: pointer; border: 1px solid transparent; font-family: Arial, sans-serif;
        }
        .btn-print { background: {{ $colorPrimary }}; color: #fff; }
        .btn-back { background: #fff; color: #334155; border-color: #e2e8f0; }

        .sheet { max-width: 320px; margin: 16px auto 40px; background: #fff; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,.07); padding: 20px 18px; }
        .center { text-align: center; }
        .shop-name { font-size: 15px; font-weight: 800; margin: 0 0 2px; }
        .muted { color: #64748b; font-size: 11px; margin: 1px 0; }
        .divider { border-top: 1px dashed #cbd5e1; margin: 12px 0; }
        .row { display: flex; justify-content: space-between; font-size: 12px; margin: 3px 0; }
        .row .lbl { color: #64748b; }
        .items-table { width: 100%; font-size: 11.5px; border-collapse: collapse; }
        .items-table th { text-align: left; font-size: 10px; text-transform: uppercase; color: #94a3b8; padding: 2px 0; border-bottom: 1px solid #e2e8f0; }
        .items-table td { padding: 4px 0; vertical-align: top; }
        .text-right { text-align: right; }
        .total-row { font-size: 14px; font-weight: 800; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 999px; font-size: 10px; font-weight: 700; background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .footer { margin-top: 14px; font-size: 10.5px; color: #94a3b8; text-align: center; }

        @media print {
            body { background: #fff; }
            .no-print { display: none !important; }
            .sheet { box-shadow: none; margin: 0; border-radius: 0; max-width: 100%; }
        }
    </style>
</head>
<body>

    <div class="toolbar no-print">
        <a href="{{ route('admin.pos.index') }}" class="btn-back">← Back to POS</a>
        <button onclick="window.print()" class="btn-print"><i class="fas fa-print"></i> Print Receipt</button>
    </div>

    <div class="sheet">
        <div class="center">
            <p class="shop-name">{{ $shop }}</p>
            @if ($address) <p class="muted">{{ $address }}</p> @endif
            @if ($phone) <p class="muted">Tel: {{ $phone }}</p> @endif
        </div>

        <div class="divider"></div>

        <div class="row"><span class="lbl">Receipt No</span><span><strong>{{ $order->order_no }}</strong></span></div>
        <div class="row"><span class="lbl">Date</span><span>{{ $order->placed_at?->format('d M, Y h:i A') }}</span></div>
        <div class="row"><span class="lbl">Cashier</span><span>{{ $order->servedBy->name ?? '—' }}</span></div>
        @if ($order->warehouse)
        <div class="row"><span class="lbl">Outlet</span><span>{{ $order->warehouse->name }}</span></div>
        @endif
        <div class="row"><span class="lbl">Customer</span><span>{{ $order->shipping_name }}</span></div>
        <div class="row"><span class="lbl">Phone</span><span>{{ $order->shipping_phone }}</span></div>

        <div class="divider"></div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>
                            {{ $item->product_name }}
                            @if ($item->variant_label)
                                <br><span class="muted">{{ $item->variant_label }}</span>
                            @endif
                        </td>
                        <td class="text-right">{{ rtrim(rtrim(number_format((float) $item->quantity, 2, '.', ''), '0'), '.') }}</td>
                        <td class="text-right">{{ number_format((float) $item->unit_price, 2) }}</td>
                        <td class="text-right">{{ number_format((float) $item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="divider"></div>

        <div class="row"><span class="lbl">Subtotal</span><span>{{ \App\Support\Money::format($order->subtotal) }}</span></div>
        @if ($order->discount > 0)
        <div class="row"><span class="lbl">Discount</span><span>-{{ \App\Support\Money::format($order->discount) }}</span></div>
        @endif
        <div class="row total-row"><span>Total</span><span>{{ \App\Support\Money::format($order->total) }}</span></div>

        <div class="divider"></div>

        <div class="row"><span class="lbl">Payment</span><span>{{ strtoupper($order->payment_method) }}</span></div>
        @if ($order->paid_amount !== null)
        <div class="row"><span class="lbl">Paid</span><span>{{ \App\Support\Money::format($order->paid_amount) }}</span></div>
        @endif
        @if ($order->change_due > 0)
        <div class="row"><span class="lbl">Change</span><span>{{ \App\Support\Money::format($order->change_due) }}</span></div>
        @endif

        <div class="center" style="margin-top:10px;">
            <span class="badge">PAID</span>
        </div>

        <div class="footer">
            Thank you for shopping with us!<br>
            Generated {{ now()->format('d M, Y h:i A') }}
        </div>
    </div>

    <script>window.onload = () => setTimeout(() => window.print(), 300);</script>
</body>
</html>
