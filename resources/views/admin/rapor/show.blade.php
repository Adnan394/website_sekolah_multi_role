@extends('layouts.admin')
@section('content')
<main id="main" class="main">
  <div class="pagetitle"><h1>Rapor: {{ $rapor->siswa->nama_lengkap }}</h1></div>
  <section class="section">
    <div class="card pt-4"><div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center justify-content-between">
          <p class="mb-0">Tahun: <strong>{{ $rapor->tahun_pelajaran }}</strong> | Semester: <strong>{{ $rapor->semester }}</strong></p>
        </div>
      </div>
      <div class="d-flex justify-content-between align-items-center mb-3">
          <h5>Item Penilaian</h5>
          <div>
            <h4 class="mb-2">Nilai : <span class="badge bg-primary">{{ number_format($rapor->nilai_total,2) }}</span></h4>
            <a href="{{ route('rapor.download', $rapor) }}" class="btn btn-secondary btn-sm w-100">Download PDF</a>
          </div>
      </div>
      <table class="table table-bordered">
        <thead><tr><th>#</th><th>Jenis</th><th>Mapel / Materi</th><th>Guru</th><th>Nilai</th><th>Komentar</th></tr></thead>
        <tbody>
          @foreach($rapor->items as $it)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ ucfirst($it->jenis) }}</td>
            <td>
              <div>{{ $it->pelajaran?->nama_pelajaran ?? $it->materi?->pelajaran->nama_pelajaran ?? '-' }}</div>
              <small class="text-muted">{{ $it->materi?->judul ?? '' }}</small>
            </td>
            <td>{{ $it->guru?->nama_lengkap ?? '-' }}</td>
            <td>{{ $it->nilai }}</td>
            <td>{{ $it->komentar }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>

      <h5>Tambah Item Penilaian</h5>
      <form method="POST" action="{{ route('rapor.items.store', $rapor) }}">
        @csrf
        <div class="row g-2">
          <div class="col-md-3">
            <label class="form-label">Jenis</label>
            <select name="jenis" class="form-select">
              <option value="materi">Materi</option>
              <option value="tugas">Tugas</option>
              <option value="kehadiran">Kehadiran</option>
              <option value="keaktifan">Keaktifan</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Mata Pelajaran</label>
            <select name="pelajaran_id" class="form-select">
              <option value="">Pilih Mapel (opsional)</option>
              @foreach($pelajaranList as $pelajaran)
                <option value="{{ $pelajaran->id }}">{{ $pelajaran->nama_pelajaran }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Materi</label>
            <select name="materi_id" class="form-select">
              <option value="">Pilih Materi (opsional)</option>
              @foreach($materiList as $materi)
                <option value="{{ $materi->id }}">{{ $materi->judul }} — {{ $materi->pelajaran->nama_pelajaran ?? '-' }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2">
            <label class="form-label">Nilai</label>
            <input name="nilai" class="form-control" placeholder="Nilai">
          </div>
          <div class="col-md-12">
            <label class="form-label">Komentar</label>
            <input name="komentar" class="form-control" placeholder="Komentar (opsional)">
          </div>
          <div class="col-md-12 text-end">
            <button class="btn btn-primary">Tambah</button>
          </div>
        </div>
      </form>
    </div></div>
  </section>
</main>
@endsection
