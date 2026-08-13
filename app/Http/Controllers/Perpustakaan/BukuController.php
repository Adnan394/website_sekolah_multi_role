<?php

namespace App\Http\Controllers\Perpustakaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Exports\BukuExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::latest()->get();
        return view('perpustakaan.buku.index', compact('bukus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'nullable|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|integer',
            'stok' => 'required|integer|min:0',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $data = $request->except('cover');

            if ($request->hasFile('cover')) {
                $file = $request->file('cover');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $filename);
                $data['cover'] = 'uploads/buku/' . $filename;
            }

            Buku::create($data);

            return redirect()->route('perpustakaan.buku.index')->with('success', 'Buku berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'nullable|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|integer',
            'stok' => 'required|integer|min:0',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $data = $request->except('cover');

            if ($request->hasFile('cover')) {
                if ($buku->cover && file_exists(public_path($buku->cover))) {
                    unlink(public_path($buku->cover));
                }
                $file = $request->file('cover');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $filename);
                $data['cover'] = 'uploads/' . $filename;
            }

            $buku->update($data);

            return redirect()->route('perpustakaan.buku.index')->with('success', 'Buku berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy(Buku $buku)
    {
        try {
            if ($buku->cover && file_exists(public_path($buku->cover))) {
                unlink(public_path($buku->cover));
            }
            $buku->delete();

            return redirect()->route('perpustakaan.buku.index')->with('success', 'Buku berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    public function exportExcel()
    {
        return Excel::download(new BukuExport, 'data_buku.xlsx');
    }
}
