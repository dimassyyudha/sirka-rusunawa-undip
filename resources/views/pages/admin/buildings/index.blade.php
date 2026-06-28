@extends('layouts.app')

@section('title', 'Data Gedung')
@section('page_title', 'Data Gedung')

@section('content')
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900">Manajemen Gedung</h2>
                <p class="text-sm text-slate-500 mt-1">Kelola data gedung Rusunawa UNDIP</p>
            </div>

            <x-button.button-menu type="button" variant="primary" size="lg" href="{{ route('admin.buildings.create') }}">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>

                Tambah Gedung
            </x-button.button-menu>
        </div>
        <form id="filterForm" method="GET" class="mb-6 rounded-[20px] border border-slate-200 bg-white p-5 shadow-sm">

            <div class="grid gap-4 lg:grid-cols-5">

                {{-- SEARCH --}}
                <div class="lg:col-span-2">
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Pencarian
                    </label>

                    <input id="searchInput" type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari kode atau nama gedung..."
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">
                </div>

                {{-- GENDER --}}
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Tipe Penghuni
                    </label>

                    <select name="gender_type"
                        class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                        <option value="">Semua</option>

                        <option value="laki-laki" @selected(request('gender_type') == 'laki-laki')>
                            Laki-Laki
                        </option>

                        <option value="perempuan" @selected(request('gender_type') == 'perempuan')>
                            Perempuan
                        </option>

                    </select>
                </div>

                {{-- STATUS --}}
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Status
                    </label>

                    <select name="is_active"
                        class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                        <option value="">Semua</option>

                        <option value="1" @selected(request('is_active') === '1')>
                            Aktif
                        </option>

                        <option value="0" @selected(request('is_active') === '0')>
                            Nonaktif
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

                        <a href="{{ route('admin.buildings.index') }}"
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
                        <th class="px-6 py-4 font-black">Kode</th>
                        <th class="px-6 py-4 font-black">Nama Gedung</th>
                        <th class="px-6 py-4 font-black">Tipe</th>
                        <th class="px-6 py-4 font-black">Lantai</th>
                        <th class="px-6 py-4 font-black">Status</th>
                        <th class="px-6 py-4 font-black">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 text-center whitespace-nowrap">
                    @forelse ($buildings as $building)
                        <tr class="bg-white hover:bg-slate-50 transition text-center">
                            <td class="px-6 py-4 font-semibold">
                                {{ method_exists($buildings, 'firstItem') ? $buildings->firstItem() + $loop->index : $loop->iteration }}
                            </td>

                            <td class="px-6 py-4 font-black text-[#070B55]">
                                {{ $building->code }}
                            </td>

                            <td class="px-6 py-4 font-bold text-slate-900">
                                {{ $building->name }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($building->gender_type === 'laki-laki')
                                    <x-ui.badge type="Laki-Laki" label="Laki-Laki" />
                                @else
                                    <x-ui.badge type="perempuan" label="Perempuan" />
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center font-bold">
                                {{ $building->total_floors }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if ($building->is_active)
                                    <x-ui.badge type="success" label="Aktif" />
                                @else
                                    <x-ui.badge type="danger" label="Nonaktif" />
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2 whitespace-nowrap">

                                    <a href="{{ route('admin.buildings.show', $building) }}"
                                        class="rounded-xl bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-600 transition hover:bg-blue-600 hover:text-white">
                                        Detail
                                    </a>

                                    <a href="{{ route('admin.buildings.edit', $building) }}"
                                        class="rounded-xl bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-600 transition hover:bg-amber-500 hover:text-white">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.buildings.destroy', $building) }}" method="POST"
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
                            <td colspan="8" class="px-6 py-12 text-center text-slate-500 font-semibold">
                                Belum ada data gedung.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>


        </div>
        <div class="border-t border-slate-200  px-6 py-4">
            <x-ui.pagination :paginator="$buildings" />
        </div>
    </div>

@endsection
