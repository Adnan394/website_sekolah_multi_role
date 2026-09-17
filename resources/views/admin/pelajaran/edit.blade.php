@extends('layouts.admin')

@section('content')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Edit Mata Pelajaran</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('pelajaran.index') }}">Data Pelajaran</a></li>
        <li class="breadcrumb-item active">Edit Mata Pelajaran</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body pt-4">
        <h5 class="card-title">
          Form Edit Mata Pelajaran &mdash;
          <span class="text-danger">{{ $pelajaran->nama_pelajaran }}</span>
          <small class="text-muted fs-6">({{ $pelajaran->kode_pelajaran }})</small>
        </h5>

        @if(isset($errors) && $errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h6 class="alert-heading fw-bold mb-1"><i class="bi bi-exclamation-octagon me-1"></i> Terjadi Kesalahan!</h6>
            <ul class="mb-0 ps-3">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <form action="{{ route('pelajaran.update', $pelajaran) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label fw-semibold">Kode Pelajaran <span class="text-danger">*</span></label>
              <input type="text" 
                     name="kode_pelajaran" 
                     class="form-control @error('kode_pelajaran') is-invalid @enderror" 
                     value="{{ old('kode_pelajaran', $pelajaran->kode_pelajaran) }}" 
                     placeholder="Contoh: MTK-01" 
                     required>
              @error('kode_pelajaran')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-8">
              <label class="form-label fw-semibold">Nama Pelajaran <span class="text-danger">*</span></label>
              <input type="text" 
                     name="nama_pelajaran" 
                     class="form-control @error('nama_pelajaran') is-invalid @enderror" 
                     value="{{ old('nama_pelajaran', $pelajaran->nama_pelajaran) }}" 
                     placeholder="Contoh: Matematika" 
                     required>
              @error('nama_pelajaran')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
              <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                @foreach($kategoriList as $kat)
                  <option value="{{ $kat }}" {{ old('kategori', $pelajaran->kategori) == $kat ? 'selected' : '' }}>
                    {{ $kat }}
                  </option>
                @endforeach
              </select>
              @error('kategori')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-3">
              <label class="form-label fw-semibold">Tingkat Min <span class="text-danger">*</span></label>
              <input type="number" 
                     name="tingkat_min" 
                     class="form-control @error('tingkat_min') is-invalid @enderror" 
                     value="{{ old('tingkat_min', $pelajaran->tingkat_min) }}" 
                     min="1" 
                     max="6" 
                     required>
              @error('tingkat_min')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-3">
              <label class="form-label fw-semibold">Tingkat Max <span class="text-danger">*</span></label>
              <input type="number" 
                     name="tingkat_max" 
                     class="form-control @error('tingkat_max') is-invalid @enderror" 
                     value="{{ old('tingkat_max', $pelajaran->tingkat_max) }}" 
                     min="1" 
                     max="6" 
                     required>
              @error('tingkat_max')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Jam Per Minggu <span class="text-danger">*</span></label>
              <input type="number" 
                     name="jam_per_minggu" 
                     class="form-control @error('jam_per_minggu') is-invalid @enderror" 
                     value="{{ old('jam_per_minggu', $pelajaran->jam_per_minggu) }}" 
                     min="1" 
                     required>
              @error('jam_per_minggu')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6 d-flex align-items-center mt-4">
              <div class="form-check form-switch">
                <input class="form-check-input" 
                       type="checkbox" 
                       name="is_active" 
                       value="1" 
                       id="is_active" 
                       {{ old('is_active', $pelajaran->is_active) ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold ms-2" for="is_active">Pelajaran Aktif</label>
              </div>
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Deskripsi</label>
              <textarea name="deskripsi" 
                        class="form-control @error('deskripsi') is-invalid @enderror" 
                        rows="3" 
                        placeholder="Deskripsi atau catatan tambahan...">{{ old('deskripsi', $pelajaran->deskripsi) }}</textarea>
              @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-12 pt-2">
              <button type="submit" class="btn btn-primary me-2">
                <i class="bi bi-save me-1"></i> Perbarui
              </button>
              <a href="{{ route('pelajaran.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>
@endsection
