@extends('layouts.app')

@section('title', 'Periode Hunian')
@section('page_title', 'Periode Hunian')

@section('content')

    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>

                <h2 class="text-2xl font-black text-slate-900">
                    Periode Hunian
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Kelola periode hunian semester ganjil dan genap Rusunawa Universitas Diponegoro.
                </p>

            </div>

            <x-button.button-menu type="button" variant="primary" size="lg"
                href="{{ route('admin.occupancy-periods.create') }}">

                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />

                </svg>

                Tambah Periode

            </x-button.button-menu>

        </div>

        <div class="grid md:grid-cols-4 gap-4">

            <div class="bg-white rounded-[10px] border border-slate-200 p-6">

                <p class="text-sm text-slate-500">
                    Total Periode
                </p>

                <h3 class="text-3xl font-black">
                    {{ $totalPeriods }}
                </h3>

            </div>

            <div class="bg-white rounded-[10px] border border-slate-200 p-6">

                <p class="text-sm text-slate-500">
                    Registrasi Dibuka
                </p>

                <h3 class="text-3xl font-black text-green-600">
                    {{ $openCount }}
                </h3>

            </div>

            <div class="bg-white rounded-[10px] border border-slate-200 p-6">

                <p class="text-sm text-slate-500">
                    Akan Dibuka
                </p>

                <h3 class="text-3xl font-black text-amber-600">
                    {{ $upcomingCount }}
                </h3>

            </div>

            <div class="bg-white rounded-[10px] border border-slate-200 p-6">

                <p class="text-sm text-slate-500">
                    Registrasi Ditutup
                </p>

                <h3 class="text-3xl font-black text-red-600">
                    {{ $closedCount }}
                </h3>

            </div>

        </div>
        <form id="filterForm" method="GET" class="mb-6 rounded-[20px] border border-slate-200 bg-white p-5 shadow-sm">

            <div class="grid gap-4 lg:grid-cols-5">

                {{-- SEARCH --}}
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Pencarian
                    </label>

                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama periode..."
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">
                </div>

                {{-- SEMESTER --}}
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Semester
                    </label>

                    <select name="semester" class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                        <option value="">Semua Semester</option>

                        <option value="ganjil" @selected(request('semester') == 'ganjil')>
                            Ganjil
                        </option>

                        <option value="genap" @selected(request('semester') == 'genap')>
                            Genap
                        </option>

                    </select>
                </div>

                {{-- STATUS --}}
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Status
                    </label>

                    <select name="status" class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                        <option value="">Semua Status</option>

                        <option value="open" @selected(request('status') == 'open')>
                            Registrasi Dibuka
                        </option>

                        <option value="upcoming" @selected(request('status') == 'upcoming')>
                            Akan Dibuka
                        </option>

                        <option value="closed" @selected(request('status') == 'closed')>
                            Registrasi Ditutup
                        </option>

                    </select>
                </div>

                {{-- TAHUN AKADEMIK --}}
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Tahun Akademik
                    </label>

                    <input type="text" name="academic_year" value="{{ request('academic_year') }}"
                        placeholder="2025/2026" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">
                </div>

                {{-- BUTTON --}}
                <div>

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-transparent">
                        Action
                    </label>

                    <div class="flex gap-2">

                        <button type="submit"
                            class="flex-1 rounded-xl bg-violet-600 px-4 py-3 text-sm font-bold text-white hover:bg-violet-700">

                            Filter

                        </button>

                        <a href="{{ route('admin.occupancy-periods.index') }}"
                            class="flex-1 rounded-xl border border-slate-300 px-4 py-3 text-center text-sm font-bold text-slate-700 hover:bg-slate-50">

                            Reset

                        </a>

                    </div>

                </div>

            </div>

        </form>
        <div class="relative overflow-x-auto bg-white shadow-sm rounded-[10px] border border-slate-200">

            <table class="w-full min-w-[1300px] text-sm text-left text-slate-700">
                <thead class="text-xs uppercase bg-slate-50 border-b border-slate-200 text-slate-500 text-center">
                    <thead class="bg-slate-50 text-slate-700 ">
                        <tr>
                            <th class="px-6 py-4 text-center align-middle font-black">Nama Periode</th>
                            <th class="px-6 py-4 text-center align-middle font-black">Semester</th>
                            <th class="px-6 py-4 text-center align-middle font-black">Tahun Akademik</th>
                            <th class="px-6 py-4 text-center align-middle font-black">Registrasi</th>
                            <th class="px-6 py-4 text-center align-middle font-black">Masa Hunian</th>
                            <th class="px-6 py-4 text-center align-middle font-black">Status</th>
                            <th class="px-6 py-4 text-center align-middle font-black">Aksi</th>
                        </tr>
                    </thead>

                <tbody class="divide-y divide-slate-100 text-center whitespace-nowrap">
                    @forelse ($periods as $period)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 font-bold text-slate-900">
                                {{ $period->name }}
                            </td>

                            <td class="px-6 py-4 text-center align-middle text-slate-600">
                                {{ $period->semester_type === 'ganjil' ? 'Semester Ganjil' : 'Semester Genap' }}
                            </td>

                            <td class="px-6 py-4 text-center align-middle text-slate-600">
                                {{ $period->academic_year_start }}/{{ $period->academic_year_end }}
                            </td>

                            <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                                {{ $period->registration_start_date?->format('d M Y') }}
                                -
                                {{ $period->registration_end_date?->format('d M Y') }}
                            </td>

                            <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                                {{ $period->lease_start_date?->format('d M Y') }}
                                -
                                {{ $period->lease_end_date?->format('d M Y') }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">

                                @if ($period->status === 'open')
                                    <span
                                        class="inline-flex items-center rounded-full bg-emerald-100 px-4 py-2 text-xs font-bold text-emerald-700">

                                        Registrasi Dibuka

                                    </span>
                                @elseif ($period->status === 'upcoming')
                                    <span
                                        class="inline-flex items-center rounded-full bg-amber-100 px-4 py-2 text-xs font-bold text-amber-700">

                                        Akan Dibuka

                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center rounded-full bg-red-100 px-4 py-2 text-xs font-bold text-red-700">

                                        Registrasi Ditutup

                                    </span>
                                @endif

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex items-center justify-center gap-2 whitespace-nowrap">

                                    @if ($period->status !== 'open')
                                        <form action="{{ route('admin.occupancy-periods.open-registration', $period) }}"
                                            method="POST" data-confirm-form data-confirm-title="Buka Registrasi?"
                                            data-confirm-text="Registrasi ulang akan dibuka untuk periode ini."
                                            data-confirm-button-text="Ya, Buka" data-confirm-cancel-text="Batal">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                class="rounded-xl bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-600 transition hover:bg-emerald-600 hover:text-white">

                                                Buka

                                            </button>

                                        </form>
                                    @else
                                        <form action="{{ route('admin.occupancy-periods.close-registration', $period) }}"
                                            method="POST" data-confirm-form data-confirm-title="Tutup Registrasi?"
                                            data-confirm-text="Registrasi ulang akan ditutup dan seluruh data hunian akan diproses."
                                            data-confirm-button-text="Ya, Tutup" data-confirm-cancel-text="Batal">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                class="rounded-xl bg-orange-50 px-4 py-2 text-sm font-semibold text-orange-600 transition hover:bg-orange-600 hover:text-white">

                                                Tutup

                                            </button>

                                        </form>
                                    @endif

                                    <a href="{{ route('admin.occupancy-periods.show', $period) }}"
                                        class="rounded-xl bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-600 transition hover:bg-blue-600 hover:text-white">

                                        Detail

                                    </a>

                                </div>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                Belum ada periode hunian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

      
        <div class="border-t border-slate-200  px-6 py-4">
            <x-ui.pagination :paginator="$periods" />
        </div>
    </div>

    </div>

@endsection
