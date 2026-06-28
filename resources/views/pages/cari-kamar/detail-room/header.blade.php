{{-- HEADER DETAIL --}}

<div class="space-y-5">


    {{-- Rating --}}
    <div class="flex items-center gap-2 text-sm">

        <div class="flex items-center text-yellow-400">

            @for ($i = 1; $i <= 5; $i++)
                <svg class="w-4 h-4 {{ $i <= round($averageRating) ? 'fill-current' : 'text-slate-300 fill-current' }}"
                    viewBox="0 0 20 20">
                    <path
                        d="M9.049.927c.3-.921 1.603-.921 1.902 0l1.562 4.81a1 1 0 00.95.69h5.058c.969 0 1.371 1.24.588 1.81l-4.092 2.973a1 1 0 00-.364 1.118l1.563 4.81c.299.92-.755 1.688-1.539 1.118l-4.092-2.973a1 1 0 00-1.176 0L5.36 17.256c-.783.57-1.838-.197-1.539-1.118l1.563-4.81a1 1 0 00-.364-1.118L.928 7.237C.145 6.667.547 5.427 1.516 5.427h5.058a1 1 0 00.95-.69L9.049.927z" />
                </svg>
            @endfor

        </div>

        <span class="font-medium text-slate-600">
            Hunian Rusunawa UNDIP
        </span>

    </div>

    {{-- Judul --}}
    <div>

        <h1 class="text-3xl md:text-4xl font-black text-slate-900">
            Kamar {{ $room->kode_kamar }}
        </h1>

        <div class="mt-2 flex flex-wrap items-center gap-2 text-sm text-slate-500">

            <span>Gedung {{ $gedungLabelUpper }}</span>

            <span>•</span>

            <span>Lantai {{ $lantai }}</span>

            <span>•</span>

            <span>{{ $capacity }} Penghuni</span>

        </div>

    </div>

    {{-- Badge Status --}}
    <div class="flex flex-wrap gap-2">

        <span
            class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-sm font-bold
        {{ $isAvailable
            ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
            : 'bg-red-50 text-red-700 border border-red-200' }}">

            <svg id='User_Account_24' width='24' height='24' viewBox='0 0 24 24'
                xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                <rect width='24' height='24' stroke='none' fill='#000000' opacity='0' />


                <g transform="matrix(0.91 0 0 0.91 12 12)">
                    <path
                        style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                        transform=" translate(-12, -12)"
                        d="M 8 5 C 6.343145750507619 5 5 6.343145750507619 5 8 C 5 9.65685424949238 6.343145750507619 11 8 11 C 9.65685424949238 11 11 9.65685424949238 11 8 C 11 6.343145750507619 9.65685424949238 5 8 5 z M 16 5 C 14.34314575050762 5 13 6.343145750507619 13 8 C 13 9.65685424949238 14.34314575050762 11 16 11 C 17.65685424949238 11 19 9.65685424949238 19 8 C 19 6.343145750507619 17.65685424949238 5 16 5 z M 8 13 C 5 13 1 14.464 1 16.5 L 1 19 L 15 19 L 15 16.5 C 15 14.464 11 13 8 13 z M 16 13 C 15.683 13 15.353484 13.019781 15.021484 13.050781 C 16.203484 13.915781 17 15.059 17 16.5 L 17 19 L 23 19 L 23 16.5 C 23 14.464 19 13 16 13 z"
                        stroke-linecap="round" />
                </g>
            </svg>

            {{ $isAvailable ? 'Tersedia' : 'Penuh' }}

        </span>

        <span
            class="inline-flex items-center gap-2 rounded-full bg-blue-50 text-blue-700 border border-blue-200 px-3 py-1 text-sm font-bold">

            <svg id='Key_24' width='24' height='24' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'
                xmlns:xlink='http://www.w3.org/1999/xlink'>
                <rect width='24' height='24' stroke='none' fill='#000000' opacity='0' />


                <g transform="matrix(0.83 0 0 0.83 12 12)">
                    <path
                        style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                        transform=" translate(-12, -12)"
                        d="M 7 5 C 3.134 5 0 8.134 0 12 C 0 15.866 3.134 19 7 19 C 10.170669 19 12.846171 16.890989 13.707031 14 L 18 14 L 18 17 L 22 17 L 22 14 L 24 14 L 24 10 L 13.707031 10 C 12.846171 7.1090112 10.170669 5 7 5 z M 7 9 C 8.657 9 10 10.343 10 12 C 10 13.657 8.657 15 7 15 C 5.343 15 4 13.657 4 12 C 4 10.343 5.343 9 7 9 z"
                        stroke-linecap="round" />
                </g>
            </svg>

            Sisa {{ $slots }} Slot

        </span>

    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">

        <div class="rounded-2xl border border-slate-200 bg-white p-4">

            <div class="text-xs text-slate-500">
                Rating
            </div>

            <div class="mt-1 text-xl font-black text-slate-900">
                {{ $averageRating ?: '-' }}
            </div>

        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4">

            <div class="text-xs text-slate-500">
                Ulasan
            </div>

            <div class="mt-1 text-xl font-black text-slate-900">
                {{ $totalTestimonials }}
            </div>

        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4">

            <div class="text-xs text-slate-500">
                Terisi
            </div>

            <div class="mt-1 text-xl font-black text-slate-900">
                {{ $occupied }}
            </div>

        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4">

            <div class="text-xs text-slate-500">
                Slot
            </div>

            <div class="mt-1 text-xl font-black text-emerald-600">
                {{ $slots }}
            </div>

        </div>

    </div>


</div>
