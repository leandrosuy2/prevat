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
        Schema::table('training_certificates', function (Blueprint $table) {
            $table->unsignedBigInteger('training_participant_id')->after('reference');
            $table->foreign('training_participant_id')->references('id')->on('training_participants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_certificates', function (Blueprint $table) {
            $table->dropForeign('training_certificates_training_participant_id_foreign');
            $table->dropColumn('training_participant_id');
        });
    }
};
