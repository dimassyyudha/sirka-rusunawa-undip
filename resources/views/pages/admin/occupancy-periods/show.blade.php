@extends('layouts.app')

@section('title', 'Data Registrasi Ulang')
@section('page_title', 'Data Registrasi Ulang')

@section('content')

    <div class="space-y-6">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            <div>
                <h1 class="text-3xl font-black text-slate-900">
                    Data Registrasi Ulang
                </h1>

                <p class="mt-2 text-slate-500">
                    {{-- <p class="mt-2 text-slate-500">
                    {{ $occupancyPeriod->semester_type === 'ganjil' ? 'Semester Ganjil' : 'Semester Genap' }}
                    {{ $occupancyPeriod->academic_year_start }}/{{ $occupancyPeriod->academic_year_end }}
                    •
                    Masa Hunian:
                    {{ $occupancyPeriod->lease_start_date?->format('d M Y') }}
                    -
                    {{ $occupancyPeriod->lease_end_date?->format('d M Y') }}
                </p>
                </p> --}}
            </div>


        </div>

        <form id="filterForm" method="GET" action="{{ route('admin.occupancy-periods.show', $occupancyPeriod) }}"
            class="rounded-[10px] border border-slate-200 bg-white p-5 shadow-sm">

            <div class="grid gap-4 lg:grid-cols-12">

                {{-- PENCARIAN --}}
                <div class="lg:col-span-4">

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Pencarian
                    </label>

                    <input id="searchInput" type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama mahasiswa atau NIM..."
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                </div>

                {{-- JENIS PENGAJUAN --}}
                <div class="lg:col-span-2">

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Jenis Pengajuan
                    </label>

                    <select name="reservation_type"
                        class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                        <option value="" @selected(request('reservation_type') == '')>
                            Semua
                        </option>

                        <option value="extension" @selected(request('reservation_type') == 'extension')>
                            Perpanjang
                        </option>

                        <option value="transfer" @selected(request('reservation_type') == 'transfer')>
                            Pindah Kamar
                        </option>

                        <option value="checkout" @selected(request('reservation_type') == 'checkout')>
                            Akhiri Hunian
                        </option>

                    </select>

                </div>

                {{-- STATUS --}}
                <div class="lg:col-span-2">

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Status
                    </label>

                    <select name="status" class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                        <option value="" @selected(request('status') == '')>
                            Semua
                        </option>

                        <option value="pending" @selected(request('status') == 'pending')>
                            Menunggu
                        </option>

                        <option value="approved" @selected(request('status') == 'approved')>
                            Disetujui
                        </option>

                        <option value="rejected" @selected(request('status') == 'rejected')>
                            Ditolak
                        </option>

                    </select>

                </div>

                {{-- PERIODE --}}
                <div class="lg:col-span-2">

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Periode Registrasi
                    </label>

                    <select name="period_id"
                        class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                        @foreach ($periods as $period)
                            <option value="{{ $period->id }}" @selected($period->id === $occupancyPeriod->id)>

                                {{ $period->semester_type === 'ganjil' ? 'Ganjil' : 'Genap' }}
                                -
                                {{ $period->academic_year_start }}/{{ $period->academic_year_end }}

                            </option>
                        @endforeach

                    </select>

                </div>

                {{-- ACTION --}}
                <div class="lg:col-span-2">

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-transparent">
                        Action
                    </label>

                    <div class="flex gap-2">

                        <button type="submit"
                            class="flex-1 rounded-xl bg-violet-600 px-4 py-3 text-sm font-bold text-white hover:bg-violet-700">

                            Filter

                        </button>

                        <a href="{{ route('admin.occupancy-periods.show', $occupancyPeriod) }}"
                            class="flex-1 rounded-xl border border-slate-300 px-4 py-3 text-center text-sm font-bold text-slate-700 hover:bg-slate-50">

                            Reset

                        </a>

                    </div>

                </div>

            </div>

        </form>



        {{-- FORM BULK ACTION TERPISAH, JANGAN MEMBUNGKUS TABLE --}}
        <form id="bulkActionForm" action="{{ route('admin.occupancy-periods.reservations.bulk-action') }}" method="POST"
            data-bulk-form>
            @csrf
        </form>

        <div class="relative overflow-x-auto bg-white shadow-sm rounded-[10px] border border-slate-200">

            <div class="px-6 py-5 border-b border-slate-100">

                <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">

                    <div class="flex flex-wrap items-center gap-3">

                        <select name="bulk_action" form="bulkActionForm" id="bulkActionSelect"
                            class="rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500">

                            <option value="">
                                Bulk Action
                            </option>

                            <option value="approve">
                                Setujui Terpilih
                            </option>

                            <option value="reject">
                                Tolak Terpilih
                            </option>

                            <option value="delete">
                                Hapus Terpilih
                            </option>

                        </select>

                        <button type="submit" form="bulkActionForm"
                            class="flex-1 rounded-xl bg-violet-600 px-4 py-3 text-sm font-bold text-white hover:bg-violet-700">
                            Terapkan
                        </button>

                    </div>



                </div>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full min-w-[1350px]">

                    <thead class="bg-slate-50 border-b border-slate-200">

                        <tr class="text-left">

                            <th class="px-6 py-4 w-[50px]">
                                <input type="checkbox" id="checkAll"
                                    class="rounded border-slate-300 text-orange-500 focus:ring-orange-500">
                            </th>

                            <th class="px-6 py-4 font-black text-slate-700">
                                Mahasiswa
                            </th>

                            <th class="px-6 py-4 font-black text-slate-700">
                                Jenis
                            </th>

                            <th class="px-6 py-4 font-black text-slate-700">
                                Kamar Lama
                            </th>

                            <th class="px-6 py-4 font-black text-slate-700">
                                Kamar Tujuan
                            </th>

                            <th class="px-6 py-4 font-black text-slate-700">
                                Status
                            </th>

                            <th class="px-6 py-4 font-black text-slate-700">
                                Catatan
                            </th>

                            <th class="px-6 py-4 font-black text-slate-700 text-right">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($reservations as $reservation)
                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition table-row-item"
                                data-status="{{ strtolower($reservation->status) }}">

                                <td class="px-6 py-5">

                                    <input type="checkbox" name="ids[]" value="{{ $reservation->reservation_id }}"
                                        form="bulkActionForm"
                                        class="row-checkbox rounded border-slate-300 text-orange-500 focus:ring-orange-500">

                                </td>

                                <td class="px-6 py-5">

                                    <div class="font-black text-slate-900">
                                        {{ $reservation->user->name ?? '-' }}
                                    </div>

                                    <div class="text-sm text-slate-500">
                                        {{ $reservation->user->email ?? '-' }}
                                    </div>

                                </td>

                                <td class="px-6 py-5">

                                    @if ($reservation->reservation_type === 'extension')
                                        <span
                                            class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                                            Perpanjang
                                        </span>
                                    @elseif ($reservation->reservation_type === 'transfer')
                                        <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">
                                            Pindah
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                            Akhiri
                                        </span>
                                    @endif

                                </td>

                                <td class="px-6 py-5 text-slate-700">
                                    {{ $reservation->previousRoom->kode_kamar ?? '-' }}
                                </td>

                                <td class="px-6 py-5 text-slate-700">
                                    {{ $reservation->room->kode_kamar ?? '-' }}
                                </td>

                                <td class="px-6 py-5">

                                    @if ($reservation->status === 'approved')
                                        <span
                                            class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                                            APPROVED
                                        </span>
                                    @elseif ($reservation->status === 'rejected')
                                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                            REJECTED
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold">
                                            PENDING
                                        </span>
                                    @endif

                                </td>

                                <td class="px-6 py-5 text-slate-600 max-w-[280px]">
                                    {{ $reservation->notes ?? '-' }}
                                </td>

                                <td class="px-6 py-5">

                                    <div class="flex justify-end gap-2 flex-wrap">

                                        @if ($reservation->status === 'pending')
                                            <form id="approve-{{ $reservation->reservation_id }}"
                                                action="{{ route('admin.occupancy-periods.reservations.approve', $reservation->reservation_id) }}"
                                                method="POST" data-confirm-form data-confirm-title="Setujui pengajuan?"
                                                data-confirm-text="Pengajuan registrasi ulang akan disetujui."
                                                data-confirm-button-text="Ya, setujui">
                                                @csrf
                                                @method('PATCH')
                                            </form>

                                            <button type="submit" form="approve-{{ $reservation->reservation_id }}"
                                                class="px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-black transition">
                                                Setujui
                                            </button>

                                            <form id="reject-{{ $reservation->reservation_id }}"
                                                action="{{ route('admin.occupancy-periods.reservations.reject', $reservation->reservation_id) }}"
                                                method="POST" data-confirm-form data-confirm-title="Tolak pengajuan?"
                                                data-confirm-text="Pengajuan registrasi ulang akan ditolak."
                                                data-confirm-button-text="Ya, tolak">
                                                @csrf
                                                @method('PATCH')
                                            </form>

                                            <button type="submit" form="reject-{{ $reservation->reservation_id }}"
                                                class="px-4 py-2 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-black transition">
                                                Tolak
                                            </button>
                                        @endif

                                        <form id="delete-{{ $reservation->reservation_id }}"
                                            action="{{ route('admin.occupancy-periods.reservations.delete', $reservation->reservation_id) }}"
                                            method="POST" data-confirm-form data-confirm-title="Hapus data?"
                                            data-confirm-text="Data registrasi ulang akan dihapus permanen."
                                            data-confirm-button-text="Ya, hapus">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                        <button type="submit" form="delete-{{ $reservation->reservation_id }}"
                                            class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-black transition">
                                            Hapus
                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-slate-500">
                                    Belum ada data registrasi ulang yang masuk.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>



        </div>
        <div class="border-t border-slate-200  px-6 py-4">
            <x-ui.pagination :paginator="$reservations" />
        </div>
    </div>

@endsection
