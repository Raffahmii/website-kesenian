<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_log', function (Blueprint $table) {
            $table->id('id_log');
            
            $table->unsignedBigInteger('id_user')->nullable();
            
            $table->string('action', 50);                        // create, update, delete, login, logout
            $table->string('module', 50)->nullable();            // anggota, kas, absensi, dokumentasi, dll
            $table->text('description')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_user')
                  ->references('id_user')->on('users')
                  ->onDelete('set null');

            $table->index('action');
            $table->index('module');
            $table->index('created_at');
            $table->index(['id_user', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_log');
    }
};