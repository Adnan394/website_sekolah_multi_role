@extends('layouts.admin')
@section('content')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Mapping Siswa - Kelas</h1>
    <nav><ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active">Mapping Siswa Kelas</li>
    </ol></nav>
  </div>

  <section class="section">
    <div class="row"><div class="col-lg-12"><div class="card"><div class="card-body">
      <h5 class="card-title">Daftar Kelas</h5>

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
          <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      {{-- Form Filter --}}
      <form method="GET" class="d-flex flex-wrap gap-2 align-items-end mb-3">
        <div>
          <label class="form-label mb-1 small fw-semibold">Tahun Pelajaran</label>
          <select name="tahun_pelajaran" class="form-select form-select-sm" style="min-width:130px">
            <option value="">Semua</option>
            @foreach($tahunList as $t)
              <option value="{{ $t }}" {{ request('tahun_pelajaran')===$t?'selected':'' }}>{{ $t }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="form-label mb-1 small fw-semibold">Tingkat</label>
          <select name="tingkat" class="form-select form-select-sm" style="min-width:100px">
            <option value="">Semua</option>
            @foreach(range(1,6) as $t)
              <option value="{{ $t }}" {{ request('tingkat')==$t?'selected':'' }}>Kelas {{ $t }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="form-label mb-1 small fw-semibold">Semester</label>
          <select name="semester" class="form-select form-select-sm" style="min-width:110px">
            <option value="">Semua</option>
            <option value="Ganjil" {{ request('semester')==='Ganjil'?'selected':'' }}>Ganjil</option>
            <option value="Genap"  {{ request('semester')==='Genap'?'selected':'' }}>Genap</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search"></i> Filter</button>
        <a href="{{ route('kelas-siswa.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-counterclockwise"></i></a>
      </form>

      {{-- Tabel Kelas --}}
      <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th width="5%">#</th>
              <th>Kelas</th>
              <th>Tahun / Semester</th>
              <th>Kapasitas</th>
              <th>Jumlah Siswa</th>
              <th width="15%">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($kelas as $i => $item)
              <tr>
                <td>{{ $kelas->firstItem() + $i }}</td>
                <td>
                  <strong>{{ $item->nama_kelas }}</strong><br>
                  <span class="badge bg-primary">Kelas {{ $item->tingkat }}</span>
                </td>
                <td>
                  {{ $item->tahun_pelajaran }}<br>
                  <small class="text-muted">{{ $item->semester }}</small>
                </td>
                <td>{{ $item->kapasitas }}</td>
                <td>
                  <span class="badge bg-info text-dark">{{ $item->siswa->count() ?? 0 }} Siswa</span>
                </td>
                <td>
                  <a href="{{ route('kelas-siswa.detail', $item) }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-people me-1"></i>Kelola Siswa
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center text-muted py-4">Belum ada data kelas.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <div class="d-flex justify-content-between align-items-center mt-2">
        <small class="text-muted">{{ $kelas->firstItem() ?? 0 }}–{{ $kelas->lastItem() ?? 0 }} dari {{ $kelas->total() }}</small>
        {{ $kelas->links() }}
      </div>

    </div></div></div></div>
  </section>
</main>
@endsection