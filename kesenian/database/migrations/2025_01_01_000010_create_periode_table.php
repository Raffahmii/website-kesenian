<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periode', function (Blueprint $table) {
            $table->id('id_periode');
            $table->string('nama_periode', 20);
            $table->integer('tahun_mulai');
            $table->integer('tahun_selesai');
            $table->boolean('is_active')->default(false);
            $table->timestamps();   // ← ★ TAMBAH INI

            $table->index('is_active');
            $table->index(['tahun_mulai', 'tahun_selesai']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periode');
    }
};