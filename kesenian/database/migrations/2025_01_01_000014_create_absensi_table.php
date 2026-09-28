<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id('id_absensi');
            
            $table->unsignedBigInteger('id_jadwal');
            $table->unsignedBigInteger('id_user');
            
            $table->string('status', 20)->default('alpa');       // pakai App\Enums\StatusAbsensi
            $table->timestamp('waktu_absen')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('metode', 20)->default('manual');     // manual / qr
            
            $table->timestamps();

            $table->foreign('id_jadwal')
                  ->references('id_jadwal')->on('jadwal_kegiatan')
                  ->onDelete('cascade');
            
            $table->foreign('id_user')
                  ->references('id_user')->on('users')
                  ->onDelete('cascade');

            $table->index('status');
            $table->unique(['id_jadwal', 'id_user'], 'unique_absensi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};