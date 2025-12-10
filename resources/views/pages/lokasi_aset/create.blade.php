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

                {{-- Pilihan Aset --}}
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
                    <label>Lokasi (Jalan/Gedung)</label>
                    <input type="text" name="lokasi_text" class="form-control" required placeholder="Contoh: Jl. Merdeka No. 10">
                </div>

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

                {{-- INPUT FILE DENGAN NAMA BARU --}}
                <div class="mb-3">
                    <label>Foto Lokasi (media_file)</label>
                    <input type="file" name="media_file" class="form-control" accept="image/*">
                    <small class="text-muted">Format: JPG/PNG, Maks: 4MB</small>
                </div>

                <div class="mb-3">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('lokasi-aset.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
