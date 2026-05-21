@extends('layouts.admin')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Kontak Kami</h1>
        <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Kontak Kami</li>
        </ol>
        </nav>
    </div>

@if($data)
    <a href="{{ route('kontak.edit',$data->id) }}" class="btn btn-warning mb-3">Edit</a>
@else
    <a href="{{ route('kontak.create') }}" class="btn btn-danger mb-3">Tambah</a>
@endif

<div class="card">
<div class="card-body mt-3">

@if($data)
    <p><b>Nama Tempat:</b> {{ $data->nama_tempat }}</p>
    <p><b>Alamat:</b> {{ $data->alamat }}</p>
    <p><b>Telepon:</b> {{ $data->telepon }}</p>
    <p><b>Email:</b> {{ $data->email }}</p>
    <p><b>Facebook:</b> {{ $data->facebook }}</p>
    <p><b>Instagram:</b> {{ $data->instagram }}</p>
    <p><b>Youtube:</b> {{ $data->youtube }}</p>

    @if($data->logo)
        <img src="{{ asset('uploads/kontak/'.$data->logo) }}" width="120">
    @endif

    <div class="mt-3">
        {!! $data->maps_embed !!}
    </div>
@endif

</div>
</div>

</main>
@endsection