@extends('layouts.admin')

@section('content')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Tambah Jadwal Pelajaran</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('jadwal-pelajaran.index') }}">Jadwal Pelajaran</a></li>
        <li class="breadcrumb-item active">Tambah</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body pt-4">
            <h5 class="card-title">Form Input Jadwal</h5>

            @if($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('jadwal-pelajaran.store') }}" method="POST">
              @csrf
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Kelas <span class="text-danger">*</span></label>
                  <select name="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasList as $k)
                      <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-bold">Mata Pelajaran <span class="text-danger">*</span></label>
                  <select name="pelajaran_id" class="form-select @error('pelajaran_id') is-invalid @enderror">
                    <option value="">-- Pilih Pelajaran --</option>
                    @foreach($pelajaranList as $p)
                      <option value="{{ $p->id }}" {{ old('pelajaran_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_pelajaran }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-bold">Guru Pengampu <span class="text-danger">*</span></label>
                  <select name="guru_id" class="form-select @error('guru_id') is-invalid @enderror">
                    <option value="">-- Pilih Guru --</option>
                    @foreach($guruList as $g)
                      <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_lengkap }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-3">
                  <label class="form-label fw-bold">Hari <span class="text-danger">*</span></label>
                  <select name="hari" class="form-select @error('hari') is-invalid @enderror">
                    @foreach($hariList as $h)
                      <option value="{{ $h }}" {{ old('hari') == $h ? 'selected' : '' }}>{{ $h }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-3">
                  <label class="form-label fw-bold">Jam Ke- <span class="text-danger">*</span></label>
                  <input type="number" name="jam_ke" class="form-control" value="{{ old('jam_ke', 1) }}" min="1" max="12">
                </div>

                <div class="col-md-3">
                  <label class="form-label fw-bold">Jam Mulai <span class="text-danger">*</span></label>
                  <input type="time" name="jam_mulai" class="form-control @error('jam_mulai') is-invalid @enderror" value="{{ old('jam_mulai') }}">
                </div>

                <div class="col-md-3">
                  <label class="form-label fw-bold">Jam Selesai <span class="text-danger">*</span></label>
                  <input type="time" name="jam_selesai" class="form-control @error('jam_selesai') is-invalid @enderror" value="{{ old('jam_selesai') }}">
                </div>

                <div class="col-md-3">
                  <label class="form-label fw-bold">Tahun Pelajaran <span class="text-danger">*</span></label>
                  <input type="text" name="tahun_pelajaran" class="form-control" placeholder="2024/2025" value="{{ old('tahun_pelajaran') }}">
                </div>

                <div class="col-md-3">
                  <label class="form-label fw-bold">Semester <span class="text-danger">*</span></label>
                  <select name="semester" class="form-select">
                    @foreach($semesterList as $s)
                      <option value="{{ $s }}" {{ old('semester') == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-12">
                  <label class="form-label fw-bold">Ruangan (Opsional)</label>
                  <input type="text" name="ruangan" class="form-control" value="{{ old('ruangan') }}" placeholder="Contoh: Lab Komputer, Ruang 01">
                </div>

                <div class="col-12 mt-4">
                  <button type="submit" class="btn btn-danger"><i class="bi bi-save me-1"></i> Simpan Jadwal</button>
                  <a href="{{ route('jadwal-pelajaran.index') }}" class="btn btn-secondary">Kembali</a>
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