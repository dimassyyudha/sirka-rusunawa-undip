@extends('layouts.app')

@section('title', 'Edit Alur Reservasi')
@section('page_title', 'Edit Alur Reservasi')

@section('content')

    <div class="mx-auto max-w-6xl space-y-6">


        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>

                <h1 class="text-3xl font-black text-slate-900">
                    Edit Alur Reservasi
                </h1>

                <p class="mt-2 text-slate-500">
                    Kelola badge, judul, deskripsi, dan langkah-langkah alur reservasi.
                </p>

            </div>

            <a href="{{ route('admin.settings.alur.index') }}"
                class="rounded-2xl border border-slate-300 px-5 py-3 text-sm font-bold text-slate-700 hover:bg-slate-50">

                Kembali

            </a>

        </div>

        @if ($errors->any())

            <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">

                <ul class="list-disc pl-5 space-y-1">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif

        <form method="POST" action="{{ route('admin.settings.alur.update') }}"
            class="rounded-[10px] border border-slate-200 bg-white p-6 shadow-sm">

            @csrf
            @method('PUT')

            <div class="space-y-5">

                <div>

                    <label class="block mb-2 text-sm font-medium text-slate-700">
                        Badge
                    </label>

                    <input type="text" name="badge" value="{{ old('badge', $data['badge'] ?? '') }}"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3">

                </div>

                <div>

                    <label class="block mb-2 text-sm font-medium text-slate-700">
                        Judul
                    </label>

                    <input type="text" name="title" required value="{{ old('title', $data['title'] ?? '') }}"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3">

                </div>

                <div>

                    <label class="block mb-2 text-sm font-medium text-slate-700">
                        Deskripsi
                    </label>

                    <textarea name="description" rows="4" class="w-full rounded-2xl border border-slate-300 px-4 py-3">{{ old('description', $data['description'] ?? '') }}</textarea>

                </div>

            </div>

            <div class="mt-8 border-t border-slate-200 pt-6">

                <div class="flex items-center justify-between">

                    <div>

                        <h3 class="font-black text-slate-900">
                            Daftar Langkah
                        </h3>

                        <p class="text-sm text-slate-500">
                            Urutan akan dirapikan otomatis saat disimpan.
                        </p>

                    </div>

                    <button type="button" id="btnAddStep"
                        class="rounded-2xl bg-orange-500 px-4 py-3 text-sm font-black text-white hover:bg-orange-600">

                        Tambah Langkah

                    </button>

                </div>

                <div id="stepContainer" class="mt-5 space-y-4">

                    @forelse($items as $i => $step)
                        <div class="step-item rounded-[10px] border border-slate-200 bg-slate-50 p-5">

                            <div class="grid md:grid-cols-12 gap-4">

                                <div class="md:col-span-5">

                                    <label class="block mb-2 text-sm font-medium text-slate-700">
                                        Judul Langkah
                                    </label>

                                    <input type="text" name="step_title[]"
                                        value="{{ old("step_title.$i", $step['title'] ?? '') }}"
                                        class="w-full rounded-2xl border border-slate-300 px-4 py-3">

                                </div>

                                <div class="md:col-span-2">

                                    <label class="block mb-2 text-sm font-medium text-slate-700">
                                        Urutan
                                    </label>

                                    <input type="number" min="1" name="sort_order[]"
                                        value="{{ old("sort_order.$i", $step['sort_order'] ?? 1) }}"
                                        class="w-full rounded-2xl border border-slate-300 px-4 py-3">

                                </div>

                                <div class="md:col-span-2 flex items-end">

                                    <label class="flex items-center gap-2">

                                        <input type="checkbox" class="active-switch" name="is_active[{{ $i }}]"
                                            {{ !empty($step['is_active']) ? 'checked' : '' }}>

                                        <span class="font-medium">
                                            Aktif
                                        </span>

                                    </label>

                                </div>

                                <div class="md:col-span-3 flex items-end">

                                    <label class="flex items-center gap-2">

                                        <input type="checkbox" name="delete[{{ $i }}]">

                                        <span class="font-medium text-red-600">
                                            Hapus
                                        </span>

                                    </label>

                                </div>

                            </div>

                            <div class="mt-4">

                                <label class="block mb-2 text-sm font-medium text-slate-700">
                                    Deskripsi Langkah
                                </label>

                                <textarea name="step_desc[]" rows="4" class="w-full rounded-2xl border border-slate-300 px-4 py-3">{{ old("step_desc.$i", $step['desc'] ?? '') }}</textarea>

                            </div>

                        </div>

                    @empty

                        <div class="rounded-[10px] border border-slate-200 bg-slate-50 p-5 text-center text-slate-500">

                            Belum ada langkah alur.

                        </div>
                    @endforelse

                </div>

            </div>

            <div class="mt-8 flex gap-3">

                <x-button.button-menu type="submit" variant="primary" data-confirm data-confirm-title="Simpan perubahan?"
                    data-confirm-text="Pastikan data sudah sesuai." data-confirm-button-text="Ya, simpan">
                    Simpan Perubahan
                </x-button.button-menu>

                <x-button.button-menu href="{{ route('admin.settings.alur.index') }}" variant="outline" size="md"
                    class="w-full sm:w-auto">

                    Batal

                </x-button.button-menu>


            </div>

        </form>


    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {

                const btnAdd = document.getElementById('btnAddStep');
                const container = document.getElementById('stepContainer');

                btnAdd.addEventListener('click', () => {

                    const total = document.querySelectorAll('.step-item').length + 1;

                    const html = `
        <div class="step-item rounded-[10px] border border-slate-200 bg-slate-50 p-5">

            <div class="grid md:grid-cols-12 gap-4">

                <div class="md:col-span-5">

                    <label class="block mb-2 text-sm font-medium text-slate-700">
                        Judul Langkah
                    </label>

                    <input
                        type="text"
                        name="step_title[]"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3">

                </div>

                <div class="md:col-span-2">

                    <label class="block mb-2 text-sm font-medium text-slate-700">
                        Urutan
                    </label>

                    <input
                        type="number"
                        min="1"
                        value="${total}"
                        name="sort_order[]"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3">

                </div>

                <div class="md:col-span-2 flex items-end">

                    <label class="flex items-center gap-2">

                        <input type="checkbox" checked>

                        <span class="font-medium">
                            Aktif
                        </span>

                    </label>

                </div>

                <div class="md:col-span-3 flex items-end">

                    <button
                        type="button"
                        class="remove-step rounded-xl bg-red-50 px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-600 hover:text-white">

                        Hapus

                    </button>

                </div>

            </div>

            <div class="mt-4">

                <label class="block mb-2 text-sm font-medium text-slate-700">
                    Deskripsi Langkah
                </label>

                <textarea
                    name="step_desc[]"
                    rows="4"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3"></textarea>


        </div>

    </div>`;

                    container.insertAdjacentHTML('beforeend', html);

                });

                document.addEventListener('click', function(e) {

                    if (e.target.classList.contains('remove-step')) {

                        e.target.closest('.step-item').remove();

                    }

                });


            });
        </script>
    @endpush

@endsection
