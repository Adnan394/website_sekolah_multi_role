@extends('layouts.admin', ['active' => 'buku'])

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Data Buku</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Data Buku</li>
        </ol>
      </nav>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Kelola Data Buku</h5>
              <div class="mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahBukuModal">
                  <i class="bi bi-plus-circle"></i> Tambah Buku
                </button>
                <a href="{{ route('perpustakaan.buku.export') }}" class="btn btn-success">
                  <i class="bi bi-file-earmark-excel"></i> Ekspor Excel
                </a>
              </div>

              @if(session('error'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      {{ session('error') }}
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
              @endif

              @if($errors->any())
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <ul class="mb-0">
                          @foreach($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
              @endif

              <table class="table datatable">
                <thead>
                  <tr>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($bukus as $buku)
                  <tr>
                    <td>{{ $buku->judul }}</td>
                    <td>{{ $buku->pengarang }}</td>
                    <td>{{ $buku->penerbit }}</td>
                    <td>{{ $buku->stok }}</td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editBukuModal{{ $buku->id }}">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <form action="{{ route('perpustakaan.buku.destroy', $buku->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
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

@foreach($bukus as $buku)
<!-- Modal Edit -->
<div class="modal fade" id="editBukuModal{{ $buku->id }}" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('perpustakaan.buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">Edit Buku</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
              <label>Judul Buku</label>
              <input type="text" name="judul" class="form-control" value="{{ $buku->judul }}" required>
          </div>
          <div class="mb-3">
              <label>Pengarang</label>
              <input type="text" name="pengarang" class="form-control" value="{{ $buku->pengarang }}">
          </div>
          <div class="mb-3">
              <label>Penerbit</label>
              <input type="text" name="penerbit" class="form-control" value="{{ $buku->penerbit }}">
          </div>
          <div class="mb-3">
              <label>Tahun Terbit</label>
              <input type="number" name="tahun_terbit" class="form-control" value="{{ $buku->tahun_terbit }}">
          </div>
          <div class="mb-3">
              <label>Stok</label>
              <input type="number" name="stok" class="form-control" value="{{ $buku->stok }}" required>
          </div>
          <div class="mb-3">
              <label>Cover Baru (Opsional)</label>
              <input type="file" name="cover" class="form-control" accept="image/*">
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
<div class="modal fade" id="tambahBukuModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('perpustakaan.buku.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Tambah Buku</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
              <label>Judul Buku</label>
              <input type="text" name="judul" class="form-control" required>
          </div>
          <div class="mb-3">
              <label>Pengarang</label>
              <input type="text" name="pengarang" class="form-control">
          </div>
          <div class="mb-3">
              <label>Penerbit</label>
              <input type="text" name="penerbit" class="form-control">
          </div>
          <div class="mb-3">
              <label>Tahun Terbit</label>
              <input type="number" name="tahun_terbit" class="form-control">
          </div>
          <div class="mb-3">
              <label>Stok</label>
              <input type="number" name="stok" class="form-control" value="0" required>
          </div>
          <div class="mb-3">
              <label>Cover (Opsional)</label>
              <input type="file" name="cover" class="form-control" accept="image/*">
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
