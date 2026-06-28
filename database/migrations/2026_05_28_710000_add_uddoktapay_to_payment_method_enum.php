<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE `orders` MODIFY `payment_method` ENUM('cod','bkash','nagad','rocket','bank','uddoktapay') NOT NULL DEFAULT 'cod'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `orders` MODIFY `payment_method` ENUM('cod','bkash','nagad','rocket','bank') NOT NULL DEFAULT 'cod'");
    }
};
