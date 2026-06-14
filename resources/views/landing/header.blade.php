<header class="sticky top-0 z-50">

    <div class="bg-[#070B55] text-white border-b border-white/10">

        <div class="max-w-7xl mx-auto px-4 sm:px-5 lg:px-6">

            <div class="h-[74px] flex items-center justify-between gap-3">

                {{-- LEFT --}}
                <div class="flex items-center gap-3 shrink-0">

                    {{-- MOBILE HAMBURGER --}}
                    <div class="xl:hidden">

                        <x-button.hamburger-menu button-id="mobileMenuButton" menu-id="mobileMenu" color="bg-white"
                            hover="hover:bg-white/10" />

                    </div>

                    {{-- LOGO --}}
                    <a href="{{ route('page.beranda') }}" class="flex items-center gap-3 min-w-0">

                        <img src="{{ asset('assets-admin/images/logo/logo-undip-01.png') }}"
                            class="h-10 w-10 md:h-11 md:w-11 object-contain shrink-0" alt="UNDIP">

                        <div class="leading-tight min-w-0">

                            <div
                                class="font-extrabold uppercase tracking-wide text-[12px] sm:text-[13px] md:text-[14px] truncate">
                                Universitas Diponegoro
                            </div>

                            <div class="text-[9px] sm:text-[10px] md:text-[11px] italic text-white/70 truncate">
                                The Excellent Research University
                            </div>

                        </div>

                    </a>

                </div>

                {{-- DESKTOP NAV --}}
                <nav class="hidden xl:flex items-center gap-1">


                    <a href="{{ route('page.beranda') }}"
                        class="
    relative px-3 py-2 transition-all duration-200

    {{ request()->routeIs('page.beranda')
        ? 'text-orange-500 font-semibold after:absolute after:left-3 after:right-3 after:-bottom-1 after:h-[2px] after:bg-orange-500 after:rounded-full'
        : 'text-white hover:text-orange-500' }}
">
                        Beranda
                    </a>

                    <a href="{{ route('cari-kamar.index') }}"
                        class="
    relative px-3 py-2 transition-all duration-200

    {{ request()->routeIs('cari-kamar.*')
        ? 'text-orange-500 font-semibold after:absolute after:left-3 after:right-3 after:-bottom-1 after:h-[2px] after:bg-orange-500 after:rounded-full'
        : 'text-white hover:text-orange-500' }}
">
                        Reservasi Kamar
                    </a>

                    <a href="{{ route('Reservation.check') }}"
                        class="
    relative px-3 py-2 transition-all duration-200

    {{ request()->routeIs('Reservation.*')
        ? 'text-orange-500 font-semibold after:absolute after:left-3 after:right-3 after:-bottom-1 after:h-[2px] after:bg-orange-500 after:rounded-full'
        : 'text-white hover:text-orange-500' }}
">
                        Cek Transaksi
                    </a>

                    <div class="relative group">

                        <button type="button"
                            class="flex items-center gap-1 px-3 py-2 hover:text-orange-500 transition">

                            Tentang Kami

                            <svg class="h-4 w-4 transition duration-300 group-hover:rotate-180" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7" />

                            </svg>

                        </button>

                        <div
                            class="invisible absolute left-0 top-full z-50 mt-3 w-64 rounded-2xl border border-slate-200 bg-white p-2 text-slate-700 opacity-0 shadow-xl transition-all duration-200 group-hover:visible group-hover:opacity-100">

                            <div class="flex flex-col">

                                <a href="{{ route('about.index') }}"
                                    class="rounded-xl px-4 py-3 hover:text-orange-500 transition">
                                    Tentang Kami
                                </a>

                                <a href="{{ route('about.visi-misi') }}"
                                    class="rounded-xl px-4 py-3 hover:text-orange-500 transition">
                                    Visi & Misi
                                </a>

                                <a href="{{ route('about.gedung') }}"
                                    class="rounded-xl px-4 py-3 hover:text-orange-500 transition">
                                    Paparan Gedung
                                </a>

                                <a href="{{ route('about.fasilitas') }}"
                                    class="rounded-xl px-4 py-3 hover:text-orange-500 transition">
                                    Fasilitas Umum
                                </a>

                                <a href="{{ route('about.aturan') }}"
                                    class="rounded-xl px-4 py-3 hover:text-orange-500 transition">
                                    Aturan / Tata Tertib
                                </a>

                            </div>

                        </div>

                    </div>

                    <a href="{{ route('page.testimoni') }}"
                        class="
    relative px-3 py-2 transition-all duration-200

    {{ request()->routeIs('page.testimoni')
        ? 'text-orange-500 font-semibold after:absolute after:left-3 after:right-3 after:-bottom-1 after:h-[2px] after:bg-orange-500 after:rounded-full'
        : 'text-white hover:text-orange-500' }}
">
                        Testimoni
                    </a>

                    <a href="{{ route('page.faq') }}"
                        class="
    relative px-3 py-2 transition-all duration-200

    {{ request()->routeIs('page.faq')
        ? 'text-orange-500 font-semibold after:absolute after:left-3 after:right-3 after:-bottom-1 after:h-[2px] after:bg-orange-500 after:rounded-full'
        : 'text-white hover:text-orange-500' }}
">
                        FAQ
                    </a>

                </nav>

                {{-- RIGHT --}}
                <div class="flex items-center gap-2 shrink-0">

                    @guest

                        <a href="{{ route('login') }}" target="_blank"
                            class="hidden xl:inline-flex px-5 py-2 rounded-2xl border border-white/20 text-white font-bold hover:text-orange-500 transition">
                            Login
                        </a>

                        <a href="{{ route('register') }}" target="_blank"
                            class="hidden xl:inline-flex px-5 py-2 rounded-2xl bg-white text-[#070B55] font-extrabold hover:bg-slate-100 transition">
                            Register
                        </a>

                    @endguest

                    @auth

                        @if (auth()->user()->role === 'mahasiswa')
                            {{-- DESKTOP PROFILE --}}
                            <div class="hidden xl:block relative">

                                <button id="profileButton" type="button"
                                    class="flex items-center gap-3 px-3 py-1.5 rounded-2xl transition">

                                    <div
                                        class="w-10 h-10 rounded-full overflow-hidden border border-white/10 bg-white flex items-center justify-center">

                                        @if (auth()->user()->profile_photo)
                                            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                                                alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-white text-sm font-black">
                                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                            </span>
                                        @endif

                                    </div>

                                    <div class="text-left leading-tight">

                                        <div class="text-sm font-extrabold">
                                            {{ strtok(auth()->user()->name, ' ') }}
                                        </div>

                                        <div class="text-[11px] text-white/60">
                                            Mahasiswa
                                        </div>

                                    </div>

                                    <svg class="w-4 h-4 text-white/70" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">

                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />

                                    </svg>

                                </button>

                                <div id="profileDropdown"
                                    class="hidden absolute right-0 mt-3 w-[250px] bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden z-50">

                                    <div class="bg-gradient-to-r from-orange-500 to-orange-400 px-4 py-3 text-white">

                                        <div class="text-sm truncate">
                                            {{ auth()->user()->name }}
                                        </div>

                                        <div class="text-[11px] text-white/80 mt-0.5">
                                            Portal Mahasiswa Rusunawa
                                        </div>

                                    </div>

                                    <div class="p-2">

                                        <a href="{{ route('mahasiswa.dashboard') }}" target="_blank"
                                            class="block px-3 py-3 rounded-xl hover:bg-slate-50 text-sm font-bold text-slate-900 transition">
                                            My Portal
                                        </a>

                                    </div>

                                    <div class="border-t border-slate-100 p-2">

                                        <form action="{{ route('logout') }}" method="POST">

                                            @csrf

                                            <button type="submit"
                                                class="w-full px-3 py-3 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-bold transition">
                                                Logout
                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                            {{-- MOBILE PROFILE --}}
                            <div class="xl:hidden relative">

                                <button id="mobileProfileButton" type="button"
                                    class="flex items-center gap-2 rounded-2xl px-2 py-1.5 hover:bg-white/5 transition">

                                    <div
                                        class="w-10 h-10 rounded-full overflow-hidden border border-white/10 bg-orange-500 flex items-center justify-center">

                                        @if (auth()->user()->profile_photo)
                                            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                                                alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-white text-sm font-black">
                                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                            </span>
                                        @endif

                                    </div>

                                    <svg class="w-4 h-4 text-white/70" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">

                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />

                                    </svg>

                                </button>

                                {{-- MOBILE PROFILE DROPDOWN --}}
                                <div id="mobileProfileDropdown"
                                    class="hidden absolute right-0 mt-3 w-[220px] rounded-2xl border border-slate-200 bg-white shadow-2xl overflow-hidden z-50">

                                    <div class="bg-gradient-to-r from-orange-500 to-orange-400 px-4 py-4 text-white">

                                        <div class="flex items-center gap-3">

                                            <div
                                                class="w-12 h-12 rounded-full overflow-hidden border border-white/20 bg-white/10 flex items-center justify-center shrink-0">

                                                @if (auth()->user()->profile_photo)
                                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                                                        alt="{{ auth()->user()->name }}"
                                                        class="w-full h-full object-cover">
                                                @else
                                                    <span class="text-white text-sm font-black">
                                                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                                    </span>
                                                @endif

                                            </div>

                                            <div class="min-w-0">

                                                <div class="text-sm font-black truncate">
                                                    {{ auth()->user()->name }}
                                                </div>

                                                <div class="text-[11px] text-white/80">
                                                    Mahasiswa
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="p-2">

                                        <a href="{{ route('mahasiswa.dashboard') }}"
                                            class="block rounded-xl px-4 py-3 text-sm font-bold text-slate-800 hover:bg-slate-50 transition">
                                            My Portal
                                        </a>

                                    </div>

                                    <div class="border-t border-slate-100 p-2">

                                        <form action="{{ route('logout') }}" method="POST">

                                            @csrf

                                            <button type="submit"
                                                class="w-full rounded-xl bg-red-500 px-4 py-3 text-sm font-bold text-white hover:bg-red-600 transition">
                                                Logout
                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </div>
                        @endif

                    @endauth

                </div>

            </div>

        </div>

    </div>

    {{-- MOBILE MENU --}}
    <div id="mobileMenu" class="xl:hidden hidden bg-[#070B55] text-white border-t border-white/10">

        <div class="px-5 py-5 flex flex-col gap-4 text-[16px]">

            <a href="{{ route('page.beranda') }}" class="hover:text-orange-500 transition">
                Beranda
            </a>

            <a href="{{ route('cari-kamar.index') }}" class="hover:text-orange-500 transition">
                Reservasi Kamar
            </a>

            <a href="{{ route('Reservation.check') }}" class="hover:text-orange-500 transition">
                Cek Transaksi
            </a>

            <details class="group">

                <summary
                    class="flex cursor-pointer list-none items-center justify-between hover:text-orange-500 transition">

                    <span>Tentang Kami</span>

                    <svg class="h-4 w-4 transition group-open:rotate-180" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7" />

                    </svg>

                </summary>

                <div class="mt-3 ml-4 flex flex-col gap-3 text-white">

                    <a href="{{ route('about.index') }}" class="hover:text-orange-500 transition">
                        Tentang Kami
                    </a>

                    <a href="{{ route('about.visi-misi') }}" class="hover:text-orange-500 transition">
                        Visi & Misi
                    </a>

                    <a href="{{ route('about.gedung') }}" class="hover:text-orange-500 transition">
                        Paparan Gedung
                    </a>

                    <a href="{{ route('about.fasilitas') }}" class="hover:text-orange-500 transition">
                        Fasilitas Umum
                    </a>

                    <a href="{{ route('about.aturan') }}" class="hover:text-orange-500 transition">
                        Aturan / Tata Tertib
                    </a>

                </div>

            </details>

            <a href="{{ route('page.testimoni') }}" class="hover:text-orange-500 transition">
                Testimoni
            </a>

            <a href="{{ route('page.faq') }}" class="hover:text-orange-500 transition">
                FAQ
            </a>

            @guest

                <div class="grid grid-cols-2 gap-3 pt-4">

                    <a href="{{ route('login') }}"
                        class="rounded-2xl border border-white/20 px-4 py-3 text-center font-bold hover:text-orange-500 transition">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                        class="rounded-2xl bg-white px-4 py-3 text-center font-extrabold text-[#070B55] hover:bg-slate-100 transition">
                        Register
                    </a>

                </div>

            @endguest

        </div>

    </div>

</header>

<script>
    const profileButton = document.getElementById('profileButton');

    const profileDropdown = document.getElementById('profileDropdown');

    if (profileButton && profileDropdown) {

        profileButton.addEventListener('click', function(e) {

            e.stopPropagation();

            profileDropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', function(e) {

            if (
                !profileDropdown.contains(e.target) &&
                !profileButton.contains(e.target)
            ) {
                profileDropdown.classList.add('hidden');
            }
        });
    }

    const mobileProfileButton = document.getElementById(
        'mobileProfileButton'
    );

    const mobileProfileDropdown = document.getElementById(
        'mobileProfileDropdown'
    );

    if (mobileProfileButton && mobileProfileDropdown) {

        mobileProfileButton.addEventListener(
            'click',
            function(e) {

                e.stopPropagation();

                mobileProfileDropdown.classList.toggle(
                    'hidden'
                );
            }
        );

        document.addEventListener(
            'click',
            function(e) {

                if (
                    !mobileProfileDropdown.contains(e.target) &&
                    !mobileProfileButton.contains(e.target)
                ) {
                    mobileProfileDropdown.classList.add(
                        'hidden'
                    );
                }
            }
        );
    }


    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');

    if (mobileMenuButton && mobileMenu) {

        mobileMenuButton.addEventListener('click', function(e) {

            e.stopPropagation();

            mobileMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', function(e) {

            if (
                !mobileMenu.contains(e.target) &&
                !mobileMenuButton.contains(e.target)
            ) {
                mobileMenu.classList.add('hidden');
            }

        });
    }
</script>
