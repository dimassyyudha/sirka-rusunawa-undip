@extends('layouts.app')

@section('title', 'Manajemen Testimoni')
@section('page_title', 'Manajemen Testimoni')

@section('content')

    <div class="space-y-6">


        <div>
            <h2 class="text-2xl font-black text-slate-900">
                Manajemen Testimoni
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Kelola seluruh testimoni penghuni Rusunawa
            </p>
        </div>
        <div class="grid md:grid-cols-4 gap-4 mb-6">

            <div class="bg-white rounded-[10px] border border-slate-200 p-6">
                <p class="text-sm text-slate-500">
                    Total Testimoni
                </p>

                <h3 class="text-3xl font-black">
                    {{ $totalTestimonials }}
                </h3>
            </div>

            <div class="bg-white rounded-[10px] border border-slate-200 p-6">
                <p class="text-sm text-slate-500">
                    Rating Rata-rata
                </p>

                <h3 class="text-3xl font-black text-amber-500">
                    {{ $averageRating }}
                </h3>
            </div>

            <div class="bg-white rounded-[10px] border border-slate-200 p-6">
                <p class="text-sm text-slate-500">
                    Ditampilkan
                </p>

                <h3 class="text-3xl font-black text-green-600">
                    {{ $visibleCount }}
                </h3>
            </div>

            <div class="bg-white rounded-[10px] border border-slate-200 p-6">
                <p class="text-sm text-slate-500">
                    Disembunyikan
                </p>

                <h3 class="text-3xl font-black text-red-600">
                    {{ $hiddenCount }}
                </h3>
            </div>

        </div>

        <form id="filterForm" method="GET" class="mb-6 rounded-[20px] border border-slate-200 bg-white p-5 shadow-sm">

            <div class="grid gap-4 lg:grid-cols-7">

                {{-- SEARCH --}}
                <div class="lg:col-span-2">

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Pencarian
                    </label>

                    <input id="searchInput" type="text" name="search" value="{{ request('search') }}"
                        placeholder="Mahasiswa, kamar, testimoni..."
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                </div>

                {{-- GEDUNG --}}
                <div>

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Gedung
                    </label>

                    <select name="building_id"
                        class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                        <option value="">
                            Semua Gedung
                        </option>

                        @foreach ($buildings as $building)
                            <option value="{{ $building->building_id }}" @selected(request('building_id') == $building->building_id)>

                                {{ $building->code }}

                            </option>
                        @endforeach

                    </select>

                </div>

                {{-- RATING --}}
                <div>

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Rating
                    </label>

                    <select name="rating" class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                        <option value="">
                            Semua Rating
                        </option>

                        @for ($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" @selected(request('rating') == $i)>

                                {{ $i }} Bintang

                            </option>
                        @endfor

                    </select>

                </div>

                {{-- STATUS --}}
                <div>

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Status
                    </label>

                    <select name="visibility"
                        class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                        <option value="">
                            Semua Status
                        </option>

                        <option value="1" @selected(request('visibility') === '1')>

                            Ditampilkan

                        </option>

                        <option value="0" @selected(request('visibility') === '0')>

                            Disembunyikan

                        </option>

                    </select>

                </div>

                {{-- SORT --}}
                <div>

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">
                        Urutkan
                    </label>

                    <select name="sort" class="auto-filter w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                        <option value="latest" @selected(request('sort') === 'latest')>

                            Terbaru

                        </option>

                        <option value="oldest" @selected(request('sort') === 'oldest')>

                            Terlama

                        </option>

                        <option value="rating_desc" @selected(request('sort') === 'rating_desc')>

                            Rating Tertinggi

                        </option>

                        <option value="rating_asc" @selected(request('sort') === 'rating_asc')>

                            Rating Terendah

                        </option>

                    </select>

                </div>

                {{-- BUTTON --}}
                <div>

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-transparent">
                        Action
                    </label>

                    <div class="flex gap-2">

                        <button type="submit"
                            class="flex-1 rounded-xl bg-violet-600 px-4 py-3 text-sm font-bold text-white hover:bg-violet-700">

                            Filter

                        </button>

                        <a href="{{ route('admin.testimoni.index') }}"
                            class="flex-1 rounded-xl border border-slate-300 px-4 py-3 text-center text-sm font-bold text-slate-700 hover:bg-slate-50">

                            Reset

                        </a>

                    </div>

                </div>

            </div>

        </form>
        <div class="relative overflow-x-auto bg-white shadow-sm rounded-[10px] border border-slate-200">

            <table class="w-full text-sm text-center text-black">

                <thead class="text-xs uppercase bg-slate-50 border-b border-slate-200">

                    <tr>

                        <th class="px-6 py-4 font-black">
                            No
                        </th>

                        <th class="px-6 py-4 font-black">
                            Mahasiswa
                        </th>

                        <th class="px-6 py-4 font-black">
                            Kamar
                        </th>

                        <th class="px-6 py-4 font-black">
                            Gedung
                        </th>

                        <th class="px-6 py-4 font-black">
                            Rating
                        </th>

                        <th class="px-6 py-4 font-black">
                            Komentar
                        </th>

                        <th class="px-6 py-4 font-black">
                            Status
                        </th>

                        <th class="px-6 py-4 font-black">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 font-black">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100 text-center whitespace-nowrap">

                    @forelse($testimonials as $testimonial)
                        <tr class="bg-white hover:bg-slate-50 transition">

                            <td class="px-6 py-4 font-semibold">
                                {{ $testimonials->firstItem() + $loop->index }}
                            </td>

                            <td class="px-6 py-4 font-bold">
                                {{ $testimonial->user->name }}
                            </td>

                            <td class="px-6 py-4 font-black text-[#070B55]">
                                {{ $testimonial->room->kode_kamar }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $testimonial->room->floor->building->code }}
                            </td>

                            <td class="px-6 py-4">

                                <span class="font-black text-amber-500">
                                    {{ $testimonial->rating }}/5
                                </span>

                            </td>

                            <td class="px-6 py-4 text-left max-w-xs">

                                {{ Str::limit($testimonial->comment, 50) }}

                            </td>

                            <td class="px-6 py-4">

                                @if ($testimonial->is_visible)
                                    <x-ui.badge type="success" label="Ditampilkan" />
                                @else
                                    <x-ui.badge type="danger" label="Disembunyikan" />
                                @endif

                            </td>

                            <td class="px-6 py-4">
                                {{-- {{ $testimonial->created_at->format('d M Y') }} --}}
                                {{ $testimonial->created_at->timezone('Asia/Jakarta')->translatedFormat('d F Y H:i') }} WIB
                            </td>

                            <td class="px-6 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    <a href="{{ route('admin.testimoni.show', $testimonial) }}"
                                        class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-bold text-white hover:bg-blue-700 transition">

                                        Detail

                                    </a>
                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9" class="px-6 py-12 text-center text-slate-500 font-semibold">

                                Belum ada testimoni.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>



        </div>

        <div class="border-t border-slate-200 px-6 py-4">

            <x-ui.pagination :paginator="$testimonials" />

        </div>
    </div>

@endsection
