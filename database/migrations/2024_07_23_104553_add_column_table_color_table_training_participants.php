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
        Schema::table('training_participants', function (Blueprint $table) {
            $table->string('table_color')->after('note')->nullable();
            $table->enum('status', ['Aprovado', 'Reprovado'])->after('table_color')->default('Reprovado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_participants', function (Blueprint $table) {
            $table->dropColumn('table_color');
            $table->dropColumn('status');
        });
    }
};
