@extends('layouts.app')

@section('title', 'Pengaturan FAQ')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pengaturan FAQ</h3>
                <p class="text-subtitle text-muted">Preview FAQ yang tampil di landing page dan halaman FAQ.</p>
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
                    <h5 class="mb-0">FAQ Saat Ini</h5>
                    <small class="text-muted">FAQ aktif dapat tampil di halaman FAQ. FAQ yang ditandai landing page juga tampil di beranda.</small>
                </div>
                <a href="{{ route('admin.settings.faq.edit') }}" class="btn btn-primary btn-sm">Edit</a>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <div class="fw-semibold">Judul</div>
                    <div>{{ $data['title'] ?? '-' }}</div>
                </div>
                <div class="mb-4">
                    <div class="fw-semibold">Subjudul</div>
                    <div>{{ $data['subtitle'] ?? '-' }}</div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm align-middle table-striped">
                        <thead>
                            <tr>
                                <th style="width:90px;">Urutan</th>
                                <th>Pertanyaan</th>
                                <th style="width:120px;">Status</th>
                                <th style="width:150px;">Landing Page</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $it)
                                <tr>
                                    <td class="fw-semibold">{{ $it['sort_order'] ?? 0 }}</td>
                                    <td class="text-break">{{ $it['question'] ?? '-' }}</td>
                                    <td>
                                        {!! !empty($it['is_active'])
                                            ? '<span class="badge bg-success">Aktif</span>'
                                            : '<span class="badge bg-secondary">Nonaktif</span>' !!}
                                    </td>
                                    <td>
                                        {!! !empty($it['is_featured'])
                                            ? '<span class="badge bg-primary">Ditampilkan</span>'
                                            : '<span class="badge bg-light text-dark">Tidak</span>' !!}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-muted">Belum ada FAQ.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection