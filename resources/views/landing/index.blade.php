@extends('landing.layout')
@section('title','Beranda')
@section('content')
<section class="jumbotron-carousel">
    @php
        $slides = [
            'images/banner-13.jpg',
            'images/banner-5.jpg',
            'images/banner-6.jpg',
            'images/pemeriksaan.jpg',
            'images/banner-2.jpg',
            'images/banner-4.jpg',
        ];
    @endphp
    <div class="carousel" id="heroCarousel" data-count="{{ count($slides) }}">
        <div class="carousel-track">
            @foreach ($slides as $i => $s)
                <div class="carousel-slide {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}">
                    <img src="{{ asset($s) }}" alt="LPH Hidayatullah slide {{ $i+1 }}">
                </div>
            @endforeach
        </div>
        <button class="carousel-btn prev" onclick="carouselNav(-1)" aria-label="Sebelumnya">‹</button>
        <button class="carousel-btn next" onclick="carouselNav(1)" aria-label="Berikutnya">›</button>
        <div class="carousel-dots">
            @foreach ($slides as $i => $s)
                <button class="dot {{ $i === 0 ? 'active' : '' }}" onclick="carouselGoTo({{ $i }})" aria-label="Slide {{ $i+1 }}"></button>
            @endforeach
        </div>
    </div>
</section>

<section class="hero-cta-section">
    <div class="container">
        <div class="badge-pill">LPH UTAMA · Terakreditasi BPJPH</div>
        <h1>Lembaga Pemeriksa Halal <span class="accent">Hidayatullah</span></h1>
        <p class="lead">LPH Hidayatullah terakreditasi sebagai <b>LPH UTAMA</b> dengan pemeriksaan seluruh ruang lingkup, dan menjadi <b>LPH Terbaik ke-2 se-Indonesia</b> pada tahun 2025.</p>
        <div class="hero-cta">
            <a href="{{ route('portal.register') }}" class="btn btn-primary btn-lg">Ajukan Sertifikasi</a>
            <a href="{{ route('landing.layanan') }}" class="btn btn-outline btn-lg">Pelajari Layanan</a>
        </div>
        <div class="hero-partners">
            <small>Terdaftar &amp; diakui</small>
            <span class="partner">BPJPH · MUI · Kementerian Agama</span>
        </div>
    </div>
</section>

<section class="stats-section">
    <div class="container stats-grid">
        <div class="stat">
            <div class="stat-num">{{ number_format($stats['produk']) }}+</div>
            <div class="stat-label">Produk Tersertifikasi</div>
        </div>
        <div class="stat">
            <div class="stat-num">{{ number_format($stats['usaha']) }}+</div>
            <div class="stat-label">Pelaku Usaha</div>
        </div>
        <div class="stat">
            <div class="stat-num">{{ number_format($stats['auditor']) }}+</div>
            <div class="stat-label">Auditor Bersertifikat</div>
        </div>
        <div class="stat">
            <div class="stat-num">{{ number_format($stats['sertifikat']) }}+</div>
            <div class="stat-label">Sertifikat Terbit</div>
        </div>
    </div>
</section>

<section class="about-section">
    <div class="container about-inner">
        <div>
            <div class="eyebrow">Tentang Kami</div>
            <h2>Mitra Terpercaya Sertifikasi Halal Indonesia</h2>
            <p>Lembaga Pemeriksa Halal (LPH) merupakan lembaga yang melakukan pemeriksaan dan pengujian terhadap kehalalan produk. <b>LPH Hidayatullah</b> merupakan salah satu LPH yang telah mendapatkan izin dari <b>BPJPH (Badan Penyelenggara Jaminan Produk Halal)</b> untuk melaksanakan fungsi pemeriksaan dan pengujian kehalalan produk yang diajukan oleh pelaku usaha melalui sistem PTSP Halal Kementerian Agama.</p>
            <p>Dengan tim auditor berpengalaman dan ruang lingkup pemeriksaan yang lengkap, kami membantu pelaku usaha di dalam dan luar negeri memperoleh sertifikat halal resmi dari BPJPH.</p>
            <img src="{{ asset('images/team.webp') }}" alt="Tim LPH Hidayatullah" style="width:100%;border-radius:12px;margin:20px 0">
            <a href="{{ route('landing.tentang') }}" class="btn btn-outline">Selengkapnya →</a>
        </div>
        <div class="feature-grid">
            <div class="feature">
                <div class="feature-icon"><x-icon name="award" size="28"/></div>
                <h4>LPH Utama</h4>
                <p>Terakreditasi kategori utama dengan seluruh ruang lingkup pemeriksaan.</p>
            </div>
            <div class="feature">
                <div class="feature-icon"><x-icon name="zap" size="28"/></div>
                <h4>Proses Cepat</h4>
                <p>Alur digital dari pengajuan sampai penerbitan sertifikat.</p>
            </div>
            <div class="feature">
                <div class="feature-icon"><x-icon name="globe" size="28"/></div>
                <h4>Klien Global</h4>
                <p>Melayani pelaku usaha dalam dan luar negeri.</p>
            </div>
            <div class="feature">
                <div class="feature-icon"><x-icon name="clipboard" size="28"/></div>
                <h4>Transparan</h4>
                <p>Setiap tahap terdokumentasi dan dapat dipantau klien.</p>
            </div>
        </div>
    </div>
</section>

<section class="services-section">
    <div class="container">
        <div class="section-head">
            <div class="eyebrow">Layanan</div>
            <h2>Ruang Lingkup Pemeriksaan Kehalalan</h2>
            <p class="section-sub">Kami melayani seluruh kategori produk yang wajib bersertifikat halal.</p>
        </div>
        <div class="service-grid">
            @foreach ([
                ['utensils','Makanan &amp; Minuman','Produk pangan olahan, minuman, snack, katering.'],
                ['pill','Obat &amp; Kosmetik','Obat-obatan, jamu, kosmetik, perawatan.'],
                ['flask','Bahan Kimiawi','Bahan penolong, aditif, kemasan pangan.'],
                ['butcher','Penyembelihan','Rumah potong hewan, sertifikasi juleha.'],
                ['dna','Rekayasa Genetik','Produk rekayasa genetik terapan.'],
                ['shirt','Barang Gunaan','Tekstil, kulit, kemasan, alat makan.'],
            ] as $s)
                <div class="service">
                    <div class="service-icon"><x-icon :name="$s[0]" size="36"/></div>
                    <h4>{!! $s[1] !!}</h4>
                    <p>{{ $s[2] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="banner-showcase">
    <div class="container">
        <div class="showcase-grid">
            <div class="showcase-item"><img src="{{ asset('images/banner-5.jpg') }}" alt="Kegiatan LPH Hidayatullah"></div>
            <div class="showcase-item"><img src="{{ asset('images/banner-6.jpg') }}" alt="Kegiatan LPH Hidayatullah"></div>
            <div class="showcase-item"><img src="{{ asset('images/pemeriksaan.jpg') }}" alt="Pemeriksaan Produk Halal"></div>
        </div>
    </div>
</section>

<section class="testimonials-section">
    <div class="container">
        <div class="section-head">
            <div class="eyebrow">Testimoni</div>
            <h2>Apa Kata Mereka</h2>
        </div>
        <div class="testimonial-grid">
            <div class="testimonial">
                <div class="quote-mark">"</div>
                <p>Saya percaya LPH Hidayatullah akan terus bertumbuh dan berkembang dalam melayani sertifikasi halal untuk pelaku usaha di seluruh Indonesia.</p>
                <div class="testimonial-author">
                    <b>Haikal Hasan</b>
                    <small>Kepala BPJPH</small>
                </div>
            </div>
            <div class="testimonial">
                <div class="quote-mark">"</div>
                <p>Saya bersyukur dengan kehadiran LPH Hidayatullah yang telah memberikan pelayanan terbaik dalam pemeriksaan kehalalan produk.</p>
                <div class="testimonial-author">
                    <b>Hamim Thohari</b>
                    <small>Ketua Umum</small>
                </div>
            </div>
            <div class="testimonial">
                <div class="quote-mark">"</div>
                <p>Sebagai tim LPH Hidayatullah, kami berkomitmen untuk memberikan layanan pemeriksaan halal yang profesional, transparan, dan terpercaya.</p>
                <div class="testimonial-author">
                    <b>Ubaidillah Navis</b>
                    <small>Ketua LPH Hidayatullah</small>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container cta-box">
        <div>
            <h3>Siap Mulai Proses Sertifikasi Halal?</h3>
            <p>Daftarkan usaha Anda dan pantau progres sertifikasi lewat portal klien kami.</p>
        </div>
        <div>
            <a href="{{ route('portal.register') }}" class="btn btn-primary btn-lg">Daftar Sekarang</a>
            <a href="{{ route('landing.kontak') }}" class="btn btn-outline btn-lg">Hubungi Kami</a>
        </div>
    </div>
</section>
@endsection
