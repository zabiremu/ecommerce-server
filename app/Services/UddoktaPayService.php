<?php

namespace App\Services;

use App\Models\Order;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UddoktaPayService
{
    private string $apiKey;
    private string $apiUrl;

    public function __construct()
    {
        $this->apiKey = SiteSetting::get('uddoktapay_api_key', config('uddoktapay.api_key', ''));
        $this->apiUrl = rtrim(
            SiteSetting::get('uddoktapay_api_url', config('uddoktapay.api_url', 'https://sandbox.uddoktapay.com/api')),
            '/'
        );
    }

    public function createCharge(Order $order): array
    {
        $email = $order->shipping_email
            ?: preg_replace('/[^a-z0-9]/', '', strtolower($order->shipping_phone)) . '@customer.nfshop24.com';

        $payload = [
            'full_name'    => $order->shipping_name,
            'email'        => $email,
            'amount'       => number_format((float) $order->total, 2, '.', ''),
            'metadata'     => [
                'order_no'  => $order->order_no,
                'order_id'  => $order->id,
            ],
            'redirect_url' => route('uddoktapay.callback'),
            'return_type'  => 'GET',
            'cancel_url'   => route('uddoktapay.cancel') . '?order=' . $order->order_no,
            'webhook_url'  => route('uddoktapay.webhook'),
        ];

        $response = Http::withHeaders([
            'RT-UDDOKTAPAY-API-KEY' => $this->apiKey,
            'Content-Type'          => 'application/json',
            'Accept'                => 'application/json',
        ])->post($this->apiUrl . '/checkout-v2', $payload);

        if (!$response->successful()) {
            Log::error('UddoktaPay createCharge failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
                'order'  => $order->order_no,
            ]);
            throw new \RuntimeException('UddoktaPay payment initiation failed: ' . $response->body());
        }

        return $response->json();
    }

    public function verifyPayment(string $invoiceId): array
    {
        $response = Http::withHeaders([
            'RT-UDDOKTAPAY-API-KEY' => $this->apiKey,
            'Content-Type'          => 'application/json',
            'Accept'                => 'application/json',
        ])->post($this->apiUrl . '/verify-payment', [
            'invoice_id' => $invoiceId,
        ]);

        if (!$response->successful()) {
            Log::error('UddoktaPay verifyPayment failed', [
                'invoice_id' => $invoiceId,
                'status'     => $response->status(),
                'body'       => $response->body(),
            ]);
            throw new \RuntimeException('UddoktaPay payment verification failed.');
        }

        return $response->json();
    }
}
