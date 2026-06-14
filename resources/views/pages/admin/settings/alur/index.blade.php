@extends('layouts.app')

@section('title', 'Pengaturan Alur Reservasi')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pengaturan Alur Reservasi</h3>
                <p class="text-subtitle text-muted">Preview section alur reservasi yang tampil di landing page.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Alur Reservasi</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Preview Alur Reservasi</h5>
                    <small class="text-muted">Badge, judul, deskripsi, dan daftar langkah yang aktif.</small>
                </div>
                <a href="{{ route('admin.settings.alur.edit') }}" class="btn btn-primary btn-sm">
                    Edit
                </a>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <div class="text-uppercase text-muted small">Badge</div>
                    <div class="fw-semibold">{{ $data['badge'] ?? '-' }}</div>
                </div>

                <div class="mb-3">
                    <div class="text-uppercase text-muted small">Judul</div>
                    <div class="fw-semibold">{{ $data['title'] ?? '-' }}</div>
                </div>

                <div class="mb-4">
                    <div class="text-uppercase text-muted small">Deskripsi</div>
                    <div>{{ $data['description'] ?? '-' }}</div>
                </div>

                <h6 class="mb-2">Daftar Langkah</h6>

                @if(empty($items))
                    <div class="text-muted">Belum ada langkah alur.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm align-middle table-striped">
                            <thead>
                                <tr>
                                    <th style="width:90px;">Urutan</th>
                                    <th style="width:120px;">Status</th>
                                    <th style="width:220px;">Judul</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $step)
                                    <tr>
                                        <td class="fw-semibold">{{ $step['sort_order'] ?? 0 }}</td>
                                        <td>
                                            {!! !empty($step['is_active'])
                                                ? '<span class="badge bg-success">Aktif</span>'
                                                : '<span class="badge bg-secondary">Nonaktif</span>' !!}
                                        </td>
                                        <td class="fw-semibold">{{ $step['title'] ?? '-' }}</td>
                                        <td class="text-break">{{ $step['desc'] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection