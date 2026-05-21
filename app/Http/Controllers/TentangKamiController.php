<?php

namespace App\Http\Controllers;

use App\Models\TentangKami;
use Illuminate\Http\Request;

class TentangKamiController extends Controller
{
    public function index()
    {
        return view('admin.tentang_kami.index', [
            'active' => 'tentang_kami',
            'data' => TentangKami::first()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tentang_kami' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = TentangKami::first();

        // HANDLE GAMBAR
        $namaFile = $data->gambar ?? null;

        if ($request->hasFile('gambar')) {

            // hapus gambar lama
            if ($namaFile && file_exists(public_path('uploads/tentang_kami/'.$namaFile))) {
                unlink(public_path('uploads/tentang_kami/'.$namaFile));
            }

            $file = $request->file('gambar');
            $namaFile = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/tentang_kami'), $namaFile);
        }

        if ($data) {
            // UPDATE
            $data->update([
                'tentang_kami' => $request->tentang_kami,
                'gambar'       => $namaFile
            ]);
        } else {
            // CREATE
            TentangKami::create([
                'tentang_kami' => $request->tentang_kami,
                'gambar'       => $namaFile
            ]);
        }

        return redirect()->route('tentang_kami.index')->with('success', 'Data berhasil disimpan');
    }
}