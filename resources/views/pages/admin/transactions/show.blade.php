@extends('layouts.app')

@section('title', 'Detail Transaction')

@section('content')
    @php
        $invoice = $transaction->invoice;
        $Reservation = $invoice?->Reservation;
    @endphp

    <div class="p-6 space-y-6">

        <div class="flex justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900">
                    Detail Transaction
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Detail pembayaran dan Reservation mahasiswa.
                </p>
            </div>

            <a href="{{ route('admin.transactions.index') }}"
                class="h-fit px-4 py-2 rounded-xl border border-slate-300 text-sm font-bold text-slate-700 hover:bg-slate-50">
                Kembali
            </a>
        </div>

        <div class="grid lg:grid-cols-2 gap-6">

            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5 space-y-4">
                <h2 class="text-lg font-black text-slate-900">
                    Data Transaksi
                </h2>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Order ID</span>
                        <span class="font-black">{{ $transaction->transaction_code }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">Metode</span>
                        <span class="font-bold">{{ $transaction->payment_method ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">Status</span>
                        <span class="font-black text-emerald-600">{{ strtoupper($transaction->status) }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">Amount</span>
                        <span class="font-black text-orange-600">
                            Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">Tanggal</span>
                        <span class="font-bold">{{ $transaction->created_at?->format('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5 space-y-4">
                <h2 class="text-lg font-black text-slate-900">
                    Data Reservation
                </h2>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Nama</span>
                        <span class="font-bold">{{ $transaction->user?->name ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">Email</span>
                        <span class="font-bold">{{ $transaction->user?->email ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">Kamar</span>
                        <span class="font-bold">{{ $Reservation?->room?->kode_kamar ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">Durasi</span>
                        <span class="font-bold">{{ $Reservation?->duration_month ?? '-' }} bulan</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">Status Reservation</span>
                        <span class="font-black">{{ strtoupper($Reservation?->status ?? '-') }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
