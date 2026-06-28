<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BdCourierFraudService
{
    private const BASE_URL = 'https://api.bdcourier.com';

    public function check(string $phone): ?array
    {
        $apiKey = SiteSetting::get('bdcourier_api_key');
        if (!$apiKey) return null;

        // Normalize: strip +880/880 prefix, ensure leading 0
        $normalized = preg_replace('/^\+?880/', '0', trim($phone));

        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Accept'        => 'application/json',
                ])
                ->get(self::BASE_URL . '/courier-check', [
                    'phone' => $normalized,
                ]);

            $json = $response->json();

            if (($json['status'] ?? '') !== 'success') {
                return null; // phone not found or API error
            }

            $summary  = $json['summary']  ?? [];
            $couriers = $json['data']     ?? [];   // per-courier breakdown
            $reports  = $json['reports']  ?? [];   // fraud reports

            // Build clean couriers array
            $courierList = [];
            foreach ($couriers as $key => $c) {
                if (!is_array($c)) continue;
                $courierList[] = [
                    'key'       => $key,
                    'name'      => $c['name']             ?? ucfirst($key),
                    'logo'      => $c['logo']             ?? null,
                    'total'     => (int)   ($c['total_parcel']    ?? 0),
                    'cancelled' => (int)   ($c['cancelled_parcel']?? 0),
                    'ratio'     => (float) ($c['success_ratio']   ?? 0),
                ];
            }

            // Build clean reports array
            $reportList = [];
            foreach ($reports as $r) {
                if (!is_array($r)) continue;
                $reportList[] = [
                    'id'       => $r['id']            ?? null,
                    'name'     => $r['name']          ?? 'Unknown',
                    'remark'   => $r['remark']        ?? '',
                    'merchant' => $r['merchant_name'] ?? '',
                    'date'     => $r['created_at']    ?? '',
                ];
            }

            return [
                'success_ratio' => (float) ($summary['success_ratio']   ?? 0),
                'total_parcels' => (int)   ($summary['total_parcel']    ?? 0),
                'cancelled'     => (int)   ($summary['cancelled_parcel']?? 0),
                'fraud_reports' => count($reportList),
                'couriers'      => $courierList,
                'reports'       => $reportList,
            ];
        } catch (\Throwable $e) {
            Log::warning('BD Courier check failed for ' . $phone . ': ' . $e->getMessage());
            return null;
        }
    }

    public static function isEnabled(): bool
    {
        return !empty(SiteSetting::get('bdcourier_api_key'));
    }

    public static function minSuccessRatio(): float
    {
        return (float) SiteSetting::get('bdcourier_min_success_ratio', '0');
    }
}
