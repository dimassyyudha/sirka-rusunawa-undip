@extends('landing.landing')

@section('title', 'Cek Transaksi')

@section('content')
    <section class="min-h-screen bg-slate-50 py-16">
        <div class="mx-auto max-w-2xl px-4">

            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="text-center">
                    <h1 class="text-3xl font-black text-slate-900">
                        Cek Transaksi
                    </h1>

                    <p class="mt-3 text-slate-500">
                        Masukkan nomor invoice untuk melihat status transaksi dan melanjutkan pembayaran.
                    </p>
                </div>

                @if (session('error'))
                    <div
                        class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('invoice.check') }}" method="POST" class="mt-8">
                    @csrf

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Nomor Invoice
                        </label>

                        <input type="text" name="invoice_number" value="{{ old('invoice_number') }}"
                            placeholder="Contoh: INV-20260523-ABCDE" required
                            class="w-full rounded-2xl border border-slate-300 px-5 py-4 uppercase focus:border-orange-500 focus:outline-none focus:ring-4 focus:ring-orange-100">
                    </div>

                    <x-button.button-menu type="submit" variant="primary" class="mt-6 w-full">
                        Cek Transaksi
                    </x-button.button-menu>
                </form>
            </div>

        </div>
    </section>
@endsection
