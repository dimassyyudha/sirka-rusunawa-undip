@props([
    'gender' => null,
    'gedungFilter' => null,
    'lantaiFilter' => null,
    'gedungsSidebar' => [],
    'floorInfo' => [],
])
@php

    $lakiGedung = collect($gedungsSidebar)->where('gender_type', 'laki-laki')->pluck('code')->implode(', ');

    $perempuanGedung = collect($gedungsSidebar)->where('gender_type', 'perempuan')->pluck('code')->implode(', ');

@endphp

<div class="space-y-4">

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
                    class="text-xs font-bold text-red-600 hover:underline">
                    Reset
                </a>
            @endif

        </div>

        <div class="space-y-2">

            <label class="flex items-center gap-2 cursor-pointer">

                <input type="radio" name="gender_filter" value="laki-laki"
                    {{ $gender === 'laki-laki' ? 'checked' : '' }}
                    onchange="window.location.href='{{ route(
                        'cari-kamar.index',
                        array_filter(
                            array_merge(request()->except('page', 'gender', 'gedung', 'lantai'), ['gender' => 'laki-laki']),
                            fn($v) => $v !== null && $v !== '',
                        ),
                    ) }}'">

                <span class="text-sm font-medium">
                    Laki-Laki
                </span>

            </label>

            <label class="flex items-center gap-2 cursor-pointer">

                <input type="radio" name="gender_filter" value="perempuan"
                    {{ $gender === 'perempuan' ? 'checked' : '' }}
                    onchange="window.location.href='{{ route(
                        'cari-kamar.index',
                        array_filter(
                            array_merge(request()->except('page', 'gender', 'gedung', 'lantai'), ['gender' => 'perempuan']),
                            fn($v) => $v !== null && $v !== '',
                        ),
                    ) }}'">

                <span class="text-sm font-medium">
                    Perempuan
                </span>

            </label>

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
                    Pilih Gedung Kamar
                </p>
                <p class="text-xs text-slate-500">

                    @if ($gender === 'laki-laki')
                        Gedung laki-laki: {{ $lakiGedung }}
                    @elseif($gender === 'perempuan')
                        Gedung perempuan: {{ $perempuanGedung }}
                    @else
                        Laki-laki: {{ $lakiGedung }}
                        <br>
                        Perempuan: {{ $perempuanGedung }}
                    @endif

                </p>
            </div>

            @if ($gedungFilter)
                <a href="{{ route('cari-kamar.index', array_filter(request()->except('page', 'gedung'), fn($v) => $v !== null && $v !== '')) }}"
                    class="text-xs font-bold text-red-600 hover:underline">
                    Reset
                </a>
            @endif

        </div>

        <form method="GET">

            @foreach (request()->except('gedung', 'page') as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            <select name="gedung" onchange="this.form.submit()"
                class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm">

                <option value="">
                    Semua Gedung
                </option>

                @foreach ($gedungsSidebar as $gedung)
                    @php
                        $kode = $gedung['code'];
                        $genderGedung = strtolower(trim($gedung['gender_type']));
                    @endphp

                    @if (
                        !$gender ||
                            ($gender === 'laki-laki' && $genderGedung === 'laki-laki') ||
                            ($gender === 'perempuan' && $genderGedung === 'perempuan'))
                        <option value="{{ $kode }}" {{ $gedungFilter == $kode ? 'selected' : '' }}>

                            Gedung {{ $kode }}

                        </option>
                    @endif
                @endforeach

            </select>

        </form>

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

            <div>

                <form method="GET">

                    @foreach (request()->except('lantai', 'page') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach

                    <select name="lantai" onchange="this.form.submit()"
                        class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm">

                        <option value="">
                            Semua Lantai
                        </option>

                        @foreach ($floorInfo[$gedungFilter] as $floorNumber => $totalRooms)
                            <option value="{{ $floorNumber }}"
                                {{ (string) $lantaiFilter === (string) $floorNumber ? 'selected' : '' }}>

                                Lantai {{ $floorNumber }}

                            </option>
                        @endforeach

                    </select>

                </form>

            </div>

        </div>

    @endif




</div>
