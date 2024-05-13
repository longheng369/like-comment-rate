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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('title');
            $table->boolean('active');
            $table->unsignedBigInteger('parent_id')->nullable(); // Nullable since top-level categories won't have a parent.
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('set null'); // Reference to the same table
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
