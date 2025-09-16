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
        Schema::create('certificate_reissues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('original_certificate_id');
            $table->unsignedBigInteger('reissued_by_user_id')->nullable();
            $table->string('reason')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('completed');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('original_certificate_id')->references('id')->on('training_certificates')->onDelete('cascade');
            $table->foreign('reissued_by_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            $table->foreign('contract_id')->references('id')->on('companies_contracts')->onDelete('set null');
            
            $table->index(['original_certificate_id']);
            $table->index(['reissued_by_user_id', 'created_at']);
            $table->index(['company_id', 'created_at']);
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_reissues');
    }
};
