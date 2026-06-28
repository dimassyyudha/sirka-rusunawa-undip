@extends('layouts.app')

@section('title', 'Tambah Lantai')
@section('page_title', 'Tambah Lantai')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900">
                    Tambah Lantai
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Tambahkan data lantai baru untuk gedung
                </p>
            </div>

            <x-button.button-menu href="{{ route('admin.floors.index') }}" variant="outline" size="md">
                Kembali
            </x-button.button-menu>
        </div>

        <form action="{{ route('admin.floors.store') }}" method="POST"
            class="bg-white rounded-[20px] border border-slate-200 shadow-sm p-8 lg:p-10 space-y-6">

            @csrf

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Gedung
                </label>

                <select name="building_id" required
                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 bg-white focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none">
                    <option value="">Pilih gedung</option>

                    @foreach ($buildings as $building)
                        <option value="{{ $building->building_id }}"
                            {{ old('building_id') == $building->building_id ? 'selected' : '' }}>
                            {{ $building->name }}
                        </option>
                    @endforeach
                </select>

                @error('building_id')
                    <p class="text-sm text-red-600 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Nomor Lantai
                </label>

                <input type="number" name="floor_number" value="{{ old('floor_number') }}" min="1" required
                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none"
                    placeholder="Contoh: 1">

                @error('floor_number')
                    <p class="text-sm text-red-600 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Total Kamar
                </label>

                <input type="number" name="total_rooms" value="{{ old('total_rooms') }}" min="0" required
                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none"
                    placeholder="Contoh: 20">

                @error('total_rooms')
                    <p class="text-sm text-red-600 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Harga Bulanan
                </label>

                <input type="number" name="monthly_price" value="{{ old('monthly_price') }}" min="0" required
                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none"
                    placeholder="Contoh: 800000">

                @error('monthly_price')
                    <p class="text-sm text-red-600 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Kapasitas per Kamar
                </label>

                <input type="number" name="room_capacity" value="{{ old('room_capacity') }}" min="1" required
                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none"
                    placeholder="Contoh: 2">

                @error('room_capacity')
                    <p class="text-sm text-red-600 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3 pt-4">

                <x-button.button-menu type="submit" variant="primary" size="md" class="w-full sm:w-auto" data-confirm
                    data-confirm-title="Apakah data sudah sesuai?" data-confirm-text="Pastikan data sudah sesuai."
                    data-confirm-button-text="Ya, simpan">

                    Simpan Data

                </x-button.button-menu>

                <x-button.button-menu href="{{ route('admin.floors.index') }}" variant="outline" size="md"
                    class="w-full sm:w-auto">

                    Batal

                </x-button.button-menu>

            </div>

        </form>

    </div>
@endsection
