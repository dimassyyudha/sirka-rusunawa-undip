@extends('layouts.app')

@section('title', 'Pengaturan Kenapa Rusunawa')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pengaturan Kenapa Rusunawa</h3>
                <p class="text-subtitle text-muted">Konten section "Kenapa Rusunawa?" di landing page.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kenapa Rusunawa</li>
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
                    <h5 class="mb-0">Preview</h5>
                    <small class="text-muted">Badge, judul, deskripsi, dan daftar poin (cards).</small>
                </div>
                <a href="{{ route('admin.settings.kenapa.edit') }}" class="btn btn-primary btn-sm">Edit</a>
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

                <h6 class="mb-2">Daftar Cards</h6>
                @if(empty($cards))
                    <div class="text-muted">Belum ada cards.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm align-middle table-striped">
                            <thead>
                                <tr>
                                    <th style="width:90px;">Urutan</th>
                                    <th style="width:130px;">Status</th>
                                    <th style="width:120px;">Icon</th>
                                    <th>Judul</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cards as $c)
                                    <tr>
                                        <td class="fw-semibold">{{ $c['sort_order'] ?? 0 }}</td>
                                        <td>
                                            {!! !empty($c['is_active'])
                                                ? '<span class="badge bg-success">Aktif</span>'
                                                : '<span class="badge bg-secondary">Nonaktif</span>' !!}
                                        </td>
                                        <td><code>{{ $c['icon'] ?? '-' }}</code></td>
                                        <td>{{ $c['title'] ?? '-' }}</td>
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
