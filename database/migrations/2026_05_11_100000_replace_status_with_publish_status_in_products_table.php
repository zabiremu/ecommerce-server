<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->enum('publish_status', ['draft', 'pending', 'published'])
                  ->default('draft')
                  ->after('status');
        });

        DB::table('products')->where('status', true)->update(['publish_status' => 'published']);
        DB::table('products')->where('status', false)->update(['publish_status' => 'draft']);

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('status')->default(true)->after('thumbnail');
        });

        DB::table('products')->where('publish_status', 'published')->update(['status' => true]);
        DB::table('products')->whereIn('publish_status', ['draft', 'pending'])->update(['status' => false]);

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('publish_status');
        });
    }
};
