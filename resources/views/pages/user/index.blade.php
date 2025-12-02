@extends('layouts.admin.app')

@section('title', 'Data User')

@push('css')
    {{-- Tambahkan CSS untuk Simple Datatables --}}
    <link rel="stylesheet" href="{{ asset('assets-admin/vendors/simple-datatables/style.css') }}">
@endpush

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data User</h3>
                    <p class="text-subtitle text-muted">Daftar lengkap semua user pengelola sistem.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Daftar User</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    {{-- Menggunakan route dari file Anda: user.create --}}
                    <a href="{{ route('user.create') }}" class="btn btn-primary d-inline-flex align-items-center">
                        <i class="bi bi-plus-circle me-2"></i> Tambah User Baru
                    </a>
                </div>
                <div class="card-body">

                    {{-- Menggunakan notifikasi 'success' yang ada di file Anda --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {!! session('success') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Menggunakan variabel dari file Anda: $dataUser as $item --}}
                            @foreach ($dataUser as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->password }}</td> {{-- Menampilkan password (bahkan yang ter-hash) tidak disarankan --}}
                                    <td>{{ $item->role }}</td>
                                    <td>
                                        {{-- Menggunakan route dari file Anda dan icon Bootstrap --}}
                                        <a href="{{ route('user.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('user.destroy', $item->id) }}" method="POST"
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
