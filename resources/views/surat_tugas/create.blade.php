@extends('layouts.app')
@section('title','Buat Surat Tugas')
@section('content')
    <div class="page-crumb">Operasional / Surat Tugas / Baru</div>
    <h1 class="page-title">Buat Surat Tugas Baru</h1>
    <div class="card">
        <form method="POST" action="{{ route('admin.surat-tugas.store') }}" class="form">
            @php $item = null; @endphp
            @include('surat_tugas._form')
        </form>
    </div>
@endsection
