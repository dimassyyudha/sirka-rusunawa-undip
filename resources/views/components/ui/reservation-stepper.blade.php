@props([
    'step' => 1,
    'status' => 'pending',
])

@php
    $step = (int) $step;

    $isExpired = in_array($status, ['expired', 'cancelled', 'rejected']);
    $isPaid = in_array($status, ['paid', 'approved', 'active']);
    $isActive = in_array($status, ['active', 'completed', 'checked_out']);

    $steps = [
        1 => [
            'title' => 'Isi Data',
            'desc' => 'Data reservasi mahasiswa',
        ],

        2 => [
            'title' => 'Pembayaran',
            'desc' => $isExpired ? 'Pembayaran kedaluwarsa' : ($isPaid ? 'Pembayaran berhasil' : 'Menunggu pembayaran'),
        ],

        3 => [
            'title' => 'Verifikasi Admin',
            'desc' => $isPaid ? 'Menunggu verifikasi admin' : 'Belum diproses',
        ],

        4 => [
            'title' => 'Selesai',
            'desc' => $isActive ? 'Kamar aktif' : 'Menunggu proses selesai',
        ],
    ];
@endphp

<div {{ $attributes->merge([
    'class' => 'rounded-3xl border border-transparent bg-transparent p-6',
]) }}>



        <h2 class="text-lg font-black text-black text-center">
            PROGRESS TRANSAKSI
        </h2>

        <ol class="mt-8 flex items-start justify-between">

            @foreach ($steps as $number => $item)
                @php

                    $circleClass =
                        $isExpired && $number === 2
                            ? 'bg-red-500 border-red-500 text-white'
                            : ($number <= $step
                                ? 'bg-orange-500 border-orange-500 text-white'
                                : 'bg-white border-slate-300 text-slate-400');

                    $textClass =
                        $isExpired && $number === 2
                            ? 'text-red-600'
                            : ($number <= $step
                                ? 'text-orange-600'
                                : 'text-slate-500');

                    $lineClass =
                        $isExpired && $number < 2 ? 'bg-red-500' : ($number < $step ? 'bg-orange-500' : 'bg-slate-200');

                @endphp

                <li class="relative flex-1">

                    @if (!$loop->last)
                        <div class="absolute top-5 left-1/2 w-full h-0.5 {{ $lineClass }}">
                        </div>
                    @endif

                    <div class="relative z-10 flex flex-col items-center text-center">

                        <span
                            class="flex h-10 w-10 md:h-12 md:w-12 items-center justify-center rounded-full border-2 text-sm md:text-base font-black {{ $circleClass }}">

                            {{ $number }}

                        </span>

                        <div class="mt-3">

                            <p class="text-xs md:text-sm font-black {{ $textClass }}">

                                {{ $item['title'] }}

                            </p>

                            <p class="hidden md:block mt-1 text-xs font-normal text-slate-500">

                                {{ $item['desc'] }}

                            </p>

                        </div>

                    </div>

                </li>
            @endforeach

        </ol>

    </div>
