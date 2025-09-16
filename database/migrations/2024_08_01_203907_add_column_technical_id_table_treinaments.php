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
        Schema::table('trainings', function (Blueprint $table) {
            $table->unsignedBigInteger('technical_id')->after('category_id')->nullable();
            $table->foreign('technical_id')->references('id')->on('technical_managers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropForeign('trainings_technical_id_foreign');
            $table->dropColumn('technical_id');
        });
    }
};
