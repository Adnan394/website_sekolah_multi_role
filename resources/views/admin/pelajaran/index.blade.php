@extends('layouts.admin')
@section('content')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Data Mata Pelajaran</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Mata Pelajaran</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Daftar Pelajaran</h5>

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
          <a href="{{ route('pelajaran.create') }}" class="btn btn-danger">
            <i class="bi bi-plus-circle me-1"></i> Tambah Pelajaran
          </a>

          <div class="btn-group ms-2">
            <a href="{{ route('pelajaran.index', ['tampilkan' => 'aktif']) }}"
               class="btn btn-sm {{ $tampilkan === 'aktif' ? 'btn-primary' : 'btn-outline-primary' }}">Aktif</a>
            <a href="{{ route('pelajaran.index', ['tampilkan' => 'terhapus']) }}"
               class="btn btn-sm {{ $tampilkan === 'terhapus' ? 'btn-danger' : 'btn-outline-danger' }}">
               Terhapus @if($jumlahTerhapus > 0) <span class="badge bg-white text-danger">{{ $jumlahTerhapus }}</span> @endif
            </a>
            <a href="{{ route('pelajaran.index', ['tampilkan' => 'semua']) }}"
               class="btn btn-sm {{ $tampilkan === 'semua' ? 'btn-secondary' : 'btn-outline-secondary' }}">Semua</a>
          </div>
        </div>

        <form method="GET" action="{{ route('pelajaran.index') }}" class="d-flex flex-wrap gap-2 align-items-end mb-3">
          <input type="hidden" name="tampilkan" value="{{ $tampilkan }}">
          <div>
            <label class="form-label small fw-semibold">Kategori</label>
            <select name="kategori" class="form-select form-select-sm">
              <option value="">Semua Kategori</option>
              @foreach($kategoriList as $kat)
                <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="form-label small fw-semibold">Cari</label>
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Kode / Nama..." value="{{ request('search') }}">
          </div>
          <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search"></i> Filter</button>
          <a href="{{ route('pelajaran.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-counterclockwise"></i> Reset</a>
        </form>

        <div class="table-responsive">
          <table class="table table-hover table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Mata Pelajaran</th>
                <th>Kategori</th>
                <th>Tingkat</th>
                <th>Jam/Minggu</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($pelajaran as $index => $item)
                <tr class="{{ $item->trashed() ? 'table-danger' : '' }}">
                  <td>{{ $pelajaran->firstItem() + $index }}</td>
                  <td>
                    <strong>{{ $item->nama_pelajaran }}</strong><br>
                    <small class="text-muted">{{ $item->kode_pelajaran }}</small>
                  </td>
                  <td><span class="badge bg-info text-dark">{{ $item->kategori }}</span></td>
                  <td>Kelas {{ $item->tingkat_min }} - {{ $item->tingkat_max }}</td>
                  <td class="text-center">{{ $item->jam_per_minggu }} Jam</td>
                  <td>
                    @if($item->trashed()) <span class="badge bg-danger">Terhapus</span>
                    @elseif($item->is_active) <span class="badge bg-success">Aktif</span>
                    @else <span class="badge bg-secondary">Nonaktif</span> @endif
                  </td>
                  <td>
                    @if($item->trashed())
                      <form action="{{ route('pelajaran.restore', $item->id) }}" method="POST" class="d-inline">
                        @csrf @method('PATCH')
                        <button class="btn btn-success btn-sm" onclick="return confirm('Restore data?')"><i class="bi bi-arrow-counterclockwise"></i></button>
                      </form>
                      <form action="{{ route('pelajaran.force-delete', $item->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus Permanen?')"><i class="bi bi-trash-fill"></i></button>
                      </form>
                    @else
                      <a href="{{ route('pelajaran.edit', $item) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                      <form action="{{ route('pelajaran.destroy', $item) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus ke Trash?')"><i class="bi bi-trash"></i></button>
                      </form>
                    @endif
                  </td>
                </tr>
              @empty
                <tr><td colspan="7" class="text-center py-4">Data tidak ditemukan.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
        {{ $pelajaran->links() }}
      </div>
    </div>
  </section>
</main>
@endsection