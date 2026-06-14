<section id="beranda" class="relative overflow-hidden h-[calc(100vh-74px)] min-h-[520px]">
    @php
        $active = collect($beranda['background_images'] ?? [])
            ->where('is_active', true)
            ->sortBy('sort_order')
            ->values();

        $fallback = asset('assets-admin/images/hero-1.jpg');
        $availableRooms = $availableRooms ?? 0;
        $availableByBuilding = $availableByBuilding ?? ['A' => 0, 'B' => 0, 'C' => 0, 'D' => 0, 'E' => 0, 'F' => 0];
    @endphp

    <div class="absolute inset-0">
        @if ($active->isNotEmpty())
            @foreach ($active as $i => $bg)
                @php
                    $url = !empty($bg['image']) ? asset('storage/' . $bg['image']) : $fallback;
                @endphp
                <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 {{ $i === 0 ? 'opacity-100' : 'opacity-0' }}"
                    data-hero-slide style="background-image:url('{{ $url }}');">
                </div>
            @endforeach
        @else
            <div class="absolute inset-0 bg-cover bg-center opacity-100" data-hero-slide
                style="background-image:url('{{ $fallback }}');"></div>
        @endif

        <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-black/10"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 py-12 lg:py-16 h-full">
        <div class="flex flex-col justify-center h-full max-w-2xl text-white">

            {{-- <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/15 border border-white/20 text-xs md:text-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
                Resmi UNDIP • Sistem reservasi digital
            </div> --}}

            <h1 class="mt-4 text-4xl md:text-6xl font-black leading-tight">
                <span id="typed-headline" data-text="{{ $beranda['headline'] ?? 'Reservasi Rusunawa UNDIP' }}">
                </span>
                <span class="inline-block w-[3px] h-[1em] bg-white ml-1 animate-pulse"></span>
            </h1>


            <p class="mt-4 text-white/90 text-base md:text-lg max-w-lg leading-relaxed">
                {{ $beranda['subheadline'] ?? 'Mudah, cepat, transparan.' }}
            </p>

            <div class="mt-7 flex flex-wrap items-center gap-5">
                <a href="{{ route('cari-kamar.index') }}"
                    class="inline-flex items-center justify-center px-7 py-3 rounded-2xl bg-[#0B63F8] hover:bg-[#0850c5] text-sm md:text-base font-extrabold shadow-lg shadow-blue-900/40 transition">
                    {{ $beranda['cta_text'] ?? 'Reservasi Kamar' }}
                    <i class="bi bi-arrow-right-short text-xl ms-1"></i>
                </a>

                {{-- STATS (kamar tersedia, bukan slot) --}}

            </div>

            {{-- <div class="mt-8 flex gap-3 flex-wrap">
                <span class="px-3 py-1 rounded-full bg-white/10 border border-white/15 text-xs">Dekat fakultas</span>
                <span class="px-3 py-1 rounded-full bg-white/10 border border-white/15 text-xs">Aman 24 jam</span>
                <span class="px-3 py-1 rounded-full bg-white/10 border border-white/15 text-xs">Harga terjangkau</span>
                <span class="px-3 py-1 rounded-full bg-white/10 border border-white/15 text-xs">Data realtime</span>
            </div> --}}

        </div>
    </div>
</section>
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
