<?php

namespace Tests\Feature\Concerns;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

trait CreatesOrders
{
    protected function makeCustomer(array $overrides = []): Customer
    {
        return Customer::create(array_merge([
            'name'  => 'Jane Doe',
            'phone' => '017' . rand(10000000, 99999999),
        ], $overrides));
    }

    protected function makeOrderFor(Product $product, array $overrides = [], int $qty = 1): Order
    {
        $customer = $overrides['customer'] ?? $this->makeCustomer();
        unset($overrides['customer']);

        $unitPrice = (float) $product->selling_price;

        $order = Order::create(array_merge([
            'order_no'         => 'NF-TEST-' . uniqid(),
            'customer_id'      => $customer->id,
            'shipping_name'    => $customer->name,
            'shipping_phone'   => $customer->phone,
            'shipping_email'   => $customer->email,
            'shipping_address' => '123 Main St',
            'shipping_city'    => 'Dhaka',
            'subtotal'         => $unitPrice * $qty,
            'shipping_charge'  => 60,
            'discount'         => 0,
            'total'            => $unitPrice * $qty + 60,
            'payment_method'   => 'cod',
            'payment_status'   => 'unpaid',
            'status'           => 'pending',
            'placed_at'        => now(),
        ], $overrides));

        OrderItem::create([
            'order_id'     => $order->id,
            'product_id'   => $product->id,
            'product_name' => $product->name,
            'product_sku'  => $product->sku,
            'quantity'     => $qty,
            'unit_price'   => $unitPrice,
            'total'        => $unitPrice * $qty,
        ]);

        return $order->fresh('items');
    }
}
