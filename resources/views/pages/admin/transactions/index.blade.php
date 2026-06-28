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

                <p class="mt-1 text-sm text-slate-500">
                    Daftar transaksi pembayaran Rusunawa.
                </p>

            </div>

        </div>

        <form id="filterForm" method="GET" action="{{ route('admin.transactions.index') }}"
            class="mb-6 rounded-[20px] border border-slate-200 bg-white p-5 shadow-sm">

            <div class="grid gap-4 lg:grid-cols-5">

                {{-- SEARCH --}}
                <div>

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Pencarian
                    </label>

                    <input id="searchInput" type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari transaksi..."
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm
                       focus:border-violet-500
                       focus:outline-none
                       focus:ring-4
                       focus:ring-violet-100">

                </div>

                {{-- STATUS --}}
                <div>

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Status
                    </label>

                    <select name="status" class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                        <option value="">Semua Status</option>

                        <option value="pending" @selected(request('status') == 'pending')>
                            Pending
                        </option>

                        <option value="settlement" @selected(request('status') == 'settlement')>
                            Settlement
                        </option>

                        <option value="capture" @selected(request('status') == 'capture')>
                            Capture
                        </option>

                        <option value="paid" @selected(request('status') == 'paid')>
                            Paid
                        </option>

                        <option value="failed" @selected(request('status') == 'failed')>
                            Failed
                        </option>

                        <option value="expire" @selected(request('status') == 'expire')>
                            Expired
                        </option>

                    </select>

                </div>

                {{-- PAYMENT METHOD --}}
                <div>

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Metode Bayar
                    </label>

                    <select name="payment_method"
                        class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                        <option value="">Semua Metode</option>

                        @foreach ($paymentMethods as $method)
                            <option value="{{ $method }}" @selected(request('payment_method') == $method)>

                                {{ strtoupper($method) }}

                            </option>
                        @endforeach

                    </select>

                </div>

                {{-- GEDUNG --}}
                <div>

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Gedung
                    </label>

                    <select name="building_id"
                        class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                        <option value="">Semua Gedung</option>

                        @foreach ($buildings as $building)
                            <option value="{{ $building->building_id }}" @selected(request('building_id') == $building->building_id)>

                                {{ $building->name }}

                            </option>
                        @endforeach

                    </select>

                </div>

                {{-- ACTION --}}
                <div>

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-transparent">
                        Action
                    </label>

                    <div class="flex gap-2">

                        <button type="submit"
                            class="flex-1 rounded-xl bg-violet-600 px-4 py-3 text-sm font-bold text-white hover:bg-violet-700">

                            Filter

                        </button>

                        <a href="{{ route('admin.transactions.index') }}"
                            class="flex-1 rounded-xl border border-slate-300 px-4 py-3 text-center text-sm font-bold text-slate-700 hover:bg-slate-50">

                            Reset

                        </a>

                    </div>

                </div>

            </div>

        </form>

        <div class="overflow-hidden rounded-[10px] border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="border-b border-slate-200 bg-slate-50">

                        <tr>

                            <th class="px-6 py-4 text-center font-black text-slate-700">
                                No
                            </th>

                            <th class="px-5 py-4 text-left font-black text-slate-700">
                                Order ID
                            </th>

                            <th class="px-5 py-4 text-left font-black text-slate-700">
                                Nama Mahasiswa
                            </th>

                            <th class="px-5 py-4 text-left font-black text-slate-700">
                                Kamar
                            </th>

                            <th class="px-5 py-4 text-left font-black text-slate-700">
                                Metode Pembayaran
                            </th>

                            <th class="px-5 py-4 text-left font-black text-slate-700">
                                Status Pembayaran
                            </th>

                            <th class="px-5 py-4 text-left font-black text-slate-700">
                                Total Pembayaran
                            </th>

                            <th class="px-5 py-4 text-left font-black text-slate-700">
                                Tanggal Transaksi
                            </th>

                            <th class="px-5 py-4 text-right font-black text-slate-700">
                                Aksi
                            </th>

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
                                    $transaction->user ??
                                    ($invoice?->user ?? ($Reservation?->user ?? $reservation?->user));

                                $status =
                                    $transaction->transaction_status ??
                                    ($transaction->status ?? ($invoice?->status ?? 'pending'));

                                $amount =
                                    $transaction->gross_amount ??
                                    ($transaction->amount ?? ($invoice?->amount ?? ($Reservation?->total_price ?? 0)));

                                $paymentMethod = $transaction->payment_type ?? ($transaction->payment_method ?? '-');

                                $statusClass = match ($status) {
                                    'settlement',
                                    'capture',
                                    'paid'
                                        => 'bg-emerald-50 text-emerald-700 border border-emerald-200',

                                    'pending', 'unpaid' => 'bg-orange-50 text-orange-700 border border-orange-200',

                                    'expire', 'expired' => 'bg-slate-100 text-slate-600 border border-slate-200',

                                    'failed', 'deny', 'cancel' => 'bg-red-50 text-red-700 border border-red-200',

                                    default => 'bg-slate-100 text-slate-600 border border-slate-200',
                                };
                            @endphp

                            <tr class="hover:bg-slate-50">

                                <td class="px-6 py-4 text-center font-black text-slate-900">

                                    {{ $transactions->firstItem() + $loop->index }}

                                </td>

                                <td class="px-5 py-4">

                                    <span class="font-semibold text-slate-700">

                                        {{-- {{ $transaction->transaction_code ?? '-' }} --}}
                                        {{ $transaction->order_id ?? '-' }}

                                    </span>

                                </td>

                                <td class="px-5 py-4">

                                    <div class="font-bold text-slate-900">

                                        {{ $user?->name ?? '-' }}

                                    </div>

                                    <div class="text-xs text-slate-500">

                                        {{ $user?->email ?? '-' }}

                                    </div>

                                </td>

                                <td class="px-5 py-4 font-semibold text-slate-700">

                                    {{ $room?->kode_kamar ?? '-' }}

                                </td>

                                <td class="px-5 py-4 text-slate-700">

                                    {{ strtoupper($paymentMethod) }}

                                </td>

                                <td class="px-5 py-4">

                                    <span class="rounded-full px-3 py-1 text-xs font-black {{ $statusClass }}">

                                        {{ strtoupper(str_replace('_', ' ', $status)) }}

                                    </span>

                                </td>

                                <td class="px-5 py-4 font-black text-orange-600">

                                    Rp {{ number_format((int) $amount, 0, ',', '.') }}

                                </td>

                                <td class="px-5 py-4 text-slate-700">

                                    {{ $transaction->created_at?->format('d M Y') ?? '-' }}

                                </td>

                                <td class="px-5 py-4 text-right">

                                    <a href="{{ route('admin.transactions.show', $transaction) }}"
                                        class="rounded-xl bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-600 transition hover:bg-blue-600 hover:text-white">

                                        Detail

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9" class="px-6 py-12 text-center text-slate-500">

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
