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
        Schema::table('training_certificates', function (Blueprint $table) {
            $table->decimal('registry')->after('note');
            $table->string('year')->after('registry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_certificates', function (Blueprint $table) {
            $table->dropColumn('registy');
            $table->dropColumn('year');
        });
    }
};
