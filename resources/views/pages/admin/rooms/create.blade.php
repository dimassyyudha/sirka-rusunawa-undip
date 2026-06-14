@extends('layouts.app')

@section('title', 'Tambah Kamar')
@section('page_title', 'Tambah Kamar')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-black text-slate-900">Tambah Kamar Baru</h2>
            <p class="text-sm text-slate-500 mt-1">Input data kamar rusunawa.</p>
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

    <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data"
        class="bg-white rounded-[28px] border border-slate-200 shadow-sm p-6 space-y-6">

        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>
                <label class="block mb-2.5 text-sm font-medium text-heading">
                    Kode Kamar
                </label>

                <input type="text" name="kode_kamar" value="{{ old('kode_kamar') }}" required
                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 uppercase text-sm font-semibold text-slate-700 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none"
                    placeholder="Contoh: A-101">

                @error('kode_kamar')
                    <p class="text-sm text-red-600 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block mb-2.5 text-sm font-medium text-heading">
                    Lantai
                </label>

                <select name="floor_id" required
                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 bg-white text-sm font-semibold text-slate-700 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none">
                    <option value="">-- Pilih Lantai --</option>

                    @foreach ($floors as $floor)
                        <option value="{{ $floor->id }}" @selected(old('floor_id') == $floor->id)>
                            {{ $floor->building->name ?? '-' }} - Lantai {{ $floor->floor_number }}
                        </option>
                    @endforeach
                </select>

                @error('floor_id')
                    <p class="text-sm text-red-600 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block mb-2.5 text-sm font-medium text-heading">
                    Terisi
                </label>

                <input type="number" name="occupied" value="{{ old('occupied', 0) }}" min="0" required
                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none"
                    placeholder="Contoh: 0">

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
                    <option value="tersedia" @selected(old('status', 'tersedia') == 'tersedia')>Tersedia</option>
                    <option value="penuh" @selected(old('status') == 'penuh')>Penuh</option>
                    <option value="maintenance" @selected(old('status') == 'maintenance')>Maintenance</option>
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
                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 resize-none text-sm font-semibold text-slate-700 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none"
                    placeholder="Contoh: WiFi, kasur, lemari, meja belajar">{{ old('fasilitas') }}</textarea>

                @error('fasilitas')
                    <p class="text-sm text-red-600 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block mb-2.5 text-sm font-medium text-heading" for="photos">
                    Upload Foto Kamar
                </label>

                <input
                    class="cursor-pointer bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full shadow-xs placeholder:text-body"
                    id="photos" name="photos[]" type="file" accept="image/*" multiple>

                <p class="text-xs text-slate-500 mt-2">
                    Bisa upload lebih dari 1 foto. Format: jpg, jpeg, png, webp.
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

            <x-button.button-menu type="submit" variant="primary" size="md">
                Simpan Data
            </x-button.button-menu>
        </div>

    </form>

</div>
@endsection
