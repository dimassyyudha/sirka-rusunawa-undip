{{-- resources/views/frontend/about-us.blade.php --}}
<section id="about" class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-4">

        {{-- ================= HEADER ================= --}}
        <div class="max-w-3xl">
            <p class="text-xs font-semibold tracking-[0.25em] uppercase text-sky-600">
                {{ $tentang['badge'] ?? 'Tentang Kami' }}
            </p>

            <h2 class="mt-2 text-3xl md:text-4xl font-black text-slate-900">
                {{ $tentang['title'] ?? 'Mengenal Rusunawa UNDIP & SIRKA Lebih Dekat' }}
            </h2>

            <p class="mt-3 text-sm md:text-base text-slate-600 leading-relaxed">
                {{ $tentang['description'] ?? '' }}
            </p>
        </div>

        {{-- ================= BLOK 1: PROFIL ================= --}}
        <div class="mt-12 grid md:grid-cols-2 gap-10 items-center">
            {{-- Gambar --}}
            <div class="relative">
                <div class="rounded-3xl overflow-hidden shadow-lg border border-slate-200 bg-slate-100">
                    <img
                        src="{{ !empty($tentang['blok1_image']) ? asset('storage/'.$tentang['blok1_image']) : asset('assets-admin/images/hero-1.jpg') }}"
                        alt="Profil Rusunawa UNDIP"
                        class="w-full h-72 md:h-80 object-cover"
                    >
                </div>
                <div class="hidden md:block absolute -bottom-4 -right-4 w-24 h-24 rounded-3xl bg-sky-600/80 blur-2xl opacity-60"></div>
            </div>

            {{-- Teks --}}
            <div class="space-y-4">
                <h3 class="text-2xl md:text-3xl font-black text-slate-900">
                    {{ $tentang['blok1_title'] ?? 'Profil Rusunawa UNDIP' }}
                </h3>

                <p class="text-sm md:text-base text-slate-600 leading-relaxed">
                    {{ $tentang['blok1_body'] ?? '' }}
                </p>

                @php
                    $blok1Points = array_values(array_filter(($tentang['blok1_points'] ?? []), fn($x) => trim((string)$x) !== ''));
                @endphp

                @if(!empty($blok1Points))
                    <ul class="space-y-2 text-sm md:text-base text-slate-700">
                        @foreach($blok1Points as $point)
                            <li class="flex gap-2">
                                <span class="mt-1 text-sky-600"><i class="bi bi-check-circle-fill"></i></span>
                                <span>{{ $point }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        {{-- ================= BLOK 2: VISI & MISI ================= --}}
        <div class="mt-16 grid md:grid-cols-2 gap-10 items-center">
            {{-- Teks --}}
            <div class="space-y-4 md:pr-6">
                <h3 class="text-2xl md:text-3xl font-black text-slate-900">
                    {{ $tentang['blok2_title'] ?? 'Visi & Misi Pengelolaan Rusunawa' }}
                </h3>

                <div class="bg-sky-50 border border-sky-100 rounded-3xl p-5 md:p-6">
                    <h4 class="text-sm font-bold tracking-wide text-sky-700 uppercase mb-1">
                        Visi
                    </h4>
                    <p class="text-sm md:text-base text-slate-700 leading-relaxed">
                        {{ $tentang['blok2_visi'] ?? '' }}
                    </p>
                </div>

                @php
                    $blok2Misi = array_values(array_filter(($tentang['blok2_misi'] ?? []), fn($x) => trim((string)$x) !== ''));
                @endphp

                @if(!empty($blok2Misi))
                    <div class="bg-white border border-slate-200 rounded-3xl p-5 md:p-6 shadow-sm">
                        <h4 class="text-sm font-bold tracking-wide text-slate-700 uppercase mb-2">
                            Misi
                        </h4>
                        <ul class="space-y-2 text-sm md:text-base text-slate-700">
                            @foreach($blok2Misi as $misi)
                                <li class="flex gap-2">
                                    <span class="mt-1 text-sky-600"><i class="bi bi-dot"></i></span>
                                    <span>{{ $misi }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            {{-- Gambar --}}
            <div class="relative">
                <div class="rounded-3xl overflow-hidden shadow-lg border border-slate-200 bg-slate-100">
                    <img
                        src="{{ !empty($tentang['blok2_image']) ? asset('storage/'.$tentang['blok2_image']) : asset('assets-admin/images/hero-2.jpg') }}"
                        alt="Visi dan Misi Rusunawa"
                        class="w-full h-72 md:h-80 object-cover"
                    >
                </div>
                <div class="hidden md:block absolute -top-4 -left-4 w-24 h-24 rounded-3xl bg-amber-400/80 blur-2xl opacity-70"></div>
            </div>
        </div>

        {{-- ================= BLOK 3: KEUNGGULAN ================= --}}
        <div class="mt-16 grid md:grid-cols-2 gap-10 items-center">
            {{-- Gambar --}}
            <div class="relative">
                <div class="rounded-3xl overflow-hidden shadow-lg border border-slate-200 bg-slate-100">
                    <img
                        src="{{ !empty($tentang['blok3_image']) ? asset('storage/'.$tentang['blok3_image']) : asset('assets-admin/images/hero-3.jpg') }}"
                        alt="Keunggulan SIRKA"
                        class="w-full h-72 md:h-80 object-cover"
                    >
                </div>

                @if(!empty($tentang['blok3_badge']))
                    <div class="hidden md:block absolute bottom-6 left-6 bg-slate-900/80 text-white text-xs font-semibold px-4 py-2 rounded-full">
                        {{ $tentang['blok3_badge'] }}
                    </div>
                @endif
            </div>

            {{-- Teks --}}
            <div class="space-y-4 md:pl-6">
                <h3 class="text-2xl md:text-3xl font-black text-slate-900">
                    {{ $tentang['blok3_title'] ?? 'Keunggulan Sistem SIRKA' }}
                </h3>

                <p class="text-sm md:text-base text-slate-600 leading-relaxed">
                    {{ $tentang['blok3_body'] ?? '' }}
                </p>

                @php
                    $cards = $tentang['blok3_cards'] ?? [];
                    $cards = array_values(array_filter($cards, function ($c) {
                        $t = trim((string)($c['title'] ?? ''));
                        $d = trim((string)($c['desc'] ?? ''));
                        return $t !== '' || $d !== '';
                    }));
                @endphp

                @if(!empty($cards))
                    <div class="grid sm:grid-cols-2 gap-3">
                        @foreach($cards as $card)
                            <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4">
                                <p class="text-sm font-bold text-slate-900 mb-1">
                                    {{ $card['title'] ?? '' }}
                                </p>
                                <p class="text-xs md:text-sm text-slate-600">
                                    {{ $card['desc'] ?? '' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- ================= BLOK 4: ATURAN & NILAI ================= --}}
        <div class="mt-16 grid lg:grid-cols-3 gap-6">
            {{-- aturan --}}
            <div class="lg:col-span-2 rounded-3xl bg-slate-50 border border-slate-200 p-6 md:p-8">
                <h3 class="text-xl md:text-2xl font-black text-slate-900">
                    {{ $tentang['blok4_rules_title'] ?? 'Aturan Umum Penghuni' }}
                </h3>
                <p class="mt-2 text-sm md:text-base text-slate-600">
                    {{ $tentang['blok4_rules_body'] ?? '' }}
                </p>

                @php
                    $rules = array_values(array_filter(($tentang['blok4_rules'] ?? []), fn($x) => trim((string)$x) !== ''));
                @endphp

                @if(!empty($rules))
                    <ul class="mt-4 grid sm:grid-cols-2 gap-2 text-sm md:text-base text-slate-700">
                        @foreach($rules as $rule)
                            <li class="flex gap-2">
                                <span class="mt-1 text-sky-600"><i class="bi bi-shield-lock-fill"></i></span>
                                <span>{{ $rule }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- nilai utama --}}
            <div class="rounded-3xl bg-slate-900 text-white p-6 md:p-8 flex flex-col justify-between">
                <div>
                    <p class="text-xs font-semibold tracking-[0.25em] uppercase text-sky-300">
                        {{ $tentang['blok4_value_badge'] ?? 'Nilai Utama' }}
                    </p>

                    <h3 class="mt-2 text-xl md:text-2xl font-black">
                        {{ $tentang['blok4_value_title'] ?? '' }}
                    </h3>

                    <p class="mt-3 text-sm md:text-base text-slate-200">
                        {{ $tentang['blok4_value_body'] ?? '' }}
                    </p>
                </div>

                <div class="mt-6 text-xs text-slate-300">
                    {{ $tentang['blok4_value_footer'] ?? '' }}
                </div>
            </div>
        </div>

    </div>
</section>
