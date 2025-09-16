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
        Schema::table('schedule_prevats', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->after('contractor_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_prevats', function (Blueprint $table) {
            $table->dropForeign('schedule_prevats_company_id_foreign');
            $table->dropColumn('company_id');
        });
    }
};
