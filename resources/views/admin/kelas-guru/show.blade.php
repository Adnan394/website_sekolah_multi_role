@extends('layouts.admin')
@section('content')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Kelola Guru — Kelas {{ $kelas->nama_kelas }}</h1>
    <nav><ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('kelas-guru.index') }}">Mapping Guru Kelas</a></li>
      <li class="breadcrumb-item active">{{ $kelas->nama_kelas }}</li>
    </ol></nav>
  </div>

  <section class="section">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    {{-- Info Kelas --}}
    <div class="alert alert-light border d-flex gap-3 align-items-center mb-3">
      <span class="fs-2 fw-bold text-danger">{{ $kelas->tingkat }}</span>
      <div>
        <div class="fw-bold fs-5">Kelas {{ $kelas->nama_kelas }}</div>
        <div class="text-muted small">{{ $kelas->tahun_pelajaran }} · Semester {{ $kelas->semester }} · Kapasitas {{ $kelas->kapasitas }} siswa</div>
      </div>
    </div>

    <div class="row">

      {{-- ══ Wali Kelas ══ --}}
      <div class="col-lg-5">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class="bi bi-person-badge me-2 text-danger"></i>Wali Kelas</h5>

            {{-- Tampilkan wali kelas saat ini --}}
            @if($kelas->waliKelas->count())
              @foreach($kelas->waliKelas as $w)
                <div class="d-flex align-items-center gap-3 border rounded p-3 mb-3">
                  <img src="{{ $w->foto_url }}" class="rounded-circle" width="50" height="50" style="object-fit:cover">
                  <div class="flex-grow-1">
                    <div class="fw-bold">{{ $w->nama_gelar }}</div>
                    <small class="text-muted">{{ $w->jabatan }} · {{ $w->status_kepegawaian }}</small>
                  </div>
                  <form action="{{ route('kelas-guru.remove-wali-kelas', $kelas) }}" method="POST"
                        onsubmit="return confirm('Hapus wali kelas ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" title="Hapus">
                      <i class="bi bi-x-lg"></i>
                    </button>
                  </form>
                </div>
              @endforeach
            @else
              <div class="alert alert-warning py-2 mb-3">
                <i class="bi bi-exclamation-triangle me-1"></i>Belum ada wali kelas.
              </div>
            @endif

            {{-- Form set wali kelas --}}
            <form action="{{ route('kelas-guru.set-wali-kelas', $kelas) }}" method="POST">
              @csrf @method('POST')
              <label class="form-label fw-semibold small">
                {{ $kelas->waliKelas->count() ? 'Ganti' : 'Tetapkan' }} Wali Kelas
              </label>
              <div class="input-group">
                <select name="guru_id" class="form-select @error('guru_id') is-invalid @enderror">
                  <option value="">-- Pilih Guru --</option>
                  @foreach($guruList as $g)
                    <option value="{{ $g->id }}">{{ $g->nama_lengkap }}</option>
                  @endforeach
                </select>
                <button type="submit" class="btn btn-danger">
                  <i class="bi bi-check-lg"></i> Tetapkan
                </button>
              </div>
              @error('guru_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </form>
          </div>
        </div>
      </div>

      {{-- ══ Guru Mata Pelajaran ══ --}}
      <div class="col-lg-7">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class="bi bi-journal-bookmark me-2 text-primary"></i>Guru Mata Pelajaran</h5>

            {{-- Form sync semua mapel --}}
            <form action="{{ route('kelas-guru.sync-guru-mapel', $kelas) }}" method="POST">
              @csrf @method('POST')

              <div class="table-responsive mb-3">
                <table class="table table-sm table-bordered align-middle">
                  <thead class="table-light">
                    <tr>
                      <th>Mata Pelajaran</th>
                      <th>Guru Pengampu</th>
                      <th width="40"></th>
                    </tr>
                  </thead>
                  <tbody id="mapel-rows">
                    @foreach($pelajaranList as $idx => $pel)
                      @php $existing = $mapelExisting[$pel->id] ?? null; @endphp
                      <tr>
                        <td>
                          <strong class="small">{{ $pel->nama_pelajaran }}</strong>
                          <input type="hidden" name="mapel[{{ $idx }}][pelajaran_id]" value="{{ $pel->id }}">
                          <br><span class="badge bg-light text-dark border">{{ $pel->kategori }}</span>
                        </td>
                        <td>
                          <select name="mapel[{{ $idx }}][guru_id]"
                                  class="form-select form-select-sm">
                            <option value="">-- Belum Ditugaskan --</option>
                            @foreach($guruList as $g)
                              <option value="{{ $g->id }}"
                                {{ $existing && $existing->guru_id == $g->id ? 'selected' : '' }}>
                                {{ $g->nama_lengkap }}
                              </option>
                            @endforeach
                          </select>
                        </td>
                        <td class="text-center">
                          @if($existing)
                            <i class="bi bi-check-circle-fill text-success" title="Sudah ada guru"></i>
                          @else
                            <i class="bi bi-dash-circle text-muted" title="Belum ada guru"></i>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

              @if($pelajaranList->isEmpty())
                <div class="alert alert-info">
                  <i class="bi bi-info-circle me-1"></i>
                  Belum ada mata pelajaran yang sesuai untuk kelas {{ $kelas->tingkat }}.
                  <a href="{{ route('pelajaran.create') }}">Tambah pelajaran</a>
                </div>
              @else
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-save me-1"></i>Simpan Semua Penugasan
                </button>
              @endif
            </form>
          </div>
        </div>
      </div>

    </div>{{-- /row --}}
    <a href="{{ route('kelas-guru.index') }}" class="btn btn-secondary mb-4">
      <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
  </section>
</main>
@endsection