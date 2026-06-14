@extends('layouts.app')

@section('title', 'Edit Beranda')

@section('content')
    @php
        $heroImageUrl = function ($path) {
            if (empty($path)) {
                return null;
            }

            if (str_starts_with($path, 'http')) {
                return $path;
            }

            if (str_starts_with($path, 'storage/')) {
                return asset($path);
            }

            if (str_starts_with($path, 'assets-admin/')) {
                return asset($path);
            }

            return asset('storage/' . $path);
        };
    @endphp

    <div class="min-h-screen bg-slate-50 px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl space-y-6">

            {{-- HEADER --}}
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Edit Hero & Teks Beranda
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Upload multiple background hero dan atur teks landing page.
                    </p>
                </div>

                <div class="flex items-center gap-2 text-sm">
                    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-indigo-700">
                        Dashboard
                    </a>

                    <span class="text-slate-300">/</span>

                    <a href="{{ route('admin.settings.beranda.index') }}" class="text-slate-500 hover:text-indigo-700">
                        Pengaturan Beranda
                    </a>

                    <span class="text-slate-300">/</span>

                    <span class="font-medium text-slate-700">
                        Edit
                    </span>
                </div>
            </div>

            {{-- CARD --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                {{-- HEADER --}}
                <div
                    class="flex flex-col gap-4 border-b border-slate-200 px-5 py-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">
                            Form Hero Beranda
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Kelola background dan teks hero landing page.
                        </p>
                    </div>

                    <a href="{{ route('admin.settings.beranda.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Kembali
                    </a>
                </div>

                {{-- BODY --}}
                <div class="p-5">
                    <form method="POST" action="{{ route('admin.settings.beranda.update') }}" enctype="multipart/form-data"
                        class="space-y-8">

                        @csrf
                        @method('PUT')

                        {{-- BACKGROUND --}}
                        <div class="space-y-4">

                            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <div>
                                    <h3 class="text-base font-semibold text-slate-900">
                                        Hero Background Images
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Background aktif akan diputar otomatis berdasarkan urutan.
                                    </p>
                                </div>

                                <button type="button" id="btnAddBg"
                                    class="inline-flex items-center justify-center rounded-lg bg-indigo-700 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-800">

                                    Tambah Background
                                </button>
                            </div>

                            {{-- CONTAINER --}}
                            <div id="bgContainer" class="space-y-5">

                                @forelse($backgrounds as $b)
                                    @php
                                        $id = $b['id'] ?? 'bg_' . $loop->index;
                                        $imgUrl = $heroImageUrl($b['image'] ?? null);
                                    @endphp

                                    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

                                        <input type="hidden" name="existing_id[]" value="{{ $id }}">

                                        <div class="grid gap-5 lg:grid-cols-12">

                                            {{-- IMAGE --}}
                                            <div class="lg:col-span-6">
                                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                                    Preview Background
                                                </label>

                                                <div
                                                    class="overflow-hidden rounded-xl border border-slate-200 bg-slate-100">
                                                    @if ($imgUrl)
                                                        <img src="{{ $imgUrl }}"
                                                            id="preview_existing_{{ $id }}"
                                                            class="h-[240px] w-full object-cover">
                                                    @else
                                                        <div
                                                            class="flex h-[240px] items-center justify-center text-sm text-slate-400">
                                                            Belum ada gambar
                                                        </div>

                                                        <img hidden id="preview_existing_{{ $id }}"
                                                            class="h-[240px] w-full object-cover">
                                                    @endif
                                                </div>

                                                <div class="mt-3">
                                                    <label class="mb-2 block text-sm font-medium text-slate-700">
                                                        Ganti Gambar
                                                    </label>

                                                    <input type="file" name="existing_image[{{ $id }}]"
                                                        accept="image/*"
                                                        onchange="previewExisting(event, '{{ $id }}')"
                                                        class="block w-full rounded-xl border border-slate-300 bg-white text-sm text-slate-700
                                                    file:mr-4 file:border-0 file:bg-indigo-700
                                                    file:px-4 file:py-2
                                                    file:text-sm file:font-semibold
                                                    file:text-white hover:file:bg-indigo-800">
                                                </div>
                                            </div>

                                            {{-- SETTINGS --}}
                                            <div class="lg:col-span-3 space-y-4">

                                                <div>
                                                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                                                        Urutan
                                                    </label>

                                                    <input type="number" min="1"
                                                        name="existing_sort_order[{{ $id }}]"
                                                        value="{{ $b['sort_order'] ?? 1 }}"
                                                        class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none">
                                                </div>

                                                <label
                                                    class="flex items-center gap-3 rounded-xl border border-slate-200 px-4 py-3">

                                                    <input type="checkbox" name="existing_is_active[{{ $id }}]"
                                                        class="h-5 w-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                                                        {{ !empty($b['is_active']) ? 'checked' : '' }}>

                                                    <span class="text-sm font-medium text-slate-700">
                                                        Aktifkan Background
                                                    </span>
                                                </label>
                                            </div>

                                            {{-- DELETE --}}
                                            <div class="lg:col-span-3">
                                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                                    Hapus
                                                </label>

                                                <label
                                                    class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3">

                                                    <input type="checkbox" name="existing_delete[{{ $id }}]"
                                                        class="mt-1 h-5 w-5 rounded border-red-300 text-red-600 focus:ring-red-500">

                                                    <div>
                                                        <p class="text-sm font-semibold text-red-700">
                                                            Hapus background ini
                                                        </p>

                                                        <p class="mt-1 text-xs text-red-500">
                                                            Background akan dihapus saat disimpan.
                                                        </p>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                @empty

                                    <div
                                        class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center">
                                        <p class="text-sm text-slate-500">
                                            Belum ada background.
                                        </p>
                                    </div>
                                @endforelse
                            </div>

                            {{-- TEMPLATE --}}
                            <template id="bgTemplate">

                                <div class="bg-new-bg rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

                                    <div class="grid gap-5 lg:grid-cols-12">

                                        <div class="lg:col-span-6">
                                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                                Upload Background
                                            </label>

                                            <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-100">
                                                <img hidden class="bg-preview h-[240px] w-full object-cover">

                                                <div
                                                    class="bg-placeholder flex h-[240px] items-center justify-center text-sm text-slate-400">
                                                    Preview gambar muncul di sini
                                                </div>
                                            </div>

                                            <input type="file" accept="image/*"
                                                class="bg-file mt-3 block w-full rounded-xl border border-slate-300 bg-white text-sm text-slate-700
                                            file:mr-4 file:border-0 file:bg-indigo-700
                                            file:px-4 file:py-2
                                            file:text-sm file:font-semibold
                                            file:text-white hover:file:bg-indigo-800">
                                        </div>

                                        <div class="lg:col-span-3 space-y-4">

                                            <div>
                                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                                    Urutan
                                                </label>

                                                <input type="number" min="1" value="1"
                                                    class="bg-sort w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm">
                                            </div>

                                            <label
                                                class="flex items-center gap-3 rounded-xl border border-slate-200 px-4 py-3">

                                                <input type="checkbox" checked
                                                    class="bg-active h-5 w-5 rounded border-slate-300 text-indigo-600">

                                                <span class="text-sm font-medium text-slate-700">
                                                    Aktifkan Background
                                                </span>
                                            </label>
                                        </div>

                                        <div class="lg:col-span-3">
                                            <button type="button"
                                                class="bg-remove inline-flex w-full items-center justify-center rounded-xl border border-red-300 px-4 py-3 text-sm font-semibold text-red-600 hover:bg-red-50">

                                                Hapus Item
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        {{-- TEXT --}}
                        <div class="grid gap-5 lg:grid-cols-2">

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Headline
                                </label>

                                <input type="text" name="headline" required
                                    value="{{ old('headline', $data['headline'] ?? '') }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Teks Tombol
                                </label>

                                <input type="text" name="cta_text"
                                    value="{{ old('cta_text', $data['cta_text'] ?? '') }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none">
                            </div>

                            <div class="lg:col-span-2">
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Subheadline
                                </label>

                                <textarea rows="4" name="subheadline"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none">{{ old('subheadline', $data['subheadline'] ?? '') }}</textarea>
                            </div>
                        </div>

                        {{-- BUTTON --}}
                        <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-5 sm:flex-row sm:justify-end">

                            <x-button.button-menu href="{{ route('admin.settings.beranda.index') }}" variant="outline"
                                size="md">
                                Batal
                            </x-button.button-menu>

                            <x-button.button-menu type="submit" variant="primary" data-confirm
                                data-confirm-title="Simpan perubahan?" data-confirm-text="Pastikan data sudah sesuai."
                                data-confirm-button-text="Ya, simpan">
                                Simpan Perubahan
                            </x-button.button-menu>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- JS --}}
    <script>
        function previewExisting(event, id) {
            const file = event.target.files[0];
            if (!file) return;

            const img = document.getElementById('preview_existing_' + id);

            img.hidden = false;
            img.src = URL.createObjectURL(file);
        }

        (() => {
            const btnAdd = document.getElementById('btnAddBg');
            const container = document.getElementById('bgContainer');
            const tpl = document.getElementById('bgTemplate');

            function getNextSort() {
                const nums = Array.from(document.querySelectorAll(
                        'input[name^="existing_sort_order"], input[name="new_sort_order[]"]'
                    ))
                    .map(i => parseInt(i.value || '0'))
                    .filter(n => !isNaN(n));

                return nums.length ? Math.max(...nums) + 1 : 1;
            }

            function addBgItem() {
                const node = tpl.content.cloneNode(true);

                const wrap = node.querySelector('.bg-new-bg');
                const fileInput = node.querySelector('.bg-file');
                const previewImg = node.querySelector('.bg-preview');
                const placeholder = node.querySelector('.bg-placeholder');

                const sortInput = node.querySelector('.bg-sort');
                const activeInput = node.querySelector('.bg-active');
                const removeBtn = node.querySelector('.bg-remove');

                fileInput.name = 'new_image[]';

                sortInput.name = 'new_sort_order[]';
                sortInput.value = getNextSort();

                activeInput.name = 'new_is_active[]';
                activeInput.value = '1';

                fileInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (!file) return;

                    previewImg.hidden = false;
                    previewImg.src = URL.createObjectURL(file);

                    placeholder.remove();
                });

                removeBtn.addEventListener('click', () => {
                    wrap.remove();
                });

                container.prepend(node);
            }

            btnAdd.addEventListener('click', addBgItem);
        })();
    </script>
@endsection
