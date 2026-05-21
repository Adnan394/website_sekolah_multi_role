@extends('layouts.admin')

@section('content')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Edit Data Guru</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('guru.index') }}">Data Guru</a></li>
        <li class="breadcrumb-item active">Edit</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row justify-content-center">
      <div class="col-lg-10">

        @if($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('guru.update', $guru) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          {{-- Nav Tabs --}}
          <ul class="nav nav-tabs mb-0" id="editTabs" role="tablist">
            <li class="nav-item">
              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-akun">
                <i class="bi bi-person-lock me-1"></i>Akun Login
              </button>
            </li>
            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-identitas">
                <i class="bi bi-person-vcard me-1"></i>Identitas
              </button>
            </li>
            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-alamat">
                <i class="bi bi-geo-alt me-1"></i>Alamat
              </button>
            </li>
            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-kepegawaian">
                <i class="bi bi-briefcase me-1"></i>Kepegawaian
              </button>
            </li>
            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-lain">
                <i class="bi bi-gear me-1"></i>Lainnya
              </button>
            </li>
          </ul>

          <div class="tab-content border border-top-0 rounded-bottom bg-white p-4">

            {{-- ── Tab Akun ──────────────────────────────── --}}
            <div class="tab-pane fade show active" id="tab-akun">
              <div class="row g-3 mt-1">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                  <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                         value="{{ old('username', $guru->user->username ?? '') }}">
                  @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Email Akun <span class="text-danger">*</span></label>
                  <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                         value="{{ old('email', $guru->user->email ?? '') }}">
                  @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Password Baru <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                  <div class="input-group">
                    <input type="password" name="password" id="password"
                           class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePass('password')">
                      <i class="bi bi-eye" id="icon-password"></i>
                    </button>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                  <div class="input-group">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="form-control" placeholder="Ulangi password baru">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePass('password_confirmation')">
                      <i class="bi bi-eye" id="icon-password_confirmation"></i>
                    </button>
                  </div>
                </div>
                <div class="col-12">
                  <label class="form-label fw-semibold">Deskripsi Akun</label>
                  <input type="text" name="deskripsi_akun" class="form-control"
                         value="{{ old('deskripsi_akun', $guru->user->deskripsi ?? '') }}">
                </div>
              </div>
            </div>

            {{-- ── Tab Identitas ─────────────────────────── --}}
            <div class="tab-pane fade" id="tab-identitas">
              <div class="row g-3 mt-1">

                {{-- Foto saat ini --}}
                <div class="col-12 d-flex align-items-center gap-3">
                  <img src="{{ $guru->foto_url }}" alt="Foto"
                       class="rounded-circle border" width="80" height="80" style="object-fit:cover">
                  <div>
                    <label class="form-label fw-semibold mb-1 d-block">Ganti Foto</label>
                    <input type="file" name="foto" class="form-control form-control-sm @error('foto') is-invalid @enderror"
                           accept="image/jpg,image/jpeg,image/png" style="max-width:300px">
                    @if($guru->foto)
                      <div class="form-check mt-1">
                        <input class="form-check-input" type="checkbox" name="hapus_foto" value="1" id="hapus_foto">
                        <label class="form-check-label small text-danger" for="hapus_foto">Hapus foto saat ini</label>
                      </div>
                    @endif
                    @error('foto')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                  </div>
                </div>

                <div class="col-md-2">
                  <label class="form-label fw-semibold">Gelar Depan</label>
                  <input type="text" name="gelar_depan" class="form-control"
                         value="{{ old('gelar_depan', $guru->gelar_depan) }}" placeholder="Dr.">
                </div>
                <div class="col-md-5">
                  <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                  <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
                         value="{{ old('nama_lengkap', $guru->nama_lengkap) }}">
                  @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                  <label class="form-label fw-semibold">Gelar Belakang</label>
                  <input type="text" name="gelar_belakang" class="form-control"
                         value="{{ old('gelar_belakang', $guru->gelar_belakang) }}" placeholder="S.Pd.">
                </div>
                <div class="col-md-2">
                  <label class="form-label fw-semibold">Jenis Kelamin</label>
                  <select name="jenis_kelamin" class="form-select">
                    <option value="">--</option>
                    <option value="L" {{ old('jenis_kelamin', $guru->jenis_kelamin)==='L'?'selected':'' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $guru->jenis_kelamin)==='P'?'selected':'' }}>Perempuan</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <label class="form-label fw-semibold">Tempat Lahir</label>
                  <input type="text" name="tempat_lahir" class="form-control"
                         value="{{ old('tempat_lahir', $guru->tempat_lahir) }}">
                </div>
                <div class="col-md-3">
                  <label class="form-label fw-semibold">Tanggal Lahir</label>
                  <input type="date" name="tanggal_lahir" class="form-control"
                         value="{{ old('tanggal_lahir', $guru->tanggal_lahir?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-3">
                  <label class="form-label fw-semibold">Agama</label>
                  <select name="agama" class="form-select">
                    <option value="">-- Pilih --</option>
                    @foreach($agamaList as $a)
                      <option value="{{ $a }}" {{ old('agama', $guru->agama)===$a?'selected':'' }}>{{ $a }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-2">
                  <label class="form-label fw-semibold">Status Nikah</label>
                  <select name="status_pernikahan" class="form-select">
                    <option value="">--</option>
                    @foreach(['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'] as $sn)
                      <option value="{{ $sn }}" {{ old('status_pernikahan',$guru->status_pernikahan)===$sn?'selected':'' }}>{{ $sn }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-4">
                  <label class="form-label fw-semibold">No. HP</label>
                  <input type="text" name="no_hp" class="form-control"
                         value="{{ old('no_hp', $guru->no_hp) }}">
                </div>
                <div class="col-md-4">
                  <label class="form-label fw-semibold">Email Pribadi</label>
                  <input type="email" name="email_pribadi" class="form-control"
                         value="{{ old('email_pribadi', $guru->email_pribadi) }}">
                </div>
              </div>
            </div>

            {{-- ── Tab Alamat ────────────────────────────── --}}
            <div class="tab-pane fade" id="tab-alamat">
              <div class="row g-3 mt-1">
                <div class="col-12">
                  <label class="form-label fw-semibold">Jalan / Perumahan</label>
                  <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $guru->alamat) }}</textarea>
                </div>
                <div class="col-md-2"><label class="form-label fw-semibold">RT</label>
                  <input type="text" name="rt" class="form-control" value="{{ old('rt', $guru->rt) }}"></div>
                <div class="col-md-2"><label class="form-label fw-semibold">RW</label>
                  <input type="text" name="rw" class="form-control" value="{{ old('rw', $guru->rw) }}"></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Kelurahan</label>
                  <input type="text" name="kelurahan" class="form-control" value="{{ old('kelurahan', $guru->kelurahan) }}"></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Kecamatan</label>
                  <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan', $guru->kecamatan) }}"></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Kota / Kabupaten</label>
                  <input type="text" name="kota" class="form-control" value="{{ old('kota', $guru->kota) }}"></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Provinsi</label>
                  <input type="text" name="provinsi" class="form-control" value="{{ old('provinsi', $guru->provinsi) }}"></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Kode Pos</label>
                  <input type="text" name="kode_pos" class="form-control" value="{{ old('kode_pos', $guru->kode_pos) }}"></div>
              </div>
            </div>

            {{-- ── Tab Kepegawaian ───────────────────────── --}}
            <div class="tab-pane fade" id="tab-kepegawaian">
              <div class="row g-3 mt-1">
                <div class="col-md-3">
                  <label class="form-label fw-semibold">NIP</label>
                  <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror"
                         value="{{ old('nip', $guru->nip) }}">
                  @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                  <label class="form-label fw-semibold">NUPTK</label>
                  <input type="text" name="nuptk" class="form-control @error('nuptk') is-invalid @enderror"
                         value="{{ old('nuptk', $guru->nuptk) }}">
                  @error('nuptk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                  <label class="form-label fw-semibold">Jabatan <span class="text-danger">*</span></label>
                  <select name="jabatan" class="form-select @error('jabatan') is-invalid @enderror">
                    @foreach($jabatanList as $j)
                      <option value="{{ $j }}" {{ old('jabatan', $guru->jabatan)===$j?'selected':'' }}>{{ $j }}</option>
                    @endforeach
                  </select>
                  @error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                  <label class="form-label fw-semibold">Status Kepegawaian</label>
                  <select name="status_kepegawaian" id="status_kepegawaian" class="form-select"
                          onchange="togglePNSFields()">
                    @foreach($statusKepegawaianList as $sk)
                      <option value="{{ $sk }}" {{ old('status_kepegawaian',$guru->status_kepegawaian)===$sk?'selected':'' }}>{{ $sk }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-2" id="field-golongan">
                  <label class="form-label fw-semibold">Golongan</label>
                  <input type="text" name="golongan" class="form-control" value="{{ old('golongan', $guru->golongan) }}" placeholder="III/a">
                </div>
                <div class="col-md-3" id="field-tmt-cpns">
                  <label class="form-label fw-semibold">TMT CPNS</label>
                  <input type="date" name="tmt_cpns" class="form-control" value="{{ old('tmt_cpns', $guru->tmt_cpns?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-3" id="field-tmt-pns">
                  <label class="form-label fw-semibold">TMT PNS</label>
                  <input type="date" name="tmt_pns" class="form-control" value="{{ old('tmt_pns', $guru->tmt_pns?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-3">
                  <label class="form-label fw-semibold">Tanggal Bergabung</label>
                  <input type="date" name="tanggal_bergabung" class="form-control"
                         value="{{ old('tanggal_bergabung', $guru->tanggal_bergabung?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-2">
                  <label class="form-label fw-semibold">Masa Kerja Tahun</label>
                  <input type="number" name="masa_kerja_tahun" class="form-control"
                         value="{{ old('masa_kerja_tahun', $guru->masa_kerja_tahun) }}" min="0" max="50">
                </div>
                <div class="col-md-2">
                  <label class="form-label fw-semibold">Masa Kerja Bulan</label>
                  <input type="number" name="masa_kerja_bulan" class="form-control"
                         value="{{ old('masa_kerja_bulan', $guru->masa_kerja_bulan) }}" min="0" max="11">
                </div>
                <div class="col-md-3">
                  <label class="form-label fw-semibold">Pendidikan Terakhir</label>
                  <select name="pendidikan_terakhir" class="form-select">
                    <option value="">-- Pilih --</option>
                    @foreach($pendidikanList as $p)
                      <option value="{{ $p }}" {{ old('pendidikan_terakhir',$guru->pendidikan_terakhir)===$p?'selected':'' }}>{{ $p }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-4">
                  <label class="form-label fw-semibold">Jurusan</label>
                  <input type="text" name="jurusan" class="form-control" value="{{ old('jurusan', $guru->jurusan) }}">
                </div>
                <div class="col-md-5">
                  <label class="form-label fw-semibold">Universitas</label>
                  <input type="text" name="universitas" class="form-control" value="{{ old('universitas', $guru->universitas) }}">
                </div>
              </div>
            </div>

            {{-- ── Tab Lainnya ───────────────────────────── --}}
            <div class="tab-pane fade" id="tab-lain">
              <div class="row g-3 mt-1">
                <div class="col-md-3 d-flex align-items-center">
                  <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" role="switch"
                           id="is_sertifikasi" name="is_sertifikasi" value="1"
                           onchange="toggleSertifikasi()"
                           {{ old('is_sertifikasi', $guru->is_sertifikasi) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="is_sertifikasi">Sudah Sertifikasi</label>
                  </div>
                </div>
                <div class="col-md-3" id="field-tahun-sertifikasi">
                  <label class="form-label fw-semibold">Tahun Sertifikasi</label>
                  <input type="number" name="tahun_sertifikasi" class="form-control"
                         value="{{ old('tahun_sertifikasi', $guru->tahun_sertifikasi) }}" min="2000">
                </div>
                <div class="col-md-4" id="field-nomor-sertifikasi">
                  <label class="form-label fw-semibold">Nomor Sertifikasi</label>
                  <input type="text" name="nomor_sertifikasi" class="form-control"
                         value="{{ old('nomor_sertifikasi', $guru->nomor_sertifikasi) }}">
                </div>
                <div class="col-md-10">
                  <label class="form-label fw-semibold">Keterangan</label>
                  <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $guru->keterangan) }}</textarea>
                </div>
                <div class="col-md-2 d-flex align-items-center mt-4">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch"
                           id="is_active" name="is_active" value="1"
                           {{ old('is_active', $guru->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="is_active">Aktif</label>
                  </div>
                </div>
              </div>
            </div>

          </div>{{-- /tab-content --}}

          {{-- Tombol Submit --}}
          <div class="d-flex gap-2 mt-3 mb-4">
            <button type="submit" class="btn btn-warning">
              <i class="bi bi-save me-1"></i> Update Data Guru
            </button>
            <a href="{{ route('guru.show', $guru) }}" class="btn btn-info">
              <i class="bi bi-eye me-1"></i> Lihat Detail
            </a>
            <a href="{{ route('guru.index') }}" class="btn btn-secondary">
              <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
          </div>

        </form>
      </div>
    </div>
  </section>

  <script>
    function togglePass(id) {
      const el = document.getElementById(id);
      const icon = document.getElementById('icon-' + id);
      el.type = el.type === 'password' ? 'text' : 'password';
      icon.className = el.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
    }
    function togglePNSFields() {
      const val = document.getElementById('status_kepegawaian').value;
      const isPns = ['PNS', 'PPPK'].includes(val);
      document.getElementById('field-golongan').style.display  = isPns ? '' : 'none';
      document.getElementById('field-tmt-cpns').style.display  = isPns ? '' : 'none';
      document.getElementById('field-tmt-pns').style.display   = val === 'PNS' ? '' : 'none';
    }
    function toggleSertifikasi() {
      const checked = document.getElementById('is_sertifikasi').checked;
      document.getElementById('field-tahun-sertifikasi').style.display = checked ? '' : 'none';
      document.getElementById('field-nomor-sertifikasi').style.display = checked ? '' : 'none';
    }
    document.addEventListener('DOMContentLoaded', function () {
      togglePNSFields();
      toggleSertifikasi();
    });
  </script>

</main>
@endsection