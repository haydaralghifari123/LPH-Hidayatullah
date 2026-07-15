<?php

namespace Database\Seeders;

use App\Models\Auditor;
use App\Models\Invoice;
use App\Models\Penawaran;
use App\Models\Perusahaan;
use App\Models\SertifikatHalal;
use App\Models\SuratTugas;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ============ USERS ============
        User::updateOrCreate(['username' => 'nafi'], [
            'nama_lengkap' => 'Nafi Hidayat',
            'email' => 'nafi@lph-hidayatullah.id',
            'password' => Hash::make('password'),
            'role' => 'operasional',
            'status' => 'aktif',
        ]);

        User::updateOrCreate(['username' => 'syahrul'], [
            'nama_lengkap' => 'Syahrul Karim',
            'email' => 'syahrul@lph-hidayatullah.id',
            'password' => Hash::make('password'),
            'role' => 'keuangan',
            'status' => 'aktif',
        ]);

        User::updateOrCreate(['username' => 'admin'], [
            'nama_lengkap' => 'Administrator',
            'email' => 'admin@lph-hidayatullah.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        // ============ AUDITORS ============
        $auditors = [
            ['AUD-001', 'Ahmad Sutrisno, S.T.',  'Jl. Mawar No.12, Yogyakarta', 'ahmad.s@lph.id',  '081234500001', 'S1 Teknik Pangan', null, null, 'Senior', 'aktif', 0, 'Sleman'],
            ['AUD-002', 'Siti Rahmawati, S.Pt.', 'Jl. Melati No.8, Sleman',    'siti.r@lph.id',    '081234500002', 'S1 Peternakan',   'S2 Ilmu Pangan', null, 'Madya', 'aktif', 1, 'Yogyakarta'],
            ['AUD-003', 'Bambang Wijaya, S.Si.', 'Jl. Kenanga No.5, Bantul',   'bambang.w@lph.id', '081234500003', 'S1 Kimia',        null, null, 'Senior', 'aktif', 0, 'Bantul'],
            ['AUD-004', 'Dewi Lestari, S.TP.',   'Jl. Anggrek No.3, Yogyakarta','dewi.l@lph.id',  '081234500004', 'S1 Teknik Pangan', null, null, 'Junior', 'cuti', 0, 'Yogyakarta'],
            ['AUD-005', 'Hadi Pranoto, S.Pt.',   'Jl. Cempaka No.7, Kulon Progo','hadi.p@lph.id', '081234500005', 'S1 Peternakan',   null, null, 'Madya', 'aktif', 2, 'Kulon Progo'],
        ];
        foreach ($auditors as [$no, $nama, $alamat, $email, $tel, $s1, $s2, $s3, $kom, $st, $bk, $kota]) {
            Auditor::updateOrCreate(['no_registrasi' => $no], [
                'nama' => $nama, 'alamat' => $alamat, 'email' => $email, 'no_telepon' => $tel,
                'pendidikan_s1' => $s1, 'pendidikan_s2' => $s2, 'pendidikan_s3' => $s3,
                'kompetensi' => $kom, 'status' => $st, 'beban_kerja' => $bk, 'lokasi_kota' => $kota,
            ]);
        }

        // ============ PERUSAHAAN ============
        $perusahaans = [
            ['REF-2026-0156', 'PT Berkah Makmur', 'BerkahFood', 'Kemasan Produk', 'Kecil', 'Snack Kemasan', 'Jl. Industri No.10', 'D.I. Yogyakarta', 'Sleman', 'info@berkahmakmur.id', '0274-111222', 'Audit Berjalan'],
            ['REF-2026-0157', 'UD Rezeki Barokah', 'Rezeki', 'Makanan Olahan', 'Mikro', 'Makanan Ringan', 'Jl. Kaliurang KM 7', 'D.I. Yogyakarta', 'Sleman', 'rezeki@email.id', '0274-333444', 'Selesai'],
            ['REF-2026-0158', 'CV Halal Sejahtera', 'HalalKu', 'Minuman', 'Menengah', 'Minuman Sehat', 'Jl. Magelang KM 5', 'D.I. Yogyakarta', 'Yogyakarta', 'cs@halalku.id', '0274-555666', 'Verifikasi'],
            ['REF-2026-0159', 'PT Pangan Nusantara', 'PanganNusa', 'Daging Olahan', 'Besar', 'Daging Beku', 'Jl. Solo KM 9', 'Jawa Tengah', 'Klaten', 'corp@pangannusa.id', '0272-888999', 'Pengajuan'],
        ];
        foreach ($perusahaans as [$ref, $nama, $merek, $ajuan, $skala, $produk, $alamat, $prov, $kota, $email, $tel, $stat]) {
            Perusahaan::updateOrCreate(['no_ref' => $ref], [
                'nama_pelaku_usaha' => $nama, 'merek_dagang' => $merek, 'jenis_ajuan' => $ajuan, 'skala' => $skala,
                'jenis_produk' => $produk, 'alamat' => $alamat, 'provinsi' => $prov, 'kota' => $kota,
                'email' => $email, 'no_telepon' => $tel, 'status' => $stat,
            ]);
        }

        // ============ PENAWARAN ============
        $perusahaan1 = Perusahaan::where('no_ref', 'REF-2026-0156')->first();
        Penawaran::updateOrCreate(['no_penawaran' => 'PNW-2026-0042'], [
            'perusahaan_id' => $perusahaan1->id,
            'tanggal_terbit' => '2026-05-13',
            'hok_jumlah_produk' => 15,
            'biaya_bpjph' => 350000,
            'biaya_lph' => 2500000,
            'biaya_transportasi' => 500000,
            'biaya_uji_lab' => 1200000,
            'total_biaya' => 4550000,
            'status' => 'disetujui',
        ]);

        // ============ SURAT TUGAS ============
        $auditor1 = Auditor::where('no_registrasi', 'AUD-001')->first();
        SuratTugas::updateOrCreate(['no_surat' => 'ST-2026-0157'], [
            'perusahaan_id' => $perusahaan1->id,
            'auditor_id' => $auditor1->id,
            'tanggal_terbit' => '2026-05-13',
            'tanggal_audit' => '2026-05-20',
            'lokasi' => 'Sleman, D.I. Yogyakarta',
            'catatan' => 'Audit kemasan produk',
            'status_kirim' => 'terkirim',
        ]);

        // ============ SERTIFIKAT ============
        $perusahaan2 = Perusahaan::where('no_ref', 'REF-2026-0157')->first();
        SertifikatHalal::updateOrCreate(['no_sertifikat' => 'LPH-2024-0067'], [
            'perusahaan_id' => $perusahaan2->id,
            'jenis_daftar' => 'Baru',
            'jenis_produk' => 'Makanan Ringan',
            'merek_dagang' => 'Rezeki',
            'tanggal_terbit' => '2024-08-12',
            'tanggal_expired' => '2028-08-12',
            'status' => 'Terbit',
        ]);

        // ============ INVOICE ============
        Invoice::updateOrCreate(['no_invoice' => 'INV-2026-0234'], [
            'perusahaan_id' => $perusahaan1->id,
            'tanggal_invoice' => '2026-05-13',
            'hok_jumlah_produk' => 15,
            'keterangan' => 'Tagihan biaya sertifikasi halal untuk produk kemasan PT Berkah Makmur Sejahtera',
            'total_tagihan' => 6550000,
            'diskon' => 500000,
            'grand_total' => 6050000,
            'skema_pembayaran' => 'Lunas / Sekali Bayar',
            'status' => 'terkirim',
        ]);
    }
}
