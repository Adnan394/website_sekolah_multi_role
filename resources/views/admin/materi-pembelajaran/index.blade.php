@extends('layouts.admin')
@section('content')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Setting Materi Pembelajaran</h1>
    <nav><ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active">Materi Pembelajaran</li>
    </ol></nav>
  </div>
  <section class="section">
    <div class="row"><div class="col-12"><div class="card"><div class="card-body">
      <h5 class="card-title">Daftar Materi Pembelajaran</h5>

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
          <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <a href="{{ route('materi-pembelajaran.create') }}" class="btn btn-danger">
          <i class="bi bi-plus-circle me-1"></i>Tambah Materi
        </a>
        <a href="{{ route('jadwal-tugas.index') }}" class="btn btn-outline-primary">
          <i class="bi bi-clipboard-check me-1"></i>Jadwal Tugas
        </a>
      </div>

      {{-- Filter --}}
      <form method="GET" class="d-flex flex-wrap gap-2 align-items-end mb-3">
        <div>
          <label class="form-label mb-1 small fw-semibold">Kelas</label>
          <select name="kelas_id" class="form-select form-select-sm" style="min-width:120px">
            <option value="">Semua</option>
            @foreach($kelasList as $k)
              <option value="{{ $k->id }}" {{ request('kelas_id')==$k->id?'selected':'' }}>{{ $k->nama_kelas }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="form-label mb-1 small fw-semibold">Pelajaran</label>
          <select name="pelajaran_id" class="form-select form-select-sm" style="min-width:150px">
            <option value="">Semua</option>
            @foreach($pelajaranList as $p)
              <option value="{{ $p->id }}" {{ request('pelajaran_id')==$p->id?'selected':'' }}>{{ $p->nama_pelajaran }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="form-label mb-1 small fw-semibold">Status</label>
          <select name="is_published" class="form-select form-select-sm" style="min-width:120px">
            <option value="">Semua</option>
            <option value="1" {{ request('is_published')==='1'?'selected':'' }}>Published</option>
            <option value="0" {{ request('is_published')==='0'?'selected':'' }}>Draft</option>
          </select>
        </div>
        <div>
          <label class="form-label mb-1 small fw-semibold">Cari</label>
          <input type="text" name="search" class="form-control form-control-sm"
                 value="{{ request('search') }}" placeholder="Judul materi..." style="min-width:160px">
        </div>
        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search"></i></button>
        <a href="{{ route('materi-pembelajaran.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-counterclockwise"></i></a>
      </form>

      <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th>#</th><th>Judul Materi</th><th>Kelas</th><th>Pelajaran</th>
              <th>Guru</th><th>Tipe</th><th>Tgl Upload</th><th>Status</th><th width="130">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($materi as $idx => $item)
              <tr>
                <td>{{ $materi->firstItem() + $idx }}</td>
                <td>
                  <strong>{{ $item->judul }}</strong>
                  @if($item->link_materi)
                    <br><a href="{{ $item->link_materi }}" target="_blank" class="small text-primary">
                      <i class="bi bi-link-45deg"></i> Buka Link
                    </a>
                  @elseif($item->file_materi)
                    <br><a href="{{ $item->file_url }}" target="_blank" class="small text-primary">
                      <i class="bi bi-file-earmark-arrow-down"></i> Unduh
                    </a>
                  @endif
                </td>
                <td><span class="badge bg-primary">{{ $item->kelas->nama_kelas ?? '-' }}</span></td>
                <td><small>{{ $item->pelajaran->nama_pelajaran ?? '-' }}</small></td>
                <td><small>{{ $item->guru->nama_lengkap ?? '-' }}</small></td>
                <td>
                  @php $tipeColor = ['Dokumen'=>'info','Video'=>'danger','Link'=>'warning','Teks'=>'secondary']; @endphp
                  <span class="badge bg-{{ $tipeColor[$item->tipe] ?? 'secondary' }}">{{ $item->tipe }}</span>
                </td>
                <td><small>{{ $item->tanggal_upload->format('d M Y') }}</small></td>
                <td class="text-center">
                  @if($item->is_published)
                    <span class="badge bg-success">Published</span>
                  @else
                    <span class="badge bg-secondary">Draft</span>
                  @endif
                </td>
                <td>
                  <div class="d-flex gap-1">
                    <a href="{{ route('materi-pembelajaran.show', $item) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('materi-pembelajaran.edit', $item) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('materi-pembelajaran.toggle-publish', $item) }}" method="POST">
                      @csrf @method('PATCH')
                      <button class="btn btn-sm {{ $item->is_published ? 'btn-outline-secondary' : 'btn-outline-success' }}"
                              title="{{ $item->is_published ? 'Sembunyikan' : 'Publish' }}">
                        <i class="bi bi-{{ $item->is_published ? 'eye-slash' : 'send' }}"></i>
                      </button>
                    </form>
                    <form action="{{ route('materi-pembelajaran.destroy', $item) }}" method="POST"
                          onsubmit="return confirm('Hapus materi ini?')">
                      @csrf @method('DELETE')
                      <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr><td colspan="9" class="text-center text-muted py-4">
                <i class="bi bi-inbox fs-4 d-block mb-2"></i>Belum ada materi.
              </td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="d-flex justify-content-between mt-2">
        <small class="text-muted">{{ $materi->firstItem() ?? 0 }}–{{ $materi->lastItem() ?? 0 }} dari {{ $materi->total() }}</small>
        {{ $materi->links() }}
      </div>
    </div></div></div></div>
  </section>
</main>
@endsection