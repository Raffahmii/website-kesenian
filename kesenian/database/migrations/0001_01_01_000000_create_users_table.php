<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // Primary key custom (pakai id_user, bukan id)
            $table->id('id_user');

            // Auth fields (dari Breeze)
            $table->string('nama_lengkap', 100);
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);

            // Custom fields
            $table->string('nis', 20)->unique()->nullable();
            $table->string('role', 30)->default('anggota');      // pakai App\Enums\RoleUser
            $table->string('kelas', 20)->nullable();
            $table->string('jurusan', 50)->nullable();
            $table->string('angkatan', 10)->nullable();
            $table->string('status_anggota', 20)->default('aktif'); // pakai App\Enums\StatusAnggota
            $table->string('photo', 255)->nullable();
            $table->string('phone', 15)->nullable();

            $table->rememberToken();
            $table->timestamps();

            // Index untuk query cepat
            $table->index('role');
            $table->index('status_anggota');
            $table->index(['kelas', 'jurusan']);
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};