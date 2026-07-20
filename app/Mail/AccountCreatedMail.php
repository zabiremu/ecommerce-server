<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $plainPassword,
        public string $orderNo,
    ) {}

    public function envelope(): Envelope
    {
        $shop = \App\Models\SiteSetting::get('company_name', 'ROVENTEX');
        return new Envelope(
            subject: 'Your ' . $shop . ' account has been created',
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.account-created');
    }
}
