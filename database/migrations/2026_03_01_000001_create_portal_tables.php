<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perusahaan_id')->nullable()->constrained('perusahaans')->nullOnDelete();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nama_pic', 100);
            $table->string('no_hp', 20)->nullable();
            $table->string('jabatan')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('client_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perusahaan_id')->constrained('perusahaans')->cascadeOnDelete();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->string('jenis_dokumen', 60);
            $table->string('nama_file');
            $table->string('file_path');
            $table->integer('file_size')->default(0);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('catatan_staf')->nullable();
            $table->timestamps();
        });

        Schema::table('penawarans', function (Blueprint $table) {
            $table->timestamp('disetujui_klien_at')->nullable()->after('status');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->string('bukti_transfer_path')->nullable()->after('status');
            $table->timestamp('bukti_uploaded_at')->nullable()->after('bukti_transfer_path');
        });

        Schema::table('perusahaans', function (Blueprint $table) {
            $table->string('nib', 30)->nullable()->after('business_license_no');
            $table->string('npwp', 30)->nullable()->after('nib');
            $table->string('no_sihalal', 40)->nullable()->after('npwp');
        });
    }

    public function down(): void
    {
        Schema::table('perusahaans', function (Blueprint $table) {
            $table->dropColumn(['nib', 'npwp', 'no_sihalal']);
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['bukti_transfer_path', 'bukti_uploaded_at']);
        });
        Schema::table('penawarans', function (Blueprint $table) {
            $table->dropColumn('disetujui_klien_at');
        });
        Schema::dropIfExists('client_documents');
        Schema::dropIfExists('clients');
    }
};
