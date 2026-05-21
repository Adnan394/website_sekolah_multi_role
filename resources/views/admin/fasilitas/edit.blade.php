@extends('layouts.admin')

@section('content')
<main id="main" class="main">
<div class="pagetitle">
    <h1>Edit Fasilitas Sekolah</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Edit Fasilitas Sekolah</li>
    </ol>
    </nav>
</div>
<section class="section">
<div class="card">
<div class="card-body mt-3">

<form action="{{ route('fasilitas.update',$data->id) }}" method="POST">
@csrf
@method('PUT')

<div class="mb-3">
    <label>Nama Fasilitas</label>
    <input type="text" name="nama" class="form-control" value="{{ $data->nama }}">
</div>

<button class="btn btn-danger">Update</button>
<a href="{{ route('fasilitas.index') }}" class="btn btn-secondary">Kembali</a>

</form>

</div>
</div>
</section>

</main>
@endsection