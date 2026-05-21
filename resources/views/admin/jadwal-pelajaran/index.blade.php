@extends('layouts.admin')
@section('content')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Setting Jadwal Pelajaran</h1>
    <nav><ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active">Jadwal Pelajaran</li>
    </ol></nav>
  </div>
  <section class="section">
    <div class="row"><div class="col-12"><div class="card"><div class="card-body">
      <h5 class="card-title">Jadwal Pelajaran</h5>

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
          <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <a href="{{ route('jadwal-pelajaran.create') }}" class="btn btn-danger">
          <i class="bi bi-plus-circle me-1"></i>Tambah Jadwal
        </a>
        <a href="{{ route('jadwal-pelajaran.grid') }}" class="btn btn-outline-primary">
          <i class="bi bi-grid-3x3-gap me-1"></i>Tampilan Grid
        </a>
      </div>

      {{-- Filter --}}
      <form method="GET" class="d-flex flex-wrap gap-2 align-items-end mb-3">
        <div>
          <label class="form-label mb-1 small fw-semibold">Kelas</label>
          <select name="kelas_id" class="form-select form-select-sm" style="min-width:120px">
            <option value="">Semua</option>
            @foreach($kelasList as $k)
              <option value="{{ $k->id }}" {{ request('kelas_id')==$k->id?'selected':'' }}>{{ $k->nama_kelas }}</option>
            @endforeach
          </select>
        </div>
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
          <label class="form-label mb-1 small fw-semibold">Hari</label>
          <select name="hari" class="form-select form-select-sm" style="min-width:100px">
            <option value="">Semua</option>
            @foreach(\App\Models\JadwalPelajaran::listHari() as $h)
              <option value="{{ $h }}" {{ request('hari')===$h?'selected':'' }}>{{ $h }}</option>
            @endforeach
          </select>
        </div>
        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search"></i></button>
        <a href="{{ route('jadwal-pelajaran.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-counterclockwise"></i></a>
      </form>

      <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th>#</th><th>Kelas</th><th>Hari</th><th>Jam ke-</th>
              <th>Waktu</th><th>Pelajaran</th><th>Guru</th><th>Ruangan</th><th width="100">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($jadwal as $idx => $item)
              <tr>
                <td>{{ $jadwal->firstItem() + $idx }}</td>
                <td><span class="badge bg-primary">{{ $item->kelas->nama_kelas ?? '-' }}</span></td>
                <td>
                  @php
                    $hariColor = ['Senin'=>'primary','Selasa'=>'success','Rabu'=>'info','Kamis'=>'warning','Jumat'=>'danger','Sabtu'=>'secondary'];
                  @endphp
                  <span class="badge bg-{{ $hariColor[$item->hari] ?? 'secondary' }}">{{ $item->hari }}</span>
                </td>
                <td class="text-center fw-bold">{{ $item->jam_ke }}</td>
                <td><small>{{ $item->durasi }}</small></td>
                <td><small>{{ $item->pelajaran->nama_pelajaran ?? '-' }}</small></td>
                <td><small>{{ $item->guru->nama_lengkap ?? '-' }}</small></td>
                <td><small>{{ $item->ruangan ?? '-' }}</small></td>
                <td>
                  <div class="d-flex gap-1">
                    <a href="{{ route('jadwal-pelajaran.edit', $item) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('jadwal-pelajaran.destroy', $item) }}" method="POST"
                          onsubmit="return confirm('Hapus jadwal ini?')">
                      @csrf @method('DELETE')
                      <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr><td colspan="9" class="text-center text-muted py-4">
                <i class="bi bi-inbox fs-4 d-block mb-2"></i>Belum ada jadwal pelajaran.
              </td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="d-flex justify-content-between mt-2">
        <small class="text-muted">{{ $jadwal->firstItem() ?? 0 }}–{{ $jadwal->lastItem() ?? 0 }} dari {{ $jadwal->total() }}</small>
        {{ $jadwal->links() }}
      </div>
    </div></div></div></div>

    {{-- Grid View per Kelas --}}
    <div class="row mt-2"><div class="col-12"><div class="card"><div class="card-body">
      <h5 class="card-title"><i class="bi bi-grid-3x3-gap me-2"></i>Grid Jadwal per Kelas</h5>
      <p class="text-muted small">Gunakan tampilan grid untuk melihat jadwal lengkap per kelas dalam format tabel mingguan.</p>
      <a href="{{ route('jadwal-pelajaran.grid') }}" class="btn btn-outline-primary">
        <i class="bi bi-grid me-1"></i>Buka Tampilan Grid Jadwal
      </a>
    </div></div></div></div>
  </section>
</main>
@endsection