@extends('layouts.app')

@section('title', 'Verifikasi Reservation')
@section('page_title', 'Verifikasi Reservation')

@section('content')

    <div class="space-y-4">

        {{-- HEADER --}}
        <div class="rounded-[10px] border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                <div>

                    <h1 class="text-3xl font-black text-slate-900">
                        Verifikasi Reservasi
                    </h1>

                    <p class="mt-2 text-slate-500">
                        Kelola verifikasi pembayaran reservasi mahasiswa Rusunawa.
                    </p>

                </div>

                <div class="inline-flex items-center rounded-2xl bg-orange-50 px-4 py-3 text-sm font-bold text-orange-700">

                    {{ $Reservations->total() }}
                    Data Reservasi

                </div>

            </div>

        </div>
        <form id="filterForm" method="GET" action="{{ route('admin.verifikasi.index') }}"
            class="rounded-[10px] border border-slate-200 bg-white p-5 shadow-sm">

            <div class="grid gap-4 lg:grid-cols-5">

                {{-- PENCARIAN --}}
                <div class="lg:col-span-2">

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Pencarian
                    </label>

                    <input id="searchInput" type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama mahasiswa atau NIM..."
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                </div>

                {{-- STATUS --}}
                <div>

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Status Verifikasi
                    </label>

                    <select name="status" class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                        <option value="">
                            Semua Status
                        </option>

                        <option value="paid" @selected(request('status') == 'paid')>
                            Menunggu Verifikasi
                        </option>

                        <option value="active" @selected(request('status') == 'active')>
                            Disetujui
                        </option>

                        <option value="rejected" @selected(request('status') == 'rejected')>
                            Ditolak
                        </option>

                    </select>

                </div>

                {{-- JALUR --}}
                <div>

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Jalur Pembiayaan
                    </label>

                    <select name="jalur" class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                        <option value="">
                            Semua Jalur
                        </option>

                        <option value="kipk" @selected(request('jalur') == 'kipk')>
                            KIP-K
                        </option>

                        <option value="mandiri" @selected(request('jalur') == 'mandiri')>
                            Non KIP-K
                        </option>

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

                        <a href="{{ route('admin.verifikasi.index') }}"
                            class="flex-1 rounded-xl border border-slate-300 px-4 py-3 text-center text-sm font-bold text-slate-700 hover:bg-slate-50">

                            Reset

                        </a>

                    </div>

                </div>

            </div>

        </form>
        {{-- TABLE --}}
        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="border-b border-slate-100 bg-slate-50">

                        <tr>
                            <th class="px-4 py-4 text-center">No</th>
                            <th class="px-4 py-4 text-center">Mahasiswa</th>
                            <th class="px-4 py-4 text-center">NIM</th>
                            <th class="px-4 py-4 text-center">Kamar</th>
                            <th class="px-4 py-4 text-center">Jalur</th>
                            <th class="px-4 py-4 text-center">Skema</th>
                            <th class="px-4 py-4 text-center">Total</th>
                            <th class="px-4 py-4 text-center">Tgl Bayar</th>
                            <th class="px-4 py-4 text-center">Status</th>
                            <th class="px-4 py-4 text-center">Aksi</th>
                        </tr>

                    </thead>





                    <tbody class="divide-y divide-slate-100 bg-white">


                        @forelse($Reservations as $Reservation)
                            @php
                                $invoice = $Reservation->invoices->first();
                                $jalur = $Reservation->user?->studentProfile?->jalur_pembiayaan;
                            @endphp
                            <tr class="transition hover:bg-slate-50 text-center">
                                <td class="px-4 py-5 text-center font-bold">
                                    {{ $loop->iteration + ($Reservations->firstItem() ?? 0) - 1 }}
                                </td>
                                <td class="px-4 py-5 font-semibold text-slate-900">
                                    {{ $Reservation->guest_name }}
                                </td>
                                <td class="px-4 py-5 text-slate-600">
                                    {{ $Reservation->guest_nim }}
                                </td>
                                <td class="px-4 py-5">
                                    <div class="font-semibold">
                                        {{ $Reservation->room?->kode_kamar }}
                                    </div>
                                    <div class="text-xs text-slate-500">
                                        {{ $Reservation->room?->floor?->building?->name }}
                                    </div>
                                </td>
                                <td class="px-4 py-5 text-center">

                                    @if ($jalur === 'Bidikmisi/KIP-K')
                                        <span
                                            class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">
                                            KIP-K
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700">
                                            Non KIP-K
                                        </span>
                                    @endif

                                </td>
                                <td class="px-4 py-5 text-center">

                                    @if ($Reservation->payment_term == 3)
                                        <span
                                            class="inline-flex rounded-full bg-orange-50 px-3 py-1 text-xs font-bold text-orange-700">
                                            Termin 3 Bulan
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-700">
                                            Full Semester
                                        </span>
                                    @endif

                                </td>
                                <td class="px-4 py-5 text-center font-black text-orange-600">
                                    Rp {{ number_format($Reservation->total_price, 0, ',', '.') }}
                                </td>

                                <td class="px-4 py-5 text-center">

                                    @if ($invoice?->paid_at)
                                        <div class="font-semibold text-slate-900">
                                            {{ $invoice->paid_at->timezone('Asia/Jakarta')->format('d M Y') }}
                                        </div>

                                        <div class="text-xs text-slate-500">
                                            {{ $invoice->paid_at->timezone('Asia/Jakarta')->format('H:i') }} WIB
                                        </div>
                                    @else
                                        <span class="text-slate-400">
                                            -
                                        </span>
                                    @endif

                                </td>
                                <td class="px-4 py-5 text-center">

                                    @if ($Reservation->status === 'paid')
                                        <span
                                            class="inline-flex rounded-full bg-orange-50 px-3 py-1 text-xs font-bold text-orange-700">
                                            Menunggu Verifikasi
                                        </span>
                                    @elseif($Reservation->status === 'active')
                                        <span
                                            class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-700">
                                            Disetujui
                                        </span>
                                    @elseif($Reservation->status === 'rejected')
                                        <span
                                            class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-red-700">
                                            Ditolak
                                        </span>
                                    @endif

                                </td>
                                <td class="px-4 py-5 text-center">

                                    <div class="flex justify-center gap-2">

                                        <a href="{{ route('admin.verifikasi.show', $Reservation) }}"
                                            class="rounded-xl bg-blue-600 px-3 py-2 text-xs font-bold text-white">
                                            Detail
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="px-6 py-16 text-center">

                                    <div
                                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-500">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">

                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />

                                        </svg>

                                    </div>

                                    <h3 class="mt-5 text-xl font-black text-slate-900">
                                        Tidak Ada Reservation
                                    </h3>

                                    <p class="mt-2 text-sm text-slate-500">
                                        Belum ada Reservation yang menunggu verifikasi admin.
                                    </p>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


        </div>
        <div class="border-t border-slate-200 px-6 py-4">
            <x-ui.pagination :paginator="$Reservations" />
        </div>


    </div>

@endsection
