@extends('landing.landing')

@section('title', 'Pembayaran Berhasil')

@section('content')
    @php

        $title = match ($Reservation->status) {
            'paid' => 'Pembayaran Berhasil',
            'active' => 'Reservasi Aktif',
            'approved' => 'Reservasi Disetujui',

            'expired' => 'Pembayaran Kedaluwarsa',
            'cancelled' => 'Pembayaran Dibatalkan',
            'rejected' => 'Reservasi Ditolak',

            default => 'Status Reservasi',
        };

        $description = match ($Reservation->status) {
            'paid' => 'Pembayaran berhasil diterima dan sedang menunggu verifikasi admin.',

            'active' => 'Reservasi telah aktif dan kamar dapat digunakan.',

            'approved' => 'Reservasi telah disetujui oleh admin Rusunawa.',

            'expired' => 'Batas waktu pembayaran telah habis.',

            'cancelled' => 'Transaksi pembayaran dibatalkan.',

            'rejected' => 'Reservasi ditolak oleh admin.',

            default => 'Silakan cek status reservasi Anda.',
        };

        $iconBg = match ($Reservation->status) {
            'expired', 'cancelled', 'rejected' => 'bg-red-50 text-red-600',

            default => 'bg-emerald-50 text-emerald-600',
        };

        $statusLabel = match ($Reservation->status) {
            'paid' => 'Menunggu Verifikasi',
            'approved' => 'Disetujui',
            'active' => 'Aktif',
            'completed' => 'Selesai',

            'expired' => 'Kedaluwarsa',
            'cancelled' => 'Dibatalkan',
            'rejected' => 'Ditolak',

            default => ucfirst($Reservation->status),
        };

        $statusColor = match ($Reservation->status) {
            'paid' => 'bg-yellow-100 text-yellow-700',
            'approved' => 'bg-blue-100 text-blue-700',
            'active' => 'bg-emerald-100 text-emerald-700',
            'completed' => 'bg-green-100 text-green-700',

            'expired' => 'bg-red-100 text-red-700',
            'cancelled' => 'bg-red-100 text-red-700',
            'rejected' => 'bg-red-100 text-red-700',

            default => 'bg-slate-100 text-slate-700',
        };

    @endphp

    <section class="min-h-screen bg-slate-50 py-10">

        <div class="mx-auto max-w-4xl px-4">
            @php
                $step = match ($Reservation->status) {
                    'pending', 'expired', 'cancelled' => 2,

                    'paid' => 3,

                    'approved', 'active', 'completed' => 4,

                    default => 2,
                };
            @endphp

            <x-ui.Reservation-stepper :step="$step" :status="$Reservation->status" />
            {{-- <x-ui.reservation-stepper step="4" :status="$reservation->status" /> --}}

            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-6 py-10 text-center">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full {{ $iconBg }}">
                        @if (in_array($Reservation->status, ['expired', 'cancelled', 'rejected']))
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        @endif
                    </div>

                    <h1 class="mt-5 text-3xl font-black text-slate-900">
                        {{ $title }}
                    </h1>

                    <p class="mt-2 text-slate-500">
                        {{ $description }}
                    </p>

                    <div class="mt-5">
                        <span class="inline-flex items-center rounded-full px-4 py-2 text-sm font-bold {{ $statusColor }}">
                            {{ $statusLabel }}
                        </span>
                    </div>

                    <div class="space-y-6 p-6">
                        <div class="space-y-4 rounded-3xl border border-slate-200 bg-slate-50 p-5">
                            <div class="flex justify-between gap-4">
                                <span class="text-sm text-slate-500">Kode Reservation</span>
                                <span class="text-right text-sm font-black text-slate-900">
                                    @if (in_array($Reservation->status, ['active', 'approved', 'completed']))
                                        {{ $Reservation->reservation_code }}
                                    @else
                                        Menunggu Verifikasi Admin
                                    @endif
                                </span>
                            </div>

                            <div class="flex justify-between gap-4">
                                <span class="text-sm text-slate-500">Nomor Invoice</span>
                                <span class="text-right text-sm font-black text-slate-900">
                                    {{ $invoice?->invoice_number ?? '-' }}
                                </span>
                            </div>

                            {{-- <div class="flex justify-between gap-4">
                            <span class="text-sm text-slate-500">Order ID</span>
                            <span class="text-right text-sm font-black text-slate-900">
                                {{ $transaction->order_id }}
                            </span>
                        </div> --}}

                            <div class="flex justify-between gap-4">
                                <span class="text-sm text-slate-500">Nama</span>
                                <span class="text-right text-sm font-black text-slate-900">
                                    {{ $Reservation->guest_name }}
                                </span>
                            </div>

                            <div class="flex justify-between gap-4">
                                <span class="text-sm text-slate-500">Kamar</span>
                                <span class="text-right text-sm font-black text-slate-900">
                                    {{ $Reservation->room?->kode_kamar ?? '-' }}
                                </span>
                            </div>

                            <div class="flex justify-between gap-4">
                                <span class="text-sm text-slate-500">Status Reservasi</span>
                                <span class="text-right text-sm font-black uppercase text-orange-600">
                                    {{ $statusLabel }}
                                </span>
                            </div>

                            <div class="flex justify-between gap-4 border-t border-slate-200 pt-3">
                                <span class="text-sm text-slate-500">Total Pembayaran</span>
                                <span class="text-right text-lg font-black text-orange-600">
                                    Rp
                                    {{ number_format($transaction->gross_amount ?? ($invoice?->amount ?? $Reservation->total_price), 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        @if (in_array($Reservation->status, ['approved', 'active', 'completed']))
                            <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-6 text-center">
                                <div class="text-sm font-bold text-emerald-700">
                                    Kode Reservation
                                </div>

                                <div class="mt-2 text-4xl font-black tracking-[0.25em] text-emerald-700">
                                    {{ $Reservation->reservation_code }}
                                </div>

                                <p class="mt-3 text-sm text-emerald-700">
                                    Simpan kode Reservation ini sebagai bukti reservasi kamar.
                                </p>
                            </div>
                        @endif

                        <div class="flex flex-col gap-3 sm:flex-row">
                            @if (in_array($Reservation->status, ['approved', 'active']))
                                <x-button.button-menu href="{{ route('Reservation.ticket.download', $Reservation) }}"
                                    variant="accent" class="w-full">
                                    Download E-Ticket
                                </x-button.button-menu>
                            @endif

                            @if ($Reservation->status === 'expired')
                                <x-button.button-menu href="{{ route('cari-kamar.index') }}" variant="primary"
                                    class="w-full">
                                    Cari Kamar Lainnya
                                </x-button.button-menu>
                            @else
                                <x-button.button-menu href="{{ route('mahasiswa.reservasi') }}" variant="primary"
                                    class="w-full">
                                    Lihat Reservasi
                                </x-button.button-menu>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
    </section>

    @if (!in_array($Reservation->status, ['active', 'approved', 'rejected', 'expired', 'cancelled']))
        <script>
            setTimeout(function() {
                window.location.reload();
            }, 5000);
        </script>
    @endif
@endsection
