<?php

namespace App\Support;

class Money
{
    public static function format($amount): string
    {
        return '৳' . number_format((float) $amount, 2);
    }
}
