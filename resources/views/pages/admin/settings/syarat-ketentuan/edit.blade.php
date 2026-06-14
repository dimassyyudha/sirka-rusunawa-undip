@extends('layouts.app')

@section('content')
    <form action="{{ route('admin.settings.syarat-ketentuan.update') }}" method="POST">

        @csrf
        @method('PUT')

        <div class="min-h-screen bg-slate-50 px-4 py-6">

            <div class="mx-auto max-w-7xl space-y-6">

                <div>

                    <h1 class="text-2xl font-bold text-slate-900">
                        Edit syaratKetentuan & Conditions
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Kelola aturan dan ketentuan penghuni Rusunawa.
                    </p>

                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">

                    <div class="mb-8">

                        <label class="mb-2 block text-sm font-semibold text-slate-700">

                            Judul

                        </label>

                        <input type="text" name="title" value="{{ old('title', $data['title']) }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3">

                    </div>

                    <div id="sectionContainer">

                        @foreach ($sections as $index => $section)
                            <div class="section-card mb-8 rounded-3xl border-2 border-slate-200 bg-slate-50 p-6">

                                <div class="mb-5 flex items-center justify-between">

                                    <h3 class="section-label text-2xl font-black text-slate-900">
                                        Ketentuan {{ $section['number'] }}
                                    </h3>

                                    <x-button.button-menu type="button" variant="danger" size="sm"
                                        class="btn-remove-section" data-confirm data-confirm-title="Hapus ketentuan?"
                                        data-confirm-text="Ketentuan yang dihapus tidak dapat dikembalikan."
                                        data-confirm-button-text="Ya, hapus">

                                        <svg class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M5 7L5.29949 14.7868C5.41251 17.7252 5.46902 19.1944 6.40719 20.0972C7.34537 21 8.81543 21 11.7555 21H12.2433C15.1842 21 16.6547 21 17.5928 20.0972C18.531 19.1944 18.5875 17.7252 18.7006 14.7868L19 7"
                                                stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />

                                            <path
                                                d="M20.4706 4.43329C18.6468 4.27371 17.735 4.19392 16.8229 4.13611C13.6109 3.93249 10.3891 3.93249 7.17707 4.13611C6.26506 4.19392 5.35318 4.27371 3.52942 4.43329"
                                                stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />

                                            <path
                                                d="M13.7647 3.95212C13.7647 3.95212 13.3993 2.98339 11.6471 2.9834C9.8949 2.9834 9.52942 3.95211 9.52942 3.95211"
                                                stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                                        </svg>

                                        Hapus Ketentuan

                                    </x-button.button-menu>

                                </div>

                                <input type="hidden" class="section-number" name="sections[{{ $index }}][number]"
                                    value="{{ $section['number'] }}">

                                <div class="mb-5">

                                    <label class="mb-2 block text-sm font-bold text-slate-700">
                                        Judul Ketentuan
                                    </label>

                                    <input type="text" name="sections[{{ $index }}][title]"
                                        value="{{ $section['title'] }}"
                                        class="w-full rounded-2xl border border-slate-300 px-4 py-3">

                                </div>

                                <div class="items-container space-y-3">
                                    @foreach ($section['items'] as $itemIndex => $item)
                                        <div class="item-row flex items-center gap-3">

                                            <span class="item-letter w-8 text-center font-bold text-slate-700">
                                                {{ chr(97 + $itemIndex) }}.
                                            </span>

                                            <input type="text" name="sections[{{ $index }}][items][]"
                                                value="{{ $item }}"
                                                class="flex-1 rounded-2xl border border-slate-300 px-4 py-3">

                                            <x-button.button-menu type="button" variant="danger" size="sm"
                                                class="btn-remove-item" data-confirm data-confirm-title="Hapus item?"
                                                data-confirm-text="Item ini akan dihapus dari ketentuan."
                                                data-confirm-button-text="Ya, hapus">

                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none">
                                                    <path d="M7.75732 7.75745L16.2426 16.2427" stroke="currentColor"
                                                        stroke-width="1.6" stroke-linecap="round" />

                                                    <path d="M16.2426 7.75745L7.75732 16.2427" stroke="currentColor"
                                                        stroke-width="1.6" stroke-linecap="round" />
                                                </svg>

                                            </x-button.button-menu>

                                        </div>
                                    @endforeach

                                </div>

                                <x-button.button-menu type="button" variant="dark" size="md"
                                    class="btn-add-item mt-5">

                                    <svg class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none">
                                        <path d="M12 6V18" stroke="currentColor" stroke-width="1.6"
                                            stroke-linecap="round" />
                                        <path d="M18 12H6" stroke="currentColor" stroke-width="1.6"
                                            stroke-linecap="round" />
                                    </svg>

                                    Tambah Item

                                </x-button.button-menu>

                            </div>
                        @endforeach

                    </div>

                    <div class="mb-8">

                        <x-button.button-menu type="button" variant="accent" id="btnAddSection">

                            <svg class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none">
                                <path d="M12 6V18" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                                <path d="M18 12H6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                            </svg>

                            Tambah Ketentuan

                        </x-button.button-menu>

                    </div>

                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                        <x-button.button-menu href="{{ route('admin.settings.syarat-ketentuan.index') }}" variant="outline"
                            size="md">

                            Batal

                        </x-button.button-menu>

                        <x-button.button-menu type="submit" variant="primary" data-confirm
                            data-confirm-title="Simpan perubahan?"
                            data-confirm-text="Pastikan syarat Ketentuan & Conditions sudah sesuai."
                            data-confirm-button-text="Ya, simpan">

                            Simpan Perubahan

                        </x-button.button-menu>

                    </div>

                </div>

            </div>

        </div>

    </form>
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const container = document.getElementById('sectionContainer');

            function refreshLetters() {

                document.querySelectorAll('.section-card').forEach(card => {

                    card.querySelectorAll('.item-row').forEach((row, index) => {

                        let badge = row.querySelector('.item-letter');

                        if (badge) {
                            badge.textContent =
                                String.fromCharCode(97 + index) + '.';
                        }

                    });

                });

            }

            function reindex() {

                container
                    .querySelectorAll('.section-card')
                    .forEach((card, index) => {

                        card.querySelector('.section-label').innerText =
                            'Ketentuan ' + (index + 1);

                        card.querySelector('.section-number').value =
                            index + 1;

                        card
                            .querySelectorAll('input[type=text]')
                            .forEach(input => {

                                const old = input.name;

                                if (old.includes('sections[')) {

                                    input.name = old.replace(
                                        /sections\[\d+\]/,
                                        `sections[${index}]`
                                    );

                                }

                            });

                    });

            }

            document
                .getElementById('btnAddSection')
                .addEventListener('click', () => {

                    const idx = container.children.length;

                    container.insertAdjacentHTML(
                        'beforeend',
                        `
<div class="section-card mb-6 rounded-2xl border border-slate-200 p-5">

    <div class="mb-4 flex items-center justify-between">

        <h3 class="section-label text-lg font-bold">
         Ketentuan ${idx + 1}
        </h3>

        <button
            type="button"
            class="btn-remove-section rounded-lg bg-red-500 px-3 py-2 text-sm text-white">

            Hapus Ketentuan

        </button>

    </div>

    <input
        type="hidden"
        class="section-number"
        name="sections[${idx}][number]"
        value="${idx + 1}">

    <div class="mb-4">

        <label class="mb-2 block text-sm font-semibold">
            Judul Ketentuan
        </label>

        <input
            type="text"
            name="sections[${idx}][title]"
            class="w-full rounded-xl border border-slate-300 px-4 py-3">

    </div>

    <div class="items-container">

        <div class="item-row mb-2 flex items-center gap-3">

            <span class="item-letter w-8 text-center font-bold text-slate-700">
                a.
            </span>

            <input
                type="text"
                name="sections[${idx}][items][]"
                class="flex-1 rounded-xl border border-slate-300 px-4 py-3">

            <button
                type="button"
                class="btn-remove-item rounded-lg bg-red-500 px-3 text-white">

                ×

            </button>

        </div>

    </div>

    <button
        type="button"
        class="btn-add-item mt-3 rounded-xl bg-slate-800 px-4 py-2 text-white">

        + Tambah Item

    </button>

</div>
`
                    );

                    refreshLetters();

                });

            document.addEventListener('click', function(e) {

                const addItemBtn = e.target.closest('.btn-add-item');
                const removeItemBtn = e.target.closest('.btn-remove-item');
                const removeSectionBtn = e.target.closest('.btn-remove-section');

                if (addItemBtn) {

                    const card =
                        addItemBtn.closest('.section-card');

                    const containerItem =
                        card.querySelector('.items-container');

                    const sectionIndex = [...container.children].indexOf(card);

                    const letter =
                        String.fromCharCode(
                            97 + containerItem.querySelectorAll('.item-row').length
                        );

                    containerItem.insertAdjacentHTML(
                        'beforeend',
                        `
<div class="item-row mb-2 flex items-center gap-3">

    <span class="item-letter w-8 text-center font-bold text-slate-700">
        ${letter}.
    </span>

    <input
        type="text"
        name="sections[${sectionIndex}][items][]"
        class="flex-1 rounded-xl border border-slate-300 px-4 py-3">

    <button
        type="button"
        class="btn-remove-item rounded-lg bg-red-500 px-3 text-white">

            ×

    </button>

</div>
`
                    );

                    refreshLetters();
                }

                if (removeItemBtn) {

                    e.preventDefault();

                    Swal.fire({
                        title: 'Hapus item?',
                        text: 'Item ini akan dihapus dari ketentuan.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                    }).then((result) => {

                        if (!result.isConfirmed) return;

                        removeItemBtn.closest('.item-row').remove();

                        refreshLetters();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Item berhasil dihapus.',
                            timer: 1500,
                            showConfirmButton: false,
                        });

                    });

                    return;
                }
                if (removeSectionBtn) {

                    e.preventDefault();

                    Swal.fire({
                        title: 'Hapus ketentuan?',
                        text: 'Ketentuan yang dihapus tidak dapat dikembalikan.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                    }).then((result) => {

                        if (!result.isConfirmed) return;

                        removeSectionBtn.closest('.section-card').remove();

                        reindex();

                        refreshLetters();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Ketentuan berhasil dihapus.',
                            timer: 1500,
                            showConfirmButton: false,
                        });

                    });

                    return;
                }

            });

            refreshLetters();

        });
    </script>
@endsection
