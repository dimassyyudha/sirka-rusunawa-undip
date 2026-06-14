@extends('layouts.app')

@section('title', 'Periode Hunian')
@section('page_title', 'Periode Hunian')

@section('content')

    <div class="space-y-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900">
                    Periode Hunian
                </h1>

                <p class="mt-2 text-slate-500">
                    Kelola periode hunian semester ganjil dan genap.
                </p>
            </div>

            <a href="{{ route('admin.occupancy-periods.create') }}"
                class="inline-flex items-center justify-center rounded-2xl bg-orange-500 px-5 py-3 font-black text-white hover:bg-orange-600 transition">
                Tambah Periode
            </a>
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
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

                    <tbody class="divide-y divide-slate-100">
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
                                    @if ($period->computed_status === 'open')
                                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-black text-green-700">
                                            Registrasi Dibuka
                                        </span>
                                    @elseif ($period->computed_status === 'upcoming')
                                        <span
                                            class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-black text-yellow-700">
                                            Akan Dibuka
                                        </span>
                                    @else
                                        <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-black text-red-700">
                                            Registrasi Ditutup
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-end gap-2">

                                        {{-- BUKA / TUTUP --}}
                                        @if ($period->computed_status !== 'open')
                                            <form action="{{ route('admin.occupancy-periods.open-registration', $period) }}"
                                                method="POST" data-confirm-form data-confirm-title="Buka Registrasi Ulang?"
                                                data-confirm-text="Registrasi ulang akan dibuka untuk periode ini. Pastikan periode yang dipilih sudah sesuai."
                                                data-confirm-button-text="Ya, Buka" data-confirm-cancel-text="Batal"
                                                data-confirm-icon="question">

                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                    class="rounded-xl bg-green-50 px-4 py-2 text-xs font-black text-green-700 hover:bg-green-100 transition">
                                                    Buka
                                                </button>
                                            </form>
                                        @else
                                            <form
                                                action="{{ route('admin.occupancy-periods.close-registration', $period) }}"
                                                method="POST" data-confirm-form
                                                data-confirm-title="Tutup Registrasi Ulang?"
                                                data-confirm-text="Registrasi ulang akan ditutup dan data hunian akan diproses. Pastikan semua data pengajuan sudah benar."
                                                data-confirm-button-text="Ya, Tutup" data-confirm-cancel-text="Batal"
                                                data-confirm-icon="warning">

                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                    class="rounded-xl bg-orange-50 px-4 py-2 text-xs font-black text-orange-700 hover:bg-orange-100 transition">
                                                    Tutup
                                                </button>
                                            </form>
                                        @endif

                                        {{-- VIEW --}}
                                        <a href="{{ route('admin.occupancy-periods.show', $period) }}"
                                            class="rounded-xl bg-blue-50 px-4 py-2 text-xs font-black text-blue-700 hover:bg-blue-100 transition">
                                            View
                                        </a>

                                        {{-- EDIT --}}
                                        <a href="{{ route('admin.occupancy-periods.edit', $period) }}"
                                            class="rounded-xl bg-yellow-50 px-4 py-2 text-xs font-black text-yellow-700 hover:bg-yellow-100 transition">
                                            Edit
                                        </a>

                                        {{-- HAPUS --}}
                                        <form action="{{ route('admin.occupancy-periods.destroy', $period) }}"
                                            method="POST" class="form-delete" data-confirm-title="Hapus Periode Hunian?"
                                            data-confirm-text="Data periode hunian yang dihapus tidak dapat dikembalikan. Pastikan data sudah benar sebelum menghapus."
                                            data-confirm-button-text="Ya, Hapus" data-confirm-cancel-text="Batal"
                                            data-confirm-icon="warning">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="rounded-xl bg-red-50 px-4 py-2 text-xs font-black text-red-700 hover:bg-red-100 transition">
                                                Hapus
                                            </button>
                                        </form>

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

            @if ($periods->hasPages())
                <div class="border-t border-slate-100 px-6 py-4">
                    {{ $periods->links() }}
                </div>
            @endif

        </div>

    </div>

@endsection
