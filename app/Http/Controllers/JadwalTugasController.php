<?php

namespace App\Http\Controllers;

use App\Models\JadwalTugas;
use App\Models\Kelas;
use App\Models\Pelajaran;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JadwalTugasController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalTugas::with(['kelas', 'pelajaran', 'guru']);

        if ($request->filled('kelas_id'))     $query->where('kelas_id', $request->kelas_id);
        if ($request->filled('pelajaran_id')) $query->where('pelajaran_id', $request->pelajaran_id);
        if ($request->filled('is_published')) $query->where('is_published', $request->is_published);
        if ($request->filled('search')) {
            $query->where('judul_tugas', 'like', '%' . $request->search . '%');
        }

        $tugas         = $query->orderByDesc('tenggat_waktu')->paginate(15)->withQueryString();
        $kelasList     = Kelas::aktif()->orderBy('nama_kelas')->get();
        $pelajaranList = Pelajaran::aktif()->orderBy('nama_pelajaran')->get();
        $active = 'materi_pelajaran';

        return view('admin.jadwal-tugas.index', compact('tugas', 'kelasList', 'pelajaranList', 'active'));
    }

    public function create()
    {
        return view('admin.jadwal-tugas.create', [
            'kelasList'    => Kelas::aktif()->orderBy('tingkat')->orderBy('nama_kelas')->get(),
            'pelajaranList'=> Pelajaran::aktif()->orderBy('nama_pelajaran')->get(),
            'guruList'     => Guru::aktif()->orderBy('nama_lengkap')->get(),
            'tipeList'     => JadwalTugas::listTipePengumpulan(),
            'active'       => 'materi_pelajaran',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->rules(), $this->messages());

        $filePath = null;
        if ($request->hasFile('file_tugas')) {
            $filePath = $request->file('file_tugas')->store('tugas', 'public');
        }

        JadwalTugas::create([
            'kelas_id'         => $request->kelas_id,
            'pelajaran_id'     => $request->pelajaran_id,
            'guru_id'          => $request->guru_id,
            'judul_tugas'      => $request->judul_tugas,
            'deskripsi'        => $request->deskripsi,
            'file_tugas'       => $filePath,
            'tanggal_mulai'    => $request->tanggal_mulai,
            'tenggat_waktu'    => $request->tenggat_waktu,
            'tipe_pengumpulan' => $request->tipe_pengumpulan,
            'nilai_maksimal'   => $request->nilai_maksimal ?? 100,
            'is_published'     => $request->boolean('is_published'),
        ]);

        return redirect()->route('jadwal-tugas.index')
                         ->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function show(JadwalTugas $jadwalTugas)
    {
        $jadwalTugas->load(['kelas', 'pelajaran', 'guru']);
        return view('admin.jadwal-tugas.show', ['tugas' => $jadwalTugas, 'active' => 'materi_pelajaran']);
    }

    public function edit(JadwalTugas $jadwalTugas)
    {
        return view('admin.jadwal-tugas.edit', [
            'tugas'        => $jadwalTugas,
            'kelasList'    => Kelas::aktif()->orderBy('tingkat')->orderBy('nama_kelas')->get(),
            'pelajaranList'=> Pelajaran::aktif()->orderBy('nama_pelajaran')->get(),
            'guruList'     => Guru::aktif()->orderBy('nama_lengkap')->get(),
            'tipeList'     => JadwalTugas::listTipePengumpulan(),
            'active'       => 'materi_pelajaran',
        ]);
    }

    public function update(Request $request, JadwalTugas $jadwalTugas)
    {
        $request->validate($this->rules(), $this->messages());

        $filePath = $jadwalTugas->file_tugas;
        if ($request->hasFile('file_tugas')) {
            if ($filePath) Storage::disk('public')->delete($filePath);
            $filePath = $request->file('file_tugas')->store('tugas', 'public');
        }
        if ($request->boolean('hapus_file') && $filePath) {
            Storage::disk('public')->delete($filePath);
            $filePath = null;
        }

        $jadwalTugas->update([
            'kelas_id'         => $request->kelas_id,
            'pelajaran_id'     => $request->pelajaran_id,
            'guru_id'          => $request->guru_id,
            'judul_tugas'      => $request->judul_tugas,
            'deskripsi'        => $request->deskripsi,
            'file_tugas'       => $filePath,
            'tanggal_mulai'    => $request->tanggal_mulai,
            'tenggat_waktu'    => $request->tenggat_waktu,
            'tipe_pengumpulan' => $request->tipe_pengumpulan,
            'nilai_maksimal'   => $request->nilai_maksimal ?? 100,
            'is_published'     => $request->boolean('is_published'),
        ]);

        return redirect()->route('jadwal-tugas.show', $jadwalTugas)
                         ->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(JadwalTugas $jadwalTugas)
    {
        if ($jadwalTugas->file_tugas) Storage::disk('public')->delete($jadwalTugas->file_tugas);
        $jadwalTugas->delete();
        return redirect()->route('jadwal-tugas.index')
                         ->with('success', 'Tugas berhasil dihapus.');
    }

    public function togglePublish(JadwalTugas $jadwalTugas)
    {
        $jadwalTugas->update(['is_published' => !$jadwalTugas->is_published]);
        $s = $jadwalTugas->is_published ? 'dipublikasikan' : 'disembunyikan';
        return back()->with('success', "Tugas berhasil {$s}.");
    }

    private function rules(): array
    {
        return [
            'kelas_id'         => 'required|exists:kelas,id',
            'pelajaran_id'     => 'required|exists:pelajaran,id',
            'guru_id'          => 'required|exists:guru,id',
            'judul_tugas'      => 'required|string|max:200',
            'tanggal_mulai'    => 'required|date',
            'tenggat_waktu'    => 'required|date|after:tanggal_mulai',
            'tipe_pengumpulan' => 'required|in:File,Teks,Link,Offline',
            'nilai_maksimal'   => 'nullable|integer|min:1|max:100',
            'file_tugas'       => 'nullable|file|max:10240',
        ];
    }

    private function messages(): array
    {
        return [
            'kelas_id.required'         => 'Pilih kelas.',
            'pelajaran_id.required'     => 'Pilih mata pelajaran.',
            'guru_id.required'          => 'Pilih guru.',
            'judul_tugas.required'      => 'Judul tugas wajib diisi.',
            'tanggal_mulai.required'    => 'Tanggal mulai wajib diisi.',
            'tenggat_waktu.required'    => 'Tenggat waktu wajib diisi.',
            'tenggat_waktu.after'       => 'Tenggat waktu harus setelah tanggal mulai.',
            'tipe_pengumpulan.required' => 'Tipe pengumpulan wajib dipilih.',
            'file_tugas.max'            => 'Ukuran file maksimal 10MB.',
        ];
    }
}