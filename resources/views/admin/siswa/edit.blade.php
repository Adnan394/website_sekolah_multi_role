@extends('layouts.admin')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Siswa & Akun</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}">Data Siswa</a></li>
                <li class="breadcrumb-item active">Edit Siswa</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <form action="{{ route('siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Kolom Kiri: Informasi Akun -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body pt-3">
                            <h5 class="card-title"><i class="bi bi-shield-lock me-2"></i>Informasi Akun</h5>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $siswa->user->username ?? '') }}" required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $siswa->user->email ?? '') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password Baru</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kosongkan jika tidak diubah">
                                <small class="text-muted" style="font-size: 0.8rem;">Minimal 8 karakter jika ingin mengubah password.</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Data Pribadi Siswa -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body pt-3">
                            <h5 class="card-title"><i class="bi bi-person me-2"></i>Data Pribadi Siswa</h5>
                            
                            <!-- Foto Profil -->
                            <div class="mb-4 p-3 bg-light rounded border d-flex align-items-center gap-3">
                                <img src="{{ $siswa->foto_url }}" alt="Foto Siswa" width="70" height="70" class="rounded-circle object-fit-cover border shadow-sm">
                                <div class="flex-grow-1">
                                    <label class="form-label fw-semibold mb-1">Ganti Foto Profil</label>
                                    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                                    <small class="text-muted" style="font-size: 0.8rem;">Format: JPG, PNG, JPEG (Maksimal 2 MB)</small>
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if($siswa->foto)
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" name="hapus_foto" value="1" id="hapusFoto">
                                        <label class="form-check-label text-danger small" for="hapusFoto">
                                            Hapus foto profil saat ini (gunakan avatar default)
                                        </label>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}" required>
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">NISN</label>
                                    <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror" value="{{ old('nisn', $siswa->nisn) }}">
                                    @error('nisn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">NIS</label>
                                    <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis', $siswa->nis) }}">
                                    @error('nis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-select">
                                        <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Status Siswa</label>
                                    <select name="is_active" class="form-select">
                                        <option value="1" {{ old('is_active', $siswa->is_active) ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ old('is_active', $siswa->is_active) === false || old('is_active', $siswa->is_active) === 0 || old('is_active', $siswa->is_active) === '0' ? 'selected' : '' }}>Non-Aktif</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('Y-m-d') : '') }}">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Agama</label>
                                    <select name="agama" class="form-select">
                                        <option value="">-- Pilih Agama --</option>
                                        @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agm)
                                            <option value="{{ $agm }}" {{ old('agama', $siswa->agama) == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">No. HP / WhatsApp</label>
                                    <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $siswa->no_hp) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Tahun Masuk</label>
                                    <input type="number" name="tahun_masuk" class="form-control" placeholder="Contoh: 2024" value="{{ old('tahun_masuk', $siswa->tahun_masuk) }}">
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $siswa->alamat) }}</textarea>
                                </div>

                                <div class="col-12 mt-4 pt-2 border-top d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                                    </button>
                                    <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</main>
@endsection
