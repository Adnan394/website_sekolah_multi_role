<?php

namespace App\Http\Controllers\Perpustakaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PeminjamanBuku;
use App\Models\Siswa;
use App\Models\Buku;

class PeminjamanBukuController extends Controller
{
    public function index()
    {
        $peminjamans = PeminjamanBuku::with(['siswa', 'buku'])->latest()->get();
        $siswas = Siswa::aktif()->get();
        $bukus = Buku::where('stok', '>', 0)->get();
        
        return view('perpustakaan.peminjaman.index', compact('peminjamans', 'siswas', 'bukus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
        ]);

        $buku = Buku::findOrFail($request->buku_id);
        if ($buku->stok <= 0) {
            return back()->withErrors(['buku_id' => 'Stok buku habis.']);
        }

        PeminjamanBuku::create([
            'siswa_id' => $request->siswa_id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'dipinjam',
        ]);

        $buku->decrement('stok');

        return redirect()->route('perpustakaan.peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    public function update(Request $request, PeminjamanBuku $peminjaman)
    {
        $request->validate([
            'status' => 'required|in:dipinjam,dikembalikan',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
        ]);

        if ($peminjaman->status == 'dipinjam' && $request->status == 'dikembalikan') {
            $peminjaman->buku->increment('stok');
        } elseif ($peminjaman->status == 'dikembalikan' && $request->status == 'dipinjam') {
            if ($peminjaman->buku->stok <= 0) {
                return back()->withErrors(['status' => 'Stok buku habis, tidak bisa diubah ke dipinjam.']);
            }
            $peminjaman->buku->decrement('stok');
        }

        $peminjaman->update([
            'status' => $request->status,
            'tanggal_kembali' => $request->tanggal_kembali,
        ]);

        return redirect()->route('perpustakaan.peminjaman.index')->with('success', 'Status peminjaman diperbarui.');
    }

    public function destroy(PeminjamanBuku $peminjaman)
    {
        if ($peminjaman->status == 'dipinjam') {
            $peminjaman->buku->increment('stok');
        }
        $peminjaman->delete();

        return redirect()->route('perpustakaan.peminjaman.index')->with('success', 'Data peminjaman dihapus.');
    }
}
