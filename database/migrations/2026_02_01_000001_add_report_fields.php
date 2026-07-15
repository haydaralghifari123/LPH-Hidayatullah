<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perusahaans', function (Blueprint $table) {
            $table->string('business_license_no', 60)->nullable()->after('merek_dagang');
            $table->boolean('is_foreign')->default(false)->after('provinsi');
            $table->integer('jumlah_produk')->default(1)->after('is_foreign');
            $table->integer('jumlah_pabrik')->default(1)->after('jumlah_produk');
            $table->integer('jumlah_bahan')->default(1)->after('jumlah_pabrik');
        });

        Schema::table('surat_tugas', function (Blueprint $table) {
            $table->string('scope_audit')->nullable()->after('lokasi');
            $table->enum('audit_rating', ['A', 'B', 'C', 'D'])->nullable()->after('scope_audit');
            $table->text('hasil_audit')->nullable()->after('audit_rating');
        });

        Schema::table('penawarans', function (Blueprint $table) {
            $table->string('mata_uang', 5)->default('IDR')->after('perusahaan_id');
            $table->decimal('travel_time_allowance', 15, 2)->default(0)->after('biaya_uji_lab');
            $table->decimal('tta_per_day', 15, 2)->default(0)->after('travel_time_allowance');
            $table->decimal('hok_pabrik', 15, 2)->default(0)->after('tta_per_day');
            $table->decimal('hok_bahan', 15, 2)->default(0)->after('hok_pabrik');
        });
    }

    public function down(): void
    {
        Schema::table('perusahaans', function (Blueprint $table) {
            $table->dropColumn(['business_license_no', 'is_foreign', 'jumlah_produk', 'jumlah_pabrik', 'jumlah_bahan']);
        });
        Schema::table('surat_tugas', function (Blueprint $table) {
            $table->dropColumn(['scope_audit', 'audit_rating', 'hasil_audit']);
        });
        Schema::table('penawarans', function (Blueprint $table) {
            $table->dropColumn(['mata_uang', 'travel_time_allowance', 'tta_per_day', 'hok_pabrik', 'hok_bahan']);
        });
    }
};
