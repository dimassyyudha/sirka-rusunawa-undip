@extends('layouts.app')

@section('title', 'Edit Profil')
@section('page_title', 'Edit Profil')

@section('content')

    @php
        $user = auth()->user();
        $profile = $user->studentProfile;
    @endphp

    <div class="max-w-6xl mx-auto">

        <form action="{{ route('mahasiswa.profil.update') }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="space-y-6">

                {{-- HEADER --}}
                <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm overflow-hidden">

                    <div class="p-6 flex flex-col md:flex-row md:items-center gap-5">

                        <div class="w-24 h-24 rounded-3xl overflow-hidden border border-slate-200 bg-slate-100 shrink-0">

                            @if ($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center text-2xl font-black text-slate-700">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                            @endif

                        </div>

                        <div class="flex-1">

                            <h1 class="text-2xl font-black text-slate-900">
                                {{ $user->name }}
                            </h1>

                            <p class="mt-1 text-sm text-slate-500">
                                Kelola informasi profil mahasiswa Rusunawa UNDIP.
                            </p>

                        </div>

                    </div>

                </div>

                {{-- AKADEMIK --}}
                <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm overflow-hidden">

                    <div class="px-6 py-4 border-b border-slate-100">
                        <h2 class="text-lg font-black text-slate-900">
                            Informasi Akademik
                        </h2>
                    </div>

                    <div class="overflow-x-auto">

                        <table class="w-full">

                            <tbody class="divide-y divide-slate-100 text-center whitespace-nowrap">

                                <tr>
                                    <td class="w-[260px] px-6 py-4 text-sm font-bold text-slate-500">
                                        Nama Lengkap
                                    </td>

                                    <td class="px-6 py-4">
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-slate-400 focus:ring-slate-400">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-6 py-4 text-sm font-bold text-slate-500">
                                        NIM
                                    </td>

                                    <td class="px-6 py-4">
                                        <input type="text" name="nim" value="{{ old('nim', $profile?->nim) }}"
                                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-slate-400 focus:ring-slate-400">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-6 py-4 text-sm font-bold text-slate-500">
                                        Fakultas
                                    </td>

                                    <td class="px-6 py-4">
                                        <input type="text" name="fakultas"
                                            value="{{ old('fakultas', $profile?->fakultas) }}"
                                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-slate-400 focus:ring-slate-400">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-6 py-4 text-sm font-bold text-slate-500">
                                        Program Studi
                                    </td>

                                    <td class="px-6 py-4">
                                        <input type="text" name="jurusan"
                                            value="{{ old('jurusan', $profile?->jurusan) }}"
                                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-slate-400 focus:ring-slate-400">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-6 py-4 text-sm font-bold text-slate-500">
                                        Angkatan
                                    </td>

                                    <td class="px-6 py-4">
                                        <input type="number" name="angkatan"
                                            value="{{ old('angkatan', $profile?->angkatan) }}"
                                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-slate-400 focus:ring-slate-400">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-6 py-4 text-sm font-bold text-slate-500">
                                        Nomor HP
                                    </td>

                                    <td class="px-6 py-4">
                                        <input type="text" name="no_hp" value="{{ old('no_hp', $profile?->no_hp) }}"
                                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-slate-400 focus:ring-slate-400">
                                    </td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

                {{-- PRIBADI --}}
                <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm overflow-hidden">

                    <div class="px-6 py-4 border-b border-slate-100">
                        <h2 class="text-lg font-black text-slate-900">
                            Informasi Pribadi
                        </h2>
                    </div>

                    <div class="overflow-x-auto">

                        <table class="w-full">

                            <tbody class="divide-y divide-slate-100 text-center whitespace-nowrap">

                                <tr>
                                    <td class="w-[260px] px-6 py-4 text-sm font-bold text-slate-500">
                                        Tempat Lahir
                                    </td>

                                    <td class="px-6 py-4">
                                        <input type="text" name="tempat_lahir"
                                            value="{{ old('tempat_lahir', $profile?->tempat_lahir) }}"
                                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-slate-400 focus:ring-slate-400">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-6 py-4 text-sm font-bold text-slate-500">
                                        Tanggal Lahir
                                    </td>

                                    <td class="px-6 py-4">
                                        <input type="date" name="tanggal_lahir"
                                            value="{{ old('tanggal_lahir', $profile?->tanggal_lahir) }}"
                                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-slate-400 focus:ring-slate-400">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-6 py-4 text-sm font-bold text-slate-500">
                                        Agama
                                    </td>

                                    <td class="px-6 py-4">
                                        <select name="agama"
                                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-slate-400 focus:ring-slate-400">

                                            <option value="">Pilih Agama</option>

                                            @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                                <option value="{{ $agama }}" @selected(old('agama', $profile?->agama) == $agama)>
                                                    {{ $agama }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-6 py-4 text-sm font-bold text-slate-500 align-top">
                                        Alamat Rumah
                                    </td>

                                    <td class="px-6 py-4">
                                        <textarea name="alamat" rows="4"
                                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-slate-400 focus:ring-slate-400">{{ old('alamat', $profile?->alamat) }}</textarea>
                                    </td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

                {{-- ORANG TUA --}}
                <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm overflow-hidden">

                    <div class="px-6 py-4 border-b border-slate-100">
                        <h2 class="text-lg font-black text-slate-900">
                            Data Orang Tua / Wali
                        </h2>
                    </div>

                    <div class="overflow-x-auto">

                        <table class="w-full">

                            <tbody class="divide-y divide-slate-100 text-center whitespace-nowrap">

                                <tr>
                                    <td class="w-[260px] px-6 py-4 text-sm font-bold text-slate-500">
                                        Nama Orang Tua
                                    </td>

                                    <td class="px-6 py-4">
                                        <input type="text" name="nama_ortu"
                                            value="{{ old('nama_ortu', $profile?->nama_ortu) }}"
                                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-slate-400 focus:ring-slate-400">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-6 py-4 text-sm font-bold text-slate-500">
                                        No HP Orang Tua
                                    </td>

                                    <td class="px-6 py-4">
                                        <input type="text" name="no_hp_ortu"
                                            value="{{ old('no_hp_ortu', $profile?->no_hp_ortu) }}"
                                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-slate-400 focus:ring-slate-400">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-6 py-4 text-sm font-bold text-slate-500">
                                        Pekerjaan Orang Tua
                                    </td>

                                    <td class="px-6 py-4">
                                        <input type="text" name="pekerjaan_orang_tua"
                                            value="{{ old('pekerjaan_orang_tua', $profile?->pekerjaan_orang_tua) }}"
                                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-slate-400 focus:ring-slate-400">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-6 py-4 text-sm font-bold text-slate-500 align-top">
                                        Alamat Orang Tua
                                    </td>

                                    <td class="px-6 py-4">
                                        <textarea name="alamat_orang_tua" rows="4"
                                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-slate-400 focus:ring-slate-400">{{ old('alamat_orang_tua', $profile?->alamat_orang_tua) }}</textarea>
                                    </td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

                {{-- DOKUMEN --}}
                <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm overflow-hidden">

                    <div class="px-6 py-4 border-b border-slate-100">
                        <h2 class="text-lg font-black text-slate-900">
                            Dokumen Mahasiswa
                        </h2>
                    </div>

                    <div class="overflow-x-auto">

                        <table class="w-full">

                            <tbody class="divide-y divide-slate-100 text-center whitespace-nowrap">

                                {{-- FOTO --}}
                                <tr>
                                    <td class="w-[260px] px-6 py-4 text-sm font-bold text-slate-500 align-top">
                                        Foto Profil
                                    </td>

                                    <td class="px-6 py-4 space-y-3">

                                        <input
                                            class="cursor-pointer bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full shadow-xs placeholder:text-body"
                                            type="file" name="profile_photo_file" accept=".jpg,.jpeg,.png">

                                        @if ($user->profile_photo)
                                            <img src="{{ asset('storage/' . $user->profile_photo) }}"
                                                class="w-24 h-24 rounded-2xl object-cover border border-slate-200">
                                        @endif

                                    </td>
                                </tr>

                                {{-- KTM --}}
                                <tr>
                                    <td class="px-6 py-4 text-sm font-bold text-slate-500 align-top">
                                        KTM Mahasiswa
                                    </td>

                                    <td class="px-6 py-4 space-y-3">

                                        <input
                                            class="cursor-pointer bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full shadow-xs placeholder:text-body"
                                            type="file" name="ktm_file" accept=".jpg,.jpeg,.png,.pdf">

                                        @if ($profile?->ktm_path)
                                            <div class="flex items-center gap-3">


                                                <img id="preview-ktm" src="{{ asset('storage/' . $profile->ktm_path) }}"
                                                    class="w-24 h-24 rounded-2xl object-cover border border-slate-200">
                                                <x-button.button-menu title="Lihat KTM" :href="asset('storage/' . $profile->ktm_path)" target="_blank"
                                                    color="dark" />

                                            </div>
                                        @endif

                                    </td>
                                </tr>

                                {{-- STNK --}}
                                <tr>
                                    <td class="px-6 py-4 text-sm font-bold text-slate-500 align-top">
                                        STNK Kendaraan
                                    </td>

                                    <td class="px-6 py-4 space-y-3">

                                        <input
                                            class="cursor-pointer bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full shadow-xs placeholder:text-body"
                                            type="file" name="stnk_file" accept=".jpg,.jpeg,.png,.pdf">

                                        @if ($profile?->stnk_path)
                                            <div class="flex items-center gap-3">

                                                <img id="preview-stnk"
                                                    src="{{ asset('storage/' . $profile->stnk_path) }}"
                                                    class="w-24 h-24 rounded-2xl object-cover border border-slate-200">
                                                <x-button.button-menu title="Lihat STNK" :href="asset('storage/' . $profile->stnk_path)" target="_blank"
                                                    color="dark" />

                                            </div>
                                        @endif

                                    </td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

                {{-- ACTION --}}
                <div class="flex items-center justify-end gap-3">

                    <a href="{{ route('mahasiswa.profil') }}"
                        class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-black text-slate-700 hover:bg-slate-50 transition">
                        Batal
                    </a>

                    <button type="submit" id="submitButton"
                        class="inline-flex items-center justify-center rounded-2xl bg-slate-900 hover:bg-slate-800 px-6 py-3 text-sm font-black text-white transition">
                        Simpan Perubahan
                    </button>

                </div>
            </div>

        </form>

    </div>

@endsection
