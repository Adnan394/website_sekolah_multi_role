@extends('layouts.admin')

@section('content')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Tambah Guru</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('guru.index') }}">Data Guru</a></li>
        <li class="breadcrumb-item active">Tambah Guru</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row justify-content-center">
      <div class="col-lg-10">

        {{-- Stepper UI --}}
        <div class="d-flex align-items-center mb-4 gap-0">
          <div class="d-flex align-items-center" id="step-badge-1">
            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                 style="width:36px;height:36px;background:#8B0000" id="step-circle-1">1</div>
            <span class="ms-2 fw-semibold" id="step-label-1">Data Akun Login</span>
          </div>
          <div class="flex-grow-1 border-top mx-3" style="border-color:#ccc!important"></div>
          <div class="d-flex align-items-center" id="step-badge-2">
            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                 style="width:36px;height:36px;background:#ccc" id="step-circle-2">2</div>
            <span class="ms-2 text-muted" id="step-label-2">Data Lengkap Guru</span>
          </div>
        </div>

        @if($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('guru.store') }}" method="POST" enctype="multipart/form-data" id="formGuru">
          @csrf

          {{-- ══════════════════════════════════════════
               STEP 1 — Akun Login
               ══════════════════════════════════════════ --}}
          <div id="step-1">
            <div class="card">
              <div class="card-body pt-4">
                <h5 class="card-title"><i class="bi bi-person-lock me-2"></i>Step 1 — Data Akun Login</h5>
                <p class="text-muted small">Buat akun untuk guru masuk ke sistem.</p>
                <div class="row g-3">

                  <div class="col-md-6">
                    <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                           value="{{ old('username') }}" placeholder="contoh: budi.santoso">
                    @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>

                  <div class="col-md-6">
                    <label class="form-label fw-semibold">Email Akun <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="email@sekolah.sch.id">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>

                  <div class="col-md-6">
                    <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input type="password" name="password" id="password"
                             class="form-control @error('password') is-invalid @enderror"
                             placeholder="Minimal 8 karakter">
                      <button class="btn btn-outline-secondary" type="button" onclick="togglePass('password')">
                        <i class="bi bi-eye" id="icon-password"></i>
                      </button>
                      @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label fw-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input type="password" name="password_confirmation" id="password_confirmation"
                             class="form-control" placeholder="Ulangi password">
                      <button class="btn btn-outline-secondary" type="button" onclick="togglePass('password_confirmation')">
                        <i class="bi bi-eye" id="icon-password_confirmation"></i>
                      </button>
                    </div>
                  </div>

                  <div class="col-12">
                    <label class="form-label fw-semibold">Deskripsi Akun</label>
                    <input type="text" name="deskripsi_akun" class="form-control"
                           value="{{ old('deskripsi_akun') }}" placeholder="opsional, misal: Guru Kelas 3A">
                  </div>

                </div>

                <div class="mt-4 d-flex gap-2">
                  <button type="button" class="btn btn-danger" onclick="goStep(2)">
                    Lanjut ke Data Guru <i class="bi bi-arrow-right ms-1"></i>
                  </button>
                  <a href="{{ route('guru.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                  </a>
                </div>
              </div>
            </div>
          </div>

          {{-- ══════════════════════════════════════════
               STEP 2 — Data Lengkap Guru
               ══════════════════════════════════════════ --}}
          <div id="step-2" style="display:none">

            {{-- Identitas Pribadi --}}
            <div class="card">
              <div class="card-body pt-4">
                <h5 class="card-title"><i class="bi bi-person-vcard me-2"></i>Identitas Pribadi</h5>
                <div class="row g-3">

                  <div class="col-md-2">
                    <label class="form-label fw-semibold">Gelar Depan</label>
                    <input type="text" name="gelar_depan" class="form-control"
                           value="{{ old('gelar_depan') }}" placeholder="Dr.">
                  </div>
                  <div class="col-md-5">
                    <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
                           value="{{ old('nama_lengkap') }}" placeholder="Nama tanpa gelar">
                    @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-md-3">
                    <label class="form-label fw-semibold">Gelar Belakang</label>
                    <input type="text" name="gelar_belakang" class="form-control"
                           value="{{ old('gelar_belakang') }}" placeholder="S.Pd., M.Pd.">
                  </div>
                  <div class="col-md-2">
                    <label class="form-label fw-semibold">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select">
                      <option value="">--</option>
                      <option value="L" {{ old('jenis_kelamin')==='L'?'selected':'' }}>Laki-laki</option>
                      <option value="P" {{ old('jenis_kelamin')==='P'?'selected':'' }}>Perempuan</option>
                    </select>
                  </div>

                  <div class="col-md-4">
                    <label class="form-label fw-semibold">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control"
                           value="{{ old('tempat_lahir') }}" placeholder="Kota kelahiran">
                  </div>
                  <div class="col-md-3">
                    <label class="form-label fw-semibold">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control"
                           value="{{ old('tanggal_lahir') }}">
                  </div>
                  <div class="col-md-3">
                    <label class="form-label fw-semibold">Agama</label>
                    <select name="agama" class="form-select">
                      <option value="">-- Pilih --</option>
                      @foreach($agamaList as $a)
                        <option value="{{ $a }}" {{ old('agama')===$a?'selected':'' }}>{{ $a }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-2">
                    <label class="form-label fw-semibold">Status Nikah</label>
                    <select name="status_pernikahan" class="form-select">
                      <option value="">--</option>
                      @foreach(['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'] as $sn)
                        <option value="{{ $sn }}" {{ old('status_pernikahan')===$sn?'selected':'' }}>{{ $sn }}</option>
                      @endforeach
                    </select>
                  </div>

                  {{-- Foto --}}
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">Foto</label>
                    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror"
                           accept="image/jpg,image/jpeg,image/png">
                    <div class="form-text">JPG/PNG maks 2MB</div>
                    @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">No. HP</label>
                    <input type="text" name="no_hp" class="form-control"
                           value="{{ old('no_hp') }}" placeholder="08xx-xxxx-xxxx">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">Email Pribadi</label>
                    <input type="email" name="email_pribadi" class="form-control"
                           value="{{ old('email_pribadi') }}" placeholder="email@pribadi.com">
                  </div>

                </div>
              </div>
            </div>

            {{-- Alamat --}}
            <div class="card">
              <div class="card-body pt-4">
                <h5 class="card-title"><i class="bi bi-geo-alt me-2"></i>Alamat</h5>
                <div class="row g-3">
                  <div class="col-12">
                    <label class="form-label fw-semibold">Jalan / Perumahan</label>
                    <textarea name="alamat" class="form-control" rows="2"
                              placeholder="Nama jalan, nomor rumah, RT/RW">{{ old('alamat') }}</textarea>
                  </div>
                  <div class="col-md-2">
                    <label class="form-label fw-semibold">RT</label>
                    <input type="text" name="rt" class="form-control" value="{{ old('rt') }}" placeholder="001">
                  </div>
                  <div class="col-md-2">
                    <label class="form-label fw-semibold">RW</label>
                    <input type="text" name="rw" class="form-control" value="{{ old('rw') }}" placeholder="002">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">Kelurahan / Desa</label>
                    <input type="text" name="kelurahan" class="form-control" value="{{ old('kelurahan') }}">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">Kecamatan</label>
                    <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan') }}">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">Kota / Kabupaten</label>
                    <input type="text" name="kota" class="form-control" value="{{ old('kota') }}">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">Provinsi</label>
                    <input type="text" name="provinsi" class="form-control" value="{{ old('provinsi') }}">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">Kode Pos</label>
                    <input type="text" name="kode_pos" class="form-control" value="{{ old('kode_pos') }}"
                           placeholder="12345">
                  </div>
                </div>
              </div>
            </div>

            {{-- Pendidikan --}}
            <div class="card">
              <div class="card-body pt-4">
                <h5 class="card-title"><i class="bi bi-mortarboard me-2"></i>Pendidikan</h5>
                <div class="row g-3">
                  <div class="col-md-3">
                    <label class="form-label fw-semibold">Pendidikan Terakhir</label>
                    <select name="pendidikan_terakhir" class="form-select">
                      <option value="">-- Pilih --</option>
                      @foreach($pendidikanList as $p)
                        <option value="{{ $p }}" {{ old('pendidikan_terakhir')===$p?'selected':'' }}>{{ $p }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">Jurusan / Prodi</label>
                    <input type="text" name="jurusan" class="form-control"
                           value="{{ old('jurusan') }}" placeholder="Pendidikan Guru SD">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">Universitas / Institusi</label>
                    <input type="text" name="universitas" class="form-control"
                           value="{{ old('universitas') }}">
                  </div>
                  <div class="col-md-2">
                    <label class="form-label fw-semibold">Tahun Lulus</label>
                    <input type="number" name="tahun_lulus" class="form-control"
                           value="{{ old('tahun_lulus') }}" placeholder="2010" min="1970" max="{{ date('Y') }}">
                  </div>
                </div>
              </div>
            </div>

            {{-- Kepegawaian --}}
            <div class="card">
              <div class="card-body pt-4">
                <h5 class="card-title"><i class="bi bi-briefcase me-2"></i>Data Kepegawaian</h5>
                <div class="row g-3">

                  <div class="col-md-3">
                    <label class="form-label fw-semibold">NIP</label>
                    <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror"
                           value="{{ old('nip') }}" placeholder="18 digit NIP">
                    @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-md-3">
                    <label class="form-label fw-semibold">NUPTK</label>
                    <input type="text" name="nuptk" class="form-control @error('nuptk') is-invalid @enderror"
                           value="{{ old('nuptk') }}" placeholder="16 digit NUPTK">
                    @error('nuptk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-md-3">
                    <label class="form-label fw-semibold">Jabatan <span class="text-danger">*</span></label>
                    <select name="jabatan" class="form-select @error('jabatan') is-invalid @enderror">
                      <option value="">-- Pilih --</option>
                      @foreach($jabatanList as $j)
                        <option value="{{ $j }}" {{ old('jabatan')===$j?'selected':'' }}>{{ $j }}</option>
                      @endforeach
                    </select>
                    @error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-md-3">
                    <label class="form-label fw-semibold">Status Kepegawaian <span class="text-danger">*</span></label>
                    <select name="status_kepegawaian" id="status_kepegawaian"
                            class="form-select @error('status_kepegawaian') is-invalid @enderror"
                            onchange="togglePNSFields()">
                      @foreach($statusKepegawaianList as $sk)
                        <option value="{{ $sk }}" {{ old('status_kepegawaian')===$sk?'selected':'' }}>{{ $sk }}</option>
                      @endforeach
                    </select>
                    @error('status_kepegawaian')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>

                  {{-- Field khusus PNS --}}
                  <div class="col-md-3" id="field-golongan" style="display:none">
                    <label class="form-label fw-semibold">Golongan</label>
                    <input type="text" name="golongan" class="form-control"
                           value="{{ old('golongan') }}" placeholder="III/a">
                  </div>
                  <div class="col-md-3" id="field-tmt-cpns" style="display:none">
                    <label class="form-label fw-semibold">TMT CPNS</label>
                    <input type="date" name="tmt_cpns" class="form-control" value="{{ old('tmt_cpns') }}">
                  </div>
                  <div class="col-md-3" id="field-tmt-pns" style="display:none">
                    <label class="form-label fw-semibold">TMT PNS</label>
                    <input type="date" name="tmt_pns" class="form-control" value="{{ old('tmt_pns') }}">
                  </div>

                  <div class="col-md-3">
                    <label class="form-label fw-semibold">Tanggal Bergabung</label>
                    <input type="date" name="tanggal_bergabung" class="form-control"
                           value="{{ old('tanggal_bergabung') }}">
                  </div>
                  <div class="col-md-2">
                    <label class="form-label fw-semibold">Masa Kerja (Tahun)</label>
                    <input type="number" name="masa_kerja_tahun" class="form-control"
                           value="{{ old('masa_kerja_tahun', 0) }}" min="0" max="50">
                  </div>
                  <div class="col-md-2">
                    <label class="form-label fw-semibold">Masa Kerja (Bulan)</label>
                    <input type="number" name="masa_kerja_bulan" class="form-control"
                           value="{{ old('masa_kerja_bulan', 0) }}" min="0" max="11">
                  </div>

                </div>
              </div>
            </div>

            {{-- Sertifikasi --}}
            <div class="card">
              <div class="card-body pt-4">
                <h5 class="card-title"><i class="bi bi-patch-check me-2"></i>Sertifikasi</h5>
                <div class="row g-3 align-items-end">
                  <div class="col-md-3 d-flex align-items-center mt-4">
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" role="switch"
                             id="is_sertifikasi" name="is_sertifikasi" value="1"
                             onchange="toggleSertifikasi()"
                             {{ old('is_sertifikasi') ? 'checked' : '' }}>
                      <label class="form-check-label fw-semibold" for="is_sertifikasi">
                        Sudah Sertifikasi
                      </label>
                    </div>
                  </div>
                  <div class="col-md-3" id="field-tahun-sertifikasi" style="display:none">
                    <label class="form-label fw-semibold">Tahun Sertifikasi</label>
                    <input type="number" name="tahun_sertifikasi" class="form-control"
                           value="{{ old('tahun_sertifikasi') }}" placeholder="2018" min="2000">
                  </div>
                  <div class="col-md-4" id="field-nomor-sertifikasi" style="display:none">
                    <label class="form-label fw-semibold">Nomor Sertifikasi</label>
                    <input type="text" name="nomor_sertifikasi" class="form-control"
                           value="{{ old('nomor_sertifikasi') }}" placeholder="No. sertifikat">
                  </div>
                </div>
              </div>
            </div>

            {{-- Keterangan & Status --}}
            <div class="card">
              <div class="card-body pt-4">
                <h5 class="card-title"><i class="bi bi-gear me-2"></i>Pengaturan</h5>
                <div class="row g-3">
                  <div class="col-md-10">
                    <label class="form-label fw-semibold">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="2"
                              placeholder="Catatan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                  </div>
                  <div class="col-md-2 d-flex align-items-center mt-4">
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" role="switch"
                             id="is_active" name="is_active" value="1"
                             {{ old('is_active', true) ? 'checked' : '' }}>
                      <label class="form-check-label fw-semibold" for="is_active">Aktif</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {{-- Tombol --}}
            <div class="d-flex gap-2 mb-4">
              <button type="button" class="btn btn-secondary" onclick="goStep(1)">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Akun
              </button>
              <button type="submit" class="btn btn-danger">
                <i class="bi bi-save me-1"></i> Simpan Data Guru
              </button>
            </div>

          </div>{{-- /step-2 --}}
        </form>
      </div>
    </div>
  </section>

  {{-- Script diletakkan di sini agar pasti termuat
       tanpa bergantung pada @stack('scripts') di layout --}}
  <script>
    function goStep(n) {
      document.getElementById('step-1').style.display = n === 1 ? 'block' : 'none';
      document.getElementById('step-2').style.display = n === 2 ? 'block' : 'none';

      const c1 = document.getElementById('step-circle-1');
      const c2 = document.getElementById('step-circle-2');
      const l2 = document.getElementById('step-label-2');

      if (n === 2) {
        c1.style.background = '#198754';
        c1.innerHTML = '<i class="bi bi-check-lg"></i>';
        c2.style.background = '#8B0000';
        l2.classList.remove('text-muted');
        window.scrollTo(0, 0);
      } else {
        c1.style.background = '#8B0000';
        c1.innerHTML = '1';
        c2.style.background = '#ccc';
        l2.classList.add('text-muted');
      }
    }

    function togglePass(id) {
      const el   = document.getElementById(id);
      const icon = document.getElementById('icon-' + id);
      if (el.type === 'password') {
        el.type = 'text';
        icon.className = 'bi bi-eye-slash';
      } else {
        el.type = 'password';
        icon.className = 'bi bi-eye';
      }
    }

    function togglePNSFields() {
      const val  = document.getElementById('status_kepegawaian').value;
      const show = ['PNS', 'PPPK'].includes(val);
      document.getElementById('field-golongan').style.display  = show ? '' : 'none';
      document.getElementById('field-tmt-cpns').style.display  = show ? '' : 'none';
      document.getElementById('field-tmt-pns').style.display   = val === 'PNS' ? '' : 'none';
    }

    function toggleSertifikasi() {
      const checked = document.getElementById('is_sertifikasi').checked;
      document.getElementById('field-tahun-sertifikasi').style.display = checked ? '' : 'none';
      document.getElementById('field-nomor-sertifikasi').style.display = checked ? '' : 'none';
    }

    // Jalankan setelah DOM siap
    document.addEventListener('DOMContentLoaded', function () {
      togglePNSFields();
      toggleSertifikasi();

      // Jika ada error dari server, langsung loncat ke step yang bermasalah
      @if($errors->hasAny(['nama_lengkap','jabatan','status_kepegawaian','nip','nuptk','foto','tanggal_lahir']))
        goStep(2);
      @elseif($errors->any())
        goStep(1);
      @endif
    });
  </script>

</main>
@endsection