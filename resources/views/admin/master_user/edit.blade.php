@extends('layouts.admin')
@section('content')

<style>
.upload-wrapper {
    border: 2px dashed #ccc;
    border-radius: 12px;
    padding: 40px;
    text-align: center;
    cursor: pointer;
}
input[type="file"] {
    display: none;
}
</style>

<main id="main" class="main">
<div class="pagetitle">
    <h1>Edit User</h1>
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

<h5 class="card-title">Edit Data</h5>

<form action="{{ route('data_user.update', $data->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="row">
    <div class="col">
        <label>Nama Lengkap</label>
        <input type="text" name="nama_lengkap" class="form-control"
            value="{{ $data->master_user->nama_lengkap }}">
    </div>
    <div class="col">
        <label>Username</label>
        <input type="text" name="username" class="form-control"
            value="{{ $data->username }}">
    </div>
</div>

<div class="row mt-3">
    <div class="col">
        <label>Email</label>
        <input type="email" name="email" class="form-control"
            value="{{ $data->email }}">
    </div>
    <div class="col">
        <label>Password (Opsional)</label>
        <input type="password" name="password" class="form-control">
    </div>
</div>

<div class="row mt-3">
    <div class="col">
        <label>Role</label>
        <select name="role" class="form-control">
            <option value="admin" {{ $data->role == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="guru" {{ $data->role == 'guru' ? 'selected' : '' }}>Guru</option>
            <option value="siswa" {{ $data->role == 'siswa' ? 'selected' : '' }}>Siswa</option>
        </select>
    </div>

    <div class="col">
        <label>Jenis Kelamin</label>
        <select name="jenis_kelamin" class="form-control">
            <option value="L" {{ $data->master_user->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ $data->master_user->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>
    </div>
</div>

<div class="row mt-3">
    <div class="col">
        <label>Alamat</label>
        <input type="text" name="alamat" class="form-control"
            value="{{ $data->master_user->alamat }}">
    </div>
</div>

<div class="row mt-3">
    <div class="col">
        <label>Tempat Lahir</label>
        <input type="text" name="tempat_lahir" class="form-control"
            value="{{ $data->master_user->tempat_lahir }}">
    </div>
    <div class="col">
        <label>Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" class="form-control"
            value="{{ $data->master_user->tanggal_lahir }}">
    </div>
</div>

<div class="row mt-3">
    <div class="col">
        <label>Foto</label>

        <label class="upload-wrapper">
            Klik untuk upload
            <input type="file" name="foto" id="inputFoto">
        </label>

        <!-- PREVIEW -->
        <div class="mt-3 text-center">
            <img id="previewImg"
                src="{{ $data->master_user->foto 
                    ? asset('uploads/foto_user/'.$data->master_user->foto) 
                    : asset('assets/img/defaultpp.webp') }}"
                style="max-width:200px;">
        </div>
    </div>
</div>

<div class="mt-4">
    <button class="btn btn-danger">Update</button>
    <a href="{{ route('data_user.index') }}" class="btn btn-secondary">Cancel</a>
</div>

</form>
</div>
</div>
</section>
</main>

<script>
const input = document.getElementById('inputFoto');
const preview = document.getElementById('previewImg');

input.addEventListener('change', function(){
    const file = this.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            preview.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>

@endsection