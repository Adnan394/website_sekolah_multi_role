@extends('layouts.admin')

@section('content')
<main id="main" class="main">
<div class="pagetitle">
    <h1>Tambah Kurikulum</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Tambah Kurikulum</li>
    </ol>
    </nav>
</div>

<form action="{{ route('kurikulum.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="mb-3">
    <label>Judul</label>
    <input type="text" name="judul" class="form-control">
</div>

<div class="mb-3">
    <label>Tahun Ajaran</label>
    <input type="text" name="tahun_ajaran" class="form-control">
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control">
        <option value="aktif">Aktif</option>
        <option value="arsip">Arsip</option>
    </select>
</div>

<div class="mb-3">
    <label>Deskripsi</label>
    <textarea name="deskripsi" id="editor" class="form-control"></textarea>
</div>

<div class="mb-3">
    <label>Gambar Struktur</label>
    <input type="file" name="gambar" class="form-control">
</div>

<div class="mb-3">
    <label>File PDF</label>
    <input type="file" name="file_pdf" class="form-control">
</div>

<button class="btn btn-danger">Simpan</button>

</form>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>

</main>
@endsection