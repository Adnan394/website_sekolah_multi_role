@extends('layouts.admin')
@section('content')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Setting Jadwal Tugas</h1>
    <nav><ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('materi-pembelajaran.index') }}">Materi</a></li>
      <li class="breadcrumb-item active">Jadwal Tugas</li>
    </ol></nav>
  </div>
  <section class="section">
    <div class="row"><div class="col-12"><div class="card"><div class="card-body">
      <h5 class="card-title">Daftar Jadwal Tugas</h5>

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
          <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <a href="{{ route('jadwal-tugas.create') }}" class="btn btn-danger">
          <i class="bi bi-plus-circle me-1"></i>Tambah Tugas
        </a>
        <a href="{{ route('materi-pembelajaran.index') }}" class="btn btn-outline-secondary">
          <i class="bi bi-book me-1"></i>Materi Pembelajaran
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
          <label class="form-label mb-1 small fw-semibold">Pelajaran</label>
          <select name="pelajaran_id" class="form-select form-select-sm" style="min-width:150px">
            <option value="">Semua</option>
            @foreach($pelajaranList as $p)
              <option value="{{ $p->id }}" {{ request('pelajaran_id')==$p->id?'selected':'' }}>{{ $p->nama_pelajaran }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="form-label mb-1 small fw-semibold">Status</label>
          <select name="is_published" class="form-select form-select-sm" style="min-width:120px">
            <option value="">Semua</option>
            <option value="1" {{ request('is_published')==='1'?'selected':'' }}>Published</option>
            <option value="0" {{ request('is_published')==='0'?'selected':'' }}>Draft</option>
          </select>
        </div>
        <div>
          <label class="form-label mb-1 small fw-semibold">Cari</label>
          <input type="text" name="search" class="form-control form-control-sm"
                 value="{{ request('search') }}" placeholder="Judul tugas..." style="min-width:160px">
        </div>
        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search"></i></button>
        <a href="{{ route('jadwal-tugas.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-counterclockwise"></i></a>
      </form>

      <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th>#</th><th>Judul Tugas</th><th>Kelas</th><th>Pelajaran</th>
              <th>Mulai</th><th>Tenggat</th><th>Status</th><th width="130">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($tugas as $idx => $item)
              <tr class="{{ $item->is_expired && $item->is_published ? 'table-secondary' : '' }}">
                <td>{{ $tugas->firstItem() + $idx }}</td>
                <td>
                  <strong>{{ $item->judul_tugas }}</strong>
                  <br><small class="text-muted">Nilai maks: {{ $item->nilai_maksimal }}</small>
                </td>
                <td><span class="badge bg-primary">{{ $item->kelas->nama_kelas ?? '-' }}</span></td>
                <td><small>{{ $item->pelajaran->nama_pelajaran ?? '-' }}</small></td>
                <td><small>{{ $item->tanggal_mulai->format('d M Y H:i') }}</small></td>
                <td>
                  <small class="{{ $item->is_expired ? 'text-danger fw-bold' : '' }}">
                    {{ $item->tenggat_waktu->format('d M Y H:i') }}
                  </small>
                  @if($item->is_expired && $item->is_published)
                    <br><span class="badge bg-danger">Berakhir</span>
                  @endif
                </td>
                <td class="text-center">
                  @php
                    $label = $item->status_label;
                    $color = match($label) { 'Aktif' => 'success', 'Draft' => 'secondary', 'Berakhir' => 'danger', default => 'warning' };
                  @endphp
                  <span class="badge bg-{{ $color }}">{{ $label }}</span>
                </td>
                <td>
                  <div class="d-flex gap-1">
                    <a href="{{ route('guru.tugas.index') }}" class="btn btn-info btn-sm"><i class="bi bi-list-task"></i></a>
                    <a href="{{ route('jadwal-tugas.show', $item) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('jadwal-tugas.edit', $item) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('jadwal-tugas.toggle-publish', $item) }}" method="POST">
                      @csrf @method('PATCH')
                      <button class="btn btn-sm {{ $item->is_published ? 'btn-outline-secondary' : 'btn-outline-success' }}">
                        <i class="bi bi-{{ $item->is_published ? 'eye-slash' : 'send' }}"></i>
                      </button>
                    </form>
                    <form action="{{ route('jadwal-tugas.destroy', $item) }}" method="POST"
                          onsubmit="return confirm('Hapus tugas ini?')">
                      @csrf @method('DELETE')
                      <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr><td colspan="8" class="text-center text-muted py-4">
                <i class="bi bi-inbox fs-4 d-block mb-2"></i>Belum ada jadwal tugas.
              </td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="d-flex justify-content-between mt-2">
        <small class="text-muted">{{ $tugas->firstItem() ?? 0 }}–{{ $tugas->lastItem() ?? 0 }} dari {{ $tugas->total() }}</small>
        {{ $tugas->links() }}
      </div>
    </div></div></div></div>
  </section>
</main>
@endsection