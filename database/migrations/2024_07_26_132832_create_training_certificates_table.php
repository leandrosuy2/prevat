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
        Schema::create('training_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->unsignedBigInteger('training_participation_id');
            $table->foreign('training_participation_id')->references('id')->on('training_participations')->onDelete('cascade');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedBigInteger('training_id');
            $table->foreign('training_id')->references('id')->on('trainings');
            $table->unsignedBigInteger('participant_id');
            $table->foreign('participant_id')->references('id')->on('participants');
            $table->string('note');
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_certificates');
    }
};
