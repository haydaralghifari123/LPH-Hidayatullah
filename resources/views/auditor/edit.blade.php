@extends('layouts.app')
@section('title','Edit Auditor')
@section('content')
    <div class="page-crumb">Operasional / Manajemen Auditor / Edit</div>
    <h1 class="page-title">Edit Auditor</h1>
    <div class="card">
        <form method="POST" action="{{ route('admin.auditor.update', $auditor) }}" class="form">
            @method('PUT')
            @include('auditor._form')
        </form>
    </div>
@endsection
