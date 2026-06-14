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

        <div class="max-w-6xl mx-auto px-4 md:px-6 pt-6 space-y-6">

            <x-ui.reservation-stepper :step="1" status="pending" />

            <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1fr)_380px] gap-6">

                <form id="ReservationForm" action="{{ route('Reservation.store', $room->id) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">

                    @csrf

                    <input type="hidden" name="duration_month" value="6">

                    @include('pages.Reservation.create.student-information')

                    @include('pages.Reservation.create.occupancy-information')

                    @include('pages.Reservation.create.payment-information')

                    @include('pages.Reservation.create.document-information')

                    @include('pages.Reservation.create.parent-information')

                    @include('pages.Reservation.create.special-request')

                </form>

                @include('pages.Reservation.create.reservation-summary')

            </div>

        </div>

    </section>

    @include('pages.Reservation.create.reservation-script')

@endsection
