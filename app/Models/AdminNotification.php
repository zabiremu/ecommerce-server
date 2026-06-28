<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    protected $fillable = ['type', 'title', 'message', 'link', 'read_at'];

    protected $casts = ['read_at' => 'datetime'];

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    // Icon + colour per type
    public static function meta(string $type): array
    {
        return match ($type) {
            'new_order'    => ['icon' => 'fa-cart-shopping',      'bg' => 'bg-emerald-100', 'fg' => 'text-emerald-600'],
            'low_stock'    => ['icon' => 'fa-triangle-exclamation','bg' => 'bg-amber-100',   'fg' => 'text-amber-600'],
            'new_customer' => ['icon' => 'fa-user-plus',           'bg' => 'bg-blue-100',    'fg' => 'text-blue-600'],
            default        => ['icon' => 'fa-bell',                'bg' => 'bg-slate-100',   'fg' => 'text-slate-600'],
        };
    }
}
