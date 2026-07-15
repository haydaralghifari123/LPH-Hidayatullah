@extends('layouts.app')
@section('title','Input Biaya Client')
@section('content')
    <div class="page-crumb">Keuangan / Input Biaya Client / Baru</div>
    <h1 class="page-title">Input Biaya yang Dibutuhkan</h1>
    <p class="page-desc">Catat semua komponen biaya yang harus dibayar oleh client.</p>
    <div class="card">
        <form method="POST" action="{{ route('admin.biaya-client.store') }}" class="form">@php $item=null; @endphp @include('biaya_client._form')</form>
    </div>
@endsection
