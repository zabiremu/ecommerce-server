<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order) {}

    public function envelope(): Envelope
    {
        $shop = \App\Models\SiteSetting::get('company_name', 'NF Shop 24');
        return new Envelope(
            subject: '✅ Order Confirmed #' . $this->order->order_no . ' — ' . $shop,
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.order-confirmation');
    }
}
