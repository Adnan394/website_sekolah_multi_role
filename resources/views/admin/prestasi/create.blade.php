@extends('layouts.admin')

@section('content')
<main id="main" class="main">
<div class="pagetitle">
    <h1>Tambah Prestasi</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Tambah Prestasi</li>
    </ol>
    </nav>
</div>
<section class="section">
<div class="card">
<div class="card-body mt-3">

<form action="{{ route('prestasi.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="mb-3">
    <label>Title</label>
    <input type="text" name="title" class="form-control">
</div>

<div class="mb-3">
    <label>Description</label>
    <textarea name="description" id="editor" class="form-control"></textarea>
</div>

<div class="mb-3">
    <label>Gambar</label>
    <input type="file" name="gambar" class="form-control">
</div>

<button class="btn btn-danger">Simpan</button>
<a href="{{ route('prestasi.index') }}" class="btn btn-secondary">Kembali</a>

</form>

</div>
</div>
</section>

</main>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>

@endsection