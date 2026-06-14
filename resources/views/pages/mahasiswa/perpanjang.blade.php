@extends('layouts.app')

@section('title', 'Perpanjang Sewa')
@section('page_title', 'Perpanjang Sewa')

@section('content')

    <div class="grid xl:grid-cols-3 gap-6">

        <div class="xl:col-span-2 bg-white rounded-[30px] border border-slate-200 p-6 shadow-sm">

            <h2 class="text-2xl font-black text-slate-900">
                Pengajuan Perpanjangan Sewa
            </h2>

            <p class="mt-2 text-slate-500">
                Ajukan perpanjangan masa tinggal apabila periode sewa hampir berakhir.
            </p>

            <form class="mt-6 space-y-5">

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Periode Perpanjangan
                    </label>

                    <select
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <option>Pilih periode</option>
                        <option>1 Bulan</option>
                        <option>3 Bulan</option>
                        <option>6 Bulan</option>
                        <option>12 Bulan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Catatan Pengajuan
                    </label>

                    <textarea rows="5"
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                        placeholder="Tuliskan catatan jika diperlukan"></textarea>
                </div>

                <button type="button"
                    class="px-6 py-3.5 rounded-2xl bg-orange-500 hover:bg-orange-600 text-white font-black transition">
                    Ajukan Perpanjangan
                </button>

            </form>

        </div>

        <div class="bg-white rounded-[30px] border border-slate-200 p-6 shadow-sm">

            <div class="w-14 h-14 rounded-3xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 8.25h18" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4.5 5.25h15A1.5 1.5 0 0121 6.75v12A1.5 1.5 0 0119.5 20.25h-15A1.5 1.5 0 013 18.75v-12A1.5 1.5 0 014.5 5.25z" />
                </svg>
            </div>

            <h3 class="mt-5 text-xl font-black text-slate-900">
                Catatan
            </h3>

            <p class="mt-2 text-slate-500 leading-relaxed">
                Pengajuan perpanjangan akan diverifikasi oleh admin sebelum status sewa diperbarui.
            </p>

        </div>

    </div>

@endsection
