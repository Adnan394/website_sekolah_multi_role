<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <style>
    body { font-family: DejaVu Sans, sans-serif; color: #222; font-size: 12px; }
    .header-table { width: 100%; border-bottom: 2px solid #000; margin-bottom: 16px; }
    .header-table td { vertical-align: middle; }
    .logo img { max-height: 90px; }
    .school-info { text-align: center; }
    .school-info h1 { margin: 0; font-size: 16px; }
    .school-info p { margin: 2px 0; font-size: 11px; }
    .title { text-align: center; margin: 18px 0; font-size: 14px; font-weight: bold; }
    .info-table, .data-table, .summary-table, .signature-table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
    .info-table td, .data-table th, .data-table td, .summary-table td, .summary-table th, .signature-table td { border: 1px solid #444; padding: 6px 8px; }
    .data-table th { background: #f0f0f0; }
    .section-title { margin: 12px 0 6px; font-size: 13px; font-weight: bold; }
    .small-text { font-size: 11px; color: #555; }
    .text-right { text-align: right; }
    .signature-table td { border: none; }
    .signature-space { height: 90px; }
  </style>
</head>
<body>
  <table class="header-table">
    <tr>
      <td class="logo" width="100">
        @if($logoData)
          <img src="{{ $logoData }}" alt="Logo">
        @endif
      </td>
      <td class="school-info">
        <h1>{{ $schoolName }}</h1>
        <p>{{ $schoolAddress }}</p>
        <p class="small-text">{{ $schoolContact }}</p>
      </td>
      <td width="100"></td>
    </tr>
  </table>

  <div class="title">LAPORAN PENILAIAN AKADEMIK</div>

  <table class="info-table">
    <tr>
      <td>Nama Siswa</td>
      <td>{{ $rapor->siswa->nama_lengkap }}</td>
      <td>Kelas</td>
      <td>{{ $rapor->siswa->kelas->first()?->nama_kelas ?? '-' }}</td>
    </tr>
    <tr>
      <td>Tahun Pelajaran</td>
      <td>{{ $rapor->tahun_pelajaran }}</td>
      <td>Semester</td>
      <td>{{ $rapor->semester }}</td>
    </tr>
  </table>

  <div class="section-title">1. Materi Pembelajaran</div>
  <table class="data-table">
    <thead>
      <tr>
        <th style="width: 5%;">No</th>
        <th style="width: 35%;">Mata Pelajaran</th>
        <th style="width: 50%;">Materi</th>
        <th style="width: 10%;">Nilai</th>
      </tr>
    </thead>
    <tbody>
      @forelse($materiItems as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item->pelajaran?->nama_pelajaran ?? $item->materi?->pelajaran->nama_pelajaran ?? '-' }}</td>
          <td>{{ $item->materi?->judul ?? '-' }}</td>
          <td class="text-right">{{ number_format($item->nilai ?? 0, 2) }}</td>
        </tr>
      @empty
        <tr><td colspan="4" class="text-right">Belum ada catatan materi.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div class="section-title">2. Tugas</div>
  <table class="data-table">
    <thead>
      <tr>
        <th style="width: 5%;">No</th>
        <th style="width: 60%;">Keterangan</th>
        <th style="width: 15%;">Nilai</th>
      </tr>
    </thead>
    <tbody>
      @forelse($tugasItems as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item->pelajaran?->nama_pelajaran ?? $item->materi?->judul ?? 'Tugas' }}</td>
          <td class="text-right">{{ number_format($item->nilai ?? 0, 2) }}</td>
        </tr>
      @empty
        <tr><td colspan="3" class="text-right">Belum ada catatan tugas.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div class="section-title">3. Kehadiran dan Keaktifan</div>
  <table class="data-table">
    <thead>
      <tr><th style="width: 55%;">Aspek</th><th style="width: 15%;">Rata-rata</th><th style="width: 30%;">Keterangan</th></tr>
    </thead>
    <tbody>
      <tr>
        <td>Kehadiran</td>
        <td class="text-right">{{ number_format($summary['kehadiran'], 2) }}</td>
        <td>Catatan kehadiran siswa selama semester.</td>
      </tr>
      <tr>
        <td>Keaktifan</td>
        <td class="text-right">{{ number_format($summary['keaktifan'], 2) }}</td>
        <td>Catatan partisipasi dan sikap dalam pembelajaran.</td>
      </tr>
    </tbody>
  </table>

  <div class="section-title">4. Ringkasan Nilai</div>
  <table class="summary-table">
    <tr><th>Aspek</th><th>Rata-rata</th></tr>
    <tr><td>Materi</td><td class="text-right">{{ number_format($summary['materi'], 2) }}</td></tr>
    <tr><td>Tugas</td><td class="text-right">{{ number_format($summary['tugas'], 2) }}</td></tr>
    <tr><td>Kehadiran</td><td class="text-right">{{ number_format($summary['kehadiran'], 2) }}</td></tr>
    <tr><td>Keaktifan</td><td class="text-right">{{ number_format($summary['keaktifan'], 2) }}</td></tr>
    <tr><th>Total Rapor</th><th class="text-right">{{ number_format($summary['total'], 2) }}</th></tr>
  </table>

  <table class="signature-table">
    <tr>
      <td style="width: 50%; text-align: center;">Mengetahui,<br>Wali Kelas</td>
      <td style="width: 50%; text-align: center;">Purbalingga, {{ date('d F Y') }}<br>Kepala Sekolah</td>
    </tr>
    <tr>
      <td class="signature-space"></td>
      <td class="signature-space"></td>
    </tr>
    <tr>
      <td style="text-align: center;">{{ $waliKelas?->nama_gelar ?? 'Wali Kelas' }}</td>
      <td style="text-align: center;">{{ $kepalaSekolah?->nama_gelar ?? 'Kepala Sekolah' }}</td>
    </tr>
  </table>
</body>
</html>
