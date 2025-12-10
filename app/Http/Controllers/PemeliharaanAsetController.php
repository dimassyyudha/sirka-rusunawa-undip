<?php

namespace App\Http\Controllers;

use App\Models\PemeliharaanAset;
use App\Models\Aset;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PemeliharaanAsetController extends Controller
{
    public function index()
    {
        $dataPemeliharaan = PemeliharaanAset::with(['aset', 'bukti'])->latest('tanggal')->paginate(10);
        return view('pages.pemeliharaan.index', compact('dataPemeliharaan'));
    }

    public function create()
    {
        $asets = Aset::all();
        return view('pages.pemeliharaan.create', compact('asets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'aset_id'   => 'required|exists:aset,aset_id',
            'tanggal'   => 'required|date',
            'tindakan'  => 'required|string',
            'biaya'     => 'required|numeric',
            'pelaksana' => 'required|string',
            'bukti.*'   => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:4096', // Validasi array file
        ]);

        // 1. Simpan Data Utama
        $pemeliharaan = PemeliharaanAset::create($request->except('bukti'));

        // 2. Loop Multiple File Upload
        if ($request->hasFile('bukti')) {
            $path = public_path('uploads/pemeliharaan');
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            foreach ($request->file('bukti') as $index => $file) {
                $filename = time() . '_' . $index . '_' . $file->getClientOriginalName();
                $file->move($path, $filename);

                Media::create([
                    'ref_table' => 'pemeliharaan_aset',
                    'ref_id'    => $pemeliharaan->pemeliharaan_id,
                    'file_name' => $filename,
                    'mime_type' => $file->getClientMimeType(),
                    'caption'   => 'Bukti ' . ($index + 1),
                    'sort_order'=> $index + 1
                ]);
            }
        }

        return redirect()->route('pemeliharaan.index')->with('success', 'Data pemeliharaan dicatat!');
    }

    public function show($id)
    {
        $pemeliharaan = PemeliharaanAset::with(['aset', 'bukti'])->findOrFail($id);
        return view('pages.pemeliharaan.show', compact('pemeliharaan'));
    }

    public function edit($id)
    {
        $pemeliharaan = PemeliharaanAset::with('bukti')->findOrFail($id);
        $asets = Aset::all();
        return view('pages.pemeliharaan.edit', compact('pemeliharaan', 'asets'));
    }

    public function update(Request $request, $id)
    {
        $pemeliharaan = PemeliharaanAset::findOrFail($id);

        $request->validate([
            'aset_id'   => 'required|exists:aset,aset_id',
            'tanggal'   => 'required|date',
            'tindakan'  => 'required|string',
            'biaya'     => 'required|numeric',
            'pelaksana' => 'required|string',
            'bukti.*'   => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        // Update data utama
        $pemeliharaan->update($request->except('bukti'));

        // Jika ada file BARU yang diupload (Append/Tambah)
        if ($request->hasFile('bukti')) {
            $path = public_path('uploads/pemeliharaan');

            // Hitung jumlah file yang sudah ada untuk urutan sort
            $existingCount = Media::where('ref_table', 'pemeliharaan_aset')
                                  ->where('ref_id', $id)->count();

            foreach ($request->file('bukti') as $index => $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $file->move($path, $filename);

                Media::create([
                    'ref_table' => 'pemeliharaan_aset',
                    'ref_id'    => $pemeliharaan->pemeliharaan_id,
                    'file_name' => $filename,
                    'mime_type' => $file->getClientMimeType(),
                    'caption'   => 'Bukti Tambahan',
                    'sort_order'=> $existingCount + $index + 1
                ]);
            }
        }

        return redirect()->route('pemeliharaan.index')->with('success', 'Data diperbarui!');
    }

    public function destroy($id)
    {
        $pemeliharaan = PemeliharaanAset::findOrFail($id);

        // Hapus semua file bukti
        $buktis = Media::where('ref_table', 'pemeliharaan_aset')->where('ref_id', $id)->get();
        foreach ($buktis as $media) {
            $path = public_path('uploads/pemeliharaan/' . $media->file_name);
            if (File::exists($path)) {
                File::delete($path);
            }
            $media->delete();
        }

        $pemeliharaan->delete();
        return redirect()->route('pemeliharaan.index')->with('success', 'Data dihapus!');
    }

    // Optional: Fitur hapus satu foto spesifik (bisa dipanggil via Ajax/Route khusus)
    public function deleteBukti($mediaId) {
        $media = Media::findOrFail($mediaId);
        $path = public_path('uploads/pemeliharaan/' . $media->file_name);
        if (File::exists($path)) File::delete($path);
        $media->delete();
        return back()->with('success', 'File bukti dihapus.');
    }
}
