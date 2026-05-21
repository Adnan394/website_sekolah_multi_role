@extends('layouts.admin')
@section('content')
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
                            <th>Pelajaran</th>
                            <th>Tanggal Mulai</th>
                            <th>Tenggat</th>
                            <th>Status</th>
                            <th>Nilai</th>
                            <th>Komentar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tugas as $t)
                        @php
                            $sub = $submissions[$t->id] ?? null;
                        @endphp
                        <tr>
                            <td>{{ $t->judul_tugas }}</td>
                            <td>{{ $t->pelajaran->nama_pelajaran }}</td>
                            <td>{{ $t->tanggal_mulai->format('d-m-Y') }}</td>
                            <td>{{ $t->tenggat_waktu->format('d-m-Y') }}</td>
                            <td>
                                <span class="badge {{ $sub?->status=='Belum Mengumpulkan'?'bg-warning':'bg-success' }}">
                                    {{ $sub?->status ?? 'Belum Mengumpulkan' }}
                                </span>
                            </td>
                            <td>{{ $sub->nilai ?? '-' }}</td>
                            <td>{{ $sub->komentar ?? '-' }}</td>
                            <td>
                                <a href="{{ route('siswa-tugas.create', $t) }}" class="btn btn-primary btn-sm">
                                    {{ $sub?'Update':'Kumpulkan' }}
                                </a>
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