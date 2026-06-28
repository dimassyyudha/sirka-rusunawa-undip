@extends('layouts.app')

@section('title', 'Detail Invoice')

@section('content')

    @php

        $student = $invoice->user?->studentProfile;

        $room = $invoice->room;

        $floor = $room?->floor;

        $building = $floor?->building;

        $statusClass = match ($invoice->status) {
            'paid' => 'bg-emerald-100 text-emerald-700',

            'unpaid' => 'bg-red-100 text-red-700',

            'pending' => 'bg-yellow-100 text-yellow-700',

            'expired' => 'bg-slate-100 text-slate-700',

            default => 'bg-slate-100 text-slate-700',
        };

    @endphp

    <div class="p-6 space-y-6">

        <div class="flex items-center justify-between">

            <div>

                <h1 class="text-2xl font-black text-slate-900">
                    Detail Invoice
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Informasi lengkap tagihan mahasiswa Rusunawa.
                </p>

            </div>

            <a href="{{ route('admin.invoices.index') }}"
                class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50">

                Kembali

            </a>

        </div>

        {{-- HEADER --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                <div>

                    <div class="text-sm text-slate-500">
                        Nomor Invoice
                    </div>

                    <div class="text-2xl font-black text-slate-900">
                        {{ $invoice->invoice_number }}
                    </div>

                </div>

                <div>

                    <div class="text-sm text-slate-500">
                        Total Tagihan
                    </div>

                    <div class="text-3xl font-black text-orange-600">
                        {{ $invoice->formatted_amount }}
                    </div>

                </div>

                <div>

                    <span class="px-4 py-2 rounded-full text-sm font-bold {{ $statusClass }}">
                        {{ $invoice->status_label }}
                    </span>

                </div>

            </div>

        </div>

        <div class="grid lg:grid-cols-2 gap-6">

            {{-- DATA MAHASISWA --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">

                <h2 class="text-lg font-black text-slate-900 mb-5">
                    Data Mahasiswa
                </h2>

                <div class="space-y-4 text-sm">

                    <div class="flex justify-between">
                        <span class="text-slate-500">Nama</span>
                        <span class="font-bold">{{ $invoice->user?->name }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">Email</span>
                        <span class="font-bold">{{ $invoice->user?->email }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">NIM</span>
                        <span class="font-bold">{{ $student?->nim }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">Fakultas</span>
                        <span class="font-bold">{{ $student?->fakultas }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">Jurusan</span>
                        <span class="font-bold">{{ $student?->jurusan }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">Pembiayaan</span>
                        <span class="font-bold">
                            {{ $student?->jalur_pembiayaan }}
                        </span>
                    </div>

                </div>

            </div>

            {{-- DATA KAMAR --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">

                <h2 class="text-lg font-black text-slate-900 mb-5">
                    Data Kamar
                </h2>

                <div class="space-y-4 text-sm">

                    <div class="flex justify-between">
                        <span class="text-slate-500">Kode Kamar</span>
                        <span class="font-bold">
                            {{ $room?->kode_kamar }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">Gedung</span>
                        <span class="font-bold">
                            {{ $building?->name }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">Lantai</span>
                        <span class="font-bold">
                            {{ $floor?->floor_number }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">Harga / Bulan</span>
                        <span class="font-bold text-orange-600">
                            Rp {{ number_format($floor?->monthly_price ?? 0, 0, ',', '.') }}
                        </span>
                    </div>

                </div>

            </div>

        </div>

        {{-- DATA TAGIHAN --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">

            <h2 class="text-lg font-black text-slate-900 mb-5">
                Informasi Tagihan
            </h2>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">

                <div>
                    <div class="text-slate-500 text-sm">
                        Jenis Invoice
                    </div>

                    <div class="font-bold mt-1">
                        {{ strtoupper($invoice->invoice_type) }}
                    </div>
                </div>

                <div>
                    <div class="text-slate-500 text-sm">
                        Dibuat
                    </div>

                    <div class="font-bold mt-1">
                        {{ $invoice->created_at?->format('d M Y H:i') }}
                    </div>
                </div>

                <div>
                    <div class="text-slate-500 text-sm">
                        Jatuh Tempo
                    </div>

                    <div class="font-bold mt-1">
                        {{ optional($invoice->due_at)->format('d M Y') }}
                    </div>
                </div>

                <div>
                    <div class="text-slate-500 text-sm">
                        Tanggal Lunas
                    </div>

                    <div class="font-bold mt-1">
                        {{ optional($invoice->paid_at)->format('d M Y H:i') ?? '-' }}
                    </div>
                </div>

            </div>

            @if ($invoice->description)
                <div class="mt-6">

                    <div class="text-slate-500 text-sm mb-2">
                        Keterangan
                    </div>

                    <div class="rounded-xl bg-slate-50 p-4 text-sm">
                        {{ $invoice->description }}
                    </div>

                </div>
            @endif

        </div>

        {{-- RIWAYAT PEMBAYARAN --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-4 border-b border-slate-200">

                <h2 class="text-lg font-black text-slate-900">
                    Riwayat Pembayaran
                </h2>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-6 py-4 text-left">Order ID</th>
                            <th class="px-6 py-4 text-left">Metode</th>
                            <th class="px-6 py-4 text-left">Amount</th>
                            <th class="px-6 py-4 text-left">Status</th>
                            <th class="px-6 py-4 text-left">Tanggal</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($invoice->paymentTransactions as $trx)
                            <tr class="border-t">

                                <td class="px-6 py-4 font-semibold">
                                    {{ $trx->order_id }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $trx->payment_type ?? '-' }}
                                </td>

                                <td class="px-6 py-4 font-bold text-orange-600">
                                    Rp {{ number_format($trx->gross_amount, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ strtoupper($trx->transaction_status) }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $trx->created_at?->format('d M Y H:i') }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="px-6 py-10 text-center text-slate-500">

                                    Belum ada transaksi pembayaran.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- ACTION --}}
        @if ($invoice->status !== 'paid')
            <div class="flex justify-end">

                <form action="{{ route('admin.invoices.send-reminder', $invoice) }}" method="POST">

                    @csrf

                    <button type="submit"
                        class="rounded-xl bg-purple-600 px-5 py-3 text-sm font-bold text-white hover:bg-purple-700">

                        Kirim Reminder Email

                    </button>

                </form>

            </div>
        @endif

    </div>

@endsection
