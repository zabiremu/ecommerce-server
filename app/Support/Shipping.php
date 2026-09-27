<?php

namespace App\Support;

use App\Models\SiteSetting;

/**
 * Store-wide delivery charges, managed from Admin → Site Settings → Shipping.
 *
 * Two zones (inside / outside the home city). Labels and charges are editable
 * so the shop can move cities without a code change. A free-shipping
 * threshold of 0 (the default) means "never free" — only a free-shipping
 * coupon makes delivery free.
 */
class Shipping
{
    public const ZONES = ['inside', 'outside'];

    public static function charge(string $zone): float
    {
        return $zone === 'outside'
            ? (float) SiteSetting::get('shipping_outside_charge', '150')
            : (float) SiteSetting::get('shipping_inside_charge', '100');
    }

    public static function label(string $zone): string
    {
        return $zone === 'outside'
            ? SiteSetting::get('shipping_outside_label', 'Outside Chittagong')
            : SiteSetting::get('shipping_inside_label', 'Inside Chittagong');
    }

    public static function freeMin(): float
    {
        return (float) SiteSetting::get('shipping_free_min', '0');
    }

    /** Final charge for an order, after free-shipping rules. */
    public static function calculate(float $subtotal, string $zone, bool $freeCoupon = false): float
    {
        if ($freeCoupon) {
            return 0.0;
        }
        $min = self::freeMin();
        if ($min > 0 && $subtotal >= $min) {
            return 0.0;
        }
        return self::charge($zone);
    }

    /** Zone list for the storefront (cart / checkout selectors). */
    public static function zones(): array
    {
        return array_map(fn ($z) => [
            'key'    => $z,
            'label'  => self::label($z),
            'charge' => self::charge($z),
        ], self::ZONES);
    }
}
