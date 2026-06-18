@extends('layouts.admin')
@section('content')
<h3>Tugas yang Dibuat</h3>
<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <div>
            <h1>Tugas Siswa</h1>
            <nav><ol class="breadcrumb"><li class="breadcrumb-item">Siswa</li><li class="breadcrumb-item active">Tugas Siswa</li></ol></nav>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body pt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Judul Tugas</th>
                            <th>Kelas</th>
                            <th>Pelajaran</th>
                            <th>Tenggat</th>
                            <th>Jumlah Siswa</th>
                            <th>Status</th>
                            <th>Nilai</th>
                            <th>Komentar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tugas as $t)
                        <tr>
                            <td>{{ $t->judul_tugas }}</td>
                            <td>{{ $t->kelas->nama_kelas }}</td>
                            <td>{{ $t->pelajaran->nama_pelajaran }}</td>
                            <td>{{ $t->tenggat_waktu->format('d-m-Y') }}</td>
                            <td>{{ $t->kelas->siswa->count() }}</td>
                            <td>
                                <span class="badge 
                                    {{ $t->status_label=='Draft'?'bg-secondary':($t->status_label=='Berakhir'?'bg-danger':'bg-success') }}">
                                    {{ $t->status_label }}
                                </span>
                            </td>
                            <td>-</td>
                            <td>-</td>
                            <td>
                                <a href="{{ route('guru.tugas.submissions', $t->id) }}" class="btn btn-sm btn-primary">Lihat / Nilai</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>
@endsection