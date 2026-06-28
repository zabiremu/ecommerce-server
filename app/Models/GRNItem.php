<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GRNItem extends Model
{
    protected $table = 'grn_items';

    protected $fillable = [
        'goods_received_note_id',
        'purchase_item_id',
        'product_id',
        'product_name',
        'ordered_qty',
        'received_qty',
        'unit_cost',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'ordered_qty' => 'decimal:2',
            'received_qty' => 'decimal:2',
            'unit_cost' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function goodsReceivedNote()
    {
        return $this->belongsTo(GoodsReceivedNote::class);
    }

    public function purchaseItem()
    {
        return $this->belongsTo(PurchaseItem::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
