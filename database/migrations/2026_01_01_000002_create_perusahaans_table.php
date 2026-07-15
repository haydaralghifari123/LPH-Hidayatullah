<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perusahaans', function (Blueprint $table) {
            $table->id();
            $table->string('no_ref', 30)->unique();
            $table->string('nama_pelaku_usaha', 150);
            $table->string('merek_dagang', 100)->nullable();
            $table->string('jenis_ajuan', 50);
            $table->enum('skala', ['Mikro', 'Kecil', 'Menengah', 'Besar']);
            $table->string('jenis_produk')->nullable();
            $table->text('alamat')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->string('email')->nullable();
            $table->string('no_telepon')->nullable();
            $table->enum('status', ['Pengajuan', 'Verifikasi', 'Audit Berjalan', 'Selesai', 'Ditolak'])->default('Pengajuan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perusahaans');
    }
};
