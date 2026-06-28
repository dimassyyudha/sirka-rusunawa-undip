@extends('layouts.app')

@section('title', 'Manajemen Penghuni')
@section('page_title', 'Manajemen Penghuni')

@section('content')
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900">Manajemen Penghuni</h2>
                <p class="text-sm text-slate-500 mt-1">
                    Kelola data penghuni rusunawa. Hanya status penghuni lama yang dihitung sebagai penghuni kamar.
                </p>
            </div>

            <x-button.button-menu href="{{ route('admin.penghuni.create') }}" type="button" variant="primary" size="lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Penghuni
            </x-button.button-menu>
        </div>

        @if (session('success'))
            <div
                class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <form id="filterForm" method="GET" class="mb-6 rounded-[20px] border border-slate-200 bg-white p-5 shadow-sm">
            <div class="grid gap-4 lg:grid-cols-6">

                {{-- SEARCH --}}
                <div class="lg:col-span-2">
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Pencarian
                    </label>

                    <input id="searchInput" type="text" name="search" value="{{ request('search') }}"
                        placeholder="Nama, NIM, Email, No HP..."
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">
                </div>

                {{-- GEDUNG --}}
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Gedung
                    </label>

                    <select name="building_id"
                        class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                        <option value="">Semua Gedung</option>

                        @foreach ($buildings as $building)
                            <option value="{{ $building->building_id }}" @selected(request('building_id') == $building->building_id)>
                                {{ $building->name }}
                            </option>
                        @endforeach

                    </select>
                </div>
                {{-- TIPE HUNIAN --}}
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Tipe Hunian
                    </label>

                    <select name="occupancy_type"
                        class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                        <option value="">Semua</option>

                        <option value="private" @selected(request('occupancy_type') == 'private')>
                            Private
                        </option>

                        <option value="shared" @selected(request('occupancy_type') == 'shared')>
                            Shared
                        </option>

                    </select>
                </div>

                {{-- JALUR PEMBIAYAAN --}}
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Jalur Pembiayaan
                    </label>

                    <select name="jalur_pembiayaan"
                        class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                        <option value="">
                            Semua
                        </option>

                        <option value="Bidikmisi/KIP-K" @selected(request('jalur_pembiayaan') == 'Bidikmisi/KIP-K')>

                            KIP-K

                        </option>

                        <option value="Non-Bidikmisi/KIP-K" @selected(request('jalur_pembiayaan') == 'Non-Bidikmisi/KIP-K')>

                            Non KIP-K

                        </option>

                    </select>
                </div>
                {{-- BUTTON --}}
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-transparent">
                        Action
                    </label>

                    <div class="flex gap-2">

                        <button type="submit"
                            class="flex-1 rounded-xl bg-violet-600 px-4 py-3 text-sm font-bold text-white hover:bg-violet-700">

                            Filter

                        </button>

                        <a href="{{ route('admin.penghuni.index') }}"
                            class="flex-1 rounded-xl border border-slate-300 px-4 py-3 text-center text-sm font-bold text-slate-700 hover:bg-slate-50">

                            Reset

                        </a>

                    </div>
                </div>

            </div>

        </form>

        <div class="relative overflow-x-auto bg-white shadow-sm rounded-[10px] border border-slate-200">

            <table class="w-full min-w-[1300px] text-sm text-left text-slate-700">
                <thead class="text-xs uppercase bg-slate-50 border-b border-slate-200 text-slate-500 text-center">
                    <tr>
                        <th class="px-6 py-4 font-black">No</th>
                        <th class="px-6 py-4 font-black">Nama</th>
                        <th class="px-6 py-4 font-black">NIM</th>
                        <th class="px-6 py-4 font-black">Jurusan</th>
                        <th class="px-6 py-4 font-black text-center">Angkatan</th>
                        <th class="px-6 py-4 font-black text-center">Status</th>
                        <th class="px-6 py-4 font-black">Kamar</th>
                        <th class="px-6 py-4 font-black">Gedung</th>
                        <th class="px-6 py-4 font-black text-center">
                            Jalur
                        </th>
                        <th class="px-6 py-4 font-black text-center"> Tipe Hunian </th>
                        <th class="px-6 py-4 font-black text-center">
                            Masa Aktif
                        </th>
                        <th class="px-6 py-4 font-black">Alamat</th>
                        <th class="px-6 py-4 font-black">No HP</th>
                        <th class="px-6 py-4 font-black">Email</th>
                        <th class="px-6 py-4 font-black text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 text-center whitespace-nowrap">
                    @forelse ($penghunis as $p)
                        <tr class="bg-white hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-semibold">
                                {{ method_exists($penghunis, 'firstItem') ? $penghunis->firstItem() + $loop->index : $loop->iteration }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-black text-black">{{ $p->user->name ?? '-' }}</div>

                            </td>

                            <td class="px-6 py-4 font-bold">{{ $p->nim }}</td>
                            <td class="px-6 py-4">{{ $p->jurusan }}</td>
                            <td class="px-6 py-4 text-center font-bold">{{ $p->angkatan }}</td>

                            <td class="px-6 py-4 text-center">
                                @if ($p->status_mahasiswa === 'penghuni')
                                    <span
                                        class="inline-flex px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-600 text-xs font-black">
                                        Penghuni
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if ($p->room)
                                    <div class="font-black text-slate-900">{{ $p->room->kode_kamar }}</div>
                                    {{-- <div class="text-xs text-slate-500 mt-1">
                                        {{ $p->room->floor->building->name ?? '-' }} - Lantai
                                        {{ $p->room->floor->floor_number ?? '-' }}
                                    </div> --}}
                                @else
                                    <span class="text-slate-400 font-semibold">Belum ada kamar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">

                                @if ($p->room?->floor?->building)
                                    <span class="font-bold text-slate-900">

                                        {{ $p->room->floor->building->name }}

                                    </span>
                                @else
                                    <span class="text-slate-400">
                                        -
                                    </span>
                                @endif

                            </td>
                            <td class="px-6 py-4 text-center">

                                @if ($p->jalur_pembiayaan === 'Bidikmisi/KIP-K')
                                    <span
                                        class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">

                                        KIP-K

                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center rounded-full bg-violet-100 px-3 py-1 text-xs font-bold text-violet-700">

                                        Non KIP-K

                                    </span>
                                @endif

                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($p->occupancy_type_label)
                                    <span
                                        class="
            inline-flex items-center rounded-full px-4 py-1.5
            text-xs font-bold

            {{ $p->occupancy_type_label === 'private' ? 'bg-amber-100 text-amber-700' : 'bg-sky-100 text-sky-700' }}
        ">
                                        {{ ucfirst($p->occupancy_type_label) }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center rounded-full bg-slate-100 px-4 py-1.5 text-xs font-bold text-slate-500">
                                        -
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($p->lease_start_date && $p->lease_end_date)
                                    {{ \Carbon\Carbon::parse($p->lease_start_date)->translatedFormat('d M Y') }}
                                    -
                                    {{ \Carbon\Carbon::parse($p->lease_end_date)->translatedFormat('d M Y') }}
                                @else
                                    <span class="text-slate-400">
                                        -
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $p->alamat }}</td>
                            <td class="px-6 py-4">

                                @if ($p->user?->number_phone)
                                    @php
                                        $phone = preg_replace('/[^0-9]/', '', $p->user->number_phone);

                                        if (str_starts_with($phone, '0')) {
                                            $phone = '62' . substr($phone, 1);
                                        }
                                    @endphp

                                    <a href="https://wa.me/{{ $phone }}" target="_blank"
                                        class="inline-flex items-center gap-2 text-green-600 hover:text-green-700 hover:underline">

                                        <svg id='WhatsApp_24' width='24' height='24' viewBox='0 0 24 24'
                                            xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                                            <rect width='24' height='24' stroke='none' fill='#000000'
                                                opacity='0' />


                                            <g transform="matrix(0.42 0 0 0.42 12 12)">
                                                <g style="">
                                                    <g transform="matrix(1 0 0 1 -0.07 0.15)">
                                                        <path
                                                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;"
                                                            transform=" translate(-23.93, -24.15)"
                                                            d="M 4.868 43.303 L 7.562 33.467999999999996 C 5.9 30.59 5.026 27.324 5.027 23.979 C 5.032 13.514 13.548 5 24.014 5 C 29.093 5.002 33.859 6.979 37.444 10.565999999999999 C 41.028000000000006 14.154 43.002 18.921999999999997 43 23.994 C 42.996 34.459 34.478 42.974000000000004 24.014 42.974000000000004 C 24.012999999999998 42.974000000000004 24.014 42.974000000000004 24.014 42.974000000000004 L 24.006 42.974000000000004 C 20.829 42.973000000000006 17.706 42.176 14.933 40.663000000000004 L 4.868 43.303 z"
                                                            stroke-linecap="round" />
                                                    </g>
                                                    <g transform="matrix(1 0 0 1 -0.07 0.15)">
                                                        <path
                                                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;"
                                                            transform=" translate(-23.93, -24.15)"
                                                            d="M 4.868 43.803 C 4.736000000000001 43.803 4.6080000000000005 43.751 4.513 43.654999999999994 C 4.388 43.52799999999999 4.3389999999999995 43.342999999999996 4.386 43.172 L 7.025 33.536 C 5.389 30.630000000000003 4.526 27.330000000000002 4.5280000000000005 23.980000000000004 C 4.532 13.238 13.273 4.5 24.014 4.5 C 29.224 4.502 34.119 6.531000000000001 37.798 10.213000000000001 C 41.477000000000004 13.896 43.502 18.79 43.5 23.994 C 43.496 34.735 34.754 43.474000000000004 24.014 43.474000000000004 C 20.825 43.473000000000006 17.669999999999998 42.68600000000001 14.87 41.197 L 4.994999999999999 43.786 C 4.953 43.798 4.911 43.803 4.868 43.803 z"
                                                            stroke-linecap="round" />
                                                    </g>
                                                    <g transform="matrix(1 0 0 1 -0.07 0.15)">
                                                        <path
                                                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(207,216,220); fill-rule: nonzero; opacity: 1;"
                                                            transform=" translate(-23.93, -24.15)"
                                                            d="M 24.014 5 C 29.093 5.002 33.859 6.979 37.444 10.565999999999999 C 41.028000000000006 14.154 43.002 18.921999999999997 43 23.994 C 42.996 34.459 34.478 42.974000000000004 24.014 42.974000000000004 L 24.006 42.974000000000004 C 20.829 42.973000000000006 17.706 42.176 14.933 40.663000000000004 L 4.868 43.303 L 7.562 33.467999999999996 C 5.9 30.59 5.026 27.324 5.027 23.979 C 5.032 13.514 13.548 5 24.014 5 M 24.014 42.974 C 24.014 42.974 24.014 42.974 24.014 42.974 C 24.014 42.974 24.014 42.974 24.014 42.974 M 24.014 42.974 C 24.014 42.974 24.014 42.974 24.014 42.974 C 24.014 42.974 24.014 42.974 24.014 42.974 M 24.014 4 C 24.014 4 24.014 4 24.014 4 C 12.998 4 4.032 12.962 4.027 23.979 C 4.026 27.346 4.876 30.663999999999998 6.4879999999999995 33.601 L 3.9029999999999996 43.04 C 3.8089999999999997 43.385 3.9049999999999994 43.753 4.157 44.007 C 4.347 44.199 4.604 44.303999999999995 4.868 44.303999999999995 C 4.953 44.303999999999995 5.038 44.29299999999999 5.122 44.270999999999994 L 14.809 41.730999999999995 C 17.637 43.199 20.807 43.974 24.006 43.974999999999994 C 35.03 43.974999999999994 43.995999999999995 35.01199999999999 44.001000000000005 23.994999999999994 C 44.00300000000001 18.65599999999999 41.926 13.635999999999994 38.153000000000006 9.859999999999994 C 34.378 6.083 29.357 4.002 24.014 4 L 24.014 4 z"
                                                            stroke-linecap="round" />
                                                    </g>
                                                    <g transform="matrix(1 0 0 1 0.01 -0.01)">
                                                        <path
                                                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(64,195,81); fill-rule: nonzero; opacity: 1;"
                                                            transform=" translate(-24.01, -23.99)"
                                                            d="M 35.176 12.832 C 32.196000000000005 9.850000000000001 28.235000000000003 8.207 24.019000000000002 8.206 C 15.315000000000001 8.206 8.236000000000002 15.282 8.232000000000001 23.979999999999997 C 8.231000000000002 26.961 9.065000000000001 29.862999999999996 10.645000000000001 32.376 L 11.021 32.973 L 9.426 38.794 L 15.399000000000001 37.227999999999994 L 15.976 37.56999999999999 C 18.398 39.007999999999996 21.176000000000002 39.767999999999994 24.008000000000003 39.76899999999999 L 24.014000000000003 39.76899999999999 C 32.712 39.76899999999999 39.791000000000004 32.69199999999999 39.794000000000004 23.99299999999999 C 39.795 19.778 38.156 15.814 35.176 12.832 z"
                                                            stroke-linecap="round" />
                                                    </g>
                                                    <g transform="matrix(1 0 0 1 0.01 0.16)">
                                                        <path
                                                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255,255,255); fill-rule: evenodd; opacity: 1;"
                                                            transform=" translate(-24.01, -24.16)"
                                                            d="M 19.268 16.045 C 18.913 15.255000000000003 18.539 15.239 18.2 15.225000000000001 C 17.923 15.213000000000001 17.607 15.214000000000002 17.291 15.214000000000002 C 16.975 15.214000000000002 16.461000000000002 15.333000000000002 16.026 15.808000000000002 C 15.591 16.283 14.365 17.430000000000003 14.365 19.764000000000003 C 14.365 22.098000000000003 16.065 24.354000000000003 16.302 24.67 C 16.538999999999998 24.986 19.584 29.929000000000002 24.406 31.831000000000003 C 28.412999999999997 33.411 29.229 33.097 30.098999999999997 33.018 C 30.968999999999998 32.939 32.906 31.871000000000002 33.300999999999995 30.763 C 33.696 29.655 33.696 28.706000000000003 33.577999999999996 28.508000000000003 C 33.458999999999996 28.310000000000002 33.142999999999994 28.192000000000004 32.669 27.954000000000004 C 32.195 27.716000000000005 29.862 26.569000000000003 29.426999999999996 26.411000000000005 C 28.991999999999997 26.253000000000004 28.675999999999995 26.174000000000007 28.358999999999995 26.649000000000004 C 28.042999999999996 27.123000000000005 27.133999999999993 28.192000000000004 26.856999999999996 28.508000000000003 C 26.579999999999995 28.825000000000003 26.302999999999997 28.865000000000002 25.828999999999997 28.627000000000002 C 25.354999999999997 28.389000000000003 23.826999999999998 27.889000000000003 22.013999999999996 26.273000000000003 C 20.603999999999996 25.016000000000002 19.651999999999994 23.463000000000005 19.374999999999996 22.988000000000003 C 19.097999999999995 22.514000000000003 19.344999999999995 22.257 19.582999999999995 22.020000000000003 C 19.795999999999996 21.807000000000002 20.056999999999995 21.466000000000005 20.294999999999995 21.189000000000004 C 20.531999999999993 20.912000000000003 20.610999999999994 20.714000000000002 20.768999999999995 20.398000000000003 C 20.926999999999996 20.081000000000003 20.847999999999995 19.804000000000002 20.728999999999996 19.567000000000004 C 20.612 19.329 19.69 16.983 19.268 16.045 z"
                                                            stroke-linecap="round" />
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>

                                        <span>{{ $p->user->number_phone }}</span>

                                    </a>
                                @else
                                    -
                                @endif

                            </td>

                            <td class="px-6 py-4">

                                @if ($p->user?->email)
                                    <a href="mailto:{{ $p->user->email }}"
                                        class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 hover:underline">

                                        <svg id='Gmail_24' width='24' height='24' viewBox='0 0 24 24'
                                            xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                                            <rect width='24' height='24' stroke='none' fill='#000000'
                                                opacity='0' />


                                            <g transform="matrix(0.42 0 0 0.42 12 12)">
                                                <g style="">
                                                    <g transform="matrix(1 0 0 1 0 0)">
                                                        <path
                                                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(224,224,224); fill-rule: nonzero; opacity: 1;"
                                                            transform=" translate(-24, -24)"
                                                            d="M 5.5 40.5 L 42.5 40.5 C 44.433 40.5 46 38.933 46 37 L 46 11 C 46 9.067 44.433 7.5 42.5 7.5 L 5.5 7.5 C 3.567 7.5 2 9.067 2 11 L 2 37 C 2 38.933 3.567 40.5 5.5 40.5 z"
                                                            stroke-linecap="round" />
                                                    </g>
                                                    <g transform="matrix(1 0 0 1 0 0)">
                                                        <path
                                                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(217,217,217); fill-rule: nonzero; opacity: 1;"
                                                            transform=" translate(-24, -24)"
                                                            d="M 26 40.5 L 42.5 40.5 C 44.433 40.5 46 38.933 46 37 L 46 11 C 46 9.067 44.433 7.5 42.5 7.5 L 5.5 7.5 C 3.567 7.5 2 9.067 2 11 L 26 40.5 z"
                                                            stroke-linecap="round" />
                                                    </g>
                                                    <g transform="matrix(1 0 0 1 2.37 2)">
                                                        <path
                                                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(238,238,238); fill-rule: nonzero; opacity: 1;"
                                                            transform=" translate(-26.37, -26)"
                                                            d="M 6.745 40.5 L 42.5 40.5 C 44.433 40.5 46 38.933 46 37 L 46 11.5 L 6.745 40.5 z"
                                                            stroke-linecap="round" />
                                                    </g>
                                                    <g transform="matrix(1 0 0 1 8.39 2)">
                                                        <path
                                                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(224,224,224); fill-rule: nonzero; opacity: 1;"
                                                            transform=" translate(-32.39, -26)"
                                                            d="M 25.745 40.5 L 42.5 40.5 C 44.433 40.5 46 38.933 46 37 L 46 11.5 L 18.771 31.616 L 25.745 40.5 z"
                                                            stroke-linecap="round" />
                                                    </g>
                                                    <g transform="matrix(1 0 0 1 0 0.98)">
                                                        <path
                                                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(202,55,55); fill-rule: nonzero; opacity: 1;"
                                                            transform=" translate(-24, -24.98)"
                                                            d="M 42.5 9.5 L 5.5 9.5 C 3.567 9.5 2 9.067 2 11 L 2 37 C 2 38.933 3.567 40.5 5.5 40.5 L 7 40.5 L 7 12 L 41 12 L 41 40.5 L 42.5 40.5 C 44.433 40.5 46 38.933 46 37 L 46 11 C 46 9.067 44.433 9.5 42.5 9.5 z"
                                                            stroke-linecap="round" />
                                                    </g>
                                                    <g transform="matrix(1 0 0 1 0 -6.37)">
                                                        <path
                                                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(245,245,245); fill-rule: nonzero; opacity: 1;"
                                                            transform=" translate(-24, -17.63)"
                                                            d="M 42.5 7.5 L 24 7.5 L 5.5 7.5 C 3.567 7.5 2 9.036 2 11 C 2 12.206 3.518 13.258 3.518 13.258 L 24 27.756 L 44.482 13.259 C 44.482 13.259 46 12.206 46 11.001000000000001 C 46 9.036 44.433 7.5 42.5 7.5 z"
                                                            stroke-linecap="round" />
                                                    </g>
                                                    <g transform="matrix(1 0 0 1 0 -6.33)">
                                                        <path
                                                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(232,79,75); fill-rule: nonzero; opacity: 1;"
                                                            transform=" translate(-24, -17.67)"
                                                            d="M 43.246 7.582 L 24 21 L 4.754 7.582 C 3.18 7.919 2 9.297 2 11 C 2 12.206 3.518 13.258 3.518 13.258 L 24 27.756 L 44.482 13.259 C 44.482 13.259 46 12.206 46 11.001000000000001 C 46 9.297 44.82 7.919 43.246 7.582 z"
                                                            stroke-linecap="round" />
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>

                                        <span>{{ $p->user->email }}</span>

                                    </a>
                                @else
                                    -
                                @endif

                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2 whitespace-nowrap">

                                    <a href="{{ route('admin.penghuni.show', $p) }}"
                                        class="rounded-xl bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-600 transition hover:bg-blue-600 hover:text-white">
                                        Detail
                                    </a>

                                    <a href="{{ route('admin.penghuni.edit', $p) }}"
                                        class="rounded-xl bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-600 transition hover:bg-amber-500 hover:text-white">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.penghuni.destroy', $p) }}" method="POST"
                                        class="form-delete inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="rounded-xl bg-red-50 px-4 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-600 hover:text-white">
                                            Hapus
                                        </button>

                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-16 text-center text-slate-500 font-semibold">
                                Belum ada data penghuni.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>



        </div>
        <div class="border-t border-slate-200  px-6 py-4">
            <x-ui.pagination :paginator="$penghunis" />
        </div>

    </div>
@endsection
