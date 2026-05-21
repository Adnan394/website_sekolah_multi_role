<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;

class BeritaController extends Controller
{
    public function index()
    {
        $data = Berita::latest()->get();
        $active = 'berita';
        return view('admin.berita.index', compact('data', 'active'));
    }

    public function create()
    {
        $active = 'berita';
        return view('admin.berita.create', compact('active'));
    }

    public function store(Request $request)
    {
        $thumbnail = null;

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $thumbnail = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/berita'), $thumbnail);
        }

        Berita::create([
            'judul' => $request->judul,
            'thumbnail' => $thumbnail,
            'konten' => $request->konten,
            'tanggal_publish' => $request->tanggal_publish,
            'penulis' => $request->penulis,
            'status' => $request->status
        ]);

        return redirect()->route('berita.index');
    }

    public function edit($id)
    {
        $data = Berita::find($id);

        $active = 'berita';
        return view('admin.berita.edit', compact('data', 'active'));
    }

    public function update(Request $request, $id)
    {
        $data = Berita::find($id);
        $thumbnail = $data->thumbnail;

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $thumbnail = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/berita'), $thumbnail);
        }

        $data->update([
            'judul' => $request->judul,
            'thumbnail' => $thumbnail,
            'konten' => $request->konten,
            'tanggal_publish' => $request->tanggal_publish,
            'penulis' => $request->penulis,
            'status' => $request->status
        ]);

        return redirect()->route('berita.index');
    }

    public function destroy($id)
    {
        Berita::destroy($id);
        return back();
    }
}