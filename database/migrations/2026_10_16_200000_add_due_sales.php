<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Due (credit) sales from the POS: a customer takes the goods and pays the
 * rest later. orders.due_amount is what is still owed on that sale;
 * due_payments records every later collection against it.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('due_amount', 12, 2)->default(0)->after('change_due');
            $table->date('due_date')->nullable()->after('due_amount');
            $table->index('due_amount');
        });

        // New payment status for sales that are partly paid.
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY payment_status ENUM('unpaid','partial','paid','refunded') NOT NULL DEFAULT 'unpaid'");
        }

        Schema::create('due_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('payment_method', 30)->default('cash');
            $table->string('note', 500)->nullable();
            $table->foreignId('received_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamp('paid_at')->useCurrent();
            $table->timestamps();

            $table->index(['customer_id', 'paid_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('due_payments');

        if (DB::getDriverName() === 'mysql') {
            DB::statement("UPDATE orders SET payment_status = 'unpaid' WHERE payment_status = 'partial'");
            DB::statement("ALTER TABLE orders MODIFY payment_status ENUM('unpaid','paid','refunded') NOT NULL DEFAULT 'unpaid'");
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['due_amount']);
            $table->dropColumn(['due_amount', 'due_date']);
        });
    }
};
