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

    <ol class="mt-6 grid grid-cols-1 gap-6 text-sm font-bold md:grid-cols-4 md:gap-0">

        @foreach ($steps as $number => $item)
            @php

                $circleClass =
                    $isExpired && $number === 2
                        ? 'bg-red-500 border-red-500 text-white'
                        : ($number <= $step
                            ? 'bg-orange-500 border-orange-500 text-white'
                            : 'bg-white border-slate-200 text-slate-400');

                $textClass =
                    $isExpired && $number === 2
                        ? 'text-red-600'
                        : ($number <= $step
                            ? 'text-orange-600'
                            : 'text-slate-500');

                $lineClass =
                    $isExpired && $number < 2
                        ? 'md:after:bg-red-500'
                        : ($number < $step
                            ? 'md:after:bg-orange-500'
                            : 'md:after:bg-slate-200');

            @endphp

            <li
                class="relative flex text-center md:block
                {{ $number < count($steps)
                    ? "md:after:content-[''] md:after:absolute md:after:top-5 md:after:left-1/2 md:after:w-full md:after:h-0.5 {$lineClass}"
                    : '' }}">

                <div class="relative z-10 flex items-center gap-3 md:block">

                    <span
                        class="mx-auto mb-2 flex h-10 w-10 items-center justify-center rounded-full border-2 {{ $circleClass }}">

                        {{ $number }}

                    </span>

                    <div>

                        <p class="{{ $textClass }}">
                            {{ $item['title'] }}
                        </p>

                        <p class="mt-1 text-xs font-normal text-slate-500">
                            {{ $item['desc'] }}
                        </p>

                    </div>

                </div>

            </li>
        @endforeach

    </ol>

</div>
