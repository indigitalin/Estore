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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('products')->onDelete("cascade");
            $table->foreign('category_id')->references('id')->on('categories')->onDelete("cascade");
            $table->string('name', 150);
            $table->string('handle', 150);
            $table->string('sku', 150)->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('track_quantity')->default(0);
            $table->boolean('sell_without_stock')->default(0);
            $table->boolean('physical')->default(0);
            $table->decimal('weight', 8, 2)->default(0);
            $table->enum('weight_type', ['ml', 'gm', 'l', 'kg'])->default('gm');
            $table->decimal('price', 8, 2)->default(0);
            $table->decimal('cost_per_item', 8, 2)->nullable();
            $table->decimal('compare_price', 8, 2)->nullable();
            $table->boolean('charge_tax')->default(0);
            $table->boolean('custom_tax')->default(0);
            $table->decimal('tax_rate', 8, 2)->nullable();
            $table->bigInteger('client_id')->unsigned()->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete("cascade");
            $table->string('seo_title', 150)->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
