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

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
              @if($user->role == 'guru' && $profileData && $profileData->foto)
                  <img src="{{ $profileData->foto_url }}" alt="Profile" class="rounded-circle" style="width:120px; height:120px; object-fit:cover;">
              @elseif($user->role == 'siswa' && $profileData && $profileData->foto)
                  <img src="{{ $profileData->foto_url }}" alt="Profile" class="rounded-circle" style="width:120px; height:120px; object-fit:cover;">
              @else
                  <img src="https://ui-avatars.com/api/?name={{ urlencode($profileData->nama_lengkap ?? $user->username) }}&background=random" alt="Profile" class="rounded-circle" style="width:120px; height:120px;">
              @endif
              
              <h2 class="mt-3">{{ $profileData->nama_lengkap ?? $user->username }}</h2>
              <h3 class="text-muted">{{ ucfirst($user->role) }}</h3>
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
                  <h5 class="card-title">Informasi Akun</h5>
                  
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label fw-bold">Username</div>
                    <div class="col-lg-9 col-md-8">{{ $user->username }}</div>
                  </div>

                  <div class="row mt-2">
                    <div class="col-lg-3 col-md-4 label fw-bold">Email</div>
                    <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                  </div>
                  
                  <div class="row mt-2">
                    <div class="col-lg-3 col-md-4 label fw-bold">Role</div>
                    <div class="col-lg-9 col-md-8"><span class="badge bg-primary">{{ ucfirst($user->role) }}</span></div>
                  </div>

                  @if($user->role == 'guru' && $profileData)
                      <hr class="mt-4">
                      <h5 class="card-title">Informasi Data Guru</h5>
                      <div class="row">
                        <div class="col-lg-3 col-md-4 label fw-bold">NIP</div>
                        <div class="col-lg-9 col-md-8">{{ $profileData->nip ?? '-' }}</div>
                      </div>
                      <div class="row mt-2">
                        <div class="col-lg-3 col-md-4 label fw-bold">NUPTK</div>
                        <div class="col-lg-9 col-md-8">{{ $profileData->nuptk ?? '-' }}</div>
                      </div>
                      <div class="row mt-2">
                        <div class="col-lg-3 col-md-4 label fw-bold">Nama Lengkap</div>
                        <div class="col-lg-9 col-md-8">{{ $profileData->nama_lengkap }}</div>
                      </div>
                      <div class="row mt-2">
                        <div class="col-lg-3 col-md-4 label fw-bold">Jabatan</div>
                        <div class="col-lg-9 col-md-8">{{ $profileData->jabatan ?? '-' }}</div>
                      </div>
                      <div class="row mt-2">
                        <div class="col-lg-3 col-md-4 label fw-bold">No HP</div>
                        <div class="col-lg-9 col-md-8">{{ $profileData->no_hp ?? '-' }}</div>
                      </div>
                      <div class="row mt-2">
                        <div class="col-lg-3 col-md-4 label fw-bold">Alamat</div>
                        <div class="col-lg-9 col-md-8">{{ $profileData->alamat_lengkap ?? '-' }}</div>
                      </div>
                  @endif

                  @if($user->role == 'siswa' && $profileData)
                      <hr class="mt-4">
                      <h5 class="card-title">Informasi Data Siswa</h5>
                      <div class="row">
                        <div class="col-lg-3 col-md-4 label fw-bold">NISN</div>
                        <div class="col-lg-9 col-md-8">{{ $profileData->nisn ?? '-' }}</div>
                      </div>
                      <div class="row mt-2">
                        <div class="col-lg-3 col-md-4 label fw-bold">NIS</div>
                        <div class="col-lg-9 col-md-8">{{ $profileData->nis ?? '-' }}</div>
                      </div>
                      <div class="row mt-2">
                        <div class="col-lg-3 col-md-4 label fw-bold">Nama Lengkap</div>
                        <div class="col-lg-9 col-md-8">{{ $profileData->nama_lengkap }}</div>
                      </div>
                      <div class="row mt-2">
                        <div class="col-lg-3 col-md-4 label fw-bold">Jenis Kelamin</div>
                        <div class="col-lg-9 col-md-8">{{ $profileData->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</div>
                      </div>
                      <div class="row mt-2">
                        <div class="col-lg-3 col-md-4 label fw-bold">No HP</div>
                        <div class="col-lg-9 col-md-8">{{ $profileData->no_hp ?? '-' }}</div>
                      </div>
                      <div class="row mt-2">
                        <div class="col-lg-3 col-md-4 label fw-bold">Alamat</div>
                        <div class="col-lg-9 col-md-8">{{ $profileData->alamat ?? '-' }}</div>
                      </div>
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
