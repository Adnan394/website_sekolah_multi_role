@extends('layouts.admin')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Detail Siswa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}">Data Siswa</a></li>
                <li class="breadcrumb-item active">Profil</li>
            </ol>
        </nav>
    </div>

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <img src="{{ $siswa->foto_url }}" alt="Profile" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #f6f9ff;">
                        <h2 class="mt-3">{{ $siswa->nama_lengkap }}</h2>
                        <h3>NISN: {{ $siswa->nisn ?? '-' }}</h3>
                        <div class="mt-3">
                            <span class="badge bg-{{ $siswa->is_active ? 'success' : 'danger' }}">
                                {{ $siswa->is_active ? 'Siswa Aktif' : 'Non-Aktif' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body pt-3">
                        <h5 class="card-title">Akses Akun</h5>
                        <div class="row">
                            <div class="col-lg-4 label text-muted small">Username</div>
                            <div class="col-lg-8 small font-monospace">{{ $siswa->user->username }}</div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-4 label text-muted small">Email</div>
                            <div class="col-lg-8 small">{{ $siswa->user->email }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Biodata</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-history">Riwayat Kelas</button>
                            </li>
                        </ul>

                        <div class="tab-content pt-2">
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">Informasi Pribadi</h5>

                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label text-muted">Nama Lengkap</div>
                                    <div class="col-lg-9 col-md-8 fw-bold">{{ $siswa->nama_lengkap }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label text-muted">NIS / NISN</div>
                                    <div class="col-lg-9 col-md-8">{{ $siswa->nis ?? '-' }} / {{ $siswa->nisn ?? '-' }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label text-muted">TTL</div>
                                    <div class="col-lg-9 col-md-8">{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('d F Y') : '-' }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label text-muted">Jenis Kelamin</div>
                                    <div class="col-lg-9 col-md-8">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label text-muted">Agama</div>
                                    <div class="col-lg-9 col-md-8">{{ $siswa->agama ?? '-' }}</div>
                                </div>

                                <h5 class="card-title">Kontak & Alamat</h5>

                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label text-muted">No. HP</div>
                                    <div class="col-lg-9 col-md-8">{{ $siswa->no_hp ?? '-' }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label text-muted">Alamat</div>
                                    <div class="col-lg-9 col-md-8">{{ $siswa->alamat ?? '-' }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label text-muted">Tahun Masuk</div>
                                    <div class="col-lg-9 col-md-8 text-primary fw-bold">{{ $siswa->tahun_masuk ?? '-' }}</div>
                                </div>
                            </div>

                            <div class="tab-pane fade pt-3" id="profile-history">
                                <h5 class="card-title">Riwayat Penempatan Kelas</h5>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Tahun Ajaran</th>
                                                <th>Kelas</th>
                                                <th>Absen</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($siswa->kelas as $k)
                                            <tr>
                                                <td>{{ $k->tahun_pelajaran }} ({{ $k->semester }})</td>
                                                <td><strong>{{ $k->nama_kelas }}</strong></td>
                                                <td>{{ $k->pivot->nomor_absen ?? '-' }}</td>
                                                <td><span class="badge bg-primary">{{ $k->pivot->status }}</span></td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">Belum pernah di-plotting ke kelas manapun.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i> Edit Data
                            </a>
                            <a href="{{ route('siswa.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection