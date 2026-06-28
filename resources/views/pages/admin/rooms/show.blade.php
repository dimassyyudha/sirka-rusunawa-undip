@extends('layouts.app')

@section('title', 'Detail Kamar')
@section('page_title', 'Detail Kamar')

@section('content')
    @php
        $capacity = (int) ($room->floor->room_capacity ?? 0);
        $occupied = (int) ($room->occupied ?? 0);
        $available = max(0, $capacity - $occupied);
        $status = strtolower($room->status ?? 'tersedia');
    @endphp

    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900">Detail Kamar</h2>
                <p class="text-sm text-slate-500 mt-1">
                    Informasi lengkap kamar {{ $room->kode_kamar }}.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <x-button.button-menu href="{{ route('admin.rooms.edit', $room) }}" variant="warning">
                    Edit Kamar
                </x-button.button-menu>

                <x-button.button-menu href="{{ route('admin.rooms.index') }}" variant="secondary">
                    Kembali
                </x-button.button-menu>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 bg-white rounded-[10px] border border-slate-200 shadow-sm p-6">
                <h3 class="text-lg font-black text-slate-900 mb-5">Informasi Kamar</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase">Kode Kamar</p>
                        <p class="mt-1 text-base font-black text-slate-900">{{ $room->kode_kamar }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase">Gedung</p>
                        <p class="mt-1 text-base font-bold text-slate-800">
                            {{ $room->floor->building->name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase">Lantai</p>
                        <p class="mt-1 text-base font-bold text-slate-800">
                            Lantai {{ $room->floor->floor_number ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase">Harga/Bulan</p>
                        <p class="mt-1 text-base font-black text-slate-900">
                            Rp {{ number_format((int) ($room->floor->monthly_price ?? 0), 0, ',', '.') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase">Kapasitas</p>
                        <p class="mt-1 text-base font-bold text-slate-800">{{ $capacity }} orang</p>
                    </div>

                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase">Terisi</p>
                        <p class="mt-1 text-base font-bold text-slate-800">{{ $occupied }} orang</p>
                    </div>

                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase">Sisa Slot</p>
                        <p class="mt-1 text-base font-bold text-slate-800">{{ $available }} slot</p>
                    </div>

                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase">Status</p>
                        <div class="mt-2">
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
                                    Tersedia
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm p-6">
                <h3 class="text-lg font-black text-slate-900 mb-5">Fasilitas</h3>

                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4 min-h-[160px]">
                    <p class="text-sm leading-7 text-slate-700 font-medium whitespace-pre-line">
                        {{ $room->fasilitas ?: '-' }}
                    </p>
                </div>
            </div>

        </div>

        <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
                <div>
                    <h3 class="text-lg font-black text-slate-900">
                        Penghuni Kamar Saat Ini
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Daftar mahasiswa aktif yang sedang menempati kamar ini.
                    </p>
                </div>

                <span class="inline-flex w-fit px-3 py-1.5 rounded-full bg-blue-50 text-blue-700 text-xs font-black">
                    {{ $occupied }}/{{ $capacity }} Penghuni
                </span>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-200">
                <table class="w-full min-w-[720px] text-sm text-left text-slate-700">
                    <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                        <tr>
                            <th class="px-5 py-4 font-black w-16">No</th>
                            <th class="px-5 py-4 font-black">Nama</th>
                            <th class="px-5 py-4 font-black">NIM</th>
                            <th class="px-5 py-4 font-black">Jurusan</th>
                            <th class="px-5 py-4 font-black text-center">Angkatan</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 text-center whitespace-nowrap">
                        @forelse ($room->penghuni as $penghuni)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-5 py-4 font-semibold">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-5 py-4 font-black text-slate-900">
                                    {{ $penghuni->user->name ?? '-' }}
                                </td>

                                <td class="px-5 py-4 font-semibold text-slate-700">
                                    {{ $penghuni->nim ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $penghuni->jurusan ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <span
                                        class="inline-flex px-3 py-1 rounded-full bg-violet-50 text-violet-700 text-xs font-black">
                                        {{ $penghuni->angkatan ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-slate-500 font-semibold">
                                    Belum ada penghuni aktif di kamar ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="form-delete">
            @csrf
            @method('DELETE')

            <x-button.button-menu type="submit" variant="danger">
                Hapus Kamar
            </x-button.button-menu>
        </form>

    </div>
@endsection
