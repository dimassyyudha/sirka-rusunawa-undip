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

            <x-button.button-menu href="{{ route('admin.penghuni.create') }}" variant="primary" size="md">
                Tambah Penghuni
            </x-button.button-menu>
        </div>

        @if (session('success'))
            <div
                class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-[28px] border border-slate-200 p-5">
            <form action="{{ route('admin.penghuni.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div>
                    <label class="block mb-2.5 text-sm font-medium text-heading">Gedung</label>
                    <select name="building_id"
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 bg-white text-sm font-semibold text-slate-700 focus:ring-4 focus:ring-violet-200 focus:border-violet-500 focus:outline-none">
                        <option value="">Semua Gedung</option>
                        @foreach ($buildings as $building)
                            <option value="{{ $building->id }}" @selected(request('building_id') == $building->id)>
                                {{ $building->name }}
                            </option>
                        @endforeach
                    </select>
                </div>



                <div class="flex items-end gap-2">
                    <x-button.button-menu type="submit" variant="primary" size="md">
                        Filter
                    </x-button.button-menu>

                    <x-button.button-menu href="{{ route('admin.penghuni.index') }}" variant="outline" size="md">
                        Reset
                    </x-button.button-menu>
                </div>
            </form>
        </div>

        <div class="relative overflow-x-auto bg-white shadow-sm rounded-[28px] border border-slate-200">

            <table class="w-full min-w-[1300px] text-sm text-left text-slate-700">
                <thead class="text-xs uppercase bg-slate-50 border-b border-slate-200 text-slate-500">
                    <tr>
                        <th class="px-6 py-4 font-black">No</th>
                        <th class="px-6 py-4 font-black">Nama</th>
                        <th class="px-6 py-4 font-black">NIM</th>
                        <th class="px-6 py-4 font-black">Jurusan</th>
                        <th class="px-6 py-4 font-black text-center">Angkatan</th>
                        <th class="px-6 py-4 font-black text-center">Status</th>
                        <th class="px-6 py-4 font-black">Kamar</th>
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

                <tbody class="divide-y divide-slate-100">
                    @forelse ($penghunis as $p)
                        <tr class="bg-white hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-semibold">
                                {{ method_exists($penghunis, 'firstItem') ? $penghunis->firstItem() + $loop->index : $loop->iteration }}
                            </td>

                            <td class="px-6 py-4">
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

                            <td class="px-6 py-4">
                                @if ($p->room)
                                    <div class="font-black text-slate-900">{{ $p->room->kode_kamar }}</div>
                                    <div class="text-xs text-slate-500 mt-1">
                                        {{ $p->room->floor->building->name ?? '-' }} - Lantai
                                        {{ $p->room->floor->floor_number ?? '-' }}
                                    </div>
                                @else
                                    <span class="text-slate-400 font-semibold">Belum ada kamar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">

                                {{-- @php
                                    $reservation = $p->user->reservations
                                        // ->where('status', 'active')
                                        ->whereIn('status', ['approved', 'active'])
                                        ->sortByDesc('created_at')
                                        ->first();
                                @endphp --}}

                                {{-- @if ($p->occupancy_type_label === 'private')
                                    Private
                                @elseif ($p->occupancy_type_label === 'shared')
                                    Shared
                                @else
                                    <span
                                        class="inline-flex px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-black">
                                        -
                                    </span>
                                @endif --}}
                                @if ($p?->occupancy_type_label === 'private')
                                    <span
                                        class="inline-flex px-3 py-1 rounded-full bg-violet-100 text-violet-700 text-xs font-black">
                                        Private
                                    </span>
                                @elseif ($p?->occupancy_type_label === 'shared')
                                    <span
                                        class="inline-flex px-3 py-1 rounded-full bg-sky-100 text-sky-700 text-xs font-black">
                                        Shared
                                    </span>
                                @else
                                    <span
                                        class="inline-flex px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-black">
                                        -
                                    </span>
                                @endif

                            </td>
                            <td class="px-6 py-4 text-center">

                                @if ($p->lease_start_date && $p->lease_end_date)
                                    <div class="font-bold text-slate-900">
                                        {{ \Carbon\Carbon::parse($p->lease_start_date)->format('d M Y') }}
                                    </div>

                                    <div class="text-xs text-slate-500">
                                        s/d
                                        {{ \Carbon\Carbon::parse($p->lease_end_date)->format('d M Y') }}
                                    </div>
                                @else
                                    <span class="text-slate-400">
                                        -
                                    </span>
                                @endif

                            </td>
                            <td class="px-6 py-4">{{ $p->alamat }}</td>
                            <td class="px-6 py-4">{{ $p->user->number_phone ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $p->user->email ?? '-' }}</td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.penghuni.show', $p) }}"
                                        class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </a>

                                    <a href="{{ route('admin.penghuni.edit', $p) }}"
                                        class="w-10 h-10 rounded-full bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white flex items-center justify-center transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.651 1.651M4 20h4.586a1 1 0 00.707-.293l9.414-9.414a2 2 0 000-2.828l-2.172-2.172a2 2 0 00-2.828 0L4.293 14.707A1 1 0 004 15.414V20z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.penghuni.destroy', $p) }}" method="POST"
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
                            <td colspan="10" class="px-6 py-16 text-center text-slate-500 font-semibold">
                                Belum ada data penghuni.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="border-t border-slate-200 bg-white px-6 py-4">
                <x-ui.pagination :paginator="$penghunis" />
            </div>

        </div>

    </div>
@endsection
