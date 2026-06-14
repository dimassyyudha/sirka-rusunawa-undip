@extends('layouts.app')
@section('title','Tambah Rekomendasi')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <h3>Tambah Rekomendasi</h3>
        <p class="text-subtitle text-muted">Pilih kamar + atur urutan tampil.</p>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.settings.recommendation.store') }}" method="POST">
                    @csrf

                    @include('pages.admin.recommendation._form', ['rooms' => $rooms, 'nextOrder' => $nextOrder])

                    <div class="mt-4 d-flex gap-2">
                        <button class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                        <a href="{{ route('admin.settings.recommendation.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
