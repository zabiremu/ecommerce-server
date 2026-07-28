<?php

namespace App\Support;

class Money
{
    public static function format($amount): string
    {
        return '৳' . number_format((float) $amount, 2);
    }

    /**
     * Same formatting, but drops a trailing ".00" for round amounts
     * (e.g. ৳638 instead of ৳638.00). Used in compact contexts like
     * product cards; amounts with real cents still show them (৳638.50).
     */
    public static function formatShort($amount): string
    {
        $formatted = number_format((float) $amount, 2);

        if (str_ends_with($formatted, '.00')) {
            $formatted = substr($formatted, 0, -3);
        }

        return '৳' . $formatted;
    }
}
