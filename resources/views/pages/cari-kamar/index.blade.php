{{-- resources/views/pages/cari-kamar/index.blade.php --}}
@extends('landing.landing')

@section('title', 'Reservasi Kamar - SIRKA Rusunawa UNDIP')
@section('mainClass', 'w-full max-w-none px-0')

@php
    $sort = request('sort', 'recommended');
    $gender = request('gender');

    $gedungFilter = request('gedung');

    if ($gedungFilter) {
        $gedungFilter = strtoupper(preg_replace('/^Gedung\s+/i', '', trim($gedungFilter)));
    }

    $lantaiFilter = request('lantai');

    $gedungsSidebar = $gedungsList ?? [];

    $floorInfo = $floorInfo ?? [];
@endphp

@push('head')
    @include('pages.cari-kamar.partials.styles')
@endpush

@section('content')
    <section class="w-full bg-slate-50">
        <div class="w-full px-4 md:px-10 py-6">
            <div class="grid grid-cols-1 md:grid-cols-[300px_minmax(0,1fr)] gap-5 items-start">

                <x-room.filter-wrapper :gender="$gender" :gedung-filter="$gedungFilter" :lantai-filter="$lantaiFilter" :gedungs-sidebar="$gedungsSidebar"
                    :floor-info="$floorInfo" :sort="$sort" :rooms="$rooms" />

                <main class="min-w-0">
                    <div id="rooms-list" class="mt-0 space-y-4">
                        @forelse ($rooms as $room)
                            <x-room.card :room="$room" />
                        @empty
                            <x-room.empty />
                        @endforelse
                    </div>

                    <x-room.loading-skeleton :rooms="$rooms" />
                </main>

            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @include('pages.cari-kamar.partials.infinite-scroll')
@endpush
