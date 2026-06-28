<?php

namespace App\Services;

use App\Models\Order;

class PhoneAnalysisService
{
    // Bangladesh operator prefixes (first 3 digits after country code: 01X)
    private const OPERATORS = [
        '011' => ['name' => 'Teletalk',     'color' => '#16a34a'],
        '013' => ['name' => 'GrameenPhone', 'color' => '#2563eb'],
        '014' => ['name' => 'Banglalink',   'color' => '#dc2626'],
        '015' => ['name' => 'Teletalk',     'color' => '#16a34a'],
        '016' => ['name' => 'Airtel/Robi',  'color' => '#7c3aed'],
        '017' => ['name' => 'GrameenPhone', 'color' => '#2563eb'],
        '018' => ['name' => 'Robi',         'color' => '#ea580c'],
        '019' => ['name' => 'Banglalink',   'color' => '#dc2626'],
    ];

    public function analyze(string $rawPhone): array
    {
        $score = 0;
        $flags = [];
        $patternDetails = [];

        // Normalize to local format: 01XXXXXXXXX
        $phone = preg_replace('/^\+?880/', '0', trim($rawPhone));
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // ── 1. Format validation ──────────────────────────────────────────
        $isValid = (bool) preg_match('/^01[3-9]\d{8}$/', $phone)
                || (bool) preg_match('/^011\d{8}$/', $phone);

        if (!$isValid) {
            $score += 40;
            $flags[] = 'Invalid Bangladesh phone number format';
            $patternDetails[] = ['type' => 'format', 'label' => 'Invalid format', 'severity' => 'high'];
        }

        // ── 2. Operator detection ─────────────────────────────────────────
        $prefix = substr($phone, 0, 3);
        $operatorInfo = self::OPERATORS[$prefix] ?? null;
        $operatorName = $operatorInfo ? $operatorInfo['name'] : ($isValid ? 'Unknown' : 'Invalid');

        // ── 3. Digit pattern analysis ─────────────────────────────────────
        if (strlen($phone) >= 10) {
            $digits     = str_split($phone);
            $trunkPart  = substr($phone, 2); // strip leading "01", analyze remaining 9 digits
            $trunkDigits = str_split($trunkPart);

            // All same digits in the trunk
            if (count(array_unique($trunkDigits)) === 1) {
                $score += 70;
                $flags[] = 'All digits identical (' . $trunkDigits[0] . ' × ' . strlen($trunkPart) . ')';
                $patternDetails[] = ['type' => 'identical', 'label' => 'All identical digits', 'severity' => 'very_high'];
            }
            // Sequential ascending: 1234567890
            elseif ($this->isSequential($trunkDigits, 1)) {
                $score += 60;
                $flags[] = 'Sequential ascending digits (e.g. 123456789)';
                $patternDetails[] = ['type' => 'sequential_asc', 'label' => 'Sequential ascending', 'severity' => 'high'];
            }
            // Sequential descending: 9876543210
            elseif ($this->isSequential($trunkDigits, -1)) {
                $score += 60;
                $flags[] = 'Sequential descending digits (e.g. 987654321)';
                $patternDetails[] = ['type' => 'sequential_desc', 'label' => 'Sequential descending', 'severity' => 'high'];
            }
            // Repeating pair: 121212, 010101
            elseif ($this->isRepeatingPair($trunkDigits)) {
                $score += 45;
                $flags[] = 'Repeating two-digit pattern detected';
                $patternDetails[] = ['type' => 'repeating_pair', 'label' => 'Repeating pair pattern', 'severity' => 'high'];
            }
            // Mirror/palindrome: 12344321
            elseif ($this->isPalindrome($trunkDigits)) {
                $score += 35;
                $flags[] = 'Palindrome/mirror digit pattern';
                $patternDetails[] = ['type' => 'palindrome', 'label' => 'Palindrome pattern', 'severity' => 'medium'];
            }
            else {
                // High concentration of one digit (≥ 6 out of 9)
                $counts = array_count_values($trunkDigits);
                arsort($counts);
                $topDigit = array_key_first($counts);
                $topCount = $counts[$topDigit];

                if ($topCount >= 7) {
                    $score += 40;
                    $flags[] = "Digit '{$topDigit}' appears {$topCount}/9 times";
                    $patternDetails[] = ['type' => 'high_repeat', 'label' => "'{$topDigit}' repeated {$topCount}×", 'severity' => 'high'];
                } elseif ($topCount >= 5) {
                    $score += 15;
                    $flags[] = "Digit '{$topDigit}' appears {$topCount}/9 times (suspicious)";
                    $patternDetails[] = ['type' => 'moderate_repeat', 'label' => "'{$topDigit}' repeated {$topCount}×", 'severity' => 'low'];
                }
            }

            // Trailing zeros (last 4+ of full number)
            if (str_ends_with($phone, '0000')) {
                $score += 20;
                $flags[] = 'Ends in 4+ zeros (round number pattern)';
                $patternDetails[] = ['type' => 'trailing_zeros', 'label' => 'Trailing zeros', 'severity' => 'medium'];
            }

            // All zeros in trunk
            if (ltrim($trunkPart, '0') === '') {
                $score += 60;
                $flags[] = 'All-zero trunk digits';
                $patternDetails[] = ['type' => 'all_zeros', 'label' => 'All zeros', 'severity' => 'very_high'];
            }
        }

        // ── 4. Order history signals ──────────────────────────────────────
        $phones  = array_unique([$rawPhone, $phone]);
        $history = Order::whereIn('shipping_phone', $phones)->get();

        $totalOrders    = $history->count();
        $cancelledCount = $history->where('status', 'cancelled')->count();
        $returnedCount  = $history->where('status', 'returned')->count();
        $deliveredCount = $history->where('status', 'delivered')->count();

        // Different names used with this phone
        $uniqueNames = $history->pluck('shipping_name')
            ->map(fn ($n) => mb_strtolower(trim($n)))
            ->filter()
            ->unique()
            ->count();

        if ($uniqueNames >= 5) {
            $score += 35;
            $flags[] = "{$uniqueNames} different customer names used with this phone";
            $patternDetails[] = ['type' => 'multi_name', 'label' => "{$uniqueNames} names", 'severity' => 'high'];
        } elseif ($uniqueNames >= 3) {
            $score += 20;
            $flags[] = "{$uniqueNames} different names used with this phone";
            $patternDetails[] = ['type' => 'multi_name', 'label' => "{$uniqueNames} names", 'severity' => 'medium'];
        }

        // High cancel rate
        if ($totalOrders >= 3) {
            $badOrders = $cancelledCount + $returnedCount;
            $rate = $badOrders / $totalOrders;
            if ($rate >= 0.7) {
                $score += 30;
                $flags[] = round($rate * 100) . '% cancel/return rate (' . $badOrders . '/' . $totalOrders . ')';
            } elseif ($rate >= 0.4) {
                $score += 15;
                $flags[] = round($rate * 100) . '% cancel/return rate (' . $badOrders . '/' . $totalOrders . ')';
            }
        }

        $score = min(100, $score);
        $chance = $this->chanceLabel($score);
        $colors = $this->chanceColors($score);

        return [
            'raw'             => $rawPhone,
            'normalized'      => $phone,
            'is_valid'        => $isValid,
            'operator'        => $operatorName,
            'operator_color'  => $operatorInfo['color'] ?? '#64748b',
            'fake_score'      => $score,
            'fake_chance'     => $chance,
            'bg'              => $colors['bg'],
            'fg'              => $colors['fg'],
            'flags'           => $flags,
            'pattern_details' => $patternDetails,
            'history'         => [
                'total'     => $totalOrders,
                'cancelled' => $cancelledCount,
                'returned'  => $returnedCount,
                'delivered' => $deliveredCount,
                'names'     => $uniqueNames,
            ],
        ];
    }

    // ── Helpers ───────────────────────────────────────────────────────────

    private function isSequential(array $digits, int $step): bool
    {
        if (count($digits) < 3) return false;
        for ($i = 1; $i < count($digits); $i++) {
            if ((int)$digits[$i] - (int)$digits[$i - 1] !== $step) return false;
        }
        return true;
    }

    private function isRepeatingPair(array $digits): bool
    {
        if (count($digits) < 6) return false;
        $pair = [$digits[0], $digits[1]];
        for ($i = 2; $i < count($digits) - 1; $i += 2) {
            if ($digits[$i] !== $pair[0] || $digits[$i + 1] !== $pair[1]) return false;
        }
        return $pair[0] !== $pair[1]; // exclude all-same (caught earlier)
    }

    private function isPalindrome(array $digits): bool
    {
        if (count($digits) < 6) return false;
        $half = intdiv(count($digits), 2);
        for ($i = 0; $i < $half; $i++) {
            if ($digits[$i] !== $digits[count($digits) - 1 - $i]) return false;
        }
        return true;
    }

    private function chanceLabel(int $score): string
    {
        if ($score >= 70) return 'Very High';
        if ($score >= 45) return 'High';
        if ($score >= 20) return 'Medium';
        return 'Low';
    }

    private function chanceColors(int $score): array
    {
        if ($score >= 70) return ['bg' => '#fee2e2', 'fg' => '#991b1b'];
        if ($score >= 45) return ['bg' => '#fef3c7', 'fg' => '#b45309'];
        if ($score >= 20) return ['bg' => '#fefce8', 'fg' => '#854d0e'];
        return ['bg' => '#f0fdf4', 'fg' => '#15803d'];
    }

    // Static helper for quick badge rendering in views
    public static function scoreBadge(int $score): array
    {
        if ($score >= 70) return ['label' => 'Very High Risk', 'bg' => '#fee2e2', 'fg' => '#991b1b'];
        if ($score >= 45) return ['label' => 'High Risk',      'bg' => '#fef3c7', 'fg' => '#b45309'];
        if ($score >= 20) return ['label' => 'Medium Risk',    'bg' => '#fefce8', 'fg' => '#854d0e'];
        return                   ['label' => 'Low Risk',       'bg' => '#f0fdf4', 'fg' => '#15803d'];
    }
}
