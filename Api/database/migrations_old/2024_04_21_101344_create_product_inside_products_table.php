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
        Schema::create('product_inside_products', function (Blueprint $table) {
            $table->id();
            $table->string('color')->nullable()->default(null);
            $table->string('size')->nullable()->default(null);
            $table->string('type')->nullable()->default(null);
            $table->string('image');
            $table->bigInteger('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_inside_products');
    }
};
