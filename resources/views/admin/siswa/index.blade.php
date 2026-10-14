@extends('layouts.admin')

@section('content')
<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <div>
            <h1>Data Siswa</h1>
            <nav><ol class="breadcrumb"><li class="breadcrumb-item">Admin</li><li class="breadcrumb-item active">Siswa</li></ol></nav>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalImportExcel">
                <i class="bi bi-file-earmark-excel me-1"></i> Import Excel
            </button>
            <a href="{{ route('siswa.download-template') }}" class="btn btn-outline-success" title="Download Template Excel">
                <i class="bi bi-download me-1"></i> Template
            </a>
            <a href="{{ route('siswa.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Tambah Siswa
            </a>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body pt-3">
                <form action="{{ route('siswa.index') }}" method="GET" class="row g-2 mb-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Cari NISN atau Nama..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-secondary w-100">Cari</button>
                    </div>
                </form>

                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Foto</th>
                            <th>NISN / NIS</th>
                            <th>Nama Lengkap</th>
                            <th>L/P</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswa as $s)
                        <tr>
                            <td><img src="{{ $s->foto_url }}" width="40" class="rounded-circle"></td>
                            <td><small>{{ $s->nisn }} <br> {{ $s->nis }}</small></td>
                            <td><strong>{{ $s->nama_lengkap }}</strong></td>
                            <td>{{ $s->jenis_kelamin }}</td>
                            <td>
                                <span class="badge bg-{{ $s->is_active ? 'success' : 'danger' }}">
                                    {{ $s->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('siswa.show', $s->id) }}" class="btn btn-info btn-sm text-white"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('siswa.edit', $s->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('siswa.destroy', $s->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus siswa dan akun user?')"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $siswa->links() }}
            </div>
        </div>
    </section>

    <!-- Modal Import Excel -->
    <div class="modal fade" id="modalImportExcel" tabindex="-1" aria-labelledby="modalImportExcelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="modalImportExcelLabel">
                            <i class="bi bi-file-earmark-excel me-2"></i> Import Data Siswa dari Excel
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info py-2 px-3 mb-3 small">
                            <div class="fw-bold mb-1"><i class="bi bi-info-circle me-1"></i> Format Kolom Data Siswa:</div>
                            <ul class="mb-0 ps-3">
                                <li><strong>Informasi Akun:</strong> <code>username</code>, <code>email</code>, <code>password</code> (min. 8 karakter)</li>
                                <li><strong>Data Pribadi:</strong> <code>nama_lengkap</code>, <code>nisn</code>, <code>nis</code>, <code>jenis_kelamin</code> (L/P)</li>
                            </ul>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih File Excel (.xlsx, .xls, .csv) <span class="text-danger">*</span></label>
                            <input type="file" name="file" class="form-control" accept=".xlsx, .xls, .csv" required>
                            <div class="form-text">Maksimal ukuran file: 5 MB</div>
                        </div>

                        <div class="card bg-light border mb-0">
                            <div class="card-body p-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold small">Template Format Excel</div>
                                    <div class="text-muted" style="font-size: 0.8rem;">Gunakan format resmi agar proses import lancar.</div>
                                </div>
                                <a href="{{ route('siswa.download-template') }}" class="btn btn-outline-success btn-sm text-nowrap">
                                    <i class="bi bi-download me-1"></i> Unduh Template
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-upload me-1"></i> Upload & Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection