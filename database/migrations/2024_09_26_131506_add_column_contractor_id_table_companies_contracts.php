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
        Schema::table('companies_contracts', function (Blueprint $table) {
            $table->unsignedBigInteger('contractor_id')->after('id')->nullable();
            $table->foreign('contractor_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies_contracts', function (Blueprint $table) {
            $table->dropForeign('companies_contracts_contractor_id_foreign');
            $table->dropColumn('contractor_id');
        });
    }
};
