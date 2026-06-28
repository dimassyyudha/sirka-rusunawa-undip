@extends('layouts.app')

@section('title', 'Pindah Kamar')
@section('page_title', 'Pindah Kamar')
@php
    $capacity = $room->floor->room_capacity ?? 0;
    $occupied = $room->occupied ?? 0;
    $available = $capacity - $occupied;
@endphp
@section('content')
    <div class="rounded-3xl border border-amber-200 bg-amber-50 p-5">
        <h3 class="font-bold text-amber-800">
            Informasi Pengajuan
        </h3>

        <ul class="mt-2 text-sm text-amber-700 space-y-1">
            <li>• Pengajuan pindah kamar harus diverifikasi admin.</li>
            <li>• Kamar tidak langsung berpindah setelah pengajuan.</li>
            <li>• Mahasiswa tetap menempati kamar lama sampai disetujui.</li>
            <li>• Dokumen pendukung wajib diunggah.</li>
        </ul>
    </div>

    <div class="max-w-7xl mx-auto space-y-6">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            <div>
                <h1 class="text-3xl font-black text-slate-900">
                    Pindah Kamar
                </h1>

                <p class="mt-2 text-slate-500">
                    Pilih kamar baru yang tersedia untuk periode registrasi ulang.
                </p>
            </div>

            <x-button.button-menu href="{{ route('mahasiswa.registrasi-ulang.index') }}"
                class="bg-slate-100 text-slate-700 hover:bg-slate-200 justify-center">
                Kembali
            </x-button.button-menu>

        </div>

        @if (isset($currentRoom))
            <div class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">

                <p class="text-sm text-slate-500">
                    Kamar Saat Ini
                </p>

                <h2 class="mt-2 text-3xl font-black text-slate-900">
                    {{ $currentRoom->kode_kamar ?? '-' }}
                </h2>

                <p class="mt-2 text-sm text-slate-500">
                    {{ $currentRoom->floor->building->name ?? '-' }}
                    •
                    Lantai {{ $currentRoom->floor->floor_number ?? '-' }}
                </p>

            </div>
        @endif

        <div class="grid lg:grid-cols-2 gap-6">

            @forelse($rooms as $room)
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                    <div class="p-6">

                        <div class="flex items-start justify-between gap-4">

                            <div>
                                <h2 class="text-2xl font-black text-slate-900">
                                    {{ $room->kode_kamar }}
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    {{ $room->floor->building->name ?? '-' }}
                                    •
                                    Lantai {{ $room->floor->floor_number ?? '-' }}
                                </p>
                            </div>

                            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                                Tersedia
                            </span>

                        </div>

                        <div class="mt-6 grid grid-cols-2 gap-4">

                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-xs text-slate-500">
                                    Harga
                                </p>

                                <p class="mt-2 text-lg font-black text-orange-500">
                                    Rp {{ number_format($room->floor->monthly_price ?? 0, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-xs text-slate-500">
                                    Kapasitas
                                </p>

                                <p class="mt-2 text-lg font-black text-slate-900">
                                    @if ($available > 0)
                                        <span
                                            class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                                            {{ $available }} Slot
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                            Penuh
                                        </span>
                                    @endif

                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <p class="text-xs text-slate-500">
                                        Slot Tersedia
                                    </p>

                                    <p class="mt-2 text-lg font-black text-emerald-600">
                                        {{ $available }} Slot
                                    </p>
                                </div>
                                </p>
                            </div>

                        </div>

                        <form action="{{ route('mahasiswa.registrasi-ulang.pindah-kamar.store', $room->room_id) }}"
                            method="POST" enctype="multipart/form-data" class="mt-6 space-y-4" data-confirm-form
                            data-confirm-title="Ajukan pindah kamar?"
                            data-confirm-text="Pengajuan pindah kamar akan dikirim ke admin untuk diverifikasi."
                            data-confirm-button-text="Ya, ajukan">

                            @csrf

                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700">
                                    Jenis Hunian
                                </label>

                                <select name="occupancy_type" required
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-3">

                                    <option value="">
                                        Pilih Jenis Hunian
                                    </option>

                                    <option value="shared">
                                        Shared Room
                                    </option>

                                    <option value="private">
                                        Private Room
                                    </option>

                                </select>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700">
                                    Dokumen Pendukung
                                </label>

                                <input type="file" name="requirement_document" accept=".pdf,.jpg,.jpeg,.png" required
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-3">
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700">
                                    Catatan / Alasan Pindah
                                </label>

                                <textarea name="notes" rows="3"
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 focus:border-orange-500 focus:ring-orange-500"
                                    placeholder="Tuliskan alasan pindah kamar...">{{ old('notes') }}</textarea>
                            </div>

                            @if ($available > 0)
                                <button type="submit"
                                    class="w-full px-5 py-3 rounded-2xl bg-orange-500 hover:bg-orange-600 text-white font-black">

                                    Saya Ingin Pindah ke Kamar Ini

                                </button>
                            @else
                                <button type="button" disabled
                                    class="w-full px-5 py-3 rounded-2xl bg-slate-200 text-slate-500 cursor-not-allowed">

                                    Kamar Penuh

                                </button>
                            @endif

                        </form>

                        @csrf

                        <div>
                            <label class="block mb-2 text-sm font-bold text-slate-700">
                                Catatan / Alasan Pindah
                            </label>

                            <textarea name="notes" rows="3"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-3 focus:border-orange-500 focus:ring-orange-500"
                                placeholder="Tuliskan alasan pindah kamar jika diperlukan...">{{ old('notes') }}</textarea>
                        </div>

                        <button type="submit"
                            class="w-full px-5 py-3 rounded-2xl bg-orange-500 hover:bg-orange-600 text-white font-black transition">
                            Ajukan Pindah Kamar
                        </button>

                        </form>

                    </div>

                </div>

            @empty

                <div class="lg:col-span-2">

                    <div class="bg-white rounded-3xl border border-dashed border-slate-300 p-12 text-center">

                        <h2 class="text-xl font-black text-slate-900">
                            Tidak Ada Kamar Tersedia
                        </h2>

                        <p class="mt-2 text-slate-500">
                            Saat ini belum ada kamar yang dapat dipilih.
                        </p>

                        <div class="mt-6">
                            <x-button.button-menu href="{{ route('mahasiswa.registrasi-ulang.index') }}"
                                class="bg-slate-100 text-slate-700 hover:bg-slate-200 justify-center">
                                Kembali ke Registrasi Ulang
                            </x-button.button-menu>
                        </div>

                    </div>

                </div>
            @endforelse

        </div>


        <div>
            <x-ui.pagination :paginator="$rooms" />
        </div>


    </div>

@endsection
