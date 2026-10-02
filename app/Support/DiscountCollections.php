<?php

namespace App\Support;

use App\Models\Product;

/**
 * Dynamic discount collections ("20% OFF", "30% OFF", "Clearance Sale", ...).
 *
 * Nothing is stored: a product's discount percent is derived from its regular
 * price vs. sale price, so changing a product's price in the admin panel
 * automatically moves it between collections (and drops it out when the sale
 * price is removed). The "Clearance Sale" collection reuses the existing
 * "Clearance" special-section tag.
 */
class DiscountCollections
{
    public const CLEARANCE_KEY = 'clearance-sale';

    /** URL key for a percentage collection, e.g. 20 => "20-off". */
    public static function keyForPercent(int $percent): string
    {
        return $percent . '-off';
    }

    /**
     * Every collection that currently has at least one published product,
     * biggest discount first, Clearance Sale last.
     *
     * @return array<int, array{key:string,label:string,emoji:string,percent:?int,count:int,url:string}>
     */
    public static function all(): array
    {
        // Same result is needed by the nav, the homepage strip and the
        // listing page within one request — only hit the database once.
        return self::$memo ??= self::build();
    }

    /** @var array|null */
    protected static ?array $memo = null;

    protected static function build(): array
    {
        $collections = [];

        $byPercent = Product::published()
            ->whereNotNull('sale_price')
            ->where('sale_price', '>', 0)
            ->whereColumn('sale_price', '<', 'selling_price')
            ->where('selling_price', '>', 0)
            ->get(['selling_price', 'sale_price'])
            ->map(fn (Product $p) => $p->discountPercent())
            ->filter(fn ($pct) => $pct >= 1)
            ->countBy()
            ->sortKeysDesc();

        foreach ($byPercent as $percent => $count) {
            $key = self::keyForPercent((int) $percent);
            $collections[] = [
                'key'     => $key,
                'label'   => $percent . '% OFF',
                'emoji'   => '🔥',
                'percent' => (int) $percent,
                'count'   => $count,
                'url'     => route('offers', ['collection' => $key]),
            ];
        }

        $clearanceCount = Product::published()
            ->whereJsonContains('special_sections', 'clearance')
            ->count();

        if ($clearanceCount > 0) {
            $collections[] = [
                'key'     => self::CLEARANCE_KEY,
                'label'   => 'Clearance Sale',
                'emoji'   => '🔥',
                'percent' => null,
                'count'   => $clearanceCount,
                'url'     => route('offers', ['collection' => self::CLEARANCE_KEY]),
            ];
        }

        return $collections;
    }

    /** Find one collection by its URL key, or null when it is empty/unknown. */
    public static function find(?string $key): ?array
    {
        if (!$key) {
            return null;
        }

        foreach (self::all() as $collection) {
            if ($collection['key'] === $key) {
                return $collection;
            }
        }

        return null;
    }
}
