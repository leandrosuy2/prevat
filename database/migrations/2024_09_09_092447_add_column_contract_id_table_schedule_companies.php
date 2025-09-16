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
        Schema::table('schedule_companies', function (Blueprint $table) {
            $table->unsignedBigInteger('contract_id')->after('company_id')->nullable();
            $table->foreign('contract_id')->references('id')->on('companies_contracts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_companies', function (Blueprint $table) {
            $table->dropForeign('schedule_companies_contract_id_foreign');
            $table->dropColumn('contract_id');
        });
    }
};
