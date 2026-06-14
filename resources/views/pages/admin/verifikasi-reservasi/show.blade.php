@extends('layouts.app')

@section('title', 'Detail Verifikasi Reservation')
@section('page_title', 'Detail Verifikasi Reservation')

@section('content')

    @php
        $profile = $Reservation->user?->studentProfile;

        function isPdf($file)
        {
            return $file && strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'pdf';
        }
    @endphp

    <div class="space-y-4">

        {{-- HEADER --}}
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                <div>

                    <h1 class="text-2xl font-black text-slate-900">
                        Detail Verifikasi Reservation
                    </h1>

                    <p class="mt-2 text-sm text-slate-500">
                        Verifikasi data mahasiswa dan dokumen pendukung Reservation Rusunawa.
                    </p>

                </div>

                <x-button.button-menu :href="route('admin.verifikasi.index')" color="secondary" icon="arrow-left">

                    Kembali

                </x-button.button-menu>

            </div>

        </div>

        {{-- DATA MAHASISWA --}}
        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-6 py-5">

                <h2 class="text-lg font-black text-slate-900">
                    Data Mahasiswa
                </h2>

            </div>


            <div class="divide-y divide-slate-100 text-base">

                <div class="flex px-6 py-4">
                    <span class="w-48 shrink-0 text-slate-500">Nama Lengkap</span>
                    <span class="mr-3">:</span>
                    <span class="font-bold text-slate-900">
                        {{ $Reservation->guest_name }}
                    </span>
                </div>

                <div class="flex px-6 py-4">
                    <span class="w-48 shrink-0 text-slate-500">NIM</span>
                    <span class="mr-3">:</span>
                    <span class="font-bold text-slate-900">
                        {{ $profile?->nim ?? $Reservation->guest_nim }}
                    </span>
                </div>

                <div class="flex px-6 py-4">
                    <span class="w-48 shrink-0 text-slate-500">Fakultas</span>
                    <span class="mr-3">:</span>
                    <span class="font-bold text-slate-900">
                        {{ $profile?->fakultas ?? '-' }}
                    </span>
                </div>

                <div class="flex px-6 py-4">
                    <span class="w-48 shrink-0 text-slate-500">Jurusan</span>
                    <span class="mr-3">:</span>
                    <span class="font-bold text-slate-900">
                        {{ $profile?->jurusan ?? '-' }}
                    </span>
                </div>

                <div class="flex px-6 py-4">
                    <span class="w-48 shrink-0 text-slate-500">Angkatan</span>
                    <span class="mr-3">:</span>
                    <span class="font-bold text-slate-900">
                        {{ $profile?->angkatan ?? '-' }}
                    </span>
                </div>

                <div class="px-6 py-4">
                    <div class="flex">
                        <span class="w-48 shrink-0 text-slate-500">Alamat</span>
                        <span class="mr-3">:</span>
                        <span class="font-bold leading-relaxed text-slate-900">
                            {{ $profile?->alamat ?? '-' }}
                        </span>
                    </div>
                </div>

                <div class="flex px-6 py-4">
                    <span class="w-48 shrink-0 text-slate-500">No. HP</span>
                    <span class="mr-3">:</span>
                    <span class="font-bold text-slate-900">
                        {{ $profile?->no_hp ?? '-' }}
                    </span>
                </div>

                <div class="flex px-6 py-4">
                    <span class="w-48 shrink-0 text-slate-500">Nama Orang Tua</span>
                    <span class="mr-3">:</span>
                    <span class="font-bold text-slate-900">
                        {{ $profile?->nama_ortu ?? '-' }}
                    </span>
                </div>

                <div class="flex px-6 py-4">
                    <span class="w-48 shrink-0 text-slate-500">No. HP Orang Tua</span>
                    <span class="mr-3">:</span>
                    <span class="font-bold text-slate-900">
                        {{ $profile?->no_hp_ortu ?? '-' }}
                    </span>
                </div>

                <div class="flex px-6 py-4">
                    <span class="w-48 shrink-0 text-slate-500">Status Mahasiswa</span>
                    <span class="mr-3">:</span>

                    <x-ui.badge type="brand" :label="strtoupper(str_replace('_', ' ', $profile?->status_mahasiswa ?? '-'))" />
                </div>

                <div class="flex px-6 py-4">
                    <span class="w-48 shrink-0 text-slate-500">
                        Plat Nomor Kendaraan
                    </span>

                    <span class="mr-3">:</span>

                    <span class="font-bold text-slate-900">
                        {{ $profile?->has_vehicle ? ($profile?->vehicle_plate_number ?: '-') : '-' }}
                    </span>
                </div>

                <div class="flex px-6 py-4">
                    <span class="w-48 shrink-0 text-slate-500">Jalur Pembiayaan</span>
                    <span class="mr-3">:</span>

                    @php
                        $jalur = $profile?->jalur_pembiayaan;
                    @endphp

                    @if ($jalur === 'Bidikmisi/KIP-K')
                        <x-ui.badge type="success" label="Bidikmisi / KIP-K" />
                    @elseif($jalur === 'Non-Bidikmisi/KIP-K')
                        <x-ui.badge type="brand" label="Non Bidikmisi / KIP-K" />
                    @else
                        <span class="font-bold text-slate-900">
                            -
                        </span>
                    @endif
                </div>

                <div class="flex px-6 py-4">
                    <span class="w-48 shrink-0 text-slate-500">Kamar</span>
                    <span class="mr-3">:</span>
                    <span class="font-bold text-slate-900">
                        {{ $Reservation->room?->kode_kamar ?? '-' }}
                    </span>
                </div>

                <div class="flex px-6 py-4">
                    <span class="w-48 shrink-0 text-slate-500">Total Pembayaran</span>
                    <span class="mr-3">:</span>
                    <span class="font-black text-orange-600">
                        Rp {{ number_format($Reservation->total_price, 0, ',', '.') }}
                    </span>
                </div>

            </div>
        </div>

    </div>
    <br>

    {{-- DOKUMEN --}}
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-100 px-6 py-5">

            <h2 class="text-lg font-black text-slate-900">
                Dokumen Mahasiswa
            </h2>

        </div>

        <div class="space-y-8 p-6">

            {{-- PAS FOTO --}}
            <div>

                <div class="mb-4 flex items-center justify-between">

                    <div>

                        <h3 class="font-black text-slate-900">
                            Pas Foto
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Foto profil mahasiswa
                        </p>

                    </div>

                    @if ($Reservation->user?->profile_photo)
                        <a href="{{ Storage::url($Reservation->user->profile_photo) }}" target="_blank"
                            class="text-sm font-bold text-blue-600 hover:underline">

                            Buka File

                        </a>
                    @endif

                </div>

                @if ($Reservation->user?->profile_photo)
                    <div
                        class="flex items-center justify-center overflow-hidden rounded-3xl border border-slate-200 bg-slate-50 p-4">

                        <img src="{{ Storage::url($Reservation->user->profile_photo) }}" alt="Pas Foto"
                            class="max-h-[500px] rounded-2xl object-contain">

                    </div>
                @else
                    <div
                        class="flex h-56 flex-col items-center justify-center rounded-3xl border border-dashed border-slate-300 bg-slate-50 text-center">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L18 9.828M15 5h4v4" />

                        </svg>

                        <p class="mt-4 text-sm font-bold text-slate-400">
                            Pas foto belum tersedia
                        </p>

                    </div>
                @endif

            </div>

            {{-- KTM --}}
            <div>

                <div class="mb-4 flex items-center justify-between">

                    <div>

                        <h3 class="font-black text-slate-900">
                            KTM
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Kartu Tanda Mahasiswa
                        </p>

                    </div>

                    @if ($profile?->ktm_path)
                        <a href="{{ Storage::url($profile->ktm_path) }}" target="_blank"
                            class="text-sm font-bold text-blue-600 hover:underline">

                            Buka File

                        </a>
                    @endif

                </div>

                @if ($profile?->ktm_path)

                    @if (isPdf($profile->ktm_path))
                        <div class="overflow-hidden rounded-3xl border border-slate-200">

                            <iframe src="{{ Storage::url($profile->ktm_path) }}" class="h-[500px] w-full">
                            </iframe>

                        </div>
                    @else
                        <div
                            class="flex items-center justify-center overflow-hidden rounded-3xl border border-slate-200 bg-slate-50 p-4">

                            <img src="{{ Storage::url($profile->ktm_path) }}" alt="KTM"
                                class="max-h-[500px] rounded-2xl object-contain">

                        </div>
                    @endif
                @else
                    <div
                        class="flex h-56 flex-col items-center justify-center rounded-3xl border border-dashed border-slate-300 bg-slate-50 text-center">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />

                        </svg>

                        <p class="mt-4 text-sm font-bold text-slate-400">
                            Dokumen KTM belum diupload
                        </p>

                    </div>

                @endif

            </div>

            @if ($profile?->jalur_pembiayaan === 'Bidikmisi/KIP-K')

                <div>

                    <div class="mb-4 flex items-center justify-between">

                        <div>

                            <h3 class="font-black text-slate-900">
                                Dokumen KIP-K
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Bukti penerima KIP-K
                            </p>

                        </div>

                        @if ($profile?->kip_document_path)
                            <a href="{{ Storage::url($profile->kip_document_path) }}" target="_blank"
                                class="text-sm font-bold text-blue-600 hover:underline">

                                Buka File

                            </a>
                        @endif

                    </div>

                    @if ($profile?->kip_document_path)

                        @if (isPdf($profile->kip_document_path))
                            <div class="overflow-hidden rounded-3xl border border-slate-200">

                                <iframe src="{{ Storage::url($profile->kip_document_path) }}" class="h-[500px] w-full">
                                </iframe>

                            </div>
                        @else
                            <div
                                class="flex items-center justify-center overflow-hidden rounded-3xl border border-slate-200 bg-slate-50 p-4">

                                <img src="{{ Storage::url($profile->kip_document_path) }}" alt="Dokumen KIP-K"
                                    class="max-h-[500px] rounded-2xl object-contain">

                            </div>
                        @endif
                    @else
                        <div
                            class="flex h-56 flex-col items-center justify-center rounded-3xl border border-dashed border-slate-300 bg-slate-50 text-center">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />

                            </svg>

                            <p class="mt-4 text-sm font-bold text-slate-400">
                                Dokumen KIP-K belum diupload
                            </p>

                        </div>

                    @endif

                </div>

            @endif

            {{-- STNK --}}
            <div>

                <div class="mb-4 flex items-center justify-between">

                    <div>

                        <h3 class="font-black text-slate-900">
                            STNK Kendaraan
                        </h3>

                        {{-- <p class="mt-1 text-sm text-slate-500">

                            @if ($profile?->has_vehicle)
                                {{ $profile?->vehicle_plate_number ?? '-' }}
                            @else
                                Mahasiswa tidak membawa kendaraan
                            @endif

                        </p> --}}

                    </div>

                    @if ($profile?->stnk_path)
                        <a href="{{ Storage::url($profile->stnk_path) }}" target="_blank"
                            class="text-sm font-bold text-blue-600 hover:underline">

                            Buka File

                        </a>
                    @endif

                </div>

                @if ($profile?->has_vehicle)

                    @if ($profile?->stnk_path)

                        @if (isPdf($profile->stnk_path))
                            <div class="overflow-hidden rounded-3xl border border-slate-200">

                                <iframe src="{{ Storage::url($profile->stnk_path) }}" class="h-[500px] w-full">
                                </iframe>

                            </div>
                        @else
                            <div
                                class="flex items-center justify-center overflow-hidden rounded-3xl border border-slate-200 bg-slate-50 p-4">

                                <img src="{{ Storage::url($profile->stnk_path) }}" alt="STNK"
                                    class="max-h-[500px] rounded-2xl object-contain">

                            </div>
                        @endif
                    @else
                        <div
                            class="flex h-56 flex-col items-center justify-center rounded-3xl border border-dashed border-slate-300 bg-slate-50 text-center">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />

                            </svg>

                            <p class="mt-4 text-sm font-bold text-slate-400">
                                Dokumen STNK belum diupload
                            </p>

                        </div>

                    @endif
                @else
                    <div
                        class="flex h-56 flex-col items-center justify-center rounded-3xl border border-dashed border-slate-300 bg-slate-50 text-center">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-12.728 12.728M6.343 6.343l11.314 11.314" />

                        </svg>

                        <p class="mt-4 text-sm font-bold text-slate-400">
                            Mahasiswa tidak membawa kendaraan
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>

    {{-- AKSI --}}
    <div class="mt-10 border-t border-slate-200 pt-8">

        <div class="text-center">

            <h2 class="text-lg font-black text-slate-900">
                Keputusan Verifikasi
            </h2>

            <p class="mt-2 text-sm text-slate-500">
                Pastikan seluruh data dan dokumen mahasiswa telah diperiksa sebelum mengambil keputusan.
            </p>

        </div>

        <div class="mt-6 flex flex-wrap justify-center gap-3">

            <form action="{{ route('admin.verifikasi.approve', $Reservation) }}" method="POST">

                @csrf

                <x-button.button-menu type="submit" variant="accent" icon="check-circle" data-confirm
                    data-confirm-title="Setujui Reservasi Ini?" data-confirm-text="Pastikan data sudah sesuai."
                    data-confirm-button-text="Ya, Setuju">

                    Approve Reservation

                </x-button.button-menu>

            </form>

            <form action="{{ route('admin.verifikasi.reject', $Reservation) }}" method="POST" data-confirm
                data-confirm-title="Yakin ingin menolak Reservasi ini?" data-confirm-text="Pastikan data sudah sesuai."
                data-confirm-button-text="Ya, Yakin">

                @csrf

                <x-button.button-menu type="submit" variant="danger" icon="x-circle">

                    Reject Reservation

                </x-button.button-menu>

            </form>

        </div>

    </div>

    </div>

@endsection
