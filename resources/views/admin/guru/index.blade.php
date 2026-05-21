@extends('layouts.admin')

@section('content')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Data Guru</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Data Guru</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Daftar Guru</h5>

            @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif
            @if(session('error'))
              <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle me-1"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif

            {{-- Toolbar --}}
            <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
              <a href="{{ route('guru.create') }}" class="btn btn-danger">
                <i class="bi bi-plus-circle me-1"></i> Tambah Guru
              </a>
              {{-- Tab: Aktif / Terhapus --}}
              <div class="btn-group ms-2">
                <a href="{{ route('guru.index', array_merge(request()->except('tampilkan','page'), ['tampilkan'=>'aktif'])) }}"
                   class="btn btn-sm {{ $tampilkan==='aktif' ? 'btn-primary' : 'btn-outline-primary' }}">
                  <i class="bi bi-list-check me-1"></i>Aktif
                </a>
                <a href="{{ route('guru.index', array_merge(request()->except('tampilkan','page'), ['tampilkan'=>'terhapus'])) }}"
                   class="btn btn-sm {{ $tampilkan==='terhapus' ? 'btn-danger' : 'btn-outline-danger' }}">
                  <i class="bi bi-trash me-1"></i>Terhapus
                  @if($jumlahTerhapus > 0)
                    <span class="badge bg-white text-danger ms-1">{{ $jumlahTerhapus }}</span>
                  @endif
                </a>
              </div>
            </div>

            @if($tampilkan === 'terhapus')
              <div class="alert alert-warning py-2">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                Menampilkan data yang telah dihapus.
              </div>
            @endif

            {{-- Filter --}}
            <form method="GET" action="{{ route('guru.index') }}"
                  class="d-flex flex-wrap gap-2 align-items-end mb-3">
              <input type="hidden" name="tampilkan" value="{{ $tampilkan }}">

              <div>
                <label class="form-label mb-1 small fw-semibold">Jabatan</label>
                <select name="jabatan" class="form-select form-select-sm" style="min-width:160px">
                  <option value="">Semua Jabatan</option>
                  @foreach(\App\Models\Guru::listJabatan() as $j)
                    <option value="{{ $j }}" {{ request('jabatan')===$j ? 'selected':'' }}>{{ $j }}</option>
                  @endforeach
                </select>
              </div>

              <div>
                <label class="form-label mb-1 small fw-semibold">Status</label>
                <select name="status_kepegawaian" class="form-select form-select-sm" style="min-width:120px">
                  <option value="">Semua Status</option>
                  @foreach(\App\Models\Guru::listStatusKepegawaian() as $s)
                    <option value="{{ $s }}" {{ request('status_kepegawaian')===$s ? 'selected':'' }}>{{ $s }}</option>
                  @endforeach
                </select>
              </div>

              <div>
                <label class="form-label mb-1 small fw-semibold">Cari</label>
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Nama / NIP / NUPTK..." value="{{ request('search') }}"
                       style="min-width:180px">
              </div>

              <button type="submit" class="btn btn-primary btn-sm">
                <i class="bi bi-search"></i> Filter
              </button>
              <a href="{{ route('guru.index', ['tampilkan'=>$tampilkan]) }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-counterclockwise"></i> Reset
              </a>
            </form>

            {{-- Tabel --}}
            <div class="table-responsive">
              <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                  <tr>
                    <th width="45">#</th>
                    <th width="60">Foto</th>
                    <th>Nama Guru</th>
                    <th>NIP / NUPTK</th>
                    <th>Jabatan</th>
                    <th>Status</th>
                    <th>Akun</th>
                    <th width="160">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($guru as $index => $item)
                    <tr class="{{ $item->trashed() ? 'table-danger' : '' }}">
                      <td>{{ $guru->firstItem() + $index }}</td>
                      <td class="text-center">
                        <img src="{{ $item->foto_url }}" alt="{{ $item->nama_lengkap }}"
                             class="rounded-circle" width="40" height="40"
                             style="object-fit:cover">
                      </td>
                      <td>
                        <strong>{{ $item->nama_gelar }}</strong>
                        <br><small class="text-muted">{{ $item->jenis_kelamin === 'L' ? 'Laki-laki' : ($item->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}</small>
                        @if($item->trashed())
                          <br><span class="badge bg-danger mt-1">Dihapus {{ $item->deleted_at->diffForHumans() }}</span>
                        @endif
                      </td>
                      <td>
                        <small>NIP: {{ $item->nip ?? '-' }}</small><br>
                        <small>NUPTK: {{ $item->nuptk ?? '-' }}</small>
                      </td>
                      <td>
                        <span class="badge bg-secondary">{{ $item->jabatan }}</span>
                        <br><small class="text-muted">{{ $item->status_kepegawaian }}</small>
                      </td>
                      <td class="text-center">
                        @if($item->trashed())
                          <span class="badge bg-danger">Terhapus</span>
                        @elseif($item->is_active)
                          <span class="badge bg-success">Aktif</span>
                        @else
                          <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                      </td>
                      <td>
                        @if($item->user)
                          <small><i class="bi bi-person me-1"></i>{{ $item->user->username }}</small><br>
                          <small><i class="bi bi-envelope me-1"></i>{{ $item->user->email }}</small>
                        @else
                          <span class="text-muted small">-</span>
                        @endif
                      </td>
                      <td>
                        @if($item->trashed())
                          <div class="d-flex gap-1">
                            <form action="{{ route('guru.restore', $item->id) }}" method="POST">
                              @csrf @method('PATCH')
                              <button class="btn btn-success btn-sm"
                                      onclick="return confirm('Pulihkan data guru ini?')">
                                <i class="bi bi-arrow-counterclockwise"></i> Restore
                              </button>
                            </form>
                            <form action="{{ route('guru.force-delete', $item->id) }}" method="POST">
                              @csrf @method('DELETE')
                              <button class="btn btn-danger btn-sm"
                                      onclick="return confirm('Hapus PERMANEN? Data tidak bisa dikembalikan!')">
                                <i class="bi bi-trash-fill"></i>
                              </button>
                            </form>
                          </div>
                        @else
                          <div class="d-flex gap-1">
                            <a href="{{ route('guru.show', $item) }}" class="btn btn-info btn-sm" title="Detail">
                              <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('guru.edit', $item) }}" class="btn btn-warning btn-sm" title="Edit">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('guru.destroy', $item) }}" method="POST"
                                  onsubmit="return confirm('Hapus guru {{ $item->nama_lengkap }}?')">
                              @csrf @method('DELETE')
                              <button class="btn btn-danger btn-sm" title="Hapus">
                                <i class="bi bi-trash"></i>
                              </button>
                            </form>
                          </div>
                        @endif
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="8" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                        {{ $tampilkan === 'terhapus' ? 'Tidak ada data guru yang terhapus.' : 'Belum ada data guru.' }}
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-2">
              <small class="text-muted">
                Menampilkan {{ $guru->firstItem() ?? 0 }}–{{ $guru->lastItem() ?? 0 }}
                dari {{ $guru->total() }} data
              </small>
              {{ $guru->links() }}
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection