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
        Schema::table('schedule_company_participants', function (Blueprint $table) {
            $table->decimal('quantity', 10,2)->after('presence')->default(0);
            $table->decimal('value', 10,2)->after('quantity')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_company_participants', function (Blueprint $table) {
            $table->dropColumn('quantity');
            $table->dropColumn('value');
        });
    }
};
