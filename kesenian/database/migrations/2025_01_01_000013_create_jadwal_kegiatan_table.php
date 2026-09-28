<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_kegiatan', function (Blueprint $table) {
            $table->id('id_jadwal');
            
            $table->string('judul', 100);
            $table->string('jenis', 20);                         // pakai App\Enums\JenisKegiatan
            $table->text('deskripsi')->nullable();
            $table->date('tanggal');
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->string('lokasi', 100)->nullable();
            $table->string('qr_token', 100)->unique()->nullable(); // untuk QR attendance
            $table->boolean('qr_active')->default(false);
            
            $table->unsignedBigInteger('id_user_pembuat')->nullable();
            
            $table->timestamps();

            $table->foreign('id_user_pembuat')
                  ->references('id_user')->on('users')
                  ->onDelete('set null');

            $table->index('tanggal');
            $table->index('jenis');
            $table->index(['tanggal', 'jenis']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_kegiatan');
    }
};