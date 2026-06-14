@extends('layouts.app')

@section('title', 'Pengaturan Tentang Kami')

@section('content')
    @php
        $imageUrl = function ($path) {
            if (empty($path)) {
                return null;
            }

            /*
        |--------------------------------------------------------------------------
        | FULL URL
        |--------------------------------------------------------------------------
        */

            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                return $path;
            }

            /*
        |--------------------------------------------------------------------------
        | STORAGE URL
        |--------------------------------------------------------------------------
        */

            if (str_starts_with($path, '/storage/')) {
                return asset(ltrim($path, '/'));
            }

            if (str_starts_with($path, 'storage/')) {
                return asset($path);
            }

            /*
        |--------------------------------------------------------------------------
        | ASSET ADMIN
        |--------------------------------------------------------------------------
        */

            if (str_starts_with($path, 'assets-admin/')) {
                return asset($path);
            }

            /*
        |--------------------------------------------------------------------------
        | DEFAULT STORAGE
        |--------------------------------------------------------------------------
        */

            return asset('storage/' . ltrim($path, '/'));
        };
    @endphp

    <div class="min-h-screen bg-slate-50 px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl space-y-6">

            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Pengaturan Tentang Kami
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Preview lengkap konten Tentang Kami yang tampil di landing page.
                    </p>
                </div>

                <x-button.button-menu href="{{ route('admin.settings.tentang-kami.edit') }}" variant="primary">
                    Edit Tentang Kami
                </x-button.button-menu>

            </div>

            {{-- @if (session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif --}}

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <span class="inline-flex rounded-full bg-indigo-50 px-4 py-1 text-sm font-semibold text-indigo-700">
                    {{ $data['badge'] ?? 'Tentang Kami' }}
                </span>

                <h2 class="mt-4 text-3xl font-bold text-slate-900">
                    {{ $data['title'] ?? '-' }}
                </h2>

                <p class="mt-3 max-w-4xl text-sm leading-relaxed text-slate-600">
                    {{ $data['description'] ?? '-' }}
                </p>
            </div>

            @forelse(($data['blocks'] ?? []) as $i => $block)
                @php
                    $img = $imageUrl($block['image'] ?? null);
                @endphp

                <div class="grid gap-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:grid-cols-12">
                    <div class="{{ $i % 2 === 0 ? 'lg:col-span-5' : 'lg:col-span-5 lg:order-2' }}">
                        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-100">
                            @php
                                $img = $imageUrl($block['image'] ?? null);
                            @endphp

                            @if ($img)
                                <img src="{{ $img }}" class="h-72 w-full object-cover"
                                    alt="{{ $block['title'] ?? 'Tentang Kami' }}">
                            @else
                                <div class="flex h-72 items-center justify-center text-sm text-slate-400">
                                    Gambar belum diupload
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="{{ $i % 2 === 0 ? 'lg:col-span-7' : 'lg:col-span-7 lg:order-1' }}">
                        <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                            {{ $block['type'] ?? 'Blok' }}
                        </span>

                        <h3 class="mt-3 text-2xl font-bold text-slate-900">
                            {{ $block['title'] ?? '-' }}
                        </h3>

                        <p class="mt-3 text-sm leading-relaxed text-slate-600">
                            {{ $block['body'] ?? '-' }}
                        </p>

                        <div class="mt-5 space-y-3">
                            @forelse(($block['items'] ?? []) as $item)
                                <div
                                    class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700">
                                    {{ $item }}
                                </div>
                            @empty
                                <p class="text-sm text-slate-400">
                                    Belum ada item.
                                </p>
                            @endforelse
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center text-sm text-slate-500">
                    Belum ada blok Tentang Kami.
                </div>
            @endforelse

        </div>
    </div>
@endsection
