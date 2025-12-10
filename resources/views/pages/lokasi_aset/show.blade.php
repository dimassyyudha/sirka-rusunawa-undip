@extends('layouts.admin.app')
@section('title', 'Detail Lokasi')

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
                        <li class="breadcrumb-item"><a href="{{ route('lokasi-aset.index') }}">Lokasi</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            {{-- KOLOM KIRI: DENAH --}}
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Foto / Denah Lokasi</h4>
                    </div>
                    <div class="card-body">
                        {{-- Menggunakan relasi hasOne: media --}}
                        @php $denah = $lokasiAset->media; @endphp

                        @if($denah)
                            <div class="text-center">
                                <a href="{{ asset('uploads/lokasi/' . $denah->file_name) }}"
                                   download="Denah_{{ $lokasiAset->lokasi_text }}.jpg"
                                   title="Download Denah">
                                    <img src="{{ asset('uploads/lokasi/' . $denah->file_name) }}"
                                         class="img-fluid rounded shadow-sm w-100"
                                         style="border: 2px solid #eee;">
                                </a>
                                <div class="mt-2 text-sm text-primary">
                                    <i class="bi bi-download me-1"></i> Klik gambar untuk mengunduh
                                </div>
                            </div>
                        @else
                            <div class="text-center p-5 bg-light rounded border border-dashed">
                                <i class="bi bi-map text-secondary fs-1"></i>
                                <p class="mt-2 text-muted">Tidak ada foto denah.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: DATA LOKASI --}}
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Informasi Lokasi</h4>
                        <a href="{{ route('lokasi-aset.edit', $lokasiAset->lokasi_id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th style="width: 30%">Aset Terkait</th>
                                <td>
                                    @if($lokasiAset->aset)
                                        <strong>{{ $lokasiAset->aset->nama_aset }}</strong>
                                        <br><small class="text-muted">{{ $lokasiAset->aset->kode_aset }}</small>
                                    @else
                                        <span class="text-danger">Aset Terhapus</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Alamat / Lokasi</th>
                                <td>{{ $lokasiAset->lokasi_text }}</td>
                            </tr>
                            <tr>
                                <th>RT / RW</th>
                                <td>RT {{ $lokasiAset->rt }} / RW {{ $lokasiAset->rw }}</td>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <td>{{ $lokasiAset->keterangan ?? '-' }}</td>
                            </tr>
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