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
        Schema::create('service_orders_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_order_id');
            $table->foreign('service_order_id')->references('id')->on('service_orders')->onDelete('cascade');
            $table->unsignedBigInteger('schedule_company_id');
            $table->foreign('schedule_company_id')->references('id')->on('schedule_companies');
            $table->decimal('quantity',10,2)->default(0);
            $table->decimal('value', 10,2)->default(0);
            $table->decimal('total_value', 10,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_orders_items');
    }
};
