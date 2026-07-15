<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('biaya_clients', function (Blueprint $table) {
            $table->id();
            $table->string('no_biaya', 30)->unique();
            $table->foreignId('perusahaan_id')->constrained('perusahaans')->cascadeOnDelete();
            $table->date('tanggal_terbit');
            $table->integer('hok_jumlah_produk')->default(1);
            $table->decimal('biaya_bpjph', 15, 2)->default(0);
            $table->decimal('biaya_lph', 15, 2)->default(0);
            $table->decimal('biaya_transportasi', 15, 2)->default(0);
            $table->decimal('biaya_uji_lab', 15, 2)->default(0);
            $table->decimal('total_biaya', 15, 2)->default(0);
            $table->enum('status', ['draft', 'final'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biaya_clients');
    }
};
