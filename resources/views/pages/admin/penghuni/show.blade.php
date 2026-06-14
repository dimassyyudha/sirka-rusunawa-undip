@extends('layouts.app')

@section('title', 'Detail Penghuni')
@section('page_title', 'Detail Penghuni')

@section('content')
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900">Detail Penghuni</h2>
                <p class="text-sm text-slate-500 mt-1">Informasi lengkap penghuni rusunawa.</p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <x-button.button-menu href="{{ route('admin.penghuni.edit', $penghuni) }}" variant="warning" size="md">
                    Edit
                </x-button.button-menu>

                <x-button.button-menu href="{{ route('admin.penghuni.index') }}" variant="outline" size="md">
                    Kembali
                </x-button.button-menu>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 bg-white rounded-[28px] border border-slate-200 shadow-sm p-6">
                <h3 class="text-lg font-black text-slate-900 mb-5">Data Mahasiswa</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase">Nama</p>
                        <p class="mt-1 text-base font-black text-slate-900">{{ $penghuni->user->name ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase">NIM</p>
                        <p class="mt-1 text-base font-bold text-slate-800">{{ $penghuni->nim }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase">Fakultas</p>
                        <p class="mt-1 text-base font-bold text-slate-800">{{ $penghuni->fakultas }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase">Jurusan</p>
                        <p class="mt-1 text-base font-bold text-slate-800">{{ $penghuni->jurusan }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase">Angkatan</p>
                        <p class="mt-1 text-base font-bold text-slate-800">{{ $penghuni->angkatan }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase">Email</p>
                        <p class="mt-1 text-base font-bold text-slate-800">{{ $penghuni->user->email ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase">No HP</p>
                        <p class="mt-1 text-base font-bold text-slate-800">{{ $penghuni->user->number_phone ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase">No HP Orang Tua</p>
                        <p class="mt-1 text-base font-bold text-slate-800">{{ $penghuni->no_hp_ortu ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase">Status</p>
                        <div class="mt-2">
                            @if ($penghuni->status_mahasiswa === 'penghuni')
                                <span
                                    class="inline-flex px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-600 text-xs font-black">
                                    Penghuni
                                </span>
                            @else
                                <span
                                    class="inline-flex px-3 py-1.5 rounded-full bg-amber-50 text-amber-600 text-xs font-black">
                                    Tidak Penghuni
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <p class="text-xs font-black text-slate-400 uppercase">Alamat</p>
                        <p class="mt-1 text-base font-bold text-slate-800">{{ $penghuni->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[28px] border border-slate-200 shadow-sm p-6">
                <h3 class="text-lg font-black text-slate-900 mb-5">Informasi Kamar</h3>

                @if ($penghuni->room)
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase">Kode Kamar</p>
                            <p class="mt-1 text-base font-black text-slate-900">{{ $penghuni->room->kode_kamar }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase">Gedung</p>
                            <p class="mt-1 text-base font-bold text-slate-800">
                                {{ $penghuni->room->floor->building->name ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase">Lantai</p>
                            <p class="mt-1 text-base font-bold text-slate-800">
                                Lantai {{ $penghuni->room->floor->floor_number ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase">Harga/Bulan</p>
                            <p class="mt-1 text-base font-black text-slate-900">
                                Rp {{ number_format((int) ($penghuni->room->floor->monthly_price ?? 0), 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @else
                    <div
                        class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-6 text-center text-sm font-semibold text-slate-500">
                        Belum memiliki kamar.
                    </div>
                @endif
            </div>

        </div>
        <form action="{{ route('admin.penghuni.destroy', $penghuni) }}" method="POST" class="form-delete">
            @csrf
            @method('DELETE')

            <x-button.button-menu type="submit" variant="danger" size="md">
                Hapus
            </x-button.button-menu>
        </form>
    </div>
@endsection
