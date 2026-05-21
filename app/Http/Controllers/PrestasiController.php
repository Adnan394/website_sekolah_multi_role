<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestasi;

class PrestasiController extends Controller
{
    public function index()
    {
        $data = Prestasi::latest()->get();
        $active = 'prestasi';
        return view('admin.prestasi.index', compact('data', 'active'));
    }

    public function create()
    {
        $active = 'prestasi';
        return view('admin.prestasi.create', compact('active'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'gambar' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $namaFile = null;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/prestasi'), $namaFile);
        }

        Prestasi::create([
            'title' => $request->title,
            'description' => $request->description,
            'gambar' => $namaFile
        ]);

        return redirect()->route('prestasi.index');
    }

    public function edit($id)
    {
        $data = Prestasi::find($id);
        $active = 'prestasi';
        return view('admin.prestasi.edit', compact('data', 'active'));
    }

    public function update(Request $request, $id)
    {
        $data = Prestasi::find($id);
        $namaFile = $data->gambar;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/prestasi'), $namaFile);
        }

        $data->update([
            'title' => $request->title,
            'description' => $request->description,
            'gambar' => $namaFile
        ]);

        return redirect()->route('prestasi.index');
    }

    public function destroy($id)
    {
        Prestasi::destroy($id);
        return back();
    }
}