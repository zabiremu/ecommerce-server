@php
    $shop    = \App\Models\SiteSetting::get('company_name', 'NF Shop 24');
    $phone   = \App\Models\SiteSetting::get('contact_phone', '');
    $email   = \App\Models\SiteSetting::get('contact_email', '');
    $address = \App\Models\SiteSetting::get('contact_address', '');
    $firstName = explode(' ', trim($customerName))[0];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Welcome to {{ $shop }}</title>
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:Arial,Helvetica,sans-serif;color:#1e293b">
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="padding:32px 16px">
<tr><td align="center">
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600"
       style="max-width:600px;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,.07)">

    {{-- Header --}}
    <tr>
        <td style="background:linear-gradient(135deg,#2D1B69 0%,#5E2590 100%);padding:36px 40px;text-align:center">
            <h1 style="margin:0 0 6px;font-size:26px;font-weight:800;color:#ffffff;letter-spacing:-0.5px">
                🎉 Welcome, {{ $firstName }}!
            </h1>
            <p style="margin:0;font-size:14px;color:rgba(255,255,255,.8)">
                You're now part of the {{ $shop }} family.
            </p>
        </td>
    </tr>

    {{-- Body --}}
    <tr>
        <td style="padding:36px 40px">

            <p style="margin:0 0 20px;font-size:15px;line-height:1.7;color:#334155">
                Hi <strong>{{ $firstName }}</strong>, thank you for your first order at
                <strong>{{ $shop }}</strong>! We've received your order
                <span style="font-family:monospace;background:#f1f5f9;padding:2px 7px;border-radius:4px;font-size:13px;color:#5E2590"><strong>#{{ $orderNo }}</strong></span>
                and we're already getting it ready for you. 🛍️
            </p>

            {{-- What happens next --}}
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                   style="background:#f8fafc;border-radius:8px;padding:20px 24px;margin-bottom:24px">
                <tr>
                    <td>
                        <p style="margin:0 0 14px;font-size:13px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em">What happens next?</p>
                        @foreach([
                            ['📦', 'Order Confirmed',   'We\'ve received your order and will prepare it shortly.'],
                            ['🚚', 'Shipped',           'You\'ll get a tracking update once your order is on the way.'],
                            ['🏠', 'Delivered',         'Sit back and wait — we\'ll deliver right to your door!'],
                        ] as [$icon, $title, $desc])
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                               style="margin-bottom:12px">
                            <tr>
                                <td width="36" valign="top" style="font-size:20px;padding-top:2px">{{ $icon }}</td>
                                <td>
                                    <strong style="font-size:14px;color:#1e293b">{{ $title }}</strong><br>
                                    <span style="font-size:13px;color:#64748b">{{ $desc }}</span>
                                </td>
                            </tr>
                        </table>
                        @endforeach
                    </td>
                </tr>
            </table>

            {{-- Track order button --}}
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                   style="margin-bottom:28px">
                <tr>
                    <td align="center">
                        <a href="{{ route('order-complete') }}?id={{ $orderNo }}"
                           style="display:inline-block;padding:13px 36px;background:linear-gradient(135deg,#5E2590,#2D1B69);color:#ffffff;text-decoration:none;border-radius:8px;font-size:15px;font-weight:700;letter-spacing:.3px">
                            Track My Order →
                        </a>
                    </td>
                </tr>
            </table>

            {{-- Divider --}}
            <hr style="border:0;border-top:1px solid #e2e8f0;margin:0 0 24px">

            {{-- Need help --}}
            <p style="margin:0 0 6px;font-size:14px;font-weight:700;color:#1e293b">Need help?</p>
            <p style="margin:0;font-size:13px;color:#64748b;line-height:1.7">
                We're always here for you. Reach us at:
                @if($phone) 📞 <strong>{{ $phone }}</strong>@endif
                @if($email) &nbsp;·&nbsp; ✉️ <a href="mailto:{{ $email }}" style="color:#5E2590;text-decoration:none">{{ $email }}</a>@endif
            </p>
        </td>
    </tr>

    {{-- Footer --}}
    <tr>
        <td style="background:#f8fafc;border-top:1px solid #e2e8f0;padding:18px 40px;text-align:center">
            <p style="margin:0 0 4px;font-size:13px;font-weight:700;color:#1e293b">{{ $shop }}</p>
            @if($address)
            <p style="margin:0 0 6px;font-size:12px;color:#94a3b8">{{ $address }}</p>
            @endif
            <p style="margin:0;font-size:11px;color:#cbd5e1">
                You're receiving this because you placed an order on {{ $shop }}.
            </p>
        </td>
    </tr>

</table>
</td></tr>
</table>
</body>
</html>
