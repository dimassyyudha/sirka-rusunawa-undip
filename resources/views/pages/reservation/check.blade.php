@extends('landing.landing')

@section('title', 'Cek Status Reservation')

@section('content')

    <section class="min-h-screen bg-slate-50 py-20">

        <div class="mx-auto max-w-3xl px-4">

            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                {{-- Header --}}
                <div class="border-b border-slate-100 px-8 py-10 text-center">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-orange-50 text-orange-500">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                            stroke="currentColor" class="h-8 w-8">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-4.35-4.35m1.85-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />

                        </svg>

                    </div>

                    <h1 class="mt-5 text-3xl font-black text-slate-900">
                        Cek Status Reservation
                    </h1>

                    <p class="mx-auto mt-3 max-w-xl text-slate-500">
                        Masukkan nomor invoice atau kode reservation untuk melihat
                        status reservasi kamar Rusunawa Universitas Diponegoro.
                    </p>

                </div>

                {{-- Form --}}
                <div class="p-8">

                    <form action="{{ route('Reservation.check.store') }}" method="POST">

                        @csrf

                        <div>

                            <label class="mb-3 block text-sm font-bold text-slate-800">

                                Nomor Invoice / Kode Reservation

                            </label>

                            <div class="relative">

                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-5">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.8" stroke="currentColor" class="h-5 w-5 text-slate-400">

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m21 21-4.35-4.35m1.85-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />

                                    </svg>

                                </div>

                                <input type="text" name="keyword" value="{{ old('keyword') }}"
                                    placeholder="Contoh: INV-20260601205319-7THZ atau AB12CD" required
                                    class="w-full rounded-2xl border border-slate-300 bg-white py-4 pl-12 pr-5 text-slate-900 placeholder:text-slate-400 focus:border-orange-500 focus:outline-none focus:ring-4 focus:ring-orange-100">

                            </div>

                            @error('keyword')
                                <p class="mt-2 text-sm font-medium text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        <x-button.button-menu type="submit" variant="primary" class="mt-6 w-full">

                            Cek Status Reservation

                        </x-button.button-menu>

                    </form>

                </div>

                {{-- Info --}}
                <div class="border-t border-slate-100 bg-slate-50 px-8 py-6">

                    <div class="flex items-start gap-3">

                        <div class="mt-0.5 flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 text-blue-600">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="h-4 w-4">

                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m0 3.75h.008v.008H12v-.008ZM21 12a9 9 0 11-18 0 9 9 0 0118 0Z" />

                            </svg>

                        </div>

                        <div>

                            <h3 class="font-bold text-slate-800">
                                Informasi
                            </h3>

                            <p class="mt-1 text-sm leading-relaxed text-slate-500">

                                Nomor invoice dapat ditemukan pada halaman pembayaran
                                maupun bukti transaksi. Kode reservation tersedia
                                setelah reservasi berhasil diverifikasi oleh admin
                                Rusunawa.

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection
