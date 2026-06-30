<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Services\MailConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SiteSettingController extends Controller
{
    protected array $fields = [
        // group => [key => ['label','rules','help']]
        'company' => [
            'company_name'    => ['Company Name',    'nullable|string|max:255'],
            'company_tagline' => ['Footer Tagline',  'nullable|string|max:1000'],
        ],
        'contact' => [
            'contact_address'     => ['Address',                'nullable|string|max:255'],
            'contact_email'       => ['Public Email',           'nullable|email|max:255'],
            'contact_phone'       => ['Phone',                  'nullable|string|max:30'],
            'contact_hours'       => ['Business Hours',         'nullable|string|max:100'],
            'admin_notify_email'  => ['Admin Notify Email',     'nullable|email|max:255'],
        ],
        'social' => [
            'social_facebook'  => ['Facebook URL',   'nullable|string|max:500'],
            'social_youtube'   => ['YouTube URL',    'nullable|string|max:500'],
            'social_whatsapp'  => ['WhatsApp URL',   'nullable|string|max:500'],
            'social_instagram' => ['Instagram URL',  'nullable|string|max:500'],
        ],
        'credit' => [
            'developer_name'  => ['Developer Name',  'nullable|string|max:100'],
            'developer_url'   => ['Developer URL',   'nullable|string|max:500'],
        ],
        'steadfast' => [
            'steadfast_api_key'       => ['Steadfast API Key',      'nullable|string|max:255'],
            'steadfast_secret_key'    => ['Steadfast Secret Key',   'nullable|string|max:255'],
            'steadfast_webhook_token' => ['Steadfast Webhook Token', 'nullable|string|max:255'],
        ],

        'bdcourier' => [
            'bdcourier_api_key'           => ['BD Courier API Key',                'nullable|string|max:255'],
            'bdcourier_min_success_ratio' => ['Min. Success Ratio to Allow Order (%)', 'nullable|numeric|min:0|max:100'],
        ],
        'uddoktapay' => [
            'uddoktapay_api_key' => ['UddoktaPay API Key', 'nullable|string|max:255'],
            'uddoktapay_api_url' => ['UddoktaPay API URL', 'nullable|string|max:500'],
        ],
        'mail' => [
            'mail_mailer'       => ['Mail Driver',      'nullable|string|in:smtp,log,sendmail'],
            'mail_host'         => ['SMTP Host',        'nullable|string|max:255'],
            'mail_port'         => ['SMTP Port',        'nullable|string|max:10'],
            'mail_username'     => ['SMTP Username',    'nullable|string|max:255'],
            'mail_password'     => ['SMTP Password',    'nullable|string|max:500'],
            'mail_encryption'   => ['Encryption',       'nullable|string|in:tls,ssl,none'],
            'mail_from_address' => ['From Email',       'nullable|string|max:255'],
            'mail_from_name'    => ['From Name',        'nullable|string|max:255'],
        ],
        'colors' => [
            'color_primary'   => ['Primary Color',   'nullable|regex:/^#[0-9a-fA-F]{6}$/'],
            'color_secondary' => ['Secondary Color', 'nullable|regex:/^#[0-9a-fA-F]{6}$/'],
            'color_accent'    => ['Accent Color',    'nullable|regex:/^#[0-9a-fA-F]{6}$/'],
        ],
        'header' => [
            'announcement_text' => ['Announcement Bar Text', 'nullable|string|max:300'],
        ],
        'homepage' => [
            'home_hero_title'    => ['Hero Title',    'nullable|string|max:255'],
            'home_hero_subtitle' => ['Hero Subtitle', 'nullable|string|max:500'],
        ],
    ];

    public function edit()
    {
        $settings = SiteSetting::pluck('value', 'key')->all();
        $fields = $this->fields;
        return view('Admin.site_settings.edit', compact('settings', 'fields'));
    }

    public function update(Request $request)
    {
        $rules = [];
        foreach ($this->fields as $group) {
            foreach ($group as $key => [$label, $rule]) {
                $rules[$key] = $rule;
            }
        }

        $data = $request->validate($rules);

        // Normalise values before saving
        if (isset($data['mail_port']) && $data['mail_port'] !== null) {
            $data['mail_port'] = (int) $data['mail_port'] ?: null;
        }
        if (isset($data['mail_encryption']) && $data['mail_encryption'] === 'none') {
            $data['mail_encryption'] = '';
        }

        DB::transaction(function () use ($data) {
            foreach ($this->fields as $groupName => $keys) {
                foreach ($keys as $key => $_) {
                    SiteSetting::updateOrCreate(
                        ['key' => $key],
                        ['value' => $data[$key] ?? null, 'group' => $groupName]
                    );
                }
            }
        });

        SiteSetting::flushCache();

        return redirect()->route('admin.site-settings.edit')
            ->with('success', 'Site settings updated successfully.');
    }

    public function sendTestEmail(Request $request)
    {
        $to = trim((string) $request->input('to', ''));
        if (!$to || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['success' => false, 'message' => 'Please enter a valid email address.'], 422);
        }

        try {
            MailConfigService::apply();

            Mail::raw('This is a test email from your ROVENTEX admin panel. Your mail settings are working correctly!', function ($msg) use ($to) {
                $msg->to($to)->subject('✅ Test Email — Mail Settings Working');
            });

            return response()->json(['success' => true, 'message' => 'Test email sent to ' . $to . '. Please check your inbox.']);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Failed: ' . $e->getMessage()], 500);
        }
    }
}
