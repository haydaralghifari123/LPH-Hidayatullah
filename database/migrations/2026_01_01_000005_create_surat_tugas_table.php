<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_tugas', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat', 30)->unique();
            $table->foreignId('perusahaan_id')->constrained('perusahaans')->cascadeOnDelete();
            $table->foreignId('auditor_id')->constrained('auditors')->cascadeOnDelete();
            $table->date('tanggal_terbit');
            $table->date('tanggal_audit');
            $table->text('lokasi')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status_kirim', ['belum', 'terkirim'])->default('belum');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_tugas');
    }
};
