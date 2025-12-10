@extends('layouts.admin.app')
@section('title', 'Detail Pemeliharaan')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Detail Pemeliharaan</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pemeliharaan.index') }}">Pemeliharaan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            {{-- KOLOM KIRI: BUKTI FOTO --}}
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Bukti Dokumentasi</h4>
                    </div>
                    <div class="card-body">
                        @if($pemeliharaan->bukti->count() > 0)
                            <div class="row g-2">
                                @foreach($pemeliharaan->bukti as $file)
                                    <div class="col-6">
                                        <div class="position-relative">
                                            <a href="{{ asset('uploads/pemeliharaan/' . $file->file_name) }}"
                                               download="Bukti_{{ $file->id }}.jpg" title="Klik Download">
                                                <img src="{{ asset('uploads/pemeliharaan/' . $file->file_name) }}"
                                                     class="img-fluid rounded border shadow-sm w-100"
                                                     style="height: 150px; object-fit: cover;">
                                            </a>
                                            <div class="mt-1 text-center">
                                                <small class="text-primary"><i class="bi bi-download"></i> Klik gambar untuk mengunduh</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center p-5 bg-light rounded border border-dashed">
                                <i class="bi bi-camera-video-off text-secondary fs-1"></i>
                                <p class="mt-2 text-muted">Tidak ada bukti foto dilampirkan.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: RINCIAN PENGERJAAN --}}
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Rincian Pengerjaan</h4>
                        <a href="{{ route('pemeliharaan.edit', $pemeliharaan->pemeliharaan_id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th style="width: 30%">Aset</th>
                                <td>
                                    <strong>{{ $pemeliharaan->aset->nama_aset }}</strong>
                                    <br><small class="text-muted">{{ $pemeliharaan->aset->kode_aset }}</small>
                                </td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td>{{ $pemeliharaan->tanggal->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th>Pelaksana</th>
                                <td>{{ $pemeliharaan->pelaksana }}</td>
                            </tr>
                            <tr>
                                <th>Biaya</th>
                                <td class="fw-bold text-success">Rp {{ number_format($pemeliharaan->biaya, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Tindakan</th>
                                <td>{{ $pemeliharaan->tindakan }}</td>
                            </tr>
                        </table>

                        <div class="mt-4">
                            <a href="{{ route('pemeliharaan.index') }}" class="btn btn-secondary w-100">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection