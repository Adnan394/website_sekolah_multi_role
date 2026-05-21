@extends('layouts.admin')

@section('content')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Detail Jadwal</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body pt-4">
            <table class="table table-striped">
              <tr><th width="150">Kelas</th><td>{{ $jadwal->kelas->nama_kelas }}</td></tr>
              <tr><th>Mata Pelajaran</th><td>{{ $jadwal->pelajaran->nama_pelajaran }}</td></tr>
              <tr><th>Guru</th><td>{{ $jadwal->guru->nama_lengkap }}</td></tr>
              <tr><th>Waktu</th><td>{{ $jadwal->hari }}, Jam ke-{{ $jadwal->jam_ke }} ({{ $jadwal->durasi }})</td></tr>
              <tr><th>Ruangan</th><td>{{ $jadwal->ruangan ?? 'Tidak ditentukan' }}</td></tr>
              <tr><th>Semester</th><td>{{ $jadwal->semester }} ({{ $jadwal->tahun_pelajaran }})</td></tr>
            </table>
            <div class="mt-3">
              <a href="{{ route('jadwal-pelajaran.edit', $jadwal->id) }}" class="btn btn-warning">Edit</a>
              <a href="{{ route('jadwal-pelajaran.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection