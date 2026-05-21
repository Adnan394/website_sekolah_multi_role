@extends('layouts.admin')

@section('content')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Tambah Tugas</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('jadwal-tugas.index') }}">Jadwal Tugas</a></li>
        <li class="breadcrumb-item active">Tambah Tugas</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body pt-4">
            <h5 class="card-title">Form Tambah Tugas Baru</h5>

            @if($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('jadwal-tugas.store') }}" method="POST" enctype="multipart/form-data">
              @csrf

              <div class="row g-3">
                {{-- Judul Tugas --}}
                <div class="col-md-12">
                  <label for="judul_tugas" class="form-label fw-semibold">Judul Tugas <span class="text-danger">*</span></label>
                  <input type="text" id="judul_tugas" name="judul_tugas" class="form-control @error('judul_tugas') is-invalid @enderror" value="{{ old('judul_tugas') }}" placeholder="Masukkan judul tugas">
                  @error('judul_tugas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Mata Pelajaran --}}
                <div class="col-md-4">
                  <label for="pelajaran_id" class="form-label fw-semibold">Mata Pelajaran <span class="text-danger">*</span></label>
                  <select id="pelajaran_id" name="pelajaran_id" class="form-select @error('pelajaran_id') is-invalid @enderror">
                    <option value="">-- Pilih Pelajaran --</option>
                    @foreach($pelajaranList as $p)
                      <option value="{{ $p->id }}" {{ old('pelajaran_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_pelajaran }}</option>
                    @endforeach
                  </select>
                </div>

                {{-- Kelas --}}
                <div class="col-md-4">
                  <label for="kelas_id" class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                  <select id="kelas_id" name="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasList as $k)
                      <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                  </select>
                </div>

                {{-- Guru --}}
                <div class="col-md-4">
                  <label for="guru_id" class="form-label fw-semibold">Guru Pengampu <span class="text-danger">*</span></label>
                  <select id="guru_id" name="guru_id" class="form-select @error('guru_id') is-invalid @enderror">
                    <option value="">-- Pilih Guru --</option>
                    @foreach($guruList as $g)
                      <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_lengkap }}</option>
                    @endforeach
                  </select>
                </div>

                {{-- Tanggal Mulai --}}
                <div class="col-md-6">
                  <label for="tanggal_mulai" class="form-label fw-semibold">Tanggal Mulai <span class="text-danger">*</span></label>
                  <input type="datetime-local" id="tanggal_mulai" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai') }}">
                </div>

                {{-- Tenggat Waktu --}}
                <div class="col-md-6">
                  <label for="tenggat_waktu" class="form-label fw-semibold">Tenggat Waktu <span class="text-danger">*</span></label>
                  <input type="datetime-local" id="tenggat_waktu" name="tenggat_waktu" class="form-control @error('tenggat_waktu') is-invalid @enderror" value="{{ old('tenggat_waktu') }}">
                </div>

                {{-- Tipe Pengumpulan --}}
                <div class="col-md-4">
                  <label for="tipe_pengumpulan" class="form-label fw-semibold">Metode Pengumpulan <span class="text-danger">*</span></label>
                  <select id="tipe_pengumpulan" name="tipe_pengumpulan" class="form-select @error('tipe_pengumpulan') is-invalid @enderror">
                    @foreach($tipeList as $tipe)
                      <option value="{{ $tipe }}" {{ old('tipe_pengumpulan') == $tipe ? 'selected' : '' }}>{{ $tipe }}</option>
                    @endforeach
                  </select>
                </div>

                {{-- Nilai Maksimal --}}
                <div class="col-md-4">
                  <label for="nilai_maksimal" class="form-label fw-semibold">Nilai Maksimal</label>
                  <input type="number" id="nilai_maksimal" name="nilai_maksimal" class="form-control" value="{{ old('nilai_maksimal', 100) }}">
                </div>

                {{-- File Tugas --}}
                <div class="col-md-4">
                  <label for="file_tugas" class="form-label fw-semibold">Lampiran File</label>
                  <input type="file" id="file_tugas" name="file_tugas" class="form-control @error('file_tugas') is-invalid @enderror">
                </div>

                {{-- Deskripsi --}}
                <div class="col-12">
                  <label for="deskripsi" class="form-label fw-semibold">Deskripsi / Instruksi</label>
                  <textarea id="deskripsi" name="deskripsi" rows="4" class="form-control">{{ old('deskripsi') }}</textarea>
                </div>

                {{-- Publish Status --}}
                <div class="col-12 mt-3">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_published" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="is_published">Publikasikan Sekarang</label>
                  </div>
                </div>

                {{-- Buttons --}}
                <div class="col-12 d-flex gap-2 mt-4">
                  <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan Tugas
                  </button>
                  <a href="{{ route('jadwal-tugas.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
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