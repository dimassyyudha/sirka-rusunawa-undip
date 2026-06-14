@extends('layouts.app')

@section('title', 'Edit FAQ')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit FAQ</h3>
                <p class="text-subtitle text-muted">Tambah, edit, aktifkan/nonaktifkan FAQ, dan pilih FAQ yang tampil di landing page.</p>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Form FAQ</h5>
                <a href="{{ route('admin.settings.faq.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.faq.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul</label>
                        <input type="text" name="title" class="form-control"
                               value="{{ old('title', $data['title'] ?? '') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Subjudul</label>
                        <textarea name="subtitle" class="form-control" rows="2">{{ old('subtitle', $data['subtitle'] ?? '') }}</textarea>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Daftar Pertanyaan</h6>
                            <small class="text-muted">Urutan akan dirapikan otomatis menjadi 1..N saat disimpan.</small>
                        </div>
                        <button type="button" class="btn btn-primary btn-sm" id="btnAddFaq">
                            <i class="bi bi-plus-circle me-1"></i> Tambah FAQ
                        </button>
                    </div>

                    <div id="faqContainer" class="mt-3 d-flex flex-column gap-3">
                        @forelse($items as $i => $it)
                            <div class="border rounded-3 p-3 faq-item">
                                <input type="hidden" name="item_id[]" value="{{ $it['id'] ?? '' }}">

                                <div class="row g-3">
                                    <div class="col-md-7">
                                        <label class="form-label fw-semibold">Pertanyaan</label>
                                        <input type="text" name="question[]" class="form-control"
                                               value="{{ old("question.$i", $it['question'] ?? '') }}" required>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold">Urutan</label>
                                        <input type="number" name="sort_order[]" class="form-control"
                                               value="{{ old("sort_order.$i", $it['sort_order'] ?? 1) }}" min="1">
                                    </div>

                                    <div class="col-md-3 d-flex flex-column justify-content-end gap-2">
                                        <div class="form-check form-switch mb-1">
                                            <input class="form-check-input active-switch" type="checkbox" name="is_active[{{ $i }}]"
                                                   {{ !empty($it['is_active']) ? 'checked' : '' }}>
                                            <label class="form-check-label">Aktif</label>
                                        </div>

                                        <div class="form-check form-switch mb-1">
                                            <input class="form-check-input featured-switch" type="checkbox" name="is_featured[{{ $i }}]"
                                                   {{ !empty($it['is_featured']) ? 'checked' : '' }}>
                                            <label class="form-check-label">Tampilkan di Landing Page</label>
                                        </div>

                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" name="delete[{{ $i }}]">
                                            <label class="form-check-label text-danger fw-semibold">Hapus</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Jawaban</label>
                                        <textarea name="answer[]" class="form-control" rows="3" required>{{ old("answer.$i", $it['answer'] ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-light border mb-0">
                                Belum ada FAQ. Klik <b>Tambah FAQ</b>.
                            </div>
                        @endforelse
                    </div>

                    <template id="faqTemplate">
                        <div class="border rounded-3 p-3 faq-item">
                            <input type="hidden" name="item_id[]" value="">

                            <div class="row g-3">
                                <div class="col-md-7">
                                    <label class="form-label fw-semibold">Pertanyaan</label>
                                    <input type="text" name="question[]" class="form-control" placeholder="Contoh: Bisa 1 orang 1 kamar?" required>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">Urutan</label>
                                    <input type="number" name="sort_order[]" class="form-control sort-input" min="1" value="1">
                                </div>

                                <div class="col-md-3 d-flex flex-column justify-content-end gap-2">
                                    <div class="form-check form-switch mb-1">
                                        <input class="form-check-input active-switch" type="checkbox">
                                        <label class="form-check-label">Aktif</label>
                                    </div>

                                    <div class="form-check form-switch mb-1">
                                        <input class="form-check-input featured-switch" type="checkbox">
                                        <label class="form-check-label">Tampilkan di Landing Page</label>
                                    </div>

                                    <button type="button" class="btn btn-outline-danger btn-sm btnRemoveFaq">
                                        <i class="bi bi-trash me-1"></i> Buang
                                    </button>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">Jawaban</label>
                                    <textarea name="answer[]" class="form-control" rows="3" placeholder="Isi jawaban..." required></textarea>
                                </div>
                            </div>
                        </div>
                    </template>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.settings.faq.index') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>

                </form>
            </div>
        </div>
    </section>
</div>

<script>
(function () {
    const btnAdd = document.getElementById('btnAddFaq');
    const container = document.getElementById('faqContainer');
    const tpl = document.getElementById('faqTemplate');

    function nextSort() {
        const nums = Array.from(document.querySelectorAll('input[name="sort_order[]"]'))
            .map(i => parseInt(i.value || '0', 10))
            .filter(n => !isNaN(n) && n > 0);
        return (nums.length ? Math.max(...nums) : 0) + 1;
    }

    function refreshIndexes() {
        document.querySelectorAll('#faqContainer .faq-item').forEach((item, idx) => {
            const activeSwitch = item.querySelector('.active-switch');
            const featuredSwitch = item.querySelector('.featured-switch');

            if (activeSwitch) activeSwitch.name = `is_active[${idx}]`;
            if (featuredSwitch) featuredSwitch.name = `is_featured[${idx}]`;
        });
    }

    btnAdd?.addEventListener('click', () => {
        const node = tpl.content.cloneNode(true);

        const sortInput = node.querySelector('.sort-input');
        if (sortInput) sortInput.value = nextSort();

        const activeSwitch = node.querySelector('.active-switch');
        const featuredSwitch = node.querySelector('.featured-switch');

        if (activeSwitch) activeSwitch.checked = true;
        if (featuredSwitch) featuredSwitch.checked = false;

        const removeBtn = node.querySelector('.btnRemoveFaq');
        removeBtn.addEventListener('click', () => {
            removeBtn.closest('.faq-item').remove();
            refreshIndexes();
        });

        container.appendChild(node);
        refreshIndexes();
    });

    refreshIndexes();
})();
</script>
@endsection