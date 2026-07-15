<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auditors', function (Blueprint $table) {
            $table->id();
            $table->string('no_registrasi', 20)->unique();
            $table->string('nama', 100);
            $table->text('alamat')->nullable();
            $table->string('email', 100)->nullable();
            $table->string('no_telepon', 20)->nullable();
            $table->string('pendidikan_s1')->nullable();
            $table->string('pendidikan_s2')->nullable();
            $table->string('pendidikan_s3')->nullable();
            $table->enum('kompetensi', ['Junior', 'Madya', 'Senior'])->default('Junior');
            $table->enum('status', ['aktif', 'non-aktif', 'cuti'])->default('aktif');
            $table->integer('beban_kerja')->default(0);
            $table->string('lokasi_kota')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auditors');
    }
};
