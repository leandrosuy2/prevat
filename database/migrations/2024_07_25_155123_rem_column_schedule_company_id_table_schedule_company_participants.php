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
        Schema::table('schedule_company_participants', function (Blueprint $table) {
            $table->dropForeign('schedule_company_participants_schedule_company_id_foreign');
            $table->dropColumn('schedule_company_id');
            $table->unsignedBigInteger('schedule_company_id');
            $table->foreign('schedule_company_id')->references('id')->on('schedule_companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_company_participants', function (Blueprint $table) {
            $table->unsignedBigInteger('schedule_company_id');
            $table->foreign('schedule_company_id')->references('id')->on('schedule_companies')->onDelete('cascade');
        });
    }
};
