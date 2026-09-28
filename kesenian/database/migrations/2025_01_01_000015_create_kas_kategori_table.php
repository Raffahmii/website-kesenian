<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kas_kategori', function (Blueprint $table) {
            $table->id('id_kategori');
            
            $table->string('nama', 50);                          // Kas Bulanan, Iuran Event, dll
            $table->decimal('nominal', 10, 2);
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();

            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kas_kategori');
    }
};