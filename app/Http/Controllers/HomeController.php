<?php

namespace App\Http\Controllers;

use App\Models\TentangKami;
use App\Models\StrukturOrganisasi;
use App\Models\FasilitasSekolah;
use App\Models\Prestasi;
use App\Models\Berita;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome', [
            'tentang' => TentangKami::first(),
            'struktur' => StrukturOrganisasi::with('children')->whereNull('parent_id')->get(),
            'fasilitas' => FasilitasSekolah::take(6)->get(),
            'prestasi' => Prestasi::latest()->take(3)->get(),
            'berita' => Berita::where('status', 'publish')->latest('tanggal_publish')->get(),
            'active' => 'home'
        ]);
    }
}