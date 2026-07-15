@extends('landing.layout')
@section('title','Tentang Kami')
@section('content')
<section class="page-hero">
    <div class="container">
        <div class="eyebrow">Company Profile</div>
        <h1>Lembaga Pemeriksa Halal Hidayatullah</h1>
        <p class="lead">Terakreditasi LPH Utama oleh BPJPH — melayani pemeriksaan halal untuk seluruh ruang lingkup produk di Indonesia.</p>
    </div>
</section>

<!-- ============ PROFIL ============ -->
<section class="content-section">
    <div class="container prose">
        <div class="eyebrow">Profil</div>
        <h2>Profil LPH Hidayatullah</h2>
        <p>Ketetapan Musyawarah Nasional (Munas) Hidayatullah V, Nomor <b>12/TAP/MunasV/2020</b> tentang Kebijakan Strategis Hidayatullah Tahun 2020–2025 di bidang perekonomian dan sektor keuangan, mengamanatkan agar Hidayatullah menjadi pionir di bidang pangan halal dengan memberikan edukasi kepada masyarakat agar lebih memperhatikan masalah kehalalan pangan yang masyarakat konsumsi setiap hari.</p>
        <p>Menyadari adanya <b>Undang-Undang Nomor 33 Tahun 2014 tentang Jaminan Produk Halal</b>, kemudian Hidayatullah mengajukan permohonan menjadi Lembaga Pemeriksa Halal sebagaimana diatur dalam undang-undang No.33/2014.</p>
        <p>Akhirnya pada bulan <b>April 2022</b>, di bulan Ramadhan, LPH Hidayatullah menerima sertifikat akreditasi <b>REG RI LH A-1P12470020013122</b>, sejak itu LPH Hidayatullah melayani seluruh pemilik produk untuk mendapatkan sertifikat halal.</p>

        <div class="quote-card">
            <div class="quote-title">Pesan Ketua LPH Hidayatullah</div>
            <p><i>"LPH Hidayatullah berkomitmen sepenuhnya mendukung visi Indonesia menjadi pusat industri produk halal dunia."</i></p>
        </div>
    </div>
</section>

<!-- ============ AKREDITASI LPH UTAMA ============ -->
<section class="content-section" style="background:var(--bg)">
    <div class="container">
        <div class="section-head">
            <div class="eyebrow">Akreditasi</div>
            <h2>LPH UTAMA</h2>
        </div>
        <div class="two-col">
            <div class="col-image">
                <img src="{{ asset('images/slides/slide-03.png') }}" alt="Sertifikat Akreditasi LPH Utama" class="cropped-img" style="object-position: left center">
            </div>
            <div class="col-text">
                <p>Lembaga Pemeriksa Halal Hidayatullah berhasil mendapatkan <b>akreditasi utama</b> dengan nomor <b>REG RI LH A-2 U11000000000000000020853124</b>, diterbitkan pada <b>26 Agustus 2024</b> (berlaku sampai 26 Agustus 2028).</p>
                <p>Akreditasi ini mengukuhkan posisi LPH Hidayatullah sebagai lembaga pemeriksa halal terkemuka yang diakui secara nasional dan internasional untuk diaudit dalam <b>semua ruang lingkup</b>, menunjukkan komitmennya terhadap transparansi dan kualitas layanan pemeriksaan halal.</p>
                <p>Keberhasilan ini merupakan tonggak penting dalam upaya lembaga untuk terus meningkatkan standar layanan yang ditawarkannya.</p>
            </div>
        </div>
    </div>
</section>

<!-- ============ VISI MISI ============ -->
<section class="content-section">
    <div class="container prose">
        <div class="eyebrow">Visi &amp; Misi</div>
        <h2>Visi</h2>
        <p style="font-size:17px;font-style:italic;color:var(--dark)">Menjadi Lembaga Pemeriksa Halal yang terpercaya dan bereputasi global, berlandaskan nilai-nilai Islami.</p>

        <h2>Misi</h2>
        <ol class="numbered-list">
            <li>Memberikan layanan pemeriksaan halal yang profesional dan berstandar internasional.</li>
            <li>Mengembangkan SDM di dunia halal yang unggul berbasis nilai dakwah dan integritas.</li>
            <li>Memperluas jaringan dan kolaborasi untuk mendukung ekosistem halal global.</li>
            <li>Menerapkan teknologi inovatif dalam pelayanan halal.</li>
            <li>Menginspirasi gaya hidup halal sebagai bagian dari peradaban dunia.</li>
        </ol>
    </div>
</section>

<!-- ============ CORPORATE VALUE HALAL ============ -->
<section class="content-section" style="background:var(--bg)">
    <div class="container">
        <div class="section-head">
            <div class="eyebrow">Corporate Value</div>
            <h2>H · A · L · A · L</h2>
            <p class="section-sub">Lima nilai inti yang menjadi landasan setiap layanan kami.</p>
        </div>
        <div class="value-grid">
            <div class="value-card">
                <div class="value-letter">H</div>
                <div class="value-name">Honesty</div>
                <p>Menjunjung tinggi kejujuran dan transparansi.</p>
            </div>
            <div class="value-card">
                <div class="value-letter">A</div>
                <div class="value-name">Accountability</div>
                <p>Bertanggung jawab dalam setiap layanan.</p>
            </div>
            <div class="value-card">
                <div class="value-letter">L</div>
                <div class="value-name">Leadership</div>
                <p>Menjadi pelopor dalam ekosistem halal.</p>
            </div>
            <div class="value-card">
                <div class="value-letter">A</div>
                <div class="value-name">Adaptability</div>
                <p>Siap berinovasi sesuai perkembangan zaman.</p>
            </div>
            <div class="value-card">
                <div class="value-letter">L</div>
                <div class="value-name">Loyalty</div>
                <p>Komitmen penuh terhadap nilai Islami dan dakwah.</p>
            </div>
        </div>
        <div class="quote-card" style="max-width:800px;margin:30px auto 0">
            <p style="font-size:15px"><i>LPH Hidayatullah bertekad untuk menjadi lembaga halal yang tidak hanya melayani, tetapi juga menginspirasi perubahan positif.</i></p>
        </div>
    </div>
</section>

<!-- ============ TIM ============ -->
<section class="content-section">
    <div class="container prose">
        <div class="eyebrow">Tim Kami</div>
        <h2>Tim LPH Hidayatullah</h2>
        <p>Tim kami di LPH Hidayatullah terdiri dari individu-individu yang berpegang teguh pada prinsip-prinsip Islam, memiliki keahlian yang luas tidak hanya di industri makanan saja, tapi juga produk dan layanan lain seperti obat-obatan, kosmetik, produk kimia, produk biologi, barang gunaan dan jasa.</p>
        <p>Tim kami sangat cermat dan detail dalam memeriksa produk, bahan dan proses, sesuai dengan standar Halal. Berbudaya dan menghormati adat istiadat setempat serta mampu mengintegrasikannya dalam praktik sertifikasi Halal di tengah-tengah masyarakat Muslim Indonesia.</p>
        <p>Menjunjung tinggi standar etika, integritas, kejujuran, dan profesionalitas dalam bekerja. Auditor Halal kami dibekali dengan kemampuan yang mumpuni dan berpengalaman, untuk memperkuat komitmen kami dalam memberikan layanan terbaik dalam layanan sertifikasi Halal. Semangat kolaboratif dan kemampuan beradaptasi mereka terhadap dinamika perusahaan menjadi kontribusi yang sangat berharga bagi misi lembaga kami.</p>
        <img src="{{ asset('images/team.webp') }}" alt="Tim LPH Hidayatullah" style="width:100%;border-radius:12px;margin-top:16px">
    </div>
</section>

<!-- ============ PRESTASI PERINGKAT 2 ============ -->
<section class="content-section" style="background:var(--bg)">
    <div class="container">
        <div class="section-head">
            <div class="eyebrow">Pencapaian</div>
            <h2>Peringkat 2 Tahun 2025</h2>
            <p class="section-sub">LPH Hidayatullah menempati Peringkat 2 nasional berdasarkan penilaian SLA BPJPH.</p>
        </div>
        <div class="single-image">
            <img src="{{ asset('images/slides/slide-08.png') }}" alt="Peringkat 2 - SLA BPJPH 2025">
        </div>
        <p class="section-sub" style="margin-top:20px;max-width:800px;margin-left:auto;margin-right:auto">LPH Hidayatullah terus menunjukkan kinerja kuat dengan capaian layanan yang stabil dan waktu penyelesaian yang terjaga. Data ini menegaskan komitmen untuk menghadirkan pelayanan yang cepat, teliti, dan dapat diandalkan.</p>
    </div>
</section>

<!-- ============ 34 PERWAKILAN ============ -->
<section class="content-section">
    <div class="container">
        <div class="section-head">
            <div class="eyebrow">Jangkauan</div>
            <h2>34 Perwakilan LPH Hidayatullah</h2>
            <p class="section-sub">Menjangkau seluruh Indonesia dari Aceh sampai Papua.</p>
        </div>
        <div class="province-grid">
            @foreach ([
                'Aceh','Bali','Bangka Belitung','Banten','Bengkulu','Gorontalo','Jambi','Jawa Barat','Jawa Tengah','Jawa Timur','Kep. Riau','Kalsel','Kalteng','Kaltim','Kalbar','Kaltara','Lampung',
                'Maluku','Maluku Utara','NTT','NTB','Papua Selatan','Papua Barat','Papua Barat Daya','Riau','Sulbar','Sulteng','Sulsel','Sultra','Sulut','Sumbar','Sumsel','Sumut','Yogyakarta',
            ] as $prov)
                <div class="province-item"><x-icon name="map-pin" size="14"/> Perwakilan {{ $prov }}</div>
            @endforeach
        </div>
    </div>
</section>

<!-- ============ ALUR SERTIFIKASI ============ -->
<section class="content-section" style="background:var(--bg)">
    <div class="container">
        <div class="section-head">
            <div class="eyebrow">Proses</div>
            <h2>Alur Sertifikasi Halal</h2>
            <p class="section-sub">Total <b>21 Hari Kerja</b> dari verifikasi sampai penerbitan sertifikat.</p>
        </div>
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-day">2 Hari</div>
                <div class="timeline-content">
                    <b>1. Verifikasi BPJPH</b>
                    <p>BPJPH memverifikasi dokumen permohonan sertifikasi halal dari pelaku usaha.</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-day">15 Hari</div>
                <div class="timeline-content">
                    <b>2. Audit oleh LPH</b>
                    <p>LPH Hidayatullah melakukan pemeriksaan dan/atau pengujian kehalalan produk (audit dokumen dan lapangan).</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-day">3 Hari</div>
                <div class="timeline-content">
                    <b>3. Penetapan Kehalalan oleh MUI</b>
                    <p>Komisi Fatwa MUI mengeluarkan ketetapan halal produk.</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-day">1 Hari</div>
                <div class="timeline-content">
                    <b>4. Penerbitan Sertifikat oleh BPJPH</b>
                    <p>BPJPH menerbitkan sertifikat halal resmi.</p>
                </div>
            </div>
        </div>
        <div class="single-image" style="margin-top:30px">
            <img src="{{ asset('images/slides/slide-11.png') }}" alt="Diagram Alur Sertifikasi Halal">
        </div>
    </div>
</section>

<!-- ============ LAYANAN & RUANG LINGKUP ============ -->
<section class="content-section">
    <div class="container prose">
        <div class="eyebrow">Layanan Kami</div>
        <h2>Ruang Lingkup Pemeriksaan</h2>
        <p>Layanan utama kami fokus pada pelaksanaan fungsi sebagai <b>LPH atau Lembaga Pemeriksa Halal</b>, sebagaimana diamanatkan oleh <b>UU No. 33 Tahun 2014</b> yang mempunyai peranan yang sangat penting dalam pelaksanaan JPH (Jaminan Produk Halal) di Indonesia.</p>
        <p>Ruang lingkup LPH Hidayatullah meliputi pemeriksaan dan/atau pengujian kehalalan produk <b>makanan, minuman, obat, kosmetik, produk kimiawi, produk biologi, produk rekayasa genetik, serta barang gunaan</b>. LPH juga memeriksa jasa seperti <b>penyembelihan, pengolahan, pengemasan, penyimpanan, pendistribusian, penjualan, dan penyajian</b>.</p>
    </div>
</section>

<!-- ============ STATISTIK ============ -->
<section class="content-section" style="background:var(--primary);color:#fff">
    <div class="container">
        <div class="section-head" style="color:#fff">
            <div class="eyebrow" style="color:rgba(255,255,255,.85)">Statistik</div>
            <h2 style="color:#fff">Pencapaian dalam Angka</h2>
            <p class="section-sub" style="color:rgba(255,255,255,.85)">Data update: 22 April 2026</p>
        </div>
        <div class="big-stats">
            <div class="big-stat">
                <div class="big-num">3.241</div>
                <div class="big-label">Sertifikat Halal Reguler Terbit</div>
            </div>
            <div class="big-stat">
                <div class="big-num">+58.338</div>
                <div class="big-label">Produk / Menu Tersertifikasi</div>
            </div>
            <div class="big-stat">
                <div class="big-num">82</div>
                <div class="big-label">Auditor Bersertifikat</div>
            </div>
            <div class="big-stat">
                <div class="big-num">34</div>
                <div class="big-label">Perwakilan Provinsi</div>
            </div>
        </div>
    </div>
</section>
@endsection
