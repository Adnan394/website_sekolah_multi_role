@extends('layouts.admin', ['active' => 'profile'])

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile Saya</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if($isIncomplete)
      <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center justify-content-between flex-wrap gap-2" role="alert">
        <div>
          <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
          <strong>Data Profil Belum Lengkap!</strong> Harap lengkapi data profil Anda agar data terdaftar dengan benar di sistem.
        </div>
        <a href="{{ route('profile.edit') }}" class="btn btn-warning btn-sm fw-bold">
          <i class="bi bi-pencil-square me-1"></i> Lengkapi Data Sekarang
        </a>
      </div>
    @endif

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center text-center">
              @if(strtolower($user->role) == 'guru' && $profileData && $profileData->foto)
                  <img src="{{ $profileData->foto_url }}" alt="Profile" class="rounded-circle" style="width:120px; height:120px; object-fit:cover;">
              @elseif(strtolower($user->role) == 'siswa' && $profileData && $profileData->foto)
                  <img src="{{ $profileData->foto_url }}" alt="Profile" class="rounded-circle" style="width:120px; height:120px; object-fit:cover;">
              @else
                  <img src="https://ui-avatars.com/api/?name={{ urlencode($profileData->nama_lengkap ?? $user->username) }}&background=890A0A&color=fff&size=200" alt="Profile" class="rounded-circle" style="width:120px; height:120px;">
              @endif
              
              <h2 class="mt-3 fs-4 fw-bold">{{ $profileData->nama_lengkap ?? $user->username }}</h2>
              <h3 class="text-muted fs-6 mb-3">{{ ucfirst($user->role) }}</h3>

              <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm px-3">
                <i class="bi bi-pencil-square me-1"></i> Edit Profil / Lengkapi Data
              </a>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <ul class="nav nav-tabs nav-tabs-bordered">
                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Detail Profil</button>
                </li>
              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title text-primary fw-bold mb-3"><i class="bi bi-person-badge me-2"></i>Informasi Akun</h5>
                  
                  <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label fw-bold">Username</div>
                    <div class="col-lg-9 col-md-8">{{ $user->username }}</div>
                  </div>

                  <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label fw-bold">Email</div>
                    <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                  </div>
                  
                  <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label fw-bold">Role</div>
                    <div class="col-lg-9 col-md-8"><span class="badge bg-danger">{{ ucfirst($user->role) }}</span></div>
                  </div>

                  @if($user->deskripsi)
                  <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label fw-bold">Deskripsi</div>
                    <div class="col-lg-9 col-md-8">{{ $user->deskripsi }}</div>
                  </div>
                  @endif

                  @if(strtolower($user->role) == 'guru')
                      <hr class="my-4">
                      <h5 class="card-title text-primary fw-bold mb-3"><i class="bi bi-journal-bookmark me-2"></i>Informasi Data Guru</h5>
                      @if($profileData)
                        <div class="row mb-2">
                          <div class="col-lg-3 col-md-4 label fw-bold">Nama Lengkap</div>
                          <div class="col-lg-9 col-md-8">{{ $profileData->nama_gelar ?? $profileData->nama_lengkap }}</div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-lg-3 col-md-4 label fw-bold">NIP</div>
                          <div class="col-lg-9 col-md-8">{{ $profileData->nip ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-lg-3 col-md-4 label fw-bold">NUPTK</div>
                          <div class="col-lg-9 col-md-8">{{ $profileData->nuptk ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-lg-3 col-md-4 label fw-bold">Jabatan</div>
                          <div class="col-lg-9 col-md-8">{{ $profileData->jabatan ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-lg-3 col-md-4 label fw-bold">Status Kepegawaian</div>
                          <div class="col-lg-9 col-md-8">{{ $profileData->status_kepegawaian ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-lg-3 col-md-4 label fw-bold">Jenis Kelamin</div>
                          <div class="col-lg-9 col-md-8">{{ $profileData->jenis_kelamin == 'L' ? 'Laki-Laki' : ($profileData->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-lg-3 col-md-4 label fw-bold">Tempat, Tgl Lahir</div>
                          <div class="col-lg-9 col-md-8">
                            {{ $profileData->tempat_lahir ?? '-' }}, {{ $profileData->tanggal_lahir ? $profileData->tanggal_lahir->format('d F Y') : '-' }}
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-lg-3 col-md-4 label fw-bold">No HP</div>
                          <div class="col-lg-9 col-md-8">{{ $profileData->no_hp ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-lg-3 col-md-4 label fw-bold">Email Pribadi</div>
                          <div class="col-lg-9 col-md-8">{{ $profileData->email_pribadi ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-lg-3 col-md-4 label fw-bold">Pendidikan Terakhir</div>
                          <div class="col-lg-9 col-md-8">{{ $profileData->pendidikan_terakhir ? $profileData->pendidikan_terakhir . ($profileData->jurusan ? ' - ' . $profileData->jurusan : '') : '-' }}</div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-lg-3 col-md-4 label fw-bold">Alamat</div>
                          <div class="col-lg-9 col-md-8">{{ $profileData->alamat_lengkap ?? ($profileData->alamat ?? '-') }}</div>
                        </div>
                      @else
                        <p class="text-muted">Data guru belum diisi. Klik tombol <strong>Edit Profil / Lengkapi Data</strong> di samping untuk melengkapi data Anda.</p>
                      @endif
                  @endif

                  @if(strtolower($user->role) == 'siswa')
                      <hr class="my-4">
                      <h5 class="card-title text-primary fw-bold mb-3"><i class="bi bi-person-lines-fill me-2"></i>Informasi Data Siswa</h5>
                      @if($profileData)
                        <div class="row mb-2">
                          <div class="col-lg-3 col-md-4 label fw-bold">Nama Lengkap</div>
                          <div class="col-lg-9 col-md-8">{{ $profileData->nama_lengkap }}</div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-lg-3 col-md-4 label fw-bold">NISN</div>
                          <div class="col-lg-9 col-md-8">{{ $profileData->nisn ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-lg-3 col-md-4 label fw-bold">NIS</div>
                          <div class="col-lg-9 col-md-8">{{ $profileData->nis ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-lg-3 col-md-4 label fw-bold">Jenis Kelamin</div>
                          <div class="col-lg-9 col-md-8">{{ $profileData->jenis_kelamin == 'L' ? 'Laki-Laki' : ($profileData->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-lg-3 col-md-4 label fw-bold">Tempat, Tgl Lahir</div>
                          <div class="col-lg-9 col-md-8">
                            {{ $profileData->tempat_lahir ?? '-' }}, {{ $profileData->tanggal_lahir ? $profileData->tanggal_lahir->format('d F Y') : '-' }}
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-lg-3 col-md-4 label fw-bold">Agama</div>
                          <div class="col-lg-9 col-md-8">{{ $profileData->agama ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-lg-3 col-md-4 label fw-bold">No HP</div>
                          <div class="col-lg-9 col-md-8">{{ $profileData->no_hp ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-lg-3 col-md-4 label fw-bold">Alamat</div>
                          <div class="col-lg-9 col-md-8">{{ $profileData->alamat ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-lg-3 col-md-4 label fw-bold">Tahun Masuk</div>
                          <div class="col-lg-9 col-md-8">{{ $profileData->tahun_masuk ?? '-' }}</div>
                        </div>
                      @else
                        <p class="text-muted">Data siswa belum diisi. Klik tombol <strong>Edit Profil / Lengkapi Data</strong> di samping untuk melengkapi data Anda.</p>
                      @endif
                  @endif

                  @if(in_array(strtolower($user->role), ['admin perpustakaan', 'admin perpus', 'petugas perpus']))
                      <hr class="my-4">
                      <h5 class="card-title text-primary fw-bold mb-3"><i class="bi bi-book me-2"></i>Informasi Petugas Perpustakaan</h5>
                      <p class="text-muted">Anda terdaftar sebagai <strong>{{ $user->role }}</strong>. Anda dapat memperbarui informasi akun, email, dan deskripsi pada halaman edit profil.</p>
                  @endif

                </div>
              </div><!-- End Bordered Tabs -->
            </div>
          </div>

        </div>
      </div>
    </section>
</main>
@endsection

