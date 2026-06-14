<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>SIRKA Rusunawa UNDIP</title>

    {{-- Tailwind via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets-admin/images/logo/favicon-undip-32.png') }}?v=1">

    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

    {{-- =========================================================
   HEADER 2-LEVEL (TRAVELOKA STYLE)
   ========================================================= --}}
    <header class="sticky top-0 z-50">
        {{-- MAIN NAV --}}
        <div class="bg-[#070B55] text-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="h-[74px] flex items-center justify-between gap-6">
                    {{-- Brand --}}
                    <a href="{{ route('landing') }}" class="flex items-center gap-4">
                        <img src="{{ asset('assets/images/undip-logo.png') }}" class="h-11 w-11 object-contain"
                            alt="UNDIP">
                        <div class="leading-tight">
                            <div class="font-extrabold tracking-wide uppercase text-[14px]">
                                Universitas Diponegoro
                            </div>
                            <div class="text-[11px] text-white/70 italic">
                                The Excellent Research University
                            </div>
                        </div>
                    </a>

                    {{-- Menu (Traveloka-like) --}}
                    <nav class="hidden lg:flex items-center gap-1 font-semibold text-[15px]">
                        <a href="#beranda" class="px-3 py-2 rounded-lg hover:bg-white/10">Beranda</a>
                        <a href="#search" class="px-3 py-2 rounded-lg hover:bg-white/10">Reservasi Kamar</a>
                        <a href="#popular" class="px-3 py-2 rounded-lg hover:bg-white/10">Kamar</a>
                        <a href="#fitur" class="px-3 py-2 rounded-lg hover:bg-white/10">Fitur</a>
                        <a href="#alur" class="px-3 py-2 rounded-lg hover:bg-white/10">Alur</a>
                        <a href="#tentang" class="px-3 py-2 rounded-lg hover:bg-white/10">Tentang</a>
                        <a href="#faq" class="px-3 py-2 rounded-lg hover:bg-white/10">FAQ</a>
                        <a href="#kontak" class="px-3 py-2 rounded-lg hover:bg-white/10">Kontak</a>
                    </nav>

                    {{-- Right --}}
                    <div class="flex items-center gap-2">
                        <a href="#search"
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

                        {{-- Mobile button --}}
                        <button
                            class="lg:hidden w-10 h-10 rounded-full hover:bg-white/10 flex items-center justify-center"
                            onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
                            <i class="bi bi-list text-2xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div id="mobileMenu" class="lg:hidden hidden bg-[#070B55] text-white border-t border-white/10">
            <div class="max-w-7xl mx-auto px-4 py-3 flex flex-col gap-1">
                <a href="#beranda" class="px-3 py-2 rounded-md hover:bg-white/10">Beranda</a>
                <a href="#search" class="px-3 py-2 rounded-md hover:bg-white/10">Reservasi Kamar</a>
                <a href="#popular" class="px-3 py-2 rounded-md hover:bg-white/10">Kamar</a>
                <a href="#fitur" class="px-3 py-2 rounded-md hover:bg-white/10">Fitur</a>
                <a href="#alur" class="px-3 py-2 rounded-md hover:bg-white/10">Alur</a>
                <a href="#tentang" class="px-3 py-2 rounded-md hover:bg-white/10">Tentang</a>
                <a href="#faq" class="px-3 py-2 rounded-md hover:bg-white/10">FAQ</a>
                <a href="#kontak" class="px-3 py-2 rounded-md hover:bg-white/10">Kontak</a>

                <div class="pt-2 flex gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="flex-1 text-center px-4 py-2 rounded-xl bg-white text-[#070B55] font-extrabold">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="flex-1 text-center px-4 py-2 rounded-xl bg-white/10 border border-white/15 font-semibold">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="flex-1 text-center px-4 py-2 rounded-xl bg-[#FF7A00] font-extrabold">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    {{-- =========================================================
   HERO + SEARCH (BACKGROUND SLIDER TRAVELOKA STYLE)
   ========================================================= --}}
    <section id="beranda" class="relative overflow-hidden" style="min-height: calc(100vh - 74px);">
        {{-- SLIDES BACKGROUND --}}
        <div class="absolute inset-0">
            {{-- Slide 1 --}}
            <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 hero-slide opacity-100"
                data-hero-slide style="background-image:url('{{ asset('assets-admin/images/hero-1.jpg') }}');">
            </div>

            {{-- Slide 2 --}}
            <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 hero-slide opacity-0"
                data-hero-slide style="background-image:url('{{ asset('assets-admin/images/hero-2.jpg') }}');">
            </div>

            {{-- Slide 3 --}}
            <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 hero-slide opacity-0"
                data-hero-slide style="background-image:url('{{ asset('assets-admin/images/hero-3.jpg') }}');">
            </div>

            {{-- overlay gelap tipis --}}
            <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/40 to-black/20"></div>
        </div>

        {{-- CONTENT --}}
        <div class="relative max-w-7xl mx-auto px-4 py-12 lg:py-16">
            <div class="grid lg:grid-cols-12 gap-8 items-center">

                {{-- Left text --}}
                <div class="lg:col-span-6 text-white">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/15 border border-white/20 text-xs md:text-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-300"></span>
                        Reservation cepat • Data realtime
                    </div>

                    <h1 class="mt-4 text-3xl md:text-5xl font-black leading-tight max-w-xl">
                        Reservasi Rusunawa UNDIP
                        <span class="text-yellow-200">semudah Traveloka</span>.
                    </h1>

                    <p class="mt-4 text-white/90 text-base md:text-lg max-w-lg">
                        Reservasi Kamar, cek slot, dan ajukan reservasi online. Admin verifikasi, kamu tinggal beres.
                    </p>

                    <div class="mt-6 flex gap-3 flex-wrap">
                        <div class="px-4 py-3 rounded-2xl bg-black/35 border border-white/20">
                            <div class="text-2xl font-black">{{ $availableRooms ?? 0 }}</div>
                            <div class="text-white/80 text-sm">Kamar tersedia</div>
                        </div>
                        <div class="px-4 py-3 rounded-2xl bg-black/35 border border-white/20">
                            <div class="text-2xl font-black">{{ $totalRooms ?? 0 }}</div>
                            <div class="text-white/80 text-sm">Total kamar</div>
                        </div>
                        <div class="px-4 py-3 rounded-2xl bg-black/35 border border-white/20">
                            <div class="text-2xl font-black">2</div>
                            <div class="text-white/80 text-sm">Kapasitas/kamar</div>
                        </div>
                    </div>
                </div>

                {{-- Right: search card ala traveloka --}}
                <div id="search" class="lg:col-span-6 flex justify-center lg:justify-end mt-6 lg:mt-0">
                    <div
                        class="w-full max-w-sm bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden">
                        {{-- promo badge --}}
                        <div
                            class="px-4 py-3 bg-gradient-to-r from-pink-500 to-fuchsia-500 text-white text-xs md:text-sm font-medium flex items-start gap-2">
                            <div class="mt-0.5">
                                <i class="bi bi-calendar2-week-fill text-lg"></i>
                            </div>
                            <div>
                                <span class="font-semibold">Menginap lama lebih hemat</span>
                                <span class="block text-white/90">Tersedia diskon khusus untuk durasi tertentu</span>
                            </div>
                        </div>

                        {{-- form search --}}
                        <form action="{{ route('landing') }}" method="GET" class="p-4 md:p-5 space-y-3">
                            {{-- Kode kamar --}}
                            <div>
                                <label class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Kode
                                    Kamar</label>
                                <div
                                    class="mt-1 flex items-center gap-2 border rounded-2xl px-3 py-2.5 bg-slate-50 focus-within:ring-2 focus-within:ring-blue-400">
                                    <i class="bi bi-search text-slate-400 text-lg"></i>
                                    <input name="search" value="{{ request('search') }}"
                                        class="w-full outline-none text-slate-800 bg-transparent text-sm"
                                        placeholder="Contoh: A101, B203">
                                </div>
                            </div>

                            {{-- Gedung --}}
                            <div>
                                <label
                                    class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Gedung</label>
                                <div
                                    class="mt-1 flex items-center gap-2 border rounded-2xl px-3 py-2.5 bg-slate-50 focus-within:ring-2 focus-within:ring-blue-400">
                                    <i class="bi bi-buildings text-slate-400 text-lg"></i>
                                    <select name="gedung" class="w-full outline-none bg-transparent text-sm">
                                        <option value="">Semua gedung</option>
                                        @foreach (['A', 'B', 'C', 'D', 'E', 'F'] as $g)
                                            <option value="{{ $g }}" @selected(request('gedung') == $g)>Gedung
                                                {{ $g }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Ketersediaan --}}
                            <div>
                                <label
                                    class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Filter</label>
                                <div class="mt-1 flex items-center gap-2 border rounded-2xl px-3 py-2.5 bg-slate-50">
                                    <i class="bi bi-check2-circle text-emerald-500 text-lg"></i>
                                    <label
                                        class="text-xs md:text-sm text-slate-700 font-semibold flex items-center gap-2">
                                        <input type="checkbox" name="available" value="1" class="rounded"
                                            @checked(request('available'))>
                                        Tampilkan yang masih tersedia saja
                                    </label>
                                </div>
                            </div>

                            {{-- Button --}}
                            <button
                                class="w-full mt-1 px-4 py-3 rounded-2xl bg-[#0B63F8] text-white text-sm md:text-base font-extrabold hover:bg-[#0850c5] shadow-md">
                                Reservasi Kamar
                            </button>

                            <p class="mt-1 text-[11px] text-slate-500">
                                Tips: ketik <span class="font-semibold text-slate-700">A101</span> atau pilih gedung
                                tertentu.
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================================================
   QUICK ACTION / PROMO (TRAVELOKA FEEL)
   ========================================================= --}}
    <section class="max-w-7xl mx-auto px-4 pt-10 pb-8">
        <div class="grid md:grid-cols-3 gap-4">
            <div class="rounded-3xl bg-gradient-to-br from-blue-600 to-sky-400 text-white p-6 shadow-sm">
                <div class="text-sm font-bold opacity-90">Info</div>
                <div class="mt-1 text-xl font-black">Reservasi Online</div>
                <div class="mt-2 text-white/90 text-sm">Pilih kamar, submit, admin verifikasi.</div>
            </div>
            <div class="rounded-3xl bg-white border shadow-sm p-6">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-700">
                        <i class="bi bi-lightning-charge text-2xl"></i>
                    </div>
                    <div>
                        <div class="font-black">Realtime Slot</div>
                        <div class="text-sm text-slate-600">Slot = capacity - occupied</div>
                    </div>
                </div>
            </div>
            <div class="rounded-3xl bg-white border shadow-sm p-6">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-700">
                        <i class="bi bi-headset text-2xl"></i>
                    </div>
                    <div>
                        <div class="font-black">Butuh bantuan?</div>
                        <div class="text-sm text-slate-600">Cek FAQ / Hubungi Admin</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================================================
   TENTANG RUSUNAWA
   ========================================================= --}}
    <section id="tentang" class="max-w-7xl mx-auto px-4 pb-14">
        <div class="bg-white rounded-3xl border shadow-sm p-8 md:p-10">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <h2 class="text-2xl md:text-3xl font-black text-slate-900">Tentang Rusunawa UNDIP</h2>
                    <p class="mt-3 text-sm md:text-base text-slate-600 leading-relaxed">
                        Rusunawa Universitas Diponegoro merupakan hunian bagi mahasiswa yang berlokasi di kawasan kampus
                        UNDIP Tembalang.
                        Sistem ini membantu proses reservasi kamar secara <span class="font-semibold">online</span>,
                        mulai dari pencarian kamar,
                        pengajuan reservasi, hingga verifikasi oleh admin.
                    </p>
                    <p class="mt-3 text-sm md:text-base text-slate-600 leading-relaxed">
                        Prioritas penghuni adalah mahasiswa aktif UNDIP, terutama penerima beasiswa atau mahasiswa tahun
                        pertama
                        yang membutuhkan hunian sementara selama masa studi.
                    </p>
                    <ul class="mt-4 space-y-2 text-sm text-slate-600">
                        <li class="flex gap-2">
                            <i class="bi bi-geo-alt text-blue-600 mt-0.5"></i>
                            <span>Lokasi: Kawasan Kampus UNDIP Tembalang, Semarang.</span>
                        </li>
                        <li class="flex gap-2">
                            <i class="bi bi-people text-blue-600 mt-0.5"></i>
                            <span>Penghuni: Mahasiswa aktif UNDIP sesuai ketentuan pengelola rusunawa.</span>
                        </li>
                        <li class="flex gap-2">
                            <i class="bi bi-house-check text-blue-600 mt-0.5"></i>
                            <span>Aturan umum: wajib menjaga ketertiban, kebersihan, dan mengikuti peraturan
                                rusunawa.</span>
                        </li>
                    </ul>
                </div>
                <div class="space-y-4">
                    <div class="rounded-2xl bg-slate-50 border p-4">
                        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide">
                            Periode Tinggal
                        </div>
                        <div class="mt-1 text-sm text-slate-700">
                            Umumnya mengikuti tahun akademik (1 tahun) dan dapat diperpanjang sesuai kebijakan
                            pengelola.
                        </div>
                    </div>
                    <div class="rounded-2xl bg-slate-50 border p-4">
                        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide">
                            Kelebihan Sistem SIRKA
                        </div>
                        <ul class="mt-2 text-sm text-slate-700 list-disc list-inside space-y-1">
                            <li>Reservasi bisa dilakukan kapan saja secara online.</li>
                            <li>Data kamar & slot penghuni tercatat rapi dan realtime.</li>
                            <li>Mengurangi antrean manual & kesalahan pencatatan.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================================================
   POPULAR ROOMS (CARD LEBIH “GLOSSY”)
   ========================================================= --}}
    <section id="popular" class="max-w-7xl mx-auto px-4 pb-16">
        <div class="flex items-end justify-between gap-4">
            <div>
                <h2 class="text-2xl md:text-3xl font-black text-slate-900">Rekomendasi Kamar</h2>
                <p class="mt-2 text-slate-600">Tampilan card ala Reservation app.</p>
            </div>
        </div>

        {{-- chips --}}
        @php
            $chips = [
                ['label' => 'Semua', 'url' => route('landing')],
                ['label' => 'Tersedia', 'url' => route('landing', ['available' => 1])],
                ['label' => 'Gedung A', 'url' => route('landing', ['gedung' => 'A'])],
                ['label' => 'Gedung B', 'url' => route('landing', ['gedung' => 'B'])],
                ['label' => 'Gedung C', 'url' => route('landing', ['gedung' => 'C'])],
            ];
        @endphp

        <div class="mt-5 flex gap-2 overflow-x-auto pb-2 no-scrollbar">
            @foreach ($chips as $c)
                <a href="{{ $c['url'] }}"
                    class="shrink-0 px-4 py-2 rounded-full border bg-white text-slate-700 font-bold hover:bg-slate-50">
                    {{ $c['label'] }}
                </a>
            @endforeach
        </div>

        {{-- cards --}}
        <div class="mt-6">
            <div class="flex gap-5 overflow-x-auto pb-4 snap-x snap-mandatory no-scrollbar">
                @forelse($popularRooms ?? [] as $room)
                    @php
                        $occupied = (int) ($room->occupied ?? 0);
                        $capacity = (int) ($room->capacity ?? 2);
                        $slots = max(0, $capacity - $occupied);
                        $isAvailable = ($room->status ?? 'tersedia') === 'tersedia' && $slots > 0;
                    @endphp

                    <div
                        class="snap-start shrink-0 w-[300px] md:w-[340px] bg-white rounded-3xl border shadow-sm overflow-hidden hover:shadow-lg transition">
                        <div class="h-44 relative">
                            @if (!empty($room->foto))
                                <img src="{{ asset('uploads/rooms/' . $room->foto) }}"
                                    class="h-full w-full object-cover" alt="Foto {{ $room->kode_kamar }}">
                            @else
                                <div
                                    class="h-full w-full bg-gradient-to-br from-blue-100 via-sky-100 to-cyan-100 flex items-center justify-center">
                                    <div class="text-blue-800 font-black text-xl">SIRKA</div>
                                </div>
                            @endif

                            {{-- gradient overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/35 via-black/0 to-black/0"></div>

                            <div class="absolute top-3 left-3 flex items-center gap-2">
                                @if ($isAvailable)
                                    <span
                                        class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-extrabold">
                                        Tersedia
                                    </span>
                                @else
                                    <span
                                        class="px-2.5 py-1 rounded-full bg-rose-100 text-rose-700 text-xs font-extrabold">
                                        Penuh
                                    </span>
                                @endif
                                <span
                                    class="px-2.5 py-1 rounded-full bg-white/90 text-slate-700 text-xs font-bold border">
                                    Gedung {{ $room->gedung }}
                                </span>
                            </div>

                            {{-- rating fake ala traveloka --}}
                            <div class="absolute bottom-3 left-3 flex items-center gap-2">
                                <span
                                    class="px-2.5 py-1 rounded-full bg-white/90 text-slate-800 text-xs font-black border">
                                    <i class="bi bi-star-fill text-yellow-500"></i> 4.7
                                </span>
                                <span class="text-white text-xs font-bold drop-shadow">Favorit penghuni</span>
                            </div>
                        </div>

                        <div class="p-5">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <div class="font-black text-lg text-slate-900">{{ $room->kode_kamar }}</div>
                                    <div class="text-sm text-slate-500">
                                        Lantai {{ $room->lantai }} • Kapasitas {{ $capacity }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs text-slate-500">Sisa slot</div>
                                    <div class="font-black text-slate-900">{{ $slots }}</div>
                                </div>
                            </div>

                            <div class="mt-4 flex items-end justify-between">
                                <div>
                                    <div class="text-xs text-slate-500">Harga/bulan</div>
                                    <div class="text-xl font-black text-slate-900">
                                        Rp {{ number_format($room->harga ?? 0, 0, ',', '.') }}
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-slate-500">
                                    {{ $isAvailable ? 'Bisa diajukan' : 'Menunggu slot' }}
                                </span>
                            </div>

                            <div class="mt-5 flex gap-2">
                                <a href="{{ route('landing', ['search' => $room->kode_kamar]) }}"
                                    class="flex-1 text-center px-4 py-2.5 rounded-2xl bg-blue-600 text-white font-extrabold hover:bg-blue-700">
                                    Lihat
                                </a>
                                <a href="#search"
                                    class="px-4 py-2.5 rounded-2xl bg-slate-100 text-slate-800 font-extrabold hover:bg-slate-200">
                                    Pilih
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-slate-600">Belum ada data kamar.</div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- =========================================================
   FITUR
   ========================================================= --}}
    <section id="fitur" class="max-w-7xl mx-auto px-4 pb-14">
        @php
            $features = [
                [
                    'title' => 'Reservasi Online',
                    'desc' => 'Ajukan reservasi tanpa antre: pilih kamar & isi data.',
                    'icon' => 'bi-calendar-check',
                    'bg' => 'bg-blue-50',
                    'ic' => 'text-blue-700',
                ],
                [
                    'title' => 'Realtime Slot',
                    'desc' => 'Sisa slot otomatis dari capacity - occupied.',
                    'icon' => 'bi-lightning-charge',
                    'bg' => 'bg-emerald-50',
                    'ic' => 'text-emerald-700',
                ],
                [
                    'title' => 'Manajemen Admin',
                    'desc' => 'Admin kelola kamar, penghuni, reservasi, laporan.',
                    'icon' => 'bi-shield-check',
                    'bg' => 'bg-violet-50',
                    'ic' => 'text-violet-700',
                ],
                [
                    'title' => 'Notifikasi',
                    'desc' => 'Update status reservasi & pembayaran lebih cepat.',
                    'icon' => 'bi-bell',
                    'bg' => 'bg-orange-50',
                    'ic' => 'text-orange-700',
                ],
            ];
        @endphp

        <div class="grid md:grid-cols-4 gap-4">
            @foreach ($features as $f)
                <div class="bg-white rounded-3xl border shadow-sm p-6 hover:shadow-md transition">
                    <div
                        class="w-12 h-12 rounded-2xl {{ $f['bg'] }} flex items-center justify-center {{ $f['ic'] }}">
                        <i class="bi {{ $f['icon'] }} text-2xl"></i>
                    </div>
                    <h3 class="mt-4 font-black text-lg">{{ $f['title'] }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $f['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- =========================================================
   ALUR
   ========================================================= --}}
    <section id="alur" class="max-w-7xl mx-auto px-4 pb-16">
        <div class="bg-white rounded-3xl border shadow-sm p-8 md:p-10">
            <h2 class="text-2xl font-black text-slate-900">Alur Reservasi</h2>
            <div class="mt-6 grid md:grid-cols-4 gap-4">
                <div class="p-5 rounded-2xl bg-slate-50 border">
                    <div class="font-black">1) Login/Register</div>
                    <div class="text-sm text-slate-600 mt-1">Masuk sistem untuk ajukan reservasi.</div>
                </div>
                <div class="p-5 rounded-2xl bg-slate-50 border">
                    <div class="font-black">2) Reservasi Kamar</div>
                    <div class="text-sm text-slate-600 mt-1">Filter gedung & cari kode kamar.</div>
                </div>
                <div class="p-5 rounded-2xl bg-slate-50 border">
                    <div class="font-black">3) Ajukan</div>
                    <div class="text-sm text-slate-600 mt-1">Isi data & submit reservasi.</div>
                </div>
                <div class="p-5 rounded-2xl bg-slate-50 border">
                    <div class="font-black">4) Verifikasi Admin</div>
                    <div class="text-sm text-slate-600 mt-1">Admin approve & mapping kamar.</div>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================================================
   TESTIMONI / REVIEW PENGHUNI
   ========================================================= --}}
    <section id="testimoni" class="max-w-7xl mx-auto px-4 pb-16">
        <div class="bg-white rounded-3xl border shadow-sm p-8 md:p-10">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-black text-slate-900">Testimoni Penghuni</h2>
                    <p class="mt-2 text-sm text-slate-600">
                        Beberapa pengalaman singkat dari penghuni rusunawa.
                    </p>
                </div>
                <div class="flex items-center gap-2 text-sm text-slate-600">
                    <i class="bi bi-star-fill text-yellow-400"></i>
                    <span>Rating rata-rata 4.7/5 dari penghuni</span>
                </div>
            </div>

            <div class="mt-6 grid md:grid-cols-3 gap-4">
                <div class="rounded-2xl border bg-slate-50 p-5 h-full flex flex-col">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold">
                            A
                        </div>
                        <div>
                            <div class="font-semibold text-slate-900 text-sm">Aulia, Teknik Elektro</div>
                            <div class="text-xs text-slate-500">Penghuni 2023</div>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center gap-1 text-yellow-400 text-xs">
                        @for ($i = 0; $i < 5; $i++)
                            <i class="bi bi-star-fill"></i>
                        @endfor
                    </div>
                    <p class="mt-3 text-sm text-slate-600 flex-1">
                        Sistemnya enak, aku bisa cek kamar kosong dan langsung ajukan tanpa harus datang ke kantor
                        rusunawa.
                    </p>
                </div>

                <div class="rounded-2xl border bg-slate-50 p-5 h-full flex flex-col">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold">
                            R
                        </div>
                        <div>
                            <div class="font-semibold text-slate-900 text-sm">Rizky, Kedokteran</div>
                            <div class="text-xs text-slate-500">Penghuni 2022</div>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center gap-1 text-yellow-400 text-xs">
                        @for ($i = 0; $i < 4; $i++)
                            <i class="bi bi-star-fill"></i>
                        @endfor
                        <i class="bi bi-star-half"></i>
                    </div>
                    <p class="mt-3 text-sm text-slate-600 flex-1">
                        Informasi slot dan status pengajuan jelas. Tinggal cek dashboard kalau ada update dari admin.
                    </p>
                </div>

                <div class="rounded-2xl border bg-slate-50 p-5 h-full flex flex-col">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-700 font-bold">
                            S
                        </div>
                        <div>
                            <div class="font-semibold text-slate-900 text-sm">Sinta, Ekonomi</div>
                            <div class="text-xs text-slate-500">Penghuni 2024</div>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center gap-1 text-yellow-400 text-xs">
                        @for ($i = 0; $i < 5; $i++)
                            <i class="bi bi-star-fill"></i>
                        @endfor
                    </div>
                    <p class="mt-3 text-sm text-slate-600 flex-1">
                        Lokasi dekat kampus dan fasilitas cukup lengkap. Reservasi online menghemat waktu banget saat
                        awal semester.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================================================
   GALERI / FASILITAS
   ========================================================= --}}
    <section id="galeri" class="max-w-7xl mx-auto px-4 pb-16">
        <div class="bg-white rounded-3xl border shadow-sm p-8 md:p-10">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-black text-slate-900">Galeri & Fasilitas</h2>
                    <p class="mt-2 text-sm text-slate-600">
                        Sekilas suasana kamar dan fasilitas pendukung di lingkungan rusunawa.
                    </p>
                </div>
                <div class="text-xs text-slate-500">
                    *Foto bisa disesuaikan dengan dokumentasi asli rusunawa.
                </div>
            </div>

            <div class="mt-6 grid md:grid-cols-3 gap-4">
                {{-- Contoh tile 1 --}}
                <div class="relative overflow-hidden rounded-2xl bg-slate-200 h-40 md:h-48">
                    {{-- Ganti src dengan foto asli kalau sudah ada --}}
                    <img src="{{ asset('assets-admin/images/hero-1.jpg') }}" class="w-full h-full object-cover"
                        alt="Kamar Rusunawa">
                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent px-3 py-2">
                        <p class="text-sm text-white font-semibold">Kamar Mahasiswa</p>
                        <p class="text-[11px] text-white/80">Kamar berisi 2 penghuni dengan fasilitas dasar.</p>
                    </div>
                </div>

                {{-- Contoh tile 2 --}}
                <div class="relative overflow-hidden rounded-2xl bg-slate-200 h-40 md:h-48">
                    <img src="{{ asset('assets-admin/images/bg/bg-rusunawa-undip.jpg') }}"
                        class="w-full h-full object-cover" alt="Lingkungan Rusunawa">
                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent px-3 py-2">
                        <p class="text-sm text-white font-semibold">Lingkungan Rusunawa</p>
                        <p class="text-[11px] text-white/80">Suasana luar gedung yang nyaman dan rindang.</p>
                    </div>
                </div>

                {{-- Contoh tile 3 --}}
                <div
                    class="relative overflow-hidden rounded-2xl bg-slate-200 h-40 md:h-48 flex items-center justify-center">
                    {{-- placeholder kalau belum ada foto --}}
                    <div class="text-center px-4">
                        <i class="bi bi-image text-3xl text-slate-400"></i>
                        <p class="mt-2 text-sm font-semibold text-slate-700">Ruang Komunal</p>
                        <p class="text-[11px] text-slate-500">Tambahkan foto dapur bersama / ruang belajar di sini.</p>
                    </div>
                </div>

                {{-- Contoh tile 4 --}}
                <div
                    class="relative overflow-hidden rounded-2xl bg-slate-200 h-40 md:h-48 flex items-center justify-center">
                    <div class="text-center px-4">
                        <i class="bi bi-tree text-3xl text-slate-400"></i>
                        <p class="mt-2 text-sm font-semibold text-slate-700">Area Hijau</p>
                        <p class="text-[11px] text-slate-500">Tempat bersantai dan berkumpul di sekitar rusunawa.</p>
                    </div>
                </div>

                {{-- Contoh tile 5 --}}
                <div
                    class="relative overflow-hidden rounded-2xl bg-slate-200 h-40 md:h-48 flex items-center justify-center">
                    <div class="text-center px-4">
                        <i class="bi bi-car-front text-3xl text-slate-400"></i>
                        <p class="mt-2 text-sm font-semibold text-slate-700">Parkiran</p>
                        <p class="text-[11px] text-slate-500">Area parkir motor & sepeda untuk penghuni.</p>
                    </div>
                </div>

                {{-- Contoh tile 6 --}}
                <div
                    class="relative overflow-hidden rounded-2xl bg-slate-200 h-40 md:h-48 flex items-center justify-center">
                    <div class="text-center px-4">
                        <i class="bi bi-moon-stars text-3xl text-slate-400"></i>
                        <p class="mt-2 text-sm font-semibold text-slate-700">Keamanan</p>
                        <p class="text-[11px] text-slate-500">Penjagaan dan kontrol akses sesuai peraturan rusunawa.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================================================
   FAQ (Accordion)
   ========================================================= --}}
    <section id="faq" class="max-w-7xl mx-auto px-4 pb-16">
        <div class="bg-slate-950 text-slate-50 rounded-3xl border border-slate-800 shadow-sm p-8 md:p-10">
            <h2 class="text-2xl font-black">Ada pertanyaan?</h2>
            <p class="mt-2 text-sm text-slate-400">
                Klik salah satu pertanyaan di bawah untuk melihat jawabannya.
            </p>

            <div class="mt-6 space-y-2">
                {{-- Item 1 --}}
                <div class="rounded-2xl bg-slate-900/80 border border-slate-800 overflow-hidden">
                    <button type="button"
                        class="w-full flex items-center justify-between px-4 md:px-5 py-4 text-left text-sm md:text-base font-semibold hover:bg-slate-800/60 transition"
                        data-faq-button>
                        <span>Bisa 1 orang 1 kamar?</span>
                        <i class="bi bi-plus text-xl flex-shrink-0 transition-transform duration-200"
                            data-faq-icon></i>
                    </button>
                    <div class="px-4 md:px-5 pb-4 text-sm text-slate-300 hidden" data-faq-content>
                        Bisa, 1 orang boleh menempati 1 kamar, namun biaya yang dibayarkan tetap penuh sesuai harga
                        kamar.
                    </div>
                </div>

                {{-- Item 2 --}}
                <div class="rounded-2xl bg-slate-900/80 border border-slate-800 overflow-hidden">
                    <button type="button"
                        class="w-full flex items-center justify-between px-4 md:px-5 py-4 text-left text-sm md:text-base font-semibold hover:bg-slate-800/60 transition"
                        data-faq-button>
                        <span>Kamar tersedia itu apa?</span>
                        <i class="bi bi-plus text-xl flex-shrink-0 transition-transform duration-200"
                            data-faq-icon></i>
                    </button>
                    <div class="px-4 md:px-5 pb-4 text-sm text-slate-300 hidden" data-faq-content>
                        Kamar tersedia artinya status kamar "tersedia" dan sisa slot masih ada (belum penuh).
                    </div>
                </div>

                {{-- Item 3 --}}
                <div class="rounded-2xl bg-slate-900/80 border border-slate-800 overflow-hidden">
                    <button type="button"
                        class="w-full flex items-center justify-between px-4 md:px-5 py-4 text-left text-sm md:text-base font-semibold hover:bg-slate-800/60 transition"
                        data-faq-button>
                        <span>Cara cek slot?</span>
                        <i class="bi bi-plus text-xl flex-shrink-0 transition-transform duration-200"
                            data-faq-icon></i>
                    </button>
                    <div class="px-4 md:px-5 pb-4 text-sm text-slate-300 hidden" data-faq-content>
                        Slot dihitung dari rumus <strong>slot = capacity - occupied</strong> pada kamar tersebut.
                    </div>
                </div>

                {{-- Item 4 --}}
                <div class="rounded-2xl bg-slate-900/80 border border-slate-800 overflow-hidden">
                    <button type="button"
                        class="w-full flex items-center justify-between px-4 md:px-5 py-4 text-left text-sm md:text-base font-semibold hover:bg-slate-800/60 transition"
                        data-faq-button>
                        <span>Pembayaran?</span>
                        <i class="bi bi-plus text-xl flex-shrink-0 transition-transform duration-200"
                            data-faq-icon></i>
                    </button>
                    <div class="px-4 md:px-5 pb-4 text-sm text-slate-300 hidden" data-faq-content>
                        Pembayaran dapat diintegrasikan dengan Midtrans dan bisa ditambahkan/diatur kemudian oleh admin.
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================================================
   KONTAK / BANTUAN
   ========================================================= --}}
    <section id="kontak" class="max-w-7xl mx-auto px-4 pb-20">
        <div class="bg-white rounded-3xl border shadow-sm p-8 md:p-10">
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <h2 class="text-2xl font-black text-slate-900">Kontak & Bantuan</h2>
                    <p class="mt-2 text-sm text-slate-600">
                        Jika ada pertanyaan terkait reservasi atau hunian, silakan hubungi pengelola rusunawa.
                    </p>

                    <div class="mt-5 space-y-3 text-sm text-slate-700">
                        <div class="flex gap-3">
                            <i class="bi bi-telephone text-blue-600 mt-0.5"></i>
                            <div>
                                <div class="font-semibold text-slate-900">WhatsApp Admin</div>
                                <a href="https://wa.me/6287821305379?text=Halo%20Admin,%20saya%20mau%20bertanya..."
                                    class="text-blue-600 hover:text-blue-700">
                                    +62 878 2130 5379
                                </a>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <i class="bi bi-envelope text-blue-600 mt-0.5"></i>
                            <div>
                                <div class="font-semibold text-slate-900">Email</div>
                                <span>rusunawa@live.undip.ac.id</span>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <i class="bi bi-geo-alt text-blue-600 mt-0.5"></i>
                            <div>
                                <div class="font-semibold text-slate-900">Alamat</div>
                                <span>Kawasan Kampus UNDIP Tembalang, Semarang, Jawa Tengah.</span>
                            </div>
                        </div>
                    </div>

                    <p class="mt-4 text-xs text-slate-500">
                        *Data kontak dapat disesuaikan dengan informasi resmi pengelola rusunawa.
                    </p>
                </div>

                {{-- Simple contact form (dummy) --}}
                <div class="bg-slate-50 rounded-2xl border p-6">
                    <h3 class="font-semibold text-slate-900 text-lg">Form Pesan Cepat</h3>
                    <p class="mt-1 text-xs text-slate-500">
                        Form ini dapat dikembangkan lebih lanjut untuk mengirim email ke admin.
                    </p>

                    <form action="#" method="POST" class="mt-4 space-y-3">
                        {{-- @csrf  --}}

                        <div>
                            <label class="text-xs font-semibold text-slate-600">Nama Lengkap</label>
                            <input type="text"
                                class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Nama Anda">
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-slate-600">Email / No. HP</label>
                            <input type="text"
                                class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="email@contoh.com / 08xxxxxxxxxx">
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-slate-600">Pesan</label>
                            <textarea
                                class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-blue-500"
                                rows="4" placeholder="Tulis pertanyaan atau kendala yang ingin disampaikan"></textarea>
                        </div>

                        <button type="button"
                            class="w-full mt-2 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">
                            (Demo) Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================================================
   FOOTER
   ========================================================= --}}
    <footer class="bg-[#070B55] text-white/80 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 py-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <div class="font-extrabold text-white">SIRKA Rusunawa UNDIP</div>
                    <div class="text-sm text-white/60 mt-1">
                        Sistem Informasi Reservasi Kamar Rusunawa • Tugas Akhir
                    </div>
                </div>
                <div class="text-sm text-white/60">
                    © {{ date('Y') }} • ICONIX Process • Universitas Diponegoro
                </div>
            </div>
        </div>
    </footer>

    {{-- =========================================================
   SCRIPTS (Slider + FAQ Accordion)
   ========================================================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // HERO BACKGROUND SLIDER
            (function() {
                const slides = document.querySelectorAll('[data-hero-slide]');
                if (!slides.length) return;

                let current = 0;
                const total = slides.length;
                const intervalMs = 5000; // 5 detik

                setInterval(() => {
                    slides[current].classList.remove('opacity-100');
                    slides[current].classList.add('opacity-0');

                    current = (current + 1) % total;

                    slides[current].classList.remove('opacity-0');
                    slides[current].classList.add('opacity-100');
                }, intervalMs);
            })();

            // FAQ accordion
            (function() {
                const buttons = document.querySelectorAll('[data-faq-button]');
                if (!buttons.length) return;

                buttons.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        const item = btn.parentElement;
                        const content = item.querySelector('[data-faq-content]');
                        const icon = item.querySelector('[data-faq-icon]');
                        const isOpen = !content.classList.contains('hidden');

                        // Tutup semua
                        document.querySelectorAll('[data-faq-content]').forEach(function(c) {
                            c.classList.add('hidden');
                        });
                        document.querySelectorAll('[data-faq-icon]').forEach(function(i) {
                            i.classList.remove('bi-dash');
                            i.classList.add('bi-plus');
                            i.style.transform = '';
                        });

                        // Kalau sebelumnya tertutup, buka yang ini
                        if (!isOpen) {
                            content.classList.remove('hidden');
                            icon.classList.remove('bi-plus');
                            icon.classList.add('bi-dash');
                            icon.style.transform = 'rotate(0deg)';
                        }
                    });
                });
            })();
        });
    </script>

</body>

</html>
