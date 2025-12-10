@extends('layouts.admin.app')
@section('title', 'Detail Aset')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Detail Aset</h3>
                <p class="text-subtitle text-muted">Informasi lengkap aset {{ $aset->nama_aset }}.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('aset.index') }}">Data Aset</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            {{-- KOLOM KIRI: FOTO ASET --}}
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Foto Aset</h4>
                    </div>
                    <div class="card-body">
                        {{-- Ambil foto pertama --}}
                        @php $mainPhoto = $files->first(); @endphp

                        @if($mainPhoto)
                            <div class="mb-3 text-center">
                                <a href="{{ asset('uploads/' . $mainPhoto->file_name) }}"
                                   download="{{ $aset->kode_aset }}_main.jpg"
                                   title="Klik untuk mengunduh">
                                    <img src="{{ asset('uploads/' . $mainPhoto->file_name) }}"
                                         class="img-fluid rounded shadow-sm"
                                         style="width: 100%; height: auto; object-fit: cover; border: 2px solid #eee;">
                                </a>
                                <div class="mt-2 text-sm text-primary">
                                    <i class="bi bi-download me-1"></i> Klik gambar untuk mengunduh
                                </div>
                            </div>

                            {{-- Gallery Kecil (Jika ada lebih dari 1 foto) --}}
                            @if($files->count() > 1)
                                <hr>
                                <p class="text-muted mb-2">Foto Lainnya:</p>
                                <div class="row g-2">
                                    @foreach($files->skip(1) as $file)
                                        <div class="col-3">
                                            <a href="{{ asset('uploads/' . $file->file_name) }}" download>
                                                <img src="{{ asset('uploads/' . $file->file_name) }}"
                                                     class="img-thumbnail"
                                                     style="width: 100%; height: 60px; object-fit: cover;">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="text-center p-4 bg-light rounded">
                                <i class="bi bi-image text-secondary fs-1"></i>
                                <p class="text-muted mt-2">Belum ada foto aset.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: DETAIL --}}
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Spesifikasi</h4>
                        <a href="{{ route('aset.edit', $aset->aset_id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th style="width: 30%">Kode Aset</th>
                                    <td class="fw-bold">{{ $aset->kode_aset }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Aset</th>
                                    <td>{{ $aset->nama_aset }}</td>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $aset->kategoriAset ? $aset->kategoriAset->nama : '-' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tgl Perolehan</th>
                                    <td>{{ \Carbon\Carbon::parse($aset->tgl_perolehan)->translatedFormat('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Nilai Aset</th>
                                    <td>Rp {{ number_format($aset->nilai_perolehan, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Kondisi</th>
                                    <td>
                                        @if($aset->kondisi == 'Baik')
                                            <span class="badge bg-success">Baik</span>
                                        @elseif($aset->kondisi == 'Rusak Ringan')
                                            <span class="badge bg-warning">Rusak Ringan</span>
                                        @else
                                            <span class="badge bg-danger">Rusak Berat</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td>{{ $aset->keterangan ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-4">
                            <a href="{{ route('aset.index') }}" class="btn btn-secondary w-100">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection