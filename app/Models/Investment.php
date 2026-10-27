<?php

namespace App\Models;

/**
 * Money put into the business (shop setup, equipment…). Not an expense, so it
 * does not reduce profit. Stock bought from suppliers is not entered here —
 * it comes from Purchases automatically.
 */
class Investment extends LedgerEntry
{
    public static function dateColumn(): string
    {
        return 'invest_date';
    }

    public static function categories(): array
    {
        return [
            'capital'     => 'Owner Capital',
            'shop_setup'  => 'Shop Setup & Decoration',
            'equipment'   => 'Equipment & Furniture',
            'website'     => 'Website & Software',
            'deposit'     => 'Shop Advance / Deposit',
            'marketing'   => 'Brand / Launch Marketing',
            'other'       => 'Other',
        ];
    }
}
