@extends('layouts.admin')

@section('content')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Detail Tugas</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('jadwal-tugas.index') }}">Jadwal Tugas</a></li>
        <li class="breadcrumb-item active">Detail</li>
      </ol>
    </nav>
  </div>

  <section class="section profile">
    <div class="row">
      <div class="col-xl-4">
        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            <span class="badge {{ $tugas->is_published ? 'bg-success' : 'bg-secondary' }} mb-2">
               {{ $tugas->status_label }}
            </span>
            <h2 class="text-center">{{ $tugas->pelajaran->nama_pelajaran }}</h2>
            <h3>{{ $tugas->kelas->nama_kelas }}</h3>
          </div>
          <div class="card-body">
             <hr>
             <div class="row mb-2">
               <div class="col-lg-5 col-md-4 label fw-bold">Metode</div>
               <div class="col-lg-7 col-md-8">{{ $tugas->tipe_pengumpulan }}</div>
             </div>
             <div class="row mb-2">
               <div class="col-lg-5 col-md-4 label fw-bold">Mulai</div>
               <div class="col-lg-7 col-md-8 small">{{ $tugas->tanggal_mulai->format('d M Y, H:i') }}</div>
             </div>
             <div class="row mb-2">
               <div class="col-lg-5 col-md-4 label fw-bold">Deadline</div>
               <div class="col-lg-7 col-md-8 small text-danger">{{ $tugas->tenggat_waktu->format('d M Y, H:i') }}</div>
             </div>
             <div class="row mb-2">
               <div class="col-lg-5 col-md-4 label fw-bold">Nilai Max</div>
               <div class="col-lg-7 col-md-8">{{ $tugas->nilai_maksimal }}</div>
             </div>
             <hr>
             <div class="d-grid gap-2">
                <a href="{{ route('jadwal-tugas.edit', $tugas->id) }}" class="btn btn-warning btn-sm text-white">
                  <i class="bi bi-pencil me-1"></i> Edit Tugas
                </a>
                <a href="{{ route('jadwal-tugas.index') }}" class="btn btn-secondary btn-sm">
                  <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
             </div>
          </div>
        </div>
      </div>

      <div class="col-xl-8">
        <div class="card">
          <div class="card-body pt-3">
            <h5 class="card-title">Informasi Lengkap Tugas</h5>
            
            <div class="row mb-4">
              <div class="col-12 label fw-bold text-primary">Judul Tugas:</div>
              <div class="col-12 fs-5 fw-semibold">{{ $tugas->judul_tugas }}</div>
            </div>

            <div class="row mb-4">
              <div class="col-12 label fw-bold text-primary">Guru Pengampu:</div>
              <div class="col-12">{{ $tugas->guru->nama_lengkap }}</div>
            </div>

            <div class="row mb-4">
              <div class="col-12 label fw-bold text-primary">Instruksi / Deskripsi:</div>
              <div class="col-12 card bg-light p-3 mt-2 border-0">
                {!! nl2br(e($tugas->deskripsi)) ?: '<span class="text-muted italic">Tidak ada deskripsi.</span>' !!}
              </div>
            </div>

            <div class="row mb-4">
              <div class="col-12 label fw-bold text-primary">File Lampiran:</div>
              <div class="col-12 mt-2">
                @if($tugas->file_tugas)
                  <a href="{{ Storage::url($tugas->file_tugas) }}" target="_blank" class="btn btn-outline-info btn-sm">
                    <i class="bi bi-download me-1"></i> Download File Lampiran
                  </a>
                @else
                  <span class="text-muted">Tidak ada file lampiran.</span>
                @endif
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection