<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<style>
    .testimonial-swiper {
        overflow: hidden;
        padding: 10px 0;
    }

    .testimonial-card {
        height: 100%;
        min-height: 340px;
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
        font-size: 18px;
        line-height: 2rem;

        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;

        overflow: hidden;
    }

    .testimonial-user {
        margin-top: auto;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .testimonial-nav {
        width: 48px;
        height: 48px;
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

    /* ACTIVE CARD */

    .swiper-slide-active .testimonial-card {
        border-color: #4f46e5 !important;
        box-shadow: 0 10px 30px rgba(79, 70, 229, .12);
    }

    .swiper-slide-active .testimonial-stars {
        color: #4f46e5 !important;
    }

    .swiper-slide-active .testimonial-name {
        color: #4f46e5 !important;
    }
</style>

<section class="py-24">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mb-14 flex items-center justify-between">

            <h2 class="text-4xl font-black text-slate-900">
                Testimoni Penghuni
            </h2>

            <div class="flex items-center gap-3">

                <button id="testimonial-prev" class="testimonial-nav" type="button">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />

                    </svg>

                </button>

                <button id="testimonial-next" class="testimonial-nav" type="button">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />

                    </svg>

                </button>

            </div>

        </div>

        <div class="swiper testimonial-swiper">

            <div class="swiper-wrapper">

                @forelse($testimonials as $testimonial)

                    <div class="swiper-slide">

                        <div class="testimonial-card bg-white rounded-3xl p-8">

                            {{-- STARS --}}
                            <div
                                class="testimonial-stars flex items-center gap-2 mb-8 text-amber-500 transition-all duration-300">

                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5" viewBox="0 0 18 17"
                                        fill="{{ $i <= $testimonial->rating ? 'currentColor' : '#D1D5DB' }}">

                                        <path
                                            d="M8.10326 1.31699C8.47008 0.57374 9.52992 0.57374 9.89674 1.31699L11.7063 4.98347C11.8519 5.27862 12.1335 5.48319 12.4592 5.53051L16.5054 6.11846C17.3256 6.23765 17.6531 7.24562 17.0596 7.82416L14.1318 10.6781C13.8961 10.9079 13.7885 11.2389 13.8442 11.5632L14.5353 15.5931C14.6754 16.41 13.818 17.033 13.0844 16.6473L9.46534 14.7446C9.17402 14.5915 8.82598 14.5915 8.53466 14.7446L4.91562 16.6473C4.18199 17.033 3.32456 16.41 3.46467 15.5931L4.15585 11.5632C4.21148 11.2389 4.10393 10.9079 3.86825 10.6781L0.940384 7.82416C0.346867 7.24562 0.674378 6.23765 1.4946 6.11846L5.54081 5.53051C5.86652 5.48319 6.14808 5.27862 6.29374 4.98347L8.10326 1.31699Z" />
                                    </svg>
                                @endfor

                            </div>

                            {{-- COMMENT --}}
                            <div class="testimonial-content">

                                <p class="testimonial-comment">

                                    {{ $testimonial->comment }}

                                </p>

                            </div>

                            {{-- USER --}}
                            <div class="testimonial-user">

                                @if ($testimonial->user?->profile_photo)
                                    <img src="{{ $testimonial->user->profilePhotoUrl() }}"
                                        alt="{{ $testimonial->user->name }}"
                                        class="w-14 h-14 rounded-full object-cover">
                                @else
                                    <div
                                        class="w-14 h-14 rounded-full bg-indigo-100 flex items-center justify-center font-bold text-indigo-700">

                                        {{ strtoupper(substr($testimonial->user?->name ?? 'U', 0, 1)) }}

                                    </div>
                                @endif

                                <div>

                                    <h5
                                        class="testimonial-name text-xl font-semibold text-slate-900 transition-all duration-300">

                                        {{ $testimonial->user?->name ?? 'Pengguna' }}

                                    </h5>

                                    <p class="text-sm text-slate-500">
                                        Penghuni Rusunawa UNDIP
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="swiper-slide">

                        <div class="rounded-3xl border bg-white p-10 text-center">

                            <p class="text-gray-500">
                                Belum ada testimoni.
                            </p>

                        </div>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</section>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        new Swiper('.testimonial-swiper', {

            slidesPerView: 3,
            spaceBetween: 32,
            centeredSlides: true,
            loop: true,
            speed: 800,

            navigation: {
                nextEl: '#testimonial-next',
                prevEl: '#testimonial-prev',
            },

            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                }
            }

        });
    });
</script>
