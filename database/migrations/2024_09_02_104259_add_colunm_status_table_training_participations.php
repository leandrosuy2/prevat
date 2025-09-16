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
        Schema::table('training_participations', function (Blueprint $table) {
            $table->enum('status', ['Em Aberto', 'Concluído'])->default('Em Aberto')->after('file_programmatic')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_participations', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
