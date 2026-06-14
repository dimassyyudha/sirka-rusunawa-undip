@extends('layouts.app')

@section('title', 'Edit Kontak')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Kontak</h3>
                <p class="text-subtitle text-muted">Kelola informasi kontak dan form contact us.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.settings.contact.index') }}">Kontak</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        @if ($errors->any())
            <div class="alert alert-danger">
                <div class="fw-bold mb-1">Terjadi kesalahan:</div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Form Kontak</h5>
                <a href="{{ route('admin.settings.contact.index') }}" class="btn btn-outline-secondary btn-sm">
                    Kembali
                </a>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.contact.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul</label>
                        <input type="text" name="title" class="form-control"
                               value="{{ old('title', $data['title'] ?? '') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Subjudul</label>
                        <textarea name="subtitle" class="form-control" rows="3">{{ old('subtitle', $data['subtitle'] ?? '') }}</textarea>
                    </div>

                    <hr class="my-4">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Label WhatsApp</label>
                            <input type="text" name="wa_label" class="form-control"
                                   value="{{ old('wa_label', $data['wa_label'] ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nomor WhatsApp (tanpa +)</label>
                            <input type="text" name="wa_number" class="form-control"
                                   value="{{ old('wa_number', $data['wa_number'] ?? '') }}">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Teks WhatsApp</label>
                            <input type="text" name="wa_text" class="form-control"
                                   value="{{ old('wa_text', $data['wa_text'] ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Label Email</label>
                            <input type="text" name="email_label" class="form-control"
                                   value="{{ old('email_label', $data['email_label'] ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email', $data['email'] ?? '') }}">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Label Alamat</label>
                            <input type="text" name="address_label" class="form-control"
                                   value="{{ old('address_label', $data['address_label'] ?? '') }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Alamat</label>
                            <textarea name="address" class="form-control" rows="3">{{ old('address', $data['address'] ?? '') }}</textarea>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Form</label>
                        <input type="text" name="form_title" class="form-control"
                               value="{{ old('form_title', $data['form_title'] ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Subjudul Form</label>
                        <textarea name="form_subtitle" class="form-control" rows="2">{{ old('form_subtitle', $data['form_subtitle'] ?? '') }}</textarea>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Placeholder Nama</label>
                            <input type="text" name="name_placeholder" class="form-control"
                                   value="{{ old('name_placeholder', $data['name_placeholder'] ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Placeholder Email</label>
                            <input type="text" name="email_placeholder" class="form-control"
                                   value="{{ old('email_placeholder', $data['email_placeholder'] ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Placeholder Nomor Telepon</label>
                            <input type="text" name="phone_placeholder" class="form-control"
                                   value="{{ old('phone_placeholder', $data['phone_placeholder'] ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Placeholder Subjek</label>
                            <input type="text" name="subject_placeholder" class="form-control"
                                   value="{{ old('subject_placeholder', $data['subject_placeholder'] ?? '') }}">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Placeholder Pesan</label>
                            <input type="text" name="message_placeholder" class="form-control"
                                   value="{{ old('message_placeholder', $data['message_placeholder'] ?? '') }}">
                        </div>
                    </div>

                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Teks Tombol Form</label>
                            <input type="text" name="button_text" class="form-control"
                                   value="{{ old('button_text', $data['button_text'] ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Teks Tombol CTA</label>
                            <input type="text" name="cta_text" class="form-control"
                                   value="{{ old('cta_text', $data['cta_text'] ?? '') }}">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.settings.contact.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
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