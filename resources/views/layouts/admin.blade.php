<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Dashboard</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logo.png') }}" rel="icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="{{ asset('NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('NiceAdmin/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('NiceAdmin/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('NiceAdmin/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet" />
    <link href="{{ asset('NiceAdmin/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet" />
    <link href="{{ asset('NiceAdmin/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet" />
    <link href="{{ asset('NiceAdmin/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Template Main CSS File -->
    <link href="{{ asset('NiceAdmin/assets/css/style.css') }}" rel="stylesheet" />
    <!-- Admin Modern Override -->
    <link rel="stylesheet" href="{{ asset('assets/css/admin-modern.css') }}" />
    <link rel="stylesheet" href="sweetalert2.min.css">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Jul 27 2023 with Bootstrap v5.3.1
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

  <style>
    .sidebar-nav .nav-content {
      padding-left: 15px;
    }

    .sidebar-nav .nav-content .nav-content {
      padding-left: 20px;
    }
  </style>
  </head>

  <body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
      <div class="d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
          <img src="{{ asset('assets/img/logo.png') }}"  alt="" class="ms-3" style="transform: scale(1.5);" />
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
      </div>
      <!-- End Logo -->

      <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
          <li class="nav-item d-block d-lg-none">
            <a class="nav-link nav-icon search-bar-toggle" href="#">
              <i class="bi bi-search"></i>
            </a>
          </li>
          <!-- End Search Icon-->

          <li class="nav-item dropdown pe-3">
            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
              <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->username }}</span> </a
            ><!-- End Profile Iamge Icon -->

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
              <li class="dropdown-header">
                <h6>{{ Auth::user()->username ?? ''}}</h6>
                <span>{{ Auth::user()->role }}</span>
              </li>
              <li>
                <hr class="dropdown-divider" />
              </li>

              <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.index') }}">
                  <i class="bi bi-person"></i>
                  <span>My Profile</span>
                </a>
              </li>
              <li>
                <hr class="dropdown-divider" />
              </li>
              <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                  <i class="bi bi-box-arrow-right"></i>
                  <span>Sign Out</span>
                </a>
              </li>
            </ul>
            <!-- End Profile Dropdown Items -->
          </li>
          <!-- End Profile Nav -->
        </ul>
      </nav>
      <!-- End Icons Navigation -->
    </header>
    <!-- End Header -->
<!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
      <ul class="sidebar-nav" id="sidebar-nav">
        @if(Auth::user()->role == 'Admin')
        <li class="nav-heading">Menu Admin</li>
        <li class="nav-item">
          <a class="nav-link {{ (isset($active) && $active == 'dashboard_admin') ? '' : 'collapsed' }}" href="/admin/dashboard">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <!-- End Dashboard Nav -->

        <li class="nav-heading">Setting Umum</li>
        <li class="nav-item">
          <!-- Menu Level 1 -->
          <a class="nav-link collapsed" data-bs-target="#setting-profile" data-bs-toggle="collapse" href="#">
            <i class="bi bi-gear-wide-connected"></i>
            <span>Setting Profile</span>
            <i class="bi bi-chevron-down ms-auto"></i>
          </a>

          <ul id="setting-profile" class="nav-content collapse" data-bs-parent="#sidebar-nav">

            <!-- Sub Menu Level 2 -->
            <li class="nav-item">
              <a class="nav-link collapsed" href="{{ route('tentang_kami.index') }}">
                <i class="bi bi-circle"></i>
                <span>Tentang Kami</span>
                <i class="bi bi-chevron-down ms-auto"></i>
              </a>
            </li>

            <!-- Sub Menu Level 2 -->
            <li class="nav-item">
              <a class="nav-link {{ $active == 'struktur' ? '' : 'collapsed' }}" href="{{ route('struktur.index') }}">
              {{-- <a class="nav-link collapsed" href=""> --}}
                <i class="bi bi-circle"></i>
                <span>Struktur Organisasi</span>
                <i class="bi bi-chevron-down ms-auto"></i>
              </a>
            </li>

            <!-- Sub Menu -->
            <li class="nav-item">
              <a class="nav-link {{ $active == 'fasilitas' ? '' : 'collapsed' }}" href="{{ route('fasilitas.index') }}">
                <i class="bi bi-circle"></i>
                <span>Fasilitas Sekolah</span>
              </a>
            </li>

          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ $active == 'berita' ? '' : 'collapsed' }}" href="{{ route('berita.index') }}">
            <i class="bi bi-globe"></i>
            <span>Berita</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ $active == 'kurikulum' ? '' : 'collapsed' }}" href="{{ route('kurikulum.index') }}">
            <i class="bi bi-journals"></i>
            <span>Informasi Kurikulum</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ $active == 'prestasi' ? '' : 'collapsed' }}" href="{{ route('prestasi.index') }}">
            <i class="bi bi-trophy-fill"></i>
            <span>Prestasi</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ $active == 'kontak' ? '' : 'collapsed' }}" href="{{ route('kontak.index') }}">
            <i class="bi bi-telephone"></i>
            <span>Kontak Kami</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ $active == 'kelas' ? '' : 'collapsed' }}" href="{{ route('kelas.index') }}">
            <i class="bi bi-house-add"></i>
            <span>Kelas</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ $active == 'pelajaran' ? '' : 'collapsed' }}" href="{{ route('pelajaran.index') }}">
            <i class="bi bi-journal-text"></i>
            <span>Pelajaran</span>
          </a>
        </li>

        <ul class="sidebar-nav" id="sidebar-nav">

        <!-- ================= SETTING GURU ================= -->
        <li class="nav-heading">Setting Guru dan Siswa</li>

        <li class="nav-item">
          <a class="nav-link {{ in_array($active, ['data_guru', 'map_kelas_guru']) ? '' : 'collapsed' }}" 
              data-bs-target="#guru-siswa" 
              data-bs-toggle="collapse" 
              href="#">
            <i class="bi bi-person-lines-fill"></i><span>Data Guru dan Siswa</span>
            <i class="bi bi-chevron-down ms-auto"></i>
          </a>

          <ul id="guru-siswa" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li class="">
              <a class="{{ $active == 'data_guru' ? '' : 'collapsed' }}" href="{{ route('guru.index') }}"><i class="bi bi-person"></i><span>Data Guru</span></a>
            </li>
            <li class="">
              <a class="{{ $active == 'map_kelas_guru' ? '' : 'collapsed' }}" href="{{ route('kelas-guru.index') }}"><i class="bi bi-person"></i><span>Map Guru Kelas</span></a>
            </li>
            <li class="">
              <a class="{{ $active == 'data_siswa' ? '' : 'collapsed' }}" href="{{ route('siswa.index') }}"><i class="bi bi-person"></i><span>Data Siswa</span></a>
            </li>
            <li class="">
              <a class="{{ $active == 'map_kelas_siswa' ? '' : 'collapsed' }}" href="{{ route('kelas-siswa.index') }}"><i class="bi bi-person"></i><span>Map Siswa Kelas</span></a>
            </li>
          </ul>
        </li>

        <!-- Materi Pembelajaran -->
        <li class="nav-item">
          <a class="nav-link {{ $active == 'materi_pelajaran' ? '' : 'collapsed' }}" data-bs-target="#guru-materi" data-bs-toggle="collapse" href="#">
            <i class="bi bi-journal"></i><span>Setting Materi Pembelajaran</span>
            <i class="bi bi-chevron-down ms-auto"></i>
          </a>

          <ul id="guru-materi" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li><a href="{{ route('materi-pembelajaran.index') }}"><i class="bi bi-circle"></i><span>Setting Materi Pembelajaran</span></a></li>
            <li><a href="{{ route('jadwal-tugas.index') }}"><i class="bi bi-circle"></i><span>Setting Jadwal Tugas</span></a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ $active == 'jadwal_pelajaran' ? '' : 'collapsed' }}" href="{{ route('jadwal-pelajaran.index') }}"><i class="bi bi-calendar"></i><span>Setting Jadwal Pelajaran</span></a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ $active == 'absensi' ? '' : 'collapsed' }}" href="{{ route('absensi.index') }}"><i class="bi bi-check2-square"></i><span>Setting Absensi</span></a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ $active == 'rapor' ? '' : 'collapsed' }}" href="{{ route('rapor.index') }}"><i class="bi bi-bar-chart"></i><span>Setting Penilaian</span></a>
        </li>
        @endif
        
        @if (Auth::user()->role == 'siswa')
        <li class="nav-heading">Menu Siswa</li>
        <li class="nav-item">
          <a class="nav-link {{ (isset($active) && $active == 'dashboard_siswa') ? '' : 'collapsed' }}" href="/admin/dashboard">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ $active == 'siswa_jadwal' ? '' : 'collapsed' }}" href="{{ route('siswa.jadwal-pelajaran') }}"><i class="bi bi-calendar"></i><span>Jadwal Pelajaran</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ $active == 'materi_pelajaran' ? '' : 'collapsed' }}" href="{{ route('materi-pembelajaran.index') }}"><i class="bi bi-book"></i><span>Materi Pelajaran</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ $active == 'siswa_rapor' ? '' : 'collapsed' }}" href="{{ route('siswa.rapor.index') }}"><i class="bi bi-journal-text"></i><span>Lihat Rapor</span></a>
        </li>
          <li class="nav-item">
            <a class="nav-link {{ $active == 'tugas_siswa' ? '' : 'collapsed' }}" href="{{ route('siswa-tugas.index') }}"><i class="bi bi-bar-chart"></i><span>Tugas</span></a>
          </li>
        @endif
        
        @if (Auth::user()->role == 'guru')
        <li class="nav-heading">Menu Guru</li>
        <li class="nav-item">
          <a class="nav-link {{ (isset($active) && $active == 'dashboard_guru') ? '' : 'collapsed' }}" href="/admin/dashboard">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
          </a>
        </li>

        <!-- Materi Pembelajaran -->
        <li class="nav-item">
          <a class="nav-link {{ $active == 'materi_pelajaran' ? '' : 'collapsed' }}" data-bs-target="#guru-materi" data-bs-toggle="collapse" href="#">
            <i class="bi bi-journal"></i><span>Setting Materi Pembelajaran</span>
            <i class="bi bi-chevron-down ms-auto"></i>
          </a>

          <ul id="guru-materi" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li><a href="{{ route('materi-pembelajaran.index') }}"><i class="bi bi-circle"></i><span>Setting Materi Pembelajaran</span></a></li>
            <li><a href="{{ route('jadwal-tugas.index') }}"><i class="bi bi-circle"></i><span>Setting Jadwal Tugas</span></a></li>
          </ul>
        </li>
          <li class="nav-item">
            <a class="nav-link {{ $active == 'absensi' ? '' : 'collapsed' }}" href="{{ route('absensi.index') }}"><i class="bi bi-check2-square"></i><span>Setting Absensi</span></a>
          </li>

          <li class="nav-item">
            <a class="nav-link {{ $active == 'rapor' ? '' : 'collapsed' }}" href="{{ route('rapor.index') }}"><i class="bi bi-bar-chart"></i><span>Setting Penilaian</span></a>
          </li>
        @endif
        
        @if (Auth::user()->role == 'Admin')
        <li class="nav-heading">Setting Menu Perpustakaan</li>
        <li class="nav-item">
          <a class="nav-link {{ isset($active) && $active == 'admin_perpus' ? '' : 'collapsed' }}" href="{{ route('admin-perpus.index') }}"><i class="bi bi-person-badge"></i><span>Kelola Admin Perpus</span></a>
        </li>
        @endif
        
        @if (Auth::user()->role == 'Admin Perpustakaan' || Auth::user()->role == 'Admin')
        <li class="nav-item">
          <a class="nav-link {{ $active == 'dashboard' ? '' : 'collapsed' }}" href="{{ route('perpustakaan.dashboard') }}"><i class="bi bi-grid"></i><span>Dashboard</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ $active == 'buku' ? '' : 'collapsed' }}" href="{{ route('perpustakaan.buku.index') }}"><i class="bi bi-book"></i><span>Data Buku</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ $active == 'peminjaman' ? '' : 'collapsed' }}" href="{{ route('perpustakaan.peminjaman.index') }}"><i class="bi bi-journal-text"></i><span>Data Peminjam</span></a>
        </li>
        @endif

        <!-- ================= SETTING SISWA ================= -->
         


        <li class="nav-heading">Pengaturan Akun</li>
        <li class="nav-item">
          <a class="nav-link {{ isset($active) && $active == 'pengaturan' ? '' : 'collapsed' }}" data-bs-target="#pengaturan-akun" data-bs-toggle="collapse" href="#">
            <i class="bi bi-gear"></i><span>Pengaturan</span>
            <i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="pengaturan-akun" class="nav-content collapse {{ isset($active) && $active == 'pengaturan' ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li>
              <a href="{{ route('password.edit') }}" class="{{ request()->routeIs('password.edit') ? 'active' : '' }}">
                <i class="bi bi-circle"></i><span>Ubah Password</span>
              </a>
            </li>
            <li>
              <a href="{{ route('logout') }}">
                <i class="bi bi-circle"></i><span>Logout</span>
              </a>
            </li>
          </ul>
        </li>
        <!-- End Pengaturan Menu -->
        <!-- End Login Page Nav -->
      </ul>
    </aside>
    <!-- End Sidebar-->
    @yield('content');


    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
    </footer>
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('NiceAdmin/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('NiceAdmin/assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('NiceAdmin/assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('NiceAdmin/assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('NiceAdmin/assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('NiceAdmin/assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('NiceAdmin/assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('NiceAdmin/assets/js/main.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    {{-- sweet alert  --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        if('{{ session('success') }}'){
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                showConfirmButton: true,
            });
        }
        if('{{ session('error') }}'){
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                showConfirmButton: true,
            });
        }
    </script>
    {{-- @stack('script') --}}
  </body>
</html>


