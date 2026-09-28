<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kepengurusan', function (Blueprint $table) {
            $table->id('id_kepengurusan');
            
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_jabatan');
            $table->unsignedBigInteger('id_periode');
            
            $table->string('sk_number', 50)->nullable();         // nomor SK
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_user')
                  ->references('id_user')->on('users')
                  ->onDelete('cascade');
            
            $table->foreign('id_jabatan')
                  ->references('id_jabatan')->on('jabatan')
                  ->onDelete('cascade');
            
            $table->foreign('id_periode')
                  ->references('id_periode')->on('periode')
                  ->onDelete('cascade');

            // Index
            $table->index(['id_periode', 'is_active']);
            $table->unique(['id_user', 'id_jabatan', 'id_periode'], 'unique_kepengurusan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kepengurusan');
    }
};