@extends('layouts.admin')

@section('content')
<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <div>
            <h1>Data Siswa</h1>
            <nav><ol class="breadcrumb"><li class="breadcrumb-item">Admin</li><li class="breadcrumb-item active">Siswa</li></ol></nav>
        </div>
        <a href="{{ route('siswa.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Siswa</a>
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
</main>
@endsection