<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A money-out entry typed in by an admin: an Expense (running cost, reduces
 * profit) or an Investment (money put into the business, does not).
 */
abstract class LedgerEntry extends Model
{
    public const PAYMENT_METHODS = ['cash', 'bkash', 'nagad', 'rocket', 'card', 'bank'];

    /** Column holding the entry's (local) date. */
    abstract public static function dateColumn(): string;

    /** category key => label */
    abstract public static function categories(): array;

    protected function casts(): array
    {
        return [
            static::dateColumn() => 'date',
            'amount'             => 'decimal:2',
        ];
    }

    public function getFillable()
    {
        return [static::dateColumn(), 'category', 'title', 'amount', 'payment_method', 'note', 'created_by'];
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function getEntryDateAttribute()
    {
        return $this->{static::dateColumn()};
    }

    public function getCategoryLabelAttribute(): string
    {
        return static::categories()[$this->category] ?? ucwords(str_replace('_', ' ', (string) $this->category));
    }

    /** Entries dated between two local dates (inclusive, Y-m-d). */
    public function scopeBetweenDates($query, string $from, string $to)
    {
        return $query->whereBetween(static::dateColumn(), [$from, $to]);
    }
}
