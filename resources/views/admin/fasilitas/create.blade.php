@extends('layouts.admin')

@section('content')
<main id="main" class="main">
<div class="pagetitle">
    <h1>Tambah Fasilitas Sekolah</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Tambah Fasilitas Sekolah</li>
    </ol>
    </nav>
</div>

<section class="section">
<div class="card">
<div class="card-body mt-3">

<form action="{{ route('fasilitas.store') }}" method="POST">
@csrf

<div class="mb-3">
    <label>Nama Fasilitas</label>
    <input type="text" name="nama" class="form-control">
</div>

<button class="btn btn-danger">Simpan</button>
<a href="{{ route('fasilitas.index') }}" class="btn btn-secondary">Kembali</a>

</form>

</div>
</div>
</section>

</main>
@endsection