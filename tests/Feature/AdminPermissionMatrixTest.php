<?php

namespace Tests\Feature;

use App\Http\Middleware\CheckAdminPermission;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Route as LaravelRoute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

/**
 * "Permission given but it doesn't work" sweep.
 *
 * For EVERY admin route, a staff account whose role holds ONLY that route's
 * permission calls it (with seeded demo data). It must not be refused (403)
 * and must not crash (500). Each call runs in its own rolled-back
 * transaction, so deletes don't affect the next route.
 *
 * Also checks the reverse: holding every permission EXCEPT the route's own
 * one gets a 403.
 */
class AdminPermissionMatrixTest extends TestCase
{
    use RefreshDatabase;

    /** Intentionally Super Admin only (restoring a DB backup overwrites everything). */
    private const SUPER_ADMIN_ONLY = ['admin.backups.restore', 'admin.backups.upload'];

    /** Routes that stream files / call outside services — only the permission gate is checked. */
    private const GATE_ONLY = ['admin.backups.store', 'admin.backups.download', 'admin.steadfast.send',
        'admin.steadfast.check-status', 'admin.steadfast.balance', 'admin.orders.bdcourier-check',
        'admin.site-settings.test-email'];

    protected function setUp(): void
    {
        parent::setUp();
        foreach ([\Database\Seeders\DatabaseSeeder::class, \Database\Seeders\UnitSeeder::class,
                  \Database\Seeders\SupplierSeeder::class, \Database\Seeders\WarehouseSeeder::class,
                  \Database\Seeders\PurchaseSeeder::class, \Database\Seeders\GRNSeeder::class,
                  \Database\Seeders\CouponSeeder::class, \Database\Seeders\SliderSeeder::class,
                  \Database\Seeders\DemoVideoSeeder::class] as $seeder) {
            try { $this->seed($seeder); } catch (\Throwable $e) { /* partial demo data is fine */ }
        }

        // Rows the demo seeders don't create, so every route has something to open.
        $supplier = \App\Models\Supplier::first();
        \App\Models\Brand::firstOrCreate(['slug' => 'perm-brand'], ['name' => 'Perm Brand', 'status' => true]);
        \App\Models\TrustItem::create(['icon' => 'fa-truck', 'title' => 'Fast delivery', 'status' => true]);
        \App\Models\InstagramPost::create(['image' => 'x.jpg', 'link' => 'https://example.com', 'status' => true]);
        \App\Models\ContactMessage::create(['name' => 'A', 'email' => 'a@x.com', 'subject' => 'Hi', 'message' => 'Hello', 'status' => 'new']);
        \App\Models\Cart::create(['session_id' => 'perm-sess', 'contact_phone' => '01700000000', 'last_activity' => now()]);
        \App\Models\PhoneBlacklist::create(['phone' => '01799999999', 'reason' => 'test']);
        Role::create(['name' => 'Cashier', 'permissions' => ['pos.view']]);
        if ($supplier) {
            \App\Models\SupplierPayment::create(['supplier_id' => $supplier->id, 'amount' => 100, 'payment_method' => 'cash', 'paid_on' => now()]);
        }
        $grn = \App\Models\GoodsReceivedNote::first();
        if ($grn) {
            \App\Models\GRNReturn::create(['return_no' => 'GRNR-PERM-1', 'goods_received_note_id' => $grn->id,
                'supplier_id' => $grn->supplier_id, 'warehouse_id' => $grn->warehouse_id, 'return_date' => now()]);
        }
        // A non-super staff account to open in the Admins screens (Super Admins are protected).
        $this->targetAdmin = Admin::create(['name' => 'Target', 'email' => 'target@x.com', 'password' => 'secret123',
            'role_id' => Role::where('name', 'Cashier')->value('id')]);
    }

    private Admin $targetAdmin;

    private function adminRoutes(): array
    {
        $routes = [];
        foreach (Route::getRoutes() as $route) {
            if (in_array('admin.permission', $route->gatherMiddleware(), true)
                && !CheckAdminPermission::isExempt($route->getName())) {
                $routes[] = $route;
            }
        }
        return $routes;
    }

    private function staff(array $permissions): Admin
    {
        $role = Role::create(['name' => 'R' . uniqid(), 'permissions' => $permissions]);
        return Admin::create(['name' => 'Staff', 'email' => uniqid() . '@x.com', 'password' => 'secret123', 'role_id' => $role->id]);
    }

    /** Build a URL for the route, filling parameters from seeded rows. */
    private function urlFor(LaravelRoute $route): ?string
    {
        $params = [];
        $models = [];
        foreach ($route->signatureParameters(['subClass' => UrlRoutable::class]) as $p) {
            $models[$p->getName()] = $p->getType()?->getName();
        }
        foreach ($route->parameterNames() as $name) {
            if (isset($models[$name]) && is_subclass_of($models[$name], Model::class)) {
                $row = match ($models[$name]) {
                    Admin::class => $this->targetAdmin,
                    Role::class  => Role::where('name', 'Cashier')->first(),
                    default      => $models[$name]::query()->first(),
                };
                if (!$row) return null;              // no demo data for this model
                $params[$name] = $row->getRouteKey();
            } else {
                $params[$name] = match (true) {
                    $name === 'index'             => 0,
                    $name === 'code'              => 'SKU123',
                    $name === 'productId'         => \App\Models\Product::value('id') ?? 1,
                    $name === 'warehouseId'       => \App\Models\Warehouse::value('id') ?? 1,
                    default                       => 1,
                };
            }
        }
        return route($route->getName(), $params, false);
    }

    private function hit(LaravelRoute $route, Admin $as, string $url)
    {
        $method = collect($route->methods())->first(fn ($m) => $m !== 'HEAD');
        return $this->actingAs($as, 'admin')
            ->withHeaders(['Accept' => 'text/html'])
            ->call($method, $url, $method === 'GET' ? [] : ['_token' => csrf_token()]);
    }

    public function test_every_admin_route_works_with_only_its_own_permission(): void
    {
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
        $all = Role::permissionKeys();
        $failures = [];
        $checked = 0;
        $skipped = [];

        foreach ($this->adminRoutes() as $route) {
            $name = $route->getName();
            $perm = CheckAdminPermission::permissionFor($name);
            $url = $this->urlFor($route);
            if ($url === null) { $skipped[] = "{$name} (no demo row to open)"; continue; }

            DB::beginTransaction();
            try {
                // Reverse first (a successful delete below removes the row): a role with
                // every permission EXCEPT this one must be refused.
                $without = $this->staff(array_values(array_diff($all, [$perm])));
                $status2 = $this->hit($route, $without, $url)->getStatusCode();
                $redirectsAway = $name === 'admin.dashboard' && $status2 === 302;   // sent to a page they can open
                if ($status2 !== 403 && !$redirectsAway) {
                    $failures[] = "{$name} [{$perm}] → {$status2} for a role WITHOUT the permission (expected 403)";
                }
                \Illuminate\Support\Facades\Auth::guard('admin')->logout();

                $ok = $this->staff([$perm]);
                $res = $this->hit($route, $ok, $url);
                $status = $res->getStatusCode();
                $checked++;

                if (in_array($name, self::SUPER_ADMIN_ONLY, true)) {
                    // documented exception — nothing to assert for staff
                } elseif ($status === 403) {
                    $failures[] = "{$name} [{$perm}] → 403 even though the role has the permission";
                } elseif ($status >= 500 && !in_array($name, self::GATE_ONLY, true)) {
                    $msg = $res->exception ? class_basename($res->exception) . ': ' . \Illuminate\Support\Str::limit($res->exception->getMessage(), 160) : '';
                    $failures[] = "{$name} [{$perm}] → {$status} {$msg}";
                }
            } catch (\Throwable $e) {
                $failures[] = "{$name} [{$perm}] → exception " . class_basename($e) . ': ' . \Illuminate\Support\Str::limit($e->getMessage(), 160);
            } finally {
                DB::rollBack();
                \Illuminate\Support\Facades\Auth::guard('admin')->logout();
            }
        }

        fwrite(STDERR, "\n[permission sweep] routes checked: {$checked}, skipped: " . count($skipped) . "\n"
            . ($skipped ? '  skipped: ' . implode(', ', $skipped) . "\n" : ''));

        $this->assertSame([], $failures, "Permission problems:\n" . implode("\n", $failures));
    }
}
