@extends('layouts.app')

@section('title', 'Detail Penghuni')
@section('page_title', 'Detail Penghuni')

@section('content')
    <div class="mx-auto max-w-6xl space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900">Detail Penghuni</h2>
                <p class="text-sm text-slate-500 mt-1">
                    Informasi lengkap {{ $penghuni->user->name }}.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <x-button.button-menu href="{{ route('admin.penghuni.edit', $penghuni) }}" variant="warning">
                    Edit Penghuni
                </x-button.button-menu>

                <x-button.button-menu href="{{ route('admin.penghuni.index') }}" variant="outline">
                    Kembali
                </x-button.button-menu>
            </div>
        </div>
        {{-- DATA MAHASISWA --}}
        <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm p-6">

            <h3 class="text-lg font-black text-slate-900 mb-6">
                Data Mahasiswa
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div>
                    <p class="text-xs font-black text-slate-400 uppercase">Nama</p>
                    <p class="mt-1 text-base font-bold text-slate-900">
                        {{ $penghuni->user->name ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-black text-slate-400 uppercase">NIM</p>
                    <p class="mt-1 text-base font-bold text-slate-800">
                        {{ $penghuni->nim }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-black text-slate-400 uppercase">Email</p>
                    <p class="mt-1 text-base font-bold text-slate-800">
                        {{ $penghuni->user->email ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-black text-slate-400 uppercase">Fakultas</p>
                    <p class="mt-1 text-base font-bold text-slate-800">
                        {{ $penghuni->fakultas ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-black text-slate-400 uppercase">Jurusan</p>
                    <p class="mt-1 text-base font-bold text-slate-800">
                        {{ $penghuni->jurusan ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-black text-slate-400 uppercase">Angkatan</p>
                    <p class="mt-1 text-base font-bold text-slate-800">
                        {{ $penghuni->angkatan ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-black text-slate-400 uppercase">No HP</p>
                    <p class="mt-1 text-base font-bold text-slate-800">
                        {{ $penghuni->user->number_phone ?? '-' }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-500">
                        Jenis Kelamin
                    </label>

                    <p class="mt-1 font-semibold text-slate-900">
                        {{ $penghuni->user->gender }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-black text-slate-400 uppercase">Status Mahasiswa</p>

                    <div class="mt-2">
                        @if ($penghuni->status_mahasiswa === 'penghuni')
                            <span
                                class="inline-flex px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-600 text-xs font-black">
                                Penghuni
                            </span>
                        @else
                            <span class="inline-flex px-3 py-1.5 rounded-full bg-red-50 text-red-600 text-xs font-black">
                                Tidak Penghuni
                            </span>
                        @endif
                    </div>
                </div>

            </div>

        </div>

        {{-- DATA HUNIAN --}}
        <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm p-6">

            <h3 class="text-lg font-black text-slate-900 mb-6">
                Data Hunian
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div>
                    <p class="text-xs font-black text-slate-400 uppercase">Gedung</p>
                    <p class="mt-1 text-base font-bold text-slate-800">
                        {{ $penghuni->room?->floor?->building?->name ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-black text-slate-400 uppercase">Lantai</p>
                    <p class="mt-1 text-base font-bold text-slate-800">
                        Lantai {{ $penghuni->room?->floor?->floor_number ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-black text-slate-400 uppercase">Kamar</p>
                    <p class="mt-1 text-base font-bold text-slate-800">
                        {{ $penghuni->room?->kode_kamar ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-black text-slate-400 uppercase">Tipe Hunian</p>

                    <p class="mt-1 text-base font-bold text-slate-800">
                        {{ ucfirst($reservation->occupancy_type ?? '-') }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-black text-slate-400 uppercase">Masa Aktif</p>

                    <p class="mt-1 text-base font-bold text-slate-800">
                        {{ $reservation?->start_date?->format('d M Y') ?? '-' }}
                        -
                        {{ $reservation?->end_date?->format('d M Y') ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-black text-slate-400 uppercase">Jalur Pembiayaan</p>

                    <p class="mt-1 text-base font-bold text-slate-800">
                        {{ $penghuni->jalur_pembiayaan ?? '-' }}
                    </p>
                </div>

            </div>

        </div>

        {{-- DATA ORANG TUA --}}
        <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm p-6">

            <h3 class="text-lg font-black text-slate-900 mb-6">
                Data Orang Tua
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <p class="text-xs font-black text-slate-400 uppercase">Nama Orang Tua</p>
                    <p class="mt-1 text-base font-bold text-slate-800">
                        {{ $penghuni->nama_ortu ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-black text-slate-400 uppercase">No HP Orang Tua</p>
                    <p class="mt-1 text-base font-bold text-slate-800">
                        {{ $penghuni->no_hp_ortu ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-black text-slate-400 uppercase">Pekerjaan Orang Tua</p>
                    <p class="mt-1 text-base font-bold text-slate-800">
                        {{ $penghuni->pekerjaan_orang_tua ?? '-' }}
                    </p>
                </div>

                <div class="md:col-span-2">
                    <p class="text-xs font-black text-slate-400 uppercase">Alamat Orang Tua</p>
                    <p class="mt-1 text-base font-bold text-slate-800 break-words">
                        {{ $penghuni->alamat_orang_tua ?? '-' }}
                    </p>
                </div>

            </div>

        </div>

        {{-- DATA PRIBADI --}}
        <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm p-6">

            <h3 class="text-lg font-black text-slate-900 mb-6">
                Data Pribadi
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div>
                    <p class="text-xs font-black text-slate-400 uppercase">Tempat Lahir</p>
                    <p class="mt-1 text-base font-bold text-slate-800">
                        {{ $penghuni->tempat_lahir ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-black text-slate-400 uppercase">Tanggal Lahir</p>
                    <p class="mt-1 text-base font-bold text-slate-800">
                        {{ $penghuni->tanggal_lahir?->format('d M Y') ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-black text-slate-400 uppercase">Agama</p>
                    <p class="mt-1 text-base font-bold text-slate-800">
                        {{ $penghuni->agama ?? '-' }}
                    </p>
                </div>

                <div class="md:col-span-3">
                    <p class="text-xs font-black text-slate-400 uppercase">Alamat Mahasiswa</p>
                    <p class="mt-1 text-base font-bold text-slate-800 break-words">
                        {{ $penghuni->alamat ?? '-' }}
                    </p>
                </div>

            </div>

        </div>
        <form action="{{ route('admin.penghuni.destroy', $penghuni) }}" method="POST" class="form-delete">

            @csrf
            @method('DELETE')

            <x-button.button-menu type="submit" variant="danger" size="md" data-confirm
                data-confirm-title="Apakah Anda yakin menghapusnya?" data-confirm-text=""
                data-confirm-button-text="Ya, Hapus">

                Hapus Penghuni

            </x-button.button-menu>

        </form>
    </div>
@endsection
