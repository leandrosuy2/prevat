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
        Schema::create('training_professionals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_participation_id');
            $table->foreign('training_participation_id')->references('id')->on('training_participations')->onDelete('cascade');
            $table->unsignedBigInteger('professional_id');
            $table->foreign('professional_id')->references('id')->on('professionals');
            $table->unsignedBigInteger('professional_formation_id');
            $table->foreign('professional_formation_id')->references('id')->on('professional_qualifications');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_professionals');
    }
};
