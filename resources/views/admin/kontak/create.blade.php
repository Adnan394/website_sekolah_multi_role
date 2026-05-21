@extends('layouts.admin')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Tambah Kontak Kami</h1>
        <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Tambah Kontak Kami</li>
        </ol>
        </nav>
    </div>

<form action="{{ route('kontak.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="mb-3">
    <label>Nama Tempat</label>
    <input type="text" name="nama_tempat" class="form-control">
</div>

<div class="mb-3">
    <label>Alamat</label>
    <textarea name="alamat" class="form-control"></textarea>
</div>

<div class="mb-3">
    <label>Telepon</label>
    <input type="text" name="telepon" class="form-control">
</div>

<div class="mb-3">
    <label>Email</label>
    <input type="text" name="email" class="form-control">
</div>

<div class="mb-3">
    <label>Facebook</label>
    <input type="text" name="facebook" class="form-control">
</div>

<div class="mb-3">
    <label>Instagram</label>
    <input type="text" name="instagram" class="form-control">
</div>

<div class="mb-3">
    <label>Youtube</label>
    <input type="text" name="youtube" class="form-control">
</div>

<div class="mb-3">
    <label>Embed Google Maps</label>
    <textarea name="maps_embed" class="form-control"></textarea>
</div>

<div class="mb-3">
    <label>Logo</label>
    <input type="file" name="logo" class="form-control">
</div>

<button class="btn btn-danger">Simpan</button>

</form>

</main>
@endsection