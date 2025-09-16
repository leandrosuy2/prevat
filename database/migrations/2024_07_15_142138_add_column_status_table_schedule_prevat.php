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
        Schema::table('schedule_prevats', function (Blueprint $table) {
            $table->enum('status', ['Em Aberto', 'Concluído'])->after('quantity_people')->default('Em Aberto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_prevats', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
