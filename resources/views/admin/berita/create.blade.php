@extends('layouts.admin')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
    <h1>Tambah Berita</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Tambah Berita</li>
    </ol>
    </nav>
</div>
<form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="mb-3">
    <label>Judul</label>
    <input type="text" name="judul" class="form-control">
</div>

<div class="mb-3">
    <label>Thumbnail</label>
    <input type="file" name="thumbnail" class="form-control">
</div>

<div class="mb-3">
    <label>Penulis</label>
    <input type="text" name="penulis" class="form-control">
</div>

<div class="mb-3">
    <label>Tanggal Publish</label>
    <input type="date" name="tanggal_publish" class="form-control">
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control">
        <option value="publish">Publish</option>
        <option value="draft">Draft</option>
    </select>
</div>

<div class="mb-3">
    <label>Konten</label>
    <textarea name="konten" id="editor" class="form-control"></textarea>
</div>

<button class="btn btn-danger">Simpan</button>

</form>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>

</main>
@endsection