@extends('layouts.admin')

@section('content')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Grid Jadwal Pelajaran</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('jadwal-pelajaran.index') }}">Index</a></li>
        <li class="breadcrumb-item active">Grid View</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body pt-4">
        {{-- Filter Grid --}}
        <form method="GET" action="{{ route('jadwal-pelajaran.grid') }}" class="row g-3 mb-4">
          <div class="col-md-4">
            <label class="form-label fw-bold small">Pilih Kelas</label>
            <select name="kelas_id" class="form-select" onchange="this.form.submit()">
              <option value="">-- Pilih Kelas untuk Melihat Jadwal --</option>
              @foreach($kelasList as $k)
                <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-bold small">Tahun Pelajaran</label>
            <select name="tahun_pelajaran" class="form-select" onchange="this.form.submit()">
              @foreach($tahunList as $t)
                <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-bold small">Semester</label>
            <select name="semester" class="form-select" onchange="this.form.submit()">
              <option value="Ganjil" {{ $semester == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
              <option value="Genap" {{ $semester == 'Genap' ? 'selected' : '' }}>Genap</option>
            </select>
          </div>
        </form>

        @if($kelas)
          <h5 class="text-center mb-4">JADWAL PELAJARAN KELAS {{ $kelas->nama_kelas }} <br> 
            <small class="text-muted">TAHUN {{ $tahun }} - SEMESTER {{ strtoupper($semester) }}</small>
          </h5>

          <div class="table-responsive">
            <table class="table table-bordered align-middle">
              <thead class="table-dark text-center">
                <tr>
                  <th width="10%">Jam</th>
                  @foreach($hariList as $h)
                    <th width="15%">{{ $h }}</th>
                  @endforeach
                </tr>
              </thead>
              <tbody>
                @for($i = 1; $i <= 10; $i++) {{-- Menampilkan jam ke 1 sampai 10 --}}
                <tr>
                  <td class="text-center fw-bold bg-light">Ke-{{ $i }}</td>
                  @foreach($hariList as $h)
                    @php
                      // Mencari jadwal di hari $h dan jam ke $i
                      $item = $jadwal->get($h)?->firstWhere('jam_ke', $i);
                    @endphp
                    <td class="text-center p-2" style="min-height: 80px;">
                      @if($item)
                        <div class="card mb-0 border-0 shadow-sm" style="background-color: #f8f9fa;">
                          <div class="p-1">
                            <div class="fw-bold small text-primary">{{ $item->pelajaran->nama_pelajaran }}</div>
                            <div class="small text-muted" style="font-size: 0.7rem;">{{ $item->guru->nama_lengkap }}</div>
                            <div class="badge bg-secondary" style="font-size: 0.6rem;">{{ $item->ruangan ?? '-' }}</div>
                            <div class="mt-1">
                                <a href="{{ route('jadwal-pelajaran.edit', $item->id) }}" class="text-warning"><i class="bi bi-pencil-square"></i></a>
                            </div>
                          </div>
                        </div>
                      @else
                        <span class="text-light">-</span>
                      @endif
                    </td>
                  @endforeach
                </tr>
                @endfor
              </tbody>
            </table>
          </div>
        @else
          <div class="alert alert-info text-center">
            <i class="bi bi-info-circle me-1"></i> Silakan pilih kelas terlebih dahulu untuk melihat tampilan grid jadwal.
          </div>
        @endif
      </div>
    </div>
  </section>
</main>
@endsection