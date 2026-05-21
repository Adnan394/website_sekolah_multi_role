@extends('layouts.admin')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
    <h1>Tambah Struktur Organisasi</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Tambah Struktur Organisasi</li>
    </ol>
    </nav>
</div>

<section class="section">
<div class="card">
<div class="card-body mt-3">

<form action="{{ route('struktur.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="mb-3">
    <label>Nama</label>
    <input type="text" name="nama" class="form-control">
</div>

<div class="mb-3">
    <label>Jabatan</label>
    <input type="text" name="jabatan" class="form-control">
</div>

<div class="mb-3">
    <label>Atasan / Parent</label>
    <select name="parent_id" class="form-control">
        <option value="">-- Tidak Ada (Level Atas) --</option>
        @foreach($parent as $p)
            <option value="{{ $p->id }}">{{ $p->nama }} - {{ $p->jabatan }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Urutan</label>
    <input type="number" name="urutan" class="form-control">
</div>

<div class="mb-3">
    <label>Foto</label>
    <input type="file" name="foto" class="form-control">
</div>

<button class="btn btn-danger">Simpan</button>
<a href="{{ route('struktur.index') }}" class="btn btn-secondary">Kembali</a>

</form>

</div>
</div>
</section>

</main>
@endsection