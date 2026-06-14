@extends('layouts.app')

@section('title', 'Tambah Periode Registrasi Ulang')
@section('page_title', 'Tambah Periode Registrasi Ulang')

@section('content')

    <div class="space-y-6">

        <div>
            <h1 class="text-3xl font-black text-slate-900">
                Tambah Periode Registrasi Ulang
            </h1>

            <p class="mt-2 text-slate-500">
                Buat periode registrasi ulang semester ganjil atau genap.
            </p>
        </div>

        <form action="{{ route('admin.occupancy-periods.store') }}" method="POST"
            class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm space-y-6">

            @csrf

            <div class="grid md:grid-cols-2 gap-5">

                <div>
                    <label class="block mb-2 text-sm font-bold text-slate-700">
                        Jenis Semester
                    </label>

                    <select name="semester_type" class="w-full rounded-2xl border border-slate-300 px-4 py-3">
                        <option value="ganjil" @selected(old('semester_type') === 'ganjil')>
                            Semester Ganjil
                        </option>
                        <option value="genap" @selected(old('semester_type') === 'genap')>
                            Semester Genap
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-bold text-slate-700">
                        Tahun Akademik
                    </label>

                    <select name="academic_year_start" class="w-full rounded-2xl border border-slate-300 px-4 py-3">
                        <option value="{{ $currentYear }}" selected>
                            {{ $currentYear }}/{{ $currentYear + 1 }}
                        </option>
                    </select>
                </div>

            </div>

            <div class="grid md:grid-cols-2 gap-5">

                <div>
                    <label class="block mb-2 text-sm font-bold text-slate-700">
                        Tanggal Mulai Registrasi
                    </label>

                    <input type="date" name="registration_start_date" value="{{ old('registration_start_date') }}"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-bold text-slate-700">
                        Tanggal Selesai Registrasi
                    </label>

                    <input type="date" name="registration_end_date" value="{{ old('registration_end_date') }}"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3">
                </div>

            </div>

            <div>
                <label class="block mb-2 text-sm font-bold text-slate-700">
                    Batas Pembayaran
                </label>

                <input type="date" name="payment_due_date" value="{{ old('payment_due_date') }}"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3">
            </div>

            <div>
                <label class="block mb-2 text-sm font-bold text-slate-700">
                    Catatan
                </label>

                <textarea name="notes" rows="4" class="w-full rounded-2xl border border-slate-300 px-4 py-3">{{ old('notes') }}</textarea>
            </div>

            <div class="rounded-2xl border border-blue-200 bg-blue-50 px-5 py-4 text-sm text-blue-700">
                Sistem akan otomatis membuka registrasi sesuai tanggal. Admin tetap dapat membuka atau menutup manual
                melalui tombol aksi.
            </div>

            <div class="flex gap-3">

                <a href="{{ route('admin.occupancy-periods.index') }}"
                    class="rounded-2xl bg-slate-100 px-5 py-3 font-black text-slate-700 hover:bg-slate-200">
                    Kembali
                </a>

                <button type="submit"
                    class="rounded-2xl bg-orange-500 px-5 py-3 font-black text-white hover:bg-orange-600">
                    Simpan Periode
                </button>

            </div>

        </form>

    </div>

@endsection
