<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $customerName,
        public string $customerEmail,
        public string $orderNo,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to ' . \App\Models\SiteSetting::get('company_name', 'NF Shop 24') . '! 🎉',
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.welcome');
    }
}
