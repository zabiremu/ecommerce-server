<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'session_id',
        'ip_address',
        'user_agent',
        'contact_name',
        'contact_phone',
        'contact_email',
        'last_activity',
        'converted_at',
        'order_id',
    ];

    protected function casts(): array
    {
        return [
            'last_activity' => 'datetime',
            'converted_at'  => 'datetime',
        ];
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getEstimatedTotalAttribute(): float
    {
        return (float) $this->items->sum('total');
    }
}
