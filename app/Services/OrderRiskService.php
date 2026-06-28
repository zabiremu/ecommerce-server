<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderRiskService
{
    public function calculate(string $phone, float $total, Request $request, ?float $recaptchaScore = null): array
    {
        $score = 0;
        $flags = [];

        $history = Order::where('shipping_phone', $phone)
            ->whereNotNull('placed_at')
            ->get();

        // Previously cancelled orders
        $cancelled = $history->where('status', 'cancelled')->count();
        if ($cancelled >= 3) {
            $score += 45;
            $flags[] = "{$cancelled} cancelled order(s) from this phone";
        } elseif ($cancelled >= 1) {
            $score += $cancelled * 20;
            $flags[] = "{$cancelled} cancelled order(s) from this phone";
        }

        // Previously returned orders
        $returned = $history->where('status', 'returned')->count();
        if ($returned >= 2) {
            $score += 30;
            $flags[] = "{$returned} returned order(s) from this phone";
        } elseif ($returned === 1) {
            $score += 15;
            $flags[] = "1 returned order from this phone";
        }

        // High cancellation rate (>50% with at least 4 orders)
        $total_orders = $history->count();
        if ($total_orders >= 4) {
            $cancel_rate = ($cancelled + $returned) / $total_orders;
            if ($cancel_rate > 0.5) {
                $score += 20;
                $flags[] = round($cancel_rate * 100) . '% cancel/return rate';
            }
        }

        // Too many orders in last 24 hours from same phone
        $recentCount = Order::where('shipping_phone', $phone)
            ->where('placed_at', '>=', now()->subHours(24))
            ->count();
        if ($recentCount >= 3) {
            $score += 35;
            $flags[] = "{$recentCount} orders in the last 24 hours from this phone";
        }

        // Too many orders from same IP in last hour
        $ip = $request->ip();
        $ipCount = Order::where('ip_address', $ip)
            ->where('placed_at', '>=', now()->subHour())
            ->count();
        if ($ipCount >= 4) {
            $score += 30;
            $flags[] = "{$ipCount} orders from IP {$ip} in the last hour";
        }

        // Invalid BD phone number format
        if (!preg_match('/^(\+?880|0)(1[3-9]\d{8})$/', $phone)) {
            $score += 25;
            $flags[] = 'Phone number does not match BD format';
        }

        // Low reCAPTCHA score (likely bot/automated)
        if ($recaptchaScore !== null && $recaptchaScore < 0.5) {
            $add = $recaptchaScore < 0.3 ? 30 : 15;
            $score += $add;
            $flags[] = 'Low reCAPTCHA score (' . $recaptchaScore . ') — possible bot';
        }

        return [
            'score' => min($score, 100),
            'flags' => $flags,
            'level' => $score >= 70 ? 'high' : ($score >= 35 ? 'medium' : 'low'),
        ];
    }

    public static function badge(int $score): array
    {
        if ($score >= 70) {
            return ['label' => 'High Risk', 'bg' => '#fee2e2', 'fg' => '#b91c1c', 'icon' => 'fas fa-triangle-exclamation'];
        }
        if ($score >= 35) {
            return ['label' => 'Medium Risk', 'bg' => '#fef3c7', 'fg' => '#92400e', 'icon' => 'fas fa-circle-exclamation'];
        }
        return ['label' => 'Low Risk', 'bg' => '#d1fae5', 'fg' => '#065f46', 'icon' => 'fas fa-shield-check'];
    }
}
