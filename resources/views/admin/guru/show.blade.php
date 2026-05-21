@extends('layouts.admin')

@section('content')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Detail Guru</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('guru.index') }}">Data Guru</a></li>
        <li class="breadcrumb-item active">Detail</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="row">

      {{-- ── Kolom Kiri: Kartu Profil ── --}}
      <div class="col-lg-4">
        <div class="card text-center">
          <div class="card-body pt-4 pb-4">
            <img src="{{ $guru->foto_url }}" alt="{{ $guru->nama_lengkap }}"
                 class="rounded-circle border border-3 mb-3"
                 width="120" height="120" style="object-fit:cover">

            <h5 class="mb-0">{{ $guru->nama_gelar }}</h5>
            <p class="text-muted small mb-2">{{ $guru->jabatan }}</p>

            @if($guru->is_active)
              <span class="badge bg-success px-3 py-2">Aktif</span>
            @else
              <span class="badge bg-secondary px-3 py-2">Nonaktif</span>
            @endif

            @if($guru->is_sertifikasi)
              <span class="badge bg-warning text-dark px-3 py-2 ms-1">
                <i class="bi bi-patch-check me-1"></i>Tersertifikasi
              </span>
            @endif

            <hr>

            {{-- Quick stats --}}
            <div class="row text-center mb-3">
              <div class="col-6 border-end">
                <div class="fs-5 fw-bold text-primary">{{ $guru->masa_kerja_tahun }}</div>
                <div class="text-muted small">Tahun Kerja</div>
              </div>
              <div class="col-6">
                <div class="fs-5 fw-bold text-success">{{ $guru->waliKelas->count() }}</div>
                <div class="text-muted small">Wali Kelas</div>
              </div>
            </div>

            <div class="d-flex flex-column gap-2">
              <a href="{{ route('guru.edit', $guru) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-square me-1"></i>Edit Data
              </a>
              <form action="{{ route('guru.toggle-status', $guru) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit"
                        class="btn btn-sm w-100 {{ $guru->is_active ? 'btn-outline-secondary' : 'btn-outline-success' }}">
                  <i class="bi bi-{{ $guru->is_active ? 'pause-circle' : 'play-circle' }} me-1"></i>
                  {{ $guru->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
              </form>
              <form action="{{ route('guru.destroy', $guru) }}" method="POST"
                    onsubmit="return confirm('Hapus guru {{ $guru->nama_lengkap }}?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm w-100">
                  <i class="bi bi-trash me-1"></i>Hapus
                </button>
              </form>
            </div>
          </div>
        </div>

        {{-- Akun Login --}}
        <div class="card">
          <div class="card-body">
            <h6 class="card-title"><i class="bi bi-person-lock me-2"></i>Akun Login</h6>
            @if($guru->user)
              <table class="table table-sm table-borderless mb-0">
                <tr><th class="text-muted small" width="90">Username</th>
                    <td class="small"><code>{{ $guru->user->username }}</code></td></tr>
                <tr><th class="text-muted small">Email</th>
                    <td class="small">{{ $guru->user->email }}</td></tr>
                <tr><th class="text-muted small">Role</th>
                    <td><span class="badge bg-info">{{ $guru->user->role }}</span></td></tr>
              </table>
            @else
              <p class="text-muted small mb-0">Tidak ada akun terkait.</p>
            @endif
          </div>
        </div>

        {{-- Menu Setting (dari gambar) --}}
        <div class="card">
          <div class="card-body">
            <h6 class="card-title"><i class="bi bi-gear me-2"></i>Setting Guru</h6>
            <div class="list-group list-group-flush">
              <a href="#" class="list-group-item list-group-item-action d-flex align-items-center gap-2 py-2">
                <i class="bi bi-book text-danger"></i>
                <div><div class="small fw-semibold">Materi Pembelajaran</div>
                  <div class="text-muted" style="font-size:11px">Setting materi & jadwal tugas</div></div>
              </a>
              <a href="#" class="list-group-item list-group-item-action d-flex align-items-center gap-2 py-2">
                <i class="bi bi-calendar3 text-danger"></i>
                <div><div class="small fw-semibold">Jadwal Pelajaran</div>
                  <div class="text-muted" style="font-size:11px">Atur jadwal mengajar</div></div>
              </a>
              <a href="#" class="list-group-item list-group-item-action d-flex align-items-center gap-2 py-2">
                <i class="bi bi-check2-square text-danger"></i>
                <div><div class="small fw-semibold">Absensi</div>
                  <div class="text-muted" style="font-size:11px">Setting kehadiran siswa</div></div>
              </a>
              <a href="#" class="list-group-item list-group-item-action d-flex align-items-center gap-2 py-2">
                <i class="bi bi-bar-chart text-danger"></i>
                <div><div class="small fw-semibold">Penilaian</div>
                  <div class="text-muted" style="font-size:11px">Setting nilai & rapor</div></div>
              </a>
            </div>
          </div>
        </div>
      </div>

      {{-- ── Kolom Kanan: Detail ── --}}
      <div class="col-lg-8">

        {{-- Identitas Pribadi --}}
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class="bi bi-person-vcard me-2"></i>Identitas Pribadi</h5>
            <div class="row">
              <div class="col-md-6">
                <table class="table table-sm table-borderless">
                  <tr><th class="text-muted" width="150">Nama Lengkap</th>
                      <td><strong>{{ $guru->nama_gelar }}</strong></td></tr>
                  <tr><th class="text-muted">Jenis Kelamin</th>
                      <td>{{ $guru->jenis_kelamin === 'L' ? 'Laki-laki' : ($guru->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}</td></tr>
                  <tr><th class="text-muted">Tempat, Tgl Lahir</th>
                      <td>{{ $guru->tempat_lahir ?? '-' }}, {{ $guru->tanggal_lahir?->format('d M Y') ?? '-' }}</td></tr>
                  <tr><th class="text-muted">Usia</th>
                      <td>{{ $guru->usia ?? '-' }} tahun</td></tr>
                  <tr><th class="text-muted">Agama</th>
                      <td>{{ $guru->agama ?? '-' }}</td></tr>
                  <tr><th class="text-muted">Status Nikah</th>
                      <td>{{ $guru->status_pernikahan ?? '-' }}</td></tr>
                </table>
              </div>
              <div class="col-md-6">
                <table class="table table-sm table-borderless">
                  <tr><th class="text-muted" width="120">No. HP</th>
                      <td>{{ $guru->no_hp ?? '-' }}</td></tr>
                  <tr><th class="text-muted">No. Telp</th>
                      <td>{{ $guru->no_telp ?? '-' }}</td></tr>
                  <tr><th class="text-muted">Email Pribadi</th>
                      <td>{{ $guru->email_pribadi ?? '-' }}</td></tr>
                  <tr><th class="text-muted">Alamat</th>
                      <td><small>{{ $guru->alamat_lengkap ?: '-' }}</small></td></tr>
                </table>
              </div>
            </div>
          </div>
        </div>

        {{-- Kepegawaian --}}
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class="bi bi-briefcase me-2"></i>Data Kepegawaian</h5>
            <div class="row">
              <div class="col-md-6">
                <table class="table table-sm table-borderless">
                  <tr><th class="text-muted" width="150">NIP</th>
                      <td><code>{{ $guru->nip ?? '-' }}</code></td></tr>
                  <tr><th class="text-muted">NUPTK</th>
                      <td><code>{{ $guru->nuptk ?? '-' }}</code></td></tr>
                  <tr><th class="text-muted">Jabatan</th>
                      <td><span class="badge bg-secondary">{{ $guru->jabatan }}</span></td></tr>
                  <tr><th class="text-muted">Status</th>
                      <td><span class="badge bg-info text-dark">{{ $guru->status_kepegawaian }}</span></td></tr>
                  <tr><th class="text-muted">Golongan</th>
                      <td>{{ $guru->golongan ?? '-' }}</td></tr>
                </table>
              </div>
              <div class="col-md-6">
                <table class="table table-sm table-borderless">
                  <tr><th class="text-muted" width="150">Pend. Terakhir</th>
                      <td>{{ $guru->pendidikan_terakhir ?? '-' }}</td></tr>
                  <tr><th class="text-muted">Jurusan</th>
                      <td>{{ $guru->jurusan ?? '-' }}</td></tr>
                  <tr><th class="text-muted">Universitas</th>
                      <td>{{ $guru->universitas ?? '-' }}</td></tr>
                  <tr><th class="text-muted">Masa Kerja</th>
                      <td>{{ $guru->masa_kerja_tahun }} tahun {{ $guru->masa_kerja_bulan }} bulan</td></tr>
                  <tr><th class="text-muted">Bergabung</th>
                      <td>{{ $guru->tanggal_bergabung?->format('d M Y') ?? '-' }}</td></tr>
                </table>
              </div>
            </div>
          </div>
        </div>

        {{-- Relasi Kelas --}}
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class="bi bi-house-door me-2"></i>Penugasan Kelas</h5>
            @if($guru->waliKelas->count() > 0)
              <h6 class="text-muted small mb-2">Wali Kelas:</h6>
              <div class="d-flex gap-2 flex-wrap mb-3">
                @foreach($guru->waliKelas as $k)
                  <span class="badge bg-danger fs-6 px-3">{{ $k->nama_kelas }} ({{ $k->tahun_pelajaran }})</span>
                @endforeach
              </div>
            @endif
            @if($guru->kelasMapel->count() > 0)
              <h6 class="text-muted small mb-2">Guru Mata Pelajaran:</h6>
              <div class="d-flex gap-2 flex-wrap">
                @foreach($guru->kelasMapel as $k)
                  <span class="badge bg-primary px-3">{{ $k->nama_kelas }}</span>
                @endforeach
              </div>
            @endif
            @if($guru->waliKelas->count() === 0 && $guru->kelasMapel->count() === 0)
              <div class="alert alert-info mb-0 py-2">
                <i class="bi bi-info-circle me-1"></i>
                Guru belum ditugaskan ke kelas manapun.
              </div>
            @endif
          </div>
        </div>

      </div>
    </div>
  </section>
</main>
@endsection