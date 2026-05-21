@extends('layouts.admin')

@section('content')
<main id="main" class="main">
<div class="pagetitle">
    <h1>Edit Kontak Kami</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Edit Kontak Kami</li>
    </ol>
    </nav>
</div>
<form action="{{ route('kontak.update',$data->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="mb-3">
    <label>Nama Tempat</label>
    <input type="text" name="nama_tempat" class="form-control" value="{{ $data->nama_tempat }}">
</div>

<div class="mb-3">
    <label>Alamat</label>
    <textarea name="alamat" class="form-control">{{ $data->alamat }}</textarea>
</div>

<div class="mb-3">
    <label>Telepon</label>
    <input type="text" name="telepon" class="form-control" value="{{ $data->telepon }}">
</div>

<div class="mb-3">
    <label>Email</label>
    <input type="text" name="email" class="form-control" value="{{ $data->email }}">
</div>

<div class="mb-3">
    <label>Facebook</label>
    <input type="text" name="facebook" class="form-control" value="{{ $data->facebook }}">
</div>

<div class="mb-3">
    <label>Instagram</label>
    <input type="text" name="instagram" class="form-control" value="{{ $data->instagram }}">
</div>

<div class="mb-3">
    <label>Youtube</label>
    <input type="text" name="youtube" class="form-control" value="{{ $data->youtube }}">
</div>

<div class="mb-3">
    <label>Embed Google Maps</label>
    <textarea name="maps_embed" class="form-control">{{ $data->maps_embed }}</textarea>
</div>

<div class="mb-3">
    <label>Logo</label>
    <input type="file" name="logo" class="form-control">
    <br>
    <img src="{{ asset('uploads/kontak/'.$data->logo) }}" width="120">
</div>

<button class="btn btn-danger">Update</button>

</form>

</main>
@endsection