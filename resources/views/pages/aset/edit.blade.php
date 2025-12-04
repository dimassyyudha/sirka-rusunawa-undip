{{-- resources/views/aset/edit.blade.php --}}
@extends('layouts.admin.app')

@section('title', 'Edit Aset')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Aset</h3>
                <p class="text-subtitle text-muted">Perbarui data aset dan kelola dokumen lampiran.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('aset.index') }}">Daftar Aset</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Aset</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">

        {{-- KARTU 1: FORM UPDATE DATA UTAMA & UPLOAD BARU --}}
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="card-title">Data Aset</h4>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                {{-- Perhatikan enctype="multipart/form-data" agar bisa upload file --}}
                <form action="{{ route('aset.update', $aset->aset_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kode Aset</label>
                                <input type="text" name="kode_aset" class="form-control" value="{{ old('kode_aset', $aset->kode_aset) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Aset</label>
                                <input type="text" name="nama_aset" class="form-control" value="{{ old('nama_aset', $aset->nama_aset) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="kategori_id" class="form-select" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->kategori_id }}" {{ old('kategori_id', $aset->kategori_id) == $kategori->kategori_id ? 'selected' : '' }}>
                                            {{ $kategori->nama }} ({{ $kategori->kode }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kondisi</label>
                                <select name="kondisi" class="form-select" required>
                                    <option value="Baik" {{ old('kondisi', $aset->kondisi) == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Rusak Ringan" {{ old('kondisi', $aset->kondisi) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="Rusak Berat" {{ old('kondisi', $aset->kondisi) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Perolehan</label>
                                <input type="date" name="tgl_perolehan" class="form-control" value="{{ old('tgl_perolehan', $aset->tgl_perolehan) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nilai Perolehan (Rp)</label>
                                <input type="number" name="nilai_perolehan" class="form-control" value="{{ old('nilai_perolehan', $aset->nilai_perolehan) }}" required>
                            </div>
                        </div>
                    </div>
                    {{-- INPUT FILE BARU --}}
                    <div class="mb-4 p-3 border rounded bg-light">
                        <label class="form-label fw-bold text-primary"><i class="bi bi-upload"></i> Upload File Baru (Opsional)</label>
                        <input class="form-control" type="file" name="files[]" multiple>
                        <small class="text-muted">Anda bisa memilih banyak file sekaligus (Gambar/PDF/Word).</small>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('aset.index') }}" class="btn btn-light me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- KARTU 2: LIST FILE & HAPUS FILE (Terpisah dari form update) --}}
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">File Terlampir</h4>
            </div>
            <div class="card-body">
                @if($files->isEmpty())
                    <p class="text-muted fst-italic">Belum ada dokumen atau foto yang dilampirkan pada aset ini.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama File</th>
                                    <th style="width: 150px;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($files as $file)
                                    <tr>
                                        <td>
                                            <a href="{{ asset('uploads/'.$file->file_name) }}" target="_blank" class="d-flex align-items-center text-decoration-none">
                                                <i class="bi bi-file-earmark-text fs-4 me-2"></i>
                                                {{ $file->caption }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            {{-- Form Hapus File (Ini Form Terpisah) --}}
                                            <form action="{{ route('media.destroy', $file->media_id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus file ini?')">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </section>
</div>
@endsection