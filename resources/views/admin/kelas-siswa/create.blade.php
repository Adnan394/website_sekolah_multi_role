@extends('layouts.admin')
@section('content')
@php
    $kelas_id = request()->query('kelas_id'); // ambil ?kelas_id=1
@endphp

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Tambah Siswa ke Kelas {{ $kelas->nama_kelas }}</h1>
    <nav><ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('kelas-siswa.detail', $kelas_id) }}">Detail Kelas</a></li>
      <li class="breadcrumb-item active">Tambah Siswa</li>
    </ol></nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Form Penambahan Siswa</h5>
            <form action="{{ route('kelas-siswa.store', $kelas_id) }}" method="POST">
              @csrf
              <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">

              <div class="mb-3">
                  <label class="form-label fw-semibold">Pilih Siswa</label>
                  <select name="siswa_id" class="form-select select2" required>
                      <option value="">-- Cari Siswa --</option>
                      @foreach($siswaTersedia as $s)
                          <option value="{{ $s->id }}">{{ $s->nisn }} - {{ $s->nama_lengkap }}</option>
                      @endforeach
                  </select>
                  @error('siswa_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
              </div>

              <div class="mb-3">
                  <label class="form-label fw-semibold">Nomor Absen</label>
                  <input type="text" name="nomor_absen" class="form-control" placeholder="Contoh: 01">
                  @error('nomor_absen')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
              </div>

              <div class="text-end mt-4">
                  <a href="{{ route('kelas-siswa.detail', $kelas_id) }}" class="btn btn-secondary me-2">Batal</a>
                  <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan</button>
              </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection