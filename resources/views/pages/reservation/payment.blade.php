@extends('landing.landing')

@section('title', 'Pembayaran Reservation')

@section('content')
    @php
        $expiredAt = $transaction?->expired_at
            ? \Carbon\Carbon::parse($transaction->expired_at)->timestamp * 1000
            : null;

        $paymentStatus = $transaction?->transaction_status ?? 'pending';
    @endphp

    <section class="min-h-screen bg-slate-50 py-10">
        <div class="mx-auto max-w-4xl px-4 space-y-6">

            {{-- <x-ui.Reservation-stepper step="2" :status="$Reservation->status" class="bg-white shadow-sm" /> --}}
            {{-- <x-ui.reservation-stepper step="1" :status="$reservation->status" /> --}}

            <x-ui.Reservation-stepper step="2" :status="$Reservation->status" class="bg-white shadow-sm" />

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h1 class="text-2xl font-black text-slate-900">
                    Pembayaran Reservation
                </h1>

                <p class="mt-2 text-slate-500">
                    Selesaikan pembayaran sebelum batas waktu berakhir.
                </p>

                <div class="mt-6 rounded-2xl border border-orange-200 bg-orange-50 p-6 text-center">
                    <p class="text-sm font-bold text-orange-700">
                        Batas Waktu Pembayaran
                    </p>

                    <div class="mt-5 flex items-center justify-center w-full gap-1.5">
                        <div
                            class="rounded-xl border border-orange-500 py-1.5 min-w-[78px] flex items-center justify-center flex-col aspect-square px-1.5 bg-white">
                            <h3 id="countdown-hours" class="font-semibold text-2xl text-orange-600 text-center">00</h3>
                            <p class="text-xs text-orange-600 text-center w-full">Jam</p>
                        </div>

                        <h3 class="font-semibold text-2xl text-gray-900">:</h3>

                        <div
                            class="rounded-xl border border-orange-500 py-1.5 min-w-[78px] flex items-center justify-center flex-col aspect-square px-1.5 bg-white">
                            <h3 id="countdown-minutes" class="font-semibold text-2xl text-orange-600 text-center">00</h3>
                            <p class="text-xs text-orange-600 text-center w-full">Menit</p>
                        </div>

                        <h3 class="font-semibold text-2xl text-gray-900">:</h3>

                        <div
                            class="rounded-xl border border-orange-500 py-1.5 min-w-[78px] flex items-center justify-center flex-col aspect-square px-1.5 bg-white">
                            <h3 id="countdown-seconds" class="font-semibold text-2xl text-orange-600 text-center">00</h3>
                            <p class="text-xs text-orange-600 text-center w-full">Detik</p>
                        </div>
                    </div>

                    <p id="countdown-message" class="mt-4 text-xs font-semibold text-orange-700">
                        Jika waktu habis, Reservation akan kedaluwarsa.
                    </p>
                </div>

                <div class="mt-6 space-y-4 rounded-2xl border border-slate-200 bg-slate-50 p-5">
                    <div class="flex justify-between gap-4">
                        <span class="text-sm text-slate-500">
                            Kode Reservation
                        </span>

                        <span class="text-right text-sm font-black text-slate-900">

                            @if ($Reservation->status === 'active')
                                {{ $Reservation->Reservation_code }}
                            @else
                                Menunggu Verifikasi Admin
                            @endif

                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-sm text-slate-500">Nomor Invoice</span>
                        <span class="text-right text-sm font-black text-slate-900">
                            {{ $invoice?->invoice_number ?? '-' }}
                        </span>
                    </div>

                    {{-- <div class="flex justify-between gap-4">
                        <span class="text-sm text-slate-500">Order ID</span>
                        <span class="text-right text-sm font-black text-slate-900">
                            {{ $transaction->order_id }}
                        </span>
                    </div> --}}

                    <div class="flex justify-between gap-4">
                        <span class="text-sm text-slate-500">Nama</span>
                        <span class="text-right text-sm font-black text-slate-900">
                            {{ $Reservation->guest_name }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-sm text-slate-500">Kamar</span>
                        <span class="text-right text-sm font-black text-slate-900">
                            {{ $Reservation->room?->kode_kamar ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-sm text-slate-500">Gedung</span>
                        <span class="text-right text-sm font-black text-slate-900">
                            {{ $Reservation->room?->floor?->building?->name ?? '-' }}
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
                            Rp
                            {{ number_format($transaction->gross_amount ?? ($invoice?->amount ?? $Reservation->total_price), 0, ',', '.') }}
                        </span>

                    </div>
                </div>

                <button id="pay-button" type="button"
                    class="mt-6 w-full rounded-2xl bg-orange-500 px-5 py-4 font-black text-white hover:bg-orange-600 disabled:cursor-not-allowed disabled:opacity-50">
                    Bayar Sekarang
                </button>
            </div>
        </div>
    </section>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $midtransClientKey }}"></script>

    <script>
        const expiredAt = Number(@json($expiredAt));
        const hoursEl = document.getElementById('countdown-hours');
        const minutesEl = document.getElementById('countdown-minutes');
        const secondsEl = document.getElementById('countdown-seconds');
        const messageEl = document.getElementById('countdown-message');
        const payButton = document.getElementById('pay-button');

        function setExpiredState() {
            hoursEl.textContent = '00';
            minutesEl.textContent = '00';
            secondsEl.textContent = '00';
            messageEl.textContent = 'Waktu pembayaran habis. Reservation telah kedaluwarsa.';
            payButton.disabled = true;
            payButton.textContent = 'Reservation Kedaluwarsa';
        }

        function updateCountdown() {
            if (!expiredAt) {
                setExpiredState();
                clearInterval(timer);
                return;
            }

            const now = new Date().getTime();
            const distance = expiredAt - now;

            if (distance <= 0) {
                setExpiredState();
                clearInterval(timer);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
                return;
            }

            const hours = Math.floor(distance / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            hoursEl.textContent = String(hours).padStart(2, '0');
            minutesEl.textContent = String(minutes).padStart(2, '0');
            secondsEl.textContent = String(seconds).padStart(2, '0');
        }

        const timer = setInterval(updateCountdown, 1000);
        updateCountdown();

        payButton.addEventListener('click', function() {
            if (payButton.disabled) return;

            payButton.disabled = true;
            payButton.textContent = 'Memproses Pembayaran...';

            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    window.location.href =
                        "{{ route('Reservation.payment.success.order') }}?order_id={{ $transaction->order_id }}";
                },


                onPending: function(result) {
                    payButton.disabled = false;
                    payButton.textContent = 'Lanjutkan Pembayaran';
                    console.log('Pembayaran masih pending:', result);
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
                    console.log('Popup pembayaran ditutup.');
                }
            });
        });
    </script>
@endsection
