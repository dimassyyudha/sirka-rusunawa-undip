@extends('landing.landing')

@section('title', 'SIRKA Rusunawa UNDIP')

@section('content')
    {{-- BERANDA = HERO doang --}}
    {{-- @include('frontend.hero') --}}
    @include('frontend.carousel.carousel')

    {{-- Klik navbar "Tentang" -> scroll ke sini --}}
    {{-- @include('frontend.why-rusunawa') --}}

    @include('frontend.stats')

    @include('frontend.recommendations')

    @include('frontend.alur')

    @include('frontend.faq')

    @include('frontend.cta-bottom')
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.beranda-swiper', {
                loop: true,
                slidesPerView: 1,
                spaceBetween: 0,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.beranda-swiper .swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.beranda-swiper .swiper-button-next',
                    prevEl: '.beranda-swiper .swiper-button-prev',
                },
            });
        });
        document.addEventListener('DOMContentLoaded', () => {


            // HERO SLIDER
            // (function () {
            //   const slides = document.querySelectorAll('[data-hero-slide]');
            //   if (!slides || slides.length <= 1) return;

            //   let i = 0;
            //   setInterval(() => {
            //     slides[i].classList.remove('opacity-100');
            //     slides[i].classList.add('opacity-0');

            //     i = (i + 1) % slides.length;

            //     slides[i].classList.remove('opacity-0');
            //     slides[i].classList.add('opacity-100');
            //   }, 5000);
            // })();

            // FAQ ACCORDION
            (function() {
                const buttons = document.querySelectorAll('[data-faq-button]');
                if (!buttons.length) return;

                buttons.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const parent = btn.closest('[data-faq-item]');
                        const content = parent.querySelector('[data-faq-content]');
                        const icon = parent.querySelector('[data-faq-icon]');
                        const isOpen = !content.classList.contains('hidden');

                        // tutup semua
                        document.querySelectorAll('[data-faq-content]').forEach((c) => c
                            .classList.add('hidden'));
                        document.querySelectorAll('[data-faq-icon]').forEach((i) => i.style
                            .transform = 'rotate(0deg)');

                        if (!isOpen) {
                            content.classList.remove('hidden');
                            icon.style.transform = 'rotate(180deg)';
                        }
                    });
                });
            })();

        });
    </script>
@endpush
