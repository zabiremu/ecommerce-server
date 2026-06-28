<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'city',
        'area',
        'total_orders',
        'total_spent',
        'notes',
        'status',
        'last_order_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'total_orders' => 'integer',
            'total_spent' => 'decimal:2',
            'last_order_at' => 'datetime',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class)->orderByDesc('created_at');
    }

    public function recalculateStats(): void
    {
        $stats = $this->orders()
            ->reorder()
            ->whereNotIn('status', ['cancelled'])
            ->selectRaw('count(*) as cnt, coalesce(sum(total), 0) as spent, max(created_at) as last_at')
            ->first();

        $this->update([
            'total_orders' => (int) ($stats->cnt ?? 0),
            'total_spent'  => (float) ($stats->spent ?? 0),
            'last_order_at' => $stats->last_at,
        ]);
    }
}
