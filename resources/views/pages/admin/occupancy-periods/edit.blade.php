@extends('layouts.app')

@section('title', 'Edit Periode Hunian')
@section('page_title', 'Edit Periode Hunian')

@section('content')

    @php
        $currentYear = now()->year;
    @endphp

    <div class="space-y-6">

        <div>
            <h1 class="text-3xl font-black text-slate-900">
                Edit Periode Hunian
            </h1>

            <p class="mt-2 text-slate-500">
                Perbarui periode hunian berdasarkan semester dan tahun akademik berjalan.
            </p>
        </div>

        <form action="{{ route('admin.occupancy-periods.update', $occupancyPeriod) }}" method="POST"
            class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-6">

            @csrf
            @method('PUT')

            <div class="grid md:grid-cols-2 gap-5">

                <div>
                    <label class="block mb-2 text-sm font-bold text-slate-700">
                        Jenis Semester
                    </label>

                    <select name="semester_type" class="w-full rounded-2xl border border-slate-300 px-4 py-3">
                        <option value="ganjil" @selected(old('semester_type', $occupancyPeriod->semester_type) === 'ganjil')>
                            Semester Ganjil
                        </option>
                        <option value="genap" @selected(old('semester_type', $occupancyPeriod->semester_type) === 'genap')>
                            Semester Genap
                        </option>
                    </select>

                    @error('semester_type')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-bold text-slate-700">
                        Tahun Akademik
                    </label>

                    <select name="academic_year_start" class="w-full rounded-2xl border border-slate-300 px-4 py-3">
                        <option value="{{ $currentYear }}" @selected(old('academic_year_start', $occupancyPeriod->academic_year_start) == $currentYear)>

                            {{ $currentYear }}/{{ $currentYear + 1 }}

                        </option>
                    </select>

                    @error('academic_year_start')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="grid md:grid-cols-2 gap-5">

                <div>
                    <label class="block mb-2 text-sm font-bold text-slate-700">
                        Tanggal Mulai Registrasi
                    </label>

                    <input type="date" name="registration_start_date"
                        value="{{ old('registration_start_date', $occupancyPeriod->registration_start_date?->format('Y-m-d')) }}"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3">

                    @error('registration_start_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-bold text-slate-700">
                        Tanggal Selesai Registrasi
                    </label>

                    <input type="date" name="registration_end_date"
                        value="{{ old('registration_end_date', $occupancyPeriod->registration_end_date?->format('Y-m-d')) }}"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3">

                    @error('registration_end_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="grid md:grid-cols-2 gap-5">

                <div>
                    <label class="block mb-2 text-sm font-bold text-slate-700">
                        Batas Pembayaran
                    </label>

                    <input type="date" name="payment_due_date"
                        value="{{ old('payment_due_date', $occupancyPeriod->payment_due_date?->format('Y-m-d')) }}"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3">

                    @error('payment_due_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-bold text-slate-700">
                        Status
                    </label>

                    <select name="status" class="w-full rounded-2xl border border-slate-300 px-4 py-3">

                        <option value="upcoming" @selected(old('status', $occupancyPeriod->status) === 'upcoming')>

                            Akan Dibuka

                        </option>

                        <option value="open" @selected(old('status', $occupancyPeriod->status) === 'open')>

                            Registrasi Dibuka

                        </option>

                        <option value="closed" @selected(old('status', $occupancyPeriod->status) === 'closed')>

                            Registrasi Ditutup

                        </option>

                    </select>

                    @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div>
                <label class="block mb-2 text-sm font-bold text-slate-700">
                    Catatan
                </label>

                <textarea name="notes" rows="4" class="w-full rounded-2xl border border-slate-300 px-4 py-3">{{ old('notes', $occupancyPeriod->notes) }}</textarea>

                @error('notes')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="rounded-2xl border border-blue-200 bg-blue-50 px-5 py-4 text-sm text-blue-700">
                Masa hunian akan dihitung ulang otomatis berdasarkan semester dan tahun akademik yang dipilih.
            </div>

            <div class="flex flex-wrap gap-3 pt-2">

                <a href="{{ route('admin.occupancy-periods.index') }}"
                    class="px-5 py-3 rounded-2xl bg-slate-100 text-slate-700 hover:bg-slate-200 font-black transition">
                    Kembali
                </a>

                <button type="submit"
                    class="px-5 py-3 rounded-2xl bg-orange-500 hover:bg-orange-600 text-white font-black transition">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

@endsection
