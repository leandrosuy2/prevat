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
        Schema::create('site_informations', function (Blueprint $table) {
            $table->id();
            $table->string('email_01')->nullable();
            $table->string('email_02')->nullable();
            $table->string('phone_01')->nullable();
            $table->string('phone_02')->nullable();
            $table->text('text_about')->nullable();
            $table->string('link_instagram')->nullable();
            $table->string('link_facebook')->nullable();
            $table->string('link_twitter')->nullable();
            $table->string('link_youtube')->nullable();
            $table->string('link_linkedin')->nullable();
            $table->text('text_footer')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_informations');
    }
};
