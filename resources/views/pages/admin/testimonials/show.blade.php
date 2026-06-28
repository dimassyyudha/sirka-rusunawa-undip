@extends('layouts.app')

@section('title', 'Detail Testimoni')
@section('page_title', 'Detail Testimoni')

@section('content')

    <div class="max-w-4xl mx-auto space-y-6">

        {{-- HEADER --}}
        <div>

            <a href="{{ route('admin.testimoni.index') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">

                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />

                </svg>

                Kembali

            </a>

            <h1 class="mt-4 text-3xl font-black text-slate-900">
                Detail Testimoni
            </h1>

            <p class="mt-2 text-slate-500">
                Informasi lengkap mengenai testimoni yang diberikan oleh penghuni Rusunawa Universitas Diponegoro.
            </p>

        </div>

        {{-- DATA PENGHUNI --}}
        <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm overflow-hidden">

            <div class="border-b border-slate-200 bg-slate-50 px-6 py-5">

                <h2 class="text-lg font-black text-slate-900">
                    Data Penghuni
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Informasi mahasiswa yang memberikan testimoni terhadap kamar Rusunawa.
                </p>

            </div>

            <div class="p-6">

                <div class="grid md:grid-cols-2 gap-6">

                    <div>

                        <label class="block text-sm font-semibold text-slate-500 mb-2">
                            Nama Mahasiswa
                        </label>

                        <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 font-bold text-slate-900">

                            {{ $testimonial->user->name }}

                        </div>

                    </div>

                    <div>

                        <label class="block text-sm font-semibold text-slate-500 mb-2">
                            Tanggal Testimoni
                        </label>

                        <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 font-bold text-slate-900">

                            {{ $testimonial->created_at->translatedFormat('d F Y H:i') }}
                            {{-- {{ $testimonial->created_at->timezone('Asia/Jakarta')->translatedFormat('d F Y H:i') }} WIB --}}

                        </div>

                    </div>

                    <div>

                        <label class="block text-sm font-semibold text-slate-500 mb-2">
                            Kamar
                        </label>

                        <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 font-bold text-[#070B55]">

                            {{ $testimonial->room->kode_kamar }}

                        </div>

                    </div>

                    <div>

                        <label class="block text-sm font-semibold text-slate-500 mb-2">
                            Gedung
                        </label>

                        <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 font-bold text-slate-900">

                            {{ $testimonial->room->floor->building->name }}

                        </div>

                    </div>

                    <div class="md:col-span-2">

                        <label class="block text-sm font-semibold text-slate-500 mb-2">
                            Rating yang Diberikan
                        </label>

                        <div
                            class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-4 flex items-center justify-between">

                            <div class="flex items-center gap-1">

                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-6 h-6 {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-slate-300' }}"
                                        fill="currentColor" viewBox="0 0 24 24">

                                        <path
                                            d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />

                                    </svg>
                                @endfor

                            </div>

                            <div class="text-right">

                                <div class="text-2xl font-black text-amber-500">
                                    {{ $testimonial->rating }}/5
                                </div>

                                <div class="text-sm text-slate-500">

                                    @switch($testimonial->rating)
                                        @case(5)
                                            Sangat Baik
                                        @break

                                        @case(4)
                                            Baik
                                        @break

                                        @case(3)
                                            Cukup
                                        @break

                                        @case(2)
                                            Kurang Baik
                                        @break

                                        @default
                                            Sangat Kurang
                                    @endswitch

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- TESTIMONI --}}
        <div class="bg-white rounded-[10px] border border-slate-200 shadow-sm overflow-hidden">

            <div class="border-b border-slate-200 bg-slate-50 px-6 py-5">

                <h2 class="text-lg font-black text-slate-900">
                    Testimoni Penghuni
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Pendapat, pengalaman, dan masukan yang diberikan penghuni selama menempati kamar Rusunawa.
                </p>

            </div>

            <div class="p-6">

                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">

                    <p class="leading-8 text-slate-700 whitespace-pre-line">

                        {{ $testimonial->comment ?: 'Penghuni tidak memberikan komentar tambahan.' }}

                    </p>

                </div>

            </div>

        </div>

    </div>

@endsection
