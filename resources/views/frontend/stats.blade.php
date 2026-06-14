<section id="statistik-hero" class="relative z-10 mt-16">
    @php
        $availableRooms = $availableRooms ?? 0;
        $totalRooms = $totalRooms ?? 0;
        $availableByBuilding = $availableByBuilding ?? [];
    @endphp

    <div class="max-w-7xl mx-auto px-4">

        {{-- HEADER --}}
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-black text-[#000352]">
                Statistik Ketersediaan Kamar
            </h2>
            <p class="text-slate-600 mt-2 text-sm md:text-base">
                Informasi jumlah kamar yang tersedia dan distribusinya di setiap gedung Rusunawa UNDIP.
            </p>

            <div class="mt-4 flex justify-center">
                <div class="h-1 w-20 bg-[#000352] rounded-full"></div>
            </div>
        </div>

        {{-- CARD --}}
        <div class="rounded-3xl p-6 md:p-10 text-white shadow-xl relative overflow-hidden bg-[#000352]">

            {{-- Glow --}}
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>

            {{-- STATS --}}
            <div class="flex flex-wrap md:flex-nowrap items-center gap-6 text-center">

                {{-- AVAILABLE --}}
                <div class="flex-1">
                    <div class="text-sm uppercase tracking-wider text-white/70">
                        Kamar Tersedia
                    </div>
                    <div class="font-black text-4xl md:text-5xl mt-2 counter" data-target="{{ $availableRooms }}">
                        0
                    </div>
                </div>

                <div class="hidden md:block w-px h-16 bg-white/20"></div>

                {{-- TOTAL --}}
                <div class="flex-1">
                    <div class="text-sm uppercase tracking-wider text-white/70">
                        Total Kamar
                    </div>
                    <div class="font-black text-4xl md:text-5xl mt-2 counter" data-target="{{ $totalRooms }}">
                        0
                    </div>
                </div>

            </div>

            {{-- BREAKDOWN --}}
            <div class="mt-10">
                <div class="text-sm uppercase tracking-wider text-white font-semibold mb-4 text-center">
                    Distribusi Kamar per Gedung
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
                    @forelse ($availableByBuilding as $building)
                        <div class="rounded-2xl border border-white/20 px-4 py-4 text-center hover:bg-white/10 transition">
                            <div class="text-xs text-white/80 font-semibold">
                                {{ $building['name'] ?? 'Gedung ' . ($building['code'] ?? '-') }}
                            </div>

                            <div class="text-2xl font-black mt-1 counter"
                                 data-target="{{ (int) ($building['total'] ?? 0) }}">
                                0
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center text-white/70 text-sm">
                            Belum ada data gedung.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</section>

{{-- SCRIPT ANIMASI --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const counters = document.querySelectorAll(".counter");
        const section = document.getElementById("statistik-hero");

        function animateCounter(el) {
            const target = +el.getAttribute("data-target");
            let count = 0;

            if (target === 0) {
                el.innerText = "0";
                return;
            }

            const speed = 200;
            const increment = target / speed;

            function update() {
                count += increment;

                if (count < target) {
                    el.innerText = Math.floor(count);
                    requestAnimationFrame(update);
                } else {
                    el.innerText = target.toLocaleString();
                }
            }

            update();
        }

        function resetCounters() {
            counters.forEach(el => {
                el.innerText = "0";
            });
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {

                if (entry.isIntersecting) {
                    counters.forEach(el => animateCounter(el));
                } else {
                    resetCounters();
                }

            });
        }, {
            threshold: 0.4
        });

        if (section) {
            observer.observe(section);
        }

    });
</script>