<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE `orders` MODIFY `payment_method` ENUM('cod','bkash','nagad','rocket','bank','uddoktapay','cash','card') NOT NULL DEFAULT 'cod'");

        Schema::table('orders', function (Blueprint $table) {
            $table->enum('source', ['online', 'pos'])->default('online')->after('order_no');
            $table->foreignId('warehouse_id')->nullable()->after('customer_id')->constrained()->nullOnDelete();
            $table->foreignId('served_by')->nullable()->after('warehouse_id')->constrained('admins')->nullOnDelete();
            $table->decimal('paid_amount', 12, 2)->nullable()->after('total');
            $table->decimal('change_due', 12, 2)->nullable()->after('paid_amount');
            $table->index('source');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['source']);
            $table->dropConstrainedForeignId('warehouse_id');
            $table->dropConstrainedForeignId('served_by');
            $table->dropColumn(['source', 'paid_amount', 'change_due']);
        });

        DB::statement("ALTER TABLE `orders` MODIFY `payment_method` ENUM('cod','bkash','nagad','rocket','bank','uddoktapay') NOT NULL DEFAULT 'cod'");
    }
};
