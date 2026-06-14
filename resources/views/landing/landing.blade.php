<!doctype html>
<html lang="id">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'SIRKA Rusunawa UNDIP')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets-admin/images/logo/logo-undip-01.png') }}?v=1">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .profile-menu-hidden {
            opacity: 0;
            visibility: hidden;
            transform: translateY(8px);
            pointer-events: none;
            transition: all .2s ease;
        }

        .profile-menu-show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            pointer-events: auto;
        }

        .beranda-swiper .swiper-button-prev,
        .beranda-swiper .swiper-button-next {
            width: 48px;
            height: 48px;
            border: 1px solid #070b55;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #070b55;
            background: transparent;
            transition: all 0.3s ease;

            /* INI YANG PENTING */
            overflow: hidden;
        }

        /* hover bulat sempurna */
        .beranda-swiper .swiper-button-prev:hover,
        .beranda-swiper .swiper-button-next:hover {
            background-color: #070b55;
            color: white;
        }

        /* hapus style default swiper yang bikin kotak */
        .beranda-swiper .swiper-button-prev::after,
        .beranda-swiper .swiper-button-next::after {
            font-size: 14px;
        }

        /* posisi */
        .beranda-swiper .swiper-button-prev {
            left: 20px;
        }

        .beranda-swiper .swiper-button-next {
            right: 20px;
        }

        @keyframes typing {
            from {
                width: 0
            }

            to {
                width: 26ch;
            }

            /* sesuai jumlah karakter */
        }

        @keyframes blink {
            50% {
                border-color: transparent
            }
        }

        .typewriter {
            width: 26ch;
            /* HARUS sama */
            overflow: hidden;
            white-space: nowrap;
            border-right: 3px solid white;
            animation: typing 3s steps(26) forwards, blink .8s infinite;
        }
    </style>

    @stack('head')
</head>

<body class="bg-slate-50 text-slate-800">

    @include('landing.header')

    <main>
        @yield('content')
    </main>
    @include('landing.footer')
    @include('partials.back-to-top')
    @livewireScripts
    @stack('scripts')
    @stack('scripts')
    <x-alert.flash-message />

    {{ $slot ?? '' }}
    @auth
        @if (auth()->user()->role === 'mahasiswa')
            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    const button = document.getElementById('profileButton');
                    const menu = document.getElementById('profileMenu');

                    if (button && menu) {
                        button.addEventListener('click', function(e) {
                            e.stopPropagation();
                            menu.classList.toggle('profile-menu-show');
                            menu.classList.toggle('profile-menu-hidden');
                        });

                        document.addEventListener('click', function(e) {
                            if (!menu.contains(e.target) && !button.contains(e.target)) {
                                menu.classList.remove('profile-menu-show');
                                menu.classList.add('profile-menu-hidden');
                            }
                        });

                        menu.addEventListener('click', function(e) {
                            e.stopPropagation();
                        });
                    }


                });
            </script>
        @endif
    @endauth
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('Reservation_alert'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: @json(session('Reservation_alert_icon', 'warning')),
                    title: @json(session('Reservation_alert_title')),
                    text: @json(session('Reservation_alert_message')),
                    confirmButtonText: @json(session('Reservation_alert_button', 'Lihat')),
                    confirmButtonColor: '#f97316',
                    showCancelButton: true,
                    cancelButtonText: 'Tetap di Halaman Ini'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = @json(session('Reservation_alert_url'));
                    }
                });
            });
        </script>
    @endif
</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const el = document.getElementById('typed-headline');
        if (!el) return;

        const text = el.dataset.text || '';
        let index = 0;
        let isDeleting = false;

        const typingSpeed = 70; // kecepatan mengetik
        const deletingSpeed = 40; // kecepatan hapus
        const delayAfterType = 1500; // jeda setelah selesai mengetik

        function typeLoop() {

            if (!isDeleting) {
                // MENGETIK
                el.textContent = text.substring(0, index + 1);
                index++;

                if (index === text.length) {
                    setTimeout(() => isDeleting = true, delayAfterType);
                }

            } else {
                // MENGHAPUS
                el.textContent = text.substring(0, index - 1);
                index--;

                if (index === 0) {
                    isDeleting = false;
                }
            }

            const speed = isDeleting ? deletingSpeed : typingSpeed;
            setTimeout(typeLoop, speed);
        }

        typeLoop();
    });
</script>
