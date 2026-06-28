@extends('layouts.app')

@section('title', 'Laporan Keuangan')
@section('page_title', 'Laporan Keuangan')

@section('content')

    <div class="space-y-6">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900">
                    Laporan Keuangan
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Rekap pendapatan berdasarkan pembayaran yang berhasil.
                </p>
            </div>


            <x-button.button-menu type="button" variant="primary" size="lg"
                href="{{ route('admin.financial.export', request()->query()) }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>

                Export Laporan
            </x-button.button-menu>
        </div>



        <div class="mb-8 bg-white rounded-[10px] border border-slate-200 shadow-sm p-5">

            <form id="filterForm" method="GET" action="{{ route('admin.financial.index') }}"
                class="grid gap-4 lg:grid-cols-5">

                {{-- PERIODE --}}
                <div>

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Periode Registrasi
                    </label>

                    <select name="occupancy_period_id"
                        class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                        <option value="">
                            Semua Periode
                        </option>

                        @foreach ($periods as $period)
                            <option value="{{ $period->occupancy_period_id }}" @selected(request('occupancy_period_id') == $period->occupancy_period_id)>

                                {{ $period->semester_type === 'ganjil' ? 'Semester Ganjil' : 'Semester Genap' }}
                                -
                                {{ $period->academic_year_start }}/{{ $period->academic_year_end }}

                            </option>
                        @endforeach

                    </select>

                </div>

                {{-- TANGGAL MULAI --}}
                <div>

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Tanggal Mulai
                    </label>

                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                        @if (request('occupancy_period_id')) disabled @endif
                        class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-violet-500 focus:outline-none focus:ring-4 focus:ring-violet-100 disabled:bg-slate-100">

                </div>

                {{-- TANGGAL AKHIR --}}
                <div>

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Tanggal Akhir
                    </label>

                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                        @if (request('occupancy_period_id')) disabled @endif
                        class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-violet-500 focus:outline-none focus:ring-4 focus:ring-violet-100 disabled:bg-slate-100">

                </div>

                {{-- GEDUNG --}}
                <div>

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Gedung
                    </label>

                    <select name="gedung" class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                        <option value="">
                            Semua Gedung
                        </option>

                        @foreach ($buildings as $building)
                            <option value="{{ $building->code }}" @selected(request('gedung') == $building->code)>

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

                        <a href="{{ route('admin.financial.index') }}"
                            class="flex-1 rounded-xl border border-slate-300 px-4 py-3 text-center text-sm font-bold text-slate-700 hover:bg-slate-50">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>




        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">

            <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm p-6">
                <p class="text-sm font-semibold text-slate-500">
                    Total Pendapatan
                </p>

                <h3 class="text-3xl font-black text-slate-900 mt-2">
                    Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
                </h3>
            </div>

            <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm p-6">
                <p class="text-sm font-semibold text-slate-500">
                    Total Transaksi
                </p>

                <h3 class="text-3xl font-black text-slate-900 mt-2">
                    {{ $totalTransaksi ?? 0 }}
                </h3>
            </div>

            <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm p-6">
                <p class="text-sm font-semibold text-slate-500">
                    Periode
                </p>

                <h3 class="text-base font-black text-slate-900 mt-2">
                    @if ($selectedPeriod)
                        {{ $selectedPeriod->semester_type === 'ganjil' ? 'Semester Ganjil' : 'Semester Genap' }}
                        {{ $selectedPeriod->academic_year_start }}/{{ $selectedPeriod->academic_year_end }}

                        <br>

                        <span class="text-sm text-slate-500">
                            {{ $selectedPeriod->registration_start_date?->translatedFormat('d F Y') }}
                            -
                            {{ $selectedPeriod->registration_end_date?->translatedFormat('d F Y') }}
                        </span>
                    @else
                        {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->translatedFormat('d F Y') : 'Awal' }}
                        -
                        {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->translatedFormat('d F Y') : 'Sekarang' }}
                    @endif
                </h3>
            </div>

        </div>
        <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm overflow-hidden">

            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">

                <div>
                    <h3 class="text-lg font-black text-slate-900">
                        Pendapatan per Gedung
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Distribusi pendapatan berdasarkan gedung Rusunawa.
                    </p>
                </div>

                <div class="text-right">
                    <p class="text-xs uppercase tracking-wider text-slate-400">
                        Total Pendapatan
                    </p>

                    <p class="text-lg font-black text-emerald-600">
                        Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
                    </p>
                </div>

            </div>

            <div class="p-6">

                @forelse ($incomeByBuilding as $index => $row)
                    @php
                        $income = (int) ($row->income ?? 0);

                        $percentage = ($totalPendapatan ?? 0) > 0 ? ($income / $totalPendapatan) * 100 : 0;

                        $colors = [
                            'bg-blue-500',
                            'bg-emerald-500',
                            'bg-violet-500',
                            'bg-orange-500',
                            'bg-rose-500',
                            'bg-cyan-500',
                        ];

                        $barColor = $colors[$index % count($colors)];
                    @endphp

                    <div class="{{ !$loop->last ? 'mb-6' : '' }}">

                        <div class="flex items-center justify-between mb-2">

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-sm font-black text-slate-700">

                                    {{ $index + 1 }}

                                </div>

                                <div>

                                    <p class="font-black text-slate-900">
                                        {{ $row->nama_gedung }}
                                    </p>

                                    <p class="text-xs text-slate-500">
                                        Kontribusi {{ number_format($percentage, 1) }}%
                                    </p>

                                </div>

                            </div>

                            <div class="text-right">

                                <p class="font-black text-slate-900">
                                    Rp {{ number_format($income, 0, ',', '.') }}
                                </p>

                            </div>

                        </div>

                        <div class="h-3 rounded-full bg-slate-100 overflow-hidden">

                            <div class="h-full rounded-full {{ $barColor }}" style="width: {{ $percentage }}%">
                            </div>

                        </div>

                    </div>

                @empty

                    <div class="py-10 text-center">

                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-6m3 6V7m3 10v-4m3 8H6a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2v14a2 2 0 01-2 2z" />

                            </svg>

                        </div>

                        <p class="mt-4 font-semibold text-slate-500">
                            Belum ada data pendapatan.
                        </p>

                    </div>
                @endforelse

            </div>

        </div>
        <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-100">
                <h3 class="text-lg font-black text-slate-900">
                    Detail Transaksi
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[1150px] text-sm">
                    <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            <th class="px-6 py-4 text-left font-black">Tanggal</th>
                            <th class="px-6 py-4 text-left font-black">Invoice</th>
                            <th class="px-6 py-4 text-left font-black">Order ID</th>
                            <th class="px-6 py-4 text-left font-black">Nama</th>
                            <th class="px-6 py-4 text-left font-black">Gedung</th>
                            <th class="px-6 py-4 text-left font-black">Kamar</th>
                            <th class="px-6 py-4 text-right font-black">Total</th>
                            <th class="px-6 py-4 text-center font-black">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 text-center whitespace-nowrap">
                        @forelse ($invoices as $invoice)
                            @php
                                $Reservation = $invoice->Reservation;
                                $reservation = $invoice->reservation;

                                $room = $Reservation?->room ?? ($reservation?->room ?? $invoice->room);

                                $transaction = collect($invoice->paymentTransactions ?? [])
                                    ->sortByDesc('created_at')
                                    ->first();

                                $orderId =
                                    $transaction?->order_id ??
                                    ($invoice->midtrans_order_id ??
                                        ($Reservation?->payment_order_id ?? ($invoice->invoice_number ?? '-')));

                                $transactionDate = $transaction?->created_at ?? $invoice->created_at;

                                $status = $transaction?->transaction_status ?? ($invoice->status ?? 'paid');

                                $statusClass = match ($status) {
                                    'settlement', 'paid', 'capture', 'lunas' => 'bg-emerald-50 text-emerald-700',
                                    'pending', 'unpaid' => 'bg-orange-50 text-orange-700',
                                    'expire', 'expired' => 'bg-slate-100 text-slate-600',
                                    'failed', 'deny', 'cancel', 'cancelled' => 'bg-red-50 text-red-700',
                                    default => 'bg-slate-100 text-slate-600',
                                };
                            @endphp

                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-semibold text-slate-700 whitespace-nowrap">
                                    {{ $transactionDate
                                        ? \Carbon\Carbon::parse($transactionDate)->timezone('Asia/Jakarta')->translatedFormat('d F Y • H.i') . ' WIB'
                                        : '-' }}
                                </td>

                                <td class="px-6 py-4 font-semibold text-slate-700 whitespace-nowrap">
                                    {{ $invoice->invoice_number ?? '-' }}
                                </td>

                                <td class="px-6 py-4 font-semibold text-slate-700 whitespace-nowrap">
                                    {{ $orderId }}
                                </td>

                                <td class="px-6 py-4 font-black text-slate-900">
                                    {{ $Reservation?->guest_name ?? ($invoice->user?->name ?? '-') }}
                                </td>

                                <td class="px-6 py-4 font-semibold text-slate-700">
                                    {{ $room?->floor?->building?->name ?? '-' }}
                                </td>

                                <td class="px-6 py-4 font-semibold text-slate-700 whitespace-nowrap">
                                    {{ $room?->kode_kamar ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-right font-black text-slate-900 whitespace-nowrap">
                                    Rp {{ number_format((int) ($invoice->amount ?? 0), 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <span
                                        class="inline-flex px-3 py-1 rounded-full text-xs font-black {{ $statusClass }}">
                                        {{ strtoupper(str_replace('_', ' ', $status)) }}
                                    </span>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-slate-500 font-semibold">
                                    Belum ada transaksi pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($invoices->hasPages())
                <div class="border-t border-slate-200 bg-white px-6 py-4">
                    {{ $invoices->links() }}
                </div>
            @endif

        </div>

    </div>

@endsection
