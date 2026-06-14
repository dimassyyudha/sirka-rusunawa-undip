@extends('layouts.app')

@section('title', 'Manajemen Kamar')
@section('page_title', 'Manajemen Kamar')

@section('content')
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900">Manajemen Kamar</h2>
                <p class="text-sm text-slate-500 mt-1">
                    Kelola data kamar Rusunawa berdasarkan gedung, lantai, kapasitas, dan status kamar.
                </p>
            </div>

            <x-button.button-menu href="{{ route('admin.rooms.create') }}" variant="primary" size="md">
                Tambah Kamar
            </x-button.button-menu>
        </div>

        @if (session('success'))
            <div
                class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-[28px] border border-slate-200 p-5">
            <form action="{{ route('admin.rooms.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <div>
                    <label class="text-xs font-black text-slate-500 uppercase">Gedung</label>
                    <select name="building_id"
                        class="mt-2 w-full rounded-2xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Semua Gedung</option>
                        @foreach ($buildings as $building)
                            <option value="{{ $building->id }}" @selected(request('building_id') == $building->id)>
                                {{ $building->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-xs font-black text-slate-500 uppercase">Status</label>
                    <select name="status"
                        class="mt-2 w-full rounded-2xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Semua Status</option>
                        <option value="tersedia" @selected(request('status') == 'tersedia')>Tersedia</option>
                        <option value="penuh" @selected(request('status') == 'penuh')>Penuh</option>
                        <option value="maintenance" @selected(request('status') == 'maintenance')>Maintenance</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="h-11 px-5 rounded-2xl bg-blue-600 text-white text-sm font-black hover:bg-blue-700 transition">
                        Filter
                    </button>

                    <a href="{{ route('admin.rooms.index') }}"
                        class="h-11 px-5 rounded-2xl bg-slate-100 text-slate-700 text-sm font-black hover:bg-slate-200 transition flex items-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="relative overflow-x-auto bg-white shadow-sm rounded-[28px] border border-slate-200">

            <table class="w-full text-sm text-left text-black">
                <thead class="text-xs uppercase bg-slate-50 border-b border-slate-200 text-black whitespace-nowrap">
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

                <tbody class="divide-y divide-slate-100 text-center">
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
                                {{ $capacity }} orang
                            </td>

                            <td class="px-6 py-4 text-center font-bold">
                                {{ $occupied }} orang
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
                                    <span
                                        class="inline-flex px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-600 text-xs font-black">
                                        Tersedia {{ $available }} slot
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right font-black text-slate-900">
                                Rp {{ number_format((int) ($room->floor->monthly_price ?? 0), 0, ',', '.') }}
                            </td>
                            <td class="text-xs text-slate-400 mt-1">
                                {{ $room->fasilitas ? Str::limit($room->fasilitas, 35) : '-' }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.rooms.show', $room) }}"
                                        class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </a>

                                    <a href="{{ route('admin.rooms.edit', $room) }}"
                                        class="w-10 h-10 rounded-full bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white flex items-center justify-center transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.651 1.651M4 20h4.586a1 1 0 00.707-.293l9.414-9.414a2 2 0 000-2.828l-2.172-2.172a2 2 0 00-2.828 0L4.293 14.707A1 1 0 004 15.414V20z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST"
                                        class="form-delete">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="w-10 h-10 rounded-full bg-red-50 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4" />
                                            </svg>
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

            <div class="border-t border-slate-200 bg-white px-6 py-4">
                <x-ui.pagination :paginator="$rooms" />
            </div>
        </div>
    </div>
@endsection
