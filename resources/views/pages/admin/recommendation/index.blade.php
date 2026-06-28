@extends('layouts.app')

@section('title', 'Rekomendasi Kamar')
@section('page_title', 'Rekomendasi Kamar')

@section('content')

    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <div>

                <h1 class="text-3xl font-black text-slate-900">
                    Rekomendasi Kamar
                </h1>

                <p class="mt-2 text-slate-500">
                    Kelola daftar kamar rekomendasi yang ditampilkan pada halaman beranda website.
                </p>

            </div>

            <x-button.button-menu type="button" variant="primary" size="lg"
                href="{{ route('admin.settings.recommendation.create') }}">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>

                Tambah Rekomendasi
            </x-button.button-menu>

        </div>

        {{-- STATISTIC --}}
        <div class="grid gap-4 md:grid-cols-3">

            <div class="rounded-[10px] border border-slate-200 bg-white p-6 shadow-sm">

                <p class="text-sm text-slate-500">
                    Total Rekomendasi
                </p>

                <h3 class="mt-2 text-3xl font-black text-slate-900">
                    {{ $items->count() }}
                </h3>

            </div>

            <div class="rounded-[10px] border border-slate-200 bg-white p-6 shadow-sm">

                <p class="text-sm text-slate-500">
                    Rekomendasi Aktif
                </p>

                <h3 class="mt-2 text-3xl font-black text-green-600">
                    {{ $items->where('is_active', true)->count() }}
                </h3>

            </div>

            <div class="rounded-[10px] border border-slate-200 bg-white p-6 shadow-sm">

                <p class="text-sm text-slate-500">
                    Rekomendasi Nonaktif
                </p>

                <h3 class="mt-2 text-3xl font-black text-red-600">
                    {{ $items->where('is_active', false)->count() }}
                </h3>

            </div>

        </div>

        {{-- TABLE --}}
        <div class="overflow-hidden rounded-[10px] border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="w-full min-w-[1100px] text-sm">

                    <thead class="border-b border-slate-200 bg-slate-50">

                        <tr>

                            <th class="px-6 py-4 text-center font-black text-slate-700">
                                Urutan
                            </th>

                            <th class="px-6 py-4 text-left font-black text-slate-700">
                                Kamar
                            </th>

                            <th class="px-6 py-4 text-center font-black text-slate-700">
                                Gedung
                            </th>

                            <th class="px-6 py-4 text-center font-black text-slate-700">
                                Lantai
                            </th>

                            <th class="px-6 py-4 text-center font-black text-slate-700">
                                Harga
                            </th>

                            <th class="px-6 py-4 text-center font-black text-slate-700">
                                Status Kamar
                            </th>

                            <th class="px-6 py-4 text-center font-black text-slate-700">
                                Status Tampil
                            </th>

                            <th class="px-6 py-4 text-center font-black text-slate-700">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100 bg-white">

                        @forelse ($items as $item)
                            @php
                                $room = $item->room;
                                $floor = $room?->floor;
                                $building = $floor?->building;

                                $gedung = $building ? str_replace('Gedung ', '', $building->name) : '-';

                                $lantai = $floor?->floor_number ?? '-';

                                $harga = (int) ($floor?->monthly_price ?? 0);
                            @endphp

                            <tr class="transition hover:bg-slate-50">

                                <td class="px-6 py-5 text-center font-black text-slate-900">
                                    {{ $item->sort_order }}
                                </td>

                                <td class="px-6 py-5">

                                    <div class="font-black text-[#070B55]">

                                        {{ $room?->kode_kamar ?? '-' }}

                                    </div>

                                </td>

                                <td class="px-6 py-5 text-center text-slate-700">

                                    {{ $gedung }}

                                </td>

                                <td class="px-6 py-5 text-center text-slate-700">

                                    Lantai {{ $lantai }}

                                </td>

                                <td class="px-6 py-5 text-center font-black text-orange-600">

                                    Rp {{ number_format($harga, 0, ',', '.') }}

                                </td>

                                <td class="px-6 py-5 text-center">

                                    @if (!$room)
                                        <span
                                            class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700">

                                            Data Hilang

                                        </span>
                                    @elseif($room->status === 'tersedia')
                                        <span
                                            class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-700">

                                            Tersedia

                                        </span>
                                    @elseif($room->status === 'penuh')
                                        <span
                                            class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-red-700">

                                            Penuh

                                        </span>
                                    @else
                                        <span
                                            class="inline-flex rounded-full bg-yellow-50 px-3 py-1 text-xs font-bold text-yellow-700">

                                            Maintenance

                                        </span>
                                    @endif

                                </td>

                                <td class="px-6 py-5 text-center">

                                    @if ($item->is_active)
                                        <span
                                            class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-700">

                                            Aktif

                                        </span>
                                    @else
                                        <span
                                            class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700">

                                            Nonaktif

                                        </span>
                                    @endif

                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex items-center justify-center gap-2 whitespace-nowrap">

                                        <a href="{{ route('admin.settings.recommendation.edit', $item->id) }}"
                                            class="rounded-xl bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-600 transition hover:bg-amber-500 hover:text-white">

                                            Edit

                                        </a>

                                        <form action="{{ route('admin.settings.recommendation.destroy', $item->id) }}"
                                            method="POST" class="form-delete inline">

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

                                <td colspan="8" class="px-6 py-16 text-center text-slate-500">

                                    Belum ada data rekomendasi kamar.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection
