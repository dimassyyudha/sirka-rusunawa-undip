@extends('layouts.app')

@section('title', 'Edit Penghuni')
@section('page_title', 'Edit Penghuni')

@section('content')
    <div class="mx-auto max-w-6xl space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>
                <h2 class="text-2xl font-black text-slate-900">
                    Edit Penghuni
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Perbarui data penghuni rusunawa.
                </p>
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

        <form action="{{ route('admin.penghuni.update', $penghuni) }}" method="POST"
            class="overflow-hidden rounded-[24px] border border-slate-200 bg-white shadow-sm">

            @csrf
            @method('PUT')

            {{-- DATA AKUN --}}
            <div class="p-8 border-b border-slate-200">

                <div class="mb-6">
                    <h3 class="text-lg font-black text-slate-900">
                        Data Akun
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Informasi akun mahasiswa.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Nama Lengkap
                        </label>

                        <input type="text" name="name" value="{{ old('name', $penghuni->user->name) }}" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Email
                        </label>

                        <input type="email" name="email" value="{{ old('email', $penghuni->user->email) }}" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            No HP Mahasiswa
                        </label>

                        <input type="text" name="number_phone"
                            value="{{ old('number_phone', $penghuni->user->number_phone) }}" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Jenis Kelamin
                        </label>

                        <select name="gender" required class="w-full rounded-2xl border border-slate-200 px-4 py-3">

                            <option value="">Pilih Jenis Kelamin</option>

                            <option value="Laki-Laki"
                                {{ old('gender', $penghuni->user->gender) == 'Laki-Laki' ? 'selected' : '' }}>
                                Laki-Laki
                            </option>

                            <option value="Perempuan"
                                {{ old('gender', $penghuni->user->gender) == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>

                        </select>

                        @error('gender')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>

            {{-- DATA AKADEMIK --}}
            <div class="p-8 border-b border-slate-200">

                <div class="mb-6">
                    <h3 class="text-lg font-black text-slate-900">
                        Data Akademik
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Informasi akademik mahasiswa.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            NIM
                        </label>

                        <input type="text" name="nim" value="{{ old('nim', $penghuni->nim) }}" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Fakultas
                        </label>

                        <input type="text" name="fakultas" value="{{ old('fakultas', $penghuni->fakultas) }}" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Jurusan
                        </label>

                        <input type="text" name="jurusan" value="{{ old('jurusan', $penghuni->jurusan) }}" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Angkatan
                        </label>

                        <input type="number" name="angkatan" value="{{ old('angkatan', $penghuni->angkatan) }}" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Tempat Lahir
                        </label>

                        <input type="text" name="tempat_lahir"
                            value="{{ old('tempat_lahir', $penghuni->tempat_lahir) }}" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Tanggal Lahir
                        </label>

                        <input type="date" name="tanggal_lahir"
                            value="{{ old('tanggal_lahir', optional($penghuni->tanggal_lahir)->format('Y-m-d')) }}"
                            required class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Agama
                        </label>

                        <select name="agama" required class="w-full rounded-2xl border border-slate-200 px-4 py-3">

                            @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                <option value="{{ $agama }}" @selected(old('agama', $penghuni->agama) == $agama)>
                                    {{ $agama }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Tipe Hunian
                        </label>

                        <select name="occupancy_type" required class="w-full rounded-2xl border border-slate-200 px-4 py-3">

                            <option value="private" @selected(old('occupancy_type', $activeReservation?->occupancy_type) == 'private')>
                                Private
                            </option>

                            <option value="shared" @selected(old('occupancy_type', $activeReservation?->occupancy_type) == 'shared')>
                                Shared
                            </option>

                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Masa Aktif Mulai
                        </label>

                        <input type="date" name="lease_start_date"
                            value="{{ old('lease_start_date', optional($activeReservation?->start_date)->format('Y-m-d')) }}"
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Kamar
                        </label>

                        <select name="room_id" class="w-full rounded-2xl border border-slate-200 px-4 py-3">

                            @foreach ($rooms as $room)
                                <option value="{{ $room->room_id }}" @selected(old('room_id', $penghuni->room_id) == $room->room_id)>

                                    {{ $room->kode_kamar }}
                                    -
                                    {{ $room->floor->building->name }}
                                    -
                                    Lt {{ $room->floor->floor_number }}

                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Status Mahasiswa
                        </label>

                        <select name="status_mahasiswa" class="w-full rounded-2xl border border-slate-200 px-4 py-3">

                            <option value="penghuni" @selected(old('status_mahasiswa', $penghuni->status_mahasiswa) == 'penghuni')>
                                Penghuni
                            </option>

                            <option value="tidak_penghuni" @selected(old('status_mahasiswa', $penghuni->status_mahasiswa) == 'tidak_penghuni')>
                                Tidak Penghuni
                            </option>

                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-semibold">
                            Alamat Mahasiswa
                        </label>

                        <textarea name="alamat" rows="5" required class="w-full rounded-2xl border border-slate-200 px-4 py-3">{{ old('alamat', $penghuni->alamat) }}</textarea>
                    </div>

                </div>

            </div>

            {{-- DATA ORANG TUA --}}
            <div class="p-8">

                <div class="mb-6">
                    <h3 class="text-lg font-black text-slate-900">
                        Data Orang Tua & Hunian
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Informasi keluarga mahasiswa.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Nama Orang Tua
                        </label>

                        <input type="text" name="nama_ortu" value="{{ old('nama_ortu', $penghuni->nama_ortu) }}"
                            required class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            No HP Orang Tua
                        </label>

                        <input type="text" name="no_hp_ortu" value="{{ old('no_hp_ortu', $penghuni->no_hp_ortu) }}"
                            required class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Pekerjaan Orang Tua
                        </label>

                        <input type="text" name="pekerjaan_orang_tua"
                            value="{{ old('pekerjaan_orang_tua', $penghuni->pekerjaan_orang_tua) }}" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-semibold">
                            Alamat Orang Tua
                        </label>

                        <textarea name="alamat_orang_tua" rows="4" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">{{ old('alamat_orang_tua', $penghuni->alamat_orang_tua) }}</textarea>
                    </div>

                </div>

                <div class="flex flex-col sm:flex-row items-center gap-3 pt-4">

                    <x-button.button-menu type="submit" variant="primary" data-confirm
                        data-confirm-title="Simpan perubahan?" data-confirm-text="Pastikan data sudah sesuai."
                        data-confirm-button-text="Ya, simpan">
                        Simpan Perubahan
                    </x-button.button-menu>

                    <x-button.button-menu href="{{ route('admin.penghuni.index') }}" variant="outline" size="md"
                        class="w-full sm:w-auto">

                        Batal

                    </x-button.button-menu>

                </div>

            </div>

        </form>

    </div>
@endsection
