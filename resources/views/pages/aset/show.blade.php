@extends('layouts.admin.app')

@section('title', 'Detail Aset')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Detail Aset: {{ $aset->nama_aset }}</h3>
                    <p class="text-subtitle text-muted">Informasi lengkap dan dokumen terkait aset.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('aset.index') }}">Aset</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                {{-- KOLOM KIRI: INFO TEKS --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Informasi Aset</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 40%">Kode Aset</th>
                                    <td>{{ $aset->kode_aset }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Aset</th>
                                    <td>{{ $aset->nama_aset }}</td>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <td>{{ $aset->kategoriAset->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kondisi</th>
                                    <td>
                                        @if ($aset->kondisi == 'Baik')
                                            <span class="badge bg-success">Baik</span>
                                        @elseif($aset->kondisi == 'Rusak Ringan')
                                            <span class="badge bg-warning">Rusak Ringan</span>
                                        @else
                                            <span class="badge bg-danger">Rusak Berat</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nilai Perolehan</th>
                                    <td>Rp {{ number_format($aset->nilai_perolehan, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Perolehan</th>
                                    <td>{{ \Carbon\Carbon::parse($aset->tgl_perolehan)->translatedFormat('d F Y') }}</td>
                                </tr>
                            </table>

                            <div class="mt-4 d-flex justify-content-between">
                                <a href="{{ route('aset.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                {{-- Tombol Edit untuk memudahkan navigasi jika ingin mengubah --}}
                                <a href="{{ route('aset.edit', $aset->aset_id) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil-square"></i> Edit Data
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: LIST FILE (READ ONLY) --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Dokumen & Foto Lampiran</h4>
                        </div>
                        <div class="card-body">
                            @if($files->isEmpty())
                                <div class="alert alert-light-secondary color-secondary">
                                    <i class="bi bi-exclamation-circle"></i> Tidak ada dokumen atau foto yang dilampirkan.
                                </div>
                            @else
                                <div class="list-group">
                                    @foreach($files as $file)
                                        <a href="{{ asset('uploads/' . $file->file_name) }}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-file-earmark-text fs-3 me-3 text-primary"></i>
                                                <div>
                                                    <h6 class="mb-0 text-body">{{ $file->caption }}</h6>
                                                    <small class="text-muted" style="font-size: 0.8em;">
                                                        Diunggah: {{ $file->created_at->format('d M Y, H:i') }}
                                                    </small>
                                                </div>
                                            </div>
                                            <span class="badge bg-light-primary text-primary"><i class="bi bi-download"></i> Lihat</span>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection