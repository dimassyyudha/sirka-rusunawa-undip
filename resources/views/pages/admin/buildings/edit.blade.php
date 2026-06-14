@extends('layouts.app')

@section('title', 'Edit Gedung')
@section('page_title', 'Edit Gedung')

@section('content')
    <div class="max-w-3xl space-y-6">

        <div>
            <h2 class="text-2xl font-black text-slate-900">Edit Gedung</h2>
            <p class="text-sm text-slate-500 mt-1">Perbarui data gedung</p>
        </div>

        <form action="{{ route('admin.buildings.update', $building) }}" method="POST"
            class="bg-white rounded-[28px] border border-slate-200 shadow-sm p-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Kode Gedung</label>
                <input type="text" name="code" value="{{ old('code', $building->code) }}"
                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-[#070B55] focus:outline-none">
                @error('code')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Gedung</label>
                <input type="text" name="name" value="{{ old('name', $building->name) }}"
                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-[#070B55] focus:outline-none">
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Tipe Penghuni</label>
                <select name="gender_type"
                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-[#070B55] focus:outline-none">
                    <option value="putra" {{ old('gender_type', $building->gender_type) == 'putra' ? 'selected' : '' }}>
                        Putra</option>
                    <option value="putri" {{ old('gender_type', $building->gender_type) == 'putri' ? 'selected' : '' }}>
                        Putri</option>

                </select>
                @error('gender_type')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Total Lantai</label>
                <input type="number" name="total_floors" value="{{ old('total_floors', $building->total_floors) }}"
                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-[#070B55] focus:outline-none">
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
                        {{ old('is_active', $building->is_active) ? 'checked' : '' }}>

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

            <div class="flex flex-col sm:flex-row items-center gap-3 pt-6">

                <x-button.button-menu type="submit" variant="primary" data-confirm data-confirm-title="Simpan perubahan?"
                    data-confirm-text="Pastikan data sudah sesuai." data-confirm-button-text="Ya, simpan">
                    Simpan Perubahan
                </x-button.button-menu>

                <x-button.button-menu href="{{ route('admin.buildings.index') }}" variant="outline" size="md"
                    class="w-full sm:w-auto">

                    Batal

                </x-button.button-menu>

            </div>

        </form>

    </div>
@endsection
