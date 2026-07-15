@extends('layouts.app')
@section('title','Edit Pengajuan')
@section('content')
    <div class="page-crumb">Operasional / Data Perusahaan / Edit</div>
    <h1 class="page-title">Edit Pengajuan</h1>
    <div class="card">
        <form method="POST" action="{{ route('admin.perusahaan.update', $perusahaan) }}" class="form">
            @method('PUT')
            @include('perusahaan._form')
        </form>
    </div>
@endsection
