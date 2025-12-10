@extends('layouts.admin.app')

@section('title', 'Data Warga')

@push('css')
    {{-- Tambahkan CSS untuk Simple Datatables --}}
    <link rel="stylesheet" href="{{ asset('assets-admin/vendors/simple-datatables/style.css') }}">
@endpush

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Warga</h3>
                    <p class="text-subtitle text-muted">Daftar lengkap semua warga yang terdata.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Daftar Warga</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">

                        {{-- Bagian Kiri: Tombol Tambah --}}
                        <div class="col-md-6 mb-3 mb-md-0">
                            <a href="{{ route('warga.create') }}" class="btn btn-primary d-inline-flex align-items-center">
                                <i class="bi bi-plus-circle me-2"></i> Tambah Warga Baru
                            </a>
                        </div>

                        {{-- Bagian Kanan: Filter (Rata Kanan) --}}
                        <div class="col-md-6 d-flex justify-content-md-end">
                            <form action="{{ route('warga.index') }}" method="GET" class="d-flex align-items-center">
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-funnel"></i> Filter:</span>

                                    <select name="jenis_kelamin" class="form-select" onchange="this.form.submit()" style="min-width: 150px;">
                                        <option value="">Semua Gender</option>
                                        <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                            Laki-laki
                                        </option>
                                        <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan
                                        </option>
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
                                <th>No. KTP</th>
                                <th>Nama Warga</th>
                                <th>Jenis Kelamin</th>
                                <th>Pekerjaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($warga as $warga)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $warga->no_ktp }}</td>
                                    <td>{{ $warga->nama }}</td>
                                    <td>{{ $warga->jenis_kelamin }}</td>
                                    <td>{{ $warga->pekerjaan }}</td>
                                    <td>
                                        <a href="{{ route('warga.edit', $warga->warga_id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('warga.destroy', $warga->warga_id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Anda yakin?')">
                                                <i class="bi bi-trash-fill"></i> Hapus
                                            </button>
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
