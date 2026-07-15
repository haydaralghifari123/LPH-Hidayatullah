@extends('landing.layout')
@section('title','Layanan')
@section('content')
<section class="page-hero">
    <div class="container">
        <div class="eyebrow">Layanan</div>
        <h1>Pemeriksaan Kehalalan Produk</h1>
        <p class="lead">Layanan lengkap dari verifikasi dokumen hingga penerbitan sertifikat halal resmi BPJPH.</p>
    </div>
</section>

<section class="content-section">
    <div class="container prose">
        <h2>Alur Sertifikasi Halal</h2>
        <ol>
            <li><b>Registrasi &amp; Dokumen</b> — Pelaku usaha registrasi di portal klien, upload dokumen persyaratan (NIB, daftar produk, daftar bahan, manual SJPH, dll).</li>
            <li><b>Verifikasi Dokumen</b> — Tim operasional LPH memverifikasi kelengkapan berkas.</li>
            <li><b>Penawaran Biaya</b> — Tim keuangan mengirim penawaran biaya sertifikasi (Surat Pembiayaan untuk DN, Quotation untuk LN).</li>
            <li><b>Pembayaran</b> — Klien membayar sesuai skema (Lunas, DP + Pelunasan, atau Termin).</li>
            <li><b>Penugasan Auditor</b> — Sistem merekomendasikan auditor terbaik berdasarkan kompetensi, jarak lokasi, dan beban kerja.</li>
            <li><b>Audit Lapangan</b> — Auditor melakukan pemeriksaan on-site di lokasi pelaku usaha.</li>
            <li><b>Laporan Hasil Audit</b> — LPH menerbitkan Audit Report dengan grade penilaian.</li>
            <li><b>Fatwa MUI</b> — Hasil audit diteruskan untuk sidang fatwa MUI.</li>
            <li><b>Penerbitan Sertifikat</b> — BPJPH menerbitkan sertifikat halal resmi, klien dapat mengunduh dari portal.</li>
        </ol>

        <h2>Ruang Lingkup</h2>
        <ul>
            <li>Makanan &amp; Minuman Olahan</li>
            <li>Obat, Kosmetik, dan Produk Kimiawi</li>
            <li>Produk Biologi &amp; Rekayasa Genetik</li>
            <li>Barang Gunaan (kemasan, tekstil, alat makan)</li>
            <li>Penyembelihan &amp; Rumah Potong Hewan</li>
            <li>Restoran, Katering, dan Layanan Pangan</li>
        </ul>

        <h2>Skala Usaha</h2>
        <p>Kami melayani pelaku usaha semua skala: <b>Mikro, Kecil, Menengah, Besar</b>, dan pelaku usaha luar negeri (foreign clients).</p>

        <div class="cta-inline">
            <div>
                <h3>Mulai Ajukan Sertifikasi</h3>
                <p>Buat akun portal klien untuk memulai proses.</p>
            </div>
            <a href="{{ route('portal.register') }}" class="btn btn-primary btn-lg">Daftar Portal Klien</a>
        </div>
    </div>
</section>
@endsection
