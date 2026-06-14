@extends('layouts.app')

@section('title', 'Edit Kenapa Rusunawa')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Kenapa Rusunawa</h3>
                <p class="text-subtitle text-muted">Ubah badge, judul, deskripsi, dan daftar cards.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.settings.kenapa.index') }}">Kenapa Rusunawa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Form</h5>
                <a href="{{ route('admin.settings.kenapa.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.kenapa.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Badge</label>
                            <input type="text" name="badge" class="form-control"
                                   value="{{ old('badge', $data['badge'] ?? '') }}" required>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Judul</label>
                            <input type="text" name="title" class="form-control"
                                   value="{{ old('title', $data['title'] ?? '') }}" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $data['description'] ?? '') }}</textarea>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Cards</h6>
                            <small class="text-muted">Urutan akan dirapikan otomatis jadi 1..N saat simpan.</small>
                        </div>
                        <button type="button" class="btn btn-primary btn-sm" id="btnAddCard">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Card
                        </button>
                    </div>

                    <div class="mt-3 d-flex flex-column gap-3" id="cardContainer">
                        @forelse($cards as $i => $c)
                            <div class="border rounded-3 p-3">
                                <input type="hidden" name="card_id[]" value="{{ $c['id'] ?? '' }}">

                                <div class="row g-3 align-items-start">
                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold">Urutan</label>
                                        <input type="number" name="sort_order[]" class="form-control"
                                               value="{{ $c['sort_order'] ?? ($i+1) }}" min="1">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Icon (Bootstrap Icons)</label>
                                        <input type="text" name="icon[]" class="form-control"
                                               value="{{ $c['icon'] ?? 'bi-stars' }}"
                                               placeholder="contoh: bi-geo-alt-fill">
                                        <small class="text-muted">Contoh: <code>bi-shield-lock-fill</code></small>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Judul</label>
                                        <input type="text" name="title_card[]" class="form-control"
                                               value="{{ $c['title'] ?? '' }}">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold d-block">Status</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_active[{{ $i }}]"
                                                   {{ !empty($c['is_active']) ? 'checked' : '' }}>
                                            <label class="form-check-label">Aktif</label>
                                        </div>

                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" name="delete[{{ $i }}]">
                                            <label class="form-check-label text-danger fw-semibold">Hapus</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Deskripsi</label>
                                        <textarea name="desc[]" class="form-control" rows="2">{{ $c['desc'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-light border mb-0">Belum ada cards. Klik “Tambah Card”.</div>
                        @endforelse
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.settings.kenapa.index') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<template id="cardTemplate">
    <div class="border rounded-3 p-3 card-item">
        <input type="hidden" name="card_id[]" value="">

        <div class="row g-3 align-items-start">
            <div class="col-md-2">
                <label class="form-label fw-semibold">Urutan</label>
                <input type="number" name="sort_order[]" class="form-control card-sort" min="1" value="1">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Icon</label>
                <input type="text" name="icon[]" class="form-control" value="bi-stars" placeholder="bi-geo-alt-fill">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Judul</label>
                <input type="text" name="title_card[]" class="form-control" value="">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold d-block">Status</label>
                <div class="form-check form-switch">
                    <input class="form-check-input card-active" type="checkbox" checked>
                    <label class="form-check-label">Aktif</label>
                </div>

                <button type="button" class="btn btn-outline-danger btn-sm mt-2 btn-remove">
                    <i class="bi bi-trash me-1"></i> Buang
                </button>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="desc[]" class="form-control" rows="2"></textarea>
            </div>
        </div>
    </div>
</template>

<script>
(function () {
    const container = document.getElementById('cardContainer');
    const btnAdd = document.getElementById('btnAddCard');
    const tpl = document.getElementById('cardTemplate');

    function nextSort() {
        const nums = Array.from(container.querySelectorAll('input[name="sort_order[]"]'))
            .map(i => parseInt(i.value || '0', 10))
            .filter(n => !isNaN(n) && n > 0);
        return (nums.length ? Math.max(...nums) : 0) + 1;
    }

    function addCard() {
        const node = tpl.content.cloneNode(true);
        const wrap = node.querySelector('.card-item');
        const sort = node.querySelector('.card-sort');
        const active = node.querySelector('.card-active');
        const remove = node.querySelector('.btn-remove');

        sort.value = nextSort();

        // checkbox active harus masuk ke array "is_active[index]"
        // biar sama pola controller: isset($actives[$i])
        const idx = container.querySelectorAll('.border.rounded-3').length;
        active.name = `is_active[${idx}]`;
        active.value = "1";

        remove.addEventListener('click', () => wrap.remove());

        container.prepend(node);
    }

    btnAdd?.addEventListener('click', addCard);
})();
</script>
@endsection
