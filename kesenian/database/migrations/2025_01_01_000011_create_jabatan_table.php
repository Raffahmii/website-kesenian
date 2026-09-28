<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jabatan', function (Blueprint $table) {
            $table->id('id_jabatan');
            $table->string('nama_jabatan', 50);                 // Ketua, Bendahara 1, Koor. Padus, dll
            $table->integer('level')->nullable();                // urutan hierarki (1 = tertinggi)
            $table->string('divisi', 50)->nullable();            // padus, tari, dance, band, musik, seni, dll
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->index('level');
            $table->index('divisi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jabatan');
    }
};