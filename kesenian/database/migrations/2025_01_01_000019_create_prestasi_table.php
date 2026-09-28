<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id('id_prestasi');
            
            $table->string('nama_lomba', 100);
            $table->string('kategori', 50)->nullable();          // Padus, Seni Tari, Dance, dll
            $table->string('tingkat', 20);                       // pakai App\Enums\TingkatPrestasi
            $table->string('peringkat', 20)->nullable();         // Juara 1, Harapan 2, dll
            $table->integer('tahun');
            $table->date('tanggal')->nullable();
            $table->string('penyelenggara', 100)->nullable();
            $table->string('lokasi', 100)->nullable();
            $table->string('foto', 255)->nullable();
            $table->text('deskripsi')->nullable();
            
            $table->unsignedBigInteger('id_user_pencatat')->nullable();
            
            $table->timestamps();

            $table->foreign('id_user_pencatat')
                  ->references('id_user')->on('users')
                  ->onDelete('set null');

            $table->index('tingkat');
            $table->index('tahun');
            $table->index('kategori');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasi');
    }
};