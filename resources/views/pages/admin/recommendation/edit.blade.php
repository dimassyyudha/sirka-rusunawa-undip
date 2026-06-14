@extends('layouts.app')
@section('title','Edit Rekomendasi')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <h3>Edit Rekomendasi</h3>
        <p class="text-subtitle text-muted">Ubah kamar / urutan / status aktif.</p>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.settings.recommendation.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('pages.admin.recommendation._form', ['rooms' => $rooms, 'item' => $item])

                    <div class="mt-4 d-flex gap-2">
                        <button class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Update
                        </button>
                        <a href="{{ route('admin.settings.recommendation.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
