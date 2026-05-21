@extends('layouts.admin')

@section('content')
<main id="main" class="main">

  {{-- Page Title --}}
  <div class="pagetitle">
    <h1>Data Kelas</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Data Kelas</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Daftar Kelas</h5>

            {{-- Alert Success --}}
            @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            @if(session('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-1"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            {{-- Toolbar: Tambah + Tab Filter Tampilkan --}}
            <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
              <a href="{{ route('kelas.create') }}" class="btn btn-danger">
                <i class="bi bi-plus-circle me-1"></i> Tambah Kelas
              </a>

              {{-- Tab: Aktif / Terhapus / Semua --}}
              <div class="btn-group ms-2" role="group">
                <a href="{{ route('kelas.index', array_merge(request()->except('tampilkan','page'), ['tampilkan' => 'aktif'])) }}"
                   class="btn btn-sm {{ $tampilkan === 'aktif' ? 'btn-primary' : 'btn-outline-primary' }}">
                  <i class="bi bi-list-check me-1"></i> Aktif
                </a>
                <a href="{{ route('kelas.index', array_merge(request()->except('tampilkan','page'), ['tampilkan' => 'terhapus'])) }}"
                   class="btn btn-sm {{ $tampilkan === 'terhapus' ? 'btn-danger' : 'btn-outline-danger' }}">
                  <i class="bi bi-trash me-1"></i> Terhapus
                  @if($jumlahTerhapus > 0)
                    <span class="badge bg-white text-danger ms-1">{{ $jumlahTerhapus }}</span>
                  @endif
                </a>
                <a href="{{ route('kelas.index', array_merge(request()->except('tampilkan','page'), ['tampilkan' => 'semua'])) }}"
                   class="btn btn-sm {{ $tampilkan === 'semua' ? 'btn-secondary' : 'btn-outline-secondary' }}">
                  <i class="bi bi-grid me-1"></i> Semua
                </a>
              </div>
            </div>

            {{-- Banner peringatan mode terhapus --}}
            @if($tampilkan === 'terhapus')
              <div class="alert alert-warning d-flex align-items-center gap-2 py-2" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span>Menampilkan <strong>data yang telah dihapus</strong>. Gunakan tombol <strong>Restore</strong> untuk memulihkan atau <strong>Hapus Permanen</strong> untuk menghapus selamanya.</span>
              </div>
            @endif

            {{-- Form Filter --}}
            <form method="GET" action="{{ route('kelas.index') }}"
                  class="d-flex flex-wrap gap-2 align-items-end mb-3">

              {{-- Pertahankan nilai tampilkan saat filter disubmit --}}
              <input type="hidden" name="tampilkan" value="{{ $tampilkan }}">

              <div>
                <label class="form-label mb-1 small fw-semibold">Tahun Pelajaran</label>
                <select name="tahun_pelajaran" class="form-select form-select-sm" style="min-width:130px">
                  <option value="">Semua</option>
                  @foreach($tahunPelajaranList as $tahun)
                    <option value="{{ $tahun }}" {{ request('tahun_pelajaran') == $tahun ? 'selected' : '' }}>
                      {{ $tahun }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div>
                <label class="form-label mb-1 small fw-semibold">Tingkat</label>
                <select name="tingkat" class="form-select form-select-sm" style="min-width:100px">
                  <option value="">Semua</option>
                  @foreach(range(1, 6) as $t)
                    <option value="{{ $t }}" {{ request('tingkat') == $t ? 'selected' : '' }}>
                      Kelas {{ $t }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div>
                <label class="form-label mb-1 small fw-semibold">Semester</label>
                <select name="semester" class="form-select form-select-sm" style="min-width:110px">
                  <option value="">Semua</option>
                  <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                  <option value="Genap" {{ request('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                </select>
              </div>

              <div>
                <label class="form-label mb-1 small fw-semibold">Cari</label>
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Nama / kode kelas..."
                       value="{{ request('search') }}" style="min-width:160px">
              </div>

              <button type="submit" class="btn btn-primary btn-sm">
                <i class="bi bi-search"></i> Filter
              </button>
              <a href="{{ route('kelas.index', ['tampilkan' => $tampilkan]) }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-counterclockwise"></i> Reset
              </a>
            </form>

            {{-- Tabel --}}
            <div class="table-responsive">
              <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                  <tr>
                    <th style="width:50px">#</th>
                    <th>Nama Kelas</th>
                    <th>Tingkat</th>
                    <th>Tahun Pelajaran</th>
                    <th>Semester</th>
                    <th>Kapasitas</th>
                    {{-- <th>Jml Siswa</th> --}}
                    <th>Status</th>
                    <th style="width:160px">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($kelas as $index => $item)
                    <tr class="{{ $item->trashed() ? 'table-danger' : '' }}">
                      <td>{{ $kelas->firstItem() + $index }}</td>
                      <td>
                        <strong>{{ $item->nama_kelas }}</strong>
                        <br><small class="text-muted">{{ $item->kode_kelas }}</small>
                        @if($item->trashed())
                          <br><span class="badge bg-danger mt-1">
                            <i class="bi bi-trash me-1"></i>
                            Dihapus {{ $item->deleted_at->diffForHumans() }}
                          </span>
                        @endif
                      </td>
                      <td>
                        <span class="badge bg-primary">Kelas {{ $item->tingkat }}</span>
                      </td>
                      <td>{{ $item->tahun_pelajaran }}</td>
                      <td>{{ $item->semester }}</td>
                      <td class="text-center">{{ $item->kapasitas }} siswa</td>
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
                        @if($item->trashed())
                          {{-- Mode terhapus: tombol Restore & Hapus Permanen --}}
                          <div class="d-flex gap-1">
                            <form action="{{ route('kelas.restore', $item->id) }}"
                                  method="POST" class="d-inline">
                              @csrf
                              @method('PATCH')
                              <button type="submit" class="btn btn-success btn-sm" title="Restore"
                                      onclick="return confirm('Pulihkan kelas {{ $item->nama_kelas }}?')">
                                <i class="bi bi-arrow-counterclockwise"></i> Restore
                              </button>
                            </form>
                            <form action="{{ route('kelas.force-delete', $item->id) }}"
                                  method="POST" class="d-inline">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger btn-sm" title="Hapus Permanen"
                                      onclick="return confirm('HAPUS PERMANEN kelas {{ $item->nama_kelas }}? Data tidak bisa dikembalikan!')">
                                <i class="bi bi-trash-fill"></i>
                              </button>
                            </form>
                          </div>
                        @else
                          {{-- Mode normal: tombol Detail, Edit, Hapus --}}
                          <div class="d-flex gap-1">
                            <a href="{{ route('kelas.show', $item) }}"
                               class="btn btn-info btn-sm" title="Detail">
                              <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('kelas.edit', $item) }}"
                               class="btn btn-warning btn-sm" title="Edit">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('kelas.destroy', $item) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus kelas {{ $item->nama_kelas }}?')">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
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
                        @if($tampilkan === 'terhapus')
                          Tidak ada data kelas yang terhapus.
                        @else
                          Belum ada data kelas.
                        @endif
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-2">
              <small class="text-muted">
                Menampilkan {{ $kelas->firstItem() ?? 0 }}–{{ $kelas->lastItem() ?? 0 }}
                dari {{ $kelas->total() }} data
              </small>
              {{ $kelas->links() }}
            </div>

          </div>{{-- /card-body --}}
        </div>{{-- /card --}}
      </div>
    </div>
  </section>

</main>
@endsection