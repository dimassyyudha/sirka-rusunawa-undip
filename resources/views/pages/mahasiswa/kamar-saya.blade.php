@extends('layouts.app')

@section('title', 'Kamar Saya')
@section('page_title', 'Kamar Saya')

@section('content')

    @php
        $latestReservation = $occupant?->reservation;

        $firstMoveInDate = $occupant?->start_date;

        $leaseEndDate =
            $latestReservation?->occupancyPeriod?->lease_end_date ??
            ($latestReservation?->end_date ?? $occupant?->end_date);
    @endphp

    <div class="space-y-6">

        <div class="bg-white rounded-[30px] border border-slate-200 p-6 shadow-sm">
            <div class="flex items-start justify-between gap-5 flex-wrap">

                <div>
                    <h2 class="text-2xl font-black text-slate-900">
                        Informasi Kamar Aktif
                    </h2>

                    <p class="text-slate-500 mt-2">
                        Detail kamar yang sedang ditempati mahasiswa di Rusunawa UNDIP.
                    </p>
                </div>

                <span
                    class="px-4 py-2 rounded-full {{ $occupant ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }} font-black text-sm">
                    {{ $occupant ? 'Status Aktif' : 'Belum Aktif' }}
                </span>

            </div>
        </div>

        @if ($occupant && $occupant->room)

            <div class="grid xl:grid-cols-3 gap-6">

                <div class="xl:col-span-2 bg-white rounded-[30px] border border-slate-200 p-6 shadow-sm">

                    <h3 class="text-xl font-black text-slate-900">
                        Detail Kamar
                    </h3>

                    <div class="mt-6 grid md:grid-cols-2 gap-5">

                        <div class="rounded-3xl bg-slate-50 border border-slate-100 p-5">
                            <p class="text-sm text-slate-500">
                                Kode Kamar
                            </p>

                            <p class="mt-2 text-2xl font-black text-slate-900">
                                {{ $occupant->room->kode_kamar ?? '-' }}
                            </p>
                        </div>

                        <div class="rounded-3xl bg-slate-50 border border-slate-100 p-5">
                            <p class="text-sm text-slate-500">
                                Gedung
                            </p>

                            <p class="mt-2 text-2xl font-black text-slate-900">
                                {{ $occupant->room->floor?->building?->name ?? '-' }}
                            </p>
                        </div>

                        <div class="rounded-3xl bg-slate-50 border border-slate-100 p-5">
                            <p class="text-sm text-slate-500">
                                Lantai
                            </p>

                            <p class="mt-2 text-2xl font-black text-slate-900">
                                {{ $occupant->room->floor?->floor_number ?? '-' }}
                            </p>
                        </div>

                        <div class="rounded-3xl bg-slate-50 border border-slate-100 p-5">
                            <p class="text-sm text-slate-500">
                                Harga Bulanan
                            </p>

                            <p class="mt-2 text-2xl font-black text-orange-500">
                                Rp {{ number_format($occupant->room->floor?->monthly_price ?? 0, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="rounded-3xl bg-slate-50 border border-slate-100 p-5">
                            <p class="text-sm text-slate-500">
                                Tanggal Masuk
                            </p>

                            <p class="mt-2 text-2xl font-black text-slate-900">
                                {{-- {{ $leaseStartDate ? \Carbon\Carbon::parse($leaseStartDate)->format('d M Y') : '-' }} --}}
                                {{ $firstMoveInDate ? \Carbon\Carbon::parse($firstMoveInDate)->format('d M Y') : '-' }}
                            </p>
                        </div>

                        <div class="rounded-3xl bg-slate-50 border border-slate-100 p-5">
                            <p class="text-sm text-slate-500">
                                Akhir Sewa
                            </p>

                            <p class="mt-2 text-2xl font-black text-slate-900">
                                {{ $leaseEndDate ? \Carbon\Carbon::parse($leaseEndDate)->format('d M Y') : '-' }}
                            </p>
                        </div>
                        @if ($occupant?->room)
                            <div class="bg-white rounded-[10px] border border-slate-200 p-6 shadow-sm">

                                <h3 class="text-xl font-black text-slate-900">
                                    Teman Sekamar
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    Daftar penghuni lain dalam kamar {{ $occupant->room->kode_kamar }}.
                                </p>

                                <div class="mt-5 space-y-3">
                                    @forelse ($roommates as $roommate)
                                        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                                            <p class="font-black text-slate-900">
                                                {{ $roommate->user->name ?? '-' }}
                                            </p>

                                            <p class="mt-1 text-sm text-slate-500">
                                                {{ $roommate->user->studentProfile->jurusan ?? '-' }}
                                                •
                                                Angkatan {{ $roommate->user->studentProfile->angkatan ?? '-' }}
                                            </p>
                                        </div>
                                    @empty
                                        <div
                                            class="rounded-2xl border border-slate-100 bg-slate-50 p-4 text-sm text-slate-500">
                                            Belum ada teman sekamar yang tercatat.
                                        </div>
                                    @endforelse
                                </div>

                            </div>
                        @endif

                    </div>

                    @if ($latestReservation?->occupancyPeriod)
                        <div class="mt-6 rounded-3xl border border-indigo-100 bg-indigo-50 p-5">
                            <p class="text-sm font-bold text-indigo-500">
                                Periode Hunian Terakhir
                            </p>

                            <h4 class="mt-1 text-lg font-black text-indigo-900">
                                {{ $latestReservation->occupancyPeriod->name }}
                            </h4>

                            <p class="mt-1 text-sm text-indigo-700">
                                {{-- {{ $latestReservation->occupancyPeriod->lease_start_date?->format('d M Y') }} --}}
                                {{ $occupant->start_date ? \Carbon\Carbon::parse($occupant->start_date)->format('d M Y') : '-' }}
                                -
                                {{ $latestReservation->occupancyPeriod->lease_end_date?->format('d M Y') }}
                            </p>
                        </div>
                    @endif

                </div>

                <div class="bg-white rounded-[30px] border border-slate-200 p-6 shadow-sm">

                    <div class="w-14 h-14 rounded-3xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 7.5h16.5v10.5H3.75z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5" />
                        </svg>
                    </div>

                    <h3 class="mt-5 text-xl font-black text-slate-900">
                        Status Hunian
                    </h3>

                    <p class="mt-2 text-slate-500 leading-relaxed">
                        Mahasiswa saat ini tercatat sebagai penghuni aktif pada kamar
                        <span class="font-black text-slate-900">
                            {{ $occupant->room->kode_kamar ?? '-' }}
                        </span>.
                    </p>

                    @if ($leaseEndDate)
                        <div class="mt-5 rounded-2xl bg-orange-50 border border-orange-100 px-4 py-3">
                            <p class="text-xs font-bold text-orange-500 uppercase">
                                Aktif Sampai
                            </p>

                            <p class="mt-1 text-lg font-black text-orange-700">
                                {{ \Carbon\Carbon::parse($leaseEndDate)->format('d M Y') }}
                            </p>
                        </div>
                    @endif
                    <a href="{{ route('mahasiswa.testimoni.create') }}"
                        class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-white">

                        Beri Testimoni

                    </a>
                </div>

            </div>
        @else
            <div class="bg-white rounded-[30px] border border-slate-200 p-10 text-center shadow-sm">

                <div class="mx-auto w-16 h-16 rounded-3xl bg-slate-100 text-slate-500 flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 7.5h16.5v10.5H3.75z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5" />
                    </svg>
                </div>

                <h3 class="mt-5 text-xl font-black text-slate-900">
                    Belum Memiliki Kamar Aktif
                </h3>

                <p class="mt-2 text-slate-500">
                    Data kamar akan tampil setelah reservasi disetujui dan mahasiswa tercatat sebagai penghuni.
                </p>

                <a href="{{ route('cari-kamar.index') }}"
                    class="inline-flex mt-6 px-6 py-3.5 rounded-2xl bg-orange-500 hover:bg-orange-600 text-white font-black transition">
                    Reservasi Kamar
                </a>

            </div>

        @endif

    </div>

@endsection
