<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - SIRKA Rusunawa UNDIP</title>

    <link rel="shortcut icon" type="image/png" href="{{ asset('assets-admin/images/logo/logo-undip-01.png') }}?v=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" />
</head>

<body class="bg-slate-100 text-slate-900">

    @php
        $role = auth()->user()->role ?? 'mahasiswa';

        $panel = config("panel.$role");

        $panelTitle = $panel['title'] ?? 'SIRKA';
        $panelSubtitle = $panel['subtitle'] ?? 'Panel';
        $menus = $panel['menus'] ?? [];
    @endphp
    @if (($menu['icon'] ?? null) === 'logout')
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M9.16667 17.5L5.83333 17.5V17.5C3.98765 17.5 2.5 16.0123 2.5 14.1667V14.1667L2.5 5.83333V5.83333C2.5 3.98765 3.98765 2.5 5.83333 2.5V2.5L9.16667 2.5M8.22814 10L17.117 10M14.3393 6.66667L17.0833 9.41074C17.3611 9.68852 17.5 9.82741 17.5 10C17.5 10.1726 17.3611 10.3115 17.0833 10.5893L14.3393 13.3333"
                stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
            </path>
        </svg>
    @endif
    <div class="min-h-screen">

        {{-- SIDEBAR DESKTOP --}}
        <aside class="hidden lg:flex fixed inset-y-0 left-0 z-40 w-[320px] bg-[#070B55] text-white flex-col">

            <div class="px-6 py-6 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets-admin/images/logo/logo-undip-01.png') }}"
                        class="w-11 h-11 object-contain" alt="Logo UNDIP">

                    <div>
                        <div class=" text-lg leading-none">
                            {{ $panelTitle }}
                        </div>
                        <div class="text-xs text-white/60 mt-1">
                            {{ $panelSubtitle }}
                        </div>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 text-sm font-bold overflow-y-auto">
                @foreach ($menus as $menu)
                    @if (isset($menu['section']))
                        <div class="px-4 pt-5 pb-2 text-[11px]  uppercase tracking-wider text-orange-500">
                            {{ $menu['section'] }}
                        </div>
                        @continue
                    @endif

                    @php
                        $isLogout = ($menu['icon'] ?? null) === 'logout';
                        $isActive = request()->routeIs($menu['active'] ?? $menu['route']);
                    @endphp

                    @if ($isLogout)
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition bg-red-500 hover:bg-red-600 text-white  ">

                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.16667 17.5L5.83333 17.5V17.5C3.98765 17.5 2.5 16.0123 2.5 14.1667V14.1667L2.5 5.83333V5.83333C2.5 3.98765 3.98765 2.5 5.83333 2.5V2.5L9.16667 2.5M8.22814 10L17.117 10M14.3393 6.66667L17.0833 9.41074C17.3611 9.68852 17.5 9.82741 17.5 10C17.5 10.1726 17.3611 10.3115 17.0833 10.5893L14.3393 13.3333"
                                        stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ Route::has($menu['route']) ? route($menu['route']) : '#' }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
                {{ request()->routeIs($menu['route']) ? 'bg-orange-500 text-white' : 'text-white hover:bg-white/10 hover:text-white' }}">
                            {{ $menu['label'] }}
                        </a>
                    @endif
                @endforeach
            </nav>

            {{-- <div class="p-4 border-t border-white/10">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full px-4 py-3 rounded-2xl bg-red-500 hover:bg-red-600 text-white  transition">
                        Logout
                    </button>
                </form>
            </div> --}}

        </aside>

        {{-- MAIN --}}
        <main class="lg:ml-[320px] min-h-screen">


            {{-- HEADER --}}
            <header class="sticky top-0 z-30 bg-white/90 backdrop-blur border-b border-slate-200">

                <div class="px-8 py-5 flex items-center justify-between gap-4">

                    <div class="flex items-center gap-3 min-w-0">

                        <div class="lg:hidden">
                            <x-button.hamburger-menu button-id="mobileMenuButton" menu-id="mobileMenu"
                                color="bg-[#070B55]" hover="hover:bg-slate-100" />
                        </div>

                        <div class="min-w-0">
                            <h1 class="text-lg sm:text-2xl  text-slate-900 truncate">
                                @yield('page_title', 'Dashboard')
                            </h1>
                            <p class="text-xs sm:text-sm text-slate-500 truncate">
                                {{ $panelSubtitle }}
                            </p>
                        </div>
                    </div>

                    <div class="hidden md:flex items-center gap-3">
                        <div class="text-right">
                            <div class="text-sm  text-slate-900">
                                {{ auth()->user()->name }}
                            </div>
                            <div class="text-xs text-slate-500">
                                {{ $role }}
                            </div>
                        </div>

                        <div class="w-11 h-11 rounded-2xl bg-orange-500 text-white flex items-center justify-center ">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                    </div>

                </div>

                {{-- MOBILE MENU --}}
                {{-- MOBILE MENU --}}
                <div id="mobileMenu" class="lg:hidden hidden bg-[#070B55] text-white border-t border-white/10">
                    <div class="px-5 py-5 flex flex-col gap-2 text-[16px] font-bold">

                        @foreach ($menus as $menu)
                            @if (isset($menu['section']))
                                <div class="px-4 pt-5 pb-2 text-[11px]  uppercase tracking-wider text-white/40">
                                    {{ $menu['section'] }}
                                </div>
                                @continue
                            @endif

                            <a href="{{ Route::has($menu['route']) ? route($menu['route']) : '#' }}"
                                class="px-4 py-3 rounded-2xl transition
               {{ request()->routeIs($menu['active'] ?? $menu['route']) ? 'bg-orange-500 text-white' : 'hover:bg-white/10 text-white/85' }}">
                                {{ $menu['label'] }}
                            </a>
                        @endforeach

                        <form action="{{ route('logout') }}" method="POST" class="pt-3">
                            @csrf
                            <button type="submit" class="w-full px-4 py-3 rounded-2xl bg-red-500 text-white ">
                                Logout
                            </button>
                        </form>

                    </div>
                </div>

            </header>

            <section class="p-4 sm:p-6">
                @include('components.alert.sweetalert')
                @include('components.alert.flash-message')
                @include('components.ui.badge')
                <br>
                @yield('content')
            </section>

        </main>

    </div>
    <div wire:target="navigate" class="fixed left-0 top-0 z-[9999] h-1 w-full bg-orange-500">
    </div>
    <x-alert.sweetalert />
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    @livewireScripts
    @stack('scripts')
    @stack('scripts-bottom')

</body>

</html>
