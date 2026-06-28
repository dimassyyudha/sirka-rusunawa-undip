@extends('landing.landing')

@section('title', $testimonials['title'] ?? 'Testimonial')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <style>
        .testimonial-swiper {
            overflow: hidden;
            padding: 10px 0;
        }

        .testimonial-card {
            height: 100%;
            min-height: 260px;
            display: flex;
            flex-direction: column;
            border: 1px solid #d1d5db;
        transition: all .3s ease;
        }

        .testimonial-content {
            flex: 1;
        }

        .testimonial-comment {
            color: #64748b;
            font-size: 15px;
            line-height: 1.7;

            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .testimonial-user {
            margin-top: auto;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .testimonial-nav {
            width: 44px;
            height: 44px;
            border-radius: 9999px;
            border: 1px solid #4f46e5;
            color: #4f46e5;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: .3s;
        }

        .testimonial-nav:hover {
            background: #4f46e5;
            color: white;
        }

        .swiper-slide-active .testimonial-card {
            border-color: #4f46e5 !important;
            box-shadow: 0 10px 30px rgba(79, 70, 229, .12);
        }

        .swiper-slide-active .testimonial-stars,
        .swiper-slide-active .testimonial-name {
            color: #4f46e5 !important;
        }

        .rating-filter {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            background: #fff;

            display: flex;
            align-items: center;
            justify-content: space-between;

            transition: .3s;
        }

        .rating-filter:hover {
            border-color: #4f46e5;
            background: #eef2ff;
        }

        .rating-filter.active {
            background: #4f46e5;
            border-color: #4f46e5;
            color: #fff;
        }

        .rating-filter.active span:last-child {
            background: rgba(255, 255, 255, .2);
            color: white;
        }
    </style>

    <section class="py-24 bg-slate-50">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-12">
                <h2 class="text-4xl font-black text-slate-900">
                    Testimoni Penghuni
                </h2>

                <p class="mt-3 text-slate-600">
                    Pengalaman mahasiswa yang telah tinggal di Rusunawa UNDIP.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                @php
                    $ratingCounts = [];

                    for ($i = 1; $i <= 5; $i++) {
                        $ratingCounts[$i] = $testimonials->where('rating', $i)->count();
                    }

                    $avgRating = $testimonials->count() ? round($testimonials->avg('rating'), 1) : 0;
                @endphp

                {{-- FILTER --}}
                <div class="lg:col-span-3">

                    <div class="bg-white rounded-3xl border p-6 sticky top-24">

                        <h3 class="font-bold text-lg mb-5">
                            Statistik Pendapat
                        </h3>

                        <div class="mb-6 pb-6 border-b">

                            <div class="text-4xl font-black text-slate-900">
                                {{ $avgRating }}
                            </div>

                            <div class="text-amber-500 text-lg">
                                ★★★★★
                            </div>

                            <p class="text-sm text-slate-500 mt-2">
                                Berdasarkan {{ $testimonials->count() }} testimoni
                            </p>

                        </div>

                        <div class="space-y-3">

                            {{-- Semua --}}
                            <button class="rating-filter active" data-rating="all">

                                <div class="flex justify-between items-center w-full">

                                    <span>Semua Rating</span>

                                    <span class="px-2 py-1 rounded-full bg-slate-100 text-xs">
                                        {{ $testimonials->count() }}
                                    </span>

                                </div>

                            </button>

                            {{-- Bintang 5 - 1 --}}
                            @for ($rating = 5; $rating >= 1; $rating--)
                                <button class="rating-filter" data-rating="{{ $rating }}">

                                    <div class="flex justify-between items-center w-full">

                                        <div class="flex items-center gap-2">

                                            <span class="text-amber-500">
                                                {{ str_repeat('★', $rating) }}
                                            </span>

                                            <span>
                                                Rating {{ $rating }}
                                            </span>

                                        </div>

                                        <span class="px-2 py-1 rounded-full bg-slate-100 text-xs">

                                            {{ $ratingCounts[$rating] }}

                                        </span>

                                    </div>

                                </button>
                            @endfor

                        </div>

                    </div>
                </div>

                {{-- CONTENT --}}
                <div class="lg:col-span-9">

                    <div id="testimonial-list" class="space-y-5">

                        @forelse($testimonials as $testimonial)

                            <div class="testimonial-item bg-white rounded-3xl border border-slate-200 p-6"
                                data-rating="{{ $testimonial->rating }}">

                                <div class="flex items-start gap-4">

                                    @if ($testimonial->user?->profile_photo)
                                        <img src="{{ $testimonial->user->profilePhotoUrl() }}"
                                            alt="{{ $testimonial->user->name }}"
                                            class="w-14 h-14 rounded-full object-cover">
                                    @else
                                        <div
                                            class="w-14 h-14 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xl">

                                            {{ strtoupper(substr($testimonial->user?->name ?? 'U', 0, 1)) }}

                                        </div>
                                    @endif

                                    <div class="flex-1">

                                        <div class="flex items-center justify-between">

                                            <div>

                                                <h4 class="text-xl font-bold text-slate-900">
                                                    {{ $testimonial->user?->name ?? 'Pengguna' }}
                                                </h4>

                                                <p class="text-sm text-slate-500">
                                                    Penghuni Rusunawa UNDIP
                                                </p>

                                            </div>

                                            <span
                                                class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-sm font-semibold">

                                                {{ $testimonial->rating }}/5

                                            </span>

                                        </div>

                                        <div class="flex gap-1 mt-4">

                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-5 h-5 {{ $i <= $testimonial->rating ? 'text-amber-400' : 'text-slate-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">

                                                    <path d="M9.049 2.927c.3-.921 1.603-.921
                                                        1.902 0l1.07 3.292a1 1 0 00.95.69h3.462
                                                        c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1
                                                        1 0 00-.364 1.118l1.07 3.292c.3.921-.755
                                                        1.688-1.54 1.118l-2.8-2.034a1 1 0
                                                        00-1.176 0l-2.8 2.034c-.784.57-1.838-.197
                                                        -1.539-1.118l1.07-3.292a1 1 0
                                                        00-.364-1.118L2.98 8.72c-.783-.57-.38
                                                        -1.81.588-1.81H7.03a1 1 0
                                                        00.951-.69l1.068-3.292z" />

                                                </svg>
                                            @endfor

                                        </div>

                                        <div class="mt-4 bg-slate-50 rounded-2xl p-4 text-slate-700">

                                            "{{ $testimonial->comment }}"

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @empty

                            <div class="bg-white rounded-3xl border p-10 text-center">
                                Belum ada testimoni.
                            </div>

                        @endforelse

                    </div>

                </div>


            </div>

        </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const buttons = document.querySelectorAll('.rating-filter');

            buttons.forEach(button => {

                button.addEventListener('click', function() {

                    buttons.forEach(btn =>
                        btn.classList.remove('active')
                    );

                    this.classList.add('active');

                    const rating = this.dataset.rating;

                    document.querySelectorAll('.testimonial-item')
                        .forEach(item => {

                            if (
                                rating === 'all' ||
                                item.dataset.rating === rating
                            ) {

                                item.style.display = 'block';

                            } else {

                                item.style.display = 'none';

                            }

                        });

                });

            });

        });
    </script>
@endsection
