@extends('layouts.admin.app')

@section('title', 'Riwayat Pemeliharaan')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets-admin/vendors/simple-datatables/style.css') }}">
@endpush

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Riwayat Pemeliharaan</h3>
                    <p class="text-subtitle text-muted">Daftar riwayat perbaikan dan perawatan aset desa.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pemeliharaan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Tabel Pemeliharaan</h4>
                    <a href="{{ route('pemeliharaan.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-2"></i> Catat Pemeliharaan
                    </a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Aset Terkait</th>
                                <th>Tindakan</th>
                                <th>Biaya</th>
                                <th>Bukti</th>
                                <th style="width: 20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataPemeliharaan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="fw-bold">{{ $item->aset->nama_aset }}</span>
                                        <br>
                                        <small class="text-muted">{{ $item->aset->kode_aset }}</small>
                                    </td>
                                    <td>{{ Str::limit($item->tindakan, 40) }}</td>
                                    <td>
                                        <span class="badge bg-light-success text-success">
                                            Rp {{ number_format($item->biaya, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($item->bukti->count() > 0)
                                            <span class="badge bg-secondary">
                                                <i class="bi bi-paperclip"></i> {{ $item->bukti->count() }} File
                                            </span>
                                        @else
                                            <span class="badge bg-light-secondary text-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            {{-- Tombol Detail --}}
                                            <a href="{{ route('pemeliharaan.show', $item->pemeliharaan_id) }}" class="btn btn-info btn-sm text-white" title="Lihat Detail">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>

                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('pemeliharaan.edit', $item->pemeliharaan_id) }}" class="btn btn-warning btn-sm" title="Edit Data">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>

                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('pemeliharaan.destroy', $item->pemeliharaan_id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus Data">
                                                    <i class="bi bi-trash-fill"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts-bottom')
    <script src="{{ asset('assets-admin/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script>
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>
@endpush
