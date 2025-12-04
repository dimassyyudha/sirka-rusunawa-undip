<?php

namespace App\Http\Controllers;

use App\Models\KategoriAset;
use Illuminate\Http\Request;

class KategoriAsetController extends Controller
{
    public function index()
    {
        $kategoris = KategoriAset::latest()->get();
        return view('pages.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('pages.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'kode' => 'required|string|max:20|unique:kategori_aset,kode',
            'deskripsi' => 'nullable|string',
        ]);

        KategoriAset::create($request->all());
        return redirect()->route('kategori.index')->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function edit(KategoriAset $kategori)
    {
        return view('pages.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, KategoriAset $kategori)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'kode' => 'required|string|max:20|unique:kategori_aset,kode,' . $kategori->kategori_id . ',kategori_id',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update($request->all());
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(KategoriAset $kategori)
    {
        // Opsional: Cek jika kategori masih dipakai oleh aset
        if ($kategori->asets()->count() > 0) {
            return redirect()->route('kategori.index')->withErrors('Kategori ini tidak bisa dihapus karena masih digunakan oleh aset.');
        }

        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
