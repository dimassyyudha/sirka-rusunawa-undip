@extends('layouts.app')

@section('title', 'Pembayaran Registrasi Ulang')
@section('page_title', 'Pembayaran Registrasi Ulang')

@section('content')

    @php
        $paymentStatus = $invoice->status ?? 'unpaid';
    @endphp

    <div class="max-w-4xl mx-auto space-y-6">

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h1 class="text-2xl font-black text-slate-900">
                Pembayaran Registrasi Ulang
            </h1>

            <p class="mt-2 text-slate-500">
                Selesaikan pembayaran tagihan registrasi ulang hunian Rusunawa.
            </p>

            <div class="mt-6 space-y-4 rounded-2xl border border-slate-200 bg-slate-50 p-5">

                <div class="flex justify-between gap-4">
                    <span class="text-sm text-slate-500">Nomor Invoice</span>
                    <span class="text-right text-sm font-black text-slate-900">
                        {{ $invoice->invoice_number }}
                    </span>
                </div>

                <div class="flex justify-between gap-4">
                    <span class="text-sm text-slate-500">Nama</span>
                    <span class="text-right text-sm font-black text-slate-900">
                        {{ $invoice->user->name ?? auth()->user()->name }}
                    </span>
                </div>

                <div class="flex justify-between gap-4">
                    <span class="text-sm text-slate-500">Kamar</span>
                    <span class="text-right text-sm font-black text-slate-900">
                        {{ $invoice->room->kode_kamar ?? '-' }}
                    </span>
                </div>

                <div class="flex justify-between gap-4">
                    <span class="text-sm text-slate-500">Gedung</span>
                    <span class="text-right text-sm font-black text-slate-900">
                        {{ $invoice->room->floor->building->name ?? '-' }}
                    </span>
                </div>

                <div class="flex justify-between gap-4">
                    <span class="text-sm text-slate-500">Status Pembayaran</span>
                    <span class="text-right text-sm font-black uppercase text-orange-600">
                        {{ $paymentStatus }}
                    </span>
                </div>

                <div class="flex justify-between gap-4 border-t border-slate-200 pt-4">
                    <span class="text-sm text-slate-500">Total Pembayaran</span>
                    <span class="text-right text-lg font-black text-orange-600">
                        Rp {{ number_format($invoice->amount ?? 0, 0, ',', '.') }}
                    </span>
                </div>

            </div>

            <button id="pay-button" type="button"
                class="mt-6 w-full rounded-2xl bg-orange-500 px-5 py-4 font-black text-white hover:bg-orange-600 disabled:cursor-not-allowed disabled:opacity-50">
                Bayar Sekarang
            </button>
        </div>

    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $midtransClientKey }}"></script>

    <script>
        const payButton = document.getElementById('pay-button');

        payButton.addEventListener('click', function() {
            if (payButton.disabled) return;

            payButton.disabled = true;
            payButton.textContent = 'Memproses Pembayaran...';

            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    window.location.href = "{{ route('mahasiswa.invoices.finish', $invoice) }}";
                },

                onPending: function(result) {
                    payButton.disabled = false;
                    payButton.textContent = 'Lanjutkan Pembayaran';
                    console.log('Pembayaran pending:', result);
                },

                onError: function(result) {
                    payButton.disabled = false;
                    payButton.textContent = 'Coba Bayar Lagi';
                    alert('Pembayaran gagal. Silakan coba lagi.');
                    console.log('Payment error:', result);
                },

                onClose: function() {
                    payButton.disabled = false;
                    payButton.textContent = 'Lanjutkan Pembayaran';
                }
            });
        });
    </script>

@endsection
