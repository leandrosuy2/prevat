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
        Schema::create('work_safety_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_safety_id');
            $table->foreign('work_safety_id')->references('id')->on('work_safeties')->onDelete('cascade');
            $table->unsignedBigInteger('safety_category_id');
            $table->foreign('safety_category_id')->references('id')->on('safety_categories');
            $table->unsignedBigInteger('safety_item_id');
            $table->foreign('safety_item_id')->references('id')->on('safety_items');
            $table->boolean('yes');
            $table->boolean('not');
            $table->boolean('na');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_safety_items');
    }
};
