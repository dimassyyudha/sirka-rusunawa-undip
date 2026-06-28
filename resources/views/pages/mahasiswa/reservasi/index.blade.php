@extends('layouts.app')

@section('title', 'Reservasi')
@section('page_title', 'Reservasi Saya')

@section('content')

    <div class="space-y-4">

        {{-- HEADER --}}
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                <div>

                    <h2 class="text-2xl font-black text-slate-900">
                        Riwayat Reservasi
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        Pantau status pengajuan kamar dan riwayat reservasi Rusunawa.
                    </p>

                </div>

                <a href="{{ route('cari-kamar.index') }}"
                    class="inline-flex items-center justify-center rounded-2xl bg-orange-500 px-5 py-3 text-sm font-bold text-white transition hover:bg-orange-600">

                    Reservation Kamar

                </a>

            </div>

        </div>

        {{-- LIST RESERVASI --}}
        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-6 py-5">

                <h3 class="text-xl font-black text-slate-900">
                    Daftar Reservasi
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Informasi reservasi kamar mahasiswa.
                </p>

            </div>

            @if (isset($reservations) && $reservations->count() > 0)

                <div class="divide-y divide-slate-100">

                    @foreach ($reservations as $reservation)
                        @php
                            $status = $reservation->status ?? ($reservation->status ?? 'pending');

                            $transaction = collect($reservation->paymentTransactions ?? [])
                                ->sortByDesc('created_at')
                                ->first();

                            $paymentStatus =
                                $transaction?->transaction_status ?? ($reservation->payment_status ?? 'pending');

                            $reservationDate = $reservation->created_at ?? $reservation->requested_at;

                            $reservationType = match ($reservation->reservation_type) {
                                'Reservation' => 'Reservation Kamar',
                                'extension' => 'Perpanjang Sewa',
                                'transfer' => 'Pindah Kamar',
                                'checkout' => 'Akhiri Kontrak',
                                default => ucfirst($reservation->reservation_type ?? 'Reservasi'),
                            };

                            $badgeClass = match ($status) {
                                'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                'approved', 'active' => 'bg-green-50 text-green-700 border-green-200',
                                'paid' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'rejected', 'cancelled', 'expired' => 'bg-red-50 text-red-700 border-red-200',
                                default => 'bg-slate-50 text-slate-700 border-slate-200',
                            };

                            $paymentBadgeClass = match ($paymentStatus) {
                                'settlement', 'paid' => 'bg-green-50 text-green-700 border-green-200',
                                'pending' => 'bg-orange-50 text-orange-700 border-orange-200',
                                'expire', 'expired', 'failed' => 'bg-red-50 text-red-700 border-red-200',
                                default => 'bg-slate-50 text-slate-700 border-slate-200',
                            };
                        @endphp

                        <div class="p-6">

                            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                                {{-- LEFT --}}
                                <div class="flex gap-4">

                                    <div
                                        class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-orange-50 text-orange-600">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">

                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 21h18M6 21V5a2 2 0 012-2h8a2 2 0 012 2v16M9 8h1m4 0h1M9 12h1m4 0h1M9 16h1m4 0h1" />

                                        </svg>

                                    </div>

                                    <div>

                                        <h4 class="text-xl font-black text-slate-900">
                                            Kamar {{ $reservation->room?->kode_kamar ?? '-' }}
                                        </h4>

                                        <p class="mt-1 text-sm text-slate-500">
                                            {{ $reservation->room?->floor?->building?->name ?? 'Gedung -' }}
                                            •
                                            Lantai {{ $reservation->room?->floor?->floor_number ?? '-' }}
                                        </p>

                                        <p class="mt-3 text-sm text-slate-500">
                                            Reservasi :
                                            <span class="font-semibold text-slate-700">
                                                {{ $reservation->created_at?->format('d M Y • H.i') ?? '-' }} WIB
                                            </span>
                                        </p>

                                        <div class="mt-4 flex flex-wrap gap-2">

                                            <span
                                                class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-black uppercase {{ $badgeClass }}">

                                                Status :
                                                {{ $status === 'expired' ? 'Gagal / Kedaluwarsa' : $status }}

                                            </span>

                                            {{-- <span
                                                class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-black uppercase {{ $paymentBadgeClass }}">

                                                Pembayaran :
                                                {{ strtoupper($paymentStatus) }}

                                            </span> --}}

                                        </div>

                                    </div>

                                </div>

                                {{-- RIGHT --}}
                                <div class="lg:text-right">

                                    <p class="text-sm text-slate-500">
                                        Total Pembayaran
                                    </p>

                                    <h4 class="mt-1 text-3xl font-black text-orange-600">
                                        Rp {{ number_format($reservation->total_price ?? 0, 0, ',', '.') }}
                                    </h4>

                                    <div class="mt-4 flex flex-wrap justify-start gap-2 lg:justify-end">

                                        @if (
                                            ($reservation->payment_status ?? null) === 'pending' &&
                                                $reservation->payment_expired_at &&
                                                now()->lessThan($reservation->payment_expired_at))
                                            <a href="{{ route('Reservation.payment.page', [
                                                'order_id' => $reservation->payment_order_id,
                                                'order_hash' => $reservation->order_hash,
                                            ]) }}"
                                                class="inline-flex items-center justify-center rounded-2xl bg-orange-500 px-4 py-2 text-sm font-bold text-white transition hover:bg-orange-600">

                                                Bayar Sekarang

                                            </a>
                                        @endif

                                        @if (Route::has('Reservation.ticket.download') &&
                                                in_array($reservation->status, ['paid', 'approved', 'active']) &&
                                                in_array($reservation->payment_status, ['paid', 'settlement']))
                                            <a href="{{ route('Reservation.ticket.download', $reservation->reservation_id) }}"
                                                class="inline-flex items-center justify-center rounded-2xl border border-slate-300 px-4 py-2 text-sm font-bold text-slate-700 transition hover:bg-slate-50">

                                                Download Tiket

                                            </a>
                                        @endif

                                    </div>

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>
            @else
                {{-- EMPTY STATE --}}
                <div class="flex flex-col items-center justify-center px-6 py-16 text-center">

                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-purple-50 text-purple-600">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.25 6.75h7.5M8.25 12h7.5m-7.5 5.25h4.5" />

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.75 4.5h16.5v15H3.75z" />

                        </svg>

                    </div>

                    <h4 class="mt-5 text-2xl font-black text-slate-900">
                        Belum Ada Reservasi
                    </h4>

                    <p class="mt-2 max-w-md text-sm leading-relaxed text-slate-500">
                        Silakan lakukan reservasi kamar terlebih dahulu untuk memulai pengajuan hunian.
                    </p>

                    <a href="{{ route('cari-kamar.index') }}"
                        class="mt-6 inline-flex items-center justify-center rounded-2xl bg-orange-500 px-5 py-3 text-sm font-bold text-white transition hover:bg-orange-600">

                        Reservation Kamar

                    </a>

                </div>

            @endif

        </div>

    </div>

@endsection
