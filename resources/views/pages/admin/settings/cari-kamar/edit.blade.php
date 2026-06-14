@extends('layouts.app')

@section('title', 'Edit Halaman Reservasi Kamar')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Konten Halaman Reservasi Kamar</h3>
                    <p class="text-subtitle text-muted">
                        Ubah teks banner dan tips pencarian di halaman Reservasi Kamar.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.settings.cari-kamar.index') }}">Pengaturan Reservasi Kamar</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Edit
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.settings.cari-kamar.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Teks Banner <span class="text-danger">*</span></label>
                            <input type="text" name="banner_text"
                                class="form-control @error('banner_text') is-invalid @enderror"
                                value="{{ old('banner_text', $data['banner_text'] ?? '') }}"
                                placeholder="Contoh: Reservasi Kamar berdasarkan gedung dan ketersediaan">
                            @error('banner_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Tips Pencarian</label>
                            <textarea name="tips_text" rows="3" class="form-control @error('tips_text') is-invalid @enderror"
                                placeholder="Contoh: Gunakan filter lantai dan tower untuk hasil lebih cepat.">{{ old('tips_text', $data['tips_text'] ?? '') }}</textarea>
                            @error('tips_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <x-button.button-menu href="{{ route('admin.settings.cari-kamar.index') }}" variant="outline"
                                size="md">
                                Batal
                            </x-button.button-menu>
                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
