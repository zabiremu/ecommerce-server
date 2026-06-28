@extends('Admin.Layout.app')

@section('title', 'Site Settings')
@section('page_title', 'Site Settings')

@push('styles')
@include('Admin._partials.wp-styles')
<style>
    .color-picker-row { display: flex; align-items: center; gap: 10px; }
    .color-picker-row input[type="color"] { width: 44px; height: 36px; border: 1px solid #c3c4c7; border-radius: 4px; padding: 2px; cursor: pointer; background: #fff; }
    .color-picker-row input[type="text"]  { width: 110px; font-family: monospace; }
    .color-swatch { width: 36px; height: 36px; border-radius: 6px; border: 1px solid #c3c4c7; flex-shrink: 0; }
    .color-preview-bar { height: 48px; border-radius: 6px; margin-top: 12px; transition: background .2s; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 13px; font-weight: 600; letter-spacing: .03em; }
</style>
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif

<div class="flex items-center gap-3 mb-3">
    <h1 class="wp-h1">Site Settings</h1>
</div>

<form method="POST" action="{{ route('admin.site-settings.update') }}">
    @csrf @method('PUT')

    @if ($errors->any())
        <div class="mb-4 px-3 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">
            <ul class="list-disc list-inside">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="grid grid-cols-12 gap-5 mt-3">
        <div class="col-span-12 lg:col-span-8 space-y-5">

            <!-- Company -->
            <div class="wp-panel">
                <div class="wp-panel-h"><i class="fas fa-building mr-1.5 text-slate-400"></i> Company</div>
                <div class="wp-panel-body">
                    @foreach ($fields['company'] as $key => [$label, $rule])
                        <div class="wp-field">
                            <label>{{ $label }}</label>
                            @if (str_contains($key, 'tagline'))
                                <textarea name="{{ $key }}" rows="3" class="wp-input">{{ old($key, $settings[$key] ?? '') }}</textarea>
                                <p class="wp-help">Shown in the footer description.</p>
                            @else
                                <input type="text" name="{{ $key }}" value="{{ old($key, $settings[$key] ?? '') }}" class="wp-input">
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Contact -->
            <div class="wp-panel">
                <div class="wp-panel-h"><i class="fas fa-address-book mr-1.5 text-slate-400"></i> Contact Info</div>
                <div class="wp-panel-body">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach ($fields['contact'] as $key => [$label, $rule])
                            <div class="wp-field">
                                <label>{{ $label }}</label>
                                <input type="{{ str_contains($key, 'email') ? 'email' : 'text' }}"
                                       name="{{ $key }}"
                                       value="{{ old($key, $settings[$key] ?? '') }}"
                                       class="wp-input">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Social -->
            <div class="wp-panel">
                <div class="wp-panel-h"><i class="fas fa-share-nodes mr-1.5 text-slate-400"></i> Social Links</div>
                <div class="wp-panel-body">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach ($fields['social'] as $key => [$label, $rule])
                            @php
                                $iconMap = [
                                    'social_facebook'  => 'fab fa-facebook-f',
                                    'social_youtube'   => 'fab fa-youtube',
                                    'social_whatsapp'  => 'fab fa-whatsapp',
                                    'social_instagram' => 'fab fa-instagram',
                                ];
                            @endphp
                            <div class="wp-field">
                                <label><i class="{{ $iconMap[$key] ?? 'fas fa-link' }} mr-1"></i> {{ $label }}</label>
                                <input type="url"
                                       name="{{ $key }}"
                                       value="{{ old($key, $settings[$key] ?? '') }}"
                                       class="wp-input"
                                       placeholder="https://...">
                            </div>
                        @endforeach
                    </div>
                    <p class="wp-help mt-1">Leave blank to hide the icon from the footer.</p>
                </div>
            </div>

            <!-- Developer credit -->
            <div class="wp-panel">
                <div class="wp-panel-h"><i class="fas fa-code mr-1.5 text-slate-400"></i> Developer Credit</div>
                <div class="wp-panel-body">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach ($fields['credit'] as $key => [$label, $rule])
                            <div class="wp-field">
                                <label>{{ $label }}</label>
                                <input type="text" name="{{ $key }}" value="{{ old($key, $settings[$key] ?? '') }}" class="wp-input">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Header / Announcement -->
            <div class="wp-panel">
                <div class="wp-panel-h"><i class="fas fa-rectangle-ad mr-1.5 text-slate-400"></i> Header Announcement</div>
                <div class="wp-panel-body">
                    @foreach ($fields['header'] as $key => [$label, $rule])
                    <div class="wp-field">
                        <label>{{ $label }}</label>
                        <input type="text" name="{{ $key }}" value="{{ old($key, $settings[$key] ?? '') }}" class="wp-input"
                               placeholder="পণ্য বুঝে পেয়ে ডেলিভারি ম্যানকে পেমেন্ট করবেন">
                        <p class="wp-help">Top bar এর announcement message। খালি রাখলে default text দেখাবে।</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Steadfast Courier API -->
            <div class="wp-panel border-l-4 border-[#1a6b1a]">
                <div class="wp-panel-h"><i class="fas fa-truck-fast mr-1.5 text-[#1a6b1a]"></i> Steadfast Courier API</div>
                <div class="wp-panel-body">
                    <p class="text-[12.5px] text-[#50575e] mb-3">
                        Enter your credentials from <a href="https://steadfast.com.bd" target="_blank" class="text-[#2271b1]">steadfast.com.bd</a> → Settings → API.
                    </p>
                    <div class="space-y-3">
                        @foreach ($fields['steadfast'] as $key => [$label, $rule])
                            <div class="wp-field">
                                <label>{{ $label }}</label>
                                <input type="text"
                                       name="{{ $key }}"
                                       value="{{ old($key, $settings[$key] ?? '') }}"
                                       class="wp-input font-mono"
                                       placeholder="{{ str_contains($key, 'api_key') ? 'Your API Key' : (str_contains($key, 'secret') ? 'Your Secret Key' : 'Optional Bearer token') }}"
                                       autocomplete="off">
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3 px-3 py-2 bg-[#f0fdf4] border border-[#bbf7d0] rounded text-[12px] text-[#166534]">
                        <strong>Webhook URL</strong> — paste this into your Steadfast portal → API Settings → Webhook URL:<br>
                        <code class="font-mono text-[11px] break-all select-all">{{ url('/api/steadfast/webhook') }}</code>
                    </div>
                    <p class="wp-help mt-2">Once saved, a one-click "Send to Steadfast" button appears on every order.</p>
                </div>
            </div>

            <!-- BD Courier Fraud Checker -->
            @php $bdEnabled = !empty($settings['bdcourier_api_key'] ?? ''); @endphp
            <div class="wp-panel border-l-4 border-[#d97706]">
                <div class="wp-panel-h flex items-center gap-2">
                    <i class="fas fa-shield-halved mr-1.5 text-[#d97706]"></i>
                    <span>BD Courier Fraud Checker</span>
                    <span class="ml-auto text-[11px] font-semibold px-2 py-0.5 rounded {{ $bdEnabled ? 'bg-[#f0fdf4] text-[#15803d]' : 'bg-[#f3f4f6] text-[#6b7280]' }}">
                        <i class="fas {{ $bdEnabled ? 'fa-circle-check' : 'fa-circle-xmark' }} mr-1"></i>
                        {{ $bdEnabled ? 'Active' : 'Not configured' }}
                    </span>
                </div>
                <div class="wp-panel-body">
                    <p class="text-[12.5px] text-[#50575e] mb-4">
                        Checks customer phone numbers against <strong>BD Courier</strong> delivery history before accepting an order.
                        Get your API key from <strong>bdcourier.com</strong> → API Settings.
                    </p>
                    <div class="space-y-3">
                        <div class="wp-field">
                            <label>BD Courier API Key</label>
                            <input type="text"
                                   name="bdcourier_api_key"
                                   value="{{ old('bdcourier_api_key', $settings['bdcourier_api_key'] ?? '') }}"
                                   class="wp-input font-mono"
                                   placeholder="Your BD Courier API key"
                                   autocomplete="off">
                            <p class="wp-help">Leave blank to disable the fraud check entirely.</p>
                        </div>
                        <div class="wp-field">
                            <label>Minimum Success Ratio to Allow Order (%)</label>
                            <input type="number"
                                   name="bdcourier_min_success_ratio"
                                   value="{{ old('bdcourier_min_success_ratio', $settings['bdcourier_min_success_ratio'] ?? '') }}"
                                   class="wp-input"
                                   min="0" max="100" step="1"
                                   placeholder="e.g. 50">
                            <p class="wp-help">
                                If a phone's BD Courier success ratio is <strong>below</strong> this value, the order will be rejected.
                                Set to <strong>0</strong> or leave blank to only record data without blocking any order.
                            </p>
                        </div>
                    </div>
                    <div class="mt-4 px-3 py-3 bg-[#fffbeb] border border-[#fde68a] rounded text-[12.5px] text-[#92400e] space-y-1">
                        <p><i class="fas fa-circle-info mr-1"></i> <strong>How it works:</strong></p>
                        <ul class="list-disc list-inside space-y-0.5 mt-1 text-[12px]">
                            <li>On every order, the customer's phone is checked against all major BD couriers (Pathao, Steadfast, Redx, etc.).</li>
                            <li>If the overall success ratio is below the threshold <strong>and</strong> the phone has prior delivery history, the order is blocked.</li>
                            <li>Phones with <strong>no history</strong> in BD Courier are always allowed through.</li>
                            <li>Results are saved on each order for admin review.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- UddoktaPay Payment Gateway -->
            <div class="wp-panel border-l-4 border-[#7c3aed]">
                <div class="wp-panel-h">
                    <span><i class="fas fa-credit-card mr-1.5" style="color:#7c3aed"></i> UddoktaPay Payment Gateway</span>
                    @php $upEnabled = !empty($settings['uddoktapay_api_key'] ?? ''); @endphp
                    <span class="text-[11px] font-semibold px-2 py-0.5 rounded {{ $upEnabled ? 'bg-[#f0fdf4] text-[#15803d]' : 'bg-[#f3f4f6] text-[#6b7280]' }}">
                        <i class="fas {{ $upEnabled ? 'fa-circle-check' : 'fa-circle-xmark' }} mr-1"></i>
                        {{ $upEnabled ? 'Connected' : 'Not configured' }}
                    </span>
                </div>
                <div class="wp-panel-body">
                    <p class="text-[12.5px] text-[#50575e] mb-3">
                        Get your API credentials from <a href="https://uddoktapay.com" target="_blank" class="text-[#2271b1]">uddoktapay.com</a>
                        → Dashboard → API Settings. Use <strong>Live URL</strong> for production.
                    </p>

                    <div class="space-y-3">
                        <div class="wp-field">
                            <label>UddoktaPay API Key</label>
                            <input type="text"
                                   name="uddoktapay_api_key"
                                   value="{{ old('uddoktapay_api_key', $settings['uddoktapay_api_key'] ?? '') }}"
                                   class="wp-input font-mono"
                                   placeholder="Your UddoktaPay API key"
                                   autocomplete="off">
                        </div>
                        <div class="wp-field">
                            <label>UddoktaPay API URL</label>
                            <input type="text"
                                   name="uddoktapay_api_url"
                                   value="{{ old('uddoktapay_api_url', $settings['uddoktapay_api_url'] ?? '') }}"
                                   class="wp-input font-mono"
                                   placeholder="https://sandbox.uddoktapay.com/api">
                            <p class="wp-help">
                                Sandbox: <code class="font-mono text-[11px]">https://sandbox.uddoktapay.com/api</code><br>
                                Live: <code class="font-mono text-[11px]">https://uddoktapay.com/api</code>
                            </p>
                        </div>
                    </div>

                    {{-- Callback URLs for UddoktaPay portal --}}
                    <div class="mt-4 space-y-2">
                        <p class="text-[12px] font-semibold text-[#1d2327] mb-1">Paste these URLs in your UddoktaPay portal:</p>
                        @foreach ([
                            ['Success / Redirect URL', route('uddoktapay.callback')],
                            ['Cancel URL',             route('uddoktapay.cancel')],
                            ['Webhook URL',            route('uddoktapay.webhook')],
                        ] as [$urlLabel, $urlValue])
                        <div class="px-3 py-2 bg-[#f5f3ff] border border-[#ddd6fe] rounded text-[12px] text-[#5b21b6]">
                            <strong>{{ $urlLabel }}</strong><br>
                            <code class="font-mono text-[11px] break-all select-all text-[#4c1d95]">{{ $urlValue }}</code>
                        </div>
                        @endforeach
                    </div>

                    <p class="wp-help mt-2">Once saved, customers can select UddoktaPay at checkout for online payment.</p>
                </div>
            </div>

            <!-- Email / SMTP -->
            <div class="wp-panel border-l-4 border-[#2271b1]">
                <div class="wp-panel-h">
                    <span><i class="fas fa-envelope mr-1.5 text-[#2271b1]"></i> Email / SMTP Settings</span>
                    @php $mailOk = \App\Services\MailConfigService::isConfigured(); @endphp
                    <span class="text-[11px] font-semibold px-2 py-0.5 rounded {{ $mailOk ? 'bg-[#f0fdf4] text-[#15803d]' : 'bg-[#f3f4f6] text-[#6b7280]' }}">
                        <i class="fas {{ $mailOk ? 'fa-circle-check' : 'fa-circle-xmark' }} mr-1"></i>
                        {{ $mailOk ? 'Configured' : 'Not configured' }}
                    </span>
                </div>
                <div class="wp-panel-body">
                    <p class="text-[12.5px] text-[#50575e] mb-4">
                        Configure SMTP to send contact notifications and order emails. Works with
                        <strong>Gmail</strong>, <strong>Mailgun</strong>, <strong>SendGrid</strong>, or any SMTP provider.
                    </p>

                    {{-- Driver + Encryption row --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;" class="mb-3">
                        <div class="wp-field">
                            <label>Mail Driver</label>
                            <select name="mail_mailer" class="wp-input">
                                @foreach(['smtp' => 'SMTP', 'log' => 'Log (testing)', 'sendmail' => 'Sendmail'] as $val => $lbl)
                                    <option value="{{ $val }}" @selected(($settings['mail_mailer'] ?? 'smtp') === $val)>{{ $lbl }}</option>
                                @endforeach
                            </select>
                            <p class="wp-help">Use <em>Log</em> to test without sending real emails.</p>
                        </div>
                        <div class="wp-field">
                            <label>Encryption</label>
                            <select name="mail_encryption" class="wp-input">
                                <option value="tls"  @selected(($settings['mail_encryption'] ?? 'tls') === 'tls')>TLS (recommended)</option>
                                <option value="ssl"  @selected(($settings['mail_encryption'] ?? '') === 'ssl')>SSL</option>
                                <option value="none" @selected(in_array($settings['mail_encryption'] ?? '', ['', 'none']))>None</option>
                            </select>
                        </div>
                    </div>

                    {{-- Host + Port --}}
                    <div style="display:grid;grid-template-columns:1fr 140px;gap:12px;" class="mb-3">
                        <div class="wp-field mb-0">
                            <label>SMTP Host</label>
                            <input type="text" name="mail_host"
                                   value="{{ old('mail_host', $settings['mail_host'] ?? '') }}"
                                   class="wp-input font-mono"
                                   placeholder="smtp.gmail.com">
                        </div>
                        <div class="wp-field mb-0">
                            <label>SMTP Port</label>
                            <input type="number" name="mail_port"
                                   value="{{ old('mail_port', $settings['mail_port'] ?? '587') }}"
                                   class="wp-input font-mono"
                                   placeholder="587">
                        </div>
                    </div>

                    {{-- Username + Password --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;" class="mb-3">
                        <div class="wp-field mb-0">
                            <label>SMTP Username</label>
                            <input type="text" name="mail_username"
                                   value="{{ old('mail_username', $settings['mail_username'] ?? '') }}"
                                   class="wp-input font-mono"
                                   placeholder="you@gmail.com"
                                   autocomplete="off">
                        </div>
                        <div class="wp-field mb-0">
                            <label>SMTP Password / App Password</label>
                            <div style="position:relative;">
                                <input type="password" name="mail_password" id="mailPwField"
                                       value="{{ old('mail_password', $settings['mail_password'] ?? '') }}"
                                       class="wp-input font-mono"
                                       placeholder="••••••••••••"
                                       autocomplete="new-password"
                                       style="padding-right:34px;">
                                <button type="button" onclick="toggleMailPw()"
                                        style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:0;cursor:pointer;color:#787c82;font-size:13px;">
                                    <i class="fas fa-eye" id="mailPwEye"></i>
                                </button>
                            </div>
                            <p class="wp-help">For Gmail, use an <a href="https://myaccount.google.com/apppasswords" target="_blank" class="text-[#2271b1]">App Password</a>.</p>
                        </div>
                    </div>

                    {{-- From address + name --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;" class="mb-4">
                        <div class="wp-field mb-0">
                            <label>From Email Address</label>
                            <input type="email" name="mail_from_address"
                                   value="{{ old('mail_from_address', $settings['mail_from_address'] ?? '') }}"
                                   class="wp-input"
                                   placeholder="noreply@yourshop.com">
                        </div>
                        <div class="wp-field mb-0">
                            <label>From Name</label>
                            <input type="text" name="mail_from_name"
                                   value="{{ old('mail_from_name', $settings['mail_from_name'] ?? '') }}"
                                   class="wp-input"
                                   placeholder="NF Shop 24">
                        </div>
                    </div>

                    {{-- Quick-reference --}}
                    <div class="mt-1 mb-4 p-3 bg-[#f6f7f7] border border-[#e0e0e0] rounded text-[12px] text-[#50575e]">
                        <p class="font-semibold text-[#1d2327] mb-1.5">Common SMTP providers:</p>
                        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:4px;">
                            @foreach([
                                ['Gmail',    'smtp.gmail.com',        '587', 'TLS'],
                                ['Outlook',  'smtp.office365.com',    '587', 'TLS'],
                                ['Yahoo',    'smtp.mail.yahoo.com',   '465', 'SSL'],
                                ['Mailgun',  'smtp.mailgun.org',      '587', 'TLS'],
                                ['SendGrid', 'smtp.sendgrid.net',     '587', 'TLS'],
                                ['Mailtrap', 'sandbox.smtp.mailtrap.io','2525','TLS'],
                            ] as [$name, $host, $port, $enc])
                            <div style="padding:5px 8px;background:#fff;border:1px solid #e0e0e0;border-radius:4px;cursor:pointer;"
                                 onclick="fillSmtp('{{ $host }}','{{ $port }}','{{ $enc }}')"
                                 title="Click to fill">
                                <span style="font-weight:600;color:#1d2327;">{{ $name }}</span><br>
                                <span style="font-size:10px;font-family:monospace;">{{ $host }}</span>
                            </div>
                            @endforeach
                        </div>
                        <p class="mt-1.5 text-[11px]"><i class="fas fa-mouse-pointer"></i> Click a provider to auto-fill host, port & encryption.</p>
                    </div>

                    {{-- Test email --}}
                    <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:6px;padding:12px 14px;">
                        <p class="text-[13px] font-semibold text-[#1e40af] mb-2"><i class="fas fa-paper-plane mr-1"></i> Send Test Email</p>
                        <p class="text-[12px] text-[#1e40af] mb-3">Save settings first, then send a test to confirm delivery.</p>
                        <div style="display:flex;gap:8px;align-items:center;">
                            <input type="email" id="testEmailTo"
                                   placeholder="recipient@example.com"
                                   value="{{ $settings['admin_notify_email'] ?? $settings['contact_email'] ?? '' }}"
                                   class="wp-input" style="max-width:280px;">
                            <button type="button" onclick="sendTestEmail()" id="testEmailBtn" class="wp-btn wp-btn-primary">
                                <i class="fas fa-paper-plane mr-1"></i> Send Test
                            </button>
                        </div>
                        <div id="testEmailMsg" style="display:none;margin-top:8px;font-size:12.5px;padding:6px 10px;border-radius:4px;"></div>
                    </div>

                </div>
            </div>

            <!-- Colors -->
            <div class="wp-panel border-l-4 border-[#5E2590]">
                <div class="wp-panel-h"><i class="fas fa-palette mr-1.5" style="color:#5E2590"></i> Brand Colors</div>
                <div class="wp-panel-body">
                    <p class="text-[12.5px] text-[#50575e] mb-4">These colors apply instantly to the entire storefront — buttons, headers, links, and more.</p>

                    @php
                        $colorDefs = [
                            'color_primary'   => ['Primary',   '#2D1B69', 'Main brand color — used in footer, preloader, dark sections.'],
                            'color_secondary' => ['Secondary', '#5E2590', 'Accent brand color — used in buttons, links, category bar.'],
                            'color_accent'    => ['Accent',    '#f59e0b', 'Highlight color — used for badges, stars, CTA buttons.'],
                        ];
                    @endphp

                    <div class="space-y-5">
                        @foreach ($colorDefs as $key => [$label, $default, $hint])
                            @php $val = old($key, $settings[$key] ?? $default); @endphp
                            <div class="wp-field" x-data="{ hex: '{{ $val }}' }">
                                <label class="font-semibold">{{ $label }}</label>
                                <div class="color-picker-row mt-1">
                                    <input type="color"
                                           x-model="hex"
                                           @input="$refs.text_{{ $key }}.value = hex"
                                           value="{{ $val }}">
                                    <input type="text"
                                           name="{{ $key }}"
                                           x-ref="text_{{ $key }}"
                                           x-model="hex"
                                           @input="hex = $event.target.value"
                                           class="wp-input"
                                           style="width:110px;font-family:monospace"
                                           maxlength="7"
                                           placeholder="{{ $default }}">
                                    <div class="color-swatch" :style="'background:' + hex"></div>
                                    <span class="text-[12px] text-[#50575e]">{{ $hint }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Live preview bar --}}
                    <div x-data="{
                        p: '{{ old('color_primary', $settings['color_primary'] ?? '#2D1B69') }}',
                        s: '{{ old('color_secondary', $settings['color_secondary'] ?? '#5E2590') }}',
                        a: '{{ old('color_accent', $settings['color_accent'] ?? '#f59e0b') }}'
                    }"
                    x-init="
                        $watch('p', v => $refs.bar.style.background = 'linear-gradient(90deg,'+p+','+s+')');
                        $watch('s', v => $refs.bar.style.background = 'linear-gradient(90deg,'+p+','+s+')');
                    "
                    @color-change.window="p=$event.detail.p||p; s=$event.detail.s||s">
                        <div class="color-preview-bar mt-4"
                             x-ref="bar"
                             :style="'background:linear-gradient(90deg,'+p+','+s+')'">
                            <i class="fas fa-store mr-2"></i> Preview — Your Storefront Header
                        </div>
                        <div class="mt-2 flex gap-2">
                            <button type="button"
                                    :style="'background:'+s+';color:#fff;border:none;padding:7px 18px;border-radius:6px;font-size:13px;font-weight:600;cursor:pointer'"
                                    x-init="$el.style.background='{{ old('color_secondary', $settings['color_secondary'] ?? '#5E2590') }}'">
                                <i class="fas fa-cart-shopping mr-1"></i> Add to Cart
                            </button>
                            <button type="button"
                                    :style="'background:'+a+';color:#fff;border:none;padding:7px 18px;border-radius:6px;font-size:13px;font-weight:600;cursor:pointer'"
                                    x-init="$el.style.background='{{ old('color_accent', $settings['color_accent'] ?? '#f59e0b') }}'">
                                <i class="fas fa-bolt mr-1"></i> Buy Now
                            </button>
                        </div>
                    </div>

                    <p class="wp-help mt-3"><i class="fas fa-circle-info mr-1"></i> Default primary: <code>#2D1B69</code> · secondary: <code>#5E2590</code> · accent: <code>#f59e0b</code></p>
                </div>
            </div>

        </div>

        <div class="col-span-12 lg:col-span-4 space-y-5">
            <div class="wp-panel">
                <div class="wp-panel-h">Save</div>
                <div class="wp-panel-body">
                    <button type="submit" class="wp-btn-primary w-full justify-center">
                        <i class="fas fa-save mr-1"></i> Save Settings
                    </button>
                    <p class="wp-help mt-2">Changes apply immediately across the storefront footer and header.</p>
                </div>
            </div>

            <div class="wp-panel">
                <div class="wp-panel-h">Preview</div>
                <div class="wp-panel-body text-[12px] text-slate-600 space-y-2">
                    <div><strong>Phone:</strong> {{ $settings['contact_phone'] ?? '—' }}</div>
                    <div><strong>Email:</strong> {{ $settings['contact_email'] ?? '—' }}</div>
                    <div><strong>Address:</strong> {{ $settings['contact_address'] ?? '—' }}</div>
                    <div><strong>Hours:</strong> {{ $settings['contact_hours'] ?? '—' }}</div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
// SMTP provider quick-fill
function fillSmtp(host, port, enc) {
    var h = document.querySelector('[name="mail_host"]');
    var p = document.querySelector('[name="mail_port"]');
    var e = document.querySelector('[name="mail_encryption"]');
    if (h) h.value = host;
    if (p) p.value = port;
    if (e) {
        var target = enc.toLowerCase() === '' ? 'none' : enc.toLowerCase();
        for (var i = 0; i < e.options.length; i++) {
            if (e.options[i].value === target) { e.selectedIndex = i; break; }
        }
    }
}

// Toggle password visibility
function toggleMailPw() {
    var f = document.getElementById('mailPwField');
    var i = document.getElementById('mailPwEye');
    if (!f) return;
    f.type = f.type === 'password' ? 'text' : 'password';
    i.className = f.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
}

// Send test email via AJAX
async function sendTestEmail() {
    var to  = document.getElementById('testEmailTo').value.trim();
    var btn = document.getElementById('testEmailBtn');
    var msg = document.getElementById('testEmailMsg');
    if (!to) { showTestMsg('Please enter a recipient email address.', false); return; }

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Sending…';

    try {
        var res  = await fetch('{{ route('admin.site-settings.test-email') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ to }),
        });
        var data = await res.json();
        showTestMsg(data.message || (data.success ? 'Sent!' : 'Failed.'), data.success);
    } catch (e) {
        showTestMsg('Request failed: ' + e.message, false);
    }

    btn.disabled = false;
    btn.innerHTML = '<i class="fas fa-paper-plane mr-1"></i> Send Test';
}

function showTestMsg(text, ok) {
    var el = document.getElementById('testEmailMsg');
    el.style.display   = 'block';
    el.style.background = ok ? '#f0fdf4' : '#fef2f2';
    el.style.color      = ok ? '#15803d' : '#b91c1c';
    el.style.border     = '1px solid ' + (ok ? '#bbf7d0' : '#fecaca');
    el.textContent      = (ok ? '✓ ' : '✗ ') + text;
}
</script>
@endpush
