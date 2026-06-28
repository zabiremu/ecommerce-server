<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GRNReturn extends Model
{
    protected $table = 'grn_returns';

    protected $fillable = [
        'return_no',
        'goods_received_note_id',
        'supplier_id',
        'warehouse_id',
        'return_date',
        'reason',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'return_date' => 'date',
        ];
    }

    public function goodsReceivedNote()
    {
        return $this->belongsTo(GoodsReceivedNote::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function items()
    {
        return $this->hasMany(GRNReturnItem::class);
    }
}
