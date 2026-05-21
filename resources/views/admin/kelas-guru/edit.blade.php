@extends('layouts.admin')
@section('content')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Edit Penugasan Guru</h1>
    <nav><ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('kelas-guru.index') }}">Mapping Guru</a></li>
      <li class="breadcrumb-item active">Edit</li>
    </ol></nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Edit Tugas: {{ $guru->nama_lengkap }}</h5>
            {{-- Asumsikan Anda mempassing ID pivot kelas-guru --}}
            <form action="{{ route('kelas-guru.update', $pivotId) }}" method="POST">
              @csrf @method('PUT')
              <div class="row mb-3">
                <div class="col-md-6">
                  <label class="form-label text-muted">Kelas</label>
                  <input type="text" class="form-control" value="{{ $kelas->nama_kelas }}" disabled>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Ubah Guru</label>
                  <select name="guru_id" class="form-select select2" required>
                    @foreach($guruList as $g)
                      <option value="{{ $g->id }}" {{ $guru->id == $g->id ? 'selected' : '' }}>{{ $g->nama_lengkap }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Jabatan</label>
                  <select name="jabatan" class="form-select" id="jabatanSelect" required onchange="toggleMapel()">
                    <option value="wali_kelas" {{ $pivotData->jabatan == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                    <option value="guru_mapel" {{ $pivotData->jabatan == 'guru_mapel' ? 'selected' : '' }}>Guru Mata Pelajaran</option>
                  </select>
                </div>
                <div class="col-md-6" id="mapelDiv" style="{{ $pivotData->jabatan == 'guru_mapel' ? 'block' : 'none' }}">
                  <label class="form-label fw-semibold">Pelajaran</label>
                  <select name="pelajaran_id" class="form-select select2">
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach($pelajaranList as $p)
                      <option value="{{ $p->id }}" {{ $pivotData->pelajaran_id == $p->id ? 'selected' : '' }}>{{ $p->nama_pelajaran }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="text-end mt-4">
                <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Update Penugasan</button>
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