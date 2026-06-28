<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrustItem extends Model
{
    protected $fillable = [
        'icon',
        'title',
        'description',
        'sort_order',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
