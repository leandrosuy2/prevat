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
        Schema::create('training_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_participation_id');
            $table->foreign('training_participation_id')->references('id')->on('training_participations')->onDelete('cascade');
            $table->unsignedBigInteger('participant_id');
            $table->foreign('participant_id')->references('id')->on('participants');
            $table->string('quantity')->nullable();
            $table->decimal('value', 10,2)->default(0);
            $table->decimal('total_value',10,2)->default(0);
            $table->string('note')->default(0);
            $table->string('registry')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_participants');
    }
};
