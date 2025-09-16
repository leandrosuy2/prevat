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
            $table->unsignedBigInteger('training_local_id')->after('training_room_id')->nullable();
            $table->foreign('training_local_id')->references('id')->on('training_locations');
//            $table->unsignedBigInteger('schedule_company_id');
//            $table->foreign('schedule_company_id')->references('id')->on('schedule_company');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_prevats', function (Blueprint $table) {
            $table->dropForeign('schedule_prevats_training_local_id_foreign');
            $table->dropColumn('training_local_id');
        });
    }
};
