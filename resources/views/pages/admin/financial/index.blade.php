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

            <a href="{{ route('admin.financial.export', request()->query()) }}"
                class="inline-flex justify-center items-center px-5 py-3 rounded-2xl bg-blue-600 text-white text-sm font-black hover:bg-blue-700 transition">
                Export CSV
            </a>
        </div>

        <div class="bg-white rounded-[28px] border border-slate-200 shadow-sm p-5">
            <form method="GET" action="{{ route('admin.financial.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">

                <div>
                    <label class="text-xs font-black text-slate-500 uppercase">
                        Periode Registrasi
                    </label>

                    <select name="occupancy_period_id"
                        class="mt-2 w-full rounded-2xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">

                        <option value="">Semua Periode</option>

                        @foreach ($periods as $period)
                            <option value="{{ $period->id }}" @selected(request('occupancy_period_id') == $period->id)>
                                {{ $period->semester_type === 'ganjil' ? 'Ganjil' : 'Genap' }}
                                {{ $period->academic_year_start }}/{{ $period->academic_year_end }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div>
                    <label class="text-xs font-black text-slate-500 uppercase">
                        Tanggal Mulai
                    </label>

                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                        @if (request('occupancy_period_id')) disabled @endif
                        class="mt-2 w-full rounded-2xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500 disabled:bg-slate-100 disabled:text-slate-400">
                </div>

                <div>
                    <label class="text-xs font-black text-slate-500 uppercase">
                        Tanggal Akhir
                    </label>

                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                        @if (request('occupancy_period_id')) disabled @endif
                        class="mt-2 w-full rounded-2xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500 disabled:bg-slate-100 disabled:text-slate-400">
                </div>

                <div>
                    <label class="text-xs font-black text-slate-500 uppercase">
                        Gedung
                    </label>

                    <select name="gedung"
                        class="mt-2 w-full rounded-2xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">

                        <option value="">Semua Gedung</option>

                        @foreach ($buildings as $building)
                            <option value="{{ $building->code }}" @selected(request('gedung') == $building->code)>
                                {{ $building->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="h-11 px-5 rounded-2xl bg-blue-600 text-white text-sm font-black hover:bg-blue-700 transition">
                        Filter
                    </button>

                    <a href="{{ route('admin.financial.index') }}"
                        class="h-11 px-5 rounded-2xl bg-slate-100 text-slate-700 text-sm font-black hover:bg-slate-200 transition flex items-center">
                        Reset
                    </a>
                </div>

            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            <div class="bg-white rounded-[28px] border border-slate-200 shadow-sm p-6">
                <p class="text-sm font-semibold text-slate-500">
                    Total Pendapatan
                </p>

                <h3 class="text-3xl font-black text-slate-900 mt-2">
                    Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
                </h3>
            </div>

            <div class="bg-white rounded-[28px] border border-slate-200 shadow-sm p-6">
                <p class="text-sm font-semibold text-slate-500">
                    Total Transaksi
                </p>

                <h3 class="text-3xl font-black text-slate-900 mt-2">
                    {{ $totalTransaksi ?? 0 }}
                </h3>
            </div>

            <div class="bg-white rounded-[28px] border border-slate-200 shadow-sm p-6">
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

        <div class="bg-white rounded-[28px] border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-100">
                <h3 class="text-lg font-black text-slate-900">
                    Pendapatan per Gedung
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            <th class="px-6 py-4 text-left font-black">Gedung</th>
                            <th class="px-6 py-4 text-right font-black">Total Pendapatan</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($incomeByBuilding as $row)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-black text-slate-900">
                                    {{ $row->nama_gedung ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-right font-black text-slate-700">
                                    Rp {{ number_format($row->income ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-8 text-center text-slate-500">
                                    Belum ada data pendapatan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        <div class="bg-white rounded-[28px] border border-slate-200 shadow-sm overflow-hidden">

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

                    <tbody class="divide-y divide-slate-100">
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
