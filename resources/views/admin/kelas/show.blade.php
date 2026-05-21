@extends('layouts.admin')

@section('content')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Detail Kelas</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('kelas.index') }}">Data Kelas</a></li>
        <li class="breadcrumb-item active">Detail</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">

      {{-- ── Kartu Info Utama ── --}}
      <div class="col-lg-4">
        <div class="card text-center">
          <div class="card-body pt-4 pb-4">
            {{-- Badge Tingkat --}}
            <div class="mb-3">
              <span class="display-4 fw-bold text-danger">{{ $kelas->tingkat }}</span>
              <div class="text-muted small">Tingkat Kelas</div>
            </div>

            <h4 class="card-title mb-1">Kelas {{ $kelas->nama_kelas }}</h4>
            <p class="text-muted mb-2">{{ $kelas->tahun_pelajaran }} — Semester {{ $kelas->semester }}</p>

            @if($kelas->is_active)
              <span class="badge bg-success fs-6 px-3 py-2">Aktif</span>
            @else
              <span class="badge bg-secondary fs-6 px-3 py-2">Nonaktif</span>
            @endif

            <hr>

            {{-- Statistik cepat --}}
            <div class="row text-center">
              <div class="col-6 border-end">
                <div class="fs-4 fw-bold text-primary">{{ $kelas->kapasitas }}</div>
                <div class="text-muted small">Kapasitas</div>
              </div>
              <div class="col-6">
                {{-- Aktifkan setelah relasi siswa tersedia --}}
                <div class="fs-4 fw-bold text-success">0</div>
                <div class="text-muted small">Siswa Terdaftar</div>
              </div>
            </div>

            <hr>

            {{-- Aksi --}}
            <div class="d-flex flex-column gap-2">
              <a href="{{ route('kelas.edit', $kelas) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-square me-1"></i> Edit Kelas
              </a>

              <form action="{{ route('kelas.toggle-status', $kelas) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit"
                        class="btn btn-sm w-100 {{ $kelas->is_active ? 'btn-outline-secondary' : 'btn-outline-success' }}">
                  <i class="bi bi-{{ $kelas->is_active ? 'pause-circle' : 'play-circle' }} me-1"></i>
                  {{ $kelas->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
              </form>

              <form action="{{ route('kelas.destroy', $kelas) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus kelas {{ $kelas->nama_kelas }}?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm w-100">
                  <i class="bi bi-trash me-1"></i> Hapus Kelas
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>

      {{-- ── Detail & Relasi ── --}}
      <div class="col-lg-8">

        {{-- Info Detail --}}
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Informasi Kelas</h5>
            <table class="table table-borderless">
              <tr>
                <th width="160" class="text-muted">Kode Kelas</th>
                <td><code>{{ $kelas->kode_kelas }}</code></td>
              </tr>
              <tr>
                <th class="text-muted">Nama Kelas</th>
                <td><strong>{{ $kelas->nama_kelas }}</strong></td>
              </tr>
              <tr>
                <th class="text-muted">Tingkat</th>
                <td>Kelas {{ $kelas->tingkat }} (SD)</td>
              </tr>
              <tr>
                <th class="text-muted">Tahun Pelajaran</th>
                <td>{{ $kelas->tahun_pelajaran }}</td>
              </tr>
              <tr>
                <th class="text-muted">Semester</th>
                <td>{{ $kelas->semester }}</td>
              </tr>
              <tr>
                <th class="text-muted">Kapasitas</th>
                <td>{{ $kelas->kapasitas }} siswa</td>
              </tr>
              <tr>
                <th class="text-muted">Status</th>
                <td>
                  @if($kelas->is_active)
                    <span class="badge bg-success">Aktif</span>
                  @else
                    <span class="badge bg-secondary">Nonaktif</span>
                  @endif
                </td>
              </tr>
              @if($kelas->keterangan)
              <tr>
                <th class="text-muted">Keterangan</th>
                <td>{{ $kelas->keterangan }}</td>
              </tr>
              @endif
              <tr>
                <th class="text-muted">Dibuat</th>
                <td>{{ $kelas->created_at->format('d M Y, H:i') }}</td>
              </tr>
              <tr>
                <th class="text-muted">Diperbarui</th>
                <td>{{ $kelas->updated_at->format('d M Y, H:i') }}</td>
              </tr>
            </table>
          </div>
        </div>

        {{-- ── Wali Kelas (placeholder, aktifkan setelah module guru) ── --}}
        <div class="card">
          <div class="card-body">
            <h5 class="card-title d-flex justify-content-between align-items-center">
              Wali Kelas
              {{-- <a href="#" class="btn btn-sm btn-outline-danger">Assign Wali Kelas</a> --}}
            </h5>
            <div class="alert alert-info mb-0">
              <i class="bi bi-info-circle me-1"></i>
              Fitur wali kelas akan tersedia setelah modul <strong>Guru</strong> dibuat.
            </div>
          </div>
        </div>

        {{-- ── Daftar Siswa (placeholder) ── --}}
        <div class="card">
          <div class="card-body">
            <h5 class="card-title d-flex justify-content-between align-items-center">
              Daftar Siswa
              {{-- <a href="#" class="btn btn-sm btn-outline-danger">Tambah Siswa</a> --}}
            </h5>
            <div class="alert alert-info mb-0">
              <i class="bi bi-info-circle me-1"></i>
              Daftar siswa akan tersedia setelah modul <strong>Siswa</strong> dibuat.
            </div>
          </div>
        </div>

        {{-- ── Pelajaran (placeholder) ── --}}
        <div class="card">
          <div class="card-body">
            <h5 class="card-title d-flex justify-content-between align-items-center">
              Jadwal Pelajaran
            </h5>
            <div class="alert alert-info mb-0">
              <i class="bi bi-info-circle me-1"></i>
              Jadwal pelajaran akan tersedia setelah modul <strong>Pelajaran</strong> dan <strong>Guru Mapel</strong> dibuat.
            </div>
          </div>
        </div>

      </div>{{-- /col-lg-8 --}}
    </div>{{-- /row --}}
  </section>

</main>
@endsection