@extends('layouts.admin')

@section('content')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Detail Kelas</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('kelas.index') }}">Data Kelas</a></li>
        <li class="breadcrumb-item active">Detail {{ $kelas->nama_kelas }}</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">

      {{-- ── Kartu Info Utama ── --}}
      <div class="col-lg-4">
        <div class="card text-center shadow-sm">
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
                <div class="fs-4 fw-bold text-success">{{ $kelas->siswa->count() }}</div>
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

              <div class="border-top pt-2 mt-2 text-start">
                <div class="small fw-semibold text-muted mb-2">Pintasan Manajemen:</div>
                <div class="d-grid gap-1">
                  <a href="{{ route('kelas-guru.show', $kelas) }}" class="btn btn-sm btn-outline-primary text-start">
                    <i class="bi bi-person-badge me-2"></i>Map Guru & Wali Kelas
                  </a>
                  <a href="{{ route('kelas-siswa.detail', $kelas->id) }}" class="btn btn-sm btn-outline-success text-start">
                    <i class="bi bi-people me-2"></i>Map Siswa Kelas
                  </a>
                  <a href="{{ route('jadwal-pelajaran.grid', ['kelas_id' => $kelas->id]) }}" class="btn btn-sm btn-outline-info text-start">
                    <i class="bi bi-calendar-week me-2"></i>Jadwal Pelajaran Kelas
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- ── Detail & Relasi ── --}}
      <div class="col-lg-8">

        {{-- 1. Info Detail --}}
        <div class="card shadow-sm mb-3">
          <div class="card-body pt-3">
            <h5 class="card-title pb-0 mb-3"><i class="bi bi-info-circle me-2 text-primary"></i>Informasi Kelas</h5>
            <table class="table table-borderless table-sm align-middle">
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

        {{-- 2. Wali Kelas --}}
        <div class="card shadow-sm mb-3">
          <div class="card-body pt-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="card-title pb-0 mb-0"><i class="bi bi-person-badge me-2 text-danger"></i>Wali Kelas</h5>
              <a href="{{ route('kelas-guru.show', $kelas) }}" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-pencil me-1"></i> Kelola Wali Kelas
              </a>
            </div>

            @if($waliKelas)
              <div class="d-flex align-items-center gap-3 p-3 bg-light rounded border">
                <img src="{{ $waliKelas->foto_url }}" alt="Foto Wali Kelas" class="rounded-circle border" width="60" height="60" style="object-fit:cover;">
                <div class="flex-grow-1">
                  <h6 class="fw-bold mb-1">{{ $waliKelas->nama_gelar }}</h6>
                  <div class="text-muted small">
                    NIP: {{ $waliKelas->nip ?? '-' }} · Status: {{ $waliKelas->status_kepegawaian ?? '-' }} · {{ $waliKelas->jabatan ?? 'Guru' }}
                  </div>
                  @if($waliKelas->no_hp)
                    <div class="text-muted small mt-1">
                      <i class="bi bi-telephone me-1"></i>{{ $waliKelas->no_hp }}
                    </div>
                  @endif
                </div>
                <div>
                  <span class="badge bg-danger px-3 py-2">Wali Kelas</span>
                </div>
              </div>
            @else
              <div class="alert alert-warning d-flex justify-content-between align-items-center mb-0 py-2">
                <div><i class="bi bi-exclamation-triangle me-2"></i>Belum ada wali kelas yang ditetapkan untuk kelas ini.</div>
                <a href="{{ route('kelas-guru.show', $kelas) }}" class="btn btn-sm btn-danger text-nowrap">Tetapkan Sekarang</a>
              </div>
            @endif
          </div>
        </div>

        {{-- 3. Guru Mata Pelajaran --}}
        <div class="card shadow-sm mb-3">
          <div class="card-body pt-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div class="d-flex align-items-center gap-2">
                <h5 class="card-title pb-0 mb-0"><i class="bi bi-journal-bookmark me-2 text-primary"></i>Guru Mata Pelajaran</h5>
                <span class="badge bg-primary rounded-pill">{{ $guruMapelList->count() }} Mapel</span>
              </div>
              <a href="{{ route('kelas-guru.show', $kelas) }}" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-gear me-1"></i> Atur Guru Mapel
              </a>
            </div>

            @if($guruMapelList->isNotEmpty())
              <div class="table-responsive">
                <table class="table table-hover table-bordered table-sm align-middle mb-0">
                  <thead class="table-light">
                    <tr>
                      <th width="5%" class="text-center">No</th>
                      <th>Mata Pelajaran</th>
                      <th>Guru Pengampu</th>
                      <th>NIP / Gelar</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($guruMapelList as $index => $gm)
                      <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                          <span class="badge bg-secondary me-1">{{ $gm->kode_pelajaran }}</span>
                          <strong>{{ $gm->nama_pelajaran }}</strong>
                        </td>
                        <td>
                          <div class="d-flex align-items-center gap-2">
                            <img src="{{ $gm->foto_url }}" alt="Foto Guru" class="rounded-circle" width="30" height="30" style="object-fit:cover;">
                            <span>{{ $gm->nama_gelar }}</span>
                          </div>
                        </td>
                        <td>
                          <small class="text-muted">{{ $gm->nip ?? '-' }}</small>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @else
              <div class="alert alert-light border d-flex justify-content-between align-items-center mb-0 py-2">
                <div class="text-muted small"><i class="bi bi-info-circle me-1"></i>Belum ada guru mata pelajaran yang dipetakan pada kelas ini.</div>
                <a href="{{ route('kelas-guru.show', $kelas) }}" class="btn btn-sm btn-primary text-nowrap">Mapping Guru Mapel</a>
              </div>
            @endif
          </div>
        </div>

        {{-- 4. Daftar Siswa --}}
        <div class="card shadow-sm mb-3">
          <div class="card-body pt-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div class="d-flex align-items-center gap-2">
                <h5 class="card-title pb-0 mb-0"><i class="bi bi-people me-2 text-success"></i>Daftar Siswa</h5>
                <span class="badge bg-success rounded-pill">{{ $kelas->siswa->count() }} / {{ $kelas->kapasitas }}</span>
              </div>
              <a href="{{ route('kelas-siswa.detail', $kelas->id) }}" class="btn btn-sm btn-outline-success">
                <i class="bi bi-plus-lg me-1"></i> Kelola Siswa Kelas
              </a>
            </div>

            @if($kelas->siswa->isNotEmpty())
              <div class="table-responsive">
                <table class="table table-hover table-bordered table-sm align-middle mb-0">
                  <thead class="table-light">
                    <tr>
                      <th width="7%" class="text-center">Absen</th>
                      <th>Foto</th>
                      <th>NISN / NIS</th>
                      <th>Nama Lengkap</th>
                      <th class="text-center">L/P</th>
                      <th class="text-center">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($kelas->siswa as $s)
                      <tr>
                        <td class="text-center fw-bold">{{ $s->pivot->nomor_absen ?? '-' }}</td>
                        <td width="40">
                          <img src="{{ $s->foto_url }}" class="rounded-circle" width="32" height="32" style="object-fit:cover;">
                        </td>
                        <td>
                          <small>{{ $s->nisn ?? '-' }} <br> {{ $s->nis ?? '-' }}</small>
                        </td>
                        <td>
                          <strong><a href="{{ route('siswa.show', $s->id) }}" class="text-dark">{{ $s->nama_lengkap }}</a></strong>
                        </td>
                        <td class="text-center">{{ $s->jenis_kelamin ?? '-' }}</td>
                        <td class="text-center">
                          <span class="badge bg-{{ $s->pivot->status == 'Aktif' ? 'success' : 'secondary' }}">
                            {{ $s->pivot->status }}
                          </span>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @else
              <div class="alert alert-light border d-flex justify-content-between align-items-center mb-0 py-2">
                <div class="text-muted small"><i class="bi bi-info-circle me-1"></i>Belum ada siswa yang terdaftar di kelas ini.</div>
                <a href="{{ route('kelas-siswa.detail', $kelas->id) }}" class="btn btn-sm btn-success text-nowrap">Tambah Siswa</a>
              </div>
            @endif
          </div>
        </div>

        {{-- 5. Jadwal Pelajaran --}}
        <div class="card shadow-sm mb-3">
          <div class="card-body pt-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div class="d-flex align-items-center gap-2">
                <h5 class="card-title pb-0 mb-0"><i class="bi bi-calendar-week me-2 text-info"></i>Jadwal Pelajaran</h5>
                <span class="badge bg-info text-dark rounded-pill">{{ $jadwalList->count() }} Sesi</span>
              </div>
              <div class="d-flex gap-1">
                <a href="{{ route('jadwal-pelajaran.grid', ['kelas_id' => $kelas->id]) }}" class="btn btn-sm btn-outline-info">
                  <i class="bi bi-grid-3x3 me-1"></i> Tampilan Grid
                </a>
                <a href="{{ route('jadwal-pelajaran.index', ['kelas_id' => $kelas->id]) }}" class="btn btn-sm btn-outline-secondary">
                  <i class="bi bi-list-ul me-1"></i> Kelola Jadwal
                </a>
              </div>
            </div>

            @if($jadwalList->isNotEmpty())
              <div class="table-responsive">
                <table class="table table-hover table-bordered table-sm align-middle mb-0">
                  <thead class="table-light">
                    <tr>
                      <th width="12%">Hari</th>
                      <th width="15%">Waktu</th>
                      <th>Mata Pelajaran</th>
                      <th>Guru Pengampu</th>
                      <th>Ruangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($jadwalList as $j)
                      <tr>
                        <td><span class="badge bg-dark-subtle text-dark border">{{ $j->hari }}</span></td>
                        <td><small class="fw-semibold">Jam ke-{{ $j->jam_ke }}</small><br><small class="text-muted">{{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }}</small></td>
                        <td>
                          <strong>{{ $j->pelajaran->nama_pelajaran ?? '-' }}</strong>
                        </td>
                        <td>
                          <div class="d-flex align-items-center gap-2">
                            @if($j->guru)
                              <img src="{{ $j->guru->foto_url }}" class="rounded-circle" width="24" height="24" style="object-fit:cover;">
                              <span>{{ $j->guru->nama_gelar }}</span>
                            @else
                              <span class="text-muted">-</span>
                            @endif
                          </div>
                        </td>
                        <td><small>{{ $j->ruangan ?? '-' }}</small></td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @else
              <div class="alert alert-light border d-flex justify-content-between align-items-center mb-0 py-2">
                <div class="text-muted small"><i class="bi bi-info-circle me-1"></i>Belum ada jadwal pelajaran untuk kelas ini.</div>
                <a href="{{ route('jadwal-pelajaran.create', ['kelas_id' => $kelas->id]) }}" class="btn btn-sm btn-info text-nowrap">Tambah Jadwal</a>
              </div>
            @endif
          </div>
        </div>

      </div>{{-- /col-lg-8 --}}
    </div>{{-- /row --}}
  </section>

</main>
@endsection