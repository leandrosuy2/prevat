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
        Schema::table('work_safety_items', function (Blueprint $table) {
            $table->text('action_plan')->after('not')->nullable();
            $table->string('responsible_plan')->after('action_plan')->nullable();
            $table->date('date_execution')->after('responsible_plan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_safety_items', function (Blueprint $table) {
            $table->dropColumn('action_plan');
            $table->dropColumn('responsible_plan');
            $table->dropColumn('date_execution');
        });
    }
};
