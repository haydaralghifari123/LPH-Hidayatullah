@extends('layouts.app')
@section('title','Buat Penawaran')
@section('content')
    <div class="page-crumb">Keuangan / Input Penawaran / Baru</div>
    <h1 class="page-title">Input Data Penawaran</h1>
    <p class="page-desc">Buat penawaran biaya sertifikasi halal untuk klien.</p>
    <div class="card">
        <form method="POST" action="{{ route('admin.penawaran.store') }}" class="form">@php $item=null; @endphp @include('penawaran._form')</form>
    </div>
@endsection
