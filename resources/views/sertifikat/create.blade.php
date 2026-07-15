@extends('layouts.app')
@section('title','Terbitkan Sertifikat')
@section('content')
    <div class="page-crumb">Operasional / Surat Halal Terbit / Baru</div>
    <h1 class="page-title">Terbitkan Sertifikat Halal</h1>
    <div class="card">
        <form method="POST" action="{{ route('admin.sertifikat.store') }}" class="form" enctype="multipart/form-data">
            @php $item=null; @endphp
            @include('sertifikat._form')
        </form>
    </div>
@endsection
