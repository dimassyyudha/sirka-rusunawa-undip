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
                <p class="mt-2 text-slate-500">
                    {{ $occupancyPeriod->semester_type === 'ganjil' ? 'Semester Ganjil' : 'Semester Genap' }}
                    {{ $occupancyPeriod->academic_year_start }}/{{ $occupancyPeriod->academic_year_end }}
                    •
                    Masa Hunian:
                    {{ $occupancyPeriod->lease_start_date?->format('d M Y') }}
                    -
                    {{ $occupancyPeriod->lease_end_date?->format('d M Y') }}
                </p>
                </p>
            </div>

            <a href="{{ route('admin.occupancy-periods.index') }}"
                class="inline-flex items-center justify-center px-5 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-black transition">
                Kembali
            </a>

        </div>

        <form method="GET" action="{{ route('admin.occupancy-periods.show', $occupancyPeriod) }}"
            class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="grid lg:grid-cols-[1fr_auto] gap-4 lg:items-end">

                <div>
                    <label class="block mb-2 text-sm font-bold text-slate-700">
                        Periode Registrasi
                    </label>

                    <select name="period_id"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500">

                        @foreach ($periods as $period)
                            <option value="{{ $period->id }}" @selected($period->id === $occupancyPeriod->id)>

                                {{ $period->semester_type === 'ganjil' ? 'Semester Ganjil' : 'Semester Genap' }}
                                -
                                {{ $period->academic_year_start }}/{{ $period->academic_year_end }}

                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="flex gap-2">

                    <button type="submit"
                        class="rounded-2xl bg-orange-500 px-5 py-3 text-sm font-black text-white hover:bg-orange-600 transition">
                        Tampilkan
                    </button>

                    <a href="{{ route('admin.occupancy-periods.show', $occupancyPeriod) }}"
                        class="rounded-2xl bg-slate-100 px-5 py-3 text-sm font-black text-slate-700 hover:bg-slate-200 transition">
                        Reset
                    </a>

                </div>

            </div>

        </form>

        <div class="grid md:grid-cols-6 gap-4">

            <div class="rounded-3xl bg-white border border-slate-200 p-5">
                <p class="text-sm text-slate-500">Perpanjang</p>
                <h2 class="mt-2 text-3xl font-black text-slate-900">{{ $summary['extension'] }}</h2>
            </div>

            <div class="rounded-3xl bg-white border border-slate-200 p-5">
                <p class="text-sm text-slate-500">Pindah</p>
                <h2 class="mt-2 text-3xl font-black text-slate-900">{{ $summary['transfer'] }}</h2>
            </div>

            <div class="rounded-3xl bg-white border border-slate-200 p-5">
                <p class="text-sm text-slate-500">Akhiri</p>
                <h2 class="mt-2 text-3xl font-black text-slate-900">{{ $summary['checkout'] }}</h2>
            </div>

            <div class="rounded-3xl bg-white border border-slate-200 p-5">
                <p class="text-sm text-slate-500">Pending</p>
                <h2 class="mt-2 text-3xl font-black text-orange-500">{{ $summary['pending'] }}</h2>
            </div>

            <div class="rounded-3xl bg-white border border-slate-200 p-5">
                <p class="text-sm text-slate-500">Approved</p>
                <h2 class="mt-2 text-3xl font-black text-emerald-500">{{ $summary['approved'] }}</h2>
            </div>

            <div class="rounded-3xl bg-white border border-slate-200 p-5">
                <p class="text-sm text-slate-500">Rejected</p>
                <h2 class="mt-2 text-3xl font-black text-red-500">{{ $summary['rejected'] }}</h2>
            </div>

        </div>

        {{-- FORM BULK ACTION TERPISAH, JANGAN MEMBUNGKUS TABLE --}}
        <form id="bulkActionForm" action="{{ route('admin.occupancy-periods.reservations.bulk-action') }}" method="POST"
            data-bulk-form>
            @csrf
        </form>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

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
                            class="px-5 py-3 rounded-2xl bg-orange-500 hover:bg-orange-600 text-white font-black text-sm transition">
                            Terapkan
                        </button>

                    </div>

                    <div class="flex flex-col lg:flex-row gap-3">

                        <select id="statusFilter"
                            class="rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500">

                            <option value="">
                                Semua Status
                            </option>

                            <option value="pending">
                                Pending
                            </option>

                            <option value="approved">
                                Approved
                            </option>

                            <option value="rejected">
                                Rejected
                            </option>

                        </select>

                        <input type="text" id="tableSearch" placeholder="Cari mahasiswa..."
                            class="w-full lg:w-[280px] rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500">

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

                                    <input type="checkbox" name="ids[]" value="{{ $reservation->id }}"
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
                                            <form id="approve-{{ $reservation->id }}"
                                                action="{{ route('admin.occupancy-periods.reservations.approve', $reservation->id) }}"
                                                method="POST" data-confirm-form data-confirm-title="Setujui pengajuan?"
                                                data-confirm-text="Pengajuan registrasi ulang akan disetujui."
                                                data-confirm-button-text="Ya, setujui">
                                                @csrf
                                                @method('PATCH')
                                            </form>

                                            <button type="submit" form="approve-{{ $reservation->id }}"
                                                class="px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-black transition">
                                                Setujui
                                            </button>

                                            <form id="reject-{{ $reservation->id }}"
                                                action="{{ route('admin.occupancy-periods.reservations.reject', $reservation->id) }}"
                                                method="POST" data-confirm-form data-confirm-title="Tolak pengajuan?"
                                                data-confirm-text="Pengajuan registrasi ulang akan ditolak."
                                                data-confirm-button-text="Ya, tolak">
                                                @csrf
                                                @method('PATCH')
                                            </form>

                                            <button type="submit" form="reject-{{ $reservation->id }}"
                                                class="px-4 py-2 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-black transition">
                                                Tolak
                                            </button>
                                        @endif

                                        <form id="delete-{{ $reservation->id }}"
                                            action="{{ route('admin.occupancy-periods.reservations.delete', $reservation->id) }}"
                                            method="POST" data-confirm-form data-confirm-title="Hapus data?"
                                            data-confirm-text="Data registrasi ulang akan dihapus permanen."
                                            data-confirm-button-text="Ya, hapus">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                        <button type="submit" form="delete-{{ $reservation->id }}"
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

            <div class="border-t border-slate-200 bg-white px-6 py-4">
                <x-ui.pagination :paginator="$reservations" />
            </div>

        </div>

    </div>

    @push('scripts')
        <script>
            const checkAll = document.getElementById('checkAll');
            const rowCheckboxes = document.querySelectorAll('.row-checkbox');

            if (checkAll) {
                checkAll.addEventListener('change', function() {
                    rowCheckboxes.forEach(cb => {
                        cb.checked = this.checked;
                    });
                });
            }

            const searchInput = document.getElementById('tableSearch');
            const statusFilter = document.getElementById('statusFilter');

            function filterTable() {
                const keyword = searchInput.value.toLowerCase();
                const status = statusFilter.value.toLowerCase();

                document.querySelectorAll('.table-row-item').forEach(row => {
                    const text = row.innerText.toLowerCase();
                    const rowStatus = row.dataset.status;

                    row.style.display =
                        text.includes(keyword) && (!status || rowStatus === status) ?
                        '' :
                        'none';
                });
            }

            if (searchInput) searchInput.addEventListener('keyup', filterTable);
            if (statusFilter) statusFilter.addEventListener('change', filterTable);

            const bulkForm = document.querySelector('[data-bulk-form]');

            if (bulkForm) {
                bulkForm.addEventListener('submit', function(e) {
                    if (bulkForm.dataset.confirmed === '1') return;

                    e.preventDefault();

                    const action = document.getElementById('bulkActionSelect').value;
                    const checked = document.querySelectorAll('.row-checkbox:checked').length;

                    if (!action) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Pilih aksi dulu',
                            text: 'Silakan pilih setujui, tolak, atau hapus.',
                            confirmButtonColor: '#f97316',
                        });
                        return;
                    }

                    if (checked === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Pilih data dulu',
                            text: 'Centang minimal satu data registrasi ulang.',
                            confirmButtonColor: '#f97316',
                        });
                        return;
                    }

                    let config = {
                        title: 'Lanjutkan?',
                        text: 'Data terpilih akan diproses.',
                        icon: 'warning',
                        confirmButtonText: 'Ya, lanjutkan',
                        confirmButtonColor: '#f97316',
                    };

                    if (action === 'approve') {
                        config = {
                            title: 'Setujui data terpilih?',
                            text: `${checked} pengajuan akan disetujui.`,
                            icon: 'success',
                            confirmButtonText: 'Ya, setujui',
                            confirmButtonColor: '#10b981',
                        };
                    }

                    if (action === 'reject') {
                        config = {
                            title: 'Tolak data terpilih?',
                            text: `${checked} pengajuan akan ditolak.`,
                            icon: 'warning',
                            confirmButtonText: 'Ya, tolak',
                            confirmButtonColor: '#ef4444',
                        };
                    }

                    if (action === 'delete') {
                        config = {
                            title: 'Hapus data terpilih?',
                            text: `${checked} data akan dihapus permanen.`,
                            icon: 'warning',
                            confirmButtonText: 'Ya, hapus',
                            confirmButtonColor: '#ef4444',
                        };
                    }

                    Swal.fire({
                        ...config,
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        cancelButtonColor: '#64748b',
                        reverseButtons: true,
                        customClass: {
                            popup: 'rounded-3xl',
                            confirmButton: 'rounded-xl',
                            cancelButton: 'rounded-xl',
                        }
                    }).then((result) => {
                        if (!result.isConfirmed) return;

                        bulkForm.dataset.confirmed = '1';
                        bulkForm.submit();
                    });
                });
            }
        </script>
    @endpush

@endsection
