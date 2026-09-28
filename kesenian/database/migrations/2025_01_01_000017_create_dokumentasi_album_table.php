<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumentasi_album', function (Blueprint $table) {
            $table->id('id_album');
            
            $table->string('judul', 100);
            $table->text('deskripsi')->nullable();
            $table->string('cover_image', 255)->nullable();
            $table->string('kategori', 50)->nullable();          // Pentas, Latihan, Lomba, dll
            $table->date('tanggal_kegiatan')->nullable();
            
            $table->unsignedBigInteger('id_jadwal')->nullable();
            $table->unsignedBigInteger('id_user_uploader');
            
            $table->timestamps();

            $table->foreign('id_jadwal')
                  ->references('id_jadwal')->on('jadwal_kegiatan')
                  ->onDelete('set null');
            
            $table->foreign('id_user_uploader')
                  ->references('id_user')->on('users')
                  ->onDelete('cascade');

            $table->index('kategori');
            $table->index('tanggal_kegiatan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumentasi_album');
    }
};