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
        Schema::create('schedule_company_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_company_id');
            $table->foreign('schedule_company_id')->references('id')->on('schedule_companies');
            $table->unsignedBigInteger('participant_id');
            $table->foreign('participant_id')->references('id')->on('participants');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_company_participants');
    }
};
