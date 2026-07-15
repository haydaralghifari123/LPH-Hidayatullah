# LPH Hidayatullah — Sistem Manajemen Sertifikasi Halal

Aplikasi Laravel untuk mengelola alur kerja Lembaga Pemeriksa Halal (LPH) Hidayatullah:
pengajuan klien, dokumen audit, penugasan auditor, penerbitan sertifikat, penawaran biaya,
biaya client, dan invoice. Dibangun berdasarkan dokumen PIDB 23.62.0209 dan mockup UI Figma.

## Stack

- PHP 8.3 / Laravel 12
- SQLite (default, mudah dijalankan tanpa setup tambahan)
- Blade + CSS murni (warna primer `#C0392B`)

## Setup

```bash
composer install
cp .env.example .env          # jika belum ada
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

Buka [http://127.0.0.1:8000](http://127.0.0.1:8000).

## Kredensial Demo

| Username | Password | Role |
| --- | --- | --- |
| `nafi` | `password` | Operasional |
| `syahrul` | `password` | Keuangan |
| `admin` | `password` | Admin |

## Modul

**Operasional**
- Manajemen Auditor (CRUD)
- Pemilihan Auditor (rekomendasi berdasarkan jarak kota & beban kerja)
- Data Perusahaan / Pengajuan (CRUD)
- Surat Tugas (CRUD)
- Sertifikat Halal Terbit (CRUD + upload PDF)

**Keuangan**
- Input Penawaran (otomatis menghitung total biaya BPJPH + LPH + Transportasi + Uji Lab)
- Input Biaya Client (pemilahan komponen biaya per pos)
- Buat Invoice (skema pembayaran: Lunas / DP 50% / Termin 3x; otomatis hitung grand total - diskon)

## Skema Database

8 entitas utama:

- `users` — operasional / keuangan / admin
- `auditors` — kompetensi (Junior/Madya/Senior), beban kerja, lokasi kota
- `perusahaans` — pelaku usaha, merek dagang, skala, status pengajuan
- `penawarans` — rincian biaya penawaran sertifikasi
- `biaya_clients` — rincian biaya yang dibayar client
- `surat_tugas` — menghubungkan auditor & perusahaan
- `sertifikat_halals` — sertifikat yang diterbitkan
- `invoices` — tagihan dengan skema pembayaran fleksibel

## Struktur Folder Utama

```
app/Http/Controllers/    # 9 controllers (Auth, Dashboard, Auditor, Perusahaan, dst.)
app/Http/Middleware/     # RoleMiddleware
app/Models/              # 8 Eloquent models
database/migrations/     # 8 file migrasi
database/seeders/        # Demo users + 5 auditor + 4 perusahaan + sample data
resources/views/         # Blade views per modul (index/create/edit/show/_form)
public/css/app.css       # Tema warna #C0392B + komponen UI
routes/web.php           # Auth + resource routes (dilindungi middleware role)
```

## Catatan Pengembangan

- Pemilihan auditor di `PemilihanAuditorController` adalah implementasi sederhana
  (kesamaan kota + beban kerja). Ganti dengan geocoding / API peta jika perlu.
- Generate PDF (sertifikat, invoice) saat ini hanya upload manual. Tambahkan
  paket seperti `barryvdh/laravel-dompdf` untuk generate otomatis.
- 2FA untuk modul keuangan (KNF-02) belum diimplementasikan — gunakan
  `laravel/fortify` atau Google Authenticator package.
