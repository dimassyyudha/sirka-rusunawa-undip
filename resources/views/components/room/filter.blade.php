@props([
    'gender' => null,
    'gedungFilter' => null,
    'lantaiFilter' => null,
    'gedungsSidebar' => [],
    'floorInfo' => [],
])

<div class="space-y-6">

    {{-- TIPE PENGHUNI --}}
    <div>

        <div class="flex items-center justify-between mb-3">

            <div>

                <h3 class="font-black text-slate-900">
                    Tipe Penghuni
                </h3>

                <p class="text-xs text-slate-500">
                    Pilih kategori kamar
                </p>

            </div>

            @if ($gender)
                <a href="{{ route('cari-kamar.index', array_filter(request()->except('page', 'gender', 'gedung', 'lantai'), fn($v) => $v !== null && $v !== '')) }}"
                    class="text-xs font-bold text-blue-600 hover:underline">
                    Reset
                </a>
            @endif

        </div>

        <div class="grid grid-cols-2 rounded-2xl bg-slate-100 p-1">

            <a href="{{ route('cari-kamar.index', array_filter(array_merge(request()->except('page', 'gender', 'gedung', 'lantai'), ['gender' => $gender === 'pria' ? null : 'pria']), fn($v) => $v !== null && $v !== '')) }}"
                class="rounded-xl py-3 text-center text-sm font-black transition-all duration-200
                {{ $gender === 'pria' ? 'bg-blue-600 text-white shadow' : 'text-slate-700 hover:bg-white' }}">

                Putra

            </a>

            <a href="{{ route('cari-kamar.index', array_filter(array_merge(request()->except('page', 'gender', 'gedung', 'lantai'), ['gender' => $gender === 'wanita' ? null : 'wanita']), fn($v) => $v !== null && $v !== '')) }}"
                class="rounded-xl py-3 text-center text-sm font-black transition-all duration-200
                {{ $gender === 'wanita' ? 'bg-pink-500 text-white shadow' : 'text-slate-700 hover:bg-white' }}">

                Putri

            </a>

        </div>

    </div>

    {{-- GEDUNG --}}
    <div>

        <div class="flex items-center justify-between mb-3">

            <div>

                <h3 class="font-black text-slate-900">
                    Gedung
                </h3>

                <p class="text-xs text-slate-500">
                    Pilih lokasi gedung
                </p>

            </div>

            @if ($gedungFilter)
                <a href="{{ route('cari-kamar.index', array_filter(request()->except('page', 'gedung', 'lantai'), fn($v) => $v !== null && $v !== '')) }}"
                    class="text-xs font-bold text-red-600 hover:underline">
                    Reset
                </a>
            @endif

        </div>

        <div class="flex flex-wrap gap-2">

            @foreach ($gedungsSidebar as $gedung)
                @php
                    $kode = $gedung['code'];
                    $genderGedung = strtolower($gedung['gender_type']);
                @endphp

                @if (
                    !$gender ||
                        ($gender === 'pria' && $genderGedung === 'putra') ||
                        ($gender === 'wanita' && $genderGedung === 'putri'))
                    <a href="{{ route(
                        'cari-kamar.index',
                        array_filter(
                            array_merge(request()->except('page', 'gedung', 'lantai'), ['gedung' => $kode]),
                            fn($v) => $v !== null && $v !== '',
                        ),
                    ) }}"
                        class="px-4 py-2 rounded-full border text-sm font-bold
        {{ $gedungFilter === $kode
            ? 'bg-orange-500 text-white border-orange-500'
            : 'bg-white border-slate-200 text-slate-700 hover:border-orange-300 hover:text-orange-600' }}">

                        Gedung {{ $kode }}

                    </a>
                @endif
            @endforeach

        </div>

    </div>

    {{-- LANTAI --}}
    @if ($gedungFilter && isset($floorInfo[$gedungFilter]))

        <div>

            <div class="flex items-center justify-between mb-3">

                <div>

                    <h3 class="font-black text-slate-900">
                        Lantai
                    </h3>

                    <p class="text-xs text-slate-500">
                        Pilih lantai kamar
                    </p>

                </div>

                @if ($lantaiFilter)
                    <a href="{{ route('cari-kamar.index', array_filter(request()->except('page', 'lantai'), fn($v) => $v !== null && $v !== '')) }}"
                        class="text-xs font-bold text-red-600 hover:underline">
                        Reset
                    </a>
                @endif

            </div>

            <div class="flex flex-wrap gap-2">

                @foreach ($floorInfo[$gedungFilter] as $floorNumber => $totalRooms)
                    <a href="{{ route('cari-kamar.index', array_filter(array_merge(request()->except('page', 'lantai'), ['lantai' => $floorNumber]), fn($v) => $v !== null && $v !== '')) }}"
                        class="px-4 py-2 rounded-full border text-sm font-bold transition-all duration-200
                        {{ (string) $lantaiFilter === (string) $floorNumber
                            ? 'bg-[#070B55] text-white border-[#070B55] shadow-sm'
                            : 'bg-white text-slate-700 border-slate-200 hover:border-[#070B55] hover:text-[#070B55]' }}">

                        Lt {{ $floorNumber }}

                    </a>
                @endforeach

            </div>

        </div>

    @endif

    {{-- FILTER AKTIF --}}
    @if ($gender || $gedungFilter || $lantaiFilter)

        <div class="rounded-2xl border border-orange-200 bg-orange-50 p-4">

            <div class="mb-3 text-sm font-black text-orange-700">
                Filter Aktif
            </div>

            <div class="flex flex-wrap gap-2">

                @if ($gender)
                    <a href="{{ route('cari-kamar.index', request()->except('gender')) }}"
                        class="inline-flex items-center gap-2 rounded-full bg-blue-100 px-3 py-2 text-xs font-black text-blue-700 hover:bg-blue-200 transition">

                        {{ $gender === 'pria' ? 'Putra' : 'Putri' }}

                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>

                    </a>
                @endif

                @if ($gedungFilter)
                    <a href="{{ route('cari-kamar.index', request()->except('gedung')) }}"
                        class="inline-flex items-center gap-2 rounded-full bg-orange-100 px-3 py-2 text-xs font-black text-orange-700 hover:bg-orange-200 transition">

                        Gedung {{ $gedungFilter }}

                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>

                    </a>
                @endif

                @if ($lantaiFilter)
                    <a href="{{ route('cari-kamar.index', request()->except('lantai')) }}"
                        class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-2 text-xs font-black text-emerald-700 hover:bg-emerald-200 transition">

                        Lantai {{ $lantaiFilter }}

                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>

                    </a>
                @endif

            </div>

        </div>

    @endif

    {{-- RESET --}}
    <a href="{{ route('cari-kamar.index') }}"
        class="block w-full rounded-2xl bg-red-600 px-4 py-3 text-center text-sm font-black text-white transition hover:bg-red-700">

        Reset Semua Filter

    </a>

</div>
