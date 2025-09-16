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
            $table->string('file_presence')->after('vacancies_occupied')->nullable();
            $table->string('file_programmatic')->after('file_presence')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_prevats', function (Blueprint $table) {
            $table->dropColumn('file_presence');
            $table->dropColumn('file_programmatic');
        });
    }
};
