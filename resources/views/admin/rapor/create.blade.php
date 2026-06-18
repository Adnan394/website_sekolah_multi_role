@extends('layouts.admin')
@section('content')
<main id="main" class="main">
  <div class="pagetitle"><h1>Buat Rapor</h1></div>
  <section class="section">
    <div class="card"><div class="card-body">
      <form method="GET" action="{{ route('rapor.create') }}" class="d-flex flex-wrap gap-2 align-items-end mb-3">
        <div>
          <label class="form-label mb-1 small fw-semibold">Kelas</label>
          <select name="kelas_id" class="form-select form-select-sm" style="min-width:170px">
            <option value="">Semua</option>
            @foreach($kelasList as $kelas)
              <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="form-label mb-1 small fw-semibold">Tahun Pelajaran</label>
          <select name="tahun_pelajaran" class="form-select form-select-sm" style="min-width:150px">
            <option value="">Semua</option>
            @foreach($tahunList as $tahun)
              <option value="{{ $tahun }}" {{ request('tahun_pelajaran') === $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="form-label mb-1 small fw-semibold">Semester</label>
          <select name="semester" class="form-select form-select-sm" style="min-width:130px">
            <option value="">Semua</option>
            @foreach($semesterList as $semester)
              <option value="{{ $semester }}" {{ request('semester') === $semester ? 'selected' : '' }}>{{ $semester }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="form-label mb-1 small fw-semibold">Cari Siswa</label>
          <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Nama siswa..." style="min-width:220px">
        </div>
        <div>
          <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search"></i></button>
          <a href="{{ route('rapor.create') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-counterclockwise"></i></a>
        </div>
      </form>

      <form method="POST" action="{{ route('rapor.store') }}">
        @csrf
        <div class="mb-3">
          <label>Siswa</label>
          <select name="siswa_id" class="form-select">
            @foreach($siswaList as $s)
              <option value="{{ $s->id }}">{{ $s->nama_lengkap }}</option>
            @endforeach
          </select>
        </div>
        <div class="row g-3">
          <div class="col-md-6">
            <label>Tahun Pelajaran</label>
            <select name="tahun_pelajaran" class="form-select">
              <option value="">Pilih Tahun</option>
              @foreach($tahunList as $tahun)
                <option value="{{ $tahun }}">{{ $tahun }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <label>Semester</label>
            <select name="semester" class="form-select">
              <option value="">Pilih Semester</option>
              @foreach($semesterList as $semester)
                <option value="{{ $semester }}">{{ $semester }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="mt-4">
          <button class="btn btn-primary">Buat</button>
        </div>
      </form>
    </div></div>
  </section>
</main>
@endsection
