@extends('layouts.app')
@section('title','Edit Surat Tugas')
@section('content')
    <div class="page-crumb">Operasional / Surat Tugas / Edit</div>
    <h1 class="page-title">Edit Surat Tugas</h1>
    <div class="card">
        <form method="POST" action="{{ route('admin.surat-tugas.update', $item) }}" class="form">
            @method('PUT')
            @include('surat_tugas._form')
        </form>
    </div>
@endsection
