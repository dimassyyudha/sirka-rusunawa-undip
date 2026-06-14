@php
    $menus = [
        [
            'label' => 'Dashboard',
            'route' => 'mahasiswa.dashboard',
            'icon' => 'dashboard',
        ],
        [
            'label' => 'Kamar Saya',
            'route' => 'mahasiswa.kamar-saya',
            'icon' => 'room',
        ],
        [
            'label' => 'Reservasi',
            'route' => 'mahasiswa.reservasi',
            'icon' => 'reservation',
        ],
        [
            'label' => 'Pembayaran',
            'route' => 'mahasiswa.pembayaran',
            'icon' => 'payment',
        ],
        [
            'label' => 'Perpanjang Sewa',
            'route' => 'mahasiswa.perpanjang',
            'icon' => 'calendar',
        ],
        [
            'label' => 'Pindah Kamar',
            'route' => 'mahasiswa.pindah-kamar',
            'icon' => 'transfer',
        ],
        [
            'label' => 'Review Kamar',
            'route' => 'mahasiswa.review',
            'icon' => 'star',
        ],
        [
            'label' => 'Profil Saya',
            'route' => 'mahasiswa.profil',
            'icon' => 'profile',
        ],
    ];
@endphp

<div id="studentSidebarOverlay"
     class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden">
</div>

<aside id="studentSidebar"
       class="fixed inset-y-0 left-0 z-50
              w-72 bg-[#070B55] text-white
              transform -translate-x-full lg:translate-x-0
              transition-transform duration-300">

    <div class="h-full flex flex-col">

        {{-- LOGO --}}
        <div class="h-20 px-5 flex items-center justify-between border-b border-white/10">

            <a href="{{ route('page.beranda') }}"
               class="flex items-center gap-3">

                <img src="{{ asset('assets-admin/images/logo/logo-undip-01.png') }}"
                     class="w-11 h-11 object-contain"
                     alt="UNDIP">

                <div>

                    <div class="text-lg font-black">
                        SIRKA
                    </div>

                    <div class="text-xs text-white/60">
                        Portal Mahasiswa
                    </div>

                </div>

            </a>

            {{-- CLOSE --}}
            <button id="closeStudentSidebar"
                    class="lg:hidden w-10 h-10 rounded-xl hover:bg-white/10 flex items-center justify-center">

                <svg class="w-6 h-6"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M6 18L18 6M6 6l12 12"/>

                </svg>

            </button>

        </div>

        {{-- USER --}}
        <div class="px-5 py-4 border-b border-white/10">

            <div class="flex items-center gap-3">

                <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center font-black">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>

                <div class="min-w-0">

                    <div class="font-bold truncate">
                        {{ auth()->user()->name }}
                    </div>

                    <div class="text-xs text-white/60 truncate">
                        {{ auth()->user()->email }}
                    </div>

                </div>

            </div>

        </div>

        {{-- MENU --}}
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">

            @foreach ($menus as $menu)

                @php
                    $active = request()->routeIs($menu['route']);
                @endphp

                <a href="{{ Route::has($menu['route']) ? route($menu['route']) : '#' }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all duration-200
                   {{ $active
                        ? 'bg-orange-500 text-white shadow-lg shadow-orange-900/20'
                        : 'text-white/75 hover:bg-white/10 hover:text-white'
                   }}">

                    {{-- ICON --}}
                    <div class="shrink-0">

                        @switch($menu['icon'])

                            @case('dashboard')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13h8V3H3v10zm10 8h8V3h-8v18zM3 21h8v-6H3v6z"/>
                                </svg>
                            @break

                            @case('room')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 21V9l9-6 9 6v12M9 21v-6h6v6"/>
                                </svg>
                            @break

                            @case('reservation')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M5 11h14"/>
                                </svg>
                            @break

                            @case('payment')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18"/>
                                </svg>
                            @break

                            @case('calendar')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3"/>
                                </svg>
                            @break

                            @case('transfer')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h11"/>
                                </svg>
                            @break

                            @case('star')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.5"/>
                                </svg>
                            @break

                            @default
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a5 5 0 100-10"/>
                                </svg>

                        @endswitch

                    </div>

                    <span>
                        {{ $menu['label'] }}
                    </span>

                </a>

            @endforeach

        </nav>

        {{-- LOGOUT --}}
        <div class="p-4 border-t border-white/10">

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-2xl
                               bg-white/10 hover:bg-red-500
                               text-white font-bold transition">

                    <svg class="w-5 h-5"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M17 16l4-4m0 0l-4-4m4 4H9"/>

                    </svg>

                    Logout

                </button>

            </form>

        </div>

    </div>

</aside>