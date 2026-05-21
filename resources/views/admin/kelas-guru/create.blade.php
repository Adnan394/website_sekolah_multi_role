@extends('layouts.admin')
@section('content')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Tambah Penugasan Guru</h1>
    <nav><ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('kelas-guru.index') }}">Mapping Guru</a></li>
      <li class="breadcrumb-item active">Tambah</li>
    </ol></nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Form Tugaskan Guru</h5>
            <form action="{{ route('kelas-guru.store') }}" method="POST">
              @csrf
              <div class="row mb-3">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Pilih Kelas</label>
                  <select name="kelas_id" class="form-select select2" required>
                    <option value="">-- Kelas --</option>
                    @foreach($kelasList as $k)
                      <option value="{{ $k->id }}">{{ $k->nama_kelas }} ({{ $k->tahun_pelajaran }})</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Pilih Guru</label>
                  <select name="guru_id" class="form-select select2" required>
                    <option value="">-- Guru --</option>
                    @foreach($guruList as $g)
                      <option value="{{ $g->id }}">{{ $g->nama_lengkap }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Jabatan</label>
                  <select name="jabatan" class="form-select" id="jabatanSelect" required onchange="toggleMapel()">
                    <option value="wali_kelas">Wali Kelas</option>
                    <option value="guru_mapel">Guru Mata Pelajaran</option>
                  </select>
                </div>
                <div class="col-md-6" id="mapelDiv" style="display:none;">
                  <label class="form-label fw-semibold">Pelajaran (Opsional)</label>
                  <select name="pelajaran_id" class="form-select select2">
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach($pelajaranList as $p)
                      <option value="{{ $p->id }}">{{ $p->nama_pelajaran }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="text-end mt-4">
                <a href="{{ route('kelas-guru.index') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Penugasan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<script>
  function toggleMapel() {
    var val = document.getElementById('jabatanSelect').value;
    document.getElementById('mapelDiv').style.display = (val === 'guru_mapel') ? 'block' : 'none';
  }
</script>
@endsection