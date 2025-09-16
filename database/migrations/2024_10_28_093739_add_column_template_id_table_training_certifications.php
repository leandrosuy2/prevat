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
            $table->unsignedBigInteger('template_id')->after('time02_id')->default(1);
            $table->foreign('template_id')->references('id')->on('template_certifications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_participations', function (Blueprint $table) {
            $table->dropForeign('training_certificates_template_id_foreign');
            $table->dropColumn('template_id');
        });
    }
};
