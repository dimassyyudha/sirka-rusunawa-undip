@extends('layouts.app')

@section('title', 'Testimoni Saya')

@section('content')

    <div class="max-w-5xl mx-auto">

        <div class="flex items-center justify-between mb-6">

            <h1 class="text-3xl font-black">
                Testimoni Saya
            </h1>

            <a href="{{ route('mahasiswa.testimoni.create') }}"
                class="rounded-xl bg-orange-500 px-5 py-3 text-white font-bold">

                Tambah Testimoni

            </a>

        </div>

        @forelse($testimonials as $testimonial)
            <div class="bg-white rounded-2xl border p-6 mb-4">

                <div class="flex justify-between">

                    <div>

                        <h3 class="font-black text-lg">
                            {{ $testimonial->room->kode_kamar }}
                        </h3>

                        <p class="text-slate-500 text-sm">
                            Gedung
                            {{ $testimonial->room->floor->building->code }}
                        </p>

                    </div>

                    <div class="font-bold text-yellow-500">
                        {{ $testimonial->rating }}/5
                    </div>

                </div>

                <p class="mt-4 text-slate-700">
                    {{ $testimonial->comment }}
                </p>

            </div>

        @empty

            <div class="bg-white rounded-2xl border p-10 text-center">

                Belum ada testimoni.

            </div>
        @endforelse

    </div>

@endsection
