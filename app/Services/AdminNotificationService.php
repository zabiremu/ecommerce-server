<?php

namespace App\Services;

use App\Models\AdminNotification;

class AdminNotificationService
{
    public static function newOrder(string $orderNo, string $customerName, float $total): void
    {
        AdminNotification::create([
            'type'    => 'new_order',
            'title'   => 'New Order #' . $orderNo,
            'message' => 'Order from ' . $customerName . ' — TK ' . number_format($total),
            'link'    => '/admin/orders',
        ]);
    }

    public static function lowStock(string $productName, int|float $remaining, int $productId): void
    {
        AdminNotification::create([
            'type'    => 'low_stock',
            'title'   => 'Low Stock: ' . $productName,
            'message' => 'Only ' . $remaining . ' unit(s) left in stock.',
            'link'    => '/admin/products/' . $productId . '/edit',
        ]);
    }

    public static function newCustomer(string $name, string $phone): void
    {
        AdminNotification::create([
            'type'    => 'new_customer',
            'title'   => 'New Customer',
            'message' => $name . ' (' . $phone . ') just placed their first order.',
            'link'    => '/admin/customers',
        ]);
    }
}
