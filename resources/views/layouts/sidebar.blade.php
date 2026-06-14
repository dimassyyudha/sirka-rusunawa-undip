<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <button data-drawer-target="top-bar-sidebar" data-drawer-toggle="top-bar-sidebar"
                    aria-controls="top-bar-sidebar" type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-600 rounded-lg sm:hidden 
               hover:bg-gray-100 
               focus:outline-none focus:ring-0 focus:ring-transparent active:outline-none">
                    <span class="sr-only">Open sidebar</span>
                    <i class="bi bi-list text-2xl"></i>
                </button>

                <a href="{{ route('page.beranda') }}" class="flex ms-2 md:me-24 items-center">
                    <img src="{{ asset('assets-admin/images/logo/logo-undip-high.jpg') }}" class="h-12 me-3"
                        alt="Logo">

                </a>
            </div>

            <div class="flex items-center">
                <button type="button" class="flex items-center gap-3 px-2 py-1 rounded-lg hover:bg-gray-100"
                    data-dropdown-toggle="dropdown-user">

                    {{-- FOTO USER --}}
                    <div class="user-img d-flex align-items-center">
                        <div class="avatar avatar-md">
                            @if (Auth::user()->profile_photo)
                                <img src="{{ asset('uploads/profile_pictures/' . Auth::user()->profile_photo) }}"
                                    alt="Foto Profil" style="object-fit: cover;">
                            @else
                                <img src="{{ asset('assets-admin/images/faces/1.jpg') }}" alt="Default">
                            @endif
                        </div>
                    </div>

                    {{-- NAMA --}}
                    <div class="hidden md:block text-left">
                        <p class="text-sm font-semibold text-gray-900 mb-0">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-xs text-gray-500 mb-0 capitalize">
                            {{ auth()->user()->role }}
                        </p>
                    </div>

                    <i class="bi bi-chevron-down text-gray-500 hidden md:block"></i>
                </button>

                {{-- DROPDOWN --}}
                <div class="z-50 hidden my-4 bg-white divide-y divide-gray-100 rounded-lg shadow w-56"
                    id="dropdown-user">

                    <div class="px-4 py-3 flex items-center gap-3">

                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-900 mb-0 truncate">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="text-xs text-gray-500 mb-0 truncate">
                                {{ auth()->user()->email }}
                            </p>
                        </div>
                    </div>

                    <ul class="py-2 text-sm text-gray-700 list-none m-0 p-0">
                        <li>
                            <div class="px-4 py-2 text-xs font-semibold text-gray-500">
                                Hello, {{ strtok(auth()->user()->name, ' ') }}!
                            </div>
                        </li>

                        <li>
                            <a href="{{ route('admin.user.edit', auth()->user()->id) }}"
                                class="flex items-center px-4 py-2 text-gray-700 no-underline hover:bg-gray-100 hover:text-blue-600">
                                <i class="bi bi-person me-2"></i>
                                <span>My Profile</span>
                            </a>
                        </li>

                        <li>
                            <hr class="my-1 border-gray-100">
                        </li>

                        <li>
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form-navbar').submit();"
                                class="flex items-center px-4 py-2 text-red-600 no-underline hover:bg-red-50 hover:text-red-700">
                                <i class="bi bi-box-arrow-left me-2"></i>
                                <span>Logout</span>
                            </a>

                            <form id="logout-form-navbar" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<aside id="top-bar-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0"
    aria-label="Sidebar">

    <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
        <ul class="space-y-2 font-medium">

            @if (auth()->check() && auth()->user()->role === 'mahasiswa')
                <li class="px-2 pt-2 text-xs font-bold text-gray-400 uppercase">
                    Reservation Rusunawa
                </li>

                <li>
                    <a href="{{ route('mahasiswa.dashboard') }}"
                        class="flex items-center p-2 rounded-lg group
                       {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="bi bi-house-door-fill text-xl"></i>
                        <span class="ms-3">Beranda</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('mahasiswa.cari-kamar') }}"
                        class="flex items-center p-2 rounded-lg group
                       {{ request()->routeIs('mahasiswa.cari-kamar') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="bi bi-door-open-fill text-xl"></i>
                        <span class="ms-3">Daftar Kamar</span>
                    </a>
                </li>
            @endif

            @if (auth()->check() && auth()->user()->role === 'admin')
                <li class="px-2 pt-2 text-xs font-bold text-gray-400 uppercase">
                    Menu Utama
                </li>

                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center p-2 rounded-lg group
                       {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="bi bi-house text-xl"></i>
                        <span class="ms-3">Dashboard Admin</span>
                    </a>
                </li>

                <li class="px-2 pt-4 text-xs font-bold text-gray-400 uppercase">
                    Manajemen Rusunawa
                </li>

                <li>
                    <a href="{{ route('admin.buildings.index') }}"
                        class="flex items-center p-2 rounded-lg group
                       {{ request()->routeIs('admin.buildings.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="bi bi-building text-xl"></i>
                        <span class="ms-3">Building</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.floors.index') }}"
                        class="flex items-center p-2 rounded-lg group
                       {{ request()->routeIs('admin.floors.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="bi bi-grid-3x3-gap text-xl"></i>
                        <span class="ms-3">Floor</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.rooms.index') }}"
                        class="flex items-center p-2 rounded-lg group
                       {{ request()->routeIs('admin.rooms.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="bi bi-door-open-fill text-xl"></i>
                        <span class="ms-3">Manajemen Kamar</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.penghuni.index') }}"
                        class="flex items-center p-2 rounded-lg group
                       {{ request()->routeIs('admin.penghuni.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="bi bi-people-fill text-xl"></i>
                        <span class="ms-3">Manajemen Penghuni</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.transactions.index') }}"
                        class="flex items-center p-2 rounded-lg group
        {{ request()->routeIs('admin.transactions.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="bi bi-receipt text-xl"></i>
                        <span class="ms-3">Transactions</span>
                    </a>
                </li>

                <a href="{{ route('admin.Reservations.index') }}"
                    class="flex items-center gap-4 px-5 py-3 rounded-xl text-slate-700 hover:bg-slate-100 {{ request()->routeIs('admin.Reservations.*') ? 'bg-blue-600 text-white' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4h16v16H4z" />
                    </svg>

                    <span>Verifikasi Reservation</span>
                </a>

                <li>
                    <a href="{{ route('admin.reservations.index') }}"
                        class="flex items-center p-2 rounded-lg group
                       {{ request()->routeIs('admin.reservations.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="bi bi-journal-check text-xl"></i>
                        <span class="ms-3">Data Reservasi</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.financial.index') }}"
                        class="flex items-center p-2 rounded-lg group
                       {{ request()->routeIs('admin.financial.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="bi bi-cash-coin text-xl"></i>
                        <span class="ms-3">Laporan Keuangan</span>
                    </a>
                </li>

                @php
                    $settingsOpen = request()->routeIs('admin.settings.*');
                @endphp

                <li class="px-2 pt-4 text-xs font-bold text-gray-400 uppercase">
                    Pengaturan
                </li>

                <li>
                    <button type="button" data-collapse-toggle="settings-menu"
                        class="flex items-center w-full p-2 rounded-lg group
                            {{ $settingsOpen ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="bi bi-gear text-xl"></i>
                        <span class="flex-1 ms-3 text-left">Pengaturan Website</span>
                        <i class="bi bi-chevron-down"></i>
                    </button>

                    <ul id="settings-menu" class="{{ $settingsOpen ? '' : 'hidden' }} py-2 space-y-1">
                        <li><a href="{{ route('admin.settings.beranda.index') }}"
                                class="block p-2 ps-11 rounded-lg text-sm {{ request()->routeIs('admin.settings.beranda.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">Beranda</a>
                        </li>
                        <li><a href="{{ route('admin.settings.tentang-kami.index') }}"
                                class="block p-2 ps-11 rounded-lg text-sm {{ request()->routeIs('admin.settings.tentang-kami.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">Tentang
                                Kami</a></li>
                        <li><a href="{{ route('admin.settings.recommendation.index') }}"
                                class="block p-2 ps-11 rounded-lg text-sm {{ request()->routeIs('admin.settings.recommendation.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">Rekomendasi
                                Kamar</a></li>
                        <li><a href="{{ route('admin.settings.alur.index') }}"
                                class="block p-2 ps-11 rounded-lg text-sm {{ request()->routeIs('admin.settings.alur.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">Alur
                                Reservasi</a></li>
                        <li><a href="{{ route('admin.settings.cari-kamar.index') }}"
                                class="block p-2 ps-11 rounded-lg text-sm {{ request()->routeIs('admin.settings.cari-kamar.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">Cari
                                Kamar</a></li>
                        <li><a href="{{ route('admin.settings.faq.index') }}"
                                class="block p-2 ps-11 rounded-lg text-sm {{ request()->routeIs('admin.settings.faq.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">FAQ</a>
                        </li>
                        <li><a href="{{ route('admin.settings.kenapa.index') }}"
                                class="block p-2 ps-11 rounded-lg text-sm {{ request()->routeIs('admin.settings.kenapa.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">Kenapa</a>
                        </li>
                    </ul>
                </li>
            @endif

            <li class="pt-4">
                <a href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();"
                    class="flex items-center p-2 text-red-600 rounded-lg hover:bg-red-50 group">
                    <i class="bi bi-box-arrow-left text-xl"></i>
                    <span class="ms-3">Logout</span>
                </a>

                <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </li>

        </ul>
    </div>
</aside>
