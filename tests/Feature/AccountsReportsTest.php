<?php

namespace Tests\Feature;

use App\Models\Expense;
use App\Models\Investment;
use App\Models\OrderItem;
use App\Models\Purchase;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Services\ProfitReportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\ActsAsAdmin;
use Tests\Feature\Concerns\CreatesOrders;
use Tests\Feature\Concerns\CreatesProducts;
use Tests\TestCase;

class AccountsReportsTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;
    use CreatesOrders;
    use CreatesProducts;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();
    }

    /** Product costs 500, sells at 1000 + 60 delivery. */
    private function sale(array $overrides = [], int $qty = 1, array $product = [])
    {
        return $this->makeOrderFor($this->makeProduct($product), array_merge(['status' => 'delivered'], $overrides), $qty);
    }

    public function test_order_items_snapshot_purchase_price_as_cost(): void
    {
        $product = $this->makeProduct(['purchase_price' => 420]);
        $this->makeOrderFor($product, ['status' => 'delivered']);

        $item = OrderItem::latest('id')->first();
        $this->assertEquals(420, (float) $item->unit_cost);

        $product->update(['purchase_price' => 999]);
        $this->assertEquals(420, (float) $item->fresh()->unit_cost);
    }

    public function test_net_profit_is_sales_minus_cost_minus_expenses(): void
    {
        $today = ProfitReportService::today();
        $this->sale([], 2);                       // sales 2060, cost 1000
        $this->sale(['status' => 'pending']);     // not counted
        $this->sale(['status' => 'cancelled']);   // not counted
        Expense::create(['expense_date' => $today, 'category' => 'shop_rent', 'title' => 'Rent', 'amount' => 300]);
        Investment::create(['invest_date' => $today, 'category' => 'equipment', 'title' => 'Rack', 'amount' => 5000]);

        $s = app(ProfitReportService::class)->summary($today, $today);

        $this->assertSame(1, $s['orders']);
        $this->assertEquals(2060, $s['sales']);
        $this->assertEquals(1000, $s['cost']);
        $this->assertEquals(1060, $s['gross']);
        $this->assertEquals(300, $s['expenses']);
        $this->assertEquals(760, $s['net']);   // investment does not reduce profit
    }

    public function test_sales_are_grouped_by_local_dhaka_day(): void
    {
        // 20:00 UTC = 02:00 next day in Dhaka.
        $this->sale(['placed_at' => '2026-03-10 20:00:00']);

        $days = app(ProfitReportService::class)->daily('2026-03-10', '2026-03-11');

        $this->assertSame(0, $days['2026-03-10']['orders']);
        $this->assertSame(1, $days['2026-03-11']['orders']);
        $this->assertEquals(560, $days['2026-03-11']['net']);
    }

    public function test_product_wise_profit_shares_order_discount(): void
    {
        $today = ProfitReportService::today();
        // subtotal 1000, discount 100 → product revenue 900, cost 500.
        $this->sale(['discount' => 100, 'total' => 960]);

        $rows = app(ProfitReportService::class)->productWise($today, $today);

        $this->assertCount(1, $rows);
        $this->assertEquals(900, $rows[0]->revenue);
        $this->assertEquals(500, $rows[0]->cost);
        $this->assertEquals(400, $rows[0]->profit);
    }

    public function test_investment_totals_include_stock_purchases(): void
    {
        $supplier = Supplier::create(['name' => 'Supplier', 'status' => true]);
        $warehouse = Warehouse::create(['name' => 'Main', 'slug' => 'main-' . uniqid(), 'status' => true]);
        $base = ['supplier_id' => $supplier->id, 'warehouse_id' => $warehouse->id, 'purchase_date' => '2026-03-05'];
        Purchase::create($base + ['invoice_no' => 'P-1', 'total_amount' => 8000, 'status' => 'completed']);
        Purchase::create($base + ['invoice_no' => 'P-2', 'total_amount' => 999, 'status' => 'cancelled']);
        Investment::create(['invest_date' => '2026-03-02', 'category' => 'shop_setup', 'title' => 'Paint', 'amount' => 2000]);

        $totals = app(ProfitReportService::class)->investmentTotals('2026-03-01', '2026-03-31');

        $this->assertEquals(['manual' => 2000.0, 'stock' => 8000.0, 'total' => 10000.0], $totals);
    }

    public function test_report_pages_render(): void
    {
        $this->sale();
        Expense::create(['expense_date' => ProfitReportService::today(), 'category' => 'staff_salary', 'title' => 'Salary', 'amount' => 100]);

        $this->get('/admin/accounts/daily')->assertOk()->assertSee('Daily Report')->assertSee('Salary');
        $this->get('/admin/accounts/daily?date=2026-01-15')->assertOk();
        $this->get('/admin/accounts/monthly')->assertOk()->assertSee('Day by Day');
        $this->get('/admin/accounts/monthly?month=2026-01')->assertOk();
        $this->get('/admin/accounts/products')->assertOk()->assertSee('Test Product');
        $this->get('/admin/expenses')->assertOk()->assertSee('Salary');
        $this->get('/admin/investments')->assertOk()->assertSee('Stock Bought from Suppliers');
        $this->get('/admin/dashboard')->assertOk()->assertSee('Monthly Profit')->assertSee('Total Investment');
    }

    public function test_expense_can_be_added_edited_and_deleted(): void
    {
        $this->post('/admin/expenses', [
            'entry_date' => '2026-02-01', 'category' => 'shop_rent', 'title' => 'February rent', 'amount' => 15000, 'payment_method' => 'cash',
        ])->assertRedirect('/admin/expenses?month=2026-02');

        $expense = Expense::firstOrFail();
        $this->assertSame('2026-02-01', $expense->expense_date->toDateString());

        $this->put("/admin/expenses/{$expense->id}", [
            'entry_date' => '2026-02-02', 'category' => 'shop_rent', 'title' => 'February rent', 'amount' => 16000,
        ])->assertRedirect();
        $this->assertEquals(16000, (float) $expense->fresh()->amount);

        $this->post('/admin/expenses', ['entry_date' => '2026-02-01', 'category' => 'nope', 'title' => 'x', 'amount' => 1])
            ->assertSessionHasErrors('category');

        $this->delete("/admin/expenses/{$expense->id}")->assertRedirect();
        $this->assertSame(0, Expense::count());
    }

    public function test_investment_can_be_added(): void
    {
        $this->post('/admin/investments', [
            'entry_date' => '2026-02-10', 'category' => 'equipment', 'title' => 'Cash counter', 'amount' => 7000,
        ])->assertRedirect('/admin/investments?month=2026-02');

        $this->assertEquals(7000, (float) Investment::firstOrFail()->amount);
    }

    public function test_staff_without_permission_cannot_see_accounts(): void
    {
        $role = Role::create(['name' => 'Cashier', 'permissions' => ['dashboard.view', 'pos.view']]);
        $this->actingAsAdmin(['role_id' => $role->id]);

        $this->get('/admin/accounts/daily')->assertForbidden();
        $this->get('/admin/expenses')->assertForbidden();
        $this->post('/admin/investments', [])->assertForbidden();
        $this->get('/admin/dashboard')->assertOk()->assertDontSee('Monthly Profit');
    }
}
