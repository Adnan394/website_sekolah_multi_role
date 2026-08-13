<?php

namespace App\Http\Controllers\Perpustakaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\PeminjamanBuku;

class DashboardController extends Controller
{
    public function index()
    {
        $bukuCount = Buku::count();
        $peminjamCount = PeminjamanBuku::where('status', 'dipinjam')->count();
        
        return view('perpustakaan.dashboard', compact('bukuCount', 'peminjamCount'));
    }
}
