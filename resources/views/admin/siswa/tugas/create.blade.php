@extends('layouts.admin')
@section('content')
<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <div>
            <h1>Tugas Siswa</h1>
            <nav><ol class="breadcrumb"><li class="breadcrumb-item">Siswa</li><li class="breadcrumb-item active">Tugas Siswa</li></ol></nav>
        </div>
    </div>
    <section class="section">
        <div class="card p-3">
            <div class="card-body">        
                <h3>{{ $jadwal->judul_tugas }}</h3>
                <p>{{ $jadwal->deskripsi }}</p>
                <p>Tenggat: {{ $jadwal->tenggat_waktu->format('d-m-Y H:i') }}</p>
        
                <form action="{{ route('siswa-tugas.store', $jadwal) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label>Upload File</label>
                        <input type="file" name="file_upload" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Link Pengumpulan</label>
                        <input type="url" name="link_upload" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Kumpulkan Tugas</button>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection