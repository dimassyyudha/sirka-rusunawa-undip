@extends('layouts.app')

@section('title', 'Manajemen Lantai')
@section('page_title', 'Manajemen Lantai')

@section('content')
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900">
                    Manajemen Lantai
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Kelola data lantai tiap gedung Rusunawa
                </p>
            </div>

            <x-button.button-menu href="{{ route('admin.floors.create') }}" type="button" variant="primary" size="lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Lantai

            </x-button.button-menu>
        </div>
        <form id="filterForm" method="GET" class="mb-6 rounded-[20px] border border-slate-200 bg-white p-5 shadow-sm">

            <div class="grid gap-4 lg:grid-cols-4">

                {{-- SEARCH --}}
                <div class="lg:col-span-2">
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Pencarian
                    </label>

                    <input id="searchInput" type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nomor lantai..."
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

                {{-- ACTION --}}
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-transparent">
                        Action
                    </label>

                    <div class="flex gap-2">

                        <button type="submit"
                            class="flex-1 rounded-xl bg-violet-600 px-4 py-3 text-sm font-bold text-white hover:bg-violet-700">

                            Filter

                        </button>

                        <a href="{{ route('admin.floors.index') }}"
                            class="flex-1 rounded-xl border border-slate-300 px-4 py-3 text-center text-sm font-bold text-slate-700 hover:bg-slate-50">

                            Reset

                        </a>

                    </div>
                </div>

            </div>

        </form>
        <div class="relative overflow-x-auto bg-white shadow-sm  rounded-[10px] border border-slate-200">

            <table class="w-full min-w-[1300px] text-sm text-left text-slate-700">
                <thead class="text-xs uppercase bg-slate-50 border-b border-slate-200 text-slate-500 text-center">
                    <tr>
                        <th class="px-6 py-4 font-black">No</th>
                        <th class="px-6 py-4 font-black">Gedung</th>
                        <th class="px-6 py-4 font-black">Lantai</th>
                        <th class="px-6 py-4 font-black text-center">Total Kamar</th>
                        <th class="px-6 py-4 font-black text-right">Harga/Bulan</th>
                        <th class="px-6 py-4 font-black text-center">Kapasitas</th>
                        <th class="px-6 py-4 font-black text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 text-center whitespace-nowrap">

                    @forelse ($floors as $floor)
                        <tr class="bg-white hover:bg-slate-50 transition">

                            <td class="px-6 py-4 font-semibold text-slate-700">
                                {{ method_exists($floors, 'firstItem') ? $floors->firstItem() + $loop->index : $loop->iteration }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-black text-slate-900">
                                    {{ $floor->building->name ?? '-' }}
                                </div>

                            </td>

                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-full bg-blue-50 text-blue-600 text-xs font-black">
                                    Lantai {{ $floor->floor_number }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center font-bold text-slate-700">
                                {{ $floor->total_rooms }}
                            </td>

                            <td class="px-6 py-4 text-right font-bold text-slate-900">
                                Rp {{ number_format($floor->monthly_price, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-600 text-xs font-black">
                                    {{ $floor->room_capacity }} orang
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2 whitespace-nowrap">

                                    <a href="{{ route('admin.floors.show', $floor) }}"
                                        class="rounded-xl bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-600 transition hover:bg-blue-600 hover:text-white">
                                        Detail
                                    </a>

                                    <a href="{{ route('admin.floors.edit', $floor) }}"
                                        class="rounded-xl bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-600 transition hover:bg-amber-500 hover:text-white">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.floors.destroy', $floor) }}" method="POST"
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
                            <td colspan="7" class="px-6 py-16 text-center text-slate-500 font-semibold">
                                Belum ada data lantai.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>


        </div>
        <div class="border-t border-slate-200 px-6 py-4">
            <x-ui.pagination :paginator="$floors" />
        </div>

    </div>
@endsection
