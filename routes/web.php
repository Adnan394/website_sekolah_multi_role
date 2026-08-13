<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\FasilitasSekolahController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalPelajaranController;
use App\Http\Controllers\JadwalTugasController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KelasGuruController;
use App\Http\Controllers\KelasSiswaController;
use App\Http\Controllers\KontakKamiController;
use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\MateriPembelajaranController;
use App\Http\Controllers\PelajaranController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\StrukturOrganisasiController;
use App\Http\Controllers\TentangKamiController;
use App\Http\Controllers\TugasSiswaController;
use App\Http\Controllers\StorageController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () { 
    // Serve storage files via controller when public/storage symlink is not present
    Route::get('storage/files/{path}', [StorageController::class, 'show'])->where('path', '.*');

    // Siswa
    Route::get('siswa/tugas', [TugasSiswaController::class,'indexSiswa'])->name('siswa-tugas.index');
    Route::get('siswa/tugas/{jadwal}/create', [TugasSiswaController::class,'create'])->name('siswa-tugas.create');
    Route::post('siswa/tugas/{jadwal}', [TugasSiswaController::class,'store'])->name('siswa-tugas.store');

    Route::middleware('role:siswa')->group(function () {
        Route::get('admin/siswa/jadwal-pelajaran', [JadwalPelajaranController::class, 'gridSiswa'])->name('siswa.jadwal-pelajaran');
        Route::get('admin/siswa/materi-pembelajaran', [MateriPembelajaranController::class, 'indexSiswa'])->name('siswa.materi-pembelajaran.index');
        Route::get('admin/siswa/rapor', [\App\Http\Controllers\RaporPenilaianController::class, 'indexSiswa'])->name('siswa.rapor.index');
        Route::get('admin/siswa/rapor/{rapor}', [\App\Http\Controllers\RaporPenilaianController::class, 'showSiswa'])->name('siswa.rapor.show');
        Route::get('admin/siswa/rapor/{rapor}/download', [\App\Http\Controllers\RaporPenilaianController::class, 'downloadPdfSiswa'])->name('siswa.rapor.download');
    });

    // Guru
    Route::get('guru/tugas', [TugasSiswaController::class,'indexGuru'])->name('guru.tugas.index');
    Route::get('guru/tugas/{jadwal}/submissions', [TugasSiswaController::class, 'showSubmissions'])->name('guru.tugas.submissions');
    Route::get('guru/tugas/{submission}/edit', [TugasSiswaController::class,'edit'])->name('siswa-tugas.edit');
    Route::put('guru/tugas/{submission}', [TugasSiswaController::class,'update'])->name('siswa-tugas.update');

    // Password
    Route::get('password/change', [\App\Http\Controllers\PasswordController::class, 'edit'])->name('password.edit');
    Route::put('password/change', [\App\Http\Controllers\PasswordController::class, 'update'])->name('password.update');
});
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;
        
        if ($role == 'guru') {
            return view('guru.dashboard', [
                'active' => 'dashboard_guru',
                'materiCount' => \App\Models\MateriPembelajaran::count(),
                'tugasCount' => \App\Models\JadwalTugas::count(),
                'absensiCount' => \App\Models\Absensi::count(),
                'raporCount' => \App\Models\RaporPenilaian::count(),
            ]);
        }

        if ($role == 'siswa') {
            return view('siswa.dashboard', [
                'active' => 'dashboard_siswa',
                'jadwalCount' => \App\Models\JadwalPelajaran::count(),
                'materiCount' => \App\Models\MateriPembelajaran::count(),
                'raporCount' => \App\Models\RaporPenilaian::count(),
                'tugasCount' => \App\Models\TugasSiswa::count(),
            ]);
        }

        return view('dashboard', [
            'active' => 'dashboard_admin',
            'guruCount' => \App\Models\Guru::count(),
            'siswaCount' => \App\Models\Siswa::count(),
            'kelasCount' => \App\Models\Kelas::count(),
            'pelajaranCount' => \App\Models\Pelajaran::count(),
        ]);
    })->name('dashboard');
    
    // Profile
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');

    Route::resource('tentang_kami', TentangKamiController::class);
    Route::resource('struktur', StrukturOrganisasiController::class);
    Route::resource('fasilitas', FasilitasSekolahController::class);
    Route::resource('prestasi', PrestasiController::class);
    Route::resource('kurikulum', KurikulumController::class);
    Route::resource('berita', BeritaController::class);
    Route::resource('kontak', KontakKamiController::class);

    Route::resource('kelas', KelasController::class)->parameters(['kelas' => 'kelas']);
    Route::patch('kelas/{id}/restore', [KelasController::class, 'restore'])->name('kelas.restore');
    Route::delete('kelas/{id}/force-delete', [KelasController::class, 'forceDelete'])->name('kelas.force-delete');
    Route::patch('kelas/{kelas}/toggle-status', [KelasController::class, 'toggleStatus'])->name('kelas.toggle-status');

    Route::resource('pelajaran', PelajaranController::class);
    Route::patch('pelajaran/{id}/restore', [PelajaranController::class, 'restore'])->name('pelajaran.restore');
    Route::delete('pelajaran/{id}/force-delete', [PelajaranController::class, 'forceDelete'])->name('pelajaran.force-delete');

    Route::resource('guru', GuruController::class)->parameters(['guru' => 'guru']);
    Route::patch('guru/{guru}/toggle-status', [GuruController::class, 'toggleStatus'])->name('guru.toggle-status');
    Route::patch('guru/{id}/restore', [GuruController::class, 'restore'])->name('guru.restore');
    Route::delete('guru/{id}/force-delete', [GuruController::class, 'forceDelete'])->name('guru.force-delete');

    Route::get('kelas-guru', [KelasGuruController::class, 'index'])->name('kelas-guru.index');
    Route::get('kelas-guru/{kelas}', [KelasGuruController::class, 'show'])->name('kelas-guru.show');
    Route::post('kelas-guru/{kelas}/wali-kelas', [KelasGuruController::class, 'setWaliKelas'])->name('kelas-guru.set-wali-kelas');
    Route::delete('kelas-guru/{kelas}/wali-kelas', [KelasGuruController::class, 'removeWaliKelas'])->name('kelas-guru.remove-wali-kelas');
    Route::post('kelas-guru/{kelas}/sync-mapel', [KelasGuruController::class, 'syncGuruMapel'])->name('kelas-guru.sync-guru-mapel');
    Route::post('kelas-guru/{kelas}/mapel', [KelasGuruController::class, 'setGuruMapel'])->name('kelas-guru.set-guru-mapel');
    Route::delete('kelas-guru/{kelas}/mapel', [KelasGuruController::class, 'removeGuruMapel'])->name('kelas-guru.remove-guru-mapel');

    // Data Siswa
    Route::resource('siswa', \App\Http\Controllers\SiswaController::class);
    
    // Kelola Admin Perpustakaan
    Route::resource('admin-perpus', \App\Http\Controllers\AdminPerpusController::class);

    // Plotting Siswa ke Kelas (Mapping)
    Route::resource('kelas-siswa', KelasSiswaController::class);
    Route::get('kelas-siswa/kelas/{kelas}', [KelasSiswaController::class, 'show'])->name('kelas-siswa.detail');
    Route::get('kelas-siswa/kelas/{kelas}/siswa/{siswa}/edit', [KelasSiswaController::class, 'edit'])
     ->name('kelas-siswa.ubah');
    // Route::delete('kelas-siswa/{kelas}/{siswa}/detach', [KelasSiswaController::class, 'destroy'])->name('kelas-siswa.destroy');
    
    // ── Materi Pembelajaran ───────────────────────────────────
    Route::resource('materi-pembelajaran', MateriPembelajaranController::class)->parameters(['materi-pembelajaran' => 'materiPembelajaran']);
    Route::patch('materi-pembelajaran/{materiPembelajaran}/toggle-publish',[MateriPembelajaranController::class, 'togglePublish'])->name('materi-pembelajaran.toggle-publish');

    // ── Jadwal Tugas ──────────────────────────────────────────
    Route::resource('jadwal-tugas', JadwalTugasController::class)->parameters(['jadwal-tugas' => 'jadwalTugas']);
    Route::patch('jadwal-tugas/{jadwalTugas}/toggle-publish',[JadwalTugasController::class, 'togglePublish'])->name('jadwal-tugas.toggle-publish');

    // ── Jadwal Pelajaran ──────────────────────────────────────
    Route::resource('jadwal-pelajaran', JadwalPelajaranController::class)->parameters(['jadwal-pelajaran' => 'jadwalPelajaran']);
    Route::get('jadwal-pelajaran-grid', [JadwalPelajaranController::class, 'grid'])->name('jadwal-pelajaran.grid');

    // ── Absesnsi ──────────────────────────────────────
    Route::resource('absensi', AbsensiController::class);
    // Rapor penilaian
    Route::get('rapor', [\App\Http\Controllers\RaporPenilaianController::class, 'index'])->name('rapor.index');
    Route::get('rapor/create', [\App\Http\Controllers\RaporPenilaianController::class, 'create'])->name('rapor.create');
    Route::post('rapor', [\App\Http\Controllers\RaporPenilaianController::class, 'store'])->name('rapor.store');
    Route::get('rapor/{rapor}', [\App\Http\Controllers\RaporPenilaianController::class, 'show'])->name('rapor.show');
    Route::get('rapor/{rapor}/download', [\App\Http\Controllers\RaporPenilaianController::class, 'downloadPdf'])->name('rapor.download');
    Route::delete('rapor/{rapor}', [\App\Http\Controllers\RaporPenilaianController::class, 'destroy'])->name('rapor.destroy');
    Route::post('rapor/{rapor}/items', [\App\Http\Controllers\RaporPenilaianController::class, 'storeItem'])->name('rapor.items.store');
    
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/berita/{slug}', [BeritaController::class, 'showPublic'])->name('berita.show.public');

Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'login_store'])->name('login_store');

// Routes untuk Admin Perpustakaan
Route::get('login-perpustakaan', [\App\Http\Controllers\Perpustakaan\AuthController::class, 'login'])->name('login_perpustakaan');
Route::post('login-perpustakaan', [\App\Http\Controllers\Perpustakaan\AuthController::class, 'login_store'])->name('login_perpustakaan.store');

Route::middleware('auth')->prefix('perpustakaan')->name('perpustakaan.')->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\Perpustakaan\DashboardController::class, 'index'])->name('dashboard');
    
    // Buku Export
    Route::get('buku/export', [\App\Http\Controllers\Perpustakaan\BukuController::class, 'exportExcel'])->name('buku.export');
    
    // CRUD Buku & Peminjaman
    Route::resource('buku', \App\Http\Controllers\Perpustakaan\BukuController::class);
    Route::resource('peminjaman', \App\Http\Controllers\Perpustakaan\PeminjamanBukuController::class);
});