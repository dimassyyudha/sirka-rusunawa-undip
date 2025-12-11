@extends('layouts.admin.app')

@section('title', 'Data Mutasi Aset')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets-admin/vendors/simple-datatables/style.css') }}">
@endpush

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Mutasi Aset</h3>
                    <p class="text-subtitle text-muted">Riwayat perpindahan, perubahan status, atau hibah aset.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Mutasi Aset</li>
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
                            <a href="{{ route('mutasi.create') }}" class="btn btn-primary d-inline-flex align-items-center">
                                <i class="bi bi-plus-circle me-2"></i> Tambah Mutasi
                            </a>
                        </div>
                        {{-- KANAN: Filter Dropdown (Jenis Mutasi) --}}
                        <div class="col-md-6 d-flex justify-content-md-end">
                            <form action="{{ route('mutasi.index') }}" method="GET"
                                class="d-flex align-items-center w-100 justify-content-end">
                                <div class="input-group" style="max-width: 300px;">
                                    <span class="input-group-text bg-white"><i class="bi bi-funnel"></i></span>
                                    <select name="jenis_mutasi" class="form-select" onchange="this.form.submit()">
                                        <option value="">Semua Jenis</option>
                                        @php
                                            $jenisList = [
                                                'Pemindahan',
                                                'Penghapusan',
                                                'Perubahan Status',
                                                'Peminjaman',
                                                'Pengembalian',
                                            ];
                                        @endphp
                                        @foreach ($jenisList as $jenis)
                                            <option value="{{ $jenis }}"
                                                {{ request('jenis_mutasi') == $jenis ? 'selected' : '' }}>
                                                {{ $jenis }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
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
                                <th>Tanggal</th>
                                <th>Aset Terkait</th>
                                <th>Jenis Mutasi</th>
                                <th>Keterangan</th>
                                <th style="width: 15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataMutasi as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="fw-bold">{{ $item->aset->nama_aset }}</span>
                                        <br>
                                        <small class="text-muted">{{ $item->aset->kode_aset }}</small>
                                    </td>
                                    <td>
                                        @switch($item->jenis_mutasi)
                                            @case('Pemindahan')
                                                <span class="badge bg-primary">Pemindahan</span>
                                            @break

                                            @case('Penghapusan')
                                                <span class="badge bg-danger">Penghapusan</span>
                                            @break

                                            @case('Perubahan Status')
                                                <span class="badge bg-warning text-dark">Perubahan Status</span>
                                            @break

                                            @case('Peminjaman')
                                                <span class="badge bg-info text-dark">Peminjaman</span>
                                            @break

                                            @case('Pengembalian')
                                                <span class="badge bg-success">Pengembalian</span>
                                            @break

                                            @default
                                                <span class="badge bg-secondary">{{ $item->jenis_mutasi }}</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $item->keterangan ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('mutasi.edit', $item->mutasi_id) }}"
                                                class="btn btn-warning btn-sm" title="Edit Data">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>

                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('mutasi.destroy', $item->mutasi_id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Yakin ingin menghapus data mutasi ini?')"
                                                    title="Hapus Data">
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