<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kurikulum;

class KurikulumController extends Controller
{
    public function index()
    {
        $data = Kurikulum::latest()->get();
        $active = 'kurikulum';
        return view('admin.kurikulum.index', compact('data', 'active'));
    }

    public function create()
    {
        $active = 'kurikulum';
        return view('admin.kurikulum.create', compact('active'));
    }

    public function store(Request $request)
    {
        $gambar = null;
        $pdf = null;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $gambar = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/kurikulum'), $gambar);
        }

        if ($request->hasFile('file_pdf')) {
            $file = $request->file('file_pdf');
            $pdf = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/kurikulum'), $pdf);
        }

        Kurikulum::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar,
            'file_pdf' => $pdf,
            'tahun_ajaran' => $request->tahun_ajaran,
            'status' => $request->status
        ]);

        return redirect()->route('kurikulum.index');
    }

    public function edit($id)
    {
        $data = Kurikulum::find($id);
        $active = 'kurikulum';
        return view('admin.kurikulum.edit', compact('data', 'active'));
    }

    public function update(Request $request, $id)
    {
        $data = Kurikulum::find($id);

        $gambar = $data->gambar;
        $pdf = $data->file_pdf;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $gambar = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/kurikulum'), $gambar);
        }

        if ($request->hasFile('file_pdf')) {
            $file = $request->file('file_pdf');
            $pdf = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/kurikulum'), $pdf);
        }

        $data->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar,
            'file_pdf' => $pdf,
            'tahun_ajaran' => $request->tahun_ajaran,
            'status' => $request->status
        ]);

        return redirect()->route('kurikulum.index');
    }

    public function destroy($id)
    {
        Kurikulum::destroy($id);
        return back();
    }
}