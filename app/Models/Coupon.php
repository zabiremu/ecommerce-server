<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public const TYPES = ['percentage', 'fixed'];

    protected $fillable = [
        'code',
        'description',
        'type',
        'amount',
        'minimum_spend',
        'maximum_discount',
        'usage_limit',
        'usage_limit_per_customer',
        'used_count',
        'free_shipping',
        'individual_use_only',
        'exclude_sale_items',
        'starts_at',
        'expires_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'minimum_spend' => 'decimal:2',
            'maximum_discount' => 'decimal:2',
            'usage_limit' => 'integer',
            'usage_limit_per_customer' => 'integer',
            'used_count' => 'integer',
            'free_shipping' => 'boolean',
            'individual_use_only' => 'boolean',
            'exclude_sale_items' => 'boolean',
            'starts_at' => 'date',
            'expires_at' => 'date',
            'status' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->lt(Carbon::today());
    }

    public function isScheduled(): bool
    {
        return $this->starts_at && $this->starts_at->gt(Carbon::today());
    }

    public function isExhausted(): bool
    {
        return $this->usage_limit && $this->used_count >= $this->usage_limit;
    }

    public function isUsable(): bool
    {
        return $this->status
            && !$this->isExpired()
            && !$this->isScheduled()
            && !$this->isExhausted();
    }

    public function statusLabel(): string
    {
        if (!$this->status) return 'inactive';
        if ($this->isExpired())   return 'expired';
        if ($this->isScheduled()) return 'scheduled';
        if ($this->isExhausted()) return 'exhausted';
        return 'active';
    }

    /**
     * Calculate the discount this coupon would grant on a given subtotal.
     */
    public function discountFor(float $subtotal): float
    {
        if ((float) $this->minimum_spend > 0 && $subtotal < (float) $this->minimum_spend) {
            return 0;
        }

        $discount = $this->type === 'percentage'
            ? round($subtotal * ((float) $this->amount / 100), 2)
            : (float) $this->amount;

        if ((float) $this->maximum_discount > 0 && $discount > (float) $this->maximum_discount) {
            $discount = (float) $this->maximum_discount;
        }

        return min($discount, $subtotal);
    }
}
