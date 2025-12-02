<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Media;
use App\Models\KategoriAset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AsetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $columns = ['kondisi'];
        $asets = Aset::with('kategoriAset') // Eager load relasi
                    ->filter($request, $columns) // Panggil scopeFilter
                    ->latest()
                    ->get();
        return view('pages.aset.index', compact('asets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = KategoriAset::all(); // Ambil semua kategori
        return view('pages.aset.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Data Aset + File
        $request->validate([
            'kode_aset' => 'required|unique:asets,kode_aset',
            'nama_aset' => 'required',
            'kategori_id' => 'required|exists:kategori_asets,kategori_id',
            'tanggal_perolehan' => 'required|date',
            'nilai_perolehan' => 'required|numeric',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi' => 'required',
            'penanggung_jawab' => 'required',
            // Validasi File (Nullable artinya boleh tidak ada file)
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:5120',
        ]);

        // 2. Simpan Data Aset Terlebih Dahulu (Agar dapat ID)
        $aset = Aset::create($request->except('files')); // Simpan semua kecuali input files

        // 3. Proses Upload File (Jika ada)
        if ($request->hasFile('files')) {
            $path = public_path('uploads');
            if(!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $mimeType = $file->getClientMimeType();

                $file->move($path, $filename);

                // Simpan ke tabel Media dengan ID aset yang baru dibuat
                Media::create([
                    'ref_table' => 'aset',        // Hardcode 'aset'
                    'ref_id'    => $aset->id, // Ambil ID dari variabel $aset
                    'file_name' => $filename,
                    'mime_type' => $mimeType,
                    'caption'   => $file->getClientOriginalName(),
                    'sort_order'=> 0
                ]);
            }
        }

        return redirect()->route('aset.index')->with('success', 'Data aset dan file berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Aset $aset)
    {
        // Ambil data media
    $files = Media::where('ref_table', 'aset') // Coba pakai nama singular
              ->where('ref_id', $aset->id)
              ->latest()
              ->get();

    return view('pages.aset.show', compact('aset', 'files'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aset $aset)
    {
        $kategoris = KategoriAset::all();

        // Ambil file yang sudah ada untuk ditampilkan di form edit
        $files = Media::where('ref_table', 'aset')
                      ->where('ref_id', $aset->id)
                      ->get();

        return view('pages.aset.edit', compact('aset', 'kategoris', 'files'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aset $aset)
    {
        // 1. Validasi Data Aset + File
        $request->validate([
            'kode_aset' => 'required|unique:asets,kode_aset,' . $aset->id . ',id',
            'nama_aset' => 'required',
            'kategori_id' => 'required|exists:kategori_asets,kategori_id', // Validasi baru
            'tanggal_perolehan' => 'required|date',
            'nilai_perolehan' => 'required|numeric',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi' => 'required',
            'penanggung_jawab' => 'required',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:5120'
        ]);

        // 2. Update Data Aset
        $aset->update($request->except('files'));

        // 3. Proses Upload File BARU (Tambahan)
        if ($request->hasFile('files')) {
            $path = public_path('uploads');
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $mimeType = $file->getClientMimeType();
                $file->move($path, $filename);

                Media::create([
                    'ref_table' => 'aset',
                    'ref_id'    => $aset->id,
                    'file_name' => $filename,
                    'mime_type' => $mimeType,
                    'caption'   => $file->getClientOriginalName(),
                ]);
            }
        }
        return redirect()->route('aset.index')->with('success', 'Data aset berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aset $aset)
    {
        $aset->delete();
        return redirect()->route('aset.index')->with('success', 'Data aset berhasil dihapus!');
    }
}
