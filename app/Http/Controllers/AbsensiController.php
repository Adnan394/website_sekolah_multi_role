<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Admin,guru')->only(['store']);
    }
    // INDEX — daftar absensi per kelas + tanggal
    public function index(Request $request)
    {
        $query = Kelas::with('siswa');

        if ($request->filled('kelas_id')) {
            $query->where('id', $request->kelas_id);
        }

        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $kelas = $request->kelas_id ? Kelas::find($request->kelas_id) : null;

        $tanggal = $request->tanggal ?? date('Y-m-d');
        $jam_ke = $request->jam_ke ?? 1;

        $absensi = [];
        if ($kelas) {
            $absensi = Absensi::where('kelas_id', $kelas->id)
                ->where('tanggal', $tanggal)
                ->where('jam_ke', $jam_ke)
                ->get()
                ->keyBy('siswa_id');
        }
        $active = 'absensi';

        return view('admin.absensi.index', compact('kelasList', 'kelas', 'tanggal', 'absensi', 'active', 'jam_ke'));
    }

    // STORE / UPDATE — simpan absensi
    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required|date',
            'absensi' => 'required|array',
            'absensi.*.siswa_id' => 'required|exists:siswa,id',
            'absensi.*.status' => 'required|in:Belum Absen,Hadir,Sakit,Izin,Alfa',
            'absensi.*.keterangan' => 'nullable|string|max:255',
        ]);

        $kelas_id = $request->kelas_id;
        $tanggal = $request->tanggal;
        $jam_ke = $request->jam_ke ?? 1;

        DB::transaction(function () use ($request, $kelas_id, $tanggal, $jam_ke) {
            foreach ($request->absensi as $item) {
                Absensi::updateOrCreate(
                    [
                        'kelas_id' => $kelas_id,
                        'siswa_id' => $item['siswa_id'],
                        'tanggal'  => $tanggal,
                        'jam_ke'   => $jam_ke,
                    ],
                    [
                        'status' => $item['status'],
                        'keterangan' => $item['keterangan'] ?? null,
                        'created_by' => auth()->id(),
                    ]
                );
            }
        });

        return redirect()->back()->with('success', 'Absensi berhasil disimpan.');
    }
}
