<?php

namespace App\Http\Controllers;

use App\Models\MateriPembelajaran;
use App\Models\Kelas;
use App\Models\Pelajaran;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MateriPembelajaranController extends Controller
{
    public function __construct()
    {
        // Only Admin and Guru can create/update/delete or toggle publish
        $this->middleware('role:Admin,guru')->only(['create', 'store', 'edit', 'update', 'destroy', 'togglePublish']);
    }
    public function index(Request $request)
    {
        $query = MateriPembelajaran::with(['kelas', 'pelajaran', 'guru']);

        if ($request->filled('kelas_id'))     $query->where('kelas_id', $request->kelas_id);
        if ($request->filled('pelajaran_id')) $query->where('pelajaran_id', $request->pelajaran_id);
        if ($request->filled('tipe'))         $query->where('tipe', $request->tipe);
        if ($request->filled('is_published')) $query->where('is_published', $request->is_published);
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        if (Auth::user()->role === 'siswa') {
            $siswa = Siswa::where('user_id', Auth::id())->with('kelas')->first();
            $kelasIds = $siswa?->kelas->pluck('id')->toArray() ?? [0];
            $query->published()->whereIn('kelas_id', $kelasIds);
        }

        $materi       = $query->orderByDesc('tanggal_upload')->paginate(15)->withQueryString();
        $kelasList    = Kelas::aktif()->orderBy('nama_kelas')->get();
        $pelajaranList = Pelajaran::aktif()->orderBy('nama_pelajaran')->get();
        $active = 'materi_pelajaran';
        return view('admin.materi-pembelajaran.index', compact('materi', 'kelasList', 'pelajaranList', 'active'));
    }

    public function create()
    {
        return view('admin.materi-pembelajaran.create', [
            'kelasList'    => Kelas::aktif()->orderBy('tingkat')->orderBy('nama_kelas')->get(),
            'pelajaranList'=> Pelajaran::aktif()->orderBy('nama_pelajaran')->get(),
            'guruList'     => Guru::aktif()->orderBy('nama_lengkap')->get(),
            'tipeList'     => MateriPembelajaran::listTipe(),
            'active'       => 'materi_pelajaran',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->rules(), $this->messages());

        $filePath = null;
        if ($request->hasFile('file_materi')) {
            $filePath = $request->file('file_materi')->store('materi', 'public');
        }

        MateriPembelajaran::create([
            'kelas_id'       => $request->kelas_id,
            'pelajaran_id'   => $request->pelajaran_id,
            'guru_id'        => $request->guru_id,
            'judul'          => $request->judul,
            'deskripsi'      => $request->deskripsi,
            'file_materi'    => $filePath,
            'link_materi'    => $request->link_materi,
            'tipe'           => $request->tipe,
            'tanggal_upload' => $request->tanggal_upload ?? today(),
            'is_published'   => $request->boolean('is_published'),
        ]);

        return redirect()->route('materi-pembelajaran.index')
                         ->with('success', 'Materi berhasil ditambahkan.');
    }

    public function show(MateriPembelajaran $materiPembelajaran)
    {
        $materiPembelajaran->load(['kelas', 'pelajaran', 'guru']);
        return view('admin.materi-pembelajaran.show', ['materi' => $materiPembelajaran, 'active' => 'materi_pelajaran']);
    }

    public function edit(MateriPembelajaran $materiPembelajaran)
    {
        return view('admin.materi-pembelajaran.edit', [
            'materi'       => $materiPembelajaran,
            'kelasList'    => Kelas::aktif()->orderBy('tingkat')->orderBy('nama_kelas')->get(),
            'pelajaranList'=> Pelajaran::aktif()->orderBy('nama_pelajaran')->get(),
            'guruList'     => Guru::aktif()->orderBy('nama_lengkap')->get(),
            'tipeList'     => MateriPembelajaran::listTipe(),
            'active'       => 'materi_pelajaran',
        ]);
    }

    public function update(Request $request, MateriPembelajaran $materiPembelajaran)
    {
        $request->validate($this->rules(), $this->messages());

        $filePath = $materiPembelajaran->file_materi;
        if ($request->hasFile('file_materi')) {
            if ($filePath) Storage::disk('public')->delete($filePath);
            $filePath = $request->file('file_materi')->store('materi', 'public');
        }
        if ($request->boolean('hapus_file') && $filePath) {
            Storage::disk('public')->delete($filePath);
            $filePath = null;
        }

        $materiPembelajaran->update([
            'kelas_id'       => $request->kelas_id,
            'pelajaran_id'   => $request->pelajaran_id,
            'guru_id'        => $request->guru_id,
            'judul'          => $request->judul,
            'deskripsi'      => $request->deskripsi,
            'file_materi'    => $filePath,
            'link_materi'    => $request->link_materi,
            'tipe'           => $request->tipe,
            'tanggal_upload' => $request->tanggal_upload,
            'is_published'   => $request->boolean('is_published'),
        ]);

        return redirect()->route('materi-pembelajaran.show', $materiPembelajaran)
                         ->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(MateriPembelajaran $materiPembelajaran)
    {
        if ($materiPembelajaran->file_materi) {
            Storage::disk('public')->delete($materiPembelajaran->file_materi);
        }
        $materiPembelajaran->delete();
        return redirect()->route('materi-pembelajaran.index')
                         ->with('success', 'Materi berhasil dihapus.');
    }

    public function togglePublish(MateriPembelajaran $materiPembelajaran)
    {
        $materiPembelajaran->update(['is_published' => !$materiPembelajaran->is_published]);
        $status = $materiPembelajaran->is_published ? 'dipublikasikan' : 'disembunyikan';
        return back()->with('success', "Materi berhasil {$status}.");
    }

    private function rules(): array
    {
        return [
            'kelas_id'       => 'required|exists:kelas,id',
            'pelajaran_id'   => 'required|exists:pelajaran,id',
            'guru_id'        => 'required|exists:guru,id',
            'judul'          => 'required|string|max:200',
            'tipe'           => 'required|in:Dokumen,Video,Link,Teks',
            'tanggal_upload' => 'required|date',
            'file_materi'    => 'nullable|file|max:10240',
            'link_materi'    => 'nullable|url|max:500',
            'deskripsi'      => 'nullable|string',
        ];
    }

    private function messages(): array
    {
        return [
            'kelas_id.required'     => 'Pilih kelas.',
            'pelajaran_id.required' => 'Pilih mata pelajaran.',
            'guru_id.required'      => 'Pilih guru.',
            'judul.required'        => 'Judul materi wajib diisi.',
            'tipe.required'         => 'Tipe materi wajib dipilih.',
            'tanggal_upload.required' => 'Tanggal upload wajib diisi.',
            'file_materi.max'       => 'Ukuran file maksimal 10MB.',
            'link_materi.url'       => 'Format link tidak valid.',
        ];
    }
}