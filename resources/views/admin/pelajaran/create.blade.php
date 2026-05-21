@extends('layouts.admin')
@section('content')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Tambah Mata Pelajaran</h1>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body pt-4">
        <form action="{{ route('pelajaran.store') }}" method="POST">
          @csrf
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label fw-semibold">Kode Pelajaran <span class="text-danger">*</span></label>
              <input type="text" name="kode_pelajaran" class="form-control @error('kode_pelajaran') is-invalid @enderror" value="{{ old('kode_pelajaran') }}" placeholder="Contoh: MTK-01">
            </div>

            <div class="col-md-8">
              <label class="form-label fw-semibold">Nama Pelajaran <span class="text-danger">*</span></label>
              <input type="text" name="nama_pelajaran" class="form-control @error('nama_pelajaran') is-invalid @enderror" value="{{ old('nama_pelajaran') }}">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
              <select name="kategori" class="form-select @error('kategori') is-invalid @enderror">
                @foreach($kategoriList as $kat)
                  <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-3">
              <label class="form-label fw-semibold">Tingkat Min</label>
              <input type="number" name="tingkat_min" class="form-control" value="{{ old('tingkat_min', 1) }}" min="1" max="6">
            </div>

            <div class="col-md-3">
              <label class="form-label fw-semibold">Tingkat Max</label>
              <input type="number" name="tingkat_max" class="form-control" value="{{ old('tingkat_max', 6) }}" min="1" max="6">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Jam Per Minggu</label>
              <input type="number" name="jam_per_minggu" class="form-control" value="{{ old('jam_per_minggu', 2) }}">
            </div>

            <div class="col-md-6 d-flex align-items-center mt-4">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked>
                <label class="form-check-label fw-semibold" for="is_active">Pelajaran Aktif</label>
              </div>
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Deskripsi</label>
              <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="col-12">
              <button type="submit" class="btn btn-danger"><i class="bi bi-save me-1"></i> Simpan</button>
              <a href="{{ route('pelajaran.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>
@endsection