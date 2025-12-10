<?php

namespace App\Http\Controllers;

use App\Models\Warga; // <--- TAMBAHKAN BARIS INI
use Illuminate\Http\Request;

class WargaController extends Controller
{
    public function index(Request $request)
    {
        $columns = ['jenis_kelamin'];

        $warga = Warga::latest()
                ->filter($request, $columns) // Panggil scopeFilter
                ->get();
        return view('pages.warga.index', compact('warga'));
    }

    public function create()
    {
        return view('pages.warga.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'no_ktp'        => 'required|string|size:16|unique:warga,no_ktp',
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama'         => 'required|string|max:50',
            'pekerjaan'     => 'required|string|max:100',
            'telp'          => 'nullable|string|max:15',
            'email'         => 'nullable|email|unique:warga,email'
        ]);

        Warga::create($request->all());

        return redirect()->route('warga.index')
                         ->with('success', 'Data warga berhasil ditambahkan!');
    }

    public function show(Warga $warga)
    {
        return view('pages.warga.show', compact('warga'));
    }

    public function edit(Warga $warga)
    {
        return view('pages.warga.edit', compact('warga'));
    }

    public function update(Request $request, Warga $warga)
    {
        // Validasi input
        $request->validate([
            'no_ktp'        => 'required|string|size:16|unique:warga,no_ktp,' . $warga->warga_id . ',warga_id',
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama'         => 'required|string|max:50',
            'pekerjaan'     => 'required|string|max:100',
            'telp'          => 'nullable|string|max:15',
            'email'         => 'nullable|email|unique:warga,email,' . $warga->warga_id . ',warga_id'
        ]);

        $warga->update($request->all());

        return redirect()->route('warga.index')
                         ->with('success', 'Data warga berhasil diperbarui!');
    }

    public function destroy(Warga $warga)
    {
        $warga->delete();

        return redirect()->route('warga.index')
                         ->with('success', 'Data warga berhasil dihapus!');
    }
}
