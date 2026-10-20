<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountCategory extends Model
{
    public const TYPE_EXPENSE    = 'expense';
    public const TYPE_INVESTMENT = 'investment';

    protected $fillable = ['type', 'name', 'status'];

    protected $casts = ['status' => 'boolean'];

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }
}
