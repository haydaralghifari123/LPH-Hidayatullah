@extends('layouts.app')
@section('title','Edit Invoice')
@section('content')
    <div class="page-crumb">Keuangan / Buat Invoice / Edit</div>
    <h1 class="page-title">Edit Invoice</h1>
    <div class="card">
        <form method="POST" action="{{ route('admin.invoice.update', $item) }}" class="form">@method('PUT') @include('invoice._form')</form>
    </div>
@endsection
