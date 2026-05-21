@extends('layouts.admin')
@section('content')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>{{ isset($materi) ? 'Edit' : 'Tambah' }} Materi Pembelajaran</h1>
    <nav><ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('materi-pembelajaran.index') }}">Materi</a></li>
      <li class="breadcrumb-item active">{{ isset($materi) ? 'Edit' : 'Tambah' }}</li>
    </ol></nav>
  </div>
  <section class="section">
    <div class="row justify-content-center"><div class="col-lg-12">
      @if($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">
          @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul></div>
      @endif

      <div class="card"><div class="card-body pt-4">
        <h5 class="card-title">Form {{ isset($materi) ? 'Edit' : 'Tambah' }} Materi</h5>

        <form action="{{ isset($materi) ? route('materi-pembelajaran.update', $materi) : route('materi-pembelajaran.store') }}"
              method="POST" enctype="multipart/form-data">
          @csrf
          @if(isset($materi)) @method('PUT') @endif

          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
              <select name="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror">
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelasList as $k)
                  <option value="{{ $k->id }}"
                    {{ old('kelas_id', $materi->kelas_id ?? '') == $k->id ? 'selected' : '' }}>
                    {{ $k->nama_kelas }} ({{ $k->tahun_pelajaran }})
                  </option>
                @endforeach
              </select>
              @error('kelas_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4">
              <label class="form-label fw-semibold">Mata Pelajaran <span class="text-danger">*</span></label>
              <select name="pelajaran_id" class="form-select @error('pelajaran_id') is-invalid @enderror">
                <option value="">-- Pilih Pelajaran --</option>
                @foreach($pelajaranList as $p)
                  <option value="{{ $p->id }}"
                    {{ old('pelajaran_id', $materi->pelajaran_id ?? '') == $p->id ? 'selected' : '' }}>
                    {{ $p->nama_pelajaran }}
                  </option>
                @endforeach
              </select>
              @error('pelajaran_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4">
              <label class="form-label fw-semibold">Guru <span class="text-danger">*</span></label>
              <select name="guru_id" class="form-select @error('guru_id') is-invalid @enderror">
                <option value="">-- Pilih Guru --</option>
                @foreach($guruList as $g)
                  <option value="{{ $g->id }}"
                    {{ old('guru_id', $materi->guru_id ?? '') == $g->id ? 'selected' : '' }}>
                    {{ $g->nama_lengkap }}
                  </option>
                @endforeach
              </select>
              @error('guru_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-8">
              <label class="form-label fw-semibold">Judul Materi <span class="text-danger">*</span></label>
              <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                     value="{{ old('judul', $materi->judul ?? '') }}" placeholder="Judul materi">
              @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-2">
              <label class="form-label fw-semibold">Tipe <span class="text-danger">*</span></label>
              <select name="tipe" id="tipe" class="form-select @error('tipe') is-invalid @enderror"
                      onchange="toggleTipeFields()">
                @foreach($tipeList as $t)
                  <option value="{{ $t }}" {{ old('tipe', $materi->tipe ?? '') === $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
              </select>
              @error('tipe')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-2">
              <label class="form-label fw-semibold">Tanggal Upload <span class="text-danger">*</span></label>
              <input type="date" name="tanggal_upload" class="form-control @error('tanggal_upload') is-invalid @enderror"
                     value="{{ old('tanggal_upload', isset($materi) ? $materi->tanggal_upload->format('Y-m-d') : today()->format('Y-m-d')) }}">
              @error('tanggal_upload')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Field upload file --}}
            <div class="col-12" id="field-file">
              <label class="form-label fw-semibold">File Materi</label>
              @if(isset($materi) && $materi->file_materi)
                <div class="mb-2">
                  <a href="{{ $materi->file_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-file-earmark me-1"></i>File saat ini
                  </a>
                  <div class="form-check d-inline-block ms-3">
                    <input class="form-check-input" type="checkbox" name="hapus_file" value="1" id="hapus_file">
                    <label class="form-check-label small text-danger" for="hapus_file">Hapus file</label>
                  </div>
                </div>
              @endif
              <input type="file" name="file_materi" class="form-control @error('file_materi') is-invalid @enderror">
              <div class="form-text">Maks 10MB</div>
              @error('file_materi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Field link --}}
            <div class="col-12" id="field-link">
              <label class="form-label fw-semibold">Link Materi</label>
              <input type="url" name="link_materi" class="form-control @error('link_materi') is-invalid @enderror"
                     value="{{ old('link_materi', $materi->link_materi ?? '') }}"
                     placeholder="https://drive.google.com/...">
              @error('link_materi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Deskripsi</label>
              <textarea name="deskripsi" class="form-control" rows="3"
                        placeholder="Deskripsi materi (opsional)">{{ old('deskripsi', $materi->deskripsi ?? '') }}</textarea>
            </div>

            <div class="col-12 d-flex align-items-center gap-4">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="is_published"
                       name="is_published" value="1"
                       {{ old('is_published', $materi->is_published ?? false) ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold" for="is_published">Publish Sekarang</label>
              </div>
            </div>

            <div class="col-12 d-flex gap-2 mt-2">
              <button type="submit" class="btn {{ isset($materi) ? 'btn-warning' : 'btn-danger' }}">
                <i class="bi bi-save me-1"></i>{{ isset($materi) ? 'Update' : 'Simpan' }}
              </button>
              <a href="{{ route('materi-pembelajaran.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Kembali
              </a>
            </div>
          </div>
        </form>
      </div></div>
    </div></div>
  </section>

  <script>
    function toggleTipeFields() {
      const tipe = document.getElementById('tipe').value;
      document.getElementById('field-file').style.display  = ['Dokumen','Video'].includes(tipe) ? '' : 'none';
      document.getElementById('field-link').style.display  = ['Link'].includes(tipe) ? '' : 'none';
    }
    document.addEventListener('DOMContentLoaded', toggleTipeFields);
  </script>
</main>
@endsection