<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\KontakKami;
use App\Models\Guru;
use App\Models\MateriPembelajaran;
use App\Models\Pelajaran;
use App\Models\RaporPenilaian;
use App\Models\RaporPenilaianItem;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RaporPenilaianController extends Controller
{
    public function index(Request $request)
    {
        $query = RaporPenilaian::with(['siswa.kelas']);
        
        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa.kelas', function ($q) use ($request) {
                $q->where('kelas.id', $request->kelas_id);
            });
        }
        
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        if ($request->filled('siswa_id')) {
            $query->where('siswa_id', $request->siswa_id);
        }

        $rapor = $query->orderByDesc('created_at')->paginate(20)->withQueryString();
        
        $kelasList = Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get();
        $semesterList = Kelas::listSemester();
        
        $active = 'rapor';
        return view('admin.rapor.index', compact('rapor', 'active', 'kelasList', 'semesterList'));
    }

    // public function __construct()
    // {
    //     $this->middleware('role:Admin,guru')->only(['create','store','storeItem','downloadPdf','destroy']);
    // }


    public function create(Request $request)
    {
        $kelasList = Kelas::aktif()->orderBy('tingkat')->orderBy('nama_kelas')->get();
        $tahunList = Kelas::select('tahun_pelajaran')->distinct()->orderByDesc('tahun_pelajaran')->pluck('tahun_pelajaran');
        $semesterList = Kelas::listSemester();

        $siswaQuery = Siswa::orderBy('nama_lengkap');
        if ($request->filled('kelas_id') || $request->filled('tahun_pelajaran') || $request->filled('semester')) {
            $siswaQuery->whereHas('kelas', function ($q) use ($request) {
                if ($request->filled('kelas_id')) {
                    $q->where('kelas.id', $request->kelas_id);
                }
                if ($request->filled('tahun_pelajaran')) {
                    $q->where('tahun_pelajaran', $request->tahun_pelajaran);
                }
                if ($request->filled('semester')) {
                    $q->where('semester', $request->semester);
                }
            });
        }
        if ($request->filled('search')) {
            $siswaQuery->where('nama_lengkap', 'like', '%' . $request->search . '%');
        }
        $siswaList = $siswaQuery->get();

        $active = 'rapor';
        return view('admin.rapor.create', compact(
            'siswaList', 'kelasList', 'tahunList', 'semesterList', 'active'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'tahun_pelajaran' => 'required|string',
            'semester' => 'required|string',
        ]);

        $rapor = RaporPenilaian::create([
            'siswa_id' => $request->siswa_id,
            'tahun_pelajaran' => $request->tahun_pelajaran,
            'semester' => $request->semester,
            'nilai_total' => 0,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('rapor.index')->with('success','Rapor dibuat. Silakan tambah item penilaian.');
    }

    public function show(RaporPenilaian $rapor)
    {
        $rapor->load(['items.materi.pelajaran','items.guru','siswa.kelas.waliKelas']);

        $kelasIds = $rapor->siswa->kelas()->pluck('kelas.id')->toArray();
        $materiList = MateriPembelajaran::published()
            ->whereIn('kelas_id', $kelasIds)
            ->orderByDesc('tanggal_upload')
            ->get();

        $pelajaranIds = $materiList->pluck('pelajaran_id')->filter()->unique()->toArray();
        $kelasPelajaranIds = DB::table('kelas_guru')
            ->whereIn('kelas_id', $kelasIds)
            ->whereNotNull('pelajaran_id')
            ->distinct()
            ->pluck('pelajaran_id')
            ->toArray();

        $pelajaranList = Pelajaran::whereIn('id', array_unique(array_merge($pelajaranIds, $kelasPelajaranIds)))
            ->orderBy('nama_pelajaran')
            ->get();

        // Recalculate total using configured weights
        $rapor->recalculateTotal();
        $active = 'rapor';
        return view('admin.rapor.show', compact('rapor', 'materiList', 'pelajaranList', 'active'));
    }

    public function downloadPdf(RaporPenilaian $rapor)
    {
        $rapor->load(['items.materi.pelajaran','items.guru','siswa.kelas.waliKelas']);
        $rapor->recalculateTotal();

        $items = $rapor->items;
        $materiItems = $items->where('jenis', 'materi');
        $tugasItems = $items->where('jenis', 'tugas');
        $kehadiranItems = $items->where('jenis', 'kehadiran');
        $keaktifanItems = $items->where('jenis', 'keaktifan');

        $summary = [
            'materi' => $materiItems->avg('nilai') ?: 0,
            'tugas' => $tugasItems->avg('nilai') ?: 0,
            'kehadiran' => $kehadiranItems->avg('nilai') ?: 0,
            'keaktifan' => $keaktifanItems->avg('nilai') ?: 0,
            'total' => $rapor->nilai_total ?: 0,
        ];

        $contact = KontakKami::first();
        $logoData = null;
        if ($contact?->logo && file_exists(public_path('uploads/kontak/' . $contact->logo))) {
            $logoData = 'data:image/' . pathinfo($contact->logo, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(public_path('uploads/kontak/' . $contact->logo)));
        } elseif (file_exists(public_path('assets/img/logo.png'))) {
            $logoData = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('assets/img/logo.png')));
        }

        $kelas = $rapor->siswa->kelas->first();
        $waliKelas = $kelas?->waliKelas->first();
        $kepalaSekolah = Guru::where('jabatan', 'Kepala Sekolah')->first();

        $schoolName = $contact->nama_tempat ?? 'SDN 3 Krenceng';
        $schoolAddress = $contact->alamat ?? 'Jl. Raya Krenceng, Purbalingga';
        $schoolContact = trim(($contact->telepon ?? '') . ' ' . ($contact->email ?? '')) ?: 'Telp: -';

        $pdf = Pdf::loadView('admin.rapor.pdf', compact(
            'rapor',
            'items',
            'materiItems',
            'tugasItems',
            'kehadiranItems',
            'keaktifanItems',
            'summary',
            'logoData',
            'schoolName',
            'schoolAddress',
            'schoolContact',
            'waliKelas',
            'kepalaSekolah'
        ));

        return $pdf->setPaper('a4', 'portrait')
            ->download('rapor-' . str_replace(' ', '-', strtolower($rapor->siswa->nama_lengkap)) . '.pdf');
    }

    public function indexSiswa()
    {
        $siswa = Siswa::where('user_id', Auth::id())->firstOrFail();
        $rapor = RaporPenilaian::with('siswa')
            ->where('siswa_id', $siswa->id)
            ->orderByDesc('created_at')
            ->paginate(20);

        $active = 'siswa_rapor';
        return view('admin.siswa.rapor.index', compact('rapor', 'active'));
    }

    public function showSiswa(RaporPenilaian $rapor)
    {
        $siswa = Siswa::where('user_id', Auth::id())->firstOrFail();
        if ($rapor->siswa_id !== $siswa->id) {
            abort(403);
        }

        $rapor->load(['items.materi.pelajaran','items.guru','siswa.kelas.waliKelas']);
        $rapor->recalculateTotal();

        $active = 'siswa_rapor';
        return view('admin.siswa.rapor.show', compact('rapor', 'active'));
    }

    public function downloadPdfSiswa(RaporPenilaian $rapor)
    {
        $siswa = Siswa::where('user_id', Auth::id())->firstOrFail();
        if ($rapor->siswa_id !== $siswa->id) {
            abort(403);
        }

        return $this->downloadPdf($rapor);
    }

    public function destroy(RaporPenilaian $rapor)
    {
        $rapor->delete();
        return redirect()->route('rapor.index')->with('success','Rapor dihapus.');
    }

    // Add item (nilai oleh guru)
    public function storeItem(Request $request, RaporPenilaian $rapor)
    {
        $request->validate([
            'jenis' => 'required|string',
            'nilai' => 'required|numeric',
            'pelajaran_id' => 'nullable|exists:pelajaran,id',
            'materi_id' => 'nullable|exists:materi_pembelajaran,id',
            'komentar' => 'nullable|string',
        ]);

        $pelajaranId = $request->pelajaran_id;
        if (! $pelajaranId && $request->filled('materi_id')) {
            $materi = MateriPembelajaran::find($request->materi_id);
            $pelajaranId = $materi?->pelajaran_id;
        }

        $item = RaporPenilaianItem::create([
            'rapor_id' => $rapor->id,
            'guru_id' => Auth::user()?->guru?->id ?? null,
            'jenis' => $request->jenis,
            'nilai' => $request->nilai,
            'pelajaran_id' => $pelajaranId,
            'materi_id' => $request->materi_id,
            'komentar' => $request->komentar,
            'created_by' => Auth::id(),
        ]);

        // Recalculate total using weights and per-type averages
        $rapor->recalculateTotal();

        return redirect()->back()->with('success','Item penilaian disimpan.');
    }
}
