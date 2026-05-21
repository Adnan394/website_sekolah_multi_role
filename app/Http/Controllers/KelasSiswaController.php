<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasSiswaController extends Controller
{
    // ──────────────────────────────────────────────────
    //  INDEX — Daftar kelas untuk dipilih manajemen siswanya
    // ──────────────────────────────────────────────────
    public function index(Request $request)
    {
        // Query dasar
        $query = Kelas::withCount('siswa'); // jumlah siswa terdaftar

        // Filter Tahun Pelajaran
        if ($request->filled('tahun_pelajaran')) {
            $query->where('tahun_pelajaran', $request->tahun_pelajaran);
        }

        // Filter Tingkat
        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        // Filter Semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        // Order dan paginate
        $kelas = $query->orderBy('tahun_pelajaran', 'desc')
                       ->orderBy('tingkat')
                       ->orderBy('nama_kelas')
                       ->paginate(15)
                       ->withQueryString();

        // Ambil daftar tahun untuk filter dropdown
        $tahunList = Kelas::select('tahun_pelajaran')->distinct()
                          ->orderByDesc('tahun_pelajaran')
                          ->pluck('tahun_pelajaran');

        $active = 'map_kelas_siswa';

        return view('admin.kelas-siswa.index', compact('kelas', 'tahunList', 'active'));
    }

    // ──────────────────────────────────────────────────
    //  CREATE — Tampilkan form untuk menambahkan siswa ke kelas
    // ──────────────────────────────────────────────────
    public function create(Kelas $kelas)
    {
        // Ambil siswa aktif yang belum terdaftar di kelas manapun pada tahun & semester yang sama
        $siswaTersedia = Siswa::aktif()->whereDoesntHave('kelas', function($q) use ($kelas) {
            $q->where('tahun_pelajaran', $kelas->tahun_pelajaran)
            ->where('semester', $kelas->semester);
        })->orderBy('nama_lengkap')->get();

        $active = 'map_kelas_siswa';

        // Kirim ke view create.blade.php
        return view('admin.kelas-siswa.create', compact('kelas', 'siswaTersedia', 'active'));
    }

    // ──────────────────────────────────────────────────
    //  SHOW — Daftar siswa di dalam satu kelas tertentu
    // ──────────────────────────────────────────────────
    public function show(Kelas $kelas)
    {
        $kelas->load(['siswa' => function($q) {
            $q->withPivot('nomor_absen', 'status');
        }]);

        $siswaTersedia = Siswa::aktif()->whereDoesntHave('kelas', function($q) use ($kelas) {
            $q->where('tahun_pelajaran', $kelas->tahun_pelajaran)
            ->where('semester', $kelas->semester);
        })->orderBy('nama_lengkap')->get();

        $active = 'map_kelas_siswa';

        return view('admin.kelas-siswa.show', compact('kelas', 'siswaTersedia', 'active'));
    }

    // ──────────────────────────────────────────────────
    //  STORE — Menambahkan siswa ke dalam kelas (Attach)
    // ──────────────────────────────────────────────────2882020
    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'siswa_id' => 'required|exists:siswa,id',
            'nomor_absen' => 'nullable|string|max:5',
        ]);

        $kelas = Kelas::findOrFail($request->kelas_id);

        // Cek kapasitas
        if ($kelas->siswa()->count() >= $kelas->kapasitas) {
            return back()->with('error', 'Gagal! Kapasitas kelas sudah penuh.');
        }

        try {
            $kelas->siswa()->attach($request->siswa_id, [
                'nomor_absen' => $request->nomor_absen,
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('kelas-siswa.detail', $kelas->id)->with('success', 'Siswa berhasil ditambahkan ke kelas.');
        } catch (\Exception $e) {
            return redirect()->route('kelas-siswa.detail', $kelas->id)->with('error', 'Siswa mungkin sudah terdaftar di kelas ini.');
        }
    }

    // ──────────────────────────────────────────────────
    //  EDIT — Form edit status/absen siswa di kelas
    // ──────────────────────────────────────────────────
    public function edit(Kelas $kelas, Siswa $siswa)
    {
        $pivotData = DB::table('kelas_siswa')
                    ->where('kelas_id', $kelas->id)
                    ->where('siswa_id', $siswa->id)
                    ->first();

        $active = 'map_kelas_siswa';
        return view('admin.kelas-siswa.edit', compact('kelas', 'siswa', 'pivotData', 'active'));
    }

    // ──────────────────────────────────────────────────
    //  UPDATE — Update data pivot (nomor absen / status)
    // ──────────────────────────────────────────────────
    public function update(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'siswa_id' => 'required|exists:siswa,id',
            'nomor_absen' => 'nullable|string|max:5',
            'status' => 'required|in:Aktif,Lulus,Pindah,Keluar',
        ]);

        $kelas = Kelas::findOrFail($request->kelas_id);
        $kelas->siswa()->updateExistingPivot($request->siswa_id, [
            'nomor_absen' => $request->nomor_absen,
            'status' => $request->status,
            'updated_at' => now(),
        ]);

        return redirect()->route('kelas-siswa.detail', $kelas->id)
                        ->with('success', 'Data siswa di kelas berhasil diperbarui.');
    }

    // ──────────────────────────────────────────────────
    //  DESTROY — Mengeluarkan siswa dari kelas (Detach)
    // ──────────────────────────────────────────────────
    public function destroy(Request $request, $data)
    {
        $pivotData = DB::table('kelas_siswa')
                    ->where('kelas_id', $request->kelas_id)
                    ->where('siswa_id', $request->siswa_id)
                    ->delete();

        return back()->with('success', 'Siswa berhasil hapus dari kelas.');
    }
}