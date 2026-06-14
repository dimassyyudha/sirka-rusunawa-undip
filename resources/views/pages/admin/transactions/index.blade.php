@extends('layouts.app')

@section('title', 'Transactions')
@section('page_title', 'Transactions')

@section('content')

    <div class="p-6 space-y-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900">
                    Transactions
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Daftar transaksi pembayaran Rusunawa.
                </p>
            </div>
        </div>

        <form method="GET" class="bg-white rounded-2xl border border-slate-200 p-4 flex flex-col md:flex-row gap-3">

            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari order ID, nama, atau email"
                class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm">

            <select name="status" class="rounded-xl border border-slate-300 px-4 py-2 text-sm">

                <option value="">Semua Status</option>
                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                <option value="settlement" @selected(request('status') === 'settlement')>Settlement</option>
                <option value="capture" @selected(request('status') === 'capture')>Capture</option>
                <option value="paid" @selected(request('status') === 'paid')>Paid</option>
                <option value="failed" @selected(request('status') === 'failed')>Failed</option>
                <option value="expire" @selected(request('status') === 'expire')>Expire</option>
                <option value="expired" @selected(request('status') === 'expired')>Expired</option>

            </select>

            <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 text-white text-sm font-black">
                Filter
            </button>

            <a href="{{ route('admin.transactions.index') }}"
                class="px-5 py-2 rounded-xl border border-slate-300 text-sm font-bold text-slate-700 text-center">
                Reset
            </a>

        </form>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-5 py-4 text-left font-black text-slate-700">Order ID</th>
                            <th class="px-5 py-4 text-left font-black text-slate-700">Nama</th>
                            <th class="px-5 py-4 text-left font-black text-slate-700">Kamar</th>
                            <th class="px-5 py-4 text-left font-black text-slate-700">Payment Method</th>
                            <th class="px-5 py-4 text-left font-black text-slate-700">Payment Status</th>
                            <th class="px-5 py-4 text-left font-black text-slate-700">Total Amount</th>
                            <th class="px-5 py-4 text-left font-black text-slate-700">Transaction Date</th>
                            <th class="px-5 py-4 text-right font-black text-slate-700">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($transactions as $transaction)
                            @php
                                $invoice = $transaction->invoice;

                                $Reservation = $transaction->Reservation ?? $invoice?->Reservation;

                                $reservation = $invoice?->reservation;

                                $room = $Reservation?->room ?? ($reservation?->room ?? $invoice?->room);

                                $user =
                                    $transaction->user ?? ($invoice?->user ?? ($Reservation?->user ?? $reservation?->user));

                                $status =
                                    $transaction->transaction_status ??
                                    ($transaction->status ?? ($invoice?->status ?? 'pending'));

                                $amount =
                                    $transaction->gross_amount ??
                                    ($transaction->amount ?? ($invoice?->amount ?? ($Reservation?->total_price ?? 0)));

                                $paymentMethod = $transaction->payment_type ?? ($transaction->payment_method ?? '-');

                                $orderId =
                                    $transaction->order_id ??
                                    ($transaction->transaction_code ?? ($invoice?->invoice_number ?? '-'));

                                $statusClass = match ($status) {
                                    'settlement', 'capture', 'paid' => 'bg-emerald-50 text-emerald-700',
                                    'pending', 'unpaid' => 'bg-orange-50 text-orange-700',
                                    'expire', 'expired' => 'bg-slate-100 text-slate-600',
                                    'failed', 'deny', 'cancel' => 'bg-red-50 text-red-700',
                                    default => 'bg-slate-100 text-slate-600',
                                };
                            @endphp

                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-4 font-black text-slate-900 whitespace-nowrap">
                                    {{ $orderId }}
                                </td>

                                <td class="px-5 py-4">
                                    <div class="font-bold text-slate-900">
                                        {{ $user?->name ?? '-' }}
                                    </div>

                                    <div class="text-xs text-slate-500">
                                        {{ $user?->email ?? '-' }}
                                    </div>
                                </td>

                                <td class="px-5 py-4 font-bold text-slate-700 whitespace-nowrap">
                                    {{ $room?->kode_kamar ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-slate-700 whitespace-nowrap">
                                    {{ $paymentMethod }}
                                </td>

                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 rounded-full text-xs font-black {{ $statusClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 font-black text-orange-600 whitespace-nowrap">
                                    Rp {{ number_format((int) $amount, 0, ',', '.') }}
                                </td>

                                <td class="px-5 py-4 text-slate-700 whitespace-nowrap">
                                    {{ $transaction->created_at?->format('d M Y') ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-right whitespace-nowrap">
                                    <a href="{{ route('admin.transactions.show', $transaction) }}"
                                        class="inline-flex px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black">
                                        Detail
                                    </a>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-10 text-center text-slate-500">
                                    Belum ada transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 bg-white px-6 py-4">
                <x-ui.pagination :paginator="$transactions" />
            </div>

        </div>

    </div>

@endsection
