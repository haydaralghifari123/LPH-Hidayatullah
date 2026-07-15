@extends('layouts.app')
@section('title','Buat Invoice')
@section('content')
    <div class="page-crumb">Keuangan / Buat Invoice / Baru</div>
    <h1 class="page-title">Buat Invoice Client</h1>
    <p class="page-desc">Generate invoice tagihan untuk client dengan skema pembayaran fleksibel.</p>
    <div class="card">
        <form method="POST" action="{{ route('admin.invoice.store') }}" class="form">@php $item=null; @endphp @include('invoice._form')</form>
    </div>
@endsection
