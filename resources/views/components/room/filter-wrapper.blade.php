@props([
    'gender' => null,
    'gedungFilter' => null,
    'lantaiFilter' => null,
    'gedungsSidebar' => [],
    'floorInfo' => [],
    'sort' => 'recommended',
    'rooms' => null,
])

<aside class="self-start md:sticky md:top-1 md:h-[calc(100vh-120px)] md:overflow-y-auto md:pr-2 filter-sidebar-scroll">

    <div class="space-y-4">

        {{-- MOBILE --}}

        <div class="md:hidden">

            {{-- FLOATING BAR --}}
            {{-- <div class="fixed top-[72px] left-0 right-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur"> --}}
            <div class="fixed
           left-0
           right-0
           z-40
           border-b
           border-slate-200
           bg-white/95
           backdrop-blur"
                style="top: var(--mobile-header-height,72px);">
                <div class="px-4 py-3">

                    {{-- ACTIVE FILTER CHIP --}}
                    @if ($gender || $gedungFilter || $lantaiFilter)

                        <div class="mb-3 flex items-center gap-2 overflow-x-auto no-scrollbar">

                            @if ($gender)
                                <span
                                    class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-2 text-xs font-bold text-blue-700">

                                    {{ ucfirst($gender) }}

                                    <a href="{{ route('cari-kamar.index', request()->except('gender')) }}">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </a>

                                </span>
                            @endif

                            @if ($gedungFilter)
                                <span
                                    class="inline-flex items-center gap-2 rounded-full bg-orange-50 px-3 py-2 text-xs font-bold text-orange-700">

                                    Gedung {{ $gedungFilter }}

                                    <a href="{{ route('cari-kamar.index', request()->except('gedung')) }}">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </a>

                                </span>
                            @endif

                            @if ($lantaiFilter)
                                <span
                                    class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-2 text-xs font-bold text-emerald-700">

                                    Lt {{ $lantaiFilter }}

                                    <a href="{{ route('cari-kamar.index', request()->except('lantai')) }}">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </a>

                                </span>
                            @endif

                            {{-- RESET SEMUA --}}
                            <a href="{{ route('cari-kamar.index') }}"
                                class="inline-flex shrink-0 items-center gap-2 rounded-full bg-red-500 px-3 py-2 text-xs font-black text-white hover:bg-red-600 transition">

                                <svg id='Clear_Filters_24' width='24' height='24' viewBox='0 0 24 24'
                                    xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                                    <rect width='24' height='24' stroke='none' fill='#000000' opacity='0' />


                                    <g transform="matrix(0.95 0 0 0.95 12 12)">
                                        <path
                                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                            transform=" translate(-13.5, -13.5)"
                                            d="M 3 3 L 3 5 L 4 5 L 9 13 L 9 21 L 12.294922 21 C 12.197922 20.676 12.123219 20.342 12.074219 20 L 12.080078 20 C 12.033078 19.673 12 19.34 12 19 C 12 17.67 12.378437 16.431047 13.023438 15.373047 C 13.133437 15.193047 13.251953 15.018609 13.376953 14.849609 C 13.398953 14.820609 13.419406 14.789766 13.441406 14.759766 C 13.563406 14.599766 13.693125 14.447828 13.828125 14.298828 C 13.858125 14.265828 13.886016 14.231219 13.916016 14.199219 C 14.244016 13.850219 14.606 13.534766 15 13.259766 L 15 13 L 20 5 L 21 5 L 21 3 L 20 3 L 4 3 L 3 3 z M 19.007812 14.019531 C 17.627813 14.019531 16.378609 14.572563 15.474609 15.476562 C 14.570609 16.380562 14.017578 17.629766 14.017578 19.009766 C 14.017578 21.769766 16.249766 24 19.009766 24 C 21.769766 24 24 21.770766 24 19.009766 C 23.999 16.252766 21.767813 14.020531 19.007812 14.019531 z M 17.601562 16.179688 L 19.015625 17.59375 L 20.429688 16.179688 L 21.84375 17.59375 L 20.429688 19.007812 L 21.84375 20.421875 L 20.429688 21.835938 L 19.015625 20.421875 L 17.601562 21.835938 L 16.1875 20.421875 L 17.601562 19.007812 L 16.1875 17.59375 L 17.601562 16.179688 z"
                                            stroke-linecap="round" />
                                    </g>
                                </svg>
                                Reset Filter

                            </a>

                        </div>

                    @endif

                    <div class="grid grid-cols-2 gap-3">

                        <button id="openFilter"
                            class="flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white py-3 font-black text-slate-800 shadow-sm">

                            <svg id='Filter_24' width='24' height='24' viewBox='0 0 24 24'
                                xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                                <rect width='24' height='24' stroke='none' fill='#000000' opacity='0' />


                                <g transform="matrix(0.43 0 0 0.43 12 12)">
                                    <path
                                        style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                        transform=" translate(-25, -24.99)"
                                        d="M 3.8125 2 C 3.335938 2.089844 2.992188 2.511719 3 3 L 3 6 C 3.003906 6.257813 3.101563 6.503906 3.28125 6.6875 L 19 23.375 L 19 41 C 19.007813 41.347656 19.199219 41.667969 19.5 41.84375 L 29.5 47.84375 C 29.804688 48.019531 30.183594 48.023438 30.492188 47.847656 C 30.796875 47.675781 30.992188 47.351563 31 47 L 31 23.375 L 46.5625 6.84375 C 46.574219 6.832031 46.582031 6.824219 46.59375 6.8125 L 46.71875 6.6875 C 46.765625 6.640625 46.808594 6.585938 46.84375 6.53125 C 46.867188 6.511719 46.886719 6.492188 46.90625 6.46875 C 46.964844 6.339844 46.996094 6.203125 47 6.0625 C 47 6.042969 47 6.019531 47 6 C 47.003906 5.949219 47.003906 5.894531 47 5.84375 L 47 3 C 47 2.449219 46.550781 2 46 2 L 4 2 C 3.96875 2 3.9375 2 3.90625 2 C 3.875 2 3.84375 2 3.8125 2 Z M 5 4 L 45 4 L 45 5.625 L 29.5625 22 L 20.4375 22 L 5 5.625 Z M 21 24 L 29 24 L 29 45.25 L 21 40.46875 Z"
                                        stroke-linecap="round" />
                                </g>
                            </svg>
                            Filter

                        </button>

                        <button id="openSort"
                            class="flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white py-3 font-black text-slate-800 shadow-sm">

                            <svg id='Sort_24' width='24' height='24' viewBox='0 0 24 24'
                                xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                                <rect width='24' height='24' stroke='none' fill='#000000' opacity='0' />


                                <g transform="matrix(0.49 0 0 0.49 12 12)">
                                    <path
                                        style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                                        transform=" translate(-25, -24)"
                                        d="M 25 3.585938 L 6.585938 22 L 43.414063 22 Z M 25 6.414063 L 38.585938 20 L 11.414063 20 Z M 6.585938 26 L 25 44.414063 L 43.414063 26 Z M 11.414063 28 L 38.585938 28 L 25 41.585938 Z"
                                        stroke-linecap="round" />
                                </g>
                            </svg>
                            Sort

                        </button>

                    </div>

                </div>

            </div>

            {{-- SPACER --}}
            {{-- <div class="{{ $gender || $gedungFilter || $lantaiFilter ? 'h-[170px]' : 'h-[100px]' }}"></div> --}}
            <div id="mobileBarSpacer"></div>
            {{-- FILTER MODAL --}}

            <div id="filterModal" class="hidden fixed inset-0 z-[999]">

                <div id="closeFilter" class="absolute inset-0 bg-black/50 backdrop-blur-sm">
                </div>

                <div
                    class="absolute top-[80px] left-1/2 w-[92%] max-w-md -translate-x-1/2 rounded-[32px] bg-white shadow-2xl max-h-[80vh] overflow-y-auto">



                    <div class="p-5">

                        <form id="mobileFilterForm" method="GET" action="{{ route('cari-kamar.index') }}">

                            <input type="hidden" name="sort" value="{{ $sort }}">

                            {{-- GENDER --}}
                            <div class="mb-5">

                                <h3 class="font-black text-slate-900 mb-3">
                                    Tipe Penghuni
                                </h3>

                                <div class="grid grid-cols-2 gap-2">

                                    <label
                                        class="gender-option cursor-pointer rounded-2xl border border-slate-200 bg-white p-3 text-center text-sm font-black text-slate-700 transition-all duration-200">

                                        <input type="radio" name="gender" value="laki-laki" class="hidden"
                                            {{ $gender === 'laki-laki' ? 'checked' : '' }}>

                                        Laki-Laki

                                    </label>

                                    <label
                                        class="gender-option cursor-pointer rounded-2xl border border-slate-200 bg-white p-3 text-center text-sm font-black text-slate-700 transition-all duration-200">

                                        <input type="radio" name="gender" value="perempuan" class="hidden"
                                            {{ $gender === 'perempuan' ? 'checked' : '' }}>

                                        Perempuan

                                    </label>

                                </div>

                            </div>

                            {{-- GEDUNG --}}
                            <div class="mb-5">

                                <h3 class="font-black text-slate-900 mb-3">
                                    Gedung
                                </h3>

                                <div class="flex flex-wrap gap-2">

                                    @foreach ($gedungsSidebar as $gedung)
                                        @php
                                            $kode = $gedung['code'];
                                            $genderGedung = strtolower(trim($gedung['gender_type']));
                                        @endphp

                                        <label data-gender="{{ $genderGedung }}" title="{{ $genderGedung }}"
                                            class="mobile-gedung hidden cursor-pointer rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 transition-all duration-200">

                                            <input type="radio" name="gedung" value="{{ $kode }}"
                                                class="hidden" {{ $gedungFilter === $kode ? 'checked' : '' }}>

                                            Gedung {{ $kode }}

                                        </label>
                                    @endforeach

                                </div>

                            </div>

                            {{-- LANTAI --}}
                            <div class="mb-5">

                                <h3 class="font-black text-slate-900 mb-3">
                                    Lantai
                                </h3>

                                <div id="lantaiContainer" class="flex flex-wrap gap-2">

                                </div>

                            </div>

                            <div class="grid grid-cols-2 gap-3">

                                <a href="{{ route('cari-kamar.index') }}"
                                    class="rounded-2xl border border-slate-300 py-3 text-center font-black">

                                    Reset

                                </a>

                                <button type="submit" class="rounded-2xl bg-[#070B55] py-3 font-black text-white">

                                    Tampilkan Hasil

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

            {{-- SORT MODAL --}}
            <div id="sortModal" class="hidden fixed inset-0 z-[999]">

                <div id="closeSort" class="absolute inset-0 bg-black/50 backdrop-blur-sm">
                </div>

                <div
                    class="absolute top-[80px] left-1/2 w-[92%] max-w-md -translate-x-1/2 rounded-[32px] bg-white shadow-2xl">

                    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">

                        <h3 class="text-lg font-black">
                            Urutkan Kamar
                        </h3>

                        <button id="closeSortBtn"
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100">

                            <i class="bi bi-x-lg"></i>

                        </button>

                    </div>

                    <div class="p-5">

                        <x-room.sort :sort="$sort" />

                    </div>

                </div>

            </div>

        </div>


        {{-- DESKTOP --}}
        <div class="hidden md:block space-y-5">

            {{-- FILTER CARD --}}
            <div class="overflow-visible rounded-3xl border border-slate-200 bg-white shadow-sm">

                {{-- HEADER --}}
                <div class="bg-gradient-to-r from-[#070B55] to-[#0f1a9e] px-4 py-3 text-white rounded-t-3xl">

                    <div class="flex items-center justify-between">

                        <div>

                            <div class="text-sm font-black">
                                Filter Aktif
                            </div>

                            <div class="text-[11px] text-white/70">
                                {{ collect([$gender, $gedungFilter, $lantaiFilter])->filter()->count() }}
                                filter dipilih
                            </div>

                        </div>

                        <a href="{{ route('cari-kamar.index') }}"
                            class="rounded-lg bg-red-600 px-2.5 py-1.5 text-[11px] font-bold text-white transition hover:bg-red-700">

                            Reset Filter

                        </a>

                    </div>

                    <div class="mt-3 flex flex-wrap gap-1.5">

                        @if ($gender)
                            <a href="{{ route('cari-kamar.index', request()->except('gender')) }}"
                                class="inline-flex items-center gap-1 rounded-full bg-red-600 px-2.5 py-1 text-[11px] font-bold text-white transition hover:bg-red-700">

                                {{ $gender === 'laki-laki' ? 'Laki-Laki' : 'Perempuan' }}

                                <svg class="h-2.5 w-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>

                            </a>
                        @endif

                        @if ($gedungFilter)
                            <a href="{{ route('cari-kamar.index', request()->except('gedung')) }}"
                                class="inline-flex items-center gap-1 rounded-full bg-red-600 px-2.5 py-1 text-[11px] font-bold text-white transition hover:bg-red-700">

                                Gedung {{ $gedungFilter }}

                                <svg class="h-2.5 w-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>

                            </a>
                        @endif

                        @if ($lantaiFilter)
                            <a href="{{ route('cari-kamar.index', request()->except('lantai')) }}"
                                class="inline-flex items-center gap-1 rounded-full bg-red-600 px-2.5 py-1 text-[11px] font-bold text-white transition hover:bg-red-700">

                                Lantai {{ $lantaiFilter }}

                                <svg class="h-2.5 w-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>

                            </a>
                        @endif

                        @if (!$gender && !$gedungFilter && !$lantaiFilter)
                            <span class="rounded-full bg-white/10 px-2.5 py-1 text-[11px] text-white/70">

                                Belum ada filter

                            </span>
                        @endif

                    </div>

                </div>

                {{-- CONTENT --}}
                <div class="p-5">

                    <x-room.filter :gender="$gender" :gedung-filter="$gedungFilter" :lantai-filter="$lantaiFilter" :gedungs-sidebar="$gedungsSidebar"
                        :floor-info="$floorInfo" />

                </div>

            </div>

            {{-- SORT CARD --}}
            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-100 px-5 py-4">

                    <div class="font-black text-slate-900">
                        Urutkan Hasil
                    </div>

                    <div class="mt-1 text-xs text-slate-500">
                        Tampilkan kamar sesuai preferensi
                    </div>

                </div>

                <div class="p-3">

                    <x-room.sort :sort="$sort" />

                </div>

            </div>

        </div>

    </div>

</aside>

@include('components.room.partials.mobile-filter-style')

@include('components.room.partials.mobile-filter-script')
