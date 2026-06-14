@extends('layouts.app')

@section('title', 'Tambah Penghuni')
@section('page_title', 'Tambah Penghuni')

@section('content')
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900">Tambah Penghuni</h2>
                <p class="text-sm text-slate-500 mt-1">Input data mahasiswa penghuni rusunawa.</p>
            </div>

            <x-button.button-menu href="{{ route('admin.penghuni.index') }}" variant="outline" size="md">
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

        <form action="{{ route('admin.penghuni.store') }}" method="POST"
            class="bg-white rounded-[28px] border border-slate-200 shadow-sm p-6 space-y-6">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="block mb-2.5 text-sm font-medium text-heading">Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none">
                </div>

                <div>
                    <label class="block mb-2.5 text-sm font-medium text-heading">Email untuk Login</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none">
                </div>

                <div>
                    <label class="block mb-2.5 text-sm font-medium text-heading">Password</label>
                    <input type="password" name="password" required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none">
                    <p class="text-xs text-slate-500 mt-2">Minimal 8 karakter.</p>
                </div>

                <div>
                    <label class="block mb-2.5 text-sm font-medium text-heading">NIM</label>
                    <input type="text" name="nim" value="{{ old('nim') }}" maxlength="14" required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none">
                </div>
                <div>
                    <label class="block mb-2.5 text-sm font-medium text-heading">
                        Fakultas
                    </label>

                    <input type="text" name="fakultas" value="{{ old('fakultas') }}" required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none">
                </div>

                <div>
                    <label class="block mb-2.5 text-sm font-medium text-heading">Jurusan</label>
                    <input type="text" name="jurusan" value="{{ old('jurusan') }}" required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none">
                </div>

                <div>
                    <label class="block mb-2.5 text-sm font-medium text-heading">Angkatan</label>
                    <input type="number" name="angkatan" value="{{ old('angkatan') }}" required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none">
                </div>

                <div>
                    <label class="block mb-2.5 text-sm font-medium text-heading">No HP Mahasiswa</label>
                    <input type="text" name="number_phone" value="{{ old('number_phone') }}"
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none">
                </div>
                <div>
                    <label class="block mb-2.5 text-sm font-medium text-heading">Nama Orang Tua</label>
                    <input type="text" name="nama_ortu" value="{{ old('nama_ortu', $penghuni->nama_ortu ?? '') }}"
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none">
                </div>

                <div>
                    <label class="block mb-2.5 text-sm font-medium text-heading">No HP Orang Tua</label>
                    <input type="text" name="no_hp_ortu" value="{{ old('no_hp_ortu') }}"
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none">
                </div>

                <div>
                    <label class="block mb-2.5 text-sm font-medium text-heading">Status Mahasiswa</label>
                    <select name="status_mahasiswa" required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 bg-white text-sm font-semibold text-slate-700 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none">
                        <option value="penghuni" @selected(old('status_mahasiswa', $penghuni->status_mahasiswa ?? 'penghuni') === 'penghuni')>
                            Penghuni
                        </option>
                        <option value="tidak_penghuni" @selected(old('status_mahasiswa', $penghuni->status_mahasiswa ?? '') === 'tidak_penghuni')>
                            Tidak Penghuni
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2.5 text-sm font-medium text-heading">Kamar</label>
                    <select name="room_id"
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 bg-white text-sm font-semibold text-slate-700 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none">
                        <option value="">-- Pilih Kamar --</option>

                        @foreach ($rooms as $room)
                            @php
                                $capacity = $room->floor->room_capacity ?? 0;
                                $occupied = $room->occupied ?? 0;
                                $available = max(0, $capacity - $occupied);
                            @endphp

                            <option value="{{ $room->id }}" @selected(old('room_id') == $room->id)>
                                {{ $room->kode_kamar }}
                                - {{ $room->floor->building->name ?? '-' }}
                                Lt {{ $room->floor->floor_number ?? '-' }}
                                - Sisa {{ $available }} slot
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2.5 text-sm font-medium text-heading">Alamat</label>
                    <textarea name="alamat" rows="3"
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 resize-none text-sm font-semibold text-slate-700 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none">{{ old('alamat') }}</textarea>
                </div>

            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4">
                <x-button.button-menu href="{{ route('admin.penghuni.index') }}" variant="outline" size="md">
                    Batal
                </x-button.button-menu>

                <x-button.button-menu type="submit" variant="primary" size="md">
                    Simpan Data
                </x-button.button-menu>
            </div>

        </form>

    </div>
@endsection
