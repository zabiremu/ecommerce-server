<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GRNReturnItem extends Model
{
    protected $table = 'grn_return_items';

    protected $fillable = [
        'grn_return_id',
        'grn_item_id',
        'product_id',
        'product_name',
        'received_qty',
        'return_qty',
        'unit_cost',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'received_qty' => 'decimal:2',
            'return_qty'   => 'decimal:2',
            'unit_cost'    => 'decimal:2',
            'total'        => 'decimal:2',
        ];
    }

    public function grnReturn()
    {
        return $this->belongsTo(GRNReturn::class);
    }

    public function grnItem()
    {
        return $this->belongsTo(GRNItem::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
