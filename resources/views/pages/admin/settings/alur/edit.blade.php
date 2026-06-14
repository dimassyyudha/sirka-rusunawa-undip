@extends('layouts.app')

@section('title', 'Edit Alur Reservasi')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Alur Reservasi</h3>
                <p class="text-subtitle text-muted">Kelola badge, judul, deskripsi, dan langkah reservasi.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.settings.alur.index') }}">Alur Reservasi</a></li>
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
                <h5 class="mb-0">Form Alur Reservasi</h5>
                <a href="{{ route('admin.settings.alur.index') }}" class="btn btn-outline-secondary btn-sm">
                    Kembali
                </a>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.alur.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Badge</label>
                        <input type="text"
                               name="badge"
                               class="form-control"
                               value="{{ old('badge', $data['badge'] ?? '') }}"
                               placeholder="Contoh: Cara Reservasi">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul</label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ old('title', $data['title'] ?? '') }}"
                               required
                               placeholder="Contoh: Alur Reservasi Kamar Rusunawa">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Tulis deskripsi singkat section alur reservasi...">{{ old('description', $data['description'] ?? '') }}</textarea>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Daftar Langkah</h6>
                            <small class="text-muted">Urutan akan dirapikan otomatis saat disimpan.</small>
                        </div>
                        <button type="button" class="btn btn-primary btn-sm" id="btnAddStep">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Langkah
                        </button>
                    </div>

                    <div id="stepContainer" class="mt-3 d-flex flex-column gap-3">
                        @forelse($items as $i => $step)
                            <div class="border rounded-3 p-3 step-item">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Judul Langkah</label>
                                        <input type="text"
                                               name="step_title[]"
                                               class="form-control"
                                               value="{{ old("step_title.$i", $step['title'] ?? '') }}"
                                               required
                                               placeholder="Contoh: Pilih Kamar">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Urutan</label>
                                        <input type="number"
                                               name="sort_order[]"
                                               class="form-control"
                                               value="{{ old("sort_order.$i", $step['sort_order'] ?? 1) }}"
                                               min="1">
                                    </div>

                                    <div class="col-md-3 d-flex flex-column justify-content-end gap-2">
                                        <div class="form-check form-switch mb-1">
                                            <input class="form-check-input active-switch"
                                                   type="checkbox"
                                                   name="is_active[{{ $i }}]"
                                                   {{ !empty($step['is_active']) ? 'checked' : '' }}>
                                            <label class="form-check-label">Aktif</label>
                                        </div>

                                        <div class="form-check mb-1">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   name="delete[{{ $i }}]">
                                            <label class="form-check-label text-danger fw-semibold">Hapus</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Deskripsi Langkah</label>
                                        <textarea name="step_desc[]"
                                                  class="form-control"
                                                  rows="4"
                                                  required
                                                  placeholder="Tulis penjelasan detail langkah...">{{ old("step_desc.$i", $step['desc'] ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-light border mb-0">
                                Belum ada langkah alur. Klik <b>Tambah Langkah</b>.
                            </div>
                        @endforelse
                    </div>

                    <template id="stepTemplate">
                        <div class="border rounded-3 p-3 step-item">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Judul Langkah</label>
                                    <input type="text"
                                           name="step_title[]"
                                           class="form-control"
                                           placeholder="Contoh: Pilih Kamar"
                                           required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Urutan</label>
                                    <input type="number"
                                           name="sort_order[]"
                                           class="form-control sort-input"
                                           min="1"
                                           value="1">
                                </div>

                                <div class="col-md-3 d-flex flex-column justify-content-end gap-2">
                                    <div class="form-check form-switch mb-1">
                                        <input class="form-check-input active-switch" type="checkbox" checked>
                                        <label class="form-check-label">Aktif</label>
                                    </div>

                                    <button type="button" class="btn btn-outline-danger btn-sm btnRemoveStep">
                                        <i class="bi bi-trash me-1"></i> Buang
                                    </button>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">Deskripsi Langkah</label>
                                    <textarea name="step_desc[]"
                                              class="form-control"
                                              rows="4"
                                              placeholder="Tulis penjelasan detail langkah..."
                                              required></textarea>
                                </div>
                            </div>
                        </div>
                    </template>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.settings.alur.index') }}" class="btn btn-outline-secondary">
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

<script>
(function () {
    const btnAdd = document.getElementById('btnAddStep');
    const container = document.getElementById('stepContainer');
    const tpl = document.getElementById('stepTemplate');

    function nextSort() {
        const nums = Array.from(document.querySelectorAll('input[name="sort_order[]"]'))
            .map(i => parseInt(i.value || '0', 10))
            .filter(n => !isNaN(n) && n > 0);

        return (nums.length ? Math.max(...nums) : 0) + 1;
    }

    function refreshIndexes() {
        document.querySelectorAll('#stepContainer .step-item').forEach((item, idx) => {
            const activeSwitch = item.querySelector('.active-switch');
            if (activeSwitch) activeSwitch.name = `is_active[${idx}]`;
        });
    }

    btnAdd?.addEventListener('click', () => {
        const node = tpl.content.cloneNode(true);

        const sortInput = node.querySelector('.sort-input');
        if (sortInput) sortInput.value = nextSort();

        const removeBtn = node.querySelector('.btnRemoveStep');
        removeBtn?.addEventListener('click', () => {
            removeBtn.closest('.step-item').remove();
            refreshIndexes();
        });

        container.appendChild(node);
        refreshIndexes();
    });

    refreshIndexes();
})();
</script>
@endsection