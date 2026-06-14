@extends('layouts.app')

@section('title', 'Edit Kamar')
@section('page_title', 'Edit Kamar')

@section('content')
    @php
        $photos = $room->photos ?? collect();
    @endphp

    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900">Edit Kamar</h2>
                <p class="text-sm text-slate-500 mt-1">Perbarui data kamar {{ $room->kode_kamar }}.</p>
            </div>

            <x-button.button-menu href="{{ route('admin.rooms.index') }}" variant="outline" size="md">
                Kembali
            </x-button.button-menu>
        </div>

        @if ($errors->any())
            <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.rooms.update', $room) }}" method="POST" enctype="multipart/form-data"
            class="bg-white rounded-[28px] border border-slate-200 shadow-sm p-6 space-y-6">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="block mb-2.5 text-sm font-medium text-heading">
                        Kode Kamar
                    </label>

                    <input type="text" name="kode_kamar" value="{{ old('kode_kamar', $room->kode_kamar) }}" required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 uppercase text-sm font-semibold text-slate-700 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none">

                    @error('kode_kamar')
                        <p class="text-sm text-red-600 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2.5 text-sm font-medium text-heading">
                        Gedung & Lantai
                    </label>

                    <div
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 bg-slate-50 text-sm font-bold text-slate-700">
                        {{ $room->floor->building->name ?? '-' }} - Lantai {{ $room->floor->floor_number ?? '-' }}
                    </div>
                </div>

                <div>
                    <label class="block mb-2.5 text-sm font-medium text-heading">
                        Terisi
                    </label>

                    <input type="number" name="occupied" value="{{ old('occupied', $room->occupied) }}" min="0"
                        required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none">

                    @error('occupied')
                        <p class="text-sm text-red-600 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2.5 text-sm font-medium text-heading">
                        Status
                    </label>

                    <select name="status" required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 bg-white text-sm font-semibold text-slate-700 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none">
                        <option value="tersedia" @selected(old('status', $room->status) == 'tersedia')>Tersedia</option>
                        <option value="penuh" @selected(old('status', $room->status) == 'penuh')>Penuh</option>
                        <option value="maintenance" @selected(old('status', $room->status) == 'maintenance')>Maintenance</option>
                    </select>

                    @error('status')
                        <p class="text-sm text-red-600 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2.5 text-sm font-medium text-heading">
                        Fasilitas
                    </label>

                    <textarea name="fasilitas" rows="3" required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 resize-none text-sm font-semibold text-slate-700 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none">{{ old('fasilitas', $room->fasilitas) }}</textarea>

                    @error('fasilitas')
                        <p class="text-sm text-red-600 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-3 text-sm font-medium text-heading">
                        Foto Kamar Saat Ini
                    </label>

                    @if ($photos->isEmpty())
                        <div
                            class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-6 text-center text-sm font-semibold text-slate-500">
                            Belum ada foto untuk kamar ini.
                        </div>
                    @else
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach ($photos as $photo)
                                <label
                                    class="group rounded-2xl border border-slate-200 bg-white p-2 cursor-pointer hover:border-red-300 transition">
                                    <div class="aspect-[4/3] rounded-xl overflow-hidden bg-slate-100">
                                        <img src="{{ asset($photo->path) }}" alt="Foto kamar"
                                            class="w-full h-full object-cover">
                                    </div>

                                    <div class="flex items-center gap-2 mt-3">
                                        <input type="checkbox" name="delete_photos[]" value="{{ $photo->id }}"
                                            class="rounded border-slate-300 text-red-600 focus:ring-red-500">

                                        <span class="text-xs font-bold text-slate-600">
                                            Hapus foto
                                        </span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2.5 text-sm font-medium text-heading" for="photos">
                        Tambah Foto Baru
                    </label>

                    <input
                        class="cursor-pointer bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full shadow-xs placeholder:text-body"
                        id="photos" name="photos[]" type="file" accept="image/*" multiple>

                    <p class="text-xs text-slate-500 mt-2">
                        Foto baru akan ditambahkan tanpa menghapus foto lama.
                    </p>

                    @error('photos.*')
                        <p class="text-sm text-red-600 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4">
                <x-button.button-menu href="{{ route('admin.rooms.index') }}" variant="outline" size="md">
                    Batal
                </x-button.button-menu>

                <x-button.button-menu type="submit" variant="primary" data-confirm data-confirm-title="Simpan perubahan?"
                    data-confirm-text="Pastikan data sudah sesuai." data-confirm-button-text="Ya, simpan">
                    Simpan Perubahan
                </x-button.button-menu>
            </div>

        </form>

    </div>
@endsection
