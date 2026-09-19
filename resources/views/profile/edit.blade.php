@extends('layouts.admin', ['active' => 'profile'])

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Edit & Lengkapi Profil</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('profile.index') }}">Profile</a></li>
          <li class="breadcrumb-item active">Edit Profil</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-lg-12">

          @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="bi bi-exclamation-triangle-fill me-2"></i>
              <strong>Terjadi kesalahan:</strong>
              <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <div class="card">
            <div class="card-body pt-4">
              
              <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- ─────────────────────────────────────────────── -->
                <!--  1. INFORMASI AKUN (UNTUK SEMUA ROLE)          -->
                <!-- ─────────────────────────────────────────────── -->
                <h5 class="card-title text-primary fw-bold"><i class="bi bi-person-lock me-2"></i>Informasi Akun</h5>
                
                <div class="row mb-3">
                  <div class="col-md-6 mb-3 mb-md-0">
                    <label for="username" class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $user->username) }}" required>
                    @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>
                  <div class="col-md-6">
                    <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6 mb-3 mb-md-0">
                    <label for="password" class="form-label fw-semibold">Password Baru <small class="text-muted">(Kosongkan jika tidak ingin diubah)</small></label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Minimal 6 karakter">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>
                  <div class="col-md-6">
                    <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-12">
                    <label for="deskripsi" class="form-label fw-semibold">Deskripsi Singkat / Catatan</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="2" placeholder="Catatan singkat profil...">{{ old('deskripsi', $user->deskripsi) }}</textarea>
                    @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>
                </div>

                <!-- ─────────────────────────────────────────────── -->
                <!--  2. FORM SPECIFIC UNTUK ROLE: SISWA            -->
                <!-- ─────────────────────────────────────────────── -->
                @if(strtolower($user->role) === 'siswa')
                  <hr class="my-4">
                  <h5 class="card-title text-primary fw-bold"><i class="bi bi-mortarboard me-2"></i>Kelengkapan Data Siswa</h5>

                  <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                      <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                      <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $profileData->nama_lengkap ?? $user->username) }}" required>
                      @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                      <label for="nisn" class="form-label fw-semibold">NISN</label>
                      <input type="text" class="form-control @error('nisn') is-invalid @enderror" id="nisn" name="nisn" value="{{ old('nisn', $profileData->nisn ?? '') }}" placeholder="Contoh: 0012345678">
                      @error('nisn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                      <label for="nis" class="form-label fw-semibold">NIS</label>
                      <input type="text" class="form-control @error('nis') is-invalid @enderror" id="nis" name="nis" value="{{ old('nis', $profileData->nis ?? '') }}" placeholder="Contoh: 2024001">
                      @error('nis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-4 mb-3 mb-md-0">
                      <label for="tempat_lahir" class="form-label fw-semibold">Tempat Lahir</label>
                      <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $profileData->tempat_lahir ?? '') }}">
                      @error('tempat_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                      <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir</label>
                      <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', isset($profileData->tanggal_lahir) ? \Carbon\Carbon::parse($profileData->tanggal_lahir)->format('Y-m-d') : '') }}">
                      @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                      <label for="jenis_kelamin" class="form-label fw-semibold">Jenis Kelamin</label>
                      <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin">
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin', $profileData->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                        <option value="P" {{ old('jenis_kelamin', $profileData->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                      </select>
                      @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-4 mb-3 mb-md-0">
                      <label for="agama" class="form-label fw-semibold">Agama</label>
                      <select class="form-select @error('agama') is-invalid @enderror" id="agama" name="agama">
                        <option value="">-- Pilih Agama --</option>
                        @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $ag)
                          <option value="{{ $ag }}" {{ old('agama', $profileData->agama ?? '') == $ag ? 'selected' : '' }}>{{ $ag }}</option>
                        @endforeach
                      </select>
                      @error('agama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                      <label for="no_hp" class="form-label fw-semibold">No HP / WhatsApp</label>
                      <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp', $profileData->no_hp ?? '') }}" placeholder="08xxxxxxxxxx">
                      @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                      <label for="tahun_masuk" class="form-label fw-semibold">Tahun Masuk</label>
                      <input type="number" class="form-control @error('tahun_masuk') is-invalid @enderror" id="tahun_masuk" name="tahun_masuk" value="{{ old('tahun_masuk', $profileData->tahun_masuk ?? date('Y')) }}" placeholder="2024">
                      @error('tahun_masuk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-8 mb-3 mb-md-0">
                      <label for="alamat" class="form-label fw-semibold">Alamat Lengkap</label>
                      <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" placeholder="Alamat rumah lengkap...">{{ old('alamat', $profileData->alamat ?? '') }}</textarea>
                      @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                      <label for="foto" class="form-label fw-semibold">Foto Profil</label>
                      <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*">
                      <small class="text-muted d-block mt-1">Format: JPG, PNG, WEBP (Max 2MB)</small>
                      @if(isset($profileData->foto) && $profileData->foto)
                        <div class="mt-2">
                          <img src="{{ $profileData->foto_url }}" alt="Preview Foto" class="rounded img-thumbnail" style="height: 70px; object-fit: cover;">
                        </div>
                      @endif
                      @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                  </div>
                @endif

                <!-- ─────────────────────────────────────────────── -->
                <!--  3. FORM SPECIFIC UNTUK ROLE: GURU             -->
                <!-- ─────────────────────────────────────────────── -->
                @if(strtolower($user->role) === 'guru')
                  <hr class="my-4">
                  <h5 class="card-title text-primary fw-bold"><i class="bi bi-person-workspace me-2"></i>Kelengkapan Data Guru</h5>

                  <div class="row mb-3">
                    <div class="col-md-2 mb-3 mb-md-0">
                      <label for="gelar_depan" class="form-label fw-semibold">Gelar Depan</label>
                      <input type="text" class="form-control" id="gelar_depan" name="gelar_depan" value="{{ old('gelar_depan', $profileData->gelar_depan ?? '') }}" placeholder="Dr. / Drs.">
                    </div>
                    <div class="col-md-6 mb-3 mb-md-0">
                      <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                      <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $profileData->nama_lengkap ?? $user->username) }}" required>
                      @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                      <label for="gelar_belakang" class="form-label fw-semibold">Gelar Belakang</label>
                      <input type="text" class="form-control" id="gelar_belakang" name="gelar_belakang" value="{{ old('gelar_belakang', $profileData->gelar_belakang ?? '') }}" placeholder="S.Pd., M.Pd.">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                      <label for="nip" class="form-label fw-semibold">NIP</label>
                      <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ old('nip', $profileData->nip ?? '') }}" placeholder="Nomor Induk Pegawai">
                      @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                      <label for="nuptk" class="form-label fw-semibold">NUPTK</label>
                      <input type="text" class="form-control @error('nuptk') is-invalid @enderror" id="nuptk" name="nuptk" value="{{ old('nuptk', $profileData->nuptk ?? '') }}" placeholder="Nomor Unik Pendidik">
                      @error('nuptk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-4 mb-3 mb-md-0">
                      <label for="tempat_lahir" class="form-label fw-semibold">Tempat Lahir</label>
                      <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $profileData->tempat_lahir ?? '') }}">
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                      <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir</label>
                      <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', isset($profileData->tanggal_lahir) ? \Carbon\Carbon::parse($profileData->tanggal_lahir)->format('Y-m-d') : '') }}">
                    </div>
                    <div class="col-md-4">
                      <label for="jenis_kelamin" class="form-label fw-semibold">Jenis Kelamin</label>
                      <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin', $profileData->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                        <option value="P" {{ old('jenis_kelamin', $profileData->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                      </select>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-4 mb-3 mb-md-0">
                      <label for="agama" class="form-label fw-semibold">Agama</label>
                      <select class="form-select" id="agama" name="agama">
                        <option value="">-- Pilih Agama --</option>
                        @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $ag)
                          <option value="{{ $ag }}" {{ old('agama', $profileData->agama ?? '') == $ag ? 'selected' : '' }}>{{ $ag }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                      <label for="status_pernikahan" class="form-label fw-semibold">Status Pernikahan</label>
                      <select class="form-select" id="status_pernikahan" name="status_pernikahan">
                        <option value="">-- Pilih --</option>
                        @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $sp)
                          <option value="{{ $sp }}" {{ old('status_pernikahan', $profileData->status_pernikahan ?? '') == $sp ? 'selected' : '' }}>{{ $sp }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label for="no_hp" class="form-label fw-semibold">No HP / WhatsApp</label>
                      <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp', $profileData->no_hp ?? '') }}" placeholder="08xxxxxxxxxx">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                      <label for="email_pribadi" class="form-label fw-semibold">Email Pribadi</label>
                      <input type="email" class="form-control" id="email_pribadi" name="email_pribadi" value="{{ old('email_pribadi', $profileData->email_pribadi ?? '') }}" placeholder="email@pribadi.com">
                    </div>
                    <div class="col-md-6">
                      <label for="no_telp" class="form-label fw-semibold">No Telepon Rumah</label>
                      <input type="text" class="form-control" id="no_telp" name="no_telp" value="{{ old('no_telp', $profileData->no_telp ?? '') }}">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-8 mb-3 mb-md-0">
                      <label for="alamat" class="form-label fw-semibold">Alamat Jalan / Rumah</label>
                      <textarea class="form-control" id="alamat" name="alamat" rows="2">{{ old('alamat', $profileData->alamat ?? '') }}</textarea>
                    </div>
                    <div class="col-md-2 mb-3 mb-md-0">
                      <label for="rt" class="form-label fw-semibold">RT</label>
                      <input type="text" class="form-control" id="rt" name="rt" value="{{ old('rt', $profileData->rt ?? '') }}">
                    </div>
                    <div class="col-md-2">
                      <label for="rw" class="form-label fw-semibold">RW</label>
                      <input type="text" class="form-control" id="rw" name="rw" value="{{ old('rw', $profileData->rw ?? '') }}">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-3 mb-3 mb-md-0">
                      <label for="kelurahan" class="form-label fw-semibold">Kelurahan / Desa</label>
                      <input type="text" class="form-control" id="kelurahan" name="kelurahan" value="{{ old('kelurahan', $profileData->kelurahan ?? '') }}">
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                      <label for="kecamatan" class="form-label fw-semibold">Kecamatan</label>
                      <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $profileData->kecamatan ?? '') }}">
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                      <label for="kota" class="form-label fw-semibold">Kota / Kabupaten</label>
                      <input type="text" class="form-control" id="kota" name="kota" value="{{ old('kota', $profileData->kota ?? '') }}">
                    </div>
                    <div class="col-md-3">
                      <label for="provinsi" class="form-label fw-semibold">Provinsi</label>
                      <input type="text" class="form-control" id="provinsi" name="provinsi" value="{{ old('provinsi', $profileData->provinsi ?? '') }}">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-3 mb-3 mb-md-0">
                      <label for="pendidikan_terakhir" class="form-label fw-semibold">Pendidikan Terakhir</label>
                      <select class="form-select" id="pendidikan_terakhir" name="pendidikan_terakhir">
                        <option value="">-- Pilih --</option>
                        @foreach(['SMA/SMK', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'] as $pt)
                          <option value="{{ $pt }}" {{ old('pendidikan_terakhir', $profileData->pendidikan_terakhir ?? '') == $pt ? 'selected' : '' }}>{{ $pt }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                      <label for="jurusan" class="form-label fw-semibold">Jurusan</label>
                      <input type="text" class="form-control" id="jurusan" name="jurusan" value="{{ old('jurusan', $profileData->jurusan ?? '') }}" placeholder="Pendidikan Guru SD">
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                      <label for="universitas" class="form-label fw-semibold">Universitas</label>
                      <input type="text" class="form-control" id="universitas" name="universitas" value="{{ old('universitas', $profileData->universitas ?? '') }}">
                    </div>
                    <div class="col-md-3">
                      <label for="tahun_lulus" class="form-label fw-semibold">Tahun Lulus</label>
                      <input type="number" class="form-control" id="tahun_lulus" name="tahun_lulus" value="{{ old('tahun_lulus', $profileData->tahun_lulus ?? '') }}">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-4 mb-3 mb-md-0">
                      <label for="status_kepegawaian" class="form-label fw-semibold">Status Kepegawaian</label>
                      <select class="form-select" id="status_kepegawaian" name="status_kepegawaian">
                        <option value="">-- Pilih --</option>
                        @foreach(['PNS', 'PPPK', 'GTT', 'Honor', 'Kontrak'] as $sk)
                          <option value="{{ $sk }}" {{ old('status_kepegawaian', $profileData->status_kepegawaian ?? '') == $sk ? 'selected' : '' }}>{{ $sk }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                      <label for="jabatan" class="form-label fw-semibold">Jabatan</label>
                      <select class="form-select" id="jabatan" name="jabatan">
                        <option value="">-- Pilih --</option>
                        @foreach(['Kepala Sekolah', 'Wakil Kepala Sekolah', 'Guru Kelas', 'Guru Mata Pelajaran', 'Guru Pendamping', 'Tenaga Administrasi'] as $jb)
                          <option value="{{ $jb }}" {{ old('jabatan', $profileData->jabatan ?? '') == $jb ? 'selected' : '' }}>{{ $jb }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label for="foto" class="form-label fw-semibold">Foto Profil</label>
                      <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*">
                      <small class="text-muted d-block mt-1">Format: JPG, PNG, WEBP (Max 2MB)</small>
                      @if(isset($profileData->foto) && $profileData->foto)
                        <div class="mt-2">
                          <img src="{{ $profileData->foto_url }}" alt="Preview Foto" class="rounded img-thumbnail" style="height: 70px; object-fit: cover;">
                        </div>
                      @endif
                      @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                  </div>
                @endif

                <div class="d-flex justify-content-end gap-2 mt-4">
                  <a href="{{ route('profile.index') }}" class="btn btn-secondary px-4">Batal</a>
                  <button type="submit" class="btn btn-primary px-4 fw-bold">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                  </button>
                </div>

              </form>

            </div>
          </div>

        </div>
      </div>
    </section>

</main>
@endsection
