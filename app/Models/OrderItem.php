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
        'cost_price',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'unit_price' => 'decimal:2',
            'cost_price' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    /**
     * Snapshot the product's purchase price when the line is created, so the
     * profit of this sale stays correct even if the purchase price changes later.
     */
    protected static function booted(): void
    {
        static::creating(function (OrderItem $item) {
            if ($item->cost_price === null && $item->product_id) {
                $item->cost_price = (float) (Product::whereKey($item->product_id)->value('purchase_price') ?? 0);
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
