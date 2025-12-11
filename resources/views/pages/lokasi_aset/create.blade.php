@extends('layouts.admin.app')
@section('title', 'Tambah Lokasi Aset')

@section('content')
    <div class="page-heading">
        <h3>Tambah Lokasi Aset</h3>
    </div>
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('lokasi-aset.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        {{-- KOLOM KIRI --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Pilih Aset</label>
                                <select name="aset_id" class="form-select" required>
                                    <option value="">-- Pilih Aset --</option>
                                    @foreach ($aset as $item)
                                        <option value="{{ $item->aset_id }}">
                                            {{ $item->kode_aset }} - {{ $item->nama_aset }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Alamat Lokasi (Jalan/Gedung)</label>
                                <input type="text" name="lokasi_text" class="form-control" required
                                    placeholder="Contoh: Jl. Merdeka No. 10">
                            </div>
                        </div>

                        {{-- KOLOM KANAN --}}
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>RT</label>
                                    <input type="text" name="rt" class="form-control" required placeholder="001">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>RW</label>
                                    <input type="text" name="rw" class="form-control" required placeholder="005">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Upload Foto Lokasi / Denah</label>
                                <input type="file" name="media_file" class="form-control" accept="image/*">
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2"></textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('lokasi-aset.index') }}" class="btn btn-light-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
