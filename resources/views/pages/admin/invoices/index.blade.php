@extends('layouts.app')

@section('title', 'Invoice')

@section('content')

    <div class="p-6 space-y-6">

        <div>
            <h1 class="text-2xl font-black text-slate-900">
                Invoice Mahasiswa
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Monitoring tagihan pembayaran mahasiswa Rusunawa.
            </p>
        </div>

        @if (session('success'))
            <div class="rounded-xl bg-green-100 text-green-700 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        <form id="filterForm" method="GET"
            class="bg-white border border-slate-200 rounded-2xl p-4 grid lg:grid-cols-5 gap-3">

            <input id="searchInput" type="text" name="search" value="{{ request('search') }}"
                placeholder="Nama / NIM / Invoice"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-violet-500 focus:outline-none focus:ring-4 focus:ring-violet-100">

            <select name="status" class="auto-filter rounded-xl border border-slate-300 px-4 py-3 text-sm">

                <option value="">Semua Status</option>

                <option value="unpaid" @selected(request('status') == 'unpaid')>
                    Belum Lunas
                </option>

                <option value="paid" @selected(request('status') == 'paid')>
                    Lunas
                </option>

            </select>

            <select name="jalur" class="auto-filter rounded-xl border border-slate-300 px-4 py-3 text-sm">

                <option value="">Semua Jalur</option>

                <option value="Bidikmisi/KIP-K" @selected(request('jalur') == 'Bidikmisi/KIP-K')>
                    KIP-K
                </option>

                <option value="Non-Bidikmisi/KIP-K" @selected(request('jalur') == 'Non-Bidikmisi/KIP-K')>
                    Reguler
                </option>

            </select>

            <select name="gedung" class="auto-filter rounded-xl border border-slate-300 px-4 py-3 text-sm">

                <option value="">Semua Gedung</option>

                @foreach ($buildings as $building)
                    <option value="{{ $building->building_id }}" @selected(request('gedung') == $building->building_id)>
                        {{ $building->name }}
                    </option>
                @endforeach

            </select>

            <div class="flex gap-2">

                <button class="flex-1 rounded-xl bg-purple-600 text-white font-bold">

                    Filter

                </button>

                <a href="{{ route('admin.invoices.index') }}"
                    class="flex-1 rounded-xl border border-slate-300 flex items-center justify-center">

                    Reset

                </a>

            </div>

        </form>

        <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4 text-left">Nama</th>
                            <th class="px-6 py-4 text-left">NIM</th>
                            <th class="px-6 py-4 text-left">Kamar</th>
                            <th class="px-6 py-4 text-left">Gedung</th>
                            <th class="px-6 py-4 text-left">Pembiayaan</th>
                            <th class="px-6 py-4 text-left">Invoice</th>
                            <th class="px-6 py-4 text-left">Tagihan</th>
                            <th class="px-6 py-4 text-left">Jatuh Tempo</th>
                            <th class="px-6 py-4 text-left">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($invoices as $invoice)
                            @php

                                $student = $invoice->user?->studentProfile;

                                $room = $invoice->room;

                                $building = $room?->floor?->building;

                                $statusClass = match ($invoice->status) {
                                    'paid' => 'bg-green-100 text-green-700',

                                    'unpaid' => 'bg-red-100 text-red-700',

                                    'pending' => 'bg-yellow-100 text-yellow-700',

                                    default => 'bg-slate-100 text-slate-700',
                                };

                            @endphp

                            <tr class="border-t">

                                <td class="px-6 py-4">
                                    {{ $invoices->firstItem() + $loop->index }}
                                </td>

                                <td class="px-6 py-4 font-semibold">
                                    {{ $invoice->user?->name }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $student?->nim }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $room?->kode_kamar }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $building?->name }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $student?->jalur_pembiayaan }}
                                </td>

                                <td class="px-6 py-4 font-bold">
                                    {{ $invoice->invoice_number }}
                                </td>

                                <td class="px-6 py-4 font-bold text-orange-600">
                                    {{ $invoice->formatted_amount }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ optional($invoice->due_at)->format('d M Y') }}
                                </td>

                                <td class="px-6 py-4">

                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusClass }}">
                                        {{ $invoice->status_label }}
                                    </span>

                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex justify-end gap-2 whitespace-nowrap">

                                        <a href="{{ route('admin.invoices.show', $invoice) }}"
                                            class="rounded-xl bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-600 transition hover:bg-blue-600 hover:text-white">
                                            Detail
                                        </a>

                                        @if ($invoice->status !== 'paid')
                                            <form method="POST"
                                                action="{{ route('admin.invoices.send-reminder', $invoice) }}">

                                                @csrf

                                                <button
                                                    class="rounded-xl bg-purple-50 px-4 py-2 text-sm font-semibold text-purple-600 transition hover:bg-purple-600 hover:text-white">

                                                    Reminder

                                                </button>

                                            </form>
                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="11" class="text-center py-10 text-slate-500">

                                    Tidak ada data invoice.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="border-t px-6 py-4">
                <x-ui.pagination :paginator="$invoices" />
            </div>

        </div>

    </div>

@endsection
