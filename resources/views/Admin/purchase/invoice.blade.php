@php
    $shop    = \App\Models\SiteSetting::get('company_name', 'ROVENTEX');
    $phone   = \App\Models\SiteSetting::get('contact_phone', '');
    $email   = \App\Models\SiteSetting::get('contact_email', '');
    $address = \App\Models\SiteSetting::get('contact_address', '');
    $logo    = \App\Models\SiteSetting::get('logo', '');
    $colorPrimary   = \App\Models\SiteSetting::get('color_primary', '#2D1B69');
    $colorSecondary = \App\Models\SiteSetting::get('color_secondary', '#5E2590');

    $statusStyle = match ($purchase->status) {
        'completed' => ['#166534', '#f0fdf4', '#bbf7d0'],
        'cancelled' => ['#b91c1c', '#fef2f2', '#fecaca'],
        default     => ['#92400e', '#fffbeb', '#fde68a'],
    };
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Invoice #{{ $purchase->invoice_no }}</title>
    <link rel="stylesheet" href="{{ asset('backend/assets/css/fontawesome-all.min.css') }}">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: #1e293b;
            background: #f1f5f9;
        }
        .toolbar {
            max-width: 820px; margin: 0 auto; padding: 16px 0 0;
            display: flex; align-items: center; justify-content: flex-end; gap: 8px;
        }
        .toolbar button, .toolbar a {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 9px 16px; border-radius: 6px; font-size: 13px; font-weight: 600;
            text-decoration: none; cursor: pointer; border: 1px solid transparent;
        }
        .btn-print { background: {{ $colorPrimary }}; color: #fff; }
        .btn-back { background: #fff; color: #334155; border-color: #e2e8f0; }

        .sheet {
            max-width: 820px; margin: 16px auto 40px; background: #fff;
            border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,.07);
            overflow: hidden;
        }
        .head {
            display: flex; justify-content: space-between; align-items: flex-start;
            padding: 32px 40px; background: linear-gradient(135deg,{{ $colorPrimary }} 0%,{{ $colorSecondary }} 100%); color: #fff;
        }
        .head .shop-logo-wrap {
            display: inline-flex; align-items: center; justify-content: center;
            margin-bottom: 10px;
        }
        .head .shop-logo { max-height: 80px; max-width: 260px; display: block; }
        .head h2 { margin: 0 0 4px; font-size: 20px; font-weight: 800; }
        .head p { margin: 2px 0; font-size: 12.5px; color: rgba(255,255,255,.8); }
        .head .meta { text-align: right; }
        .head .meta .title { font-size: 12px; text-transform: uppercase; letter-spacing: .06em; color: rgba(255,255,255,.7); margin: 0 0 4px; }
        .head .meta .inv-no { font-size: 20px; font-weight: 800; font-family: monospace; margin: 0 0 6px; }
        .head .meta .date { font-size: 12.5px; color: rgba(255,255,255,.85); margin: 0; }

        .body { padding: 28px 40px; }

        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }
        .info-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 16px; }
        .info-box .lbl { font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: .05em; margin: 0 0 8px; }
        .info-box .row { font-size: 13px; color: #1e293b; margin: 3px 0; }
        .info-box .row strong { color: #475569; font-weight: 600; }

        .status-pill {
            display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 11.5px; font-weight: 700;
            color: {{ $statusStyle[0] }}; background: {{ $statusStyle[1] }}; border: 1px solid {{ $statusStyle[2] }};
        }

        table.items { width: 100%; border-collapse: collapse; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; }
        table.items thead th {
            background: #f8fafc; text-align: left; font-size: 11.5px; font-weight: 700; color: #64748b;
            text-transform: uppercase; letter-spacing: .04em; padding: 10px 14px; border-bottom: 1px solid #e2e8f0;
        }
        table.items tbody td { padding: 10px 14px; font-size: 13px; border-bottom: 1px solid #f1f5f9; }
        table.items tfoot td { padding: 12px 14px; font-size: 14px; }
        .text-right { text-align: right; }

        .total-row td { font-weight: 800; font-size: 15px; border-top: 2px solid #e2e8f0; color: #1e293b; }

        .notes { margin-top: 20px; padding: 12px 16px; background: #f8fafc; border-left: 4px solid #5E2590; border-radius: 6px; font-size: 12.5px; color: #475569; }

        .footer { padding: 18px 40px 28px; text-align: center; font-size: 11.5px; color: #94a3b8; border-top: 1px solid #f1f5f9; }

        @media print {
            body { background: #fff; }
            .no-print { display: none !important; }
            .sheet { box-shadow: none; margin: 0; border-radius: 0; max-width: 100%; }
        }
    </style>
</head>
<body>

    <div class="toolbar no-print">
        <a href="{{ route('admin.purchases.show', $purchase) }}" class="btn-back">← Back</a>
        <button onclick="window.print()" class="btn-print"><i class="fas fa-print"></i> Print / Save as PDF</button>
    </div>

    <div class="sheet">
        <div class="head">
            <div>
                @if ($logo)
                    <div class="shop-logo-wrap">
                        <img src="{{ asset('storage/' . $logo) }}" alt="{{ $shop }}" class="shop-logo">
                    </div>
                @endif
                <h2>{{ $shop }}</h2>
                @if ($address) <p>{{ $address }}</p> @endif
                @if ($phone) <p>Phone: {{ $phone }}</p> @endif
                @if ($email) <p>Email: {{ $email }}</p> @endif
            </div>
            <div class="meta">
                <p class="title">Purchase Invoice</p>
                <p class="inv-no">#{{ $purchase->invoice_no }}</p>
                <p class="date">{{ $purchase->purchase_date->format('d M, Y') }}</p>
            </div>
        </div>

        <div class="body">
            <div class="info-grid">
                <div class="info-box">
                    <p class="lbl">Supplier</p>
                    <p class="row"><strong>{{ $purchase->supplier->name }}</strong></p>
                    @if ($purchase->supplier->company) <p class="row">{{ $purchase->supplier->company }}</p> @endif
                    @if ($purchase->supplier->phone) <p class="row">{{ $purchase->supplier->phone }}</p> @endif
                    @if ($purchase->supplier->email) <p class="row">{{ $purchase->supplier->email }}</p> @endif
                    @if ($purchase->supplier->address) <p class="row">{{ $purchase->supplier->address }}</p> @endif
                </div>
                <div class="info-box">
                    <p class="lbl">Purchase Details</p>
                    <p class="row"><strong>Warehouse:</strong> {{ $purchase->warehouse->name }}</p>
                    <p class="row"><strong>Date:</strong> {{ $purchase->purchase_date->format('d M, Y') }}</p>
                    <p class="row"><strong>Status:</strong> <span class="status-pill">{{ ucfirst($purchase->status) }}</span></p>
                </div>
            </div>

            <table class="items">
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Product</th>
                        <th class="text-right" style="width:110px;">Quantity</th>
                        <th class="text-right" style="width:130px;">Unit Cost</th>
                        <th class="text-right" style="width:130px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchase->items as $i => $item)
                        <tr>
                            <td style="color:#94a3b8;">{{ $i + 1 }}</td>
                            <td><strong>{{ $item->product_name }}</strong></td>
                            <td class="text-right">{{ rtrim(rtrim(number_format((float) $item->quantity, 2, '.', ''), '0'), '.') }}</td>
                            <td class="text-right">{{ \App\Support\Money::format($item->unit_cost) }}</td>
                            <td class="text-right"><strong>{{ \App\Support\Money::format($item->total) }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="4" class="text-right">Total</td>
                        <td class="text-right">{{ \App\Support\Money::format($purchase->total_amount) }}</td>
                    </tr>
                </tfoot>
            </table>

            @if ($purchase->notes)
                <div class="notes"><strong>Notes:</strong> {{ $purchase->notes }}</div>
            @endif
        </div>

        <div class="footer">
            Generated on {{ now()->format('d M, Y h:i A') }} — {{ $shop }}
        </div>
    </div>

</body>
</html>
