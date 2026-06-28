<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class SteadfastService
{
    private const BASE_URL = 'https://portal.packzy.com/api/v1';

    private string $apiKey;
    private string $secretKey;

    public function __construct()
    {
        $settings = SiteSetting::pluck('value', 'key');
        $this->apiKey    = $settings->get('steadfast_api_key', '');
        $this->secretKey = $settings->get('steadfast_secret_key', '');
    }

    public function isConfigured(): bool
    {
        return !empty($this->apiKey) && !empty($this->secretKey);
    }

    public function placeOrder(array $payload): array
    {
        try {
            $response = $this->http()->post('/create_order', $payload);
            return $this->parse($response);
        } catch (ConnectionException $e) {
            return $this->connectionError($e);
        }
    }

    public function statusByConsignmentId(string $consignmentId): array
    {
        try {
            $response = $this->http()->get("/status_by_cid/{$consignmentId}");
            return $this->parse($response);
        } catch (ConnectionException $e) {
            return $this->connectionError($e);
        }
    }

    public function statusByInvoice(string $invoice): array
    {
        try {
            $response = $this->http()->get("/status_by_invoice/{$invoice}");
            return $this->parse($response);
        } catch (ConnectionException $e) {
            return $this->connectionError($e);
        }
    }

    public function getBalance(): array
    {
        try {
            $response = $this->http()->get('/get_balance');
            return $this->parse($response);
        } catch (ConnectionException $e) {
            return $this->connectionError($e);
        }
    }

    private function http()
    {
        return Http::baseUrl(self::BASE_URL)
            ->withHeaders([
                'Api-Key'      => $this->apiKey,
                'Secret-Key'   => $this->secretKey,
                'Content-Type' => 'application/json',
            ])
            ->timeout(15)
            ->acceptJson();
    }

    private function parse(Response $response): array
    {
        $data = $response->json() ?? [];
        $data['_http_status'] = $response->status();
        $data['_ok'] = $response->successful();
        return $data;
    }

    private function connectionError(ConnectionException $e): array
    {
        return [
            '_ok'          => false,
            '_http_status' => 0,
            'message'      => 'Cannot connect to Steadfast: ' . $e->getMessage(),
        ];
    }
}
