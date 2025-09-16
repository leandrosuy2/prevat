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
        Schema::create('training_participants_historics', function (Blueprint $table) {
            $table->id();
            $table->string('training_participation_id')->nullable();
            $table->string('participant_id')->nullable();
            $table->string('name')->nullable();
            $table->string('taxpayer_registration')->nullable();
            $table->string('role')->nullable();
            $table->string('company_id')->nullable();
            $table->string('company_name')->nullable();
            $table->text('training_name')->nullable();
            $table->string('quantity')->nullable();
            $table->string('value')->nullable();
            $table->string('total_value')->nullable();
            $table->string('note')->nullable();
            $table->string('table_color')->nullable();
            $table->string('status')->nullable();
            $table->decimal('registry')->nullable();
            $table->string('presence')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_participants_historics');
    }
};
