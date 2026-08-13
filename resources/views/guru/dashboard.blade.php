@extends('layouts.admin')

@section('content')
    <main id="main" class="main">

      <style>
        .dashboard-welcome {
            background: linear-gradient(135deg, #890A0A 0%, #b01515 50%, #890A0A 100%);
            border-radius: 20px;
            padding: 36px 40px;
            position: relative;
            overflow: hidden;
            color: #fff;
        }
        .dashboard-welcome::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
        }
        .dashboard-welcome::after {
            content: '';
            position: absolute;
            bottom: -40px;
            right: 80px;
            width: 120px;
            height: 120px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }
        .dashboard-welcome h4 {
            font-weight: 800;
            font-size: 1.5rem;
            margin-bottom: 6px;
        }
        .dashboard-welcome p {
            opacity: 0.85;
            font-size: 0.92rem;
            margin: 0;
            max-width: 500px;
            line-height: 1.6;
        }
        .dashboard-welcome .welcome-icon {
            font-size: 3rem;
            opacity: 0.2;
            position: absolute;
            top: 24px;
            right: 30px;
        }
        .dashboard-welcome .welcome-date {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,0.12);
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 14px;
        }

        /* ── Stat Cards ── */
        .stat-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 20px;
            margin-top: 28px;
        }
        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.04);
            transition: all 0.35s cubic-bezier(.25,.8,.25,1);
            cursor: pointer;
            text-decoration: none;
            display: block;
            color: inherit;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            border-radius: 16px 16px 0 0;
        }
        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 40px rgba(0,0,0,0.1);
            text-decoration: none;
            color: inherit;
        }
        .stat-card .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 16px;
            transition: transform 0.3s ease;
        }
        .stat-card:hover .stat-icon {
            transform: scale(1.1);
        }
        .stat-card .stat-number {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 4px;
        }
        .stat-card .stat-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #888;
        }
        .stat-card .stat-arrow {
            position: absolute;
            bottom: 20px;
            right: 20px;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateX(-8px);
        }
        .stat-card:hover .stat-arrow {
            opacity: 1;
            transform: translateX(0);
        }
        .stat-card .stat-bg-icon {
            position: absolute;
            bottom: -10px;
            right: -10px;
            font-size: 5rem;
            opacity: 0.04;
            transform: rotate(-15deg);
        }

        /* Card color variants */
        .stat-card.materi::before { background: linear-gradient(90deg, #2563eb, #3b82f6); }
        .stat-card.materi .stat-icon { background: rgba(37,99,235,0.1); color: #2563eb; }
        .stat-card.materi .stat-number { color: #2563eb; }
        .stat-card.materi .stat-arrow { background: rgba(37,99,235,0.1); color: #2563eb; }

        .stat-card.tugas::before { background: linear-gradient(90deg, #059669, #10b981); }
        .stat-card.tugas .stat-icon { background: rgba(5,150,105,0.1); color: #059669; }
        .stat-card.tugas .stat-number { color: #059669; }
        .stat-card.tugas .stat-arrow { background: rgba(5,150,105,0.1); color: #059669; }

        .stat-card.absensi::before { background: linear-gradient(90deg, #d97706, #f59e0b); }
        .stat-card.absensi .stat-icon { background: rgba(217,119,6,0.1); color: #d97706; }
        .stat-card.absensi .stat-number { color: #d97706; }
        .stat-card.absensi .stat-arrow { background: rgba(217,119,6,0.1); color: #d97706; }

        .stat-card.rapor::before { background: linear-gradient(90deg, #890A0A, #c0392b); }
        .stat-card.rapor .stat-icon { background: rgba(137,10,10,0.1); color: #890A0A; }
        .stat-card.rapor .stat-number { color: #890A0A; }
        .stat-card.rapor .stat-arrow { background: rgba(137,10,10,0.1); color: #890A0A; }

        /* ── Quick Links ── */
        .quick-links-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #2c2c2c;
            margin: 36px 0 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .quick-links-title i {
            color: #2563eb;
        }
        .quick-links-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 14px;
        }
        .quick-link-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.04);
            transition: all 0.3s ease;
            text-decoration: none;
            color: #2c2c2c;
            font-weight: 600;
            font-size: 0.88rem;
        }
        .quick-link-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(37,99,235,0.08);
            color: #2563eb;
            border-color: rgba(37,99,235,0.15);
            text-decoration: none;
        }
        .quick-link-item i {
            font-size: 1.1rem;
            color: #2563eb;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: rgba(37,99,235,0.06);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }
        .quick-link-item:hover i {
            background: #2563eb;
            color: #fff;
        }
      </style>

      {{-- Welcome Banner --}}
      <div class="dashboard-welcome">
          <i class="bi bi-person-workspace welcome-icon"></i>
          <div class="welcome-date">
              <i class="bi bi-calendar3"></i>
              {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
          </div>
          <h4><i class="bi bi-hand-thumbs-up me-2"></i>Selamat Datang, {{ Auth::user()->username }}!</h4>
          <p>Anda telah masuk sebagai <strong>{{ Auth::user()->role }}</strong>. Gunakan menu untuk mengelola pembelajaran, tugas, absensi, dan penilaian siswa.</p>
      </div>

      {{-- Statistic Cards --}}
      <div class="stat-cards-grid">
          {{-- Materi --}}
          <a href="{{ route('materi-pembelajaran.index') }}" class="stat-card materi">
              <div class="stat-icon">
                  <i class="bi bi-book"></i>
              </div>
              <div class="stat-number">{{ $materiCount ?? 0 }}</div>
              <div class="stat-label">Materi Pembelajaran</div>
              <div class="stat-arrow">
                  <i class="bi bi-arrow-right"></i>
              </div>
              <i class="bi bi-book stat-bg-icon"></i>
          </a>

          {{-- Tugas --}}
          <a href="{{ route('jadwal-tugas.index') }}" class="stat-card tugas">
              <div class="stat-icon">
                  <i class="bi bi-list-task"></i>
              </div>
              <div class="stat-number">{{ $tugasCount ?? 0 }}</div>
              <div class="stat-label">Jadwal Tugas</div>
              <div class="stat-arrow">
                  <i class="bi bi-arrow-right"></i>
              </div>
              <i class="bi bi-list-task stat-bg-icon"></i>
          </a>

          {{-- Absensi --}}
          <a href="{{ route('absensi.index') }}" class="stat-card absensi">
              <div class="stat-icon">
                  <i class="bi bi-check2-square"></i>
              </div>
              <div class="stat-number">{{ $absensiCount ?? 0 }}</div>
              <div class="stat-label">Absensi Siswa</div>
              <div class="stat-arrow">
                  <i class="bi bi-arrow-right"></i>
              </div>
              <i class="bi bi-check2-square stat-bg-icon"></i>
          </a>

          {{-- Rapor --}}
          <a href="{{ route('rapor.index') }}" class="stat-card rapor">
              <div class="stat-icon">
                  <i class="bi bi-journal-check"></i>
              </div>
              <div class="stat-number">{{ $raporCount ?? 0 }}</div>
              <div class="stat-label">Penilaian (Rapor)</div>
              <div class="stat-arrow">
                  <i class="bi bi-arrow-right"></i>
              </div>
              <i class="bi bi-journal-check stat-bg-icon"></i>
          </a>
      </div>

      {{-- Quick Links --}}
      <h5 class="quick-links-title"><i class="bi bi-lightning-fill"></i> Akses Cepat Guru</h5>
      <div class="quick-links-grid">
          <a href="{{ route('materi-pembelajaran.index') }}" class="quick-link-item">
              <i class="bi bi-book"></i> Materi Pembelajaran
          </a>
          <a href="{{ route('jadwal-tugas.index') }}" class="quick-link-item">
              <i class="bi bi-list-task"></i> Jadwal Tugas
          </a>
          <a href="{{ route('jadwal-pelajaran.index') }}" class="quick-link-item">
              <i class="bi bi-calendar"></i> Jadwal Pelajaran
          </a>
          <a href="{{ route('absensi.index') }}" class="quick-link-item">
              <i class="bi bi-check2-square"></i> Absensi
          </a>
          <a href="{{ route('rapor.index') }}" class="quick-link-item">
              <i class="bi bi-bar-chart"></i> Penilaian (Rapor)
          </a>
      </div>

    </main>
    <!-- End #main -->
@endsection
