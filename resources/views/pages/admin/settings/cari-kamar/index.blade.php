@extends('layouts.app')

@section('title', 'Pengaturan Halaman Reservasi Kamar')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Pengaturan Halaman Reservasi Kamar</h3>
                    <p class="text-subtitle text-muted">
                        Teks yang muncul di halaman pencarian kamar pada landing.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Pengaturan Reservasi Kamar
                            </li>
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
                    <h5 class="mb-0">Konten Saat Ini</h5>
                    <a href="{{ route('admin.settings.cari-kamar.edit') }}" class="btn btn-primary btn-sm">
                        Edit
                    </a>
                </div>

                <div class="card-body">
                    <div class="border rounded-3 p-3 bg-light">
                        <div class="row mb-3 pb-3 border-bottom">
                            <div class="col-md-3 fw-semibold text-gray-600">Teks Banner</div>
                            <div class="col-md-9">
                                {{ $data['banner_text'] ?? '-' }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 fw-semibold text-gray-600">Tips Pencarian</div>
                            <div class="col-md-9">
                                {{ $data['tips_text'] ?? '-' }}
                            </div>
                        </div>
                    </div>

                    {{-- kecil-kecilan preview --}}
                    <div class="mt-4 p-4 rounded-3 bg-light-info">
                        <p class="mb-2 text-gray-600 text-sm">Pratinjau Halaman Reservasi Kamar</p>
                        <h5 class="mb-2">{{ $data['banner_text'] ?? 'Teks banner...' }}</h5>
                        <p class="mb-0 text-gray-600">
                            {{ $data['tips_text'] ?? 'Tips pencarian akan tampil di sini.' }}
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
