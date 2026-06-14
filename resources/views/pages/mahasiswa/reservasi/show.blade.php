@extends('layouts.app')

@section('title', 'Detail Reservasi')
@section('page_title', 'Detail Reservasi')

@section('content')

    <div class="max-w-5xl mx-auto space-y-6">

        <div class="bg-white rounded-[30px] border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-100">
                <h1 class="text-2xl font-black text-slate-900">
                    Detail Reservasi
                </h1>

                <p class="mt-2 text-slate-500 text-sm">
                    Informasi lengkap reservasi kamar Rusunawa.
                </p>
            </div>

            <div class="p-6 grid md:grid-cols-2 gap-5">

                <div class="rounded-2xl border border-slate-200 p-5">
                    <p class="text-sm text-slate-500">
                        Jenis Reservasi
                    </p>

                    <h2 class="mt-2 text-xl font-black text-slate-900 capitalize">
                        {{ $reservation->reservation_type ?? '-' }}
                    </h2>
                </div>

                <div class="rounded-2xl border border-slate-200 p-5">
                    <p class="text-sm text-slate-500">
                        Status Reservasi
                    </p>

                    <h2 class="mt-2 text-xl font-black text-orange-600 uppercase">
                        {{ $reservation->status ?? '-' }}
                    </h2>
                </div>

                <div class="rounded-2xl border border-slate-200 p-5">
                    <p class="text-sm text-slate-500">
                        Kamar
                    </p>

                    <h2 class="mt-2 text-xl font-black text-slate-900">
                        {{ $reservation->room?->kode_kamar ?? '-' }}
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        {{ $reservation->room?->floor?->building?->name ?? '-' }}
                        •
                        Lantai {{ $reservation->room?->floor?->floor_number ?? '-' }}
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-200 p-5">
                    <p class="text-sm text-slate-500">
                        Tanggal Reservasi
                    </p>

                    <h2 class="mt-2 text-lg font-black text-slate-900">
                        {{ $reservation->created_at?->timezone('Asia/Jakarta')->translatedFormat('d F Y • H:i') }} WIB
                    </h2>
                </div>

                <div class="rounded-2xl border border-slate-200 p-5">
                    <p class="text-sm text-slate-500">
                        Masa Hunian
                    </p>

                    <h2 class="mt-2 text-lg font-black text-slate-900">
                        {{ \Carbon\Carbon::parse($reservation->start_date)->translatedFormat('d M Y') }}
                        -
                        {{ \Carbon\Carbon::parse($reservation->end_date)->translatedFormat('d M Y') }}
                    </h2>
                </div>

                <div class="rounded-2xl border border-slate-200 p-5">
                    <p class="text-sm text-slate-500">
                        Total Pembayaran
                    </p>

                    <h2 class="mt-2 text-2xl font-black text-orange-600">
                        Rp {{ number_format($reservation->total_price ?? 0, 0, ',', '.') }}
                    </h2>
                </div>

            </div>
        </div>

        <div class="bg-white rounded-[30px] border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-100">
                <h3 class="font-black text-slate-900">
                    Informasi Pembayaran
                </h3>
            </div>

            <div class="p-6">

                @if ($latestTransaction)
                    <div class="grid md:grid-cols-2 gap-5">

                        <div class="rounded-2xl border border-slate-200 p-5">
                            <p class="text-sm text-slate-500">
                                Order ID
                            </p>

                            <h2 class="mt-2 text-lg font-black text-slate-900 break-all">
                                {{ $latestTransaction->order_id ?? '-' }}
                            </h2>
                        </div>

                        <div class="rounded-2xl border border-slate-200 p-5">
                            <p class="text-sm text-slate-500">
                                Status Pembayaran
                            </p>

                            <h2 class="mt-2 text-lg font-black text-emerald-600 uppercase">
                                {{ $latestTransaction->transaction_status ?? '-' }}
                            </h2>
                        </div>

                        <div class="rounded-2xl border border-slate-200 p-5">
                            <p class="text-sm text-slate-500">
                                Metode Pembayaran
                            </p>

                            <h2 class="mt-2 text-lg font-black text-slate-900 uppercase">
                                {{ $latestTransaction->payment_type ?? '-' }}
                            </h2>
                        </div>

                        <div class="rounded-2xl border border-slate-200 p-5">
                            <p class="text-sm text-slate-500">
                                Waktu Pembayaran
                            </p>

                            <h2 class="mt-2 text-lg font-black text-slate-900">
                                {{ $latestTransaction->created_at?->timezone('Asia/Jakarta')->translatedFormat('d F Y • H:i') }}
                                WIB
                            </h2>
                        </div>

                    </div>
                @else
                    <div class="text-center py-10">
                        <h4 class="text-lg font-black text-slate-900">
                            Belum Ada Pembayaran
                        </h4>

                        <p class="mt-2 text-slate-500">
                            Data transaksi pembayaran belum tersedia.
                        </p>
                    </div>
                @endif

            </div>
        </div>

    </div>

@endsection
