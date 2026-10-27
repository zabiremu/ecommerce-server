<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'variant_id',
        'product_name',
        'variant_label',
        'product_sku',
        'variant_sku',
        'thumbnail',
        'quantity',
        'unit_price',
        'unit_cost',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'unit_price' => 'decimal:2',
            'unit_cost' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        // Snapshot the purchase price at the time of sale so later price
        // changes don't rewrite past profit.
        static::creating(function (OrderItem $item) {
            if ($item->unit_cost === null && $item->product_id) {
                $item->unit_cost = Product::whereKey($item->product_id)->value('purchase_price');
            }
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
