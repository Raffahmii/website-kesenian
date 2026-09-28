<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestasi_peserta', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('id_prestasi');
            $table->unsignedBigInteger('id_user');
            $table->string('peran', 50)->nullable();             // peserta, pelatih, pendamping
            
            $table->timestamps();

            $table->foreign('id_prestasi')
                  ->references('id_prestasi')->on('prestasi')
                  ->onDelete('cascade');
            
            $table->foreign('id_user')
                  ->references('id_user')->on('users')
                  ->onDelete('cascade');

            $table->unique(['id_prestasi', 'id_user'], 'unique_prestasi_peserta');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasi_peserta');
    }
};