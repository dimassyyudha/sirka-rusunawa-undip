@extends('layouts.app')

@section('title', 'Detail Gedung')
@section('page_title', 'Detail Gedung')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900">
                    Detail Gedung
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Informasi lengkap gedung Rusunawa
                </p>


            </div>

            <div class="flex flex-wrap gap-3">
                <x-button.button-menu href="{{ route('admin.buildings.edit', $building) }}" variant="warning">

                    Edit Gedung

                </x-button.button-menu>

                <x-button.button-menu href="{{ route('admin.buildings.index') }}" variant="outline" size="md">
                    Kembali
                </x-button.button-menu>
            </div>
        </div>

        <div class="overflow-hidden rounded-[10px] border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 bg-slate-50 px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                    <div>
                        <h3 class="text-2xl font-black text-slate-900">
                            {{ $building->name }}
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Detail informasi data gedung
                        </p>
                    </div>

                </div>
            </div>

            <div class="divide-y divide-slate-100">

                <div class="flex flex-col md:flex-row md:items-center px-8 py-6 gap-2">
                    <div class="w-full md:w-64">
                        <p class="text-sm font-black text-slate-500 uppercase tracking-wide">Kode</p>
                    </div>
                    <div class="flex-1">
                        <p class="text-base font-bold text-[#070B55]">{{ $building->code }}</p>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row md:items-center px-8 py-6 gap-2">
                    <div class="w-full md:w-64">
                        <p class="text-sm font-black text-slate-500 uppercase tracking-wide">Nama Gedung</p>
                    </div>
                    <div class="flex-1">
                        <p class="text-base font-bold text-slate-900">{{ $building->name }}</p>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row md:items-center px-8 py-6 gap-2">
                    <div class="w-full md:w-64">
                        <p class="text-sm font-black text-slate-500 uppercase tracking-wide">Tipe</p>
                    </div>
                    <div class="flex-1">
                        @if ($building->gender_type === 'laki-laki')
                            <x-ui.badge type="Laki-Laki" label="Laki-Laki" />
                        @else
                            <x-ui.badge type="perempuan" label="Perempuan" />
                        @endif
                    </div>
                </div>

                <div class="flex flex-col md:flex-row md:items-center px-8 py-6 gap-2">
                    <div class="w-full md:w-64">
                        <p class="text-sm font-black text-slate-500 uppercase tracking-wide">Lantai</p>
                    </div>
                    <div class="flex-1">
                        <p class="text-base font-bold text-slate-900">{{ $building->total_floors }}</p>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row md:items-center px-8 py-6 gap-2">
                    <div class="w-full md:w-64">
                        <p class="text-sm font-black text-slate-500 uppercase tracking-wide">Total Kamar</p>
                    </div>
                    <div class="flex-1">
                        <p class="text-base font-bold text-slate-900">
                            {{ $building->floors->sum(fn($floor) => $floor->rooms->count()) }}</p>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row md:items-center px-8 py-6 gap-2">
                    <div class="w-full md:w-64">
                        <p class="text-sm font-black text-slate-500 uppercase tracking-wide">Status</p>
                    </div>
                    <div class="flex-1">
                        @if ($building->is_active)
                            <x-ui.badge type="success" label="Aktif" />
                        @else
                            <x-ui.badge type="danger" label="Nonaktif" />
                        @endif
                    </div>
                </div>

            </div>

        </div>

        <form action="{{ route('admin.buildings.destroy', $building) }}" method="POST" class="form-delete">

            @csrf
            @method('DELETE')

            <x-button.button-menu type="submit" variant="danger" size="md">

                Hapus Gedung

            </x-button.button-menu>

        </form>

    </div>
@endsection
