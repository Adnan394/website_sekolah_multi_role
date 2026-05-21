<?php

namespace App\Http\Controllers;

use App\Models\Pelajaran;
use Illuminate\Http\Request;

class PelajaranController extends Controller
{
    public function index(Request $request)
    {
        $tampilkan = $request->get('tampilkan', 'aktif');
        $query = Pelajaran::query();

        // Filter Soft Deletes
        if ($tampilkan === 'terhapus') {
            $query->onlyTrashed();
        } elseif ($tampilkan === 'semua') {
            $query->withTrashed();
        }

        // Search & Filter
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_pelajaran', 'like', "%{$request->search}%")
                  ->orWhere('kode_pelajaran', 'like', "%{$request->search}%");
            });
        }

        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        $pelajaran = $query->latest()->paginate(10)->withQueryString();
        $jumlahTerhapus = Pelajaran::onlyTrashed()->count();
        $kategoriList = Pelajaran::listKategori();

        $active = 'pelajaran';
        return view('admin.pelajaran.index', compact('pelajaran', 'tampilkan', 'jumlahTerhapus', 'kategoriList', 'active'));
    }

    public function create()
    {
        $kategoriList = Pelajaran::listKategori();
        $active = 'pelajaran';
        return view('admin.pelajaran.create', compact('kategoriList', 'active'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_pelajaran' => 'required|unique:pelajaran,kode_pelajaran|max:20',
            'nama_pelajaran' => 'required|max:150',
            'kategori'       => 'required|in:Wajib,Muatan Lokal,Pengembangan Diri,Ekstrakurikuler',
            'tingkat_min'    => 'required|integer|min:1|max:6',
            'tingkat_max'    => 'required|integer|min:1|max:6|gte:tingkat_min',
            'jam_per_minggu' => 'required|integer|min:1',
            'deskripsi'      => 'nullable',
            'is_active'      => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        Pelajaran::create($validated);
        return redirect()->route('pelajaran.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit(Pelajaran $pelajaran)
    {
        $kategoriList = Pelajaran::listKategori();
        $active = 'pelajaran';
        return view('admin.pelajaran.edit', compact('pelajaran', 'kategoriList', 'active'));
    }

    public function update(Request $request, Pelajaran $pelajaran)
    {
        $validated = $request->validate([
            'kode_pelajaran' => 'required|max:20|unique:pelajaran,kode_pelajaran,' . $pelajaran->id,
            'nama_pelajaran' => 'required|max:150',
            'kategori'       => 'required|in:Wajib,Muatan Lokal,Pengembangan Diri,Ekstrakurikuler',
            'tingkat_min'    => 'required|integer|min:1|max:6',
            'tingkat_max'    => 'required|integer|min:1|max:6|gte:tingkat_min',
            'jam_per_minggu' => 'required|integer|min:1',
            'deskripsi'      => 'nullable',
            'is_active'      => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $pelajaran->update($validated);
        return redirect()->route('pelajaran.index')->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(Pelajaran $pelajaran)
    {
        $pelajaran->delete();
        return back()->with('success', 'Mata pelajaran berhasil dihapus (Soft Delete).');
    }

    public function restore($id)
    {
        $pelajaran = Pelajaran::onlyTrashed()->findOrFail($id);
        $pelajaran->restore();
        return back()->with('success', 'Mata pelajaran berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $pelajaran = Pelajaran::onlyTrashed()->findOrFail($id);
        $pelajaran->forceDelete();
        return back()->with('success', 'Mata pelajaran dihapus permanen.');
    }
}