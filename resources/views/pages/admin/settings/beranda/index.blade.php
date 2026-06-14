@extends('layouts.app')

@section('title', 'Pengaturan Beranda')

@section('content')
    @php
        $heroImageUrl = function ($path) {
            if (empty($path)) {
                return null;
            }
            if (str_starts_with($path, 'http')) {
                return $path;
            }
            if (str_starts_with($path, 'storage/')) {
                return asset($path);
            }
            if (str_starts_with($path, 'assets-admin/')) {
                return asset($path);
            }

            return asset('storage/' . $path);
        };
    @endphp

    <div class="min-h-screen bg-slate-50 px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl space-y-6">

            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Pengaturan Beranda</h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Kelola background hero dan teks yang tampil di landing page.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2 text-sm">
                    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-indigo-700">
                        Dashboard
                    </a>
                    <span class="text-slate-300">/</span>
                    <span class="font-medium text-slate-700">Pengaturan Beranda</span>
                </div>
            </div>

            @if (session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div
                    class="flex flex-col gap-4 border-b border-slate-200 px-5 py-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Hero Beranda Saat Ini</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Background aktif akan diputar otomatis berdasarkan nomor urut.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <x-button.button-menu href="{{ route('page.beranda') }}" target="_blank" variant="outline">
                            Lihat Landing
                        </x-button.button-menu>

                        <x-button.button-menu href="{{ route('admin.settings.beranda.edit') }}" variant="primary">
                            Edit Beranda
                        </x-button.button-menu>
                    </div>
                </div>

                <div class="grid gap-6 p-5 lg:grid-cols-12">
                    <div class="lg:col-span-8">
                        <div class="mb-4 flex items-center justify-between">
                            <h3 class="text-base font-semibold text-slate-900">Daftar Background</h3>
                            <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700">
                                {{ count($backgrounds ?? []) }} Background
                            </span>
                        </div>

                        @if (empty($backgrounds))
                            <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-6 text-center">
                                <p class="text-sm text-slate-500">
                                    Belum ada background. Klik <b>Edit Beranda</b> untuk upload gambar.
                                </p>
                            </div>
                        @else
                            <div class="overflow-hidden rounded-xl border border-slate-200">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                                        <thead class="bg-slate-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left font-semibold text-slate-700">Preview</th>
                                                <th class="px-4 py-3 text-left font-semibold text-slate-700">Status</th>
                                                <th class="px-4 py-3 text-left font-semibold text-slate-700">Urutan</th>
                                            </tr>
                                        </thead>

                                        <tbody class="divide-y divide-slate-200 bg-white">
                                            @foreach ($backgrounds as $b)
                                                @php
                                                    $imageUrl = $heroImageUrl($b['image'] ?? null);
                                                @endphp

                                                <tr class="hover:bg-slate-50">
                                                    <td class="px-4 py-3">
                                                        @if ($imageUrl)
                                                            <a href="{{ $imageUrl }}" target="_blank" class="block">
                                                                <img src="{{ $imageUrl }}" alt="Hero Background"
                                                                    class="h-20 w-32 rounded-lg border border-slate-200 object-cover shadow-sm">
                                                            </a>
                                                        @else
                                                            <div
                                                                class="flex h-20 w-32 items-center justify-center rounded-lg border border-dashed border-slate-300 bg-slate-50 text-xs text-slate-400">
                                                                No Image
                                                            </div>
                                                        @endif
                                                    </td>

                                                    <td class="px-4 py-3">
                                                        @if (!empty($b['is_active']))
                                                            <span
                                                                class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                                                Aktif
                                                            </span>
                                                        @else
                                                            <span
                                                                class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500">
                                                                Nonaktif
                                                            </span>
                                                        @endif
                                                    </td>

                                                    <td class="px-4 py-3">
                                                        <span class="font-semibold text-slate-800">
                                                            {{ $b['sort_order'] ?? 0 }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="lg:col-span-4">
                        <h3 class="mb-4 text-base font-semibold text-slate-900">Teks Hero</h3>

                        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                            <div class="border-b border-slate-200 p-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Headline</p>
                                <p class="mt-1 text-sm font-semibold text-slate-900">
                                    {{ $data['headline'] ?? '-' }}
                                </p>
                            </div>

                            <div class="border-b border-slate-200 p-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Subheadline</p>
                                <p class="mt-1 text-sm text-slate-700">
                                    {{ $data['subheadline'] ?? '-' }}
                                </p>
                            </div>

                            <div class="p-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Teks Tombol</p>
                                <p class="mt-1 text-sm font-semibold text-indigo-700">
                                    {{ $data['cta_text'] ?? '-' }}
                                </p>
                            </div>
                        </div>

                        <p class="mt-3 text-xs text-slate-500">
                            Tombol hero otomatis mengarah ke halaman Reservasi Kamar.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
