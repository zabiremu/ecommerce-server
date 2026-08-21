<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('customer_id')->constrained()->nullOnDelete();
        });

        // Backfill: link existing orders to accounts by matching shipping email/phone
        // against a user's email/phone, so past orders show up on the dashboard too.
        DB::table('orders')->whereNull('user_id')->orderBy('id')->chunkById(500, function ($orders) {
            foreach ($orders as $order) {
                $user = null;
                if (!empty($order->shipping_email)) {
                    $user = DB::table('users')->where('email', $order->shipping_email)->first();
                }
                if (!$user && !empty($order->shipping_phone)) {
                    $user = DB::table('users')->where('phone', $order->shipping_phone)->first();
                }
                if ($user) {
                    DB::table('orders')->where('id', $order->id)->update(['user_id' => $user->id]);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
