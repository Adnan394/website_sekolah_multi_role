@extends('layouts.admin')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
    <h1>Edit Kurikulum</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Edit Kurikulum</li>
    </ol>
    </nav>
</div>

<form action="{{ route('kurikulum.update',$data->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="mb-3">
    <label>Judul</label>
    <input type="text" name="judul" class="form-control" value="{{ $data->judul }}">
</div>

<div class="mb-3">
    <label>Tahun Ajaran</label>
    <input type="text" name="tahun_ajaran" class="form-control" value="{{ $data->tahun_ajaran }}">
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control">
        <option value="aktif" {{ $data->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="arsip" {{ $data->status == 'arsip' ? 'selected' : '' }}>Arsip</option>
    </select>
</div>

<div class="mb-3">
    <label>Deskripsi</label>
    <textarea name="deskripsi" id="editor" class="form-control">
        {!! $data->deskripsi !!}
    </textarea>
</div>

<div class="mb-3">
    <label>Gambar Struktur</label>
    <input type="file" name="gambar" class="form-control">
    @if($data->gambar)
        <img src="{{ asset('uploads/kurikulum/'.$data->gambar) }}" width="150" class="mt-2">
    @endif
</div>

<div class="mb-3">
    <label>File PDF</label>
    <input type="file" name="file_pdf" class="form-control">
    @if($data->file_pdf)
        <a href="{{ asset('uploads/kurikulum/'.$data->file_pdf) }}" target="_blank">File Lama</a>
    @endif
</div>

<button class="btn btn-danger">Update</button>

</form>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>

</main>
@endsection