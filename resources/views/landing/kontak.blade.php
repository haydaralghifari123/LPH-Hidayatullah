@extends('landing.layout')
@section('title','Kontak')
@section('content')
<section class="page-hero">
    <div class="container">
        <div class="eyebrow">Kontak</div>
        <h1>Hubungi Kami</h1>
        <p class="lead">Tim kami siap menjawab pertanyaan seputar sertifikasi halal.</p>
    </div>
</section>

<section class="content-section">
    <div class="container contact-grid">
        <div class="contact-card">
            <div class="contact-icon"><x-icon name="map-pin" size="32"/></div>
            <h4>Kantor Pusat</h4>
            <p>Jl. Cipinang Cempedak No.14, Cipinang Cempedak, Jatinegara, Jakarta Timur, DKI Jakarta 13340</p>
        </div>
        <div class="contact-card">
            <div class="contact-icon"><x-icon name="building" size="32"/></div>
            <h4>Kantor Operasional</h4>
            <p>Ruko Anggrek 1, No 09, Grand Depok City, Jawa Barat</p>
        </div>
        <div class="contact-card">
            <div class="contact-icon"><x-icon name="phone" size="32"/></div>
            <h4>Telepon &amp; WA</h4>
            <p>0822-1111-5361 (Customer Care)<br>0822-1111-5367 (Keuangan)</p>
        </div>
        <div class="contact-card">
            <div class="contact-icon"><x-icon name="mail" size="32"/></div>
            <h4>Email</h4>
            <p>Customercare@lphhidayatullah.id<br>finance@lphhidayatullah.id</p>
        </div>
    </div>

    <div class="container" style="max-width:720px;margin-top:40px">
        <div class="cta-box" style="margin:0">
            <div>
                <h3>Sudah punya akun klien?</h3>
                <p>Login ke portal untuk lihat status pengajuan Anda.</p>
            </div>
            <div>
                <a href="{{ route('portal.login') }}" class="btn btn-primary btn-lg">Login Portal Klien</a>
            </div>
        </div>
    </div>
</section>
@endsection
