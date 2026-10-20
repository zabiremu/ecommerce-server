<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $fillable = [
        'account_category_id', 'title', 'amount', 'investment_date',
        'payment_method', 'note', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'amount'          => 'decimal:2',
            'investment_date' => 'date',
        ];
    }

    public function category()
    {
        return $this->belongsTo(AccountCategory::class, 'account_category_id');
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
