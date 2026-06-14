@extends('layouts.app')

@section('title', 'Detail Lantai')
@section('page_title', 'Detail Lantai')

@section('content')
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900">
                    Detail Lantai
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Informasi detail lantai Rusunawa
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">

                <x-button.button-menu href="{{ route('admin.floors.edit', $floor) }}" variant="warning" size="md">

                    Edit

                </x-button.button-menu>

                <x-button.button-menu href="{{ route('admin.floors.index') }}" variant="outline" size="md">

                    Kembali

                </x-button.button-menu>

            </div>
        </div>

        <div class="bg-white rounded-[28px] border border-slate-200 shadow-sm overflow-hidden">

            <div class="p-6 border-b border-slate-100">
                <h3 class="text-xl font-black text-slate-900">
                    {{ $floor->building->name ?? 'Gedung tidak tersedia' }}
                </h3>
                <p class="text-sm text-slate-500 mt-1">
                    Lantai {{ $floor->floor_number }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2">

                <div class="p-6 border-b md:border-r border-slate-100">
                    <p class="text-xs font-black uppercase tracking-wider text-slate-400">
                        Gedung
                    </p>
                    <p class="text-lg font-bold text-slate-900 mt-2">
                        {{ $floor->building->name ?? '-' }}
                    </p>
                </div>

                <div class="p-6 border-b border-slate-100">
                    <p class="text-xs font-black uppercase tracking-wider text-slate-400">
                        Nomor Lantai
                    </p>
                    <p class="text-lg font-bold text-slate-900 mt-2">
                        Lantai {{ $floor->floor_number }}
                    </p>
                </div>

                <div class="p-6 border-b md:border-r border-slate-100">
                    <p class="text-xs font-black uppercase tracking-wider text-slate-400">
                        Total Kamar
                    </p>
                    <p class="text-lg font-bold text-slate-900 mt-2">
                        {{ $floor->total_rooms }} kamar
                    </p>
                </div>

                <div class="p-6 border-b border-slate-100">
                    <p class="text-xs font-black uppercase tracking-wider text-slate-400">
                        Kapasitas per Kamar
                    </p>
                    <p class="text-lg font-bold text-slate-900 mt-2">
                        {{ $floor->room_capacity }} orang
                    </p>
                </div>

                <div class="p-6 md:col-span-2">
                    <p class="text-xs font-black uppercase tracking-wider text-slate-400">
                        Harga Bulanan
                    </p>
                    <p class="text-2xl font-black text-[#070B55] mt-2">
                        Rp {{ number_format($floor->monthly_price, 0, ',', '.') }}
                    </p>
                </div>

            </div>

        </div>

        <form action="{{ route('admin.floors.destroy', $floor) }}" method="POST" class="form-delete">

            @csrf
            @method('DELETE')

            <x-button.button-menu type="submit" variant="danger" size="md">

                Hapus Lantai

            </x-button.button-menu>

        </form>

    </div>
@endsection
