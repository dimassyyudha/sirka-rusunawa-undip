<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>@yield('title', 'SIRKA Rusunawa UNDIP')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets-admin/images/logo/logo-undip-01.png') }}?v=1">

    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    @stack('head')
</head>

<body class="bg-slate-50 text-slate-800">

    {{-- <header class="sticky top-0 z-50"> --}}
    <header class="fixed top-0 left-0 right-0 z-50">

        <div class="bg-[#070B55] text-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="h-[74px] flex items-center justify-between gap-6">
                    <a href="{{ route('landing') }}" class="flex items-center gap-4">
                        <img src="{{ asset('assets-admin/images/logo/logo-undip-01.png') }}"
                            class="h-11 w-11 object-contain" alt="UNDIP">
                        <div class="leading-tight">
                            <div class="font-extrabold tracking-wide uppercase text-[14px]">Universitas Diponegoro</div>
                            <div class="text-[11px] text-white/70 italic">The Excellent Research University</div>
                        </div>
                    </a>

                    <nav class="hidden lg:flex items-center gap-1 font-semibold text-[15px]">
                        <a href="#beranda" class="px-3 py-2 rounded-lg hover:bg-white/10">Beranda</a>
                        <a href="#cari-kamar" class="px-3 py-2 rounded-lg hover:bg-white/10">Reservasi Kamar</a>
                        <a href="#galeri" class="px-3 py-2 rounded-lg hover:bg-white/10">Galeri</a>
                        <a href="#testimoni" class="px-3 py-2 rounded-lg hover:bg-white/10">Testimoni</a>
                        <a href="#tentang" class="px-3 py-2 rounded-lg hover:bg-white/10">Tentang</a>
                        <a href="#kontak" class="px-3 py-2 rounded-lg hover:bg-white/10">Kontak</a>
                        <a href="#alur" class="px-3 py-2 rounded-lg hover:bg-white/10">Alur</a>
                        <a href="#faq" class="px-3 py-2 rounded-lg hover:bg-white/10">FAQ</a>
                    </nav>

                    <div class="flex items-center gap-2">
                        <a href="#cari-kamar"
                            class="w-10 h-10 rounded-full hover:bg-white/10 flex items-center justify-center">
                            <i class="bi bi-search text-xl"></i>
                        </a>

                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="hidden md:inline-flex px-4 py-2 rounded-xl bg-white text-[#070B55] font-extrabold hover:bg-slate-100">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="hidden md:inline-flex px-4 py-2 rounded-xl bg-white/10 border border-white/15 text-white font-semibold hover:bg-white/15">
                                Login
                            </a>
                            <a href="{{ route('register') }}"
                                class="hidden md:inline-flex px-4 py-2 rounded-xl bg-[#FF7A00] text-white font-extrabold hover:bg-[#ff6a00]">
                                Register
                            </a>
                        @endauth

                        <button
                            class="lg:hidden w-10 h-10 rounded-full hover:bg-white/10 flex items-center justify-center"
                            onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
                            <i class="bi bi-list text-2xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="mobileMenu" class="lg:hidden hidden bg-[#070B55] text-white border-t border-white/10">
            <div class="max-w-7xl mx-auto px-4 py-3 flex flex-col gap-1">
                <a href="#beranda" class="px-3 py-2 rounded-md hover:bg-white/10">Beranda</a>
                <a href="#cari-kamar" class="px-3 py-2 rounded-md hover:bg-white/10">Reservasi Kamar</a>
                <a href="#galeri" class="px-3 py-2 rounded-md hover:bg-white/10">Galeri</a>
                <a href="#testimoni" class="px-3 py-2 rounded-md hover:bg-white/10">Testimoni</a>
                <a href="#tentang" class="px-3 py-2 rounded-md hover:bg-white/10">Tentang</a>
                <a href="#kontak" class="px-3 py-2 rounded-md hover:bg-white/10">Kontak</a>
                <a href="#alur" class="px-3 py-2 rounded-md hover:bg-white/10">Alur</a>
                <a href="#faq" class="px-3 py-2 rounded-md hover:bg-white/10">FAQ</a>
            </div>
        </div>
    </header>

    <main class="@yield('mainClass', 'max-w-7xl mx-auto px-4') overflow-hidden">
        @yield('content')
    </main>


    <footer class="bg-[#070B55] text-white/80 border-t border-white/10 mt-10">
        <div class="max-w-7xl mx-auto px-4 py-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <div class="font-extrabold text-white">SIRKA Rusunawa UNDIP</div>
                    <div class="text-sm text-white/60 mt-1">Sistem Informasi Reservasi Kamar Rusunawa • Tugas Akhir
                    </div>
                </div>
                <div class="text-sm text-white/60 flex flex-wrap gap-4 items-center">
                    <span>© {{ date('Y') }} • ICONIX Process • Universitas Diponegoro</span>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
