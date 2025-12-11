@extends('layouts.admin.app')
@section('title', 'Tambah Aset')

@section('content')
<div class="page-heading">
    <h3>Tambah Aset Baru</h3>
</div>
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('aset.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    {{-- KOLOM KIRI --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Kode Aset</label>
                            <input type="text" name="kode_aset" class="form-control" placeholder="Contoh: AST-001" required>
                        </div>
                        <div class="mb-3">
                            <label>Nama Aset</label>
                            <input type="text" name="nama_aset" class="form-control" placeholder="Contoh: Laptop Asus" required>
                        </div>
                        <div class="mb-3">
                            <label>Kategori</label>
                            <select name="kategori_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->kategori_id }}" {{ old('kategori_id') == $kategori->kategori_id ? 'selected' : '' }}>
                                    {{ $kategori->nama }} ({{ $kategori->kode }})
                                </option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- KOLOM KANAN --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Tanggal Perolehan</label>
                            <input type="date" name="tgl_perolehan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Nilai Perolehan (Rp)</label>
                            <input type="number" name="nilai_perolehan" class="form-control" placeholder="0" required>
                        </div>
                        <div class="mb-3">
                            <label>Kondisi Aset</label>
                            <select name="kondisi" class="form-select" required>
                                <option value="Baik">Baik</option>
                                <option value="Rusak Ringan">Rusak Ringan</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                            </select>
                        </div>
                    </div>

                    {{-- KOLOM BAWAH (FULL WIDTH) --}}
                    <div class="col-12 mb-3">
                        <label>Foto Aset</label>
                        <input type="file" name="foto_aset" class="form-control" accept="image/*">
                    </div>

                    <div class="col-12 mb-3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="2" placeholder="Keterangan tambahan..."></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('aset.index') }}" class="btn btn-light-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection