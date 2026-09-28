<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumentasi_media', function (Blueprint $table) {
            $table->id('id_media');
            
            $table->unsignedBigInteger('id_album');
            
            $table->string('tipe', 10);                          // pakai App\Enums\TipeMedia (foto/video)
            $table->string('file_path', 255);
            $table->string('thumbnail', 255)->nullable();        // untuk video
            $table->string('caption', 150)->nullable();
            $table->integer('urutan')->default(0);
            
            $table->timestamps();

            $table->foreign('id_album')
                  ->references('id_album')->on('dokumentasi_album')
                  ->onDelete('cascade');

            $table->index('tipe');
            $table->index(['id_album', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumentasi_media');
    }
};