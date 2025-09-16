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
        Schema::create('schedule_companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_prevat_id');
            $table->foreign('schedule_prevat_id')->references('id')->on('schedule_prevats')->onDelete('cascade');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->enum('status', ['Em Aberto', 'Concluído'])->default('Em Aberto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_companies');
    }
};
