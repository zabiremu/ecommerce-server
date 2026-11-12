<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckAdminPermission
{
    // Routes exempt from permission checks (personal/system)
    private const EXEMPT = [
        'admin.logout',
        'admin.profile',
        'admin.profile.update',
        'admin.change-password',
        'admin.password.update',
        'admin.notifications.index',
        'admin.notifications.mark-all-read',
        'admin.notifications.read',
        'admin.search',          // results are filtered by permission in AdminSearchController
    ];

    // Custom route-name → permission (for non-resourceful routes)
    private const CUSTOM = [
        // Dashboard
        'admin.dashboard'                        => 'dashboard.view',
        'admin.dashboard.data'                   => 'dashboard.view',
        'admin.live-visitors'                    => 'dashboard.view',
        'admin.visitor-stats'                    => 'dashboard.view',
        // POS
        'admin.pos.catalog'                      => 'pos.view',
        'admin.pos.session'                      => 'pos.view',
        'admin.pos.products'                     => 'pos.view',
        'admin.pos.customers'                     => 'pos.view',
        'admin.pos.checkout'                      => 'pos.create',
        'admin.pos.receipt'                       => 'pos.view',
        // Customer dues
        'admin.dues.collect'                     => 'dues.edit',
        // Accounts & Reports
        'admin.accounts.daily'                   => 'accounts_reports.view',
        'admin.accounts.monthly'                 => 'accounts_reports.view',
        'admin.accounts.products'                => 'accounts_reports.view',
        'admin.accounts.returns'                 => 'accounts_reports.view',
        'admin.accounts.performance'             => 'accounts_reports.view',
        // Backups (restore/upload are also Super Admin only, checked in the controller)
        'admin.backups.download'                 => 'backups.view',
        'admin.backups.restore'                  => 'backups.create',
        'admin.backups.upload'                   => 'backups.create',
        // Supplier dues
        'admin.supplier-dues.pay'                => 'supplier_dues.edit',
        'admin.supplier-dues.payments.destroy'   => 'supplier_dues.edit',
        // Orders
        'admin.orders.status'                   => 'orders.edit',
        'admin.orders.payment-status'            => 'orders.edit',
        'admin.orders.notes'                     => 'orders.edit',
        'admin.orders.bulk-action'               => 'orders.edit',
        'admin.orders.invoice'                   => 'orders.view',
        'admin.orders.bdcourier-check'           => 'orders.view',
        // Steadfast
        'admin.steadfast.send'                   => 'orders.edit',
        'admin.steadfast.check-status'           => 'orders.edit',
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
        'admin.brands.toggle-status'             => 'brands.edit',
        'admin.units.toggle-status'              => 'units.edit',
        'admin.suppliers.toggle-status'          => 'suppliers.edit',
        'admin.warehouses.toggle-status'         => 'warehouses.edit',
        'admin.customers.toggle-status'          => 'customers.edit',
        'admin.sliders.toggle-status'            => 'sliders.edit',
        'admin.trust-items.toggle-status'        => 'trust_items.edit',
        'admin.instagram-posts.toggle-status'    => 'instagram_posts.edit',
        'admin.coupons.toggle-status'            => 'coupons.edit',
        'admin.coupons.generate-code'            => 'coupons.create',
        // Purchases
        'admin.purchases.invoice'                => 'purchases.view',
        'admin.purchases.status'                 => 'purchases.edit',
        // GRN
        'admin.grn.purchase-items'               => 'grn.create',
        'admin.grn-returns.grn-items'            => 'grn_returns.create',
        // Stock
        'admin.stock-adjustments.product-stock'  => 'stock_adjustments.view',
        'admin.stock-transfers.product-stock'    => 'stock_transfers.view',
        'admin.stock-transfers.status'           => 'stock_transfers.edit',
        // Reports
        'admin.sales-report.export'              => 'sales_report.view',
        'admin.purchase-report.export'           => 'purchase_report.view',
        // Phone blacklist
        'admin.phone-blacklist.block-from-order' => 'phone_blacklist.create',
        // Contact messages (no "edit" permission exists — changing status is part of viewing)
        'admin.contact-messages.status'          => 'contact_messages.view',
        'admin.contact-messages.bulk-action'     => 'contact_messages.view',
        // Site settings
        'admin.site-settings.test-email'         => 'site_settings.edit',
        // Admins
        'admin.admins.index'                     => 'admins.view',
        'admin.admins.create'                    => 'admins.create',
        'admin.admins.store'                     => 'admins.create',
        'admin.admins.edit'                      => 'admins.edit',
        'admin.admins.update'                    => 'admins.edit',
        'admin.admins.destroy'                   => 'admins.delete',
        // Roles
        'admin.roles.index'                      => 'roles.view',
        'admin.roles.create'                     => 'roles.create',
        'admin.roles.store'                      => 'roles.create',
        'admin.roles.edit'                       => 'roles.edit',
        'admin.roles.update'                     => 'roles.edit',
        'admin.roles.destroy'                    => 'roles.delete',
    ];

    // Bulk actions whose "delete" option needs the delete permission too.
    private const BULK_DELETE = [
        'admin.products.bulk-action'         => 'products.delete',
        'admin.orders.bulk-action'           => 'orders.delete',
        'admin.contact-messages.bulk-action' => 'contact_messages.delete',
    ];

    /**
     * Where to send an admin whose role can't see the dashboard (in sidebar
     * order) — so logging in never lands on a 403.
     */
    private const LANDING_PAGES = [
        'pos.view'              => 'admin.pos.index',
        'orders.view'           => 'admin.orders.index',
        'dues.view'             => 'admin.dues.index',
        'products.view'         => 'admin.products.index',
        'customers.view'        => 'admin.customers.index',
        'purchases.view'        => 'admin.purchases.index',
        'grn.view'              => 'admin.grn.index',
        'stock_report.view'     => 'admin.stock-report.index',
        'sales_report.view'     => 'admin.sales-report.index',
        'accounts_reports.view' => 'admin.accounts.daily',
        'categories.view'       => 'admin.categories.index',
        'coupons.view'          => 'admin.coupons.index',
        'contact_messages.view' => 'admin.contact-messages.index',
        'sliders.view'          => 'admin.sliders.index',
        'site_settings.view'    => 'admin.site-settings.edit',
        'admins.view'           => 'admin.admins.index',
        'roles.view'            => 'admin.roles.index',
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

        $permission = self::permissionFor($routeName);

        // Unknown mapping — deny (fail-closed). A new admin route must be given a
        // permission here or follow the admin.{module}.{index|create|…} naming.
        if (!$permission) {
            Log::warning('Admin route has no permission mapping — access denied', ['route' => $routeName]);
            return $this->deny($request, 'super admin');
        }

        if (!$admin->hasPermission($permission)) {
            // A role without dashboard access still needs somewhere to land after login.
            if ($routeName === 'admin.dashboard' && !$request->expectsJson()) {
                $landing = $this->landingFor($admin);
                if ($landing) return redirect()->route($landing);
            }
            return $this->deny($request, $permission);
        }

        // "Delete" inside a bulk action needs the delete permission as well.
        if (isset(self::BULK_DELETE[$routeName]) && $request->input('action') === 'delete'
            && !$admin->hasPermission(self::BULK_DELETE[$routeName])) {
            return $this->deny($request, self::BULK_DELETE[$routeName]);
        }

        return $next($request);
    }

    private function landingFor($admin): ?string
    {
        foreach (self::LANDING_PAGES as $permission => $route) {
            if ($admin->hasPermission($permission)) return $route;
        }
        return null;
    }

    public static function isExempt(string $routeName): bool
    {
        return in_array($routeName, self::EXEMPT, true);
    }

    /** The permission an admin route needs, or null when none is mapped. */
    public static function permissionFor(string $routeName): ?string
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
