<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice', 30)->unique();
            $table->foreignId('perusahaan_id')->constrained('perusahaans')->cascadeOnDelete();
            $table->date('tanggal_invoice');
            $table->integer('hok_jumlah_produk')->default(1);
            $table->text('keterangan')->nullable();
            $table->decimal('total_tagihan', 15, 2)->default(0);
            $table->decimal('diskon', 15, 2)->default(0);
            $table->decimal('grand_total', 15, 2)->default(0);
            $table->enum('skema_pembayaran', ['Lunas / Sekali Bayar', 'DP 50% / Pelunasan', 'Termin 3x'])->default('Lunas / Sekali Bayar');
            $table->enum('status', ['draft', 'terkirim', 'lunas'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
