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
        Schema::table('users', function (Blueprint $table) {
            $table->string('document')->after('email');
            $table->string('phone')->after('document');
            $table->text('observations')->nullable();
            $table->enum('status', ['Ativo', 'Inativo'])->after('profile_photo_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('document');
            $table->dropColumn('observations');
            $table->dropColumn('status');
        });
    }
};
