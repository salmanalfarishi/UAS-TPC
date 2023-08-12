<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $data['result'] = Kategori::where(function($query) use ($q) {
            $query->where('nama_kategori', 'like', '%' . $q . '%');
        })->paginate();

        $data['q'] = $q;

        return view('kategori.list', $data);
    }

    public function create()
        {
            return view('kategori.form');
        }
    public function show()
        {
            return view('kategori.show');
        }

    public function store(Request $request, Kategori $kategori = null)
        {
            $rules = [
                'kategori' => 'alpha',
            ];
            $this->validate($request, $rules);

            Kategori::updateOrCreate(['id'=> @$kategori->id], $request->all());
            return redirect('/kategori')->with('success', 'Data berhasil disimpan');
        }
    public function edit(Kategori $kategori)
        {
            return view('kategori.form', compact('kategori'));
        }
    public function destroy(Kategori $kategori)
        {
            $kategori->delete();
            return redirect('/kategori')->with('success', 'Data berhasil dihapus');
        }
}