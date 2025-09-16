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
        Schema::create('training_participations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_prevat_id');
            $table->foreign('schedule_prevat_id')->references('id')->on('schedule_prevats');
            $table->unsignedBigInteger('training_id')->nullable();
            $table->foreign('training_id')->references('id')->on('trainings');
            $table->unsignedBigInteger('training_location_id');
            $table->foreign('training_location_id')->references('id')->on('training_locations');
            $table->unsignedBigInteger('training_room_id');
            $table->foreign('training_room_id')->references('id')->on('training_rooms');
            $table->unsignedBigInteger('workload_id');
            $table->foreign('workload_id')->references('id')->on('work_loads');
            $table->unsignedBigInteger('time01_id');
            $table->foreign('time01_id')->references('id')->on('times');
            $table->unsignedBigInteger('time02_id')->nullable();
            $table->foreign('time02_id')->references('id')->on('times');
            $table->date('date_event');
            $table->date('start_event');
            $table->date('event_end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_participations');
    }
};
