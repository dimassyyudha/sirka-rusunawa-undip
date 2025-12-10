@extends('layouts.admin.app')

@section('title', 'Data Lokasi Aset')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets-admin/vendors/simple-datatables/style.css') }}">
@endpush

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Lokasi Aset</h3>
                    <p class="text-subtitle text-muted">Daftar lokasi penempatan aset desa beserta denahnya.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Lokasi Aset</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        {{-- KIRI: Tombol Tambah --}}
                        <div class="col-md-6 mb-3 mb-md-0">
                            <a href="{{ route('lokasi-aset.create') }}" class="btn btn-primary d-inline-flex align-items-center">
                                <i class="bi bi-plus-circle me-2"></i> Tambah Lokasi
                            </a>
                        </div>
                    </div>
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
                                <th>Denah / Foto</th>
                                <th>Aset Terkait</th>
                                <th>Alamat Lokasi</th>
                                <th>RT / RW</th>
                                <th style="width: 20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lokasiAset as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{-- PERBAIKAN: Langsung panggil $item->media karena relasinya hasOne --}}
                                        @php
                                            $foto = $item->media;
                                        @endphp

                                        @if($foto)
                                            <img src="{{ asset('uploads/lokasi/' . $foto->file_name) }}"
                                                 alt="Denah"
                                                 class="rounded"
                                                 style="width: 80px; height: 60px; object-fit: cover; cursor: pointer;"
                                                 onclick="window.location.href='{{ route('lokasi-aset.show', $item->lokasi_id) }}'">
                                        @else
                                            <span class="badge bg-secondary">No Image</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->aset)
                                            <span class="fw-bold">{{ $item->aset->nama_aset }}</span>
                                            <br>
                                            <small class="text-muted">{{ $item->aset->kode_aset }}</small>
                                        @else
                                            <span class="text-danger fst-italic">Aset Terhapus</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->lokasi_text }}</td>
                                    <td>
                                        <span class="badge bg-light-primary text-primary">RT {{ $item->rt }}</span>
                                        <span class="badge bg-light-info text-info">RW {{ $item->rw }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            {{-- Tombol Lihat --}}
                                            <a href="{{ route('lokasi-aset.show', $item->lokasi_id) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>Detail
                                            </a>

                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('lokasi-aset.edit', $item->lokasi_id) }}" class="btn btn-warning btn-sm" title="Edit Data">
                                                <i class="bi bi-pencil-square"></i>Edit
                                            </a>

                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('lokasi-aset.destroy', $item->lokasi_id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data lokasi ini?')" title="Hapus Data">
                                                    <i class="bi bi-trash-fill"></i>Hapus
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
