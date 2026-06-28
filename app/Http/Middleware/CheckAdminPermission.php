<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminPermission
{
    // Routes exempt from permission checks (personal/system)
    private const EXEMPT = [
        'admin.dashboard',
        'admin.logout',
        'admin.profile',
        'admin.profile.update',
        'admin.change-password',
        'admin.password.update',
        'admin.notifications.index',
        'admin.notifications.mark-all-read',
        'admin.notifications.read',
        'admin.search',
        'admin.dashboard.data',
    ];

    // Custom route-name → permission (for non-resourceful routes)
    private const CUSTOM = [
        // Orders
        'admin.orders.status'                    => 'orders.edit',
        'admin.orders.payment-status'            => 'orders.edit',
        'admin.orders.notes'                     => 'orders.edit',
        'admin.orders.bulk-action'               => 'orders.edit',
        // Steadfast
        'admin.steadfast.send'                   => 'orders.edit',
        'admin.steadfast.status'                 => 'orders.view',
        'admin.steadfast.balance'                => 'orders.view',
        // Products
        'admin.products.set-status'              => 'products.edit',
        'admin.products.bulk-action'             => 'products.edit',
        'admin.products.gallery-color'           => 'products.edit',
        'admin.products.gallery-delete'          => 'products.delete',
        'admin.products.barcodes'                => 'products.view',
        'admin.products.barcode-image'           => 'products.view',
        // Landing page builder (lives under the product route, gated by landings.*)
        'admin.products.landing.edit'            => 'landings.edit',
        'admin.products.landing.update'          => 'landings.edit',
        // Categories
        'admin.categories.toggle-status'         => 'categories.edit',
        // GRN
        'admin.grn.create-from-purchase'         => 'grn.create',
        // Stock
        'admin.stock-adjustments.product-stock'  => 'stock_adjustments.view',
        'admin.stock-transfers.product-stock'    => 'stock_transfers.view',
        // Phone blacklist
        'admin.phone-blacklist.block-from-order' => 'phone_blacklist.create',
        // Contact messages
        'admin.contact-messages.mark-read'       => 'contact_messages.edit',
        // Site settings
        'admin.site-settings.test-email'         => 'site_settings.edit',
        // Admins
        'admin.admins.index'                     => 'admins.view',
        'admin.admins.create'                    => 'admins.create',
        'admin.admins.store'                     => 'admins.create',
        'admin.admins.show'                      => 'admins.view',
        'admin.admins.edit'                      => 'admins.edit',
        'admin.admins.update'                    => 'admins.edit',
        'admin.admins.destroy'                   => 'admins.delete',
        // Roles
        'admin.roles.index'                      => 'roles.view',
        'admin.roles.create'                     => 'roles.create',
        'admin.roles.store'                      => 'roles.create',
        'admin.roles.show'                       => 'roles.view',
        'admin.roles.edit'                       => 'roles.edit',
        'admin.roles.update'                     => 'roles.edit',
        'admin.roles.destroy'                    => 'roles.delete',
    ];

    // Standard resource action → permission suffix
    private const ACTION_MAP = [
        'index'   => 'view',
        'show'    => 'view',
        'create'  => 'create',
        'store'   => 'create',
        'edit'    => 'edit',
        'update'  => 'edit',
        'destroy' => 'delete',
    ];

    public function handle(Request $request, Closure $next)
    {
        $admin = Auth::guard('admin')->user();

        // Not logged in — let auth middleware handle
        if (!$admin) return $next($request);

        // Super admins skip all checks
        if ($admin->isSuperAdmin()) return $next($request);

        $routeName = $request->route()?->getName() ?? '';

        // Exempt personal / system routes
        if (in_array($routeName, self::EXEMPT, true)) return $next($request);

        $permission = $this->resolve($routeName);

        // Unknown mapping — allow (fail-open for unregistered routes)
        if (!$permission) return $next($request);

        if ($admin->hasPermission($permission)) return $next($request);

        return $this->deny($request, $permission);
    }

    private function resolve(string $routeName): ?string
    {
        // Explicit custom mapping first
        if (isset(self::CUSTOM[$routeName])) {
            return self::CUSTOM[$routeName];
        }

        // Auto-derive: admin.{module}.{action}
        $parts = explode('.', $routeName);
        if (count($parts) < 3 || $parts[0] !== 'admin') return null;

        $module = str_replace('-', '_', $parts[1]);
        $action = $parts[2] ?? 'index';
        $suffix = self::ACTION_MAP[$action] ?? null;

        return $suffix ? $module . '.' . $suffix : null;
    }

    private function deny(Request $request, string $permission)
    {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message'    => 'Access denied. You do not have the "' . $permission . '" permission.',
                'permission' => $permission,
            ], 403);
        }

        return response()->view('Admin.403', ['permission' => $permission], 403);
    }
}
