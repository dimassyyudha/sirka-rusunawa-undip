@extends('layouts.app')

@section('title', 'Reservasi')
@section('page_title', 'Reservasi Saya')

@section('content')

    <div class="space-y-6">

        <div class="bg-white rounded-[30px] border border-slate-200 p-6 shadow-sm">
            <div class="flex items-center justify-between gap-4 flex-wrap">

                <div>
                    <h2 class="text-2xl font-black text-slate-900">
                        Riwayat Reservasi
                    </h2>

                    <p class="mt-2 text-slate-500">
                        Pantau seluruh pengajuan hunian Rusunawa Anda.
                    </p>
                </div>

                <a href="{{ route('cari-kamar.index') }}"
                    class="px-5 py-3 rounded-2xl bg-orange-500 hover:bg-orange-600 text-white font-black transition">
                    Reservation Kamar
                </a>

            </div>
        </div>

        <div class="bg-white rounded-[30px] border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-100">
                <h3 class="font-black text-slate-900">
                    Daftar Pengajuan
                </h3>
            </div>

            @forelse ($reservations as $reservation)
                @php
                    $status = $reservation->status ?? 'pending';

                    $invoice = $reservation->invoices->sortByDesc('created_at')->first();

                    $transaction = $invoice?->paymentTransactions?->sortByDesc('created_at')?->first();

                    $paymentStatus = $transaction?->transaction_status ?? ($invoice?->status ?? 'pending');

                    $statusBadge = match ($status) {
                        'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                        'approved' => 'bg-green-50 text-green-700 border-green-200',
                        'rejected' => 'bg-red-50 text-red-700 border-red-200',
                        default => 'bg-slate-50 text-slate-700 border-slate-200',
                    };

                    $paymentBadge = match ($paymentStatus) {
                        'settlement', 'paid' => 'bg-green-50 text-green-700 border-green-200',
                        'pending' => 'bg-orange-50 text-orange-700 border-orange-200',
                        'expire', 'expired', 'failed' => 'bg-red-50 text-red-700 border-red-200',
                        default => 'bg-slate-50 text-slate-700 border-slate-200',
                    };
                @endphp

                <div class="p-6 border-b border-slate-100 last:border-none">

                    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">

                        <div class="flex gap-4">

                            <div
                                class="w-16 h-16 rounded-3xl bg-orange-50 text-orange-600 flex items-center justify-center shrink-0">

                                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 21h18M6 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16" />
                                </svg>

                            </div>

                            <div>

                                <h4 class="text-lg font-black text-slate-900">
                                    Kamar {{ $reservation->room?->kode_kamar ?? '-' }}
                                </h4>

                                <p class="mt-1 text-sm text-slate-500">
                                    {{ $reservation->room?->floor?->building?->name ?? '-' }}
                                    •
                                    Lantai {{ $reservation->room?->floor?->floor_number ?? '-' }}
                                </p>

                                <div class="mt-4 flex flex-wrap gap-2">

                                    <span
                                        class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-black uppercase {{ $statusBadge }}">
                                        {{ $status }}
                                    </span>

                                    <span
                                        class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-black uppercase {{ $paymentBadge }}">
                                        Pembayaran :
                                        {{ $paymentStatus }}
                                    </span>

                                </div>

                                <div class="mt-4 space-y-1 text-sm text-slate-500">

                                    <p>
                                        Diajukan:
                                        {{ \Carbon\Carbon::parse($reservation->created_at)->translatedFormat('d F Y • H:i') }}
                                        WIB
                                    </p>

                                    <p>
                                        Tipe:
                                        {{ ucfirst(str_replace('_', ' ', $reservation->reservation_type ?? 'Reservation')) }}
                                    </p>

                                </div>

                            </div>

                        </div>

                        <div class="flex flex-wrap gap-3">

                            <a href="{{ route('mahasiswa.reservasi.show', $reservation->id) }}"
                                class="inline-flex items-center justify-center rounded-2xl border border-slate-300 px-5 py-3 text-sm font-black text-slate-700 hover:bg-slate-50 transition">
                                Detail
                            </a>

                        </div>

                    </div>

                </div>

            @empty

                <div class="p-10 text-center">

                    <div
                        class="mx-auto w-16 h-16 rounded-3xl bg-orange-50 text-orange-500 flex items-center justify-center">

                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 6.75h7.5M8.25 12h7.5m-7.5 5.25h4.5" />
                        </svg>

                    </div>

                    <h3 class="mt-5 text-xl font-black text-slate-900">
                        Belum Ada Reservasi
                    </h3>

                    <p class="mt-2 text-slate-500">
                        Anda belum memiliki pengajuan hunian Rusunawa.
                    </p>

                </div>
            @endforelse

        </div>

    </div>

@endsection
