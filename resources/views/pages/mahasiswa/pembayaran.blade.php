@extends('layouts.app')

@section('title', 'Pembayaran')
@section('page_title', 'Pembayaran')

@section('content')

    <div class="space-y-6">

        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-5">

            <div class="bg-white rounded-[30px] border border-slate-200 p-6 shadow-sm">
                <p class="text-sm text-slate-500">
                    Total Tagihan Aktif
                </p>

                <h2 class="mt-2 text-3xl font-black text-slate-900">
                    Rp {{ number_format($totalPending ?? 0, 0, ',', '.') }}
                </h2>

                <p class="mt-4 text-sm text-orange-600 font-bold">
                    Tagihan yang belum dibayar.
                </p>
            </div>

            <div class="bg-white rounded-[30px] border border-slate-200 p-6 shadow-sm">
                <p class="text-sm text-slate-500">
                    Invoice Pending
                </p>

                <h2 class="mt-2 text-3xl font-black text-slate-900">
                    {{ $pendingInvoices ?? 0 }}
                </h2>

                <p class="mt-4 text-sm text-slate-500">
                    Menunggu pembayaran mahasiswa.
                </p>
            </div>

            <div class="bg-white rounded-[30px] border border-slate-200 p-6 shadow-sm">
                <p class="text-sm text-slate-500">
                    Total Transaksi
                </p>

                <h2 class="mt-2 text-3xl font-black text-slate-900">
                    {{ $transactions->count() }}
                </h2>

                <p class="mt-4 text-sm text-slate-500">
                    Seluruh histori pembayaran.
                </p>
            </div>

        </div>

        <div class="bg-white rounded-[30px] border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-100">
                <h3 class="font-black text-slate-900">
                    Riwayat Pembayaran
                </h3>
            </div>

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-slate-50">

                        <tr class="text-left">

                            <th class="px-6 py-4 font-black text-slate-700">
                                Invoice
                            </th>

                            <th class="px-6 py-4 font-black text-slate-700">
                                Total
                            </th>

                            <th class="px-6 py-4 font-black text-slate-700">
                                Status
                            </th>

                            <th class="px-6 py-4 font-black text-slate-700">
                                Tanggal
                            </th>

                            <th class="px-6 py-4 font-black text-slate-700 text-right">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100 text-center whitespace-nowrap">

                        @forelse ($invoices as $invoice)
                            @php

                                $transaction = $invoice->paymentTransactions->sortByDesc('created_at')->first();

                                $status = $transaction?->transaction_status ?? $invoice->status;

                                $badge = match ($status) {
                                    'settlement', 'paid' => 'bg-green-50 text-green-700 border-green-200',

                                    'pending' => 'bg-orange-50 text-orange-700 border-orange-200',

                                    'expire', 'expired', 'failed' => 'bg-red-50 text-red-700 border-red-200',

                                    default => 'bg-slate-50 text-slate-700 border-slate-200',
                                };

                            @endphp

                            <tr>

                                <td class="px-6 py-5">
                                    <p class="font-black text-slate-900">
                                        {{ $invoice->invoice_number }}
                                    </p>
                                </td>

                                <td class="px-6 py-5 font-black text-orange-600">
                                    Rp {{ number_format($invoice->amount ?? 0, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-5">

                                    <span
                                        class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-black uppercase {{ $badge }}">

                                        {{ strtoupper($status) }}

                                    </span>

                                </td>

                                <td class="px-6 py-5 text-sm text-slate-500">
                                    {{ \Carbon\Carbon::parse($invoice->created_at)->translatedFormat('d F Y • H:i') }}
                                    WIB
                                </td>

                                <td class="px-6 py-5 text-right">

                                    @if ($status === 'pending')
                                        @if ($transaction)
                                            <a href="{{ route('Reservation.payment.page', [
                                                'order_id' => $transaction->order_id,
                                                'order_hash' => $transaction->order_hash,
                                            ]) }}"
                                                class="inline-flex items-center justify-center rounded-2xl bg-orange-500 px-4 py-2 text-sm font-black text-white hover:bg-orange-600 transition">

                                                Bayar

                                            </a>
                                        @else
                                            <button
                                                class="inline-flex items-center justify-center rounded-2xl border border-slate-300 px-4 py-2 text-sm font-black text-slate-500 cursor-not-allowed">

                                                Menunggu Transaksi

                                            </button>
                                        @endif
                                    @else
                                        <button
                                            class="inline-flex items-center justify-center rounded-2xl border border-slate-300 px-4 py-2 text-sm font-black text-slate-700">

                                            Selesai

                                        </button>
                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="px-6 py-10 text-center">

                                    <h3 class="text-lg font-black text-slate-900">
                                        Belum Ada Transaksi
                                    </h3>

                                    <p class="mt-2 text-slate-500">
                                        Histori pembayaran akan tampil di sini.
                                    </p>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection
