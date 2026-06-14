<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Mahasiswa') - SIRKA Rusunawa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">

<div class="min-h-screen flex">

    <aside class="w-72 bg-[#070B55] text-white hidden lg:flex flex-col">
        <div class="p-6 border-b border-white/10">
            <h1 class="text-xl font-black">SIRKA</h1>
            <p class="text-sm text-white/60">Portal Mahasiswa</p>
        </div>

        <nav class="flex-1 p-4 space-y-2 text-sm font-bold">
            <a href="{{ route('mahasiswa.dashboard') }}" class="block px-4 py-3 rounded-2xl hover:bg-white/10">Dashboard</a>
            <a href="{{ route('mahasiswa.kamar-saya') }}" class="block px-4 py-3 rounded-2xl hover:bg-white/10">Kamar Saya</a>
            <a href="{{ route('mahasiswa.reservasi') }}" class="block px-4 py-3 rounded-2xl hover:bg-white/10">Reservasi</a>
            <a href="{{ route('mahasiswa.pembayaran') }}" class="block px-4 py-3 rounded-2xl hover:bg-white/10">Pembayaran</a>
            <a href="{{ route('mahasiswa.perpanjang') }}" class="block px-4 py-3 rounded-2xl hover:bg-white/10">Perpanjang Sewa</a>
            <a href="{{ route('mahasiswa.pindah-kamar') }}" class="block px-4 py-3 rounded-2xl hover:bg-white/10">Pindah Kamar</a>
            <a href="{{ route('mahasiswa.akhiri-kontrak') }}" class="block px-4 py-3 rounded-2xl hover:bg-white/10">Akhiri Kontrak</a>
            <a href="{{ route('mahasiswa.profil') }}" class="block px-4 py-3 rounded-2xl hover:bg-white/10">Profil Saya</a>
        </nav>
    </aside>

    <main class="flex-1">
        <header class="bg-white border-b border-slate-200 px-6 py-5">
            <h2 class="text-2xl font-black">@yield('page_title', 'Dashboard')</h2>
        </header>

        <section class="p-6">
            @yield('content')
        </section>
    </main>

</div>

</body>
</html>