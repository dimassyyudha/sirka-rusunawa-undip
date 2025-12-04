{{-- resources/views/aset/index.blade.php --}}
@extends('layouts.admin.app')

@section('title', 'Data Aset Inventaris')

@push('css')
    {{-- Tambahkan CSS untuk Simple Datatables --}}
    <link rel="stylesheet" href="{{ asset('assets-admin/vendors/simple-datatables/style.css') }}">
@endpush

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Aset Inventaris</h3>
                    <p class="text-subtitle text-muted">Daftar lengkap semua aset yang terdata.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Daftar Aset</li>
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
                            <a href="{{ route('aset.create') }}" class="btn btn-primary d-inline-flex align-items-center">
                                <i class="bi bi-plus-circle me-2"></i> Tambah Aset Baru
                            </a>
                        </div>

                        {{-- KANAN: Filter Kondisi --}}
                        <div class="col-md-6 d-flex justify-content-md-end">
                            <form action="{{ route('aset.index') }}" method="GET"
                                class="d-flex align-items-center w-100 justify-content-end">
                                <div class="input-group" style="max-width: 300px;">
                                    <span class="input-group-text bg-white"><i class="bi bi-funnel"></i> Kondisi:</span>

                                    <select name="kondisi" class="form-select" onchange="this.form.submit()">
                                        <option value="">Semua Kondisi</option>
                                        <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik
                                        </option>
                                        <option value="Rusak Ringan"
                                            {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan
                                        </option>
                                        <option value="Rusak Berat"
                                            {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
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
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama Aset</th>
                                <th>Kategori</th>
                                <th>Kondisi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($asets as $aset)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $aset->kode_aset }}</td>
                                    <td>{{ $aset->nama_aset }}</td>
                                    <td>{{ $aset->kategoriAset->nama ?? 'N/A' }}</td>
                                    <td>
                                        @if ($aset->kondisi == 'Baik')
                                            <span class="badge bg-success">Baik</span>
                                        @elseif($aset->kondisi == 'Rusak Ringan')
                                            <span class="badge bg-warning">Rusak Ringan</span>
                                        @else
                                            <span class="badge bg-danger">Rusak Berat</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('aset.show', $aset->aset_id) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('aset.edit', $aset->aset_id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('aset.destroy', $aset->aset_id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Anda yakin?')">
                                                <i class="bi bi-trash-fill"></i> Hapus
                                            </button>
                                        </form>
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
    {{-- Tambahkan JS untuk Simple Datatables --}}
    <script src="{{ asset('assets-admin/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script>
        // Inisialisasi Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>
@endpush
