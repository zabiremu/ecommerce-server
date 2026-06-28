<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'permissions', 'is_super_admin'];

    protected $casts = [
        'permissions'    => 'array',
        'is_super_admin' => 'boolean',
    ];

    // ── Permission registry ─────────────────────────────────────────────────

    public static function allPermissions(): array
    {
        return [
            'Main' => [
                'dashboard' => ['view'],
            ],
            'Catalog' => [
                'products'   => ['view', 'create', 'edit', 'delete'],
                'categories' => ['view', 'create', 'edit', 'delete'],
                'brands'     => ['view', 'create', 'edit', 'delete'],
                'units'      => ['view', 'create', 'edit', 'delete'],
                'suppliers'  => ['view', 'create', 'edit', 'delete'],
                'warehouses' => ['view', 'create', 'edit', 'delete'],
            ],
            'Inventory' => [
                'purchases'         => ['view', 'create', 'edit', 'delete'],
                'grn'               => ['view', 'create', 'edit', 'delete'],
                'grn_returns'       => ['view', 'create', 'edit', 'delete'],
                'stock_transfers'   => ['view', 'create', 'edit', 'delete'],
                'stock_adjustments' => ['view', 'create', 'edit', 'delete'],
                'stock_report'      => ['view'],
            ],
            'Sales' => [
                'orders'           => ['view', 'create', 'edit', 'delete'],
                'abandoned_carts'  => ['view'],
                'customers'        => ['view', 'edit', 'delete'],
                'phone_blacklist'  => ['view', 'create', 'delete'],
                'coupons'          => ['view', 'create', 'edit', 'delete'],
                'contact_messages' => ['view', 'delete'],
            ],
            'Content' => [
                'sliders'      => ['view', 'create', 'edit', 'delete'],
                'trust_items'  => ['view', 'create', 'edit', 'delete'],
                'deals_banner' => ['view', 'edit'],
                'landings'     => ['view', 'create', 'edit', 'delete'],
                'about_page'   => ['view', 'edit'],
            ],
            'Reports' => [
                'sales_report'    => ['view'],
                'purchase_report' => ['view'],
                'customer_report' => ['view'],
            ],
            'Settings' => [
                'pages'         => ['view', 'create', 'edit', 'delete'],
                'site_settings' => ['view', 'edit'],
                'admins'        => ['view', 'create', 'edit', 'delete'],
                'roles'         => ['view', 'create', 'edit', 'delete'],
            ],
        ];
    }

    // Human-readable labels for module keys
    public static function moduleLabel(string $key): string
    {
        return ucwords(str_replace('_', ' ', $key));
    }

    // ── Helpers ─────────────────────────────────────────────────────────────

    public function hasPermission(string $permission): bool
    {
        if ($this->is_super_admin) return true;
        return in_array($permission, $this->permissions ?? [], true);
    }

    public function admins()
    {
        return $this->hasMany(Admin::class);
    }

    protected static function booted(): void
    {
        static::creating(function (Role $role) {
            if (empty($role->slug)) {
                $role->slug = Str::slug($role->name);
            }
        });
    }
}
