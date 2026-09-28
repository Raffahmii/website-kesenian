<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kas_pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_kategori');
            
            $table->string('periode_bulan', 10);                 // contoh: "2026-01"
            $table->decimal('nominal', 10, 2);
            $table->string('status', 20)->default('belum_lunas'); // pakai App\Enums\StatusKas
            $table->date('tanggal_bayar')->nullable();
            $table->string('bukti_pembayaran', 255)->nullable();
            $table->text('catatan')->nullable();
            
            $table->unsignedBigInteger('id_user_pencatat')->nullable();
            
            $table->timestamps();

            $table->foreign('id_user')
                  ->references('id_user')->on('users')
                  ->onDelete('cascade');
            
            $table->foreign('id_kategori')
                  ->references('id_kategori')->on('kas_kategori')
                  ->onDelete('restrict');
            
            $table->foreign('id_user_pencatat')
                  ->references('id_user')->on('users')
                  ->onDelete('set null');

            $table->index('status');
            $table->index('periode_bulan');
            $table->index(['id_user', 'periode_bulan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kas_pembayaran');
    }
};