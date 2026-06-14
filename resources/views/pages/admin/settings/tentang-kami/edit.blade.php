@extends('layouts.app')

@section('title', 'Edit Tentang Kami')

@section('content')
    @php
        $imageUrl = function ($path) {
            if (empty($path)) {
                return null;
            }

            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
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

            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Edit Tentang Kami</h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Atur header, profil, visi misi, aturan, dan blok tambahan.
                    </p>
                </div>

                <x-button.button-menu href="{{ route('admin.settings.tentang-kami.index') }}" variant="outline">
                    Kembali
                </x-button.button-menu>
            </div>

            <form method="POST" action="{{ route('admin.settings.tentang-kami.update') }}" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-slate-900">Header Tentang Kami</h2>

                    <div class="mt-5 grid gap-5 lg:grid-cols-12">
                        <div class="lg:col-span-4">
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Badge</label>
                            <input type="text" name="badge" required value="{{ old('badge', $data['badge'] ?? '') }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none">
                        </div>

                        <div class="lg:col-span-8">
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Judul</label>
                            <input type="text" name="title" required value="{{ old('title', $data['title'] ?? '') }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none">
                        </div>

                        <div class="lg:col-span-12">
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Deskripsi</label>
                            <textarea name="description" rows="3"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none">{{ old('description', $data['description'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">Blok Konten</h2>
                            <p class="mt-1 text-sm text-slate-500">
                                Tambah, ubah, atau hapus blok Tentang Kami.
                            </p>
                        </div>

                        <x-button.button-menu type="button" variant="accent" id="btnAddBlock">
                            Tambah Blok
                        </x-button.button-menu>
                    </div>

                    <div id="blocksContainer" class="mt-6 space-y-6">
                        @forelse(($data['blocks'] ?? []) as $i => $block)
                            @php
                                $img = $imageUrl($block['image'] ?? null);
                            @endphp

                            <div class="block-item rounded-2xl border border-slate-200 bg-slate-50 p-5">
                                <input type="hidden" name="blocks[{{ $i }}][id]"
                                    value="{{ $block['id'] ?? '' }}">

                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="space-y-4 lg:col-span-7">
                                        <div class="grid gap-4 md:grid-cols-2">
                                            <div>
                                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                                    Jenis Blok
                                                </label>
                                                <input type="text" name="blocks[{{ $i }}][type]"
                                                    value="{{ old("blocks.$i.type", $block['type'] ?? '') }}"
                                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none">
                                            </div>

                                            <div>
                                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                                    Judul Blok
                                                </label>
                                                <input type="text" name="blocks[{{ $i }}][title]" required
                                                    value="{{ old("blocks.$i.title", $block['title'] ?? '') }}"
                                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                                Isi Blok
                                            </label>
                                            <textarea name="blocks[{{ $i }}][body]" rows="4"
                                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none">{{ old("blocks.$i.body", $block['body'] ?? '') }}</textarea>
                                        </div>

                                        <div>
                                            <div class="mb-2 flex items-center justify-between">
                                                <label class="block text-sm font-semibold text-slate-700">
                                                    Item / Poin
                                                </label>

                                                <x-button.button-menu type="button" variant="ghost" size="sm"
                                                    class="btn-add-item">
                                                    + Tambah Item
                                                </x-button.button-menu>
                                            </div>

                                            <div class="items-container space-y-2">
                                                @forelse(($block['items'] ?? []) as $item)
                                                    <div class="item-row flex gap-2">
                                                        <input type="text" name="blocks[{{ $i }}][items][]"
                                                            value="{{ $item }}"
                                                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none">

                                                        <x-button.button-menu type="button" variant="danger" size="sm"
                                                            class="btn-remove-item">
                                                            Hapus
                                                        </x-button.button-menu>
                                                    </div>
                                                @empty
                                                    <div class="item-row flex gap-2">
                                                        <input type="text" name="blocks[{{ $i }}][items][]"
                                                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none">

                                                        <x-button.button-menu type="button" variant="danger" size="sm"
                                                            class="btn-remove-item">
                                                            Hapus
                                                        </x-button.button-menu>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>

                                    <div class="lg:col-span-5">
                                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                                            Gambar Blok
                                        </label>

                                        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-100">
                                            @if ($img)
                                                <img src="{{ $img }}"
                                                    class="preview-img h-[240px] w-full object-cover" alt="Preview">
                                                <div
                                                    class="preview-placeholder hidden h-[240px] items-center justify-center text-sm text-slate-400">
                                                    Belum ada gambar
                                                </div>
                                            @else
                                                <img src="" class="preview-img hidden h-[240px] w-full object-cover"
                                                    alt="Preview">
                                                <div
                                                    class="preview-placeholder flex h-[240px] items-center justify-center text-sm text-slate-400">
                                                    Belum ada gambar
                                                </div>
                                            @endif
                                        </div>

                                        <input type="file" name="block_images[{{ $i }}]" accept="image/*"
                                            class="block-image-input mt-3 block w-full rounded-xl border border-slate-300 bg-white text-sm text-slate-700 file:mr-4 file:border-0 file:bg-indigo-700 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-indigo-800">

                                        <label
                                            class="mt-4 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3">
                                            <input type="checkbox" name="delete_block[{{ $i }}]"
                                                value="1"
                                                class="mt-1 h-5 w-5 rounded border-red-300 text-red-600 focus:ring-red-500">

                                            <div>
                                                <p class="text-sm font-semibold text-red-700">Hapus blok ini</p>
                                                <p class="text-xs text-red-500">Blok akan hilang saat disimpan.</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div
                                class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center text-sm text-slate-500">
                                Belum ada blok. Klik Tambah Blok.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <x-button.button-menu href="{{ route('admin.settings.tentang-kami.index') }}" variant="outline"
                        size="md">
                        Batal
                    </x-button.button-menu>
                    <x-button.button-menu type="submit" variant="primary" data-confirm
                        data-confirm-title="Simpan perubahan?"
                        data-confirm-text="Pastikan data Tentang Kami sudah sesuai."
                        data-confirm-button-text="Ya, simpan">
                        Simpan Perubahan
                    </x-button.button-menu>
                </div>
            </form>
        </div>
    </div>

    <template id="blockTemplate">
        <div class="block-item rounded-2xl border border-slate-200 bg-slate-50 p-5">
            <input type="hidden" data-name="id" value="">

            <div class="grid gap-6 lg:grid-cols-12">
                <div class="space-y-4 lg:col-span-7">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Jenis Blok</label>
                            <input type="text" data-name="type" value="Custom"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Judul Blok</label>
                            <input type="text" data-name="title" required
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Isi Blok</label>
                        <textarea data-name="body" rows="4"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none"></textarea>
                    </div>

                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <label class="block text-sm font-semibold text-slate-700">Item / Poin</label>

                            <button type="button"
                                class="btn-add-item inline-flex items-center justify-center font-semibold transition-all duration-200 focus:outline-none focus:ring-4 shadow-sm px-3 py-2 text-xs rounded-xl text-slate-700 bg-transparent border border-transparent hover:bg-slate-100 focus:ring-slate-200">
                                + Tambah Item
                            </button>
                        </div>

                        <div class="items-container space-y-2">
                            <div class="item-row flex gap-2">
                                <input type="text" data-name="items"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none">

                                <button type="button"
                                    class="btn-remove-item inline-flex items-center justify-center font-semibold transition-all duration-200 focus:outline-none focus:ring-4 shadow-sm px-3 py-2 text-xs rounded-xl text-white bg-red-500 border border-transparent hover:bg-red-600 focus:ring-red-300 shadow-red-500/20">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Gambar Blok</label>

                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-100">
                        <img src="" class="preview-img hidden h-[240px] w-full object-cover" alt="Preview">
                        <div class="preview-placeholder flex h-[240px] items-center justify-center text-sm text-slate-400">
                            Belum ada gambar
                        </div>
                    </div>

                    <input type="file" accept="image/*" data-name="image"
                        class="block-image-input mt-3 block w-full rounded-xl border border-slate-300 bg-white text-sm text-slate-700 file:mr-4 file:border-0 file:bg-indigo-700 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-indigo-800">

                    <label class="mt-4 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3">
                        <input type="checkbox" data-name="delete" value="1"
                            class="mt-1 h-5 w-5 rounded border-red-300 text-red-600 focus:ring-red-500">

                        <div>
                            <p class="text-sm font-semibold text-red-700">Hapus blok ini</p>
                            <p class="text-xs text-red-500">Blok akan hilang saat disimpan.</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('blocksContainer');
            const template = document.getElementById('blockTemplate');
            const btnAddBlock = document.getElementById('btnAddBlock');

            const inputClasses =
                'w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none';

            const dangerButtonClasses =
                'btn-remove-item inline-flex items-center justify-center font-semibold transition-all duration-200 focus:outline-none focus:ring-4 shadow-sm px-3 py-2 text-xs rounded-xl text-white bg-red-500 border border-transparent hover:bg-red-600 focus:ring-red-300 shadow-red-500/20';

            function reindexBlocks() {
                const blocks = container.querySelectorAll('.block-item');

                blocks.forEach((block, index) => {
                    const id = block.querySelector('[data-name="id"]');
                    const type = block.querySelector('[data-name="type"]');
                    const title = block.querySelector('[data-name="title"]');
                    const body = block.querySelector('[data-name="body"]');
                    const image = block.querySelector('[data-name="image"]');
                    const del = block.querySelector('[data-name="delete"]');

                    if (id) id.name = `blocks[${index}][id]`;
                    if (type) type.name = `blocks[${index}][type]`;
                    if (title) title.name = `blocks[${index}][title]`;
                    if (body) body.name = `blocks[${index}][body]`;
                    if (image) image.name = `block_images[${index}]`;
                    if (del) del.name = `delete_block[${index}]`;

                    block.querySelectorAll('[data-name="items"]').forEach((item) => {
                        item.name = `blocks[${index}][items][]`;
                    });
                });
            }

            function bindEvents(scope = document) {
                scope.querySelectorAll('.btn-add-item').forEach((btn) => {
                    if (btn.dataset.bound === '1') return;
                    btn.dataset.bound = '1';

                    btn.addEventListener('click', function() {
                        const block = btn.closest('.block-item');
                        const itemsContainer = block.querySelector('.items-container');
                        const index = Array.from(container.querySelectorAll('.block-item')).indexOf(
                            block);

                        const row = document.createElement('div');
                        row.className = 'item-row flex gap-2';

                        row.innerHTML = `
                        <input type="text"
                               name="blocks[${index}][items][]"
                               data-name="items"
                               class="${inputClasses}">

                        <button type="button"
                                class="${dangerButtonClasses}">
                            Hapus
                        </button>
                    `;

                        itemsContainer.appendChild(row);
                        bindEvents(row);
                    });
                });

                scope.querySelectorAll('.btn-remove-item').forEach((btn) => {
                    if (btn.dataset.bound === '1') return;
                    btn.dataset.bound = '1';

                    btn.addEventListener('click', function() {
                        btn.closest('.item-row')?.remove();
                    });
                });

                scope.querySelectorAll('.block-image-input').forEach((input) => {
                    if (input.dataset.bound === '1') return;
                    input.dataset.bound = '1';

                    input.addEventListener('change', function() {
                        const file = input.files && input.files[0];
                        if (!file) return;

                        const block = input.closest('.block-item');
                        const img = block.querySelector('.preview-img');
                        const placeholder = block.querySelector('.preview-placeholder');

                        img.src = URL.createObjectURL(file);
                        img.classList.remove('hidden');

                        placeholder.classList.add('hidden');
                        placeholder.classList.remove('flex');

                        img.onload = () => URL.revokeObjectURL(img.src);
                    });
                });
            }

            btnAddBlock.addEventListener('click', function() {
                const emptyState = container.querySelector('.border-dashed');
                if (emptyState) emptyState.remove();

                const node = template.content.cloneNode(true);
                container.appendChild(node);

                reindexBlocks();
                bindEvents(container);
            });

            bindEvents(document);
            reindexBlocks();
        });
    </script>
@endsection
