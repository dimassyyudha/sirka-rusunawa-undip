@extends('layouts.app')

@section('title', 'Perpanjang Sewa')
@section('page_title', 'Perpanjang Sewa')

@section('content')

    @include('components.alert.sweetalert')

    <div class="max-w-5xl mx-auto space-y-6">

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">

            <h1 class="text-2xl font-black text-slate-900">
                Perpanjang Masa Sewa
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Ajukan perpanjangan masa hunian Rusunawa untuk periode semester berikutnya.
            </p>

        </div>

        <div class="grid md:grid-cols-2 gap-5">

            <div class="rounded-3xl border border-indigo-100 bg-indigo-50 p-6">
                <p class="text-sm font-bold text-indigo-500">
                    Periode Registrasi Aktif
                </p>

                <h2 class="mt-2 text-xl font-black text-indigo-900">
                    {{ $period->name }}
                </h2>

                <p class="mt-2 text-sm text-indigo-700">
                    {{ $period->registration_start_date?->format('d M Y') }}
                    -
                    {{ $period->registration_end_date?->format('d M Y') }}
                </p>
            </div>

            <div class="rounded-3xl border border-orange-100 bg-orange-50 p-6">
                <p class="text-sm font-bold text-orange-500">
                    Masa Hunian Berikutnya
                </p>

                <h2 class="mt-2 text-xl font-black text-orange-900">
                    {{ $period->lease_start_date?->format('d M Y') }}
                    -
                    {{ $period->lease_end_date?->format('d M Y') }}
                </h2>

                <p class="mt-2 text-sm text-orange-700">
                    Durasi perpanjangan otomatis 6 bulan.
                </p>
            </div>

        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-100">
                <h2 class="text-xl font-black text-slate-900">
                    Data Kamar Aktif
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Pastikan kamar aktif sudah sesuai sebelum mengajukan perpanjangan.
                </p>
            </div>

            <div class="p-6">

                <div class="grid md:grid-cols-2 gap-5 mb-6">

                    <div class="rounded-2xl border border-slate-200 p-5">
                        <p class="text-sm text-slate-500">
                            Kamar Aktif
                        </p>

                        <h2 class="mt-2 text-3xl font-black text-slate-900">
                            {{ $room->kode_kamar ?? '-' }}
                        </h2>

                        <p class="mt-2 text-sm text-slate-500">
                            {{ $room->floor->building->name ?? '-' }}
                            •
                            Lantai {{ $room->floor->floor_number ?? '-' }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 p-5">
                        <p class="text-sm text-slate-500">
                            Total Tagihan Perpanjangan
                        </p>

                        <h2 class="mt-2 text-3xl font-black text-orange-500">
                            Rp {{ number_format(($room->floor->monthly_price ?? 0) * 6, 0, ',', '.') }}
                        </h2>

                        <p class="mt-2 text-sm text-slate-500">
                            {{ number_format($room->floor->monthly_price ?? 0, 0, ',', '.') }} x 6 bulan
                        </p>
                    </div>

                </div>

                <form action="{{ route('mahasiswa.registrasi-ulang.perpanjang.store') }}" method="POST"
                    enctype="multipart/form-data" data-confirm-form data-confirm-title="Ajukan Perpanjangan Sewa?"
                    data-confirm-text="Pastikan data kamar, periode registrasi, dan masa hunian berikutnya sudah benar."
                    data-confirm-button-text="Ya, Ajukan" data-confirm-cancel-text="Batal" data-confirm-icon="question"
                    class="space-y-5">

                    @csrf

                    <input type="hidden" name="duration_month" value="6">

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4">
                        <p class="text-sm font-bold text-slate-500">
                            Durasi Perpanjangan
                        </p>

                        <p class="mt-1 text-lg font-black text-slate-900">
                            6 Bulan
                        </p>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-bold text-slate-700">
                            Dokumen Persyaratan
                            <span class="text-red-500">*</span>
                        </label>

                        <label for="requirement_document"
                            class="block cursor-pointer rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 p-6 text-center hover:border-orange-400 hover:bg-orange-50 transition">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto text-slate-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 16V4m0 0l-4 4m4-4l4 4M4 16.5V18a2 2 0 002 2h12a2 2 0 002-2v-1.5" />
                            </svg>

                            <p class="mt-3 font-semibold text-slate-700">
                                Klik untuk memilih dokumen
                            </p>

                            <p class="text-sm text-slate-500 mt-1">
                                PDF, JPG, JPEG, PNG • Maks. 2 MB
                            </p>

                            <p id="file-name" class="mt-3 text-sm font-medium text-orange-600">
                                Belum ada file dipilih
                            </p>
                        </label>

                        <input id="requirement_document" type="file" name="requirement_document"
                            accept=".pdf,.jpg,.jpeg,.png" class="hidden"
                            onchange="document.getElementById('file-name').innerText = this.files.length ? this.files[0].name : 'Belum ada file dipilih'">

                        @error('requirement_document')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-bold text-slate-700">
                            Catatan
                        </label>

                        <textarea name="notes" rows="4"
                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 focus:border-orange-500 focus:ring-orange-500"
                            placeholder="Tambahkan catatan jika diperlukan...">{{ old('notes') }}</textarea>

                        @error('notes')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-2">

                        <x-button.button-menu href="{{ route('mahasiswa.registrasi-ulang.index') }}"
                            class="bg-slate-100 text-slate-700 hover:bg-slate-200 justify-center">
                            Kembali
                        </x-button.button-menu>

                        <button type="submit"
                            class="flex-1 px-5 py-3 rounded-2xl bg-orange-500 hover:bg-orange-600 text-white font-black transition">
                            Ajukan Perpanjangan
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection
