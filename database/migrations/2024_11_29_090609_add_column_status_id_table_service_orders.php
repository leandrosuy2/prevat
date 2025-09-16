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
        Schema::table('service_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->after('payment_method_id');
            $table->foreign('status_id')->references('id')->on('service_order_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_orders', function (Blueprint $table) {
            $table->dropForeign('service_orders_status_id_foreign');
            $table->dropColumn('status_id');
        });
    }
};
