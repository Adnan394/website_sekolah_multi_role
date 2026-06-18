@extends('layouts.admin')
@section('content')
<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <div>
            <h1>Submissions: {{ $jadwal->judul_tugas }}</h1>
            <nav><ol class="breadcrumb"><li class="breadcrumb-item">Siswa</li><li class="breadcrumb-item active">Submissions</li></ol></nav>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body pt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Status</th>
                            <th>Nilai</th>
                            <th>Komentar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($submissions as $s)
                        <tr>
                            <td>{{ $s->siswa->nama_lengkap }}</td>
                            <td>{{ $s->status }}</td>
                            <td>{{ $s->nilai ?? '-' }}</td>
                            <td>{{ $s->komentar ?? '-' }}</td>
                            <td>
                                <a href="{{ route('siswa-tugas.edit', $s) }}" class="btn btn-sm btn-primary">Lihat / Nilai</a>
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
