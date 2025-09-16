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
            $table->unsignedBigInteger('team_id')->nullable()->after('time02_id');
            $table->foreign('team_id')->references('id')->on('training_teams');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_prevats', function (Blueprint $table) {
            $table->dropForeign('schedule_prevats_team_id_foreign');
            $table->dropColumn('team_id');
        });
    }
};
