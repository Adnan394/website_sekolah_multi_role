<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\JadwalTugas;
use App\Models\KelasSiswa;
use App\Models\Siswa;
use App\Models\TugasSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TugasSiswaController extends Controller
{
    // Daftar tugas untuk siswa
    // public function index()
    // {
    //     $tugas = JadwalTugas::published()->orderBy('tenggat_waktu')->get();
    //     $active = 'tugas_siswa';

    //     return view('admin.siswa.tugas.index', compact('tugas', 'active'));
    // }

    // Form upload tugas
    public function create(JadwalTugas $jadwal)
    {
        $siswa = Siswa::where('user_id', Auth::user()->id)->first();
        $submission = TugasSiswa::firstOrNew([
            'jadwal_tugas_id' => $jadwal->id,
            'siswa_id' => $siswa->id,
        ]);
        $active = 'tugas_siswa';

        return view('admin.siswa.tugas.create', compact('jadwal', 'submission', 'active'));
    }

    // Simpan/Upload tugas
    public function store(Request $request, JadwalTugas $jadwal)
    {
        try {
            $request->validate([
                'file_upload' => 'nullable|file|mimes:pdf,doc,docx,zip',
                'link_upload' => 'nullable|url',
            ]);

            $siswaId = Siswa::where('user_id', Auth::user()->id)->first()->id;

            $submission = TugasSiswa::updateOrCreate(
                ['jadwal_tugas_id' => $jadwal->id, 'siswa_id' => $siswaId],
                ['status' => 'Sudah Mengumpulkan']
            );

            if ($request->hasFile('file_upload')) {
                $filePath = $request->file('file_upload')->store('tugas_siswa');
                $submission->file_upload = $filePath;
            }

            if ($request->link_upload) {
                $submission->link_upload = $request->link_upload;
            }

            $submission->save();

            return redirect()->route('siswa-tugas.index')->with('success','Tugas berhasil dikumpulkan.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Tugas gagal dikumpulkan.');
        }
        
    }

    // Guru menilai tugas
    public function edit(TugasSiswa $submission)
    {
        $active = 'tugas_siswa';

        return view('admin.guru.tugas.edit', compact('submission', 'active'));
    }

    public function update(Request $request, TugasSiswa $submission)
    {
        $request->validate([
            'nilai' => 'required|integer|min:0|max:' . $submission->jadwalTugas->nilai_maksimal,
            'komentar' => 'nullable|string|max:255',
        ]);

        $submission->update([
            'nilai' => $request->nilai,
            'komentar' => $request->komentar,
            'status' => 'Dinilai',
        ]);

        return redirect()->back()->with('success','Tugas berhasil dinilai.');
    }

    public function indexSiswa()
    {
        $siswa = Siswa::where('user_id', Auth::user()->id)->first();
        $kelasSiswa = KelasSiswa::where('siswa_id', $siswa->id)->first();

        // Ambil semua tugas untuk kelas siswa yang aktif dan sudah publish
        $tugas = \App\Models\JadwalTugas::where('kelas_id', $kelasSiswa->kelas_id ?? 0)
                    ->published()
                    ->orderBy('tenggat_waktu')
                    ->get();

        // Ambil status pengumpulan siswa
        $submissions = \App\Models\TugasSiswa::where('siswa_id', $siswa->id)
                        ->get()
                        ->keyBy('jadwal_tugas_id');
        $active = 'tugas_siswa';

        return view('admin.siswa.tugas.index', compact('tugas', 'submissions', 'active'));
    }

    public function indexGuru()
    {
        if(Auth::user()->role == 'Admin') {
            // Ambil semua tugas yang dibuat oleh guru
            $tugas = \App\Models\JadwalTugas::orderBy('tenggat_waktu')
                        ->get();
        }else {
            $guru = Guru::where('user_id', Auth::user()->id)->first();
    
            // Ambil semua tugas yang dibuat oleh guru
            $tugas = \App\Models\JadwalTugas::where('guru_id', $guru->id)
                        ->orderBy('tenggat_waktu')
                        ->get();
        }
        $active = 'tugas_siswa';

        return view('admin.guru.tugas.index', compact('tugas', 'active'));
    }
}