<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\Pelajaran;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class JadwalPelajaranController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('role:Admin,guru')->only(['create', 'store', 'edit', 'update', 'destroy', 'grid']);
    //     $this->middleware('role:Admin,guru,siswa')->only(['gridSiswa']);
    // }

    public function gridSiswa(Request $request)
    {
        $siswa = Siswa::where('user_id', Auth::id())->with('kelas')->first();
        $kelas = $siswa?->kelas->first();

        $tahun = $request->tahun_pelajaran ?? $kelas?->tahun_pelajaran ?? Kelas::max('tahun_pelajaran');
        $semester = $request->semester ?? $kelas?->semester ?? 'Ganjil';

        $jadwal = JadwalPelajaran::with(['pelajaran', 'guru'])
            ->when($kelas?->id, fn($q) => $q->where('kelas_id', $kelas->id))
            ->where('tahun_pelajaran', $tahun)
            ->where('semester', $semester)
            ->get()
            ->groupBy('hari');

        $kelasList = Kelas::aktif()->orderBy('tingkat')->orderBy('nama_kelas')->get();
        $tahunList = Kelas::select('tahun_pelajaran')->distinct()->orderByDesc('tahun_pelajaran')->pluck('tahun_pelajaran');
        $hariList  = JadwalPelajaran::listHari();

        $active = 'siswa_jadwal';
        $isStudent = true;
        return view('admin.jadwal-pelajaran.grid', compact(
            'jadwal', 'kelas', 'kelasList', 'tahunList', 'hariList', 'tahun', 'semester', 'active', 'isStudent'
        ));
    }
    public function index(Request $request)
    {
        $query = JadwalPelajaran::with(['kelas', 'pelajaran', 'guru']);

        if ($request->filled('kelas_id'))        $query->where('kelas_id', $request->kelas_id);
        if ($request->filled('hari'))            $query->where('hari', $request->hari);
        if ($request->filled('tahun_pelajaran')) $query->where('tahun_pelajaran', $request->tahun_pelajaran);
        if ($request->filled('semester'))        $query->where('semester', $request->semester);

        $jadwal       = $query->orderByRaw("FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
                              ->orderBy('jam_ke')
                              ->paginate(20)->withQueryString();

        $kelasList    = Kelas::aktif()->orderBy('nama_kelas')->get();
        $tahunList    = Kelas::select('tahun_pelajaran')->distinct()
                            ->orderByDesc('tahun_pelajaran')->pluck('tahun_pelajaran');

        $active = 'jadwal_pelajaran';
        return view('admin.jadwal-pelajaran.index', compact('jadwal', 'kelasList', 'tahunList', 'active'));
    }

    // Tampilan grid per kelas
    public function grid(Request $request)
    {
        $kelasId = $request->kelas_id;
        $tahun   = $request->tahun_pelajaran ?? Kelas::max('tahun_pelajaran');
        $semester = $request->semester ?? 'Ganjil';

        $kelas = $kelasId ? Kelas::findOrFail($kelasId) : null;

        $jadwal = JadwalPelajaran::with(['pelajaran', 'guru'])
            ->when($kelasId, fn($q) => $q->where('kelas_id', $kelasId))
            ->where('tahun_pelajaran', $tahun)
            ->where('semester', $semester)
            ->get()
            ->groupBy('hari');

        $kelasList = Kelas::aktif()->orderBy('tingkat')->orderBy('nama_kelas')->get();
        $tahunList = Kelas::select('tahun_pelajaran')->distinct()->orderByDesc('tahun_pelajaran')->pluck('tahun_pelajaran');
        $hariList  = JadwalPelajaran::listHari();

        $active = 'jadwal_pelajaran';
        return view('admin.jadwal-pelajaran.grid', compact(
            'jadwal', 'kelas', 'kelasList', 'tahunList', 'hariList', 'tahun', 'semester', 'active'
        ));
    }

    public function create()
    {
        return view('admin.jadwal-pelajaran.create', [
            'kelasList'    => Kelas::aktif()->orderBy('tingkat')->orderBy('nama_kelas')->get(),
            'pelajaranList'=> Pelajaran::aktif()->orderBy('nama_pelajaran')->get(),
            'guruList'     => Guru::aktif()->orderBy('nama_lengkap')->get(),
            'hariList'     => JadwalPelajaran::listHari(),
            'semesterList' => JadwalPelajaran::listSemester(),
            'active'       => 'jadwal_pelajaran',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->rules(), $this->messages());

        JadwalPelajaran::create($request->only([
            'kelas_id', 'pelajaran_id', 'guru_id',
            'hari', 'jam_ke', 'jam_mulai', 'jam_selesai',
            'ruangan', 'tahun_pelajaran', 'semester', 'is_active',
        ]) + ['is_active' => $request->boolean('is_active', true)]);

        return redirect()->route('jadwal-pelajaran.index')
                         ->with('success', 'Jadwal pelajaran berhasil ditambahkan.');
    }

    public function show(JadwalPelajaran $jadwalPelajaran)
    {
        $jadwalPelajaran->load(['kelas', 'pelajaran', 'guru']);
        return view('admin.jadwal-pelajaran.show', ['jadwal' => $jadwalPelajaran, 'active' => 'jadwal_pelajaran']);
    }

    public function edit(JadwalPelajaran $jadwalPelajaran)
    {
        return view('admin.jadwal-pelajaran.edit', [
            'jadwal'       => $jadwalPelajaran,
            'kelasList'    => Kelas::aktif()->orderBy('tingkat')->orderBy('nama_kelas')->get(),
            'pelajaranList'=> Pelajaran::aktif()->orderBy('nama_pelajaran')->get(),
            'guruList'     => Guru::aktif()->orderBy('nama_lengkap')->get(),
            'hariList'     => JadwalPelajaran::listHari(),
            'semesterList' => JadwalPelajaran::listSemester(),
            'active'       => 'jadwal_pelajaran',
        ]);
    }

    public function update(Request $request, JadwalPelajaran $jadwalPelajaran)
    {
        $request->validate($this->rules($jadwalPelajaran->id), $this->messages());

        $jadwalPelajaran->update($request->only([
            'kelas_id', 'pelajaran_id', 'guru_id',
            'hari', 'jam_ke', 'jam_mulai', 'jam_selesai',
            'ruangan', 'tahun_pelajaran', 'semester',
        ]) + ['is_active' => $request->boolean('is_active')]);

        return redirect()->route('jadwal-pelajaran.show', $jadwalPelajaran)
                         ->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(JadwalPelajaran $jadwalPelajaran)
    {
        $jadwalPelajaran->delete();
        return redirect()->route('jadwal-pelajaran.index')
                         ->with('success', 'Jadwal berhasil dihapus.');
    }

    private function rules(?int $ignoreId = null): array
    {
        return [
            'kelas_id'        => 'required|exists:kelas,id',
            'pelajaran_id'    => 'required|exists:pelajaran,id',
            'guru_id'         => 'required|exists:guru,id',
            'hari'            => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_ke'          => 'required|integer|min:1|max:12',
            'jam_mulai'       => 'required|date_format:H:i',
            'jam_selesai'     => 'required|date_format:H:i|after:jam_mulai',
            'tahun_pelajaran' => ['required', 'regex:/^\d{4}\/\d{4}$/'],
            'semester'        => 'required|in:Ganjil,Genap',
            'ruangan'         => 'nullable|string|max:50',
        ];
    }

    private function messages(): array
    {
        return [
            'kelas_id.required'        => 'Pilih kelas.',
            'pelajaran_id.required'    => 'Pilih mata pelajaran.',
            'guru_id.required'         => 'Pilih guru.',
            'hari.required'            => 'Pilih hari.',
            'jam_ke.required'          => 'Jam ke- wajib diisi.',
            'jam_mulai.required'       => 'Jam mulai wajib diisi.',
            'jam_selesai.required'     => 'Jam selesai wajib diisi.',
            'jam_selesai.after'        => 'Jam selesai harus setelah jam mulai.',
            'tahun_pelajaran.required' => 'Tahun pelajaran wajib diisi.',
            'tahun_pelajaran.regex'    => 'Format: YYYY/YYYY, contoh 2024/2025.',
            'semester.required'        => 'Semester wajib dipilih.',
        ];
    }
}