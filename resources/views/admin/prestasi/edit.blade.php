@extends('layouts.admin')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
    <h1>Edit Prestasi</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Edit Prestasi</li>
    </ol>
    </nav>
</div>

<section class="section">
<div class="card">
<div class="card-body mt-3">

<form action="{{ route('prestasi.update',$data->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="mb-3">
    <label>Title</label>
    <input type="text" name="title" class="form-control" value="{{ $data->title }}">
</div>

<div class="mb-3">
    <label>Description</label>
    <textarea name="description" id="editor" class="form-control">
        {!! $data->description !!}
    </textarea>
</div>

<div class="mb-3">
    <label>Gambar</label>
    <input type="file" name="gambar" class="form-control">
    <br>
    <img width="120" src="{{ asset('uploads/prestasi/'.$data->gambar) }}">
</div>

<button class="btn btn-danger">Update</button>
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