@extends('layouts.app')

@section('title', 'Tambah Periode Registrasi')
@section('page_title', 'Tambah Periode Registrasi')

@section('content')

    <div class="mx-auto max-w-4xl space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>
                <h2 class="text-2xl font-black text-slate-900">
                    Tambah Periode Registrasi
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Tambahkan periode registrasi ulang Rusunawa.
                </p>
            </div>

            <x-button.button-menu
                href="{{ route('admin.occupancy-periods.index') }}"
                variant="outline"
                size="md">

                Kembali

            </x-button.button-menu>

        </div>

        @if ($errors->any())
            <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">

                <ul class="list-disc pl-5 space-y-1">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>
        @endif

        <form
            action="{{ route('admin.occupancy-periods.store') }}"
            method="POST"
            class="bg-white rounded-[10px] border border-slate-200 shadow-sm p-6 space-y-5">

            @csrf

            <div class="grid md:grid-cols-2 gap-5">

                <div>

                    <label class="block mb-2.5 text-sm font-medium text-heading">
                        Jenis Semester
                    </label>

                    <select
                        name="semester_type"
                        required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3">

                        <option value="">
                            -- Pilih Semester --
                        </option>

                        <option value="ganjil"
                            @selected(old('semester_type') == 'ganjil')>

                            Semester Ganjil

                        </option>

                        <option value="genap"
                            @selected(old('semester_type') == 'genap')>

                            Semester Genap

                        </option>

                    </select>

                    @error('semester_type')
                        <p class="text-sm text-red-600 mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <div>

                    <label class="block mb-2.5 text-sm font-medium text-heading">
                        Tahun Akademik
                    </label>

                    <select
                        name="academic_year_start"
                        required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3">

                        <option value="{{ $currentYear }}">
                            {{ $currentYear }}/{{ $currentYear + 1 }}
                        </option>

                    </select>

                    @error('academic_year_start')
                        <p class="text-sm text-red-600 mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <div>

                    <label class="block mb-2.5 text-sm font-medium text-heading">
                        Tanggal Mulai Registrasi
                    </label>

                    <input
                        type="date"
                        name="registration_start_date"
                        value="{{ old('registration_start_date') }}"
                        required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3">

                    @error('registration_start_date')
                        <p class="text-sm text-red-600 mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <div>

                    <label class="block mb-2.5 text-sm font-medium text-heading">
                        Tanggal Selesai Registrasi
                    </label>

                    <input
                        type="date"
                        name="registration_end_date"
                        value="{{ old('registration_end_date') }}"
                        required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3">

                    @error('registration_end_date')
                        <p class="text-sm text-red-600 mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <div class="md:col-span-2">

                    <label class="block mb-2.5 text-sm font-medium text-heading">
                        Batas Pembayaran
                    </label>

                    <input
                        type="date"
                        name="payment_due_date"
                        value="{{ old('payment_due_date') }}"
                        required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3">

                    @error('payment_due_date')
                        <p class="text-sm text-red-600 mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <div class="md:col-span-2">

                    <label class="block mb-2.5 text-sm font-medium text-heading">
                        Catatan
                    </label>

                    <textarea
                        name="notes"
                        rows="4"
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 resize-none"
                        placeholder="Masukkan catatan tambahan (opsional)">{{ old('notes') }}</textarea>

                    @error('notes')
                        <p class="text-sm text-red-600 mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

            <div
                class="rounded-2xl border border-blue-200 bg-blue-50 px-5 py-4 text-sm text-blue-700">

                Sistem akan membuka dan menutup registrasi sesuai periode yang ditentukan.
                Admin tetap dapat mengelola status registrasi melalui halaman manajemen periode.

            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3 pt-4">

                <x-button.button-menu
                    type="submit"
                    variant="primary"
                    size="md"
                    class="w-full sm:w-auto"
                    data-confirm
                    data-confirm-title="Simpan Periode Registrasi?"
                    data-confirm-text="Pastikan seluruh data yang dimasukkan sudah benar."
                    data-confirm-button-text="Ya, Simpan">

                    Simpan Periode

                </x-button.button-menu>

                <x-button.button-menu
                    href="{{ route('admin.occupancy-periods.index') }}"
                    variant="outline"
                    size="md"
                    class="w-full sm:w-auto">

                    Batal

                </x-button.button-menu>

            </div>

        </form>

    </div>

@endsection