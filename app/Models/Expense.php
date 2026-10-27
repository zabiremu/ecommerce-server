<?php

namespace App\Models;

/** A running cost of the business — subtracted when working out net profit. */
class Expense extends LedgerEntry
{
    public static function dateColumn(): string
    {
        return 'expense_date';
    }

    public static function categories(): array
    {
        return [
            'shop_rent'       => 'Shop Rent',
            'staff_salary'    => 'Staff Salary',
            'delivery_charge' => 'Delivery / Courier Charge',
            'utility'         => 'Utility Bills (Electricity, Internet)',
            'marketing'       => 'Marketing / Ads',
            'packaging'       => 'Packaging',
            'transport'       => 'Transport',
            'maintenance'     => 'Repair & Maintenance',
            'other'           => 'Other',
        ];
    }
}
