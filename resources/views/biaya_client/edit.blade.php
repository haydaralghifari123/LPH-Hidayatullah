@extends('layouts.app')
@section('title','Edit Biaya Client')
@section('content')
    <div class="page-crumb">Keuangan / Biaya Client / Edit</div>
    <h1 class="page-title">Edit Biaya Client</h1>
    <div class="card">
        <form method="POST" action="{{ route('admin.biaya-client.update', $item) }}" class="form">@method('PUT') @include('biaya_client._form')</form>
    </div>
@endsection
