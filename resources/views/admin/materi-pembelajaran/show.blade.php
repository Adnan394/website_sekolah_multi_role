@extends('layouts.admin')
@section('content')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Detail Materi Pembelajaran</h1>
    <nav><ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('materi-pembelajaran.index') }}">Materi</a></li>
      <li class="breadcrumb-item active">Detail</li>
    </ol></nav>
  </div>
  <section class="section">
    <div class="row justify-content-center"><div class="col-lg-12">
      <div class="card"><div class="card-body pt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="card-title mb-0">{{ $materi->judul }}</h5>
          @if($materi->is_published)
            <span class="badge bg-success">Published</span>
          @else
            <span class="badge bg-secondary">Draft</span>
          @endif
        </div>
        
        <table class="table table-bordered mt-3">
          <tr>
            <th width="20%">Pelajaran</th>
            <td>{{ $materi->pelajaran->nama_pelajaran ?? '-' }}</td>
          </tr>
          <tr>
            <th>Kelas</th>
            <td><span class="badge bg-primary">{{ $materi->kelas->nama_kelas ?? '-' }}</span></td>
          </tr>
          <tr>
            <th>Guru Pengampu</th>
            <td>{{ $materi->guru->nama_lengkap ?? '-' }}</td>
          </tr>
          <tr>
            <th>Tipe Materi</th>
            <td>
              @php $tipeColor = ['Dokumen'=>'info','Video'=>'danger','Link'=>'warning','Teks'=>'secondary']; @endphp
              <span class="badge bg-{{ $tipeColor[$materi->tipe] ?? 'secondary' }}">{{ $materi->tipe }}</span>
            </td>
          </tr>
          <tr>
            <th>Tanggal Upload</th>
            <td>{{ $materi->tanggal_upload->format('d M Y') }}</td>
          </tr>
          @if($materi->deskripsi)
          <tr>
            <th>Deskripsi</th>
            <td>{!! nl2br(e($materi->deskripsi)) !!}</td>
          </tr>
          @endif
          @if($materi->link_materi)
          <tr>
            <th>Link Materi</th>
            <td>
              <a href="{{ $materi->link_materi }}" target="_blank" class="btn btn-sm btn-primary">
                <i class="bi bi-box-arrow-up-right me-1"></i>Buka Link Materi
              </a>
            </td>
          </tr>
          @endif
          @if($materi->file_materi)
          <tr>
            <th>File Materi</th>
            <td>
              <a href="{{ $materi->file_url }}" target="_blank" class="btn btn-sm btn-success">
                <i class="bi bi-file-earmark-arrow-down me-1"></i>Unduh / Lihat File
              </a>
            </td>
          </tr>
          @endif
        </table>
        
        <div class="mt-4 d-flex gap-2">
          <a href="{{ route('materi-pembelajaran.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Kembali
          </a>
          @if(Auth::user()->role !== 'siswa')
          <a href="{{ route('materi-pembelajaran.edit', $materi) }}" class="btn btn-warning btn-sm">
            <i class="bi bi-pencil me-1"></i>Edit Materi
          </a>
          @endif
        </div>
      </div></div>
    </div></div>
  </section>
</main>
@endsection
