@extends('layouts.admin')

@section('content')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Edit Jadwal Pelajaran</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('jadwal-pelajaran.index') }}">Jadwal Pelajaran</a></li>
        <li class="breadcrumb-item active">Edit</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body pt-4">
        <form action="{{ route('jadwal-pelajaran.update', $jadwal->id) }}" method="POST">
          @csrf @method('PUT')
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">Kelas</label>
              <select name="kelas_id" class="form-select">
                @foreach($kelasList as $k)
                  <option value="{{ $k->id }}" {{ $jadwal->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                @endforeach
              </select>
            </div>
            {{-- Tambahkan field lainnya sama seperti Create dengan value: $jadwal->field_name --}}
            {{-- Contoh Jam Mulai: --}}
            <div class="col-md-3">
              <label class="form-label fw-bold">Jam Mulai</label>
              <input type="time" name="jam_mulai" class="form-control" value="{{ substr($jadwal->jam_mulai, 0, 5) }}">
            </div>
            
            <div class="col-md-3">
                <label class="form-label fw-bold">Status</label>
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $jadwal->is_active ? 'checked' : '' }}>
                    <label class="form-check-label">Jadwal Aktif</label>
                </div>
            </div>

            <div class="col-12 mt-4">
              <button type="submit" class="btn btn-primary">Update Jadwal</button>
              <a href="{{ route('jadwal-pelajaran.index') }}" class="btn btn-secondary">Batal</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>
@endsection