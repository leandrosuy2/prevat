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
            $table->boolean('presence')->default(0)->after('participant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_company_participants', function (Blueprint $table) {
            $table->dropColumn('presence');
        });
    }
};
