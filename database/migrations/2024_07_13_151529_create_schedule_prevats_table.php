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
        Schema::create('schedule_prevats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_id');
            $table->foreign('training_id')->references('id')->on('trainings');
            $table->unsignedBigInteger('workload_id');
            $table->foreign('workload_id')->references('id')->on('work_loads');
            $table->unsignedBigInteger('training_room_id');
            $table->foreign('training_room_id')->references('id')->on('training_rooms');
            $table->unsignedBigInteger('time01_id');
            $table->foreign('time01_id')->references('id')->on('times');
            $table->unsignedBigInteger('time02_id')->nullable();
            $table->foreign('time02_id')->references('id')->on('times');
            $table->date('date_event');
            $table->date('start_event');
            $table->date('end_event');
            $table->string('quantity_people');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_prevats');
    }
};
