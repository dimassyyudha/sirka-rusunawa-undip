@extends('layouts.app')

@section('title', 'Verifikasi Reservation')
@section('page_title', 'Verifikasi Reservation')

@section('content')
    <div class="flex gap-2">
        <a href="{{ route('admin.verifikasi.index') }}" class="px-4 py-2 rounded-xl bg-slate-100">
            Semua
        </a>

        <a href="{{ route('admin.verifikasi.index', ['status' => 'paid']) }}"
            class="px-4 py-2 rounded-xl bg-orange-100 text-orange-700">
            Pending
        </a>

        <a href="{{ route('admin.verifikasi.index', ['status' => 'active']) }}"
            class="px-4 py-2 rounded-xl bg-green-100 text-green-700">
            Disetujui
        </a>

        <a href="{{ route('admin.verifikasi.index', ['status' => 'rejected']) }}"
            class="px-4 py-2 rounded-xl bg-red-100 text-red-700">
            Ditolak
        </a>
    </div>
    <div class="space-y-4">

        {{-- HEADER --}}
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                <div>

                    <h1 class="text-2xl font-black text-slate-900">
                        Verifikasi Reservation
                    </h1>

                    <p class="mt-2 text-sm text-slate-500">
                        Daftar Reservation mahasiswa yang sudah melakukan pembayaran dan menunggu verifikasi admin.
                    </p>

                </div>

                @php
                    $counterLabel = match ($status) {
                        'paid' => 'Menunggu Verifikasi',
                        'active' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        default => 'Total Reservation',
                    };
                @endphp

                <div class="inline-flex items-center rounded-2xl bg-orange-50 px-4 py-3 text-sm font-bold text-orange-700">
                    {{ $Reservations->total() }} {{ $counterLabel }}
                </div>

            </div>

        </div>

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


                    {{-- @forelse ($Reservations as $Reservation)
                            <tr class="transition hover:bg-slate-50">


                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-4">

                                        <div
                                            class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 text-sm font-black text-blue-700">

                                            {{ strtoupper(substr($Reservation->guest_name, 0, 1)) }}

                                        </div>

                                        <div>

                                            <h3 class="font-black text-slate-900">
                                                {{ $Reservation->guest_name }}
                                            </h3>

                                            <p class="mt-1 text-xs text-slate-500">
                                                {{ $Reservation->guest_nim }}
                                            </p>

                                        </div>

                                    </div>

                                </td>

                                <td class="px-6 py-5">

                                    <div>

                                        <h4 class="font-black text-slate-900">
                                            {{ $Reservation->room?->kode_kamar ?? '-' }}
                                        </h4>

                                        <p class="mt-1 text-xs text-slate-500">
                                            {{ $Reservation->room?->floor?->building?->name ?? 'Gedung -' }}
                                        </p>

                                    </div>

                                </td>
                                <td class="px-6 py-5">

                                    <h4 class="font-black text-orange-600">
                                        Rp {{ number_format($Reservation->total_price, 0, ',', '.') }}
                                    </h4>

                                </td>


                                <td class="px-6 py-5 text-center">

                                    @php
                                        $badge = match ($Reservation->status) {
                                            'paid' => [
                                                'label' => 'Menunggu Verifikasi',
                                                'class' => 'bg-orange-50 text-orange-700',
                                            ],

                                            'active' => [
                                                'label' => 'Disetujui',
                                                'class' => 'bg-green-50 text-green-700',
                                            ],

                                            'rejected' => [
                                                'label' => 'Ditolak',
                                                'class' => 'bg-red-50 text-red-700',
                                            ],

                                            default => [
                                                'label' => ucfirst($Reservation->status),
                                                'class' => 'bg-slate-50 text-slate-700',
                                            ],
                                        };
                                    @endphp

                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-black {{ $badge['class'] }}">
                                        {{ $badge['label'] }}
                                    </span>

                                </td>
                                <td class="px-6 py-5 text-center">

                                    <a href="{{ route('admin.verifikasi.show', $Reservation) }}"
                                        class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-4 py-2 text-xs font-black text-white transition hover:bg-blue-700">
                                        Lihat Detail
                                    </a>

                                </td>

                            </tr>

                        @empty
                            <tr>

                                <td colspan="5" class="px-6 py-16 text-center">

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
                        @endforelse --}}


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

            <div class="border-t border-slate-200 bg-white px-6 py-4">
                <x-ui.pagination :paginator="$Reservations" />
            </div>
        </div>

    </div>

@endsection
