@extends('landing.landing')

@section('title', 'Review Reservasi')

@section('content')

    <section class="min-h-screen bg-slate-50 py-10">


        <div class="mx-auto max-w-6xl px-4">

            <x-ui.reservation-stepper :step="2" status="pending" />

            <form action="{{ route('Reservation.store', $room->room_id) }}" method="POST" class="mt-8">

                @csrf
                <input type="hidden" name="room_id" value="{{ $room->room_id }}">
                <input type="hidden" name="profile_photo_path" value="{{ $data['profile_photo_path'] ?? '' }}">

                <input type="hidden" name="ktm_path" value="{{ $data['ktm_path'] ?? '' }}">

                <input type="hidden" name="stnk_path" value="{{ $data['stnk_path'] ?? '' }}">
                @foreach ($data as $key => $value)
                    @if (!is_array($value))
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach

                <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                    <div class="border-b border-slate-200 px-8 py-6">

                        <h1 class="text-2xl font-black text-slate-900">
                            Review Reservasi
                        </h1>

                        <p class="mt-2 text-sm text-slate-500">
                            Pastikan seluruh data sudah benar sebelum melanjutkan pembayaran.
                        </p>

                    </div>

                    <div class="grid lg:grid-cols-3">

                        <div class="lg:col-span-2">

                            <div class="space-y-10 p-8">

                                <div>

                                    <h2 class="mb-5 text-lg font-bold text-slate-900">
                                        Informasi Mahasiswa
                                    </h2>

                                    <div class="grid gap-5 sm:grid-cols-2">

                                        <div>
                                            <p class="text-sm text-slate-500">
                                                Nama Mahasiswa
                                            </p>

                                            <p class="mt-1 font-semibold text-slate-900">
                                                {{ $data['guest_name'] ?? '-' }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-sm text-slate-500">
                                                NIM
                                            </p>

                                            <p class="mt-1 font-semibold text-slate-900">
                                                {{ $data['guest_nim'] ?? '-' }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-sm text-slate-500">
                                                Fakultas
                                            </p>

                                            <p class="mt-1 font-semibold text-slate-900">
                                                {{ $data['guest_faculty'] ?? '-' }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-sm text-slate-500">
                                                Program Studi
                                            </p>

                                            <p class="mt-1 font-semibold text-slate-900">
                                                {{ $data['guest_major'] ?? '-' }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-sm text-slate-500">
                                                Angkatan
                                            </p>

                                            <p class="mt-1 font-semibold text-slate-900">
                                                {{ $data['guest_intake_year'] ?? '-' }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-sm text-slate-500">
                                                Email
                                            </p>

                                            <p class="mt-1 font-semibold text-slate-900">
                                                {{ $data['contact_email'] ?? '-' }}
                                            </p>
                                        </div>

                                    </div>

                                </div>

                                <div class="border-t border-slate-200 pt-10">

                                    <h2 class="mb-5 text-lg font-bold text-slate-900">
                                        Informasi Orang Tua / Wali
                                    </h2>

                                    <div class="grid gap-5 sm:grid-cols-2">

                                        <div>
                                            <p class="text-sm text-slate-500">
                                                Nama Orang Tua
                                            </p>

                                            <p class="mt-1 font-semibold text-slate-900">
                                                {{ $data['parent_name'] ?? '-' }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-sm text-slate-500">
                                                Nomor HP
                                            </p>

                                            <p class="mt-1 font-semibold text-slate-900">
                                                {{ $data['parent_phone'] ?? '-' }}
                                            </p>
                                        </div>

                                    </div>

                                </div>

                                <div class="border-t border-slate-200 pt-10">

                                    <h2 class="mb-5 text-lg font-bold text-slate-900">
                                        Detail Reservasi
                                    </h2>

                                    <div class="overflow-hidden rounded-2xl border border-slate-200">

                                        <table class="w-full">

                                            <tbody class="divide-y divide-slate-200">

                                                <tr>

                                                    <td class="px-5 py-4 text-sm text-slate-500">
                                                        Kode Kamar
                                                    </td>

                                                    <td class="px-5 py-4 text-right font-bold text-slate-900">
                                                        {{ $data['room_code'] ?? '-' }}
                                                    </td>

                                                </tr>

                                                <tr>

                                                    <td class="px-5 py-4 text-sm text-slate-500">
                                                        Tipe Hunian
                                                    </td>

                                                    <td class="px-5 py-4 text-right font-bold text-slate-900">
                                                        {{ ucfirst($data['occupancy_type'] ?? '-') }}
                                                    </td>

                                                </tr>

                                                <tr>

                                                    <td class="px-5 py-4 text-sm text-slate-500">
                                                        Tanggal Masuk
                                                    </td>

                                                    <td class="px-5 py-4 text-right font-bold text-slate-900">
                                                        {{ $data['start_date'] ?? '-' }}
                                                    </td>

                                                </tr>

                                                <tr>

                                                    <td class="px-5 py-4 text-sm text-slate-500">
                                                        Tanggal Selesai
                                                    </td>

                                                    <td class="px-5 py-4 text-right font-bold text-slate-900">
                                                        {{ $data['end_date'] ?? '-' }}
                                                    </td>

                                                </tr>

                                                <tr>

                                                    <td class="px-5 py-4 text-sm text-slate-500">
                                                        Durasi
                                                    </td>

                                                    <td class="px-5 py-4 text-right font-bold text-slate-900">
                                                        {{ $data['duration_month'] ?? 6 }}
                                                        Bulan
                                                    </td>

                                                </tr>

                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="border-l border-slate-200 bg-slate-50/70">

                            <div class="sticky top-24 p-8">

                                <h2 class="mb-6 text-xl font-black text-slate-900">
                                    Order Summary
                                </h2>

                                <div class="space-y-4">

                                    <div class="flex items-center justify-between">

                                        <span class="text-slate-500">
                                            Harga / Bulan
                                        </span>

                                        <span class="font-semibold">
                                            Rp {{ number_format($data['price_per_month'] ?? 0, 0, ',', '.') }}
                                        </span>

                                    </div>

                                    <div class="flex items-center justify-between">

                                        <span class="text-slate-500">
                                            Durasi
                                        </span>

                                        <span class="font-semibold">
                                            {{ $data['duration_month'] ?? 6 }}
                                            Bulan
                                        </span>

                                    </div>

                                    <div class="flex items-center justify-between">

                                        <span class="text-slate-500">
                                            Slot Hunian
                                        </span>

                                        <span class="font-semibold">
                                            {{ $data['slot_used'] ?? 1 }}
                                        </span>

                                    </div>

                                    <div class="flex items-center justify-between">

                                        <span class="text-slate-500">
                                            Biaya Admin
                                        </span>

                                        <span class="font-semibold">
                                            Rp 0
                                        </span>

                                    </div>

                                    <div class="border-t border-slate-200 pt-4">

                                        <div class="flex items-center justify-between">

                                            <span class="text-lg font-black text-slate-900">
                                                Total
                                            </span>

                                            <span class="text-2xl font-black text-blue-700">
                                                Rp {{ number_format($data['total_price'] ?? 0, 0, ',', '.') }}
                                            </span>

                                        </div>

                                    </div>

                                </div>

                                <div class="mt-8 rounded-2xl border border-amber-200 bg-amber-50 p-4">

                                    <label class="flex items-start gap-3">

                                        <input type="checkbox" required class="mt-1 rounded border-slate-300">

                                        <span class="text-sm text-slate-700">

                                            Saya telah membaca dan menyetujui
                                            syaratKetentuan & Conditions Rusunawa UNDIP.

                                        </span>

                                    </label>

                                </div>

                                <div class="mt-8 flex flex-col gap-3">

                                    <x-button.button-menu type="submit" variant="warning" size="lg">

                                        Lanjut ke Pembayaran

                                    </x-button.button-menu>

                                    <x-button.button-menu href="{{ route('Reservation.create', $room->room_id) }}"
                                        variant="outline" size="lg">

                                        Kembali

                                    </x-button.button-menu>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </div>


    </section>

@endsection
