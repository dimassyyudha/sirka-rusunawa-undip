@extends('layouts.app')

@section('title', 'Pengaturan Alur Reservasi')
@section('page_title', 'Pengaturan Alur Reservasi')

@section('content')

<div class="space-y-6">


<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

    <div>

        <h1 class="text-3xl font-black text-slate-900">
            Pengaturan Alur Reservasi
        </h1>

        <p class="mt-2 text-slate-500">
            Kelola informasi dan langkah-langkah alur reservasi yang tampil pada halaman beranda.
        </p>

    </div>

    <a href="{{ route('admin.settings.alur.edit') }}"
        class="inline-flex items-center justify-center rounded-2xl bg-orange-500 px-5 py-3 font-black text-white hover:bg-orange-600 transition">

        Edit Alur

    </a>

</div>

@if(session('success'))

    <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">

        {{ session('success') }}

    </div>

@endif

<div class="rounded-[10px] border border-slate-200 bg-white p-6 shadow-sm">

    <div class="grid md:grid-cols-3 gap-6">

        <div>

            <p class="text-xs font-bold uppercase tracking-wider text-slate-500">
                Badge
            </p>

            <p class="mt-2 text-lg font-black text-slate-900">
                {{ $data['badge'] ?? '-' }}
            </p>

        </div>

        <div class="md:col-span-2">

            <p class="text-xs font-bold uppercase tracking-wider text-slate-500">
                Judul
            </p>

            <p class="mt-2 text-lg font-black text-slate-900">
                {{ $data['title'] ?? '-' }}
            </p>

        </div>

    </div>

    <div class="mt-6">

        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">
            Deskripsi
        </p>

        <p class="mt-2 text-slate-700 leading-relaxed">
            {{ $data['description'] ?? '-' }}
        </p>

    </div>

</div>

<div class="rounded-[10px] border border-slate-200 bg-white shadow-sm overflow-hidden">

    <div class="border-b border-slate-200 px-6 py-4">

        <h2 class="text-lg font-black text-slate-900">
            Daftar Langkah Reservasi
        </h2>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-slate-50 border-b border-slate-200">

                <tr>

                    <th class="px-6 py-4 text-center font-black text-slate-700">
                        Urutan
                    </th>

                    <th class="px-6 py-4 text-center font-black text-slate-700">
                        Status
                    </th>

                    <th class="px-6 py-4 text-left font-black text-slate-700">
                        Judul Langkah
                    </th>

                    <th class="px-6 py-4 text-left font-black text-slate-700">
                        Deskripsi
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-slate-100">

                @forelse($items as $step)

                    <tr class="hover:bg-slate-50">

                        <td class="px-6 py-4 text-center font-black text-slate-900">

                            {{ $step['sort_order'] ?? 0 }}

                        </td>

                        <td class="px-6 py-4 text-center">

                            @if(!empty($step['is_active']))

                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-black text-green-700">

                                    Aktif

                                </span>

                            @else

                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-black text-slate-700">

                                    Nonaktif

                                </span>

                            @endif

                        </td>

                        <td class="px-6 py-4 font-semibold text-slate-900">

                            {{ $step['title'] ?? '-' }}

                        </td>

                        <td class="px-6 py-4 text-slate-600">

                            {{ $step['desc'] ?? '-' }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="4"
                            class="px-6 py-12 text-center text-slate-500">

                            Belum ada langkah alur reservasi.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


</div>

@endsection
