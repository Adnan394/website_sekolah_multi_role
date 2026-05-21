@extends('layouts.admin')
@section('content')

<main id="main" class="main">
<div class="pagetitle">
    <h1>Tambah User</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Edit User</li>
    </ol>
    </nav>
</div>
<section class="section">
<div class="card p-3">
<div class="card-body">
<h5 class="card-title">Tambah Data</h5>

<form action="{{ route('data_user.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="row">
    <div class="col">
        <label>Nama Lengkap</label>
        <input type="text" name="nama_lengkap" class="form-control">
    </div>
    <div class="col">
        <label>Username</label>
        <input type="text" name="username" class="form-control">
    </div>
</div>

<div class="row mt-3">
    <div class="col">
        <label>Email</label>
        <input type="email" name="email" class="form-control">
    </div>
    <div class="col">
        <label>Password</label>
        <input type="password" name="password" class="form-control">
    </div>
</div>

<div class="row mt-3">
    <div class="col">
        <label>Role</label>
        <select name="role" class="form-control">
            <option value="admin">Admin</option>
            <option value="guru">Guru</option>
            <option value="siswa">Siswa</option>
        </select>
    </div>
    <div class="col">
        <label>Jenis Kelamin</label>
        <select name="jenis_kelamin" class="form-control">
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
        </select>
    </div>
</div>

<div class="row mt-3">
    <div class="col">
        <label>Alamat</label>
        <input type="text" name="alamat" class="form-control">
    </div>
</div>

<div class="row mt-3">
    <div class="col">
        <label>Tempat Lahir</label>
        <input type="text" name="tempat_lahir" class="form-control">
    </div>
    <div class="col">
        <label>Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" class="form-control">
    </div>
</div>

<div class="row mt-3">
    <div class="col">
        <label>Foto</label>
        <input type="file" name="foto" class="form-control">
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-danger">Save</button>
    <a href="{{ route('data_user.index') }}" class="btn btn-secondary">Cancel</a>
</div>

</form>
</div>
</div>
</section>
</main>
@endsection