@extends('layouts.app')

@section('title', 'Registrasi Ulang Hunian')
@section('page_title', 'Registrasi Ulang Hunian')

@section('content')

    <div class="max-w-6xl mx-auto space-y-6">

        <div class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">

            <h1 class="text-2xl font-black text-slate-900">
                Registrasi Ulang Hunian
            </h1>

            <p class="mt-2 text-slate-500">
                Pilih status hunian untuk periode semester berikutnya.
            </p>

            @if (!$period)
                <div class="mt-6 rounded-2xl bg-amber-50 border border-amber-200 px-5 py-4 text-amber-700">
                    Periode registrasi ulang hunian belum dibuka oleh admin.
                </div>
            @elseif (!$profile)
                <div class="mt-6 rounded-2xl bg-red-50 border border-red-200 px-5 py-4 text-red-700">
                    Kamu belum memiliki kamar aktif.
                </div>
            @else
                <div class="mt-6 rounded-2xl bg-indigo-50 border border-indigo-100 px-5 py-4">
                    <p class="text-sm text-indigo-500 font-bold">
                        Periode Aktif
                    </p>

                    <h2 class="mt-1 text-xl font-black text-indigo-900">
                        {{ $period->name }}
                    </h2>

                    <p class="mt-1 text-sm text-indigo-700">
                        {{ $period->registration_start_date?->format('d M Y') }}
                        -
                        {{ $period->registration_end_date?->format('d M Y') }}
                    </p>
                </div>

                <div class="mt-6 rounded-2xl border border-slate-200 p-5">
                    <p class="text-sm text-slate-500">
                        Kamar Aktif Saat Ini
                    </p>

                    <h2 class="mt-1 text-3xl font-black text-slate-900">
                        {{ $profile->room->kode_kamar ?? '-' }}
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        {{ $profile->room->floor->building->name ?? '-' }}
                        •
                        Lantai {{ $profile->room->floor->floor_number ?? '-' }}
                    </p>
                </div>
            @endif

        </div>

        @if ($period && $profile)

            @if ($reservation)

                @php
                    $invoice = \App\Models\Invoice::where('reservation_id', $reservation->id)
                        ->where('user_id', auth()->id())
                        ->latest()
                        ->first();
                @endphp

                <div class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">

                    <h2 class="text-xl font-black text-slate-900">
                        Pengajuan Kamu
                    </h2>

                    <div class="mt-4 grid md:grid-cols-4 gap-4">

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 font-bold uppercase">
                                Jenis
                            </p>

                            <p class="mt-1 font-black text-slate-900">
                                @if ($reservation->reservation_type === 'extension')
                                    Perpanjang Sewa
                                @elseif ($reservation->reservation_type === 'transfer')
                                    Pindah Kamar
                                @else
                                    Akhiri Kontrak
                                @endif
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 font-bold uppercase">
                                Status
                            </p>

                            <p
                                class="mt-1 font-black
                            @if ($reservation->status === 'approved') text-emerald-600
                            @elseif ($reservation->status === 'rejected') text-red-500
                            @else text-orange-500 @endif">
                                {{ strtoupper($reservation->status) }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 font-bold uppercase">
                                Kamar Tujuan
                            </p>

                            <p class="mt-1 font-black text-slate-900">
                                {{ $reservation->room->kode_kamar ?? '-' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 font-bold uppercase">
                                Tagihan
                            </p>

                            <p class="mt-1 font-black text-orange-500">
                                Rp {{ number_format($invoice->amount ?? 0, 0, ',', '.') }}
                            </p>
                        </div>

                    </div>

                    @if ($reservation->status === 'pending')
                        <div
                            class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-amber-700 font-bold">
                            Pengajuan kamu sedang menunggu persetujuan admin.
                        </div>
                    @endif

                    @if ($reservation->status === 'approved' && $invoice && in_array($invoice->status, ['pending', 'unpaid']))
                        <div
                            class="mt-6 rounded-2xl border border-orange-200 bg-orange-50 px-5 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <p class="font-black text-orange-700">
                                    Pengajuan disetujui. Silakan lakukan pembayaran.
                                </p>

                                <p class="mt-1 text-sm text-orange-600">
                                    Tagihan aktif sebesar Rp {{ number_format($invoice->amount, 0, ',', '.') }}.
                                </p>
                            </div>

                            <form action="{{ route('mahasiswa.invoices.pay', $invoice) }}" method="POST">
                                @csrf

                                <button type="submit"
                                    class="inline-flex justify-center px-5 py-3 rounded-2xl bg-orange-500 hover:bg-orange-600 text-white font-black transition">
                                    Bayar Sekarang
                                </button>
                            </form>
                        </div>
                    @endif

                    @if ($reservation->status === 'approved' && $invoice && in_array($invoice->status, ['paid', 'settlement']))
                        <div
                            class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-700 font-bold">
                            Pengajuan disetujui dan pembayaran sudah lunas.
                        </div>
                    @endif

                    @if ($reservation->status === 'approved' && !$invoice && $reservation->reservation_type !== 'checkout')
                        <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-700 font-bold">
                            Pengajuan sudah disetujui, tetapi tagihan belum dibuat.
                        </div>
                    @endif

                    @if ($reservation->status === 'rejected')
                        <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-700 font-bold">
                            Pengajuan kamu ditolak. Kamu dapat memilih ulang salah satu opsi daftar ulang di bawah ini.
                        </div>
                    @endif

                </div>

            @endif

            @if (!$reservation || $reservation->status === 'rejected')
                <div class="grid md:grid-cols-3 gap-5">

                    <a href="{{ route('mahasiswa.registrasi-ulang.perpanjang') }}"
                        class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6 hover:border-orange-300 hover:shadow-md transition">
                        <h2 class="text-xl font-black text-slate-900">
                            Daftar Ulang Perpanjang Sewa
                        </h2>

                        <p class="mt-2 text-sm text-slate-500">
                            Tetap tinggal di kamar saat ini untuk semester berikutnya.
                        </p>

                        <div class="mt-5 text-orange-500 font-black">
                            Pilih Perpanjang →
                        </div>
                    </a>

                    <a href="{{ route('mahasiswa.registrasi-ulang.pindah-kamar') }}"
                        class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6 hover:border-orange-300 hover:shadow-md transition">
                        <h2 class="text-xl font-black text-slate-900">
                            Daftar Ulang Pindah Kamar
                        </h2>

                        <p class="mt-2 text-sm text-slate-500">
                            Pilih kamar baru yang tersedia untuk periode berikutnya.
                        </p>

                        <div class="mt-5 text-orange-500 font-black">
                            Pilih Pindah →
                        </div>
                    </a>

                    <a href="{{ route('mahasiswa.registrasi-ulang.akhiri-kontrak') }}"
                        class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6 hover:border-red-300 hover:shadow-md transition">
                        <h2 class="text-xl font-black text-slate-900">
                            Daftar Ulang Akhiri Kontrak
                        </h2>

                        <p class="mt-2 text-sm text-slate-500">
                            Mengakhiri masa hunian dan keluar dari Rusunawa.
                        </p>

                        <div class="mt-5 text-red-500 font-black">
                            Pilih Akhiri →
                        </div>
                    </a>

                </div>
            @endif

        @endif

    </div>

@endsection
