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
        Schema::table('training_professionals', function (Blueprint $table) {
            $table->boolean('front')->after('professional_formation_id')->default(false);
            $table->boolean('verse')->after('front')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_professionals', function (Blueprint $table) {
            $table->dropColumn('front');
            $table->dropColumn('verse');
        });
    }
};
