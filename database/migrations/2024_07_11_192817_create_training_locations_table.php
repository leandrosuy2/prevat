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
        Schema::create('training_locations', function (Blueprint $table) {
            $table->id();
            $table->string('acronym');
            $table->string('name');
            $table->string('zip-code');
            $table->string('address');
            $table->string('number')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('complement')->nullable();
            $table->string('city')->nullable();
            $table->string('uf')->nullable();
            $table->enum('status',['Ativo', 'Inativo']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_locations');
    }
};
