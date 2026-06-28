<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_landing_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(false);
            $table->string('hero_heading')->nullable();
            $table->string('hero_subheading', 500)->nullable();
            $table->string('cta_text', 100)->default('Order Now');
            $table->boolean('show_gallery')->default(true);
            $table->boolean('show_price')->default(true);
            $table->boolean('show_short_desc')->default(true);
            $table->boolean('show_long_desc')->default(false);
            $table->longText('custom_content')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_landing_pages');
    }
};
