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
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard', ['active' => 'dashboard']);
    });
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

    // CRUD Siswa
    Route::resource('siswa', SiswaController::class);
    Route::post('siswa/{siswa}/toggle-status', [SiswaController::class, 'toggleStatus'])->name('siswa.toggle-status');

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
    
});
Route::middleware('auth')->group(function () { 
    // Siswa
    Route::get('siswa/tugas', [TugasSiswaController::class,'indexSiswa'])->name('siswa-tugas.index');
    Route::get('siswa/tugas/{jadwal}/create', [TugasSiswaController::class,'create'])->name('siswa-tugas.create');
    Route::post('siswa/tugas/{jadwal}', [TugasSiswaController::class,'store'])->name('siswa-tugas.store');

    // Guru
    Route::get('guru/tugas', [TugasSiswaController::class,'indexGuru'])->name('guru.tugas.index');
    Route::get('guru/tugas/{submission}/edit', [TugasSiswaController::class,'edit'])->name('siswa-tugas.edit');
    Route::put('guru/tugas/{submission}', [TugasSiswaController::class,'update'])->name('siswa-tugas.update');
});


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'login_store'])->name('login_store');