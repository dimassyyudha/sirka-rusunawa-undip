@extends('layouts.app')
@section('title', 'Manajemen Reservasi')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets-admin/vendors/simple-datatables/style.css') }}">
@endpush

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Manajemen Reservasi</h3>
                    <p class="text-subtitle text-muted">Kelola data reservasi mahasiswa (filter, cari, approve/reject).</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Reservasi</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">

                {{-- HEADER mirip rooms/penghuni --}}
                <div class="card-header">
                    <div class="row align-items-center">

                        {{-- KIRI: Tambah --}}
                        <div class="col-md-6 mb-3 mb-md-0">
                            <a href="{{ route('admin.reservations.create') }}"
                                class="btn btn-primary d-inline-flex align-items-center">
                                <i class="bi bi-plus-circle me-2"></i> Tambah Reservasi
                            </a>
                        </div>

                        {{-- KANAN: Filter --}}
                        <div class="col-md-6 d-flex justify-content-md-end">
                            <form method="GET" action="{{ route('admin.reservations.index') }}"
                                class="d-flex align-items-center w-100 justify-content-end gap-2 flex-wrap">

                                {{-- Filter Status --}}
                                <div class="input-group" style="max-width: 240px;">
                                    <span class="input-group-text bg-white">
                                        <i class="bi bi-funnel"></i>&nbsp;Status
                                    </span>
                                    <select name="status" class="form-select" onchange="this.form.submit()">
                                        <option value="">Semua</option>
                                        @foreach ($statusList as $st)
                                            <option value="{{ $st }}" @selected(request('status') === $st)>
                                                {{ ucfirst($st) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Filter Periode --}}
                                <div class="input-group" style="max-width: 260px;">
                                    <span class="input-group-text bg-white">
                                        <i class="bi bi-calendar-event"></i>&nbsp;Periode
                                    </span>
                                    <select name="periode" class="form-select" onchange="this.form.submit()">
                                        <option value="">Semua</option>
                                        @foreach ($periodeList as $p)
                                            <option value="{{ $p }}" @selected(request('periode') === $p)>
                                                {{ $p }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                @if (request()->hasAny(['status', 'periode']))
                                    <a href="{{ route('admin.reservations.index') }}" class="btn btn-light">Reset</a>
                                @endif
                            </form>
                        </div>

                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Kamar</th>
                                <th>Periode</th>
                                <th>Status</th>
                                <th style="width:140px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reservations as $r)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold">{{ $r->user->name ?? '-' }}</td>
                                    <td>{{ $r->user->nim ?? '-' }}</td>
                                    <td>{{ $r->room->kode_kamar ?? '-' }}</td>
                                    <td>{{ $r->periode ?? '-' }}</td>
                                    <td>
                                        @php($st = $r->status ?? 'pending')
                                        @if ($st === 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($st === 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @elseif($st === 'cancelled')
                                            <span class="badge bg-secondary">Cancelled</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('admin.reservations.show', $r->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.reservations.edit', $r->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('admin.reservations.destroy', $r->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus reservasi ID {{ $r->id }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" type="submit">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Tidak ada data reservasi.
                                    </td>
                                </tr>
                            @endforelse
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
