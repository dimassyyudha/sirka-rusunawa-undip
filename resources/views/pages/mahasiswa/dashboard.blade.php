@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')
@section('page_title', 'Dashboard Mahasiswa')

@section('content')

    @php
        $latestReservation = $occupant?->reservation;

        $firstMoveInDate = $occupant?->start_date;

        $leaseEndDate = $occupant?->end_date;
    @endphp


    {{-- @php

        $latestReservation = $occupant?->reservation;

        $firstMoveInDate = $occupant?->start_date;

        $leaseEndDate = null;

        if ($firstMoveInDate) {
            $start = \Carbon\Carbon::parse($firstMoveInDate);

            if ($start->month <= 6) {
                $leaseEndDate = $start->copy()->month(6)->endOfMonth();
            } else {
                $leaseEndDate = $start->copy()->month(12)->endOfMonth();
            }
        }

    @endphp --}}

    <div class="space-y-4">

        {{-- WELCOME --}}
        <div class="rounded-3xl bg-gradient-to-r from-[#1E3A8A] to-[#2563EB] p-6 text-white shadow-sm">

            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                <div>

                    <p class="text-sm text-white/80">
                        Portal Mahasiswa
                    </p>

                    <h1 class="mt-2 text-3xl font-black">
                        Halo, {{ strtok(auth()->user()->name, ' ') }} 👋
                    </h1>

                    <p class="mt-2 text-sm text-white/80">
                        Kelola informasi kamar dan aktivitas rusunawa dengan mudah.
                    </p>

                </div>

                <a href="{{ route('mahasiswa.kamar-saya') }}"
                    class="inline-flex items-center justify-center rounded-2xl bg-white/10 px-5 py-3 text-sm font-bold text-white backdrop-blur transition hover:bg-white/20">

                    Lihat Kamar Saya

                </a>

            </div>

        </div>

        {{-- STATISTIK --}}
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">

            {{-- KAMAR --}}
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm text-slate-500">
                            Kamar Aktif
                        </p>

                        <h3 class="mt-2 text-4xl font-black text-slate-900">
                            {{ $occupant?->room?->kode_kamar ?? '-' }}
                        </h3>

                    </div>

                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.75 7.5h16.5v10.5H3.75z" />

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 12h16.5" />

                        </svg>

                    </div>

                </div>

                <div class="mt-5 border-t border-slate-100 pt-4">

                    <p class="text-sm text-slate-500">
                        @if ($occupant?->room)
                            Gedung {{ $occupant->room->floor?->building?->code ?? '-' }}
                            •
                            Lantai {{ $occupant->room->floor?->floor_number ?? '-' }}
                        @else
                            Belum memiliki kamar aktif.
                        @endif
                    </p>

                </div>

            </div>

            {{-- TAGIHAN --}}
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm text-slate-500">
                            Tagihan Aktif
                        </p>

                        <h3 class="mt-2 text-3xl font-black text-slate-900">
                            {{-- Rp {{ number_format($activeInvoice?->amount ?? 0, 0, ',', '.') }} --}}
                            Rp {{ number_format($activeInvoiceTotal ?? 0, 0, ',', '.') }}
                        </h3>

                    </div>

                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-orange-50 text-orange-600">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.25 6.75h19.5v10.5H2.25z" />

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 10.5h19.5" />

                        </svg>

                    </div>

                </div>

                <div class="mt-5 border-t border-slate-100 pt-4">

                    @if ($activeInvoices->count())
                        <p class="text-sm font-medium text-orange-600">
                            {{ $activeInvoices->count() }}
                            tagihan menunggu pembayaran
                        </p>
                    @else
                        <p class="text-sm font-medium text-emerald-600">
                            Tidak ada tagihan aktif.
                        </p>
                    @endif
                    @if ($activeInvoices->count())

                        <div class="mt-3 space-y-2">

                            @foreach ($activeInvoices as $invoice)
                                <form action="{{ route('mahasiswa.invoices.pay', $invoice) }}" method="POST">

                                    @csrf

                                    <button type="submit"
                                        class="inline-flex items-center text-sm font-bold text-blue-600 hover:text-emerald-700">

                                        Bayar {{ $invoice->invoice_number }}
                                        (Rp {{ number_format($invoice->amount, 0, ',', '.') }})
                                    </button>

                                </form>
                            @endforeach

                        </div>

                    @endif
                    {{-- <form action="{{ route('mahasiswa.invoices.pay', $activeInvoice) }}" method="POST" class="mt-3">

                        @csrf

                        <button type="submit"
                            class="inline-flex items-center text-sm font-bold text-blue-600 hover:text-emerald-700">

                            Bayar Tagihan

                        </button>

                    </form>
                    @endif --}}
                </div>

            </div>

            {{-- STATUS --}}
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm text-slate-500">
                            Status Penghuni
                        </p>

                        <h3 class="mt-2 text-4xl font-black text-emerald-600">
                            {{ $occupant ? 'Aktif' : 'Belum Aktif' }}
                        </h3>

                    </div>

                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.5 12.75l6 6 9-13.5" />

                        </svg>

                    </div>

                </div>

                <div class="mt-5 border-t border-slate-100 pt-4">

                    <p class="text-sm text-slate-500">
                        Mahasiswa memiliki kamar aktif.
                    </p>

                </div>

            </div>

            {{-- MASA SEWA --}}
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm text-slate-500">
                            Masa Sewa
                        </p>

                        <h3 class="mt-2 text-2xl font-black text-slate-900">
                            {{ $leaseEndDate ? \Carbon\Carbon::parse($leaseEndDate)->format('d M Y') : '-' }}
                        </h3>

                    </div>

                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-purple-50 text-purple-600">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6.75 3v2.25M17.25 3v2.25M3 8.25h18" />

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.5 5.25h15A1.5 1.5 0 0121 6.75v12A1.5 1.5 0 0119.5 20.25h-15A1.5 1.5 0 013 18.75v-12A1.5 1.5 0 014.5 5.25z" />

                        </svg>

                    </div>

                </div>

                <div class="mt-5 border-t border-slate-100 pt-4">

                    <div class="h-2 overflow-hidden rounded-full bg-slate-100">

                        <div class="h-full w-[70%] rounded-full bg-purple-500"></div>

                    </div>

                    <p class="mt-3 text-sm text-slate-500">
                        {{ $firstMoveInDate ? 'Masuk sejak ' . \Carbon\Carbon::parse($firstMoveInDate)->format('d M Y') : 'Belum ada masa sewa.' }}
                    </p>

                </div>

            </div>

        </div>

        {{-- TEMAN SEKAMAR --}}
        @if ($occupant?->room)

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">

                <h3 class="text-2xl font-black text-slate-900">
                    Teman Sekamar
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Daftar penghuni lain dalam kamar {{ $occupant->room->kode_kamar }}.
                </p>

                <div class="mt-5 space-y-3">

                    @forelse ($roommates as $roommate)
                        <div class="flex items-center gap-4 rounded-2xl bg-slate-50 p-4">

                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-700">

                                {{ strtoupper(substr($roommate->user->name ?? 'U', 0, 1)) }}

                            </div>

                            <div>

                                <h4 class="font-bold text-slate-900">
                                    {{ $roommate->user->name ?? '-' }}
                                </h4>

                                <p class="mt-1 text-sm text-slate-500">
                                    {{ $roommate->user->studentProfile->jurusan ?? '-' }}
                                    •
                                    Angkatan {{ $roommate->user->studentProfile->angkatan ?? '-' }}
                                </p>

                            </div>

                        </div>

                    @empty

                        <div class="rounded-2xl bg-slate-50 p-5 text-sm text-slate-500">
                            Belum ada teman sekamar yang tercatat.
                        </div>
                    @endforelse

                </div>

            </div>

        @endif

        {{-- PENGUMUMAN --}}
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">

            <h3 class="text-2xl font-black text-slate-900">
                Pengumuman
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                Informasi terbaru untuk penghuni rusunawa.
            </p>

            <div class="mt-5 space-y-3">

                <div class="rounded-2xl bg-slate-50 p-4">

                    <h4 class="font-semibold text-slate-900">
                        Maintenance Air
                    </h4>

                    <p class="mt-1 text-sm text-slate-500">
                        Maintenance air dilakukan pada 30 Mei 2026 pukul 09.00 WIB.
                    </p>

                </div>

                <div class="rounded-2xl bg-slate-50 p-4">

                    <h4 class="font-semibold text-slate-900">
                        Pembayaran Periode Juni
                    </h4>

                    <p class="mt-1 text-sm text-slate-500">
                        Pembayaran periode Juni sudah dapat dilakukan melalui dashboard mahasiswa.
                    </p>

                </div>

            </div>

        </div>

    </div>

@endsection
