@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page_title', 'Profil Saya')

@section('content')

    @php
        $user = auth()->user();
        $profile = $user->studentProfile;
    @endphp

    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="bg-white rounded-[28px] border border-slate-200 shadow-sm p-6">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">

                <div class="flex items-center gap-5">

                    <div class="w-24 h-24 rounded-3xl overflow-hidden bg-slate-100 border border-slate-200">

                        @if ($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-2xl font-black text-slate-700">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                        @endif

                    </div>

                    <div>

                        <h2 class="text-2xl font-black text-slate-900">
                            {{ $user->name }}
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            {{ $user->email }}
                        </p>

                        <div
                            class="mt-3 inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700">
                            Akun Aktif
                        </div>

                    </div>

                </div>

                <div class="flex flex-wrap gap-3">

                    <a href="{{ route('mahasiswa.profil.edit') }}">
                        <x-button.button-menu color="dark">
                            Edit Profil
                        </x-button.button-menu>
                    </a>

                </div>

            </div>

        </div>

        {{-- INFORMASI --}}
        <div class="grid xl:grid-cols-2 gap-6">

            {{-- AKADEMIK --}}
            <div class="bg-white rounded-[28px] border border-slate-200 shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b border-slate-100">
                    <h3 class="text-lg font-black text-slate-900">
                        Informasi Akademik
                    </h3>
                </div>

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <tbody class="divide-y divide-slate-100">

                            <tr>
                                <td class="px-6 py-4 text-sm text-slate-500 w-[35%]">
                                    NIM
                                </td>

                                <td class="px-6 py-4 font-bold text-slate-900">
                                    {{ $profile?->nim ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="px-6 py-4 text-sm text-slate-500">
                                    Fakultas
                                </td>

                                <td class="px-6 py-4 font-bold text-slate-900">
                                    {{ $profile?->fakultas ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="px-6 py-4 text-sm text-slate-500">
                                    Program Studi
                                </td>

                                <td class="px-6 py-4 font-bold text-slate-900">
                                    {{ $profile?->jurusan ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="px-6 py-4 text-sm text-slate-500">
                                    Angkatan
                                </td>

                                <td class="px-6 py-4 font-bold text-slate-900">
                                    {{ $profile?->angkatan ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="px-6 py-4 text-sm text-slate-500">
                                    Status Mahasiswa
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 capitalize">
                                        {{ str_replace('_', ' ', $profile?->status_mahasiswa ?? '-') }}
                                    </span>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- PRIBADI --}}
            <div class="bg-white rounded-[28px] border border-slate-200 shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b border-slate-100">
                    <h3 class="text-lg font-black text-slate-900">
                        Informasi Pribadi
                    </h3>
                </div>

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <tbody class="divide-y divide-slate-100">

                            <tr>
                                <td class="px-6 py-4 text-sm text-slate-500 w-[35%]">
                                    Tempat Lahir
                                </td>

                                <td class="px-6 py-4 font-bold text-slate-900">
                                    {{ $profile?->tempat_lahir ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="px-6 py-4 text-sm text-slate-500">
                                    Tanggal Lahir
                                </td>

                                <td class="px-6 py-4 font-bold text-slate-900">
                                    {{ $profile?->tanggal_lahir ? \Carbon\Carbon::parse($profile->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="px-6 py-4 text-sm text-slate-500">
                                    Agama
                                </td>

                                <td class="px-6 py-4 font-bold text-slate-900">
                                    {{ $profile?->agama ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="px-6 py-4 text-sm text-slate-500">
                                    Nomor HP
                                </td>

                                <td class="px-6 py-4 font-bold text-slate-900">
                                    {{ $profile?->no_hp ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="px-6 py-4 text-sm text-slate-500 align-top">
                                    Alamat
                                </td>

                                <td class="px-6 py-4 font-bold text-slate-900 leading-relaxed">
                                    {{ $profile?->alamat ?? '-' }}
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- ORANG TUA --}}
            <div class="bg-white rounded-[28px] border border-slate-200 shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b border-slate-100">
                    <h3 class="text-lg font-black text-slate-900">
                        Orang Tua / Wali
                    </h3>
                </div>

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <tbody class="divide-y divide-slate-100">

                            <tr>
                                <td class="px-6 py-4 text-sm text-slate-500 w-[35%]">
                                    Nama
                                </td>

                                <td class="px-6 py-4 font-bold text-slate-900">
                                    {{ $profile?->nama_ortu ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="px-6 py-4 text-sm text-slate-500">
                                    No HP
                                </td>

                                <td class="px-6 py-4 font-bold text-slate-900">
                                    {{ $profile?->no_hp_ortu ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="px-6 py-4 text-sm text-slate-500">
                                    Pekerjaan
                                </td>

                                <td class="px-6 py-4 font-bold text-slate-900">
                                    {{ $profile?->pekerjaan_orang_tua ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="px-6 py-4 text-sm text-slate-500 align-top">
                                    Alamat
                                </td>

                                <td class="px-6 py-4 font-bold text-slate-900 leading-relaxed">
                                    {{ $profile?->alamat_orang_tua ?? '-' }}
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- DOKUMEN --}}
            <div class="bg-white rounded-[28px] border border-slate-200 shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b border-slate-100">
                    <h3 class="text-lg font-black text-slate-900">
                        Dokumen Mahasiswa
                    </h3>
                </div>

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <tbody class="divide-y divide-slate-100">

                            <tr>
                                <td class="px-6 py-4 text-sm text-slate-500 w-[35%]">
                                    KTM Mahasiswa
                                </td>

                                <td class="px-6 py-4">

                                    @if ($profile?->ktm_path)
                                        <a href="{{ asset('storage/' . $profile->ktm_path) }}" target="_blank">

                                            <x-button.button-menu color="dark">
                                                View KTM
                                            </x-button.button-menu>

                                        </a>
                                    @else
                                        <span class="text-sm font-semibold text-red-500">
                                            Belum upload KTM
                                        </span>
                                    @endif

                                </td>
                            </tr>

                            <tr>
                                <td class="px-6 py-4 text-sm text-slate-500">
                                    STNK Kendaraan
                                </td>

                                <td class="px-6 py-4">

                                    @if ($profile?->stnk_path)
                                        <a href="{{ asset('storage/' . $profile->stnk_path) }}" target="_blank">

                                            <x-button.button-menu color="dark">
                                                View STNK
                                            </x-button.button-menu>

                                        </a>
                                    @else
                                        <span class="text-sm font-semibold text-slate-400">
                                            Tidak ada STNK
                                        </span>
                                    @endif

                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection
