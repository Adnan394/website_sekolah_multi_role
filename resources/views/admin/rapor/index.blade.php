@extends('layouts.admin')
@section('content')
<main id="main" class="main">
  <div class="pagetitle"><h1>Rapor Penilaian</h1></div>
  <section class="section">
    <div class="card"><div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
        <a href="{{ route('rapor.create') }}" class="btn btn-primary btn-sm">Buat Rapor</a>
      </div>

      {{-- Filter --}}
      <form method="GET" action="{{ route('rapor.index') }}" class="d-flex gap-2 align-items-end mb-4">
        <div>
          <label class="form-label mb-1 small fw-semibold">Kelas</label>
          <select name="kelas_id" class="form-select form-select-sm" style="min-width: 180px;">
            <option value="">Semua Kelas</option>
            @foreach($kelasList as $k)
              <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                {{ $k->nama_kelas }} (Kelas {{ $k->tingkat }})
              </option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="form-label mb-1 small fw-semibold">Semester</label>
          <select name="semester" class="form-select form-select-sm" style="min-width: 150px;">
            <option value="">Semua Semester</option>
            @foreach($semesterList as $sem)
              <option value="{{ $sem }}" {{ request('semester') == $sem ? 'selected' : '' }}>
                {{ $sem }}
              </option>
            @endforeach
          </select>
        </div>
        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search"></i> Filter</button>
        <a href="{{ route('rapor.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-counterclockwise"></i> Reset</a>
      </form>

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
