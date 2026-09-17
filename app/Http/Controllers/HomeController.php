<?php

namespace App\Http\Controllers;

use App\Models\TentangKami;
use App\Models\StrukturOrganisasi;
use App\Models\FasilitasSekolah;
use App\Models\Prestasi;
use App\Models\Berita;
use App\Models\KontakKami;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome', [
            'tentang' => TentangKami::first(),
            'struktur' => StrukturOrganisasi::with('children')->whereNull('parent_id')->get(),
            'fasilitas' => FasilitasSekolah::get(),
            'prestasi' => Prestasi::latest()->get(),
            'berita' => Berita::where('status', 'publish')->latest('tanggal_publish')->get(),
            'kontak_kami' => KontakKami::first(),
            'active' => 'home'
        ]);
    }
}