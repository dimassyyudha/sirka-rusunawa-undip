{{-- PRICE CARD --}}
<div
    class="bg-white rounded-3xl border border-slate-200 shadow-sm
           p-5 lg:p-6
           lg:sticky lg:top-24
           space-y-5">

    {{-- HEADER --}}
    <div class="flex items-start justify-between">

        <div>

            <div class="text-xs uppercase tracking-wider text-slate-500 font-bold">
                Harga Per Bulan
            </div>

            <div class="mt-2">

                <div class="text-3xl lg:text-4xl font-black text-orange-600">
                    Rp {{ number_format($harga, 0, ',', '.') }}
                </div>

                <div class="text-sm text-slate-500 mt-1">
                    Harga kamar per bulan
                </div>

            </div>

        </div>

    </div>

    {{-- SIMULASI --}}
    <div class="rounded-2xl border border-slate-200
               bg-slate-50 p-4">

        <h4 class="font-bold text-slate-900 mb-4">

            Rincian Biaya Hunian

        </h4>

        <div class="space-y-3">

            <div class="flex justify-between items-center">

                <span class="text-slate-600">
                    Hunian 1 Orang
                </span>

                <span class="font-black text-red-600">
                    Rp {{ number_format($harga, 0, ',', '.') }}
                </span>

            </div>

            @if ($capacity >= 2)
                <div class="flex justify-between items-center">

                    <span class="text-slate-600">
                        Hunian 2 Orang
                    </span>

                    <span class="font-black text-emerald-600">
                        Rp {{ number_format($harga / 2, 0, ',', '.') }}/orang
                    </span>

                </div>
            @endif

            @if ($capacity >= 3)
                <div class="flex justify-between items-center">

                    <span class="text-slate-600">
                        Hunian 3 Orang
                    </span>

                    <span class="font-black text-blue-600">
                        Rp {{ number_format($harga / 3, 0, ',', '.') }}/orang
                    </span>

                </div>
            @endif

        </div>

        <div class="mt-4 border-t border-slate-200 pt-3
                   text-xs text-slate-500">

            Biaya per penghuni menyesuaikan jumlah penghuni aktif
            dalam satu kamar.

        </div>

    </div>

    {{-- INFORMASI --}}
    <div class="space-y-3">

        <div class="flex items-start gap-3">

            <svg id='Checkmark_24' width='24' height='24' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'
                xmlns:xlink='http://www.w3.org/1999/xlink'>
                <rect width='24' height='24' stroke='none' fill='#000000' opacity='0' />


                <g transform="matrix(0.52 0 0 0.52 12 12)">
                    <path
                        style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(67,160,71); fill-rule: nonzero; opacity: 1;"
                        transform=" translate(-24, -26.7)"
                        d="M 40.6 12.1 L 17 35.7 L 7.4 26.1 L 4.6 29 L 17 41.3 L 43.4 14.9 z" stroke-linecap="round" />
                </g>
            </svg>

            <span class="text-sm text-slate-600">
                Pembayaran dilakukan melalui sistem resmi Rusunawa UNDIP.
            </span>

        </div>

        <div class="flex items-start gap-3">

            <svg id='Business_Contract_Approve_24' width='24' height='24' viewBox='0 0 24 24'
                xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                <rect width='24' height='24' stroke='none' fill='#000000' opacity='0' />


                <g transform="matrix(0.83 0 0 0.83 12 12)">
                    <g style="">
                        <g transform="matrix(1 0 0 1 0 1)">
                            <path
                                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(227,227,227); fill-rule: nonzero; opacity: 1;"
                                transform=" translate(-12, -13)"
                                d="M 18 2.499 L 6 2.499 C 5.72386 2.499 5.5 2.72286 5.5 2.999 L 5.5 23 C 5.5 23.2761 5.72386 23.5 6 23.5 L 18 23.5 C 18.2761 23.5 18.5 23.2761 18.5 23 L 18.5 2.999 C 18.5 2.72286 18.2761 2.499 18 2.499 Z"
                                stroke-linecap="round" />
                        </g>
                        <g transform="matrix(1 0 0 1 -0.11 -3.06)">
                            <path
                                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;"
                                transform=" translate(-11.89, -8.94)"
                                d="M 18.28 2.6 C 18.1993 2.53847 18.1014 2.50353 18 2.5 L 6 2.5 C 5.86739 2.5 5.74021 2.55268 5.64645 2.64645 C 5.55268 2.74021 5.5 2.86739 5.5 3 L 5.5 15.376 L 18.28 2.6 Z"
                                stroke-linecap="round" />
                        </g>
                        <g transform="matrix(1 0 0 1 0 1)">
                            <path
                                style="stroke: rgb(25,25,25); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;"
                                transform=" translate(-12, -13)"
                                d="M 10.25 2.5 L 6 2.5 C 5.86739 2.5 5.74021 2.55268 5.64645 2.64645 C 5.55268 2.74021 5.5 2.86739 5.5 3 L 5.5 23 C 5.5 23.1326 5.55268 23.2598 5.64645 23.3536 C 5.74021 23.4473 5.86739 23.5 6 23.5 L 18 23.5 C 18.1326 23.5 18.2598 23.4473 18.3536 23.3536 C 18.4473 23.2598 18.5 23.1326 18.5 23 L 18.5 9.983"
                                stroke-linecap="round" />
                        </g>
                        <g transform="matrix(1 0 0 1 7.41 5)">
                            <path
                                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255,221,161); fill-rule: nonzero; opacity: 1;"
                                transform=" translate(-19.41, -17)"
                                d="M 23.5 22 L 22.5 20.066 L 22.5 15.5 C 22.542 13.722 20.419 12.137 18.5 10.5 L 18.5 15.949 L 17.468 14.894 C 17.3543 14.7756 17.2182 14.6809 17.0677 14.6153 C 16.9172 14.5497 16.7552 14.5145 16.591 14.5117 C 16.4268 14.509 16.2637 14.5388 16.1111 14.5993 C 15.9585 14.6599 15.8193 14.75 15.7017 14.8645 C 15.5841 14.9791 15.4902 15.1158 15.4256 15.2667 C 15.361 15.4177 15.3269 15.5799 15.3253 15.7441 C 15.3236 15.9083 15.3545 16.0712 15.4161 16.2234 C 15.4776 16.3756 15.5687 16.5141 15.684 16.631 L 18.5 19.5 L 18.5 21 C 18.6531 21.8946 18.9939 22.7466 19.5 23.5"
                                stroke-linecap="round" />
                        </g>
                        <g transform="matrix(1 0 0 1 7.41 5)">
                            <path
                                style="stroke: rgb(25,25,25); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;"
                                transform=" translate(-19.41, -17)"
                                d="M 23.5 22 L 22.5 20.066 L 22.5 15.5 C 22.542 13.722 20.419 12.137 18.5 10.5 L 18.5 15.949 L 17.468 14.894 C 17.3543 14.7756 17.2182 14.6809 17.0677 14.6153 C 16.9172 14.5497 16.7552 14.5145 16.591 14.5117 C 16.4268 14.509 16.2637 14.5388 16.1111 14.5993 C 15.9585 14.6599 15.8193 14.75 15.7017 14.8645 C 15.5841 14.9791 15.4902 15.1158 15.4256 15.2667 C 15.361 15.4177 15.3269 15.5799 15.3253 15.7441 C 15.3236 15.9083 15.3545 16.0712 15.4161 16.2234 C 15.4776 16.3756 15.5687 16.5141 15.684 16.631 L 18.5 19.5 L 18.5 21 C 18.6531 21.8946 18.9939 22.7466 19.5 23.5"
                                stroke-linecap="round" />
                        </g>
                        <g transform="matrix(1 0 0 1 7.26 4.72)">
                            <path
                                style="stroke: rgb(25,25,25); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;"
                                transform=" translate(-19.26, -16.72)" d="M 20.019 17.5 L 18.5 15.948"
                                stroke-linecap="round" />
                        </g>
                        <g transform="matrix(1 0 0 1 -7.41 -5)">
                            <path
                                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255,221,161); fill-rule: nonzero; opacity: 1;"
                                transform=" translate(-4.59, -7)"
                                d="M 0.5 2 L 1.5 3.934 L 1.5 8.5 C 1.458 10.279 3.581 11.863 5.5 13.5 L 5.5 8.052 L 6.532 9.106 C 6.64576 9.2244 6.78181 9.31913 6.93233 9.38474 C 7.08284 9.45034 7.24485 9.48553 7.40902 9.48827 C 7.57319 9.49101 7.73628 9.46124 7.8889 9.40069 C 8.04153 9.34014 8.18066 9.25 8.2983 9.13546 C 8.41595 9.02092 8.50977 8.88424 8.57437 8.73329 C 8.63897 8.58234 8.67308 8.4201 8.67472 8.25591 C 8.67637 8.09173 8.64552 7.92884 8.58395 7.77662 C 8.52239 7.62441 8.43132 7.48588 8.316 7.369 L 5.5 4.5 L 5.5 3 C 5.34669 2.10547 5.0059 1.25349 4.5 0.5"
                                stroke-linecap="round" />
                        </g>
                        <g transform="matrix(1 0 0 1 -7.41 -5)">
                            <path
                                style="stroke: rgb(25,25,25); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;"
                                transform=" translate(-4.59, -7)"
                                d="M 0.5 2 L 1.5 3.934 L 1.5 8.5 C 1.458 10.279 3.581 11.863 5.5 13.5 L 5.5 8.052 L 6.532 9.106 C 6.64576 9.2244 6.78181 9.31913 6.93233 9.38474 C 7.08284 9.45034 7.24485 9.48553 7.40902 9.48827 C 7.57319 9.49101 7.73628 9.46124 7.8889 9.40069 C 8.04153 9.34014 8.18066 9.25 8.2983 9.13546 C 8.41595 9.02092 8.50977 8.88424 8.57437 8.73329 C 8.63897 8.58234 8.67308 8.4201 8.67472 8.25591 C 8.67637 8.09173 8.64552 7.92884 8.58395 7.77662 C 8.52239 7.62441 8.43132 7.48588 8.316 7.369 L 5.5 4.5 L 5.5 3 C 5.34669 2.10547 5.0059 1.25349 4.5 0.5"
                                stroke-linecap="round" />
                        </g>
                        <g transform="matrix(1 0 0 1 -7.26 -4.72)">
                            <path
                                style="stroke: rgb(25,25,25); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;"
                                transform=" translate(-4.74, -7.28)" d="M 3.98099 6.5 L 5.49999 8.052"
                                stroke-linecap="round" />
                        </g>
                        <g transform="matrix(1 0 0 1 -1.75 3.5)">
                            <path
                                style="stroke: rgb(25,25,25); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;"
                                transform=" translate(-10.25, -15.5)" d="M 13 15.5 L 7.5 15.5" stroke-linecap="round" />
                        </g>
                        <g transform="matrix(1 0 0 1 0 0.5)">
                            <path
                                style="stroke: rgb(25,25,25); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;"
                                transform=" translate(-12, -12.5)" d="M 16.5 12.5 L 7.5 12.5" stroke-linecap="round" />
                        </g>
                        <g transform="matrix(1 0 0 1 -2.25 6.5)">
                            <path
                                style="stroke: rgb(25,25,25); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;"
                                transform=" translate(-9.75, -18.5)" d="M 12 18.5 L 7.5 18.5" stroke-linecap="round" />
                        </g>
                        <g transform="matrix(1 0 0 1 4.48 -7.5)">
                            <path
                                style="stroke: rgb(25,25,25); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: rgb(120,235,123); fill-rule: nonzero; opacity: 1;"
                                transform=" translate(-16.48, -4.5)"
                                d="M 16.481 8.499 C 18.6901 8.499 20.481 6.70814 20.481 4.499 C 20.481 2.28986 18.6901 0.499001 16.481 0.499001 C 14.2718 0.499001 12.481 2.28986 12.481 4.499 C 12.481 6.70814 14.2718 8.499 16.481 8.499 Z"
                                stroke-linecap="round" />
                        </g>
                        <g transform="matrix(1 0 0 1 5.75 -8.6)">
                            <path
                                style="stroke: rgb(25,25,25); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;"
                                transform=" translate(-17.75, -3.4)"
                                d="M 20.5 1.5 L 16.854 5.145 C 16.8076 5.19156 16.7524 5.22851 16.6916 5.25371 C 16.6309 5.27892 16.5658 5.29189 16.5 5.29189 C 16.4342 5.29189 16.3691 5.27892 16.3084 5.25371 C 16.2476 5.22851 16.1924 5.19156 16.146 5.145 L 15 4"
                                stroke-linecap="round" />
                        </g>
                    </g>
                </g>
            </svg>

            <span class="text-sm text-slate-600">
                Kontrak hunian mengikuti periode akademik yang berlaku.
            </span>

        </div>

    </div>

    {{-- CTA --}}
    <div class="space-y-3 pt-2">

        @if ($canReserve)

            @auth

                @if (auth()->user()->role !== 'admin')
                    <a href="{{ route('Reservation.create', $room->room_id) }}" target="_blank"
                        class="flex items-center justify-center
                               rounded-2xl bg-orange-500
                               px-5 py-4
                               text-center font-black text-white
                               transition hover:bg-orange-600">

                        Reservasi Kamar Ini

                    </a>
                @else
                    <button disabled
                        class="w-full cursor-not-allowed
                               rounded-2xl bg-slate-200
                               px-5 py-4
                               font-bold text-slate-500">

                        Admin Tidak Dapat Reservasi

                    </button>
                @endif
            @else
                <a href="{{ route('login', ['redirect' => url()->current()]) }}"
                    class="flex items-center justify-center
                           rounded-2xl bg-orange-500
                           px-5 py-4
                           font-black text-white
                           transition hover:bg-orange-600">

                    Login untuk Reservasi

                </a>

            @endauth
        @else
            <div class="rounded-2xl border border-red-200
                       bg-red-50 p-4">

                <div class="font-bold text-red-700">

                    Reservasi Tidak Tersedia

                </div>

                <div class="mt-1 text-sm text-red-600">

                    {{ $reserveMessage }}

                </div>

            </div>

        @endif

        <a href="{{ route('cari-kamar.index') }}"
            class="flex items-center justify-center
                   rounded-2xl border border-slate-200
                   bg-slate-50 px-5 py-4
                   font-bold text-slate-700
                   transition hover:bg-slate-100">

            Kembali ke Daftar Kamar

        </a>

    </div>

    {{-- DISCLAIMER --}}
    <div class="border-t border-slate-100 pt-4">

        <p class="text-xs leading-relaxed text-slate-500">

            Harga dan ketersediaan kamar dapat berubah sewaktu-waktu
            sesuai kebijakan pengelola Rusunawa Universitas Diponegoro.

        </p>

    </div>

</div>
