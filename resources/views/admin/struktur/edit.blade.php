@extends('layouts.admin')

@section('content')
<main id="main" class="main">
<div class="pagetitle">
    <h1>Edit Struktur Organisasi</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Edit Struktur Organisasi</li>
    </ol>
    </nav>
</div>

<section class="section">
<div class="card">
<div class="card-body mt-3">

<form action="{{ route('struktur.update',$data->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="mb-3">
    <label>Nama</label>
    <input type="text" name="nama" class="form-control" value="{{ $data->nama }}">
</div>

<div class="mb-3">
    <label>Jabatan</label>
    <input type="text" name="jabatan" class="form-control" value="{{ $data->jabatan }}">
</div>

<div class="mb-3">
    <label>Atasan / Parent</label>
    <select name="parent_id" class="form-control">
        <option value="">-- Tidak Ada --</option>
        @foreach($parent as $p)
            <option value="{{ $p->id }}" {{ $data->parent_id == $p->id ? 'selected' : '' }}>
                {{ $p->nama }} - {{ $p->jabatan }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Urutan</label>
    <input type="number" name="urutan" class="form-control" value="{{ $data->urutan }}">
</div>

<div class="mb-3">
    <label>Foto</label>
    <input type="file" name="foto" class="form-control">
    <br>
    <img width="100" src="{{ $data->foto ? asset('uploads/struktur/'.$data->foto) : asset('assets/img/defaultpp.webp') }}">
</div>

<button class="btn btn-danger">Update</button>
<a href="{{ route('struktur.index') }}" class="btn btn-secondary">Kembali</a>

</form>

</div>
</div>
</section>

</main>
@endsection