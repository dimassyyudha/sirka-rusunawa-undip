@extends('layouts.app')

@section('title', 'Tambah Gedung')
@section('page_title', 'Tambah Gedung')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900">Tambah Gedung</h2>
                <p class="text-sm text-slate-500 mt-1">Tambahkan data gedung baru</p>
            </div>

            <x-button.button-menu href="{{ route('admin.buildings.index') }}" variant="outline" size="md">
                Kembali
            </x-button.button-menu>
        </div>


        <form action="{{ route('admin.buildings.store') }}" method="POST"
            class="bg-white rounded-[20px] border border-slate-200 shadow-sm p-8 lg:p-10 space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Kode Gedung</label>
                <input type="text" name="code" value="{{ old('code') }}"
                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-[#070B55] focus:outline-none"
                    placeholder="Contoh: A">
                @error('code')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Gedung</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-[#070B55] focus:outline-none"
                    placeholder="Contoh: Gedung A">
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Tipe Penghuni</label>
                <select name="gender_type"
                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-[#070B55] focus:outline-none">
                    <option value="">Pilih tipe</option>
                    <option value="Laki-Laki" {{ old('gender_type') == 'laki-laki' ? 'selected' : '' }}>Laki-Laki</option>
                    <option value="Perempuan" {{ old('gender_type') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('gender_type')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Total Lantai</label>
                <input type="number" name="total_floors" value="{{ old('total_floors') }}"
                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-[#070B55] focus:outline-none"
                    placeholder="Contoh: 5">
                @error('total_floors')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-4">

                <div>
                    <h4 class="font-bold text-slate-800">
                        Status Gedung
                    </h4>

                    <p class="text-sm text-slate-500 mt-1">
                        Aktifkan apabila gedung masih digunakan untuk reservasi.
                    </p>
                </div>

                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="is_active" value="0">

                    <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                        {{ old('is_active', 1) ? 'checked' : '' }}>

                    <div
                        class="relative h-8 w-14 rounded-full bg-slate-300 transition-all
            peer-checked:bg-emerald-500
            after:absolute after:left-1 after:top-1
            after:h-6 after:w-6 after:rounded-full
            after:bg-white after:transition-all
            peer-checked:after:translate-x-6">
                    </div>
                </label>

            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3 pt-4">

                <x-button.button-menu type="submit" variant="primary" size="md" class="w-full sm:w-auto" data-confirm
                    data-confirm-title="Apakah data sudah sesuai?" data-confirm-text="Pastikan data sudah sesuai."
                    data-confirm-button-text="Ya, simpan">

                    Simpan Data

                </x-button.button-menu>

                <x-button.button-menu href="{{ route('admin.buildings.index') }}" variant="outline" size="md"
                    class="w-full sm:w-auto">

                    Batal

                </x-button.button-menu>

            </div>

        </form>

    </div>
@endsection
