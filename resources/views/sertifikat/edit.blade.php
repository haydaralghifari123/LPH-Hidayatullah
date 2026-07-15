@extends('layouts.app')
@section('title','Edit Sertifikat')
@section('content')
    <div class="page-crumb">Operasional / Surat Halal Terbit / Edit</div>
    <h1 class="page-title">Edit Sertifikat</h1>
    <div class="card">
        <form method="POST" action="{{ route('admin.sertifikat.update', $item) }}" class="form" enctype="multipart/form-data">
            @method('PUT')
            @include('sertifikat._form')
        </form>
    </div>
@endsection
