<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FasilitasSekolah;

class FasilitasSekolahController extends Controller
{
    public function index()
    {
        $data = FasilitasSekolah::all();
        $active = 'fasilitas';
        return view('admin.fasilitas.index', compact('data', 'active'));
    }

    public function create()
    {
        $active = 'fasilitas';
        return view('admin.fasilitas.create', compact('active'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        FasilitasSekolah::create([
            'nama' => $request->nama
        ]);

        return redirect()->route('fasilitas.index')->with('success','Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = FasilitasSekolah::find($id);
        $active = 'fasilitas';
        return view('admin.fasilitas.edit', compact('data', 'active'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        FasilitasSekolah::find($id)->update([
            'nama' => $request->nama
        ]);

        return redirect()->route('fasilitas.index')->with('success','Data berhasil diupdate');
    }

    public function destroy($id)
    {
        FasilitasSekolah::destroy($id);
        return redirect()->route('fasilitas.index');
    }
}