{{-- @extends('landing.landing')

@section('title', 'Detail Kamar ' . $room->kode_kamar . ' - SIRKA Rusunawa UNDIP')

@section('content')
    <section class="bg-slate-50 border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 py-6 space-y-6">

            <div class="text-xs text-slate-500 flex items-center gap-1">
                <a href="{{ route('page.beranda') }}" class="hover:underline">Beranda</a>
                <span>/</span>
                <a href="{{ route('cari-kamar.index') }}" class="hover:underline">Reservasi Kamar</a>
                <span>/</span>
                <span class="font-semibold text-slate-700">{{ $room->kode_kamar }}</span>
            </div>

            @php
                $building = $room->floor?->building;

                $gedungLabelUpper = strtoupper((string) ($building?->code ?? ($gedungLabel ?? '-')));
                $lantai = $room->floor?->floor_number ?? '-';

                $occupied = (int) ($occupied ?? ($room->occupied ?? 0));
                $capacity = (int) ($capacity ?? ($room->floor?->room_capacity ?? 2));
                $slots = max(0, $capacity - $occupied);
                $isAvailable = ($room->status ?? 'tersedia') === 'tersedia' && $slots > 0;

                $harga = (int) ($room->floor?->monthly_price ?? ($room->harga ?? 0));

                $gallery = [];

                if (method_exists($room, 'photos') && $room->photos && $room->photos->count()) {
                    $photos = $room->photos->sortBy('order')->sortByDesc('is_primary');

                    foreach ($photos as $p) {
                        $path = trim((string) ($p->path ?? ''));
                        if ($path !== '') {
                            $gallery[] = asset(ltrim($path, '/'));
                        }
                    }
                }

                if (empty($gallery) && !empty($room->foto)) {
                    $gallery[] = asset(ltrim((string) $room->foto, '/'));
                }

                if (empty($gallery) && $gedungLabelUpper !== '-') {
                    $folderMap = [
                        'A' => 'a',
                        'B' => 'b',
                        'C' => 'c',
                        'D' => 'd',
                        'E' => 'e',
                        'F' => 'f',
                    ];

                    $folder = $folderMap[$gedungLabelUpper] ?? null;

                    if ($folder) {
                        $exts = ['jpg', 'jpeg', 'png', 'webp'];

                        for ($i = 1; $i <= 6; $i++) {
                            foreach ($exts as $ext) {
                                $rel = "images/{$folder}/{$folder}{$i}.{$ext}";

                                if (file_exists(public_path($rel))) {
                                    $gallery[] = asset($rel);
                                    break;
                                }
                            }
                        }
                    }
                }

                if (empty($gallery)) {
                    $gallery = [
                        asset('assets-admin/images/hero-1.jpg'),
                        asset('assets-admin/images/hero-2.jpg'),
                        asset('assets-admin/images/hero-3.jpg'),
                    ];
                }

                $fasilitasList =
                    $fasilitasList ??
                    array_filter(array_map('trim', preg_split('/,|\r\n|\r|\n/', (string) ($room->fasilitas ?? ''))));

                $visibleTestimonials = $visibleTestimonials ?? collect();
                $averageRating = $averageRating ?? 0;
                $totalTestimonials = $totalTestimonials ?? 0;
            @endphp

            



            
        </div>
    </section>
@endsection

@include('pages.cari-kamar.detail-room.styles')

@include('pages.cari-kamar.detail-room.scripts') --}}


@extends('landing.landing')

@section('title', 'Detail Kamar ' . $room->kode_kamar . ' - SIRKA Rusunawa UNDIP')

@section('content')

    <section class="bg-slate-50 border-b border-slate-200">

        <div class="max-w-6xl mx-auto px-4 py-6 space-y-6">

            {{-- BREADCRUMB --}}
            <div class="text-xs text-slate-500 flex items-center gap-1">
                <a href="{{ route('page.beranda') }}" class="hover:underline">
                    Beranda
                </a>

                <span>/</span>

                <a href="{{ route('cari-kamar.index') }}" class="hover:underline">
                    Reservasi Kamar
                </a>

                <span>/</span>

                <span class="font-semibold text-slate-700">
                    {{ $room->kode_kamar }}
                </span>
            </div>

            {{-- GALLERY --}}
            @include('pages.cari-kamar.detail-room.gallery')

            <div class="grid gap-6 lg:grid-cols-[minmax(0,2fr)_minmax(260px,1fr)]">

                <div>
                    {{-- HEADER --}}
                    @include('pages.cari-kamar.detail-room.header')

                    {{-- TABS --}}
                    @include('pages.cari-kamar.detail-room.tabs')
                </div>

                {{-- PRICE CARD --}}
                @include('pages.cari-kamar.detail-room.price-card')

            </div>

        </div>

    </section>

@endsection

@include('pages.cari-kamar.detail-room.styles')
@include('pages.cari-kamar.detail-room.scripts')
