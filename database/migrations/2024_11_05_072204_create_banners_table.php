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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->mediumText('title')->nullable();
            $table->mediumText('link')->nullable();
            $table->integer('position')->nullable();
            $table->boolean('custom_link')->default(0)->nullable();
            $table->boolean('status')->default(1);
            $table->enum('type', array('image', 'video'))->default('image');
            $table->mediumText('mobile')->nullable();
            $table->mediumText('desktop')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
