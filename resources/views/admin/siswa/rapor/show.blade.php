@extends('layouts.admin')
@section('content')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Rapor Semester {{ $rapor->semester }}</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('siswa.rapor.index') }}">Rapor Saya</a></li>
        <li class="breadcrumb-item active">Detail Rapor</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="card"><div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <p class="mb-0">Tahun: <strong>{{ $rapor->tahun_pelajaran }}</strong></p>
          <p class="mb-0">Semester: <strong>{{ $rapor->semester }}</strong></p>
        </div>
        <div>
          <a href="{{ route('siswa.rapor.download', $rapor) }}" class="btn btn-primary btn-sm">Download PDF</a>
        </div>
      </div>

      <table class="table table-bordered">
        <thead><tr><th>#</th><th>Jenis</th><th>Mapel</th><th>Materi</th><th>Nilai</th><th>Komentar</th></tr></thead>
        <tbody>
          @forelse($rapor->items as $item)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ ucfirst($item->jenis) }}</td>
            <td>{{ $item->pelajaran?->nama_pelajaran ?? $item->materi?->pelajaran->nama_pelajaran ?? '-' }}</td>
            <td>{{ $item->materi?->judul ?? '-' }}</td>
            <td>{{ $item->nilai }}</td>
            <td>{{ $item->komentar }}</td>
          </tr>
          @empty
          <tr><td colspan="6" class="text-center text-muted">Belum ada data penilaian.</td></tr>
          @endforelse
        </tbody>
      </table>

      <div class="mt-3">
        <strong>Total Rapor: </strong> {{ number_format($rapor->nilai_total, 2) }}
      </div>
    </div></div>
  </section>
</main>
@endsection