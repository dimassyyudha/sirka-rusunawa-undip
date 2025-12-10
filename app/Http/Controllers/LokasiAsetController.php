<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\LokasiAset;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // Gunakan Facade File untuk hapus fisik

class LokasiAsetController extends Controller
{
    public function index()
    {
        // Mengambil data lokasi beserta relasi aset dan medianya
        $lokasiAset = LokasiAset::with(['aset', 'media'])
            ->latest('lokasi_id')
            ->paginate(10);

        return view('pages.lokasi_aset.index', compact('lokasiAset'));
    }

    public function create()
    {
        $aset = Aset::all();
        return view('pages.lokasi_aset.create', compact('aset'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'aset_id'     => 'required|exists:aset,aset_id',
            'lokasi_text' => 'required|string|max:255',
            'rt'          => 'required|string|max:5', // Sesuaikan tipe data
            'rw'          => 'required|string|max:5',
            'keterangan'  => 'nullable|string',
            'media_file'  => 'nullable|image|max:4096', // <-- Nama input sesuai request
        ]);

        // 1. Simpan Data Lokasi
        $lokasi = LokasiAset::create([
            'aset_id'     => $request->aset_id,
            'lokasi_text' => $request->lokasi_text,
            'rt'          => $request->rt,
            'rw'          => $request->rw,
            'keterangan'  => $request->keterangan,
        ]);

        // 2. Upload Foto Lokasi (media_file)
        if ($request->hasFile('media_file')) {
            $this->handleUpload($request->file('media_file'), $lokasi->lokasi_id);
        }

        return redirect()->route('lokasi-aset.index')
            ->with('success', 'Lokasi aset berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $lokasiAset = LokasiAset::with('media')->findOrFail($id);
        $aset = Aset::all();

        // PERBAIKAN: Langsung ambil properti media, JANGAN pakai first()
        $media = $lokasiAset->media;

        return view('pages.lokasi_aset.edit', compact('lokasiAset', 'aset', 'media'));
    }

    public function show($id)
    {
        $lokasiAset = LokasiAset::with(['aset', 'media'])->findOrFail($id);
        return view('pages.lokasi_aset.show', compact('lokasiAset'));
    }

    public function update(Request $request, $id)
    {
        $lokasiAset = LokasiAset::findOrFail($id);

        $request->validate([
            'aset_id'     => 'required|exists:aset,aset_id',
            'lokasi_text' => 'required|string|max:255',
            'rt'          => 'required|string|max:5',
            'rw'          => 'required|string|max:5',
            'keterangan'  => 'nullable|string',
            'media_file'  => 'nullable|image|max:4096',
        ]);

        // Update data lokasi
        $lokasiAset->update([
            'aset_id'     => $request->aset_id,
            'lokasi_text' => $request->lokasi_text,
            'rt'          => $request->rt,
            'rw'          => $request->rw,
            'keterangan'  => $request->keterangan,
        ]);

        // Jika ada upload foto baru
        if ($request->hasFile('media_file')) {

            // Cek & Hapus foto lama
            $oldMedia = Media::where('ref_table', 'lokasi_aset')
                ->where('ref_id', $lokasiAset->lokasi_id)
                ->first();

            if ($oldMedia) {
                $oldPath = public_path('uploads/lokasi/' . $oldMedia->file_name);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
                $oldMedia->delete(); // Hapus dari database
            }

            // Upload foto baru
            $this->handleUpload($request->file('media_file'), $lokasiAset->lokasi_id);
        }

        return redirect()->route('lokasi-aset.index')
            ->with('success', 'Lokasi aset berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $lokasiAset = LokasiAset::findOrFail($id);

        // Hapus media terkait
        $medias = Media::where('ref_table', 'lokasi_aset')
            ->where('ref_id', $lokasiAset->lokasi_id)
            ->get();

        foreach ($medias as $media) {
            $path = public_path('uploads/lokasi/' . $media->file_name);
            if (File::exists($path)) {
                File::delete($path);
            }
            $media->delete();
        }

        // Hapus data lokasi
        $lokasiAset->delete();

        return redirect()->route('lokasi-aset.index')
            ->with('success', 'Lokasi aset berhasil dihapus!');
    }

    // Fungsi Helper untuk Upload (Agar rapi)
    private function handleUpload($file, $lokasiId)
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = public_path('uploads/lokasi'); // Simpan di folder public/uploads/lokasi

        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $file->move($path, $filename);

        Media::create([
            'ref_table' => 'lokasi_aset',
            'ref_id'    => $lokasiId,
            'file_name' => $filename, // Sesuaikan dengan kolom DB Anda (file_name)
            'mime_type' => $file->getClientMimeType(),
            'caption'   => 'Foto Lokasi',
            'sort_order'=> 1,
        ]);
    }
}
