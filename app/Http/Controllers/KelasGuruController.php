<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Pelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasGuruController extends Controller
{
    // ──────────────────────────────────────────────────
    //  INDEX — daftar assignment per kelas
    // ──────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Kelas::with(['waliKelas', 'guruMapel']);

        if ($request->filled('tahun_pelajaran')) {
            $query->where('tahun_pelajaran', $request->tahun_pelajaran);
        }
        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $kelas = $query->orderBy('tahun_pelajaran', 'desc')
                       ->orderBy('tingkat')->orderBy('nama_kelas')
                       ->paginate(15)->withQueryString();

        $tahunList = Kelas::select('tahun_pelajaran')->distinct()
                          ->orderByDesc('tahun_pelajaran')->pluck('tahun_pelajaran');

        $active = 'map_kelas_guru';
        return view('admin.kelas-guru.index', compact('kelas', 'tahunList', 'active'));
    }

    // ──────────────────────────────────────────────────
    //  SHOW — detail assignment satu kelas
    // ──────────────────────────────────────────────────
    public function show(Kelas $kelas)
    {
        $kelas->load(['waliKelas', 'guruMapel']);

        $guruList     = Guru::aktif()->orderBy('nama_lengkap')->get();
        $pelajaranList = Pelajaran::aktif()
            ->untukTingkat($kelas->tingkat)
            ->orderBy('nama_pelajaran')->get();

        // Guru yang sudah jadi guru mapel di kelas ini, indexed by pelajaran_id
        $mapelExisting = DB::table('kelas_guru')
            ->where('kelas_id', $kelas->id)
            ->where('jabatan', 'guru_mapel')
            ->get()->keyBy('pelajaran_id');
        $active = 'map_kelas_guru';

        return view('admin.kelas-guru.show', compact(
            'kelas', 'guruList', 'pelajaranList', 'mapelExisting', 'active'
        ));
    }

    // ──────────────────────────────────────────────────
    //  SET WALI KELAS
    // ──────────────────────────────────────────────────
    public function setWaliKelas(Request $request, Kelas $kelas)
    {
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
        ], ['guru_id.required' => 'Pilih guru wali kelas.']);

        DB::transaction(function () use ($request, $kelas) {
            // Hapus wali kelas lama
            DB::table('kelas_guru')
                ->where('kelas_id', $kelas->id)
                ->where('jabatan', 'wali_kelas')
                ->delete();

            // Pasang wali kelas baru
            DB::table('kelas_guru')->insert([
                'kelas_id'   => $kelas->id,
                'guru_id'    => $request->guru_id,
                'jabatan'    => 'wali_kelas',
                'pelajaran_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return back()->with('success', 'Wali kelas berhasil ditetapkan.');
    }

    // ──────────────────────────────────────────────────
    //  REMOVE WALI KELAS
    // ──────────────────────────────────────────────────
    public function removeWaliKelas(Kelas $kelas)
    {
        DB::table('kelas_guru')
            ->where('kelas_id', $kelas->id)
            ->where('jabatan', 'wali_kelas')
            ->delete();

        return back()->with('success', 'Wali kelas berhasil dihapus.');
    }

    // ──────────────────────────────────────────────────
    //  SET GURU MAPEL (satu pelajaran)
    // ──────────────────────────────────────────────────
    public function setGuruMapel(Request $request, Kelas $kelas)
    {
        $request->validate([
            'guru_id'      => 'required|exists:guru,id',
            'pelajaran_id' => 'required|exists:pelajaran,id',
        ], [
            'guru_id.required'      => 'Pilih guru.',
            'pelajaran_id.required' => 'Pilih pelajaran.',
        ]);

        // Upsert: update jika pelajaran sudah ada, insert jika belum
        DB::table('kelas_guru')->updateOrInsert(
            [
                'kelas_id'     => $kelas->id,
                'pelajaran_id' => $request->pelajaran_id,
                'jabatan'      => 'guru_mapel',
            ],
            [
                'guru_id'    => $request->guru_id,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return back()->with('success', 'Guru mata pelajaran berhasil ditetapkan.');
    }

    // ──────────────────────────────────────────────────
    //  REMOVE GURU MAPEL (satu pelajaran)
    // ──────────────────────────────────────────────────
    public function removeGuruMapel(Request $request, Kelas $kelas)
    {
        $request->validate([
            'pelajaran_id' => 'required|exists:pelajaran,id',
        ]);

        DB::table('kelas_guru')
            ->where('kelas_id', $kelas->id)
            ->where('pelajaran_id', $request->pelajaran_id)
            ->where('jabatan', 'guru_mapel')
            ->delete();

        return back()->with('success', 'Guru mata pelajaran berhasil dihapus.');
    }

    // ──────────────────────────────────────────────────
    //  SYNC SEMUA GURU MAPEL (bulk assign dari form)
    // ──────────────────────────────────────────────────
    public function syncGuruMapel(Request $request, Kelas $kelas)
    {
        $request->validate([
            'mapel'               => 'required|array',
            'mapel.*.pelajaran_id'=> 'required|exists:pelajaran,id',
            'mapel.*.guru_id'     => 'required|exists:guru,id',
        ]);

        DB::transaction(function () use ($request, $kelas) {
            // Hapus semua guru mapel lama
            DB::table('kelas_guru')
                ->where('kelas_id', $kelas->id)
                ->where('jabatan', 'guru_mapel')
                ->delete();

            // Insert baru
            $rows = collect($request->mapel)->map(fn($item) => [
                'kelas_id'     => $kelas->id,
                'guru_id'      => $item['guru_id'],
                'jabatan'      => 'guru_mapel',
                'pelajaran_id' => $item['pelajaran_id'],
                'created_at'   => now(),
                'updated_at'   => now(),
            ])->toArray();

            DB::table('kelas_guru')->insert($rows);
        });

        return back()->with('success', 'Mapping guru mata pelajaran berhasil disimpan.');
    }
}