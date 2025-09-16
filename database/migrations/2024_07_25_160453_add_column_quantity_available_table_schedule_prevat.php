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
            $table->string('vacancies')->after('quantity_people');
            $table->string('vacancies_available')->after('vacancies');
            $table->string('vacancies_occupied')->after('vacancies_available')->default(0);
            $table->dropColumn('quantity_people');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_prevats', function (Blueprint $table) {
            $table->dropColumn('vacancies');
            $table->dropColumn('vacancies_available');
            $table->dropColumn('vacancies_occupied');
        });
    }
};
