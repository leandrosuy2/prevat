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
        Schema::create('with_trawal_protocols', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedBigInteger('contract_id');
            $table->foreign('contract_id')->references('id')->on('companies_contracts');
            $table->unsignedBigInteger('training_participation_id');
            $table->foreign('training_participation_id')->references('id')->on('training_participations');
            $table->string('reference');
            $table->string('name');
            $table->string('document');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('with_trawal_protocols');
    }
};
