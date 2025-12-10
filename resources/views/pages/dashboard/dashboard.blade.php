@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-heading">
    <h3>Dashboard Sistem Inventaris</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-9">

            {{-- BARIS 1: KARTU STATISTIK --}}
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon purple"><i class="bi bi-box-seam"></i></div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Total Aset</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalAset }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon blue"><i class="bi bi-cash-stack"></i></div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Nilai Aset</h6>
                                    <h6 class="font-extrabold mb-0" style="font-size: 0.9rem">Rp {{ number_format($totalNilaiAset, 0, ',', '.') }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon green"><i class="bi bi-tools"></i></div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Biaya Rawat</h6>
                                    <h6 class="font-extrabold mb-0" style="font-size: 0.9rem">Rp {{ number_format($totalBiayaMt, 0, ',', '.') }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon red"><i class="bi bi-geo-alt-fill"></i></div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Total Lokasi</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalLokasi }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BARIS 2: TABEL ACTIVITY --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Aset Terbaru Ditambahkan</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-lg">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Kategori</th>
                                            <th>Kondisi</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($latestAsets as $aset)
                                        <tr>
                                            <td class="col-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-md">
                                                        <img src="{{ asset('assets-admin/images/faces/1.jpg') }}"> {{-- Bisa diganti foto aset jika ada --}}
                                                    </div>
                                                    <p class="font-bold ms-3 mb-0">{{ $aset->nama_aset }}</p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0">{{ $aset->kategoriAset->nama ?? '-' }}</p>
                                            </td>
                                            <td class="col-auto">
                                                @if($aset->kondisi == 'Baik')
                                                    <span class="badge bg-success">Baik</span>
                                                @elseif($aset->kondisi == 'Rusak Ringan')
                                                    <span class="badge bg-warning">Rusak Ringan</span>
                                                @else
                                                    <span class="badge bg-danger">Rusak Berat</span>
                                                @endif
                                            </td>
                                            <td class="col-auto">
                                                <p class="mb-0">Rp {{ number_format($aset->nilai_perolehan, 0, ',', '.') }}</p>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: GRAFIK & LIST KECIL --}}
        <div class="col-12 col-lg-3">
            {{-- GRAFIK KONDISI --}}
            <div class="card">
                <div class="card-header">
                    <h4>Kondisi Aset</h4>
                </div>
                <div class="card-body">
                    <div id="chart-kondisi"></div>
                </div>
            </div>

            {{-- LIST PEMELIHARAAN TERAKHIR --}}
            <div class="card">
                <div class="card-header">
                    <h4>Pemeliharaan Terakhir</h4>
                </div>
                <div class="card-content pb-4">
                    @foreach($latestMt as $mt)
                    <div class="recent-message d-flex px-4 py-3">
                        <div class="avatar avatar-lg">
                            <div class="stats-icon green mb-2"><i class="bi bi-wrench"></i></div>
                        </div>
                        <div class="name ms-4">
                            <h5 class="mb-1">{{ $mt->aset->nama_aset }}</h5>
                            <h6 class="text-muted mb-0">{{ $mt->tindakan }}</h6>
                            <small class="text-success fw-bold">Rp {{ number_format($mt->biaya, 0, ',', '.') }}</small>
                        </div>
                    </div>
                    @endforeach
                    <div class="px-4">
                        <a href="{{ route('pemeliharaan.index') }}" class='btn btn-block btn-xl btn-light-primary font-bold mt-3'>Lihat Semua</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts-bottom')
    {{-- Script untuk Grafik (ApexCharts) --}}
    <script src="{{ asset('assets-admin/vendors/apexcharts/apexcharts.js') }}"></script>
    <script>
        // Data dari Controller
        var dataKondisi = @json(array_values($chartKondisi));
        var labelKondisi = @json(array_keys($chartKondisi));

        var optionsProfileVisit = {
            annotations: { position: 'back' },
            dataLabels: { enabled: false },
            chart: {
                type: 'donut', // Ganti ke pie/donut agar cocok untuk proporsi
                height: 300
            },
            fill: { opacity: 1 },
            series: dataKondisi.length > 0 ? dataKondisi : [0], // Cegah error jika kosong
            labels: labelKondisi.length > 0 ? labelKondisi : ['No Data'],
            colors: ['#435ebe', '#55c6e8', '#ff7976'], // Warna Mazer
            legend: { position: 'bottom' },
        }

        var chartProfileVisit = new ApexCharts(document.querySelector("#chart-kondisi"), optionsProfileVisit);
        chartProfileVisit.render();
    </script>
@endpush