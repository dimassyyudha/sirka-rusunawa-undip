@extends('layouts.app')

@section('title', 'Manajemen Kamar')
@section('page_title', 'Manajemen Kamar')

@section('content')
    <div class="space-y-6">


        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900">Manajemen Kamar</h2>
                <p class="text-sm text-slate-500 mt-1">Kelola data kamar Rusunawa berdasarkan gedung, lantai, kapasitas, dan
                    status kamar.</p>
            </div>

            <x-button.button-menu type="button" variant="primary" size="lg" href="{{ route('admin.rooms.create') }}">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>

                Tambah Kamar
            </x-button.button-menu>
        </div>
        <form id="filterForm" method="GET" class="mb-6 rounded-[20px] border border-slate-200 bg-white p-5 shadow-sm">

            <div class="grid gap-4 lg:grid-cols-5">

                {{-- SEARCH --}}
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Pencarian
                    </label>

                    <input id="searchInput" type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari kode kamar..."
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-violet-500 focus:outline-none focus:ring-4 focus:ring-violet-100">
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

                {{-- LANTAI --}}
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Lantai
                    </label>

                    <select name="floor_id" class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                        <option value="">Semua Lantai</option>

                        @foreach ($floors as $floor)
                            <option value="{{ $floor->id }}" @selected(request('floor_id') == $floor->id)>

                                {{ $floor->building->name }}
                                - Lantai {{ $floor->floor_number }}

                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- STATUS --}}
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Status
                    </label>

                    <select name="status" class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                        <option value="">Semua Status</option>

                        <option value="tersedia" @selected(request('status') == 'tersedia')>
                            Tersedia
                        </option>

                        <option value="penuh" @selected(request('status') == 'penuh')>
                            Penuh
                        </option>

                        <option value="maintenance" @selected(request('status') == 'maintenance')>
                            Maintenance
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

                        <a href="{{ route('admin.rooms.index') }}"
                            class="flex-1 rounded-xl border border-slate-300 px-4 py-3 text-center text-sm font-bold text-slate-700 hover:bg-slate-50">

                            Reset

                        </a>

                    </div>

                </div>

            </div>

        </form>


        @if (session('success'))
            <div
                class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">
                {{ session('success') }}
            </div>
        @endif


        <div class="relative overflow-x-auto bg-white shadow-sm rounded-[10px] border border-slate-200">

            <table class="w-full min-w-[1300px] text-sm text-left text-slate-700">
                <thead class="text-xs uppercase bg-slate-50 border-b border-slate-200 text-slate-500 text-center">
                    <tr class="text-center">
                        <th class="px-6 py-4 font-black">No</th>
                        <th class="px-6 py-4 font-black">Kode Kamar</th>
                        <th class="px-6 py-4 font-black">Gedung</th>
                        <th class="px-6 py-4 font-black text-center">Lantai</th>
                        <th class="px-6 py-4 font-black">Roommate</th>
                        <th class="px-6 py-4 font-black text-center">Kapasitas</th>
                        <th class="px-6 py-4 font-black text-center">Terisi</th>
                        <th class="px-6 py-4 font-black text-center">Status</th>
                        <th class="px-6 py-4 font-black text-right">Harga/Bulan</th>
                        <th class="px-6 py-4 font-black text-right">Fasilitas</th>
                        <th class="px-6 py-4 font-black text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 text-center whitespace-nowrap">
                    @forelse ($rooms as $room)
                        @php
                            $capacity = (int) ($room->floor->room_capacity ?? 0);
                            $occupied = $room->occupants()->where('status', 'active')->count();
                            $available = max(0, $capacity - $occupied);
                            $status = strtolower($room->status ?? 'tersedia');
                        @endphp

                        <tr class="bg-white hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-semibold">
                                {{ method_exists($rooms, 'firstItem') ? $rooms->firstItem() + $loop->index : $loop->iteration }}
                            </td>

                            <td class="px-4 py-4 w-[120px]">
                                <div class="font-black text-slate-900">{{ $room->kode_kamar }}</div>

                            </td>

                            <td class="px-4 py-4 w-[140px] font-bold">
                                {{ $room->floor->building->name ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-flex px-3 py-1.5 rounded-full bg-blue-50 text-blue-600 text-xs font-black">
                                    Lantai {{ $room->floor->floor_number ?? '-' }}
                                </span>
                            </td>

                            <td class="px-4 py-4 min-w-[180px]">
                                @forelse ($room->penghuni as $penghuni)
                                    <div class="text-xs font-semibold text-slate-700">
                                        {{ $penghuni->user->name ?? '-' }}
                                        <span class="text-slate-400"> - {{ $penghuni->angkatan }}
                                        </span>
                                    </div>
                                @empty
                                    <span class="text-xs text-slate-400">Belum ada penghuni</span>
                                @endforelse
                            </td>

                            <td class="px-6 py-4 text-center font-bold">
                                {{ $room->display_capacity }} orang
                            </td>

                            <td class="px-6 py-4 text-center font-bold">
                                {{ $room->display_occupied }} orang
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if ($status === 'maintenance')
                                    <span
                                        class="inline-flex px-3 py-1.5 rounded-full bg-slate-100 text-slate-600 text-xs font-black">
                                        Maintenance
                                    </span>
                                @elseif ($status === 'penuh' || $available <= 0)
                                    <span
                                        class="inline-flex px-3 py-1.5 rounded-full bg-red-50 text-red-600 text-xs font-black">
                                        Penuh
                                    </span>
                                @else
                                    @if ($room->display_status === 'penuh')
                                        <span
                                            class="inline-flex items-center rounded-full
    bg-red-100 text-red-700 px-3 py-1 text-xs font-bold">
                                            Penuh
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-full
    bg-emerald-100 text-emerald-700 px-3 py-1 text-xs font-bold">
                                            Tersedia {{ $room->display_slot }} slot
                                        </span>
                                    @endif
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right font-black text-slate-900">
                                Rp {{ number_format((int) ($room->floor->monthly_price ?? 0), 0, ',', '.') }}
                            </td>
                            <td class="text-xs text-slate-400 mt-1">
                                {{ $room->fasilitas ? Str::limit($room->fasilitas, 35) : '-' }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2 whitespace-nowrap">

                                    <a href="{{ route('admin.rooms.show', $room) }}"
                                        class="rounded-xl bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-600 transition hover:bg-blue-600 hover:text-white">
                                        Detail
                                    </a>

                                    <a href="{{ route('admin.rooms.edit', $room) }}"
                                        class="rounded-xl bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-600 transition hover:bg-amber-500 hover:text-white">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST"
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
                            <td colspan="9" class="px-6 py-16 text-center text-slate-500 font-semibold">
                                Belum ada data kamar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- </div> --}}

        </div>
        <div class="border-t border-slate-200  px-6 py-4">
            <x-ui.pagination :paginator="$rooms" />
        </div>
    @endsection
