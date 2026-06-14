@extends('layouts.app')

@section('title', 'Pengaturan Beranda')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pengaturan Beranda</h3>
                <p class="text-subtitle text-muted">
                    Ubah teks headline dan subheadline yang tampil di hero landing page.
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb"
                     class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pengaturan Beranda</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('admin.settings.beranda.update') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Headline</label>
                        <input type="text" name="headline"
                               class="form-control @error('headline') is-invalid @enderror"
                               value="{{ old('headline', $data['headline'] ?? '') }}">
                        @error('headline')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Subheadline</label>
                        <textarea name="subheadline"
                                  class="form-control @error('subheadline') is-invalid @enderror"
                                  rows="3">{{ old('subheadline', $data['subheadline'] ?? '') }}</textarea>
                        @error('subheadline')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Teks Tombol (CTA)</label>
                        <input type="text" name="cta_text"
                               class="form-control @error('cta_text') is-invalid @enderror"
                               value="{{ old('cta_text', $data['cta_text'] ?? '') }}">
                        @error('cta_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-primary">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
