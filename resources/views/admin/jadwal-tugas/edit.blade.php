@extends('layouts.admin')

@section('content')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Edit Tugas</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('jadwal-tugas.index') }}">Jadwal Tugas</a></li>
        <li class="breadcrumb-item active">Edit Tugas</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body pt-4">
            <h5 class="card-title">Edit: {{ $tugas->judul_tugas }}</h5>

            <form action="{{ route('jadwal-tugas.update', $tugas->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')

              <div class="row g-3">
                <div class="col-md-12">
                  <label class="form-label fw-semibold">Judul Tugas <span class="text-danger">*</span></label>
                  <input type="text" name="judul_tugas" class="form-control @error('judul_tugas') is-invalid @enderror" value="{{ old('judul_tugas', $tugas->judul_tugas) }}">
                </div>

                <div class="col-md-4">
                  <label class="form-label fw-semibold">Mata Pelajaran</label>
                  <select name="pelajaran_id" class="form-select">
                    @foreach($pelajaranList as $p)
                      <option value="{{ $p->id }}" {{ $tugas->pelajaran_id == $p->id ? 'selected' : '' }}>{{ $p->nama_pelajaran }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-4">
                  <label class="form-label fw-semibold">Kelas</label>
                  <select name="kelas_id" class="form-select">
                    @foreach($kelasList as $k)
                      <option value="{{ $k->id }}" {{ $tugas->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-4">
                  <label class="form-label fw-semibold">Guru Pengampu</label>
                  <select name="guru_id" class="form-select">
                    @foreach($guruList as $g)
                      <option value="{{ $g->id }}" {{ $tugas->guru_id == $g->id ? 'selected' : '' }}>{{ $g->nama_lengkap }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-semibold">Tanggal Mulai</label>
                  <input type="datetime-local" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai', $tugas->tanggal_mulai->format('Y-m-d\TH:i')) }}">
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-semibold">Tenggat Waktu</label>
                  <input type="datetime-local" name="tenggat_waktu" class="form-control" value="{{ old('tenggat_waktu', $tugas->tenggat_waktu->format('Y-m-d\TH:i')) }}">
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-semibold">File Lampiran</label>
                  @if($tugas->file_tugas)
                    <div class="mb-2">
                      <small class="text-muted">File saat ini: <a href="{{ Storage::url($tugas->file_tugas) }}" target="_blank">Lihat File</a></small>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="hapus_file" id="hapus_file" value="1">
                        <label class="form-check-label text-danger small" for="hapus_file">Hapus file saat ini</label>
                      </div>
                    </div>
                  @endif
                  <input type="file" name="file_tugas" class="form-control">
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-semibold">Metode & Nilai</label>
                  <div class="input-group">
                    <select name="tipe_pengumpulan" class="form-select">
                      @foreach($tipeList as $tipe)
                        <option value="{{ $tipe }}" {{ $tugas->tipe_pengumpulan == $tipe ? 'selected' : '' }}>{{ $tipe }}</option>
                      @endforeach
                    </select>
                    <input type="number" name="nilai_maksimal" class="form-control" placeholder="Nilai Max" value="{{ old('nilai_maksimal', $tugas->nilai_maksimal) }}">
                  </div>
                </div>

                <div class="col-12">
                  <label class="form-label fw-semibold">Deskripsi</label>
                  <textarea name="deskripsi" rows="4" class="form-control">{{ old('deskripsi', $tugas->deskripsi) }}</textarea>
                </div>

                <div class="col-12">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_published" name="is_published" value="1" {{ $tugas->is_published ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="is_published">Aktif / Publikasikan</label>
                  </div>
                </div>

                <div class="col-12 d-flex gap-2 mt-4">
                  <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle me-1"></i> Perbarui Tugas
                  </button>
                  <a href="{{ route('jadwal-tugas.show', $tugas->id) }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-1"></i> Batal
                  </a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection