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
        Schema::table('evidence', function (Blueprint $table) {
            $table->unsignedBigInteger('training_participation_id')->after('id');
            $table->foreign('training_participation_id')->references('id')->on('training_participations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evidence', function (Blueprint $table) {
            $table->dropForeign('evidence_training_participation_id_foreign');
            $table->dropColumn('training_participation_id');
        });
    }
};
