<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Warehouse extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'address',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Warehouse $warehouse) {
            if (empty($warehouse->slug)) {
                $warehouse->slug = Str::slug($warehouse->name);
            }
        });
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_warehouse')
            ->withPivot('stock')
            ->withTimestamps();
    }
}
