@extends('layouts.admin.app')

@section('title', 'Data Warga')

@push('css')
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
                        {{-- KIRI: Tombol Tambah --}}
                        <div class="col-md-6 mb-3 mb-md-0">
                            <a href="{{ route('warga.create') }}" class="btn btn-primary d-inline-flex align-items-center">
                                <i class="bi bi-plus-circle me-2"></i> Tambah Warga
                            </a>
                        </div>

                        {{-- KANAN: Filter Gender --}}
                        <div class="col-md-6 d-flex justify-content-md-end">
                            <form action="{{ route('warga.index') }}" method="GET" class="d-flex align-items-center">
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-funnel"></i></span>
                                    <select name="jenis_kelamin" class="form-select" onchange="this.form.submit()" style="min-width: 150px;">
                                        <option value="">Semua Gender</option>
                                        <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
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
                                <th>No. KTP</th>
                                <th>Nama Lengkap</th>
                                <th>L/P</th>
                                <th>Agama</th> {{-- TAMBAHAN KOLOM AGAMA --}}
                                <th>Pekerjaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($warga as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->no_ktp }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>
                                        @if($item->jenis_kelamin == 'Laki-laki')
                                            <span class="badge bg-light-primary text-primary">L</span>
                                        @else
                                            <span class="badge bg-light-danger text-danger">P</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->agama }}</td> {{-- TAMBAHAN DATA AGAMA --}}
                                    <td>{{ $item->pekerjaan }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('warga.edit', $item->warga_id) }}" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            <form action="{{ route('warga.destroy', $item->warga_id) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
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