@extends('layouts.app')
@section('title','Edit Penawaran')
@section('content')
    <div class="page-crumb">Keuangan / Input Penawaran / Edit</div>
    <h1 class="page-title">Edit Penawaran</h1>
    <div class="card">
        <form method="POST" action="{{ route('admin.penawaran.update', $item) }}" class="form">@method('PUT') @include('penawaran._form')</form>
    </div>
@endsection
