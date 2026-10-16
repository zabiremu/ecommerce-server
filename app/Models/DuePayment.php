<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** One collection of money against a customer's due (credit) POS sale. */
class DuePayment extends Model
{
    protected $fillable = [
        'customer_id',
        'order_id',
        'amount',
        'payment_method',
        'note',
        'received_by',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount'  => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function receivedBy()
    {
        return $this->belongsTo(Admin::class, 'received_by');
    }
}
