@extends('layouts.admin.app')
@section('title', 'Detail Pemeliharaan')

@section('content')
<div class="page-heading">
    <h3>Detail Pemeliharaan</h3>
</div>
<section class="section">
    <div class="row">
        {{-- Kiri: Detail --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h4>Info Pengerjaan</h4></div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th class="bg-light">Aset</th>
                            <td>{{ $pemeliharaan->aset->nama_aset }} ({{ $pemeliharaan->aset->kode_aset }})</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Tanggal</th>
                            <td>{{ $pemeliharaan->tanggal->translatedFormat('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Pelaksana</th>
                            <td>{{ $pemeliharaan->pelaksana }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Biaya</th>
                            <td class="fw-bold text-success">Rp {{ number_format($pemeliharaan->biaya, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Tindakan</th>
                            <td>{{ $pemeliharaan->tindakan }}</td>
                        </tr>
                    </table>
                    <a href="{{ route('pemeliharaan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                </div>
            </div>
        </div>

        {{-- Kanan: Galeri Bukti --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h4>Bukti Dokumentasi</h4></div>
                <div class="card-body">
                    @if($pemeliharaan->bukti->count() > 0)
                        <div class="row g-2">
                            @foreach($pemeliharaan->bukti as $file)
                                <div class="col-md-6">
                                    <a href="{{ asset('uploads/pemeliharaan/' . $file->file_name) }}" download title="Download">
                                        <img src="{{ asset('uploads/pemeliharaan/' . $file->file_name) }}"
                                             class="img-fluid rounded border w-100"
                                             style="height: 200px; object-fit: cover;">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-light-secondary text-center">
                            Tidak ada bukti foto yang dilampirkan.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
