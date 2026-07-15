<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sertifikat_halals', function (Blueprint $table) {
            $table->id();
            $table->string('no_sertifikat', 30)->unique();
            $table->foreignId('perusahaan_id')->constrained('perusahaans')->cascadeOnDelete();
            $table->string('jenis_daftar', 30)->default('Baru');
            $table->string('jenis_produk')->nullable();
            $table->string('merek_dagang')->nullable();
            $table->date('tanggal_terbit');
            $table->date('tanggal_expired')->nullable();
            $table->enum('status', ['Menunggu', 'Terbit', 'Expired'])->default('Menunggu');
            $table->string('file_pdf')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sertifikat_halals');
    }
};
