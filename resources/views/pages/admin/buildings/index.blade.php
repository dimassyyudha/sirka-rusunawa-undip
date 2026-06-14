@extends('layouts.app')

@section('title', 'Data Gedung')
@section('page_title', 'Data Gedung')

@section('content')
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900">Data Gedung</h2>
                <p class="text-sm text-slate-500 mt-1">Kelola data gedung Rusunawa UNDIP</p>
            </div>

            <x-button.button-menu type="button" variant="primary" size="lg" href="{{ route('admin.buildings.create') }}">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>

                Tambah Gedung
            </x-button.button-menu>
        </div>

        <div class="relative overflow-x-auto bg-white shadow-sm rounded-[28px] border border-slate-200">
            <table class="w-full text-sm text-center text-black">
                <thead class="text-xs uppercase bg-slate-50 border-b border-slate-200 text-black text-center">
                    <tr>
                        <th class="px-6 py-4 font-black">No</th>
                        <th class="px-6 py-4 font-black">Kode</th>
                        <th class="px-6 py-4 font-black">Nama Gedung</th>
                        <th class="px-6 py-4 font-black">Tipe</th>
                        <th class="px-6 py-4 font-black">Lantai</th>
                        <th class="px-6 py-4 font-black">Kamar</th>
                        <th class="px-6 py-4 font-black">Status</th>
                        <th class="px-6 py-4 font-black">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
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
                                @if ($building->gender_type === 'putra')
                                    <x-ui.badge type="putra" label="Putra" />
                                @else
                                    <x-ui.badge type="putri" label="Putri" />
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center font-bold">
                                {{ $building->total_floors }}
                            </td>

                            <td class="px-6 py-4 text-center font-bold">
                                {{ $building->rooms_count ?? 0 }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if ($building->is_active)
                                    <x-ui.badge type="success" label="Aktif" />
                                @else
                                    <x-ui.badge type="danger" label="Nonaktif" />
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.buildings.show', $building) }}"
                                        class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </a>

                                    <a href="{{ route('admin.buildings.edit', $building) }}"
                                        class="w-10 h-10 rounded-full bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white flex items-center justify-center transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.651 1.651M4 20h4.586a1 1 0 00.707-.293l9.414-9.414a2 2 0 000-2.828l-2.172-2.172a2 2 0 00-2.828 0L4.293 14.707A1 1 0 004 15.414V20z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.buildings.destroy', $building) }}" method="POST"
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
                            <td colspan="8" class="px-6 py-12 text-center text-slate-500 font-semibold">
                                Belum ada data gedung.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="border-t border-slate-200 bg-white px-6 py-4">
                <x-ui.pagination :paginator="$buildings" />
            </div>

        </div>
    </div>

@endsection
