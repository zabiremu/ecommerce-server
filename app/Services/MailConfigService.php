<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Config;

class MailConfigService
{
    /**
     * Read mail credentials from SiteSetting and apply them to Laravel's
     * runtime config, then flush the resolved mail manager so the next
     * Mail:: call picks up the fresh configuration.
     */
    public static function apply(): void
    {
        $s = SiteSetting::pluck('value', 'key');

        $mailer     = $s->get('mail_mailer')     ?: 'smtp';
        $host       = $s->get('mail_host')       ?: '';
        $port       = (int) ($s->get('mail_port') ?: 587);
        $username   = $s->get('mail_username')   ?: '';
        $password   = $s->get('mail_password')   ?: '';
        $encryption = $s->get('mail_encryption') ?: 'tls';
        $fromAddr   = $s->get('mail_from_address') ?: config('mail.from.address', '');
        $fromName   = $s->get('mail_from_name')    ?: config('mail.from.name', 'NF Shop 24');

        Config::set('mail.default', $mailer);
        Config::set('mail.mailers.smtp.host',       $host);
        Config::set('mail.mailers.smtp.port',       $port);
        Config::set('mail.mailers.smtp.username',   $username);
        Config::set('mail.mailers.smtp.password',   $password);
        Config::set('mail.mailers.smtp.encryption', $encryption ?: null);
        Config::set('mail.from.address',            $fromAddr);
        Config::set('mail.from.name',               $fromName);

        // Flush the resolved singleton so Laravel rebuilds the transport
        // with the new config on the next Mail:: call.
        app()->forgetInstance('mail.manager');
        app()->forgetInstance('mailer');
    }

    public static function isConfigured(): bool
    {
        $host = SiteSetting::get('mail_host', '');
        $key  = SiteSetting::get('mail_username', '');
        return $host !== '' && $key !== '';
    }
}
