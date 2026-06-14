@extends('landing.landing')

@section('title', 'Status Reservation')

@section('content')
    @php
        // $transaction = $Reservation->paymentTransactions->sortByDesc('created_at')->first();

        // $invoice = $Reservation->invoices->sortByDesc('created_at')->first();

        // $paymentStatus = $transaction?->transaction_status ?? 'belum_ada';

        $invoice = $Reservation->invoices->sortByDesc('created_at')->first();

        $transaction = $invoice?->paymentTransactions?->sortByDesc('created_at')?->first();

        $paymentStatus = $transaction?->transaction_status ?? ($invoice?->status ?? 'pending');

        $ReservationStatusLabel = match ($Reservation->status) {
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Menunggu Verifikasi Admin',
            'approved' => 'Disetujui Admin',
            'active' => 'Aktif',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
            'expired' => 'Kedaluwarsa',
            'completed' => 'Selesai',
            'checked_out' => 'Check Out',
            default => strtoupper($Reservation->status),
        };

        $paymentStatusLabel = match ($paymentStatus) {
            'pending' => 'Menunggu Pembayaran',
            'settlement', 'capture' => 'Pembayaran Berhasil',
            'expire' => 'Kedaluwarsa',
            'cancel' => 'Dibatalkan',
            'deny' => 'Ditolak',
            'failure' => 'Gagal',
            'refund' => 'Refund',
            default => 'Belum Ada Transaksi',
        };
    @endphp

    <section class="min-h-screen bg-slate-50 py-16">
        <div class="mx-auto max-w-4xl px-4">
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">

                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-3xl font-black text-slate-900">
                            Status Reservation
                        </h1>

                        <p class="mt-2 text-slate-500">
                            Informasi reservasi kamar Rusunawa.
                        </p>
                    </div>

                    <div class="rounded-2xl bg-orange-50 px-5 py-3 text-orange-700">
                        <p class="text-xs font-semibold uppercase">
                            Kode Reservation
                        </p>

                        <p class="text-lg font-black">
                            {{ $Reservation->Reservation_code }}
                        </p>
                    </div>
                </div>

                <div class="mt-8 grid gap-5 md:grid-cols-2">
                    <div class="rounded-2xl bg-slate-50 p-5">
                        <p class="text-sm text-slate-500">Nama Mahasiswa</p>
                        <p class="mt-2 text-lg font-bold text-slate-900">
                            {{ $Reservation->guest_name }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-5">
                        <p class="text-sm text-slate-500">Kamar</p>
                        <p class="mt-2 text-lg font-bold text-slate-900">
                            {{ $Reservation->room?->kode_kamar ?? '-' }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-5">
                        <p class="text-sm text-slate-500">Gedung</p>
                        <p class="mt-2 text-lg font-bold text-slate-900">
                            {{ $Reservation->room?->floor?->building?->name ?? '-' }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-5">
                        <p class="text-sm text-slate-500">Nomor Invoice</p>
                        <p class="mt-2 text-lg font-bold text-slate-900">
                            {{ $invoice?->invoice_number ?? '-' }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-5">
                        <p class="text-sm text-slate-500">Order ID</p>
                        <p class="mt-2 text-lg font-bold text-slate-900">
                            {{ $transaction?->order_id ?? '-' }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-5">
                        <p class="text-sm text-slate-500">Total Pembayaran</p>
                        <p class="mt-2 text-lg font-bold text-orange-600">
                            Rp
                            {{ number_format($transaction?->gross_amount ?? ($invoice?->amount ?? $Reservation->total_price), 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-5">
                        <p class="text-sm text-slate-500">Status Reservation</p>
                        <p class="mt-2 text-lg font-bold text-orange-600 uppercase">
                            {{ $ReservationStatusLabel }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-5">
                        <p class="text-sm text-slate-500">Status Pembayaran</p>
                        <p class="mt-2 text-lg font-bold text-orange-600 uppercase">
                            {{ $paymentStatusLabel }}
                        </p>
                    </div>
                </div>

                @if ($Reservation->status === 'pending' && $transaction && $transaction->order_id && $transaction->order_hash)
                    <div class="mt-8">
                        <a href="{{ route('Reservation.payment.page', [
                            'order_id' => $transaction->order_id,
                            'order_hash' => $transaction->order_hash,
                        ]) }}"
                            class="inline-flex w-full items-center justify-center rounded-2xl bg-orange-500 px-6 py-4 text-sm font-black text-white hover:bg-orange-600 transition">
                            Lanjutkan Pembayaran
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </section>
@endsection
