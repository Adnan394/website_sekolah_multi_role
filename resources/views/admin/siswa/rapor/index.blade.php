@extends('layouts.admin')
@section('content')
<main id="main" class="main">
  <div class="pagetitle"><h1>Rapor Saya</h1></div>
  <section class="section">
    <div class="card"><div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead><tr><th>#</th><th>Tahun</th><th>Semester</th><th>Total Nilai</th><th>Aksi</th></tr></thead>
          <tbody>
            @forelse($rapor as $item)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $item->tahun_pelajaran }}</td>
              <td>{{ $item->semester }}</td>
              <td>{{ $item->nilai_total ? number_format($item->nilai_total, 2) : '-' }}</td>
              <td class="d-flex gap-2">
                <a href="{{ route('siswa.rapor.show', $item) }}" class="btn btn-sm btn-secondary">Lihat</a>
                <a href="{{ route('siswa.rapor.download', $item) }}" class="btn btn-sm btn-primary">Unduh PDF</a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center text-muted py-4">Belum ada rapor tersedia.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="mt-3">{{ $rapor->links() }}</div>
    </div></div>
  </section>
</main>
@endsection