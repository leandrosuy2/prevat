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
        Schema::table('work_safeties', function (Blueprint $table) {
            $table->dropColumn('action_plan');
            $table->dropColumn('responsible_plan');
            $table->dropColumn('carried_out');
            $table->dropColumn('date_execution');
            $table->dropColumn('step');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_safeties', function (Blueprint $table) {
            $table->string('action_plan')->after('company_id');
            $table->string('responsible_plan')->after('action_plan');
            $table->enum('carried_out', ['yes', 'not'])->after('responsible_plan');
            $table->date('date_execution')->after('carried_out');
            $table->date('step')->after('time');
        });
    }
};
