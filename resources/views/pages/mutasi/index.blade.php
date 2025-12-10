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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Tabel Mutasi</h4>
                    <a href="{{ route('mutasi.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-2"></i> Tambah Mutasi
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
                                        <span class="badge bg-light-primary text-primary">{{ $item->jenis_mutasi }}</span>
                                    </td>
                                    <td>{{ $item->keterangan ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('mutasi.edit', $item->mutasi_id) }}" class="btn btn-warning btn-sm" title="Edit Data">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('mutasi.destroy', $item->mutasi_id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data mutasi ini?')" title="Hapus Data">
                                                    <i class="bi bi-trash-fill"></i>
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