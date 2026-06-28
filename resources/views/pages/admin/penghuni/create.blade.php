@extends('layouts.app')

@section('title', 'Tambah Penghuni')
@section('page_title', 'Tambah Penghuni')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900">Tambah Penghuni</h2>
                <p class="text-sm text-slate-500 mt-1">Input data mahasiswa penghuni rusunawa.</p>
            </div>

            <x-button.button-menu href="{{ route('admin.penghuni.index') }}" variant="outline" size="md">
                Kembali
            </x-button.button-menu>
        </div>


        <form action="{{ route('admin.penghuni.store') }}" method="POST"
            class="bg-white rounded-[20px] border border-slate-200 shadow-sm overflow-hidden">

            @csrf

            {{-- DATA AKUN --}}
            <div class="p-8 border-b border-slate-200">

                <div class="mb-6">
                    <h3 class="text-lg font-black text-slate-900">
                        Data Akun
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Informasi akun yang digunakan mahasiswa untuk login.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Nama Lengkap
                        </label>

                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Email
                        </label>

                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Password
                        </label>

                        <input type="password" name="password" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            No HP Mahasiswa
                        </label>

                        <input type="text" name="number_phone" value="{{ old('number_phone') }}" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>

                    <div>
    <label class="block mb-2 text-sm font-semibold">
        Jenis Kelamin
    </label>

    <select name="gender"
        class="w-full rounded-2xl border border-slate-200 px-4 py-3"
        required>

        <option value="">Pilih Jenis Kelamin</option>

        <option value="Laki-Laki"
            {{ old('gender') == 'Laki-Laki' ? 'selected' : '' }}>
            Laki-Laki
        </option>

        <option value="Perempuan"
            {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>
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

                        <input type="text" name="nim" value="{{ old('nim') }}" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Fakultas
                        </label>

                        <input type="text" name="fakultas" value="{{ old('fakultas') }}" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Jurusan
                        </label>

                        <input type="text" name="jurusan" value="{{ old('jurusan') }}" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Angkatan
                        </label>

                        <input type="number" name="angkatan" value="{{ old('angkatan') }}" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Tempat Lahir
                        </label>

                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Tanggal Lahir
                        </label>

                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Agama
                        </label>

                        <select name="agama" required class="w-full rounded-2xl border border-slate-200 px-4 py-3">

                            <option value="">Pilih Agama</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>

                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Tipe Hunian
                        </label>

                        <select name="occupancy_type" required class="w-full rounded-2xl border border-slate-200 px-4 py-3">

                            <option value="">
                                Pilih Tipe Hunian
                            </option>

                            <option value="private" @selected(old('occupancy_type') == 'private')>

                                Private

                            </option>

                            <option value="shared" @selected(old('occupancy_type') == 'shared')>

                                Shared

                            </option>

                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Masa Aktif Mulai
                        </label>

                        <input type="date" name="lease_start_date" value="{{ old('lease_start_date') }}" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>


                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Kamar
                        </label>

                        <select name="room_id" class="w-full rounded-2xl border border-slate-200 px-4 py-3">

                            <option value="">-- Pilih Kamar --</option>

                            @foreach ($rooms as $room)
                                <option value="{{ $room->room_id }}">
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

                            <option value="penghuni">Penghuni</option>
                            <option value="tidak_penghuni">Tidak Penghuni</option>

                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-semibold">
                            Alamat Mahasiswa
                        </label>

                        <textarea name="alamat" rows="5" placeholder="Masukkan alamat lengkap mahasiswa..." required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">{{ old('alamat') }}</textarea>
                    </div>
                </div>

            </div>

            {{-- DATA ORANG TUA & HUNIAN --}}
            <div class="p-8">

                <div class="mb-6">
                    <h3 class="text-lg font-black text-slate-900">
                        Data Orang Tua & Hunian
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Informasi keluarga dan kamar mahasiswa.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Nama Orang Tua
                        </label>

                        <input type="text" name="nama_ortu" value="{{ old('nama_ortu') }}" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            No HP Orang Tua
                        </label>

                        <input type="text" name="no_hp_ortu" value="{{ old('no_hp_ortu') }}" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">
                            Pekerjaan Orang Tua
                        </label>

                        <input type="text" name="pekerjaan_orang_tua" value="{{ old('pekerjaan_orang_tua') }}"
                            required class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>



                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-semibold">
                            Alamat Orang Tua
                        </label>

                        <textarea name="alamat_orang_tua" rows="3" required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3">{{ old('alamat_orang_tua') }}</textarea>
                    </div>

                </div>



                <div class="flex flex-col sm:flex-row items-center gap-3 pt-4">

                    <x-button.button-menu type="submit" variant="primary" size="md" class="w-full sm:w-auto"
                        data-confirm data-confirm-title="Apakah data sudah sesuai?"
                        data-confirm-text="Pastikan data sudah sesuai." data-confirm-button-text="Ya, simpan">

                        Simpan Data

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
