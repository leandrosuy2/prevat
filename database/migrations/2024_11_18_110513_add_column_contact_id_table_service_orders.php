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
            $table->unsignedBigInteger('contact_id')->after('payment_method_id')->nullable();
            $table->foreign('contact_id')->references('id')->on('service_orders_contacts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_orders', function (Blueprint $table) {
            $table->dropForeign('service_orders_contact_id_foreign');
            $table->dropColumn('contact_id');
        });
    }
};
