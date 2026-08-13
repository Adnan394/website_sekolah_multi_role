@extends('layouts.admin', ['active' => 'dashboard'])

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard Perpustakaan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row">
        <!-- Buku Card -->
        <div class="col-xxl-4 col-md-6">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">Data Buku</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-book"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $bukuCount }}</h6>
                  <span class="text-muted small pt-2 ps-1">Total Buku</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Peminjaman Card -->
        <div class="col-xxl-4 col-md-6">
          <div class="card info-card revenue-card">
            <div class="card-body">
              <h5 class="card-title">Peminjam Aktif</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-journal-text"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $peminjamCount }}</h6>
                  <span class="text-muted small pt-2 ps-1">Sedang Dipinjam</span>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>
</main>
@endsection
