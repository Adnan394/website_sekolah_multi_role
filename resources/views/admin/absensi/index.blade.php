@extends('layouts.admin')
@section('content')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Absensi Siswa</h1>
    <nav><ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active">Absensi</li>
    </ol></nav>
  </div>

  <section class="section">
    <div class="row"><div class="col-lg-12"><div class="card"><div class="card-body">
      <h5 class="card-title">Daftar Absensi</h5>

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
          <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      {{-- Filter --}}
      <form method="GET" class="d-flex gap-2 align-items-end mb-3">
        <div>
          <label class="form-label mb-1 small fw-semibold">Kelas</label>
          <select name="kelas_id" class="form-select form-select-sm" required>
            <option value="">Pilih Kelas</option>
            @foreach($kelasList as $k)
              <option value="{{ $k->id }}" {{ ($kelas && $kelas->id==$k->id)?'selected':'' }}>{{ $k->nama_kelas }} (Kelas {{ $k->tingkat }})</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="form-label mb-1 small fw-semibold">Tanggal</label>
          <input type="date" name="tanggal" class="form-control form-control-sm" value="{{ $tanggal }}">
        </div>
        <div>
          <label class="form-label mb-1 small fw-semibold">Jam Ke</label>
          <select name="jam_ke" class="form-select form-select-sm">
            @for($j=1;$j<=12;$j++)
              <option value="{{ $j }}" {{ (isset($jam_ke) && $jam_ke==$j)?'selected':'' }}>Jam {{ $j }}</option>
            @endfor
          </select>
        </div>
        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search"></i> Filter</button>
      </form>

      @if($kelas)
      <form action="{{ route('absensi.store') }}" method="POST">
        @csrf
        <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
        <input type="hidden" name="tanggal" value="{{ $tanggal }}">
        <input type="hidden" name="jam_ke" value="{{ $jam_ke }}">

        <div class="table-responsive">
          <table class="table table-hover table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Nama Siswa</th>
                <th>Nomor Absen</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Oleh</th>
              </tr>
            </thead>
            <tbody>
              @foreach($kelas->siswa as $i => $s)
              @php
                $a = $absensi[$s->id] ?? null;
              @endphp
              <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $s->nama_lengkap }}</td>
                <td>{{ $s->pivot->nomor_absen ?? '-' }}</td>
                <td>
                  <select name="absensi[{{ $i }}][status]" class="form-select form-select-sm">
                    @foreach(['Belum Absen','Hadir','Sakit','Izin','Alfa'] as $st)
                      <option value="{{ $st }}" {{ ($a && $a->status==$st)?'selected':(!$a && $st=='Belum Absen'?'selected':'') }}>{{ $st }}</option>
                    @endforeach
                  </select>
                  <input type="hidden" name="absensi[{{ $i }}][siswa_id]" value="{{ $s->id }}">
                </td>
                <td>
                  <input type="text" name="absensi[{{ $i }}][keterangan]" class="form-control form-control-sm" value="{{ $a->keterangan ?? '' }}">
                </td>
                <td>
                  @if($a && $a->created_by)
                    @php $by = \App\Models\User::find($a->created_by); @endphp
                    <small class="text-muted">{{ $by?->username ?? '—' }}</small>
                  @else
                    <small class="text-muted">—</small>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="text-end mt-3">
          <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Absensi</button>
        </div>
      </form>
      @endif

    </div></div></div></div>
  </section>
</main>
@endsection