@extends('layouts.admin.app')

@section('title', 'Detail Aset')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Detail Aset</h3>
                    <p class="text-subtitle text-muted">Informasi lengkap spesifikasi dan dokumen aset.</p>
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
                {{-- KOLOM KIRI: GALERI FOTO --}}
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Dokumentasi Aset</h4>
                        </div>
                        <div class="card-body">
                            @if ($files->count() > 0)
                                {{-- 1. FOTO UTAMA (BESAR) --}}
                                @php $mainFile = $files->first(); @endphp
                                <div class="main-image mb-3">
                                    <a href="{{ asset('uploads/' . $mainFile->file_name) }}"
                                       download="{{ 'Aset_' . $aset->kode_aset . '_Main' }}"
                                       title="Klik untuk mengunduh">
                                        <img src="{{ asset('uploads/' . $mainFile->file_name) }}"
                                             class="img-fluid rounded shadow-sm w-100"
                                             style="object-fit: cover; height: 350px; border: 2px solid #eee;">
                                    </a>
                                </div>

                                <div class="alert alert-light-primary color-primary mb-3">
                                    <i class="bi bi-info-circle me-1"></i> Klik gambar untuk <b>mengunduh</b>.
                                </div>

                                {{-- 2. GALERI MINI (Sisa Foto) --}}
                                @if($files->count() > 1)
                                    <h6 class="text-muted mb-2">Lampiran Lainnya:</h6>
                                    <div class="row g-2">
                                        @foreach($files->skip(1) as $file)
                                            <div class="col-3">
                                                <a href="{{ asset('uploads/' . $file->file_name) }}"
                                                   download="{{ 'Aset_' . $aset->kode_aset . '_' . $loop->iteration }}"
                                                   title="{{ $file->caption }}">
                                                    <img src="{{ asset('uploads/' . $file->file_name) }}"
                                                         class="img-thumbnail"
                                                         style="width: 100%; height: 70px; object-fit: cover;">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @else
                                {{-- TAMPILAN JIKA TIDAK ADA FOTO --}}
                                <div class="text-center p-5 bg-light rounded border border-dashed">
                                    <i class="bi bi-camera-video-off text-secondary display-4"></i>
                                    <p class="mt-3 text-muted">Belum ada foto/dokumen yang diupload.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: TABEL INFORMASI --}}
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Spesifikasi Aset</h4>
                            {{-- Tombol Edit (Sesuaikan parameter ID) --}}
                            <a href="{{ route('aset.edit', $aset->aset_id ?? $aset->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i> Edit Data
                            </a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th class="bg-light" style="width: 35%;">Kode Aset</th>
                                        <td class="fw-bold text-primary">{{ $aset->kode_aset }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Nama Aset</th>
                                        <td>{{ $aset->nama_aset }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Kategori</th>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ $aset->kategoriAset ? $aset->kategoriAset->nama : 'Tidak Ada Kategori' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Tanggal Perolehan</th>
                                        {{-- Menggunakan accessor tanggal jika ada, atau format manual --}}
                                        <td>{{ \Carbon\Carbon::parse($aset->tgl_perolehan ?? $aset->tanggal_perolehan)->translatedFormat('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Nilai Aset</th>
                                        <td>Rp {{ number_format($aset->nilai_perolehan, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Kondisi Saat Ini</th>
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
                                    @if($aset->keterangan)
                                    <tr>
                                        <th class="bg-light">Keterangan</th>
                                        <td>{{ $aset->keterangan }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>

                            <div class="mt-4 d-grid gap-2">
                                <a href="{{ route('aset.index') }}" class="btn btn-light-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Aset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
