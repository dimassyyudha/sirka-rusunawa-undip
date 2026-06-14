@extends('landing.landing')

@section('title', 'Hasil Cek Transaksi')

@section('content')
@php
    $Reservation = $invoice->Reservation;
    $latestTransaction = $invoice->paymentTransactions->sortByDesc('created_at')->first();
@endphp

<section class="min-h-screen bg-slate-50 py-16">
    <div class="mx-auto max-w-4xl px-4">

        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                <div>
                    <h1 class="text-3xl font-black text-slate-900">
                        Status Transaksi
                    </h1>

                    <p class="mt-2 text-slate-500">
                        Detail tagihan reservasi kamar Rusunawa.
                    </p>
                </div>

                <div class="rounded-2xl bg-orange-50 px-5 py-3 text-orange-700">
                    <p class="text-xs font-semibold uppercase">Nomor Invoice</p>
                    <p class="text-lg font-black">{{ $invoice->invoice_number }}</p>
                </div>
            </div>

            <div class="mt-8 grid gap-5 md:grid-cols-2">
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-sm text-slate-500">Nama Mahasiswa</p>
                    <p class="mt-2 text-lg font-bold text-slate-900">
                        {{ $Reservation?->guest_name ?? '-' }}
                    </p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-sm text-slate-500">Kamar</p>
                    <p class="mt-2 text-lg font-bold text-slate-900">
                        {{ $Reservation?->room?->kode_kamar ?? '-' }}
                    </p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-sm text-slate-500">Status Invoice</p>
                    <p class="mt-2 text-lg font-bold uppercase
                        {{ $invoice->status === 'paid' ? 'text-emerald-600' : 'text-orange-600' }}">
                        {{ $invoice->status }}
                    </p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-sm text-slate-500">Status Transaksi</p>
                    <p class="mt-2 text-lg font-bold uppercase text-slate-900">
                        {{ $latestTransaction?->transaction_status ?? '-' }}
                    </p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-sm text-slate-500">Metode Pembayaran</p>
                    <p class="mt-2 text-lg font-bold uppercase text-slate-900">
                        {{ $latestTransaction?->payment_type ?? $latestTransaction?->payment_gateway ?? 'MIDTRANS' }}
                    </p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-sm text-slate-500">Total Tagihan</p>
                    <p class="mt-2 text-lg font-black text-orange-600">
                        Rp {{ number_format($invoice->amount, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                @if(in_array($invoice->status, ['unpaid', 'pending']))
                    <x-button.button-menu
                        href="{{ route('Reservation.payment.page', [
                            'order_id' => $invoice->invoice_number,
                            'order_hash' => $latestTransaction?->order_hash,
                        ]) }}"
                        variant="primary"
                        class="w-full">
                        Lanjutkan Pembayaran
                    </x-button.button-menu>
                @endif

                @if($invoice->status === 'paid' && $Reservation)
                    <x-button.button-menu
                        href="{{ route('Reservation.show', $Reservation) }}"
                        variant="success"
                        class="w-full">
                        Lihat Reservasi
                    </x-button.button-menu>
                @endif

                <x-button.button-menu
                    href="{{ route('invoice.check.form') }}"
                    variant="outline"
                    class="w-full">
                    Cek Invoice Lain
                </x-button.button-menu>
            </div>
        </div>

    </div>
</section>
@endsection