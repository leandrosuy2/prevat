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
        Schema::create('participants_itens', function (Blueprint $table) {
            $table->id();
            $table->string('training_participation_id')->nullable();
            $table->string('participant_id')->nullable();
            $table->string('name')->nullable();
            $table->string('company_id')->nullable();
            $table->string('quantity')->nullable();
            $table->string('value')->nullable();
            $table->string('total_value')->nullable();
            $table->string('note')->nullable();
            $table->string('table_color')->nullable();
            $table->string('status')->nullable();
            $table->string('registry')->nullable();
            $table->string('presence')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants_itens');
    }
};
