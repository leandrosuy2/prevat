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
        Schema::create('evidence_participations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evidence_id');
            $table->foreign('evidence_id')->references('id')->on('evidence')->onDelete('cascade');
            $table->unsignedBigInteger('participant_id');
            $table->foreign('participant_id')->references('id')->on('participants');
            $table->string('note')->nullable();
            $table->boolean('presence');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evidence_participations');
    }
};
