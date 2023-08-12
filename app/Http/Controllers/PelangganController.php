<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $data['result'] = pelanggan::where(function($query) use ($q) {
            $query->where('nama_lengkap', 'like', '%' . $q . '%');
            $query->orWhere('jenis_kelamin', 'like', '%' . $q . '%');
            $query->orWhere('nomor_hp', 'like', '%' . $q . '%');
            $query->orWhere('alamat', 'like', '%' . $q . '%');
            $query->orWhere('email', 'like', '%' . $q . '%');
        })->paginate();

        $data['q'] = $q;

        return view('pelanggan.list', $data);
    }

    public function create()
        {
            return view('pelanggan.form');
        }
    public function show()
        {
            return view('pelanggan.show');
        }

    public function store(Request $request, pelanggan $pelanggan = null)
        {
            $rules = [
                'nama_lengkap' => 'alpha',
                'jenis_kelamin' => 'required',
                'nomor_hp' => 'required|numeric|min:8'
            ];
            $this->validate($request, $rules);

            pelanggan::updateOrCreate(['id'=> @$pelanggan->id], $request->all());
            return redirect('/pelanggan')->with('success', 'Data berhasil disimpan');
        }
    public function edit(pelanggan $pelanggan)
        {
            return view('pelanggan.form', compact('pelanggan'));
        }
    public function destroy(pelanggan $pelanggan)
        {
            $pelanggan->delete();
            return redirect('/pelanggan')->with('success', 'Data berhasil dihapus');
        }
}