<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('thumbnail')->nullable()->after('barcode');
            $table->json('gallery')->nullable()->after('thumbnail');
            $table->text('short_description')->nullable()->after('description');
            $table->text('long_description')->nullable()->after('short_description');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['thumbnail', 'gallery', 'short_description', 'long_description']);
        });
    }
};
