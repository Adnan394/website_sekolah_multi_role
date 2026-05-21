@extends('layouts.admin')
@section('content')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Data Siswa — Kelas {{ $kelas->nama_kelas }}</h1>
    <nav><ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('kelas-siswa.index') }}">Mapping Siswa</a></li>
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

    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
          <h5 class="card-title m-0 p-0">Daftar Siswa ({{ $kelas->siswa->count() }} / {{ $kelas->kapasitas }})</h5>
          <a href="{{ route('kelas-siswa.create', ['kelas_id' => $kelas->id]) }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Tambah Siswa
          </a>
        </div>

        <div class="table-responsive">
          <table class="table table-hover table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th width="5%">No. Absen</th>
                <th>NISN / NIS</th>
                <th>Nama Siswa</th>
                <th>Status</th>
                <th width="20%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($kelas->siswa->sortBy('pivot.nomor_absen') as $siswa)
                <tr>
                  <td class="text-center fw-bold">{{ $siswa->pivot->nomor_absen ?? '-' }}</td>
                  <td>{{ $siswa->nisn ?? '-' }} <br> <small class="text-muted">{{ $siswa->nis ?? '-' }}</small></td>
                  <td>{{ $siswa->nama_lengkap }}</td>
                  <td>
                    @if($siswa->pivot->status == 'Aktif')
                      <span class="badge bg-success">Aktif</span>
                    @else
                      <span class="badge bg-secondary">{{ $siswa->pivot->status }}</span>
                    @endif
                  </td>
                  <td>
                    <a href="{{ route('kelas-siswa.ubah', [$kelas->id, $siswa->id]) }}" class="btn btn-warning btn-sm" title="Edit Status/Absen">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('kelas-siswa.destroy', [$kelas->id, $siswa->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin mengeluarkan siswa ini?');">
                      @csrf @method('DELETE')
                      <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                      <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                      <button type="submit" class="btn btn-danger btn-sm" title="Keluarkan">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center text-muted py-4">Belum ada siswa di kelas ini.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <a href="{{ route('kelas-siswa.index') }}" class="btn btn-secondary">
      <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
  </section>
</main>
@endsection