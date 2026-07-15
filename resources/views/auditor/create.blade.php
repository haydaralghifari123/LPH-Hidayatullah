@extends('layouts.app')
@section('title','Tambah Auditor')
@section('content')
    <div class="page-crumb">Operasional / Manajemen Auditor / Tambah</div>
    <h1 class="page-title">Tambah Auditor Baru</h1>
    <div class="card">
        <form method="POST" action="{{ route('admin.auditor.store') }}" class="form">
            @include('auditor._form')
        </form>
    </div>
@endsection
