<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class KelasController extends Controller
{
    // ──────────────────────────────────────────────────
    //  INDEX
    // ──────────────────────────────────────────────────
    public function index(Request $request)
    {
        // ── Pilih scope berdasarkan filter "tampilkan" ──────────────
        $tampilkan = $request->input('tampilkan', 'aktif'); // aktif | terhapus | semua

        $query = match ($tampilkan) {
            'terhapus' => Kelas::onlyTrashed(),
            'semua'    => Kelas::withTrashed(),
            default    => Kelas::query(),          // hanya data tidak terhapus
        };

        // Filter tahun pelajaran
        if ($request->filled('tahun_pelajaran')) {
            $query->where('tahun_pelajaran', $request->tahun_pelajaran);
        }

        // Filter tingkat
        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        // Filter semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        // Filter status aktif/nonaktif (hanya relevan saat bukan mode terhapus)
        if ($request->filled('is_active') && $tampilkan !== 'terhapus') {
            $query->where('is_active', $request->is_active);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_kelas', 'like', '%' . $request->search . '%')
                  ->orWhere('tahun_pelajaran', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_kelas', 'like', '%' . $request->search . '%');
            });
        }

        $kelas = $query->orderBy('tahun_pelajaran', 'desc')
                       ->orderBy('tingkat')
                       ->orderBy('nama_kelas')
                       ->paginate(15)
                       ->withQueryString();

        // Daftar tahun pelajaran (termasuk yang sudah terhapus untuk dropdown filter)
        $tahunPelajaranList = Kelas::withTrashed()
            ->select('tahun_pelajaran')
            ->distinct()
            ->orderByDesc('tahun_pelajaran')
            ->pluck('tahun_pelajaran');

        // Jumlah data terhapus (untuk badge notifikasi)
        $jumlahTerhapus = Kelas::onlyTrashed()->count();
        $active = 'kelas';
        return view('admin.kelas.index', compact('kelas', 'tahunPelajaranList', 'tampilkan', 'jumlahTerhapus', 'active'));
    }

    // ──────────────────────────────────────────────────
    //  CREATE
    // ──────────────────────────────────────────────────
    public function create()
    {
        $tingkatList  = Kelas::listTingkat();
        $semesterList = Kelas::listSemester();

        // Saran tahun pelajaran berdasarkan tahun sekarang
        $tahunSekarang      = date('Y');
        $tahunPelajaranSaran = "{$tahunSekarang}/" . ($tahunSekarang + 1);
        $active = 'kelas';

        return view('admin.kelas.create', compact('tingkatList', 'semesterList', 'tahunPelajaranSaran', 'active'));
    }

    // ──────────────────────────────────────────────────
    //  STORE
    // ──────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate($this->rules(), $this->messages());

        $kodeKelas = Kelas::generateKode(
            $request->tahun_pelajaran,
            strtoupper($request->nama_kelas),
            $request->semester
        );

        // Cek duplikat kode
        if (Kelas::where('kode_kelas', $kodeKelas)->exists()) {
            return back()
                ->withInput()
                ->withErrors(['nama_kelas' => 'Kelas ' . $request->nama_kelas . ' pada tahun pelajaran ' . $request->tahun_pelajaran . ' semester ' . $request->semester . ' sudah ada.']);
        }

        Kelas::create([
            'nama_kelas'      => strtoupper($request->nama_kelas),
            'tingkat'         => $request->tingkat,
            'kode_kelas'      => $kodeKelas,
            'tahun_pelajaran' => $request->tahun_pelajaran,
            'semester'        => $request->semester,
            'kapasitas'       => $request->kapasitas ?? 30,
            'keterangan'      => $request->keterangan,
            'is_active'       => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    // ──────────────────────────────────────────────────
    //  SHOW
    // ──────────────────────────────────────────────────
    public function show(Kelas $kelas)
    {
        // Eager-load relasi (aktifkan setelah model guru/siswa tersedia)
        // $kelas->load(['waliKelas', 'siswa', 'pelajaran']);

        $active  = 'kelas';
        return view('admin.kelas.show', compact('kelas', 'active'));
    }

    // ──────────────────────────────────────────────────
    //  EDIT
    // ──────────────────────────────────────────────────
    public function edit(Kelas $kelas)
    {
        $tingkatList  = Kelas::listTingkat();
        $semesterList = Kelas::listSemester();
        $active       = 'kelas';

        return view('admin.kelas.edit', compact('kelas', 'tingkatList', 'semesterList', 'active'));
    }

    // ──────────────────────────────────────────────────
    //  UPDATE
    // ──────────────────────────────────────────────────
    public function update(Request $request, Kelas $kelas)
    {
        $request->validate($this->rules($kelas->id), $this->messages());

        $kodeKelas = Kelas::generateKode(
            $request->tahun_pelajaran,
            strtoupper($request->nama_kelas),
            $request->semester
        );

        // Cek duplikat kode (selain dirinya sendiri)
        if (
            Kelas::where('kode_kelas', $kodeKelas)
                 ->where('id', '!=', $kelas->id)
                 ->exists()
        ) {
            return back()
                ->withInput()
                ->withErrors(['nama_kelas' => 'Kelas ' . $request->nama_kelas . ' pada tahun pelajaran ' . $request->tahun_pelajaran . ' semester ' . $request->semester . ' sudah ada.']);
        }

        $kelas->update([
            'nama_kelas'      => strtoupper($request->nama_kelas),
            'tingkat'         => $request->tingkat,
            'kode_kelas'      => $kodeKelas,
            'tahun_pelajaran' => $request->tahun_pelajaran,
            'semester'        => $request->semester,
            'kapasitas'       => $request->kapasitas ?? 30,
            'keterangan'      => $request->keterangan,
            'is_active'       => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    // ──────────────────────────────────────────────────
    //  DESTROY
    // ──────────────────────────────────────────────────
    public function destroy(Kelas $kelas)
    {
        // Soft delete — data tetap tersimpan di DB
        $kelas->delete();

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }

    // ──────────────────────────────────────────────────
    //  RESTORE (kembalikan soft-deleted record)
    // ──────────────────────────────────────────────────
    public function restore(int $id)
    {
        $kelas = Kelas::onlyTrashed()->findOrFail($id);
        $kelas->restore();

        return redirect()
            ->route('kelas.index', ['tampilkan' => 'terhapus'])
            ->with('success', "Kelas {$kelas->nama_kelas} berhasil dipulihkan.");
    }

    // ──────────────────────────────────────────────────
    //  FORCE DELETE (hapus permanen)
    // ──────────────────────────────────────────────────
    public function forceDelete(int $id)
    {
        $kelas = Kelas::onlyTrashed()->findOrFail($id);
        $nama  = $kelas->nama_kelas;
        $kelas->forceDelete();

        return redirect()
            ->route('kelas.index', ['tampilkan' => 'terhapus'])
            ->with('success', "Kelas {$nama} berhasil dihapus permanen.");
    }

    // ──────────────────────────────────────────────────
    //  TOGGLE STATUS (AJAX-friendly)
    // ──────────────────────────────────────────────────
    public function toggleStatus(Kelas $kelas)
    {
        $kelas->update(['is_active' => !$kelas->is_active]);

        $status = $kelas->is_active ? 'diaktifkan' : 'dinonaktifkan';

        if (request()->expectsJson()) {
            return response()->json([
                'success'   => true,
                'is_active' => $kelas->is_active,
                'message'   => "Kelas berhasil {$status}.",
            ]);
        }

        return back()->with('success', "Kelas berhasil {$status}.");
    }

    // ──────────────────────────────────────────────────
    //  PRIVATE HELPERS
    // ──────────────────────────────────────────────────
    private function rules(?int $ignoreId = null): array
    {
        return [
            'nama_kelas'      => 'required|string|max:10',
            'tingkat'         => 'required|integer|between:1,6',
            'tahun_pelajaran' => ['required', 'string', 'regex:/^\d{4}\/\d{4}$/'],
            'semester'        => ['required', Rule::in(['Ganjil', 'Genap'])],
            'kapasitas'       => 'nullable|integer|min:1|max:60',
            'keterangan'      => 'nullable|string|max:500',
            'is_active'       => 'nullable|boolean',
        ];
    }

    private function messages(): array
    {
        return [
            'nama_kelas.required'          => 'Nama kelas wajib diisi.',
            'tingkat.required'             => 'Tingkat kelas wajib dipilih.',
            'tingkat.between'              => 'Tingkat kelas harus antara 1 sampai 6.',
            'tahun_pelajaran.required'     => 'Tahun pelajaran wajib diisi.',
            'tahun_pelajaran.regex'        => 'Format tahun pelajaran harus YYYY/YYYY, contoh: 2024/2025.',
            'semester.required'            => 'Semester wajib dipilih.',
            'semester.in'                  => 'Semester harus Ganjil atau Genap.',
            'kapasitas.min'                => 'Kapasitas minimal 1 siswa.',
            'kapasitas.max'                => 'Kapasitas maksimal 60 siswa.',
        ];
    }
}