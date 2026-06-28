<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Contact Message</title>
</head>
<body style="margin:0;padding:0;background:#f5f7fb;font-family:Arial,Helvetica,sans-serif;color:#1a1a2e">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="padding:30px 0">
        <tr>
            <td align="center">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" style="max-width:600px;background:#ffffff;border-radius:10px;overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,.06)">
                    <tr>
                        <td style="background:linear-gradient(135deg,#2D1B69,#5E2590);padding:24px 28px;color:#fff">
                            <h1 style="margin:0;font-size:20px;font-weight:700">📨 New Contact Message</h1>
                            <p style="margin:4px 0 0;font-size:13px;opacity:.85">Someone reached out via the website contact form.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="font-size:14px;line-height:1.6">
                                <tr>
                                    <td style="padding:8px 0;width:120px;color:#64748b;font-weight:600">Name</td>
                                    <td style="padding:8px 0;color:#1a1a2e">{{ $m->name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;color:#64748b;font-weight:600">Email</td>
                                    <td style="padding:8px 0;color:#1a1a2e"><a href="mailto:{{ $m->email }}" style="color:#5E2590;text-decoration:none">{{ $m->email }}</a></td>
                                </tr>
                                @if ($m->phone)
                                    <tr>
                                        <td style="padding:8px 0;color:#64748b;font-weight:600">Phone</td>
                                        <td style="padding:8px 0;color:#1a1a2e">{{ $m->phone }}</td>
                                    </tr>
                                @endif
                                @if ($m->subject)
                                    <tr>
                                        <td style="padding:8px 0;color:#64748b;font-weight:600">Subject</td>
                                        <td style="padding:8px 0;color:#1a1a2e">{{ $m->subject }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td style="padding:8px 0;color:#64748b;font-weight:600;vertical-align:top">Message</td>
                                    <td style="padding:8px 0;color:#1a1a2e;white-space:pre-wrap">{{ $m->message }}</td>
                                </tr>
                            </table>

                            <div style="margin-top:24px;padding-top:20px;border-top:1px solid #e2e8f0;font-size:12px;color:#94a3b8">
                                Received {{ $m->created_at->format('M j, Y \a\t g:i A') }} &middot; IP: {{ $m->ip ?? 'n/a' }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f8fafc;padding:16px 28px;text-align:center;font-size:12px;color:#64748b">
                            Reply directly to this email to reach the sender.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
