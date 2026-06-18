@extends('layouts.admin')
@section('content')
<main id="main" class="main">
  <div class="pagetitle"><h1>Rapor Penilaian</h1></div>
  <section class="section">
    <div class="card"><div class="card-body">
      <a href="{{ route('rapor.create') }}" class="btn btn-primary btn-sm mb-3">Buat Rapor</a>
      <table class="table table-bordered">
        <thead><tr><th>#</th><th>Siswa</th><th>Tahun</th><th>Semester</th><th>Total</th><th>Aksi</th></tr></thead>
        <tbody>
          @foreach($rapor as $r)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $r->siswa->nama_lengkap }}</td>
            <td>{{ $r->tahun_pelajaran }}</td>
            <td>{{ $r->semester }}</td>
            <td>{{ $r->nilai_total ?? '-' }}</td>
            <td><a href="{{ route('rapor.show', $r) }}" class="btn btn-sm btn-primary">Lihat</a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {{ $rapor->links() }}
    </div></div>
  </section>
</main>
@endsection
