<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - SIRKA Rusunawa UNDIP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>

<body class="bg-slate-100 text-slate-900">

    @php
        $panelTitle = $panelTitle ?? 'SIRKA';
        $panelSubtitle = $panelSubtitle ?? 'Panel Sistem';
        $userRole = $userRole ?? ucfirst(auth()->user()->role ?? 'User');

        $menus = $menus ?? [];
    @endphp

    <div class="min-h-screen">

        {{-- SIDEBAR DESKTOP --}}
        <aside class="hidden lg:flex fixed inset-y-0 left-0 z-40 w-72 bg-[#070B55] text-white flex-col">

            <div class="px-6 py-6 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets-admin/images/logo/logo-undip-01.png') }}" class="w-11 h-11 object-contain"
                        alt="Logo UNDIP">

                    <div>
                        <div class="font-black text-lg leading-none">
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
                    @php
                        $isActive = collect((array) ($menu['active'] ?? $menu['route']))->contains(
                            fn($pattern) => request()->routeIs($pattern),
                        );
                    @endphp

                    <a href="{{ route($menu['route']) }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
            {{ $isActive ? 'bg-orange-500 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">

                        {{ $menu['label'] }}

                    </a>
                @endforeach
            </nav>

            <div class="p-4 border-t border-white/10">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full px-4 py-3 rounded-2xl bg-red-500 hover:bg-red-600 text-white font-black transition">
                        Logout
                    </button>
                </form>
            </div>

        </aside>

        {{-- MAIN --}}
        <main class="lg:ml-72 min-h-screen">

            {{-- HEADER --}}
            <header class="sticky top-0 z-30 bg-white/90 backdrop-blur border-b border-slate-200">

                <div class="px-4 sm:px-6 py-4 flex items-center justify-between gap-4">

                    <div class="flex items-center gap-3 min-w-0">

                        <div class="lg:hidden">
                            <x-button.hamburger-menu buttonId="mobileMenuButton" menuId="mobileMenu"
                                color="bg-[#070B55]" hover="hover:bg-slate-100" />
                        </div>

                        <div class="min-w-0">
                            <h1 class="text-lg sm:text-2xl font-black text-slate-900 truncate">
                                @yield('page_title', 'Dashboard')
                            </h1>
                            <p class="text-xs sm:text-sm text-slate-500 truncate">
                                {{ $panelSubtitle }}
                            </p>
                        </div>
                    </div>

                    <div class="hidden md:flex items-center gap-3">
                        <div class="text-right">
                            <div class="text-sm font-black text-slate-900">
                                {{ auth()->user()->name }}
                            </div>
                            <div class="text-xs text-slate-500">
                                {{ $userRole }}
                            </div>
                        </div>

                        <div
                            class="w-11 h-11 rounded-2xl bg-orange-500 text-white flex items-center justify-center font-black">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                    </div>

                </div>

                {{-- MOBILE MENU --}}
                <div id="mobileMenu" class="lg:hidden hidden bg-[#070B55] text-white border-t border-white/10">

                    <div class="px-5 py-5 flex flex-col gap-2 text-[16px] font-bold">

                        @foreach ($menus as $menu)
                            @php
                                $isActive = collect((array) ($menu['active'] ?? $menu['route']))->contains(
                                    fn($pattern) => request()->routeIs($pattern),
                                );
                            @endphp

                            <a href="{{ route($menu['route']) }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
                {{ $isActive ? 'bg-orange-500 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">

                                {{ $menu['label'] }}

                            </a>
                        @endforeach

                        <form action="{{ route('logout') }}" method="POST" class="pt-3">
                            @csrf

                            <button type="submit"
                                class="w-full px-4 py-3 rounded-2xl bg-red-500 text-white font-black">
                                Logout
                            </button>
                        </form>

                    </div>

                </div>

            </header>

            <section class="p-4 sm:p-6">
                @yield('content')
            </section>

        </main>

    </div>

    @stack('scripts')

</body>

</html>
