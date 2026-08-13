@extends('layouts.admin', ['active' => 'peminjaman'])

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Data Peminjam</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Data Peminjam</li>
        </ol>
      </nav>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Kelola Data Peminjaman</h5>
              <div class="mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahPeminjamanModal">
                  <i class="bi bi-plus-circle"></i> Tambah Peminjaman
                </button>
              </div>

              @if($errors->any())
                  <div class="alert alert-danger">
                      <ul class="mb-0">
                          @foreach($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif

              <table class="table datatable">
                <thead>
                  <tr>
                    <th>Siswa</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($peminjamans as $pinjam)
                  <tr>
                    <td>{{ optional($pinjam->siswa)->nama_lengkap }}</td>
                    <td>{{ optional($pinjam->buku)->judul }}</td>
                    <td>{{ $pinjam->tanggal_pinjam->format('d/m/Y') }}</td>
                    <td>{{ $pinjam->tanggal_kembali ? $pinjam->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                    <td>
                        <span class="badge {{ $pinjam->status == 'dipinjam' ? 'bg-warning' : 'bg-success' }}">
                            {{ ucfirst($pinjam->status) }}
                        </span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPeminjamanModal{{ $pinjam->id }}">
                            <i class="bi bi-pencil"></i> Ubah Status
                        </button>
                        <form action="{{ route('perpustakaan.peminjaman.destroy', $pinjam->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
                        </form>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>
    </section>
</main>

@foreach($peminjamans as $pinjam)
<!-- Modal Edit -->
<div class="modal fade" id="editPeminjamanModal{{ $pinjam->id }}" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('perpustakaan.peminjaman.update', $pinjam->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">Ubah Status Peminjaman</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
              <label>Status</label>
              <select name="status" class="form-select" required>
                  <option value="dipinjam" {{ $pinjam->status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                  <option value="dikembalikan" {{ $pinjam->status == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
              </select>
          </div>
          <div class="mb-3">
              <label>Tanggal Kembali Aktual (Opsional)</label>
              <input type="date" name="tanggal_kembali" class="form-control" value="{{ $pinjam->tanggal_kembali ? $pinjam->tanggal_kembali->format('Y-m-d') : '' }}">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

<!-- Modal Tambah -->
<div class="modal fade" id="tambahPeminjamanModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('perpustakaan.peminjaman.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Tambah Peminjaman</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
              <label>Siswa</label>
              <select name="siswa_id" class="form-select" required>
                  <option value="">-- Pilih Siswa --</option>
                  @foreach($siswas as $siswa)
                  <option value="{{ $siswa->id }}">{{ $siswa->nisn }} - {{ $siswa->nama_lengkap }}</option>
                  @endforeach
              </select>
          </div>
          <div class="mb-3">
              <label>Buku</label>
              <select name="buku_id" class="form-select" required>
                  <option value="">-- Pilih Buku --</option>
                  @foreach($bukus as $buku)
                  <option value="{{ $buku->id }}">{{ $buku->judul }} (Sisa Stok: {{ $buku->stok }})</option>
                  @endforeach
              </select>
          </div>
          <div class="mb-3">
              <label>Tanggal Pinjam</label>
              <input type="date" name="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}" required>
          </div>
          <div class="mb-3">
              <label>Batas Tanggal Kembali (Opsional)</label>
              <input type="date" name="tanggal_kembali" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
