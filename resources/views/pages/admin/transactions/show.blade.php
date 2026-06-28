@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('page_title', 'Detail Transaksi')

@section('content')


    @php

        $invoice = $transaction->invoice;

        $reservation = $transaction->Reservation ?? ($invoice?->Reservation ?? $invoice?->reservation);

        $room = $reservation?->room ?? $invoice?->room;

        $user = $transaction->user ?? ($invoice?->user ?? $reservation?->user);

        $status = $transaction->transaction_status ?? ($transaction->status ?? 'pending');

        $amount = $transaction->gross_amount ?? ($transaction->amount ?? ($invoice?->amount ?? 0));

        $paymentMethod = $transaction->payment_type ?? ($transaction->payment_method ?? '-');

        $statusClass = match ($status) {
            'settlement', 'capture', 'paid' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',

            'pending', 'unpaid' => 'bg-orange-50 text-orange-700 border border-orange-200',

            'expire', 'expired' => 'bg-slate-100 text-slate-600 border border-slate-200',

            'failed', 'deny', 'cancel' => 'bg-red-50 text-red-700 border border-red-200',

            default => 'bg-slate-100 text-slate-600 border border-slate-200',
        };

    @endphp

    <div class="p-6 space-y-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>

                <h1 class="text-2xl font-black text-slate-900">
                    Detail Transaksi
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Informasi transaksi pembayaran Rusunawa dan data reservasi mahasiswa.
                </p>

            </div>

            <a href="{{ route('admin.transactions.index') }}"
                class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">

                Kembali

            </a>

        </div>

        <div class="grid gap-6 lg:grid-cols-3">

            <div class="rounded-[10px] border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">
                    Nominal Pembayaran
                </p>

                <h3 class="mt-2 text-3xl font-black text-orange-600">
                    Rp {{ number_format((int) $amount, 0, ',', '.') }}
                </h3>

            </div>

            <div class="rounded-[10px] border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">
                    Status Pembayaran
                </p>

                <div class="mt-3">

                    <span class="rounded-full px-3 py-1 text-xs font-black {{ $statusClass }}">

                        {{ strtoupper(str_replace('_', ' ', $status)) }}

                    </span>

                </div>

            </div>

            <div class="rounded-[10px] border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">
                    Metode Pembayaran
                </p>

                <h3 class="mt-2 text-lg font-black text-slate-900">
                    {{ strtoupper($paymentMethod) }}
                </h3>

            </div>

        </div>

        <div class="grid gap-6 lg:grid-cols-2">

            <div class="rounded-[10px] border border-slate-200 bg-white p-6 shadow-sm">

                <div class="mb-5">

                    <h2 class="text-lg font-black text-slate-900">
                        Informasi Transaksi
                    </h2>

                </div>

                <div class="space-y-4">

                    {{-- <div class="flex justify-between gap-4">

                        <span class="text-slate-500">
                            Kode Transaksi
                        </span>

                        <span class="font-black text-slate-900">

                            {{ $transaction->transaction_code ?? '-' }}

                        </span>

                    </div> --}}

                    <div class="flex justify-between gap-4">

                        <span class="text-slate-500">
                            Order ID
                        </span>

                        <span class="font-semibold text-slate-900">

                            {{ $transaction->order_id ?? '-' }}

                        </span>

                    </div>

                    {{-- <div class="flex justify-between gap-4">

                        <span class="text-slate-500">
                            Transaction ID
                        </span>

                        <span class="font-semibold text-slate-900">

                            {{ $transaction->transaction_id ?? '-' }}

                        </span>

                    </div> --}}

                    <div class="flex justify-between gap-4">

                        <span class="text-slate-500">
                            Metode Pembayaran
                        </span>

                        <span class="font-semibold text-slate-900">

                            {{ $paymentMethod }}

                        </span>

                    </div>

                    <div class="flex justify-between gap-4">

                        <span class="text-slate-500">
                            Status
                        </span>

                        <span class="font-black">

                            <span class="rounded-full px-3 py-1 text-xs {{ $statusClass }}">

                                {{ strtoupper(str_replace('_', ' ', $status)) }}

                            </span>

                        </span>

                    </div>

                    <div class="flex justify-between gap-4">

                        <span class="text-slate-500">
                            Nominal
                        </span>

                        <span class="font-black text-orange-600">

                            Rp {{ number_format((int) $amount, 0, ',', '.') }}

                        </span>

                    </div>

                    <div class="flex justify-between gap-4">

                        <span class="text-slate-500">
                            Tanggal Transaksi
                        </span>

                        <span class="font-semibold text-slate-900">

                            {{ $transaction->created_at?->format('d M Y H:i') ?? '-' }}

                        </span>

                    </div>

                </div>

            </div>

            <div class="rounded-[10px] border border-slate-200 bg-white p-6 shadow-sm">

                <div class="mb-5">

                    <h2 class="text-lg font-black text-slate-900">
                        Informasi Mahasiswa
                    </h2>

                </div>

                <div class="space-y-4">

                    <div class="flex justify-between gap-4">

                        <span class="text-slate-500">
                            Nama
                        </span>

                        <span class="font-semibold text-slate-900">

                            {{ $user?->name ?? '-' }}

                        </span>

                    </div>

                    <div class="flex justify-between gap-4">

                        <span class="text-slate-500">
                            Email
                        </span>

                        <span class="font-semibold text-slate-900">

                            {{ $user?->email ?? '-' }}

                        </span>

                    </div>

                    <div class="flex justify-between gap-4">

                        <span class="text-slate-500">
                            Kamar
                        </span>

                        <span class="font-semibold text-slate-900">

                            {{ $room?->kode_kamar ?? '-' }}

                        </span>

                    </div>

                    <div class="flex justify-between gap-4">

                        <span class="text-slate-500">
                            Gedung
                        </span>

                        <span class="font-semibold text-slate-900">

                            {{ $room?->floor?->building?->name ?? '-' }}

                        </span>

                    </div>

                    <div class="flex justify-between gap-4">

                        <span class="text-slate-500">
                            Lantai
                        </span>

                        <span class="font-semibold text-slate-900">

                            {{ $room?->floor?->floor_number ?? '-' }}

                        </span>

                    </div>

                    <div class="flex justify-between gap-4">

                        <span class="text-slate-500">
                            Status Reservasi
                        </span>

                        <span class="font-black text-slate-900">

                            {{ strtoupper($reservation?->status ?? '-') }}

                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>


@endsection
