<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const STATUSES = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'returned'];
    public const PAYMENT_METHODS = ['cod', 'bkash', 'nagad', 'rocket', 'bank', 'uddoktapay'];
    public const PAYMENT_STATUSES = ['unpaid', 'paid', 'refunded'];

    protected $fillable = [
        'order_no',
        'customer_id',
        'shipping_name',
        'shipping_phone',
        'shipping_email',
        'shipping_address',
        'shipping_city',
        'shipping_area',
        'subtotal',
        'shipping_charge',
        'discount',
        'total',
        'payment_method',
        'payment_status',
        'status',
        'notes',
        'admin_notes',
        'stock_deducted',
        'placed_at',
        'steadfast_consignment_id',
        'steadfast_tracking_code',
        'steadfast_status',
        'steadfast_sent_at',
        'uddoktapay_invoice_id',
        'ip_address',
        'risk_score',
        'risk_flags',
        'bdcourier_success_ratio',
        'bdcourier_total_parcels',
        'bdcourier_fraud_reports',
        'bdcourier_data',
    ];

    protected function casts(): array
    {
        return [
            'subtotal'         => 'decimal:2',
            'shipping_charge'  => 'decimal:2',
            'discount'         => 'decimal:2',
            'total'            => 'decimal:2',
            'stock_deducted'   => 'boolean',
            'placed_at'        => 'datetime',
            'steadfast_sent_at' => 'datetime',
        'risk_flags'      => 'array',
        'bdcourier_data'  => 'array',
        ];

    }

    public function isSentToSteadfast(): bool
    {
        return !is_null($this->steadfast_consignment_id);
    }

    public static function steadfastStatusBadge(string $status): string
    {
        return [
            'in_review'                          => 'bg-yellow-100 text-yellow-800',
            'pending'                            => 'bg-orange-100 text-orange-800',
            'delivered'                          => 'bg-emerald-100 text-emerald-800',
            'delivered_approval_pending'         => 'bg-teal-100 text-teal-800',
            'partial_delivered'                  => 'bg-cyan-100 text-cyan-800',
            'partial_delivered_approval_pending' => 'bg-cyan-100 text-cyan-800',
            'cancelled'                          => 'bg-red-100 text-red-800',
            'cancelled_approval_pending'         => 'bg-red-100 text-red-800',
            'hold'                               => 'bg-gray-200 text-gray-700',
            'unknown'                            => 'bg-gray-100 text-gray-600',
            'unknown_approval_pending'           => 'bg-gray-100 text-gray-600',
        ][$status] ?? 'bg-gray-100 text-gray-600';
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function statusBadgeClass(string $status): string
    {
        return [
            'pending'    => 'bg-amber-100 text-amber-800',
            'confirmed'  => 'bg-blue-100 text-blue-800',
            'processing' => 'bg-indigo-100 text-indigo-800',
            'shipped'    => 'bg-cyan-100 text-cyan-800',
            'delivered'  => 'bg-emerald-100 text-emerald-800',
            'cancelled'  => 'bg-red-100 text-red-800',
            'returned'   => 'bg-gray-200 text-gray-800',
        ][$status] ?? 'bg-gray-100 text-gray-700';
    }

    public static function paymentBadgeClass(string $status): string
    {
        return [
            'unpaid'   => 'bg-orange-100 text-orange-800',
            'paid'     => 'bg-emerald-100 text-emerald-800',
            'refunded' => 'bg-purple-100 text-purple-800',
        ][$status] ?? 'bg-gray-100 text-gray-700';
    }
}
