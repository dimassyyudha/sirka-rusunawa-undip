<?php

namespace App\Http\Controllers;

use App\Models\MutasiAset;
use App\Models\Aset;
use Illuminate\Http\Request;

class MutasiAsetController extends Controller
{
    public function index()
    {
        // Eager load 'aset' agar performa query cepat
        $dataMutasi = MutasiAset::with('aset')->latest('tanggal')->paginate(10);
        return view('pages.mutasi.index', compact('dataMutasi'));
    }

    public function create()
    {
        $asets = Aset::all();
        return view('pages.mutasi.create', compact('asets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'aset_id'      => 'required|exists:aset,aset_id',
            'tanggal'      => 'required|date',
            'jenis_mutasi' => 'required|string|max:100',
            'keterangan'   => 'nullable|string',
        ]);

        MutasiAset::create($request->all());

        return redirect()->route('mutasi.index')->with('success', 'Data mutasi berhasil dicatat!');
    }

    public function edit($id)
    {
        $mutasi = MutasiAset::findOrFail($id);
        $asets = Aset::all();
        return view('pages.mutasi.edit', compact('mutasi', 'asets'));
    }

    public function update(Request $request, $id)
    {
        $mutasi = MutasiAset::findOrFail($id);

        $request->validate([
            'aset_id'      => 'required|exists:aset,aset_id',
            'tanggal'      => 'required|date',
            'jenis_mutasi' => 'required|string|max:100',
            'keterangan'   => 'nullable|string',
        ]);

        $mutasi->update($request->all());

        return redirect()->route('mutasi.index')->with('success', 'Data mutasi diperbarui!');
    }

    public function destroy($id)
    {
        $mutasi = MutasiAset::findOrFail($id);
        $mutasi->delete();
        return redirect()->route('mutasi.index')->with('success', 'Data mutasi dihapus!');
    }
}