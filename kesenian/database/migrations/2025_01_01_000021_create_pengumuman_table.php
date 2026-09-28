<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id('id_pengumuman');
            
            $table->string('judul', 150);
            $table->text('isi');
            $table->string('target_role', 20)->default('semua'); // pakai App\Enums\TargetPengumuman
            $table->string('lampiran', 255)->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            
            $table->unsignedBigInteger('id_user_pembuat');
            
            $table->timestamps();

            $table->foreign('id_user_pembuat')
                  ->references('id_user')->on('users')
                  ->onDelete('cascade');

            $table->index('target_role');
            $table->index('is_published');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumuman');
    }
};