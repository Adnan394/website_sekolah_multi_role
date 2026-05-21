@extends('layouts.admin')

@section('content')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Edit Kelas</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('kelas.index') }}">Data Kelas</a></li>
        <li class="breadcrumb-item active">Edit Kelas</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body pt-4">
            <h5 class="card-title">
              Form Edit Kelas &mdash;
              <span class="text-danger">{{ $kelas->nama_kelas }}</span>
              <small class="text-muted fs-6">({{ $kelas->tahun_pelajaran }})</small>
            </h5>

            {{-- Validation Errors --}}
            @if($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('kelas.update', $kelas) }}" method="POST">
              @csrf
              @method('PUT')

              <div class="row g-3">

                {{-- Tahun Pelajaran --}}
                <div class="col-md-6">
                  <label for="tahun_pelajaran" class="form-label fw-semibold">
                    Tahun Pelajaran <span class="text-danger">*</span>
                  </label>
                  <input type="text" id="tahun_pelajaran" name="tahun_pelajaran"
                         class="form-control @error('tahun_pelajaran') is-invalid @enderror"
                         value="{{ old('tahun_pelajaran', $kelas->tahun_pelajaran) }}"
                         placeholder="contoh: 2024/2025">
                  <div class="form-text">Format: YYYY/YYYY</div>
                  @error('tahun_pelajaran')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Semester --}}
                <div class="col-md-6">
                  <label for="semester" class="form-label fw-semibold">
                    Semester <span class="text-danger">*</span>
                  </label>
                  <select id="semester" name="semester"
                          class="form-select @error('semester') is-invalid @enderror">
                    @foreach($semesterList as $sem)
                      <option value="{{ $sem }}"
                        {{ old('semester', $kelas->semester) == $sem ? 'selected' : '' }}>
                        {{ $sem }}
                      </option>
                    @endforeach
                  </select>
                  @error('semester')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Tingkat --}}
                <div class="col-md-6">
                  <label for="tingkat" class="form-label fw-semibold">
                    Tingkat Kelas <span class="text-danger">*</span>
                  </label>
                  <select id="tingkat" name="tingkat"
                          class="form-select @error('tingkat') is-invalid @enderror">
                    @foreach($tingkatList as $t)
                      <option value="{{ $t }}"
                        {{ old('tingkat', $kelas->tingkat) == $t ? 'selected' : '' }}>
                        Kelas {{ $t }}
                      </option>
                    @endforeach
                  </select>
                  @error('tingkat')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Nama Kelas --}}
                <div class="col-md-6">
                  <label for="nama_kelas" class="form-label fw-semibold">
                    Nama / Rombel Kelas <span class="text-danger">*</span>
                  </label>
                  <input type="text" id="nama_kelas" name="nama_kelas"
                         class="form-control @error('nama_kelas') is-invalid @enderror"
                         value="{{ old('nama_kelas', $kelas->nama_kelas) }}"
                         style="text-transform:uppercase">
                  @error('nama_kelas')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Kapasitas --}}
                <div class="col-md-6">
                  <label for="kapasitas" class="form-label fw-semibold">Kapasitas Siswa</label>
                  <input type="number" id="kapasitas" name="kapasitas"
                         class="form-control @error('kapasitas') is-invalid @enderror"
                         value="{{ old('kapasitas', $kelas->kapasitas) }}" min="1" max="60">
                  @error('kapasitas')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Status --}}
                <div class="col-md-6 d-flex align-items-center mt-4">
                  <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" role="switch"
                           id="is_active" name="is_active" value="1"
                           {{ old('is_active', $kelas->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="is_active">
                      Kelas Aktif
                    </label>
                  </div>
                </div>

                {{-- Keterangan --}}
                <div class="col-12">
                  <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                  <textarea id="keterangan" name="keterangan" rows="3"
                            class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $kelas->keterangan) }}</textarea>
                  @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Buttons --}}
                <div class="col-12 d-flex gap-2 mt-2">
                  <button type="submit" class="btn btn-warning">
                    <i class="bi bi-save me-1"></i> Update
                  </button>
                  <a href="{{ route('kelas.show', $kelas) }}" class="btn btn-info">
                    <i class="bi bi-eye me-1"></i> Lihat Detail
                  </a>
                  <a href="{{ route('kelas.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                  </a>
                </div>

              </div>{{-- /row g-3 --}}
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>

</main>
@endsection

@push('scripts')
<script>
  document.getElementById('nama_kelas').addEventListener('input', function () {
    this.value = this.value.toUpperCase();
  });
</script>
@endpush