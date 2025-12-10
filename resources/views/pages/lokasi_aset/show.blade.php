@extends('layouts.admin.app')

@section('title', 'Detail Lokasi Aset')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Detail Lokasi</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('lokasi-aset.index') }}">Lokasi Aset</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Foto / Denah Lokasi</h4>
                        </div>
                        <div class="card-body text-center">
                            {{-- PERBAIKAN: Hapus ->first() --}}
                            @php
                                $foto = $lokasiAset->media;
                            @endphp

                            @if ($foto)
                                <div class="image-container mb-3">
                                    <a href="{{ asset('uploads/lokasi/' . $foto->file_name) }}"
                                       download="{{ 'Lokasi_' . $lokasiAset->lokasi_text . '_' . $foto->file_name }}"
                                       title="Klik gambar untuk mengunduh">

                                        <img src="{{ asset('uploads/lokasi/' . $foto->file_name) }}"
                                             alt="Foto Lokasi"
                                             class="img-fluid rounded shadow-sm"
                                             style="width: 100%; height: auto; object-fit: cover; border: 2px solid #eee;">
                                    </a>
                                </div>
                                <div class="alert alert-light-primary color-primary">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Klik gambar di atas untuk <b>mengunduh</b>.
                                </div>
                            @else
                                <div class="text-center p-5 bg-light rounded border border-dashed">
                                    <i class="bi bi-image text-secondary display-4"></i>
                                    <p class="mt-3 text-muted">Belum ada foto denah.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Informasi Detail</h4>
                            <a href="{{ route('lokasi-aset.edit', $lokasiAset->lokasi_id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i> Edit Data
                            </a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 30%;" class="bg-light">Aset Terkait</th>
                                        <td>
                                            @if($lokasiAset->aset)
                                                <span class="fw-bold">{{ $lokasiAset->aset->nama_aset }}</span>
                                                <br>
                                                <small class="text-muted">Kode: {{ $lokasiAset->aset->kode_aset }}</small>
                                            @else
                                                <span class="text-danger">Data Aset Terhapus</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Alamat Lokasi</th>
                                        <td>{{ $lokasiAset->lokasi_text }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">RT / RW</th>
                                        <td>RT {{ $lokasiAset->rt }} / RW {{ $lokasiAset->rw }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Keterangan</th>
                                        <td>{{ $lokasiAset->keterangan ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mt-4">
                                <a href="{{ route('lokasi-aset.index') }}" class="btn btn-secondary w-100">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
