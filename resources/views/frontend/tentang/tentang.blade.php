@extends('landing.landing')

@section('title', 'Tentang Kami - SIRKA Rusunawa UNDIP')
@section('mainClass', 'w-full max-w-none px-0')

@section('content')

    @php

        $imageUrl = function ($path) {
            if (empty($path)) {
                return null;
            }

            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                return $path;
            }

            if (str_starts_with($path, '/storage/')) {
                return asset(ltrim($path, '/'));
            }

            if (str_starts_with($path, 'storage/')) {
                return asset($path);
            }

            if (str_starts_with($path, 'assets-admin/')) {
                return asset($path);
            }

            return asset('storage/' . ltrim($path, '/'));
        };

    @endphp

    <section class="bg-slate-50 py-14 md:py-20">
        <div class="mx-auto max-w-7xl px-4 md:px-8">

            {{-- HEADER --}}
            <div class="rounded-[32px] border border-slate-200 bg-white p-8 md:p-10 shadow-sm">

                <span class="inline-flex rounded-full bg-indigo-100 px-5 py-2 text-sm font-semibold text-indigo-700">
                    {{ $tentang['badge'] ?? 'Tentang Kami' }}
                </span>

                <h1 class="mt-5 text-4xl font-black leading-tight text-slate-900 md:text-5xl">
                    {{ $tentang['title'] ?? 'Mengenal Rusunawa UNDIP Lebih Dekat' }}
                </h1>

                <p class="mt-5 max-w-4xl text-sm leading-relaxed text-slate-600 md:text-base">
                    {{ $tentang['description'] ?? '' }}
                </p>
            </div>

            {{-- BLOCKS --}}
            <div class="mt-8 space-y-8">

                @forelse(($tentang['blocks'] ?? []) as $i => $block)

                    @php
                        $img = $imageUrl($block['image'] ?? null);

                        $items = array_values(array_filter($block['items'] ?? [], fn($x) => trim((string) $x) !== ''));
                    @endphp

                    <div class="grid gap-8 rounded-[32px] border border-slate-200 bg-white p-8 shadow-sm lg:grid-cols-12">

                        {{-- IMAGE --}}
                        @if ($img)
                            <div class="{{ $i % 2 === 0 ? 'lg:col-span-5' : 'lg:col-span-5 lg:order-2' }}">

                                <div class="overflow-hidden rounded-[10px] border border-slate-200 bg-slate-100">

                                    <img src="{{ $img }}" class="h-[320px] w-full object-cover md:h-[420px]"
                                        alt="{{ $block['title'] ?? 'Tentang Kami' }}">

                                </div>

                            </div>
                        @endif

                        {{-- TEXT --}}
                        <div
                            class="
                {{ $img ? ($i % 2 === 0 ? 'lg:col-span-7' : 'lg:col-span-7 lg:order-1') : 'lg:col-span-12' }}
                flex flex-col justify-center
            ">

                            <span
                                class="inline-flex w-fit rounded-full bg-slate-100 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-600">
                                {{ $block['type'] ?? 'Blok' }}
                            </span>

                            <h2 class="mt-5 text-3xl font-black leading-tight text-slate-900 md:text-4xl">
                                {{ $block['title'] ?? '-' }}
                            </h2>

                            @if (!empty($block['body']))
                                <p class="mt-5 text-sm leading-relaxed text-slate-600 md:text-base">
                                    {{ $block['body'] }}
                                </p>
                            @endif
                            @if (strtolower(trim($block['type'] ?? '')) === 'aturan')
                                <div class="mt-5 rounded-2xl border border-blue-200 bg-blue-50 p-5">

                                    <p class="text-sm leading-relaxed text-slate-700">

                                        Informasi pada bagian ini merupakan ringkasan aturan umum penghuni
                                        Rusunawa Universitas Diponegoro. Untuk membaca tata tertib,
                                        kewajiban penghuni, larangan, sanksi, serta ketentuan hunian
                                        secara lengkap, silakan kunjungi halaman Syarat & Ketentuan.

                                    </p>

                                    <a href="{{ route('page.syarat-ketentuan') }}"
                                        class="mt-4 inline-flex items-center gap-2 rounded-xl bg-[#070B55] px-4 py-2 text-sm font-bold text-white transition hover:bg-[#0f1a9e]">

                                        Baca Syarat & Ketentuan Lengkap

                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />

                                        </svg>

                                    </a>

                                </div>
                            @endif

                            @if (!empty($items))
                                <div class="mt-7 space-y-3">

                                    @foreach ($items as $item)
                                        <div
                                            class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4">

                                            <div
                                                class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-indigo-600 text-white">

                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">

                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />

                                                </svg>

                                            </div>

                                            <p class="text-sm leading-relaxed text-slate-700 md:text-base">
                                                {{ $item }}
                                            </p>

                                        </div>
                                    @endforeach

                                </div>
                            @endif

                        </div>

                    </div>

                @empty

                    <div
                        class="rounded-[32px] border border-dashed border-slate-300 bg-white p-12 text-center text-sm text-slate-500">
                        Belum ada konten Tentang Kami.
                    </div>

                @endforelse

            </div>

        </div>
    </section>

@endsection
