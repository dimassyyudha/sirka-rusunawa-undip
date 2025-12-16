@extends('layouts.admin.app')

@section('title', 'Data User')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets-admin/vendors/simple-datatables/style.css') }}">
@endpush

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data User</h3>
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
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{-- BAGIAN KIRI: Tombol Tambah --}}
                    <div>
                        <a href="{{ route('user.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i> Tambah User
                        </a>
                    </div>

                    {{-- BAGIAN KANAN: Filter Role --}}
                    <div class="d-flex align-items-center">
                        <form action="{{ route('user.index') }}" method="GET" class="d-flex gap-2">

                            {{-- Dropdown Filter --}}
                            <select name="role" class="form-select" onchange="this.form.submit()" style="width: 200px;">
                                <option value="">-- Semua Role --</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                                <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff Inventaris</option>
                                <option value="kades" {{ request('role') == 'kades' ? 'selected' : '' }}>Kepala Desa</option>
                            </select>

                            {{-- Tombol Reset (Muncul hanya jika sedang memfilter) --}}
                            @if(request('role'))
                                <a href="{{ route('user.index') }}" class="btn btn-secondary" title="Reset Filter">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataUser as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{-- PERBAIKAN: Gunakan 'profile_photo' --}}
                                        @if($item->profile_photo)
                                            <img src="{{ asset('uploads/profile_pictures/' . $item->profile_photo) }}"
                                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                        @else
                                            <img src="{{ asset('assets-admin/images/faces/1.jpg') }}"
                                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; opacity: 0.5">
                                        @endif
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        @if($item->role == 'admin')
                                            <span class="badge bg-primary">Admin</span>
                                        @elseif($item->role == 'staff')
                                            <span class="badge bg-success">Staff</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $item->role }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('user.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('user.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">
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
    <script src="{{ asset('assets-admin/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script>
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>
@endpush
