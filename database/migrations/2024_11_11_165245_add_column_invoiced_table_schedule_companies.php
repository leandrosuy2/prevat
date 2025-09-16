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
        Schema::table('schedule_companies', function (Blueprint $table) {
            $table->enum('invoiced', ['Sim', 'Não'])->default('Não')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_companies', function (Blueprint $table) {
            $table->dropColumn('invoiced');
        });
    }
};
