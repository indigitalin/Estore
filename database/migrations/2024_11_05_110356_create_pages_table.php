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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->mediumText('title')->nullable();
            $table->mediumText('slug')->nullable();
            $table->bigInteger('banner_id')->unsigned()->nullable();
            $table->foreign('banner_id')->references('id')->on('banners')->onDelete("cascade");
            $table->longText('content')->nullable();
            $table->mediumText('seo_title')->nullable();
            $table->mediumText('seo_keywords')->nullable();
            $table->mediumText('seo_description')->nullable();
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('website_id')->nullable();
            $table->foreign('website_id')->references('id')->on('stores')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
