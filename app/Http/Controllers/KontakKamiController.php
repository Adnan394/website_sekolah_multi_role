<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KontakKami;

class KontakKamiController extends Controller
{
    public function index()
    {
        $data = KontakKami::first();
        $active = 'kontak';
        return view('admin.kontak.index', compact('data', 'active'));
    }

    public function create()
    {
        $active = 'kontak';
        return view('admin.kontak.create', compact('active'));
    }

    public function store(Request $request)
    {
        $logo = null;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $logo = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/kontak'), $logo);
        }

        KontakKami::create([
            'nama_tempat' => $request->nama_tempat,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'maps_embed' => $request->maps_embed,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'youtube' => $request->youtube,
            'logo' => $logo
        ]);

        return redirect()->route('kontak.index');
    }

    public function edit($id)
    {
        $data = KontakKami::find($id);
        $active = 'kontak';
        return view('admin.kontak.edit', compact('data', 'active'));
    }

    public function update(Request $request, $id)
    {
        $data = KontakKami::find($id);
        $logo = $data->logo;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $logo = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/kontak'), $logo);
        }

        $data->update([
            'nama_tempat' => $request->nama_tempat,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'maps_embed' => $request->maps_embed,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'youtube' => $request->youtube,
            'logo' => $logo
        ]);

        return redirect()->route('kontak.index');
    }

    public function destroy($id)
    {
        KontakKami::destroy($id);
        return back();
    }
}