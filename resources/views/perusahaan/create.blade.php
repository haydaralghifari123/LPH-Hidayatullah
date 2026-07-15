@extends('layouts.app')
@section('title','Tambah Pengajuan')
@section('content')
    <div class="page-crumb">Operasional / Data Perusahaan / Tambah</div>
    <h1 class="page-title">Tambah Pengajuan Baru</h1>
    <div class="card">
        <form method="POST" action="{{ route('admin.perusahaan.store') }}" class="form">
            @include('perusahaan._form')
        </form>
    </div>
@endsection
