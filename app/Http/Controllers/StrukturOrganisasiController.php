<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StrukturOrganisasi;

class StrukturOrganisasiController extends Controller
{
    public function index()
    {
        $data = StrukturOrganisasi::with('parent')->get();

        $tree = StrukturOrganisasi::whereNull('parent_id')
                ->with('children.children')
                ->get();

        $active = 'struktur';
        return view('admin.struktur.index', compact('data','tree', 'active'));
    }

    public function create()
    {
        $parent = StrukturOrganisasi::all();
        $active = 'struktur';

        return view('admin.struktur.create', compact('parent', 'active'));
    }

    public function store(Request $request)
    {
        $namaFile = null;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $namaFile = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/struktur'), $namaFile);
        }

        StrukturOrganisasi::create([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'parent_id' => $request->parent_id,
            'urutan' => $request->urutan,
            'foto' => $namaFile
        ]);

        return redirect()->route('struktur.index');
    }

    public function edit($id)
    {
        $data = StrukturOrganisasi::find($id);
        $parent = StrukturOrganisasi::where('id','!=',$id)->get();

        $active = 'struktur';
        return view('admin.struktur.edit', compact('data','parent', 'active'));
    }

    public function update(Request $request, $id)
    {
        $data = StrukturOrganisasi::find($id);
        $namaFile = $data->foto;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $namaFile = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/struktur'), $namaFile);
        }

        $data->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'parent_id' => $request->parent_id,
            'urutan' => $request->urutan,
            'foto' => $namaFile
        ]);

        return redirect()->route('struktur.index');
    }

    public function destroy($id)
    {
        StrukturOrganisasi::destroy($id);
        return back();
    }
}