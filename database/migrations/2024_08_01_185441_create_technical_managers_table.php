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
        Schema::create('technical_managers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('registry');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('document')->nullable();
            $table->string('formation')->nullable();
            $table->string('signature_image')->nullable();
            $table->enum('status', ['Ativo', 'Inativo']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technical_managers');
    }
};
