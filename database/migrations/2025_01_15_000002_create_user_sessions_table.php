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
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('session_id');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('location')->nullable();
            $table->timestamp('login_at');
            $table->timestamp('logout_at')->nullable();
            $table->timestamp('last_activity')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->boolean('is_suspicious')->default(false);
            $table->text('suspicious_reason')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            $table->foreign('contract_id')->references('id')->on('companies_contracts')->onDelete('set null');
            
            $table->index(['user_id', 'created_at']);
            $table->index(['session_id']);
            $table->index(['ip_address', 'created_at']);
            $table->index(['is_suspicious', 'created_at']);
            $table->index(['company_id', 'created_at']);
            $table->index(['last_activity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_sessions');
    }
};
