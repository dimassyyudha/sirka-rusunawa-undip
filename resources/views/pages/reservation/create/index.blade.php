@extends('landing.landing')

@section('title', 'Isi Data Reservation Kamar ' . ($room->kode_kamar ?? ''))

@section('content')
    @php

        $formData = session('reservation_review_data', []);

        $buildingName = $room->floor?->building?->name ?? ($room->floor?->building?->code ?? '-');

        $floorNumber = $room->floor?->floor_number ?? '-';

        $selectedType = $formData['occupancy_type'] ?? ($canPrivate ? 'private' : 'shared');

        if (!$canPrivate && $selectedType === 'private') {
            $selectedType = 'shared';
        }

        $selectedPrice = $selectedType === 'private' ? $privatePricePerMonth : $sharedPricePerMonth;

        $selectedTotal = $selectedPrice * 6;

    @endphp

    <section class="min-h-screen bg-slate-50 pb-12">

        <div class="max-w-6xl mx-auto px-4 md:px-6 pt-6 space-y-4">

            <x-ui.reservation-stepper :step="1" status="pending" />

            <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1fr)_380px] gap-6">

                {{-- FORM --}}
                <form id="ReservationForm" action="{{ route('Reservation.store', $room->room_id) }}" method="POST"
                    enctype="multipart/form-data" class="">

                    @csrf

                    <input type="hidden" name="duration_month" value="6">

                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                        @include('pages.reservation.create.student-information')

                        <div class="border-t border-slate-200"></div>

                        @include('pages.reservation.create.occupancy-information')

                        <div class="border-t border-slate-200"></div>

                        @include('pages.reservation.create.payment-information')

                        <div class="border-t border-slate-200"></div>

                        @include('pages.reservation.create.document-information')

                        <div class="border-t border-slate-200"></div>

                        @include('pages.reservation.create.parent-information')

                        <div class="border-t border-slate-200"></div>

                        @include('pages.reservation.create.special-request')

                    </div>

                </form>

                {{-- SUMMARY HARUS DI SINI --}}
                @include('pages.reservation.create.reservation-summary')

            </div>

        </div>

    </section>

    @include('pages.reservation.create.reservation-script')

@endsection
