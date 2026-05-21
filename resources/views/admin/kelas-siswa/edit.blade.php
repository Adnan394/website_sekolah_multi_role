@extends('layouts.admin')
@section('content')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Edit Data Kelas Siswa</h1>
    <nav><ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('kelas-siswa.detail', $kelas->id) }}">Detail Kelas</a></li>
      <li class="breadcrumb-item active">Edit</li>
    </ol></nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Edit Penugasan: {{ $siswa->nama_lengkap }}</h5>
            <form action="{{ route('kelas-siswa.update', [$kelas->id, $siswa->id]) }}" method="POST">
              @csrf
              @method('PUT')

              <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
              <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">

              <div class="mb-3">
                  <label class="form-label text-muted">Kelas</label>
                  <input type="text" class="form-control" value="{{ $kelas->nama_kelas }}" disabled>
              </div>

              <div class="mb-3">
                  <label class="form-label fw-semibold">Nomor Absen</label>
                  <input type="text" name="nomor_absen" class="form-control" value="{{ old('nomor_absen', $pivotData->nomor_absen) }}">
              </div>

              <div class="mb-3">
                  <label class="form-label fw-semibold">Status di Kelas</label>
                  <select name="status" class="form-select">
                      @foreach(['Aktif', 'Lulus', 'Pindah', 'Keluar'] as $st)
                          <option value="{{ $st }}" {{ $pivotData->status == $st ? 'selected' : '' }}>{{ $st }}</option>
                      @endforeach
                  </select>
              </div>

              <div class="text-end mt-4">
                  <a href="{{ route('kelas-siswa.detail', $kelas->id) }}" class="btn btn-secondary me-2">Batal</a>
                  <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Update</button>
              </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection