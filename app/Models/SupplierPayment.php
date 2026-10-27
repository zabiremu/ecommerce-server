<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** One payment made to a supplier, optionally against a specific purchase. */
class SupplierPayment extends Model
{
    public const METHODS = ['cash', 'bkash', 'nagad', 'rocket', 'card', 'bank'];

    protected $fillable = [
        'supplier_id',
        'purchase_id',
        'amount',
        'payment_method',
        'note',
        'paid_by',
        'paid_on',
    ];

    protected function casts(): array
    {
        return [
            'amount'  => 'decimal:2',
            'paid_on' => 'date',
        ];
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function paidBy()
    {
        return $this->belongsTo(Admin::class, 'paid_by');
    }
}
